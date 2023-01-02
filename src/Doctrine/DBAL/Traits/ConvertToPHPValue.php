<?php declare(strict_types = 1);

namespace PhpSimple\Doctrine\DBAL\Traits;

use DateTimeInterface;
use DateTimeZone;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;

trait ConvertToPHPValue
{
    /**
     * @throws ConversionException
     */
    private function convertToPHPValueForType($value, AbstractPlatform $platform, string $type, DateTimeInterface $object, string $function): ?DateTimeInterface
    {
        if (null === $value || $value instanceof $object) {
            return $value;
        }

        $timezone = new DateTimeZone(timezone: 'UTC');
        $converted = $object::createFromFormat(format: $platform->getDateTimeFormatString(), datetime: $value, timezone: $timezone);

        if (false === $converted) {
            $converted = $function(datetime: $value, timezone: $timezone);
        }

        if (false === $converted) {
            throw ConversionException::conversionFailedFormat(value: $value, toType: $type, expectedFormat: $platform->getDateTimeFormatString());
        }

        return $converted;
    }
}
