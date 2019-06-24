<?php

declare(strict_types=1);

namespace App\Shopery\Domain\Product\Repository;

use App\Shopery\Domain\Product\Product;
use App\Shopery\Domain\Shared\ValueObject\Id;

interface ProductRepository
{
    public function byId(Id $id): ?Product;

    public function all(): array;

    public function save(Product $product): void;
}
