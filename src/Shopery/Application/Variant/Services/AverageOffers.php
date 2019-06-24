<?php

declare(strict_types=1);

namespace App\Shopery\Application\Variant\Services;

use App\Shopery\Domain\Shared\ValueObject\Id;
use App\Shopery\Domain\Variant\Repository\VariantRepository;
use App\Shopery\Domain\Variant\Variant;

class AverageOffers
{
    /**
     * @var VariantRepository
     */
    private $variantRepository;

    public function __construct(VariantRepository $variantRepository)
    {
        $this->variantRepository = $variantRepository;
    }

    public function getAverageOffers(Id $productId): float
    {
        /** @var Variant[] $variants */
        $variants = $this->variantRepository->byProductId($productId);

        $average = 0;
        $count = 0;

        foreach ($variants as $variant)
        {
            if(!is_null($variant->offer()))
            {
                $average = $average + (int) $variant->offer()->getAmount();
                $count++;
            }

        }

        return $average / $count;
    }
}
