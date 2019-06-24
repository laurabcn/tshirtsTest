<?php

declare(strict_types = 1);

namespace App\Shopery\Infrastructure\Persistence\Repository;

use App\Shopery\Domain\Product\Exceptions\VariantNotFoundException;
use App\Shopery\Domain\Product\Product;
use App\Shopery\Domain\Product\Repository\ProductRepository;
use App\Shopery\Domain\Shared\ValueObject\Id;

final class InMemoryProductRepository  implements ProductRepository
{
    /** @var Product[] */
    protected $loadedData;


    public function save(Product $product): void
    {
        $this->loadedData[$product->id()->id()] = $product;
    }

    public function byId(Id $id): ?Product
    {
        if (!isset($this->loadedData[$id->id()])) {
            throw new VariantNotFoundException(sprintf('Product with id: %s not found', $id->id()));
        }

        return $this->loadedData[$id->id()];
    }

    public function all(): array
    {
        return $this->loadedData;
    }
}