<?php

declare(strict_types=1);

namespace App\Test\Shopery\Unit\Application\Product\Update\UpdateName;

use App\Shopery\Application\Product\Create\CreateProductCommand;
use App\Shopery\Application\Product\Update\UpdateName\UpdateNameProductCommand;
use App\Shopery\Application\Product\Update\UpdateName\UpdateNameProductHandler;
use App\Shopery\Domain\Product\Product;
use App\Shopery\Domain\Product\Repository\ProductRepository;
use App\Shopery\Domain\Shared\ValueObject\Id;
use App\Tests\Shopery\Unit\Core\UnitTestCase;
use PHPUnit\Framework\MockObject\MockObject;

class UpdateNameProductHandlerTest extends UnitTestCase
{

    /** @var ProductRepository | MockObject */
    private $productRepository;
    /** @var UpdateNameProductHandler */
    private $sut;

    protected function setUp(): void
    {
        parent::setUp();

        $this->productRepository = $this->createMock(ProductRepository::class);
        $this->sut = new UpdateNameProductHandler($this->productRepository);
    }

    /**
     * @test
     */
    public function handle()
    {

        $product = new Product(
            $productId = new Id($this->faker->uuid),
            $name = $this->faker->text(5)
        );

        $command = new UpdateNameProductCommand(
            $productId,
            $newName = $this->faker->text(6)
        );

        $this->productRepository
            ->expects($this->once())
            ->method('byId')
            ->with($command->id())
            ->willReturn($product);

        $product->setName($newName);

        $this->productRepository
            ->expects($this->once())
            ->method('save')
            ->with($product);

        $this->sut->handle($command);

    }
}
