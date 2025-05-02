<?php

namespace DMT\XsdBuilder\Attributes;

use DMT\XsdBuilder\Types\DataType;

abstract class Node
{
    public null|string $default = null;

    /**
     * @template T
     * @param null|string|class-string<T>|DataType $type
     */
    public function __construct(
        public null|string $name = null,
        public null|string|DataType $type = null,
        bool|float|int|string $default = null
    ) {
        $this->default = match (gettype($default)) {
            'integer', 'string' => strval($default),
            'boolean' => $default ? 'true' : 'false',
            "double" => ($default > 1e10 || $default < 1e-10)
                ? preg_replace('~(?<=E)\+~', '', sprintf('%E', strval($default)))
                : strval($default),
            default => null,
        };
    }
}