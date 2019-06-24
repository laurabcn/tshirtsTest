<?php

declare(strict_types=1);

namespace App\Test\Shopery\Unit\Application\Variant\Update\UpdatePricesVariant;

use App\Shopery\Application\Variant\Update\UpdatePricesVariant\UpdatePricesVariantCommand;
use App\Shopery\Application\Variant\Update\UpdatePricesVariant\UpdatePricesVariantHandler;
use App\Shopery\Domain\Shared\ValueObject\Id;
use App\Shopery\Domain\Variant\Repository\VariantRepository;
use App\Shopery\Domain\Variant\Size;
use App\Shopery\Domain\Variant\SizeEnums;
use App\Shopery\Domain\Variant\Variant;
use App\Tests\Shopery\Unit\Core\UnitTestCase;
use Money\Money;
use PHPUnit\Framework\MockObject\MockObject;

class UpdatePricesVariantHandlerTest extends UnitTestCase
{

    /** @var VariantRepository | MockObject */
    private $variantRepository;
    /** @var UpdatePricesVariantHandler */
    private $sut;

    protected function setUp(): void
    {
        parent::setUp();

        $this->variantRepository = $this->createMock(VariantRepository::class);
        $this->sut = new UpdatePricesVariantHandler($this->variantRepository);
    }

    /**
     * @test
     * @throws \App\Shopery\Domain\Variant\Exceptions\SizeNotExistException
     */
    public function handle()
    {
        $variant = new Variant(
            $variantId = new Id($this->faker->uuid),
            $productId = new Id($this->faker->uuid),
            new Size(new Id($this->faker->uuid), SizeEnums::SIZE_M),
            Money::EUR(600),
            Money::EUR(475)
        );

        $command = new UpdatePricesVariantCommand(
            $variantId,
            Money::EUR(500),
            Money::EUR(375)
        );

        $this->variantRepository
            ->expects($this->once())
            ->method('byId')
            ->with($command->id())
            ->willReturn($variant);

        $variant->setOffer($command->offer());
        $variant->setPrice($command->price());

        $this->variantRepository
            ->expects($this->once())
            ->method('save')
            ->with($variant);

        $this->sut->handle($command);

    }
}
