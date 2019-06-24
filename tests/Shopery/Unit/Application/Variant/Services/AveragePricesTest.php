<?php

declare(strict_types=1);

namespace App\Test\Shopery\Unit\Application\Variant\Services;

use App\Shopery\Application\Variant\Services\AveragePrices;
use App\Shopery\Domain\Shared\ValueObject\Id;
use App\Shopery\Domain\Variant\Repository\VariantRepository;
use App\Shopery\Domain\Variant\Variant;
use App\Tests\Shopery\Unit\Core\UnitTestCase;
use Money\Money;
use PHPUnit\Framework\MockObject\MockObject;

class AveragePricesTest extends UnitTestCase
{

    /** @var VariantRepository | MockObject */
    private $variantRepository;
    /** @var AveragePrices */
    private $sut;

    /**
     * @return Variant|MockObject
     */
    public function getVariant()
    {
        return $this->createMock(Variant::class);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->variantRepository = $this->createMock(VariantRepository::class);
        $this->sut = new AveragePrices($this->variantRepository);
    }

    /**
     * @test
     * @throws \App\Shopery\Domain\Variant\Exceptions\SizeNotExistException
     */
    public function getAveragePrices()
    {
        $productId = new Id($this->faker->uuid);

        $variant1 = $this->getVariant();

        $variant1
            ->expects($this->any())
            ->method('price')
            ->willReturn($price = Money::EUR(2220));

        $variant2 = $this->getVariant();

        $variant2
            ->expects($this->any())
            ->method('price')
            ->willReturn($price1 = Money::EUR(300));

        $variant3 = $this->getVariant();

        $variant3
            ->expects($this->any())
            ->method('price')
            ->willReturn($price2 = Money::EUR(375));

        $this->variantRepository
            ->expects($this->once())
            ->method('byProductId')
            ->with($productId)
            ->willReturn(
                [$variant1, $variant2, $variant3]
            );


        $average = $this->sut->getAveragePrices($productId);

        $expected = ((int) $price->getAmount() + (int) $price1->getAmount() + (int) $price2->getAmount()) / 3;

        $this->assertEquals($expected, $average);
    }
}
