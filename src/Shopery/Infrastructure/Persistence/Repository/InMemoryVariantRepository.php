<?php

declare(strict_types = 1);

namespace App\Shopery\Infrastructure\Persistence\Repository;

use App\Shopery\Domain\Shared\ValueObject\Id;
use App\Shopery\Domain\Variant\Exceptions\VariantNotFoundException;
use App\Shopery\Domain\Variant\Repository\VariantRepository;
use App\Shopery\Domain\Variant\Variant;

final class InMemoryVariantRepository  implements VariantRepository
{
    /** @var Variant[] */
    protected $loadedData;


    public function save(Variant $variant): void
    {
        $this->loadedData[$variant->id()->id()] = $variant;
    }

    /**
     * @param Id $id
     * @return Variant|null
     * @throws VariantNotFoundException
     */
    public function byId(Id $id): ?Variant
    {
        if (!isset($this->loadedData[$id->id()])) {
            throw new VariantNotFoundException(sprintf('Variant with id: %s not found', $id->id()));
        }

        return $this->loadedData[$id->id()];
    }


    /**
     * @param Id $productId
     * @return array
     * @throws VariantNotFoundException
     */
    public function byProductId(Id $productId): array
    {
        $response = [];

        foreach ($this->loadedData as $variant)
        {
            if($variant->productId()->id() === $productId->id()){
                $response[] = $variant;
            }
        }

        if (!isset($response)) {
            throw new VariantNotFoundException(sprintf('Variant with this product id: %s not  found', $productId->id()));
        }

        return $response;
    }

    public function all(): array
    {
        return $this->loadedData;
    }
}