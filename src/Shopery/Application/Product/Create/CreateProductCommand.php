<?php

declare(strict_types=1);

namespace App\Shopery\Application\Product\Create;

use App\Shopery\Domain\Shared\Command\Command;
use App\Shopery\Domain\Shared\ValueObject\Id;

final class CreateProductCommand implements Command
{
    /** @var Id  */
    private $id;

    /** @var string */
    private $name;

    public function __construct(
        Id $id,
        string $name
    ) {
        $this->id = $id;
        $this->name = $name;
    }

    public function id(): Id
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }
}