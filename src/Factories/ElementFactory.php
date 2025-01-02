<?php

declare(strict_types=1);

namespace DMT\XsdBuilder\Factories;

use DMT\XsdBuilder\Elements\ElementNode;
use DMT\XsdBuilder\Elements\Type;
use DMT\XsdBuilder\Types\DataType;
use DMT\XsdBuilder\Types\SchemaType;
use InvalidArgumentException;
use TypeError;
use ValueError;

class ElementFactory implements Factory
{
    public function __construct(
        private readonly string        $name,
        private readonly Type|DataType $type,
        private readonly SchemaType    $schemaType = SchemaType::VenetianBlind,
        private string|null            $minOccurs = null,
        private string|null            $maxOccurs = null,
        private mixed                  $default = null
    ) {
    }

    /**
     * @inheritDoc
     */
    public static function create(string $name, mixed $type, SchemaType $schemaType = null): self
    {
        try {
            return new self(
                $name,
                is_string($type) ? DataType::from($type) : $type,
                $schemaType ?? SchemaType::VenetianBlind
            );
        } catch (TypeError|ValueError) {
            throw new InvalidArgumentException('Unknown type for element');
        }
    }

    public function setMinOccurs(int $minOccurs): self
    {
        $this->minOccurs = (string)$minOccurs;

        return $this;
    }

    public function setMaxOccurs(int|string $maxOccurs): self
    {
        if (!preg_match('~^(\d+|unbounded)$~', (string)$maxOccurs)) {
            throw new InvalidArgumentException('Value of maxOccurs must be an integer or "unbounded"');
        }

        $this->maxOccurs = (string)$maxOccurs;

        return $this;
    }

    public function setDefault(mixed $default): self
    {
        if (!is_scalar($default)) {
            throw new InvalidArgumentException('Default value must be a boolean, integer, float or string');
        }

        if (is_bool($default)) {
            $default = $default ? 'true' : 'false';
        }

        $this->default = (string)$default;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function build(): ElementNode
    {
        if ($this->type instanceof Type) {
            $type = match ($this->schemaType) {
                SchemaType::VenetianBlind => $this->type->getNodeName(),
                SchemaType::RussianDoll, SchemaType::SalamiSlice => null,
            };
        }

        return new ElementNode(
            $this->name,
            $type ?? $this->type,
            $this->minOccurs,
            $this->maxOccurs,
            $this->default
        );
    }
}
