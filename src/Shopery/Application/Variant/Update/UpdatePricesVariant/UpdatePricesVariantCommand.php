<?php

declare(strict_types=1);

namespace App\Shopery\Application\Variant\Update\UpdatePricesVariant;

use App\Shopery\Domain\Shared\Command\Command;
use App\Shopery\Domain\Shared\ValueObject\Id;
use Money\Money;

final class UpdatePricesVariantCommand implements Command
{
    /** @var Id  */
    private $id;

    /** @var Money */
    private $price;

    /** @var Money | null*/
    private $offer;

    public function __construct(
        Id $id,
        Money $price,
        ?Money $offer = null
    ) {
        $this->id = $id;
        $this->price = $price;
        $this->offer = $offer;
    }

    public function id(): Id
    {
        return $this->id;
    }

    public function price(): Money
    {
        return $this->price;
    }

    public function offer(): Money
    {
        return $this->offer;
    }
}