<?php

declare(strict_types=1);

namespace App\Test\Shopery\Unit\Application\Product\Create;

use App\Shopery\Application\Product\Create\CreateProductCommand;
use App\Shopery\Application\Product\Create\CreateProductHandler;
use App\Shopery\Domain\Product\Product;
use App\Shopery\Domain\Product\Repository\ProductRepository;
use App\Shopery\Domain\Shared\ValueObject\Id;
use App\Tests\Shopery\Unit\Core\UnitTestCase;
use PHPUnit\Framework\MockObject\MockObject;

class CreateProductHandlerTest extends UnitTestCase
{

    /** @var ProductRepository | MockObject */
    private $productRepository;
    /** @var CreateProductHandler */
    private $sut;

    protected function setUp(): void
    {
        parent::setUp();

        $this->productRepository = $this->createMock(ProductRepository::class);
        $this->sut = new CreateProductHandler($this->productRepository);
    }

    /**
     * @test
     */
    public function handle()
    {
        $command = new CreateProductCommand(
            $productId = new Id($this->faker->uuid),
            $name = $this->faker->text(6)
        );

        $product = new Product($productId, $name);

        $this->productRepository
            ->expects($this->once())
            ->method('save')
            ->with($product);

        $this->sut->handle($command);

    }
}
