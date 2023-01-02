<?php declare(strict_types = 1);

namespace PhpSimple\Doctrine\DBAL;

use DateTime;
use DateTimeInterface;
use DateTimeZone;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\DateTimeType;
use Doctrine\DBAL\Types\Types;

use function date_create;

class UTCDateTimeType extends DateTimeType
{
    use Traits\ConvertToDatabaseValue;

    public function convertToPHPValue($value, AbstractPlatform $platform): ?DateTimeInterface
    {
        if (null === $value || $value instanceof DateTime) {
            return $value;
        }

        $tz = new DateTimeZone(timezone: 'UTC');
        $converted = DateTime::createFromFormat(format: $platform->getDateTimeFormatString(), datetime: $value, timezone: $tz);

        if (false === $converted) {
            $converted = date_create(datetime: $value, timezone: $tz);
        }

        if (false === $converted) {
            throw ConversionException::conversionFailedFormat(value: $value, toType: Types::DATETIME_MUTABLE, expectedFormat: $platform->getDateTimeFormatString());
        }

        return $converted;
    }
}
