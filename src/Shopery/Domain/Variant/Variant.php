<?php

declare(strict_types=1);

namespace App\Shopery\Domain\Variant;

use App\Shopery\Domain\Shared\Aggregate\AggregateRoot;
use App\Shopery\Domain\Shared\ValueObject\Id;
use DateTime;
use Money\Money;

class Variant extends AggregateRoot
{
    /** @var Id */
    private $id;

    /** @var Id */
    private $productId;

    /** @var Size */
    private $size;

    /** @var Money */
    private $price;

    /** @var Money | null */
    private $offer;

    /** @var DateTime | null */
    private $removedAt;

    public function __construct(Id $id, Id $productId, Size $size, Money $price, ?Money $offer = null)
    {
        $this->id = $id;
        $this->productId = $productId;
        $this->size = $size;
        $this->price = $price;
        $this->offer = $offer;
    }

    public function id(): Id
    {
        return $this->id();
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

    public function officialPrice(): Money
    {
        if(!is_null($this->offer))
        {
            return $this->offer();
        }

        return $this->price();
    }

    public function setPrice(Money $price): void
    {
       $this->price = $price;
    }

    public function setOffer(Money $offer): void
    {
        $this->offer = $offer;
    }

    public function remove(): void
    {
        $this->removedAt = new DateTime();
    }

}