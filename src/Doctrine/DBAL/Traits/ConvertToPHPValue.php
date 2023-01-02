<?php declare(strict_types = 1);

namespace PhpSimple\Doctrine\DBAL\Traits;

use DateTime;
use DateTimeImmutable;
use DateTimeZone;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\Types;
use InvalidArgumentException;

trait ConvertToPHPValue
{
    /**
     * @throws ConversionException
     */
    private function convertToPHPValueForType($value, AbstractPlatform $platform, string $type): ?DateTimeImmutable
    {
        switch ($type) {
            case Types::DATETIME_IMMUTABLE:
                $class = new DateTimeImmutable();
                $function = 'date_create_immutable';
                break;
            case Types::DATETIME_MUTABLE:
                $class = new DateTime();
                $function = 'date_create';
                break;
            default:
                throw new InvalidArgumentException(message: 'Invalid value');
        }

        if (null === $value || $value instanceof $class) {
            return $value;
        }

        $timezone = new DateTimeZone(timezone: 'UTC');
        $converted = $class::createFromFormat(format: $platform->getDateTimeFormatString(), datetime: $value, timezone: $timezone);

        if (false === $converted) {
            $converted = $function(datetime: $value, timezone: $timezone);
        }

        if (false === $converted) {
            throw ConversionException::conversionFailedFormat(value: $value, toType: $type, expectedFormat: $platform->getDateTimeFormatString());
        }

        return $converted;
    }
}
