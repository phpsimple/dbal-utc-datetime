<?php declare(strict_types = 1);

namespace PhpSimple\Doctrine\DBAL;

use DateTimeInterface;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\DateTimeType;
use Doctrine\DBAL\Types\Types;

class UTCDateTimeType extends DateTimeType
{
    use Traits\ConvertToDatabaseValue;
    use Traits\ConvertToPHPValue;

    public function convertToPHPValue($value, AbstractPlatform $platform): ?DateTimeInterface
    {
        return $this->convertToPHPValueForType(value: $value, platform: $platform, type: Types::DATETIME_MUTABLE);
    }
}
