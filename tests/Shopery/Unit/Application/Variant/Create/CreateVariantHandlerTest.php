<?php

declare(strict_types=1);

namespace App\Test\Shopery\Unit\Application\Variant\Create;

use App\Shopery\Application\Variant\Create\CreateVariantCommand;
use App\Shopery\Application\Variant\Create\CreateVariantHandler;
use App\Shopery\Domain\Shared\ValueObject\Id;
use App\Shopery\Domain\Variant\Repository\VariantRepository;
use App\Shopery\Domain\Variant\Size;
use App\Shopery\Domain\Variant\SizeEnums;
use App\Shopery\Domain\Variant\Variant;
use App\Tests\Shopery\Unit\Core\UnitTestCase;
use Money\Money;
use PHPUnit\Framework\MockObject\MockObject;

class CreateVariantHandlerTest extends UnitTestCase
{

    /** @var VariantRepository | MockObject */
    private $variantRepository;
    /** @var CreateVariantHandler */
    private $sut;

    protected function setUp(): void
    {
        parent::setUp();

        $this->variantRepository = $this->createMock(VariantRepository::class);
        $this->sut = new CreateVariantHandler($this->variantRepository);
    }

    /**
     * @test
     * @throws \App\Shopery\Domain\Variant\Exceptions\SizeNotExistException
     */
    public function handle()
    {
        $command = new CreateVariantCommand(
            $variantId = new Id($this->faker->uuid),
            $productId = new Id($this->faker->uuid),
            $size = new Size( new Id($this->faker->uuid), SizeEnums::SIZE_S),
            Money::EUR(500),
            Money::EUR(375)
        );

        $variant = new Variant(
            $command->id(),
            $command->productId(),
            $command->size(),
            $command->price(),
            $command->offer()
        );

        $this->variantRepository
            ->expects($this->once())
            ->method('save')
            ->with($variant);

        $this->sut->handle($command);

    }
}
