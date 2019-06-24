<?php

declare(strict_types=1);

namespace App\Shopery\Application\Product\Update\UpdateName;

use App\Shopery\Domain\Product\Repository\ProductRepository;
use App\Shopery\Domain\Shared\Command\CommandHandler;

final class UpdateNameProductHandler implements CommandHandler
{
    /** @var ProductRepository */
    private $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function handle(UpdateNameProductCommand $command): void
    {
        $product = $this->productRepository->byId($command->id());

        $product->setName($command->name());

        $this->productRepository->save($product);
    }
}



