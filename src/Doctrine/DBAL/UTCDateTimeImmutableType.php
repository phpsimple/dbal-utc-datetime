<?php declare(strict_types = 1);

namespace PhpSimple\Doctrine\DBAL;

use DateTimeImmutable;
use DateTimeZone;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\DateTimeImmutableType;
use Doctrine\DBAL\Types\Types;

use function date_create_immutable;

class UTCDateTimeImmutableType extends DateTimeImmutableType
{
    use Traits\ConvertToDatabaseValue;

    public function convertToPHPValue($value, AbstractPlatform $platform): ?DateTimeImmutable
    {
        if (null === $value || $value instanceof DateTimeImmutable) {
            return $value;
        }

        $tz = new DateTimeZone(timezone: 'UTC');
        $converted = DateTimeImmutable::createFromFormat(format: $platform->getDateTimeFormatString(), datetime: $value, timezone: $tz);

        if (false === $converted) {
            $converted = date_create_immutable(datetime: $value, timezone: $tz);
        }

        if (false === $converted) {
            throw ConversionException::conversionFailedFormat(value: $value, toType: Types::DATETIME_IMMUTABLE, expectedFormat: $platform->getDateTimeFormatString());
        }

        return $converted;
    }
}
