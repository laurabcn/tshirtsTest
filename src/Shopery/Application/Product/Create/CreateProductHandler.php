<?php

declare(strict_types=1);

namespace App\Shopery\Application\Product\Create;

use App\Shopery\Domain\Product\Product;
use App\Shopery\Domain\Product\Repository\ProductRepository;
use App\Shopery\Domain\Shared\Command\CommandHandler;

final class CreateProductHandler implements CommandHandler
{
    /** @var ProductRepository */
    private $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function handle(CreateProductCommand $command): void
    {
        $product = new Product(
            $command->id(),
            $command->name()
        );

        $this->productRepository->save($product);
    }
}



