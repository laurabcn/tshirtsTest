<?php

declare(strict_types=1);

namespace App\Shopery\Domain\Variant;

use App\Shopery\Domain\Shared\ValueObject\Id;
use App\Shopery\Domain\Variant\Exceptions\SizeNotExistException;


class Size
{
    /** @var Id */
    private $id;

    /** @var string */
    private $name;

    public function __construct(Id $id, string $name)
    {
        if(!in_array($name, SizeEnums::SIZE_VALID, true)){
            throw new SizeNotExistException('This size $size not found');
        }

        $this->id = $id;
        $this->name = $name;
    }

    public function id(): Id
    {
        return $this->id();
    }

    public function name(): string
    {
        return $this->name->value();
    }
}