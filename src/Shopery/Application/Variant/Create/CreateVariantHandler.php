<?php

declare(strict_types=1);

namespace App\Shopery\Application\Variant\Create;

use App\Shopery\Domain\Shared\Command\CommandHandler;
use App\Shopery\Domain\Variant\Repository\VariantRepository;
use App\Shopery\Domain\Variant\Variant;

final class CreateVariantHandler implements CommandHandler
{
    /** @var VariantRepository */
    private $variantRepository;

    public function __construct(VariantRepository $variantRepository)
    {
        $this->variantRepository = $variantRepository;
    }

    public function handle(CreateVariantCommand $command)
    {
        $variant = new Variant(
            $command->id(),
            $command->productId(),
            $command->size(),
            $command->price(),
            $command->offer()
        );

        $this->variantRepository->save($variant);
    }
}



