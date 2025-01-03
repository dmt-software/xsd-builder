<?php

namespace DMT\XsdBuilder;

use DMT\XsdBuilder\Builders\Builder;
use DMT\XsdBuilder\Builders\VenetianBlind;
use DMT\XsdBuilder\Elements\ComplexType;
use DMT\XsdBuilder\Elements\ParentNode;
use DMT\XsdBuilder\Elements\ParentType;
use DMT\XsdBuilder\Elements\Schema;
use DMT\XsdBuilder\Elements\Type;
use DMT\XsdBuilder\Restrictions\Restriction;
use DMT\XsdBuilder\Types\ListType;
use DOMDocument;
use InvalidArgumentException;

class XsdBuilder
{
    private Schema $schema;
    private ParentNode|ParentType|null $current = null;

    public function __construct(
        private readonly Builder $builder = new VenetianBlind(),
        private readonly ListType $listType = ListType::Sequence,
        private DOMDocument $document = new DOMDocument(),
    ) {
        $this->schema = $this->current = new Schema($this->document);
    }

    /**
     * Add simple type to schema or current element.
     *
     * @param string $name The name of the simple type.
     * @param mixed $type The type of the simple type.
     * @param Restriction|null $restriction The restriction of the simple type [optional].
     *
     * @throws InvalidArgumentException
     */
    public function addSimpleType(string $name, mixed $type, Restriction|null $restriction = null): void
    {
        $this->current = $this->builder->addSimpleType($this->current, $name, $type, $restriction);
    }

    /**
     * Add complex type to schema or current element.
     *
     * @param string $name The name of the complex type.
     * @param ListType|null $type The container type of the complex type [sequence|all].
     *
     * @throws InvalidArgumentException
     */
    public function addComplexType(string $name, ListType $type = null): void
    {
        $this->current = $this->builder->addComplexType($this->current, $name, $type ?? $this->listType);
    }

    /**
     * Add element to schema or current node.
     *
     * @param string $name The name of the element.
     * @param Type|string $type The type of the element.
     * @param array<string, mixed> $attributes Extra attributes for the element (minOccurs, maxOccurs, default).
     *
     * @throws InvalidArgumentException
     */
    public function addElement(string $name, Type|string $type, array $attributes = []): void
    {
        $this->current = $this->builder->addElement($this->current, $name, $type, $attributes);
    }

    /**
     * Add attribute to schema or current node.
     *
     * @param string $name The name of the attribute.
     * @param Type|string $type The type of the attribute.
     * @param array<string, mixed> $attributes Extra attributes for the attribute (use, default).
     *
     * @throws InvalidArgumentException
     */
    public function addAttribute(string $name, Type|string $type, array $attributes = []): void
    {
        $this->current = $this->builder->addAttribute($this->current, $name, $type, $attributes);
    }

    public function build(): DOMDocument
    {
        return $this->schema->renderSchema();
    }
}
