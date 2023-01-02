<?php declare(strict_types = 1);

namespace PhpSimple\Doctrine\DBAL;

use DateTimeImmutable;
use DateTimeInterface;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\DateTimeImmutableType;
use Doctrine\DBAL\Types\Types;

class UTCDateTimeImmutableType extends DateTimeImmutableType
{
    use Traits\ConvertToDatabaseValue;
    use Traits\ConvertToPHPValue;

    public function convertToPHPValue($value, AbstractPlatform $platform): ?DateTimeInterface
    {
        return $this->convertToPHPValueForType(value: $value, platform: $platform, type: Types::DATETIME_IMMUTABLE, object: new DateTimeImmutable(), function: 'date_create_immutable');
    }
}
