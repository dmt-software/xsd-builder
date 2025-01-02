<?php

declare(strict_types=1);

namespace DMT\XsdBuilder\Factories;

use DMT\XsdBuilder\Elements\Node;
use DMT\XsdBuilder\Elements\Type;
use DMT\XsdBuilder\Types\SchemaType;
use InvalidArgumentException;

interface Factory
{
    /**
     * Create the factory.
     *
     * @throws InvalidArgumentException
     */
    public static function create(string $name, mixed $type, SchemaType $schemaType = null): Factory;

    /**
     * Create node.
     *
     * @throws InvalidArgumentException
     */
    public function build(): Type|Node;
}
