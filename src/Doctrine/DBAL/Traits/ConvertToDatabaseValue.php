<?php declare(strict_types = 1);

namespace PhpSimple\Doctrine\DBAL\Traits;

use DateTimeInterface;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use PhpSimple\UTCDateTimeImmutable;

trait ConvertToDatabaseValue
{
    public function convertToDatabaseValue($value, AbstractPlatform $platform): mixed
    {
        if ($value instanceof DateTimeInterface) {
            $value = $value->setTimezone(timezone: UTCDateTimeImmutable::getUTCTimeZone());
        }

        return parent::convertToDatabaseValue(value: $value, platform: $platform);
    }
}
