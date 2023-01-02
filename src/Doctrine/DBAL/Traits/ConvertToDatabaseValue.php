<?php declare(strict_types = 1);

namespace PhpSimple\Doctrine\DBAL\Traits;

use DateTimeInterface;
use DateTimeZone;
use Doctrine\DBAL\Platforms\AbstractPlatform;

trait ConvertToDatabaseValue
{
    public function convertToDatabaseValue($value, AbstractPlatform $platform): mixed
    {
        if ($value instanceof DateTimeInterface) {
            $value = $value->setTimezone(new DateTimeZone(timezone: 'UTC'));
        }

        return parent::convertToDatabaseValue(value: $value, platform: $platform);
    }
}
