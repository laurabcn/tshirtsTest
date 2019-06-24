<?php

declare(strict_types=1);

namespace App\Shopery\Application\Variant\Update\UpdatePricesVariant;

use App\Shopery\Domain\Shared\Command\CommandHandler;
use App\Shopery\Domain\Variant\Repository\VariantRepository;

final class UpdatePricesVariantHandler implements CommandHandler
{
    /** @var VariantRepository */
    private $variantRepository;

    public function __construct(VariantRepository $variantRepository)
    {
        $this->variantRepository = $variantRepository;
    }

    public function handle(UpdatePricesVariantCommand $command): void
    {
        $variant = $this->variantRepository->byId($command->id());

        $variant->setOffer($command->offer());
        $variant->setPrice($command->price());

        $this->variantRepository->save($variant);
    }
}



