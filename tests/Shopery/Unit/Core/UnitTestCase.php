<?php

namespace App\Tests\Shopery\Unit\Core;

use Faker\Factory;
use Faker\Generator;
use PHPUnit\Framework\TestCase;

class UnitTestCase extends TestCase
{
    /**
     * @var Generator
     */
    protected $faker;

    protected function setUp(): void
    {
        parent::setUp();
        $this->faker = Factory::create();
    }
}
