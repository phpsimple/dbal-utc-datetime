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

        $dateTime = $object::createFromFormat(
            format: $platform->getDateTimeFormatString(),
            datetime: $value,
            timezone: UTCDateTimeImmutable::getUTCTimeZone(),
        ) ?: $function(datetime: $value, timezone: UTCDateTimeImmutable::getUTCTimeZone());

        if (false === $dateTime) {
            throw ConversionException::conversionFailedFormat(value: $value, toType: $object::class, expectedFormat: $platform->getDateTimeFormatString());
        }

        return $dateTime;
    }
}
