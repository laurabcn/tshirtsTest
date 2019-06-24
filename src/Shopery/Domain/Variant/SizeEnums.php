<?php

declare(strict_types=1);

namespace App\Shopery\Domain\Variant;

class SizeEnums
{
    const SIZE_S = 'S';
    const SIZE_L = 'L';
    const SIZE_M = 'M';

    const SIZE_VALID = [
        self::SIZE_L,
        self::SIZE_M,
        self::SIZE_S
    ];
}