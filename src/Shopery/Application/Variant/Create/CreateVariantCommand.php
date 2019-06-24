<?php

declare(strict_types=1);

namespace App\Shopery\Application\Variant\Create;

use App\Shopery\Domain\Shared\Command\Command;
use App\Shopery\Domain\Shared\ValueObject\Id;
use App\Shopery\Domain\Variant\Size;
use Money\Money;

final class CreateVariantCommand implements Command
{
    /** @var Id  */
    private $id;

    /** @var Id  */
    private $productId;

    /** @var Size */
    private $size;

    /** @var Money */
    private $price;

    /** @var Money | null */
    private $offer;

    public function __construct(Id $id, Id $productId, Size $size, Money $price, ?Money $offer)
    {
        $this->id = $id;
        $this->productId = $productId;
        $this->size = $size;
        $this->price = $price;
        $this->offer = $offer;
    }

    public function id(): Id
    {
        return $this->id;
    }

    public function productId(): Id
    {
        return $this->productId;
    }

    public function size(): Size
    {
        return $this->size;
    }

    public function price(): Money
    {
        return $this->price;
    }

    public function offer(): ?Money
    {
        return $this->offer;
    }
}