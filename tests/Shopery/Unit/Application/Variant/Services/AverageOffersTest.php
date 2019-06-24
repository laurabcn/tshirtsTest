<?php

declare(strict_types=1);

namespace App\Test\Shopery\Unit\Application\Variant\Services;

use App\Shopery\Application\Variant\Services\AverageOffers;
use App\Shopery\Domain\Shared\ValueObject\Id;
use App\Shopery\Domain\Variant\Repository\VariantRepository;
use App\Shopery\Domain\Variant\Variant;
use App\Tests\Shopery\Unit\Core\UnitTestCase;
use Money\Money;
use PHPUnit\Framework\MockObject\MockObject;

class UpdatePricesVariantHandlerTest extends UnitTestCase
{

    /** @var VariantRepository | MockObject */
    private $variantRepository;
    /** @var AverageOffers */
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
        $this->sut = new AverageOffers($this->variantRepository);
    }

    /**
     * @test
     * @throws \App\Shopery\Domain\Variant\Exceptions\SizeNotExistException
     */
    public function getAverageOffersWhenAProductHasThreeVariantsAndOneHasOffer()
    {
        $productId = new Id($this->faker->uuid);

        $variant1 = $this->getVariant();

        $variant1
            ->expects($this->any())
            ->method('offer')
            ->willReturn($offer = Money::EUR(200));

        $variant2 = $this->getVariant();

        $variant2
            ->expects($this->any())
            ->method('offer')
            ->willReturn(null);

        $variant3 = $this->getVariant();

        $variant3
            ->expects($this->any())
            ->method('offer')
            ->willReturn(null);

        $this->variantRepository
            ->expects($this->once())
            ->method('byProductId')
            ->with($productId)
            ->willReturn(
                [$variant1, $variant2, $variant3]
            );


        $average = $this->sut->getAverageOffers($productId);

        $this->assertEquals((int) $offer->getAmount(), $average);

    }


    /**
     * @test
     * @throws \App\Shopery\Domain\Variant\Exceptions\SizeNotExistException
     */
    public function getAverageOffersWhenAProductHasThreeVariantsAndTwoHasOffer()
    {
        $productId = new Id($this->faker->uuid);

        $variant1 = $this->getVariant();

        $variant1
            ->expects($this->any())
            ->method('offer')
            ->willReturn($offer = Money::EUR(200));

        $variant2 = $this->getVariant();

        $variant2
            ->expects($this->any())
            ->method('offer')
            ->willReturn($offer1 = Money::EUR(200));

        $variant3 = $this->getVariant();

        $variant3
            ->expects($this->any())
            ->method('offer')
            ->willReturn(null);

        $this->variantRepository
            ->expects($this->once())
            ->method('byProductId')
            ->with($productId)
            ->willReturn(
                [$variant1, $variant2, $variant3]
            );


        $average = $this->sut->getAverageOffers($productId);

        $expected = ((int) $offer->getAmount() + (int) $offer1->getAmount()) / 2;

        $this->assertEquals($expected, $average);
    }

    /**
     * @test
     * @throws \App\Shopery\Domain\Variant\Exceptions\SizeNotExistException
     */
    public function getAverageOffersWhenAProductHasThreeVariantsAndThreeHasOffer()
    {
        $productId = new Id($this->faker->uuid);

        $variant1 = $this->getVariant();

        $variant1
            ->expects($this->any())
            ->method('offer')
            ->willReturn($offer = Money::EUR(200));

        $variant2 = $this->getVariant();

        $variant2
            ->expects($this->any())
            ->method('offer')
            ->willReturn($offer1 = Money::EUR(200));

        $variant3 = $this->getVariant();

        $variant3
            ->expects($this->any())
            ->method('offer')
            ->willReturn($offer2 = Money::EUR(375));

        $this->variantRepository
            ->expects($this->once())
            ->method('byProductId')
            ->with($productId)
            ->willReturn(
                [$variant1, $variant2, $variant3]
            );


        $average = $this->sut->getAverageOffers($productId);

        $expected = ((int) $offer->getAmount() + (int) $offer1->getAmount() + (int) $offer2->getAmount()) / 3;

        $this->assertEquals($expected, $average);
    }
}
