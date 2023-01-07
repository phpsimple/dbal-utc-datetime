<?php declare(strict_types = 1);

namespace PhpSimple\Doctrine\DBAL\Traits;

use DateTimeInterface;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use PhpSimple\UTCDateTimeImmutable;

trait ConvertToPHPValue
{
    /**
     * @throws ConversionException
     */
    private function convertToPHPValueForType($value, AbstractPlatform $platform, DateTimeInterface $object, string $function): ?DateTimeInterface
    {
        if (null === $value || $value instanceof $object) {
            return $value;
        }

        $converted = $object::createFromFormat(format: $platform->getDateTimeFormatString(), datetime: $value, timezone: UTCDateTimeImmutable::getUTCTimeZone());

        if (false === $converted) {
            $converted = $function(datetime: $value, timezone: UTCDateTimeImmutable::getUTCTimeZone());
        }

        if (false === $converted) {
            throw ConversionException::conversionFailedFormat(value: $value, toType: $object::class, expectedFormat: $platform->getDateTimeFormatString());
        }

        return $converted;
    }
}
