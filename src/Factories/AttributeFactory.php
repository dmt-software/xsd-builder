<?php

declare(strict_types=1);

namespace DMT\XsdBuilder\Factories;

use DMT\XsdBuilder\Elements\AttributeNode;
use DMT\XsdBuilder\Elements\SimpleType;
use DMT\XsdBuilder\Elements\Type;
use DMT\XsdBuilder\Types\DataType;
use DMT\XsdBuilder\Types\SchemaType;
use DMT\XsdBuilder\Types\UseType;
use InvalidArgumentException;
use TypeError;
use ValueError;

class AttributeFactory implements Factory
{
    public function __construct(
        private readonly string $name,
        private readonly DataType|SimpleType $type,
        private readonly SchemaType $schemaType = SchemaType::VenetianBlind,
        private string|null $default = null,
        private UseType|null $use = null
    ) {
    }

    public static function create(string $name, mixed $type, SchemaType $schemaType = null): self
    {
        try {
            return new self(
                $name,
                is_string($type) ? DataType::from($type) : $type,
                $schemaType ?? SchemaType::VenetianBlind
            );
        } catch (TypeError | ValueError) {
            throw new InvalidArgumentException('Invalid type for attribute');
        }
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

    public function setUse(UseType|string $use): self
    {
        try {
            if (!$use instanceof UseType) {
                $use = UseType::from($use);
            }
        } catch (ValueError) {
            throw new InvalidArgumentException('Invalid use type for attribute');
        }

        $this->use = $use;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function build(): AttributeNode
    {
        if ($this->type instanceof Type) {
            $type = match ($this->schemaType) {
                SchemaType::VenetianBlind => $this->type->getNodeName(),
                SchemaType::RussianDoll, SchemaType::SalamiSlice => $this->type,
            };
        }

        return new AttributeNode(
            $this->name,
            $type ?? $this->type,
            $this->default,
            $this->use
        );
    }
}
