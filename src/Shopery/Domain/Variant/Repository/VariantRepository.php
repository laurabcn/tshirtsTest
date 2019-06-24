<?php

declare(strict_types=1);

namespace App\Shopery\Domain\Variant\Repository;

use App\Shopery\Domain\Shared\ValueObject\Id;
use App\Shopery\Domain\Variant\Variant;


interface VariantRepository
{
    public function byId(Id $id): ?Variant;

    public function byProductId(Id $productId): array;

    public function all(): array;

    public function save(Variant $variant): void;
}
