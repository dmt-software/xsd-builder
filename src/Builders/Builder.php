<?php

declare(strict_types=1);

namespace DMT\XsdBuilder\Builders;

use DMT\XsdBuilder\Restrictions\Restriction;
use DOMDocument;
use DOMException;
use InvalidArgumentException;

interface Builder
{
    /**
     * Add an attribute to the complexType or schema.
     *
     * @throws InvalidArgumentException
     */
    public function addAttribute(string $name, mixed $type, array $attributes = []): void;

    /**
     * Add a complexType to the schema or element.
     *
     * @throws InvalidArgumentException
     */
    public function addComplexType(string $name, mixed $type = null): void;

    /**
     * Add an element to the complexType or schema.
     *
     * @throws InvalidArgumentException
     */
    public function addElement(string $name, mixed $type, array $attributes = []): void;

    /**
     * Add a simpleType to the schema or element.
     *
     * @throws InvalidArgumentException
     */
    public function addSimpleType(string $name, mixed $type, Restriction $restriction = null): void;

    /**
     * Render en build schema.
     *
     * @throws DOMException
     */
    public function build(): DOMDocument;
}
