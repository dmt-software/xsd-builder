<?php

declare(strict_types=1);

namespace DMT\XsdBuilder\Factories;

use DMT\XsdBuilder\Elements\Node;
use DMT\XsdBuilder\Elements\SimpleType;
use DMT\XsdBuilder\Elements\Type;
use DMT\XsdBuilder\Restrictions\Restriction;
use DMT\XsdBuilder\Types\DataType;
use DMT\XsdBuilder\Types\SchemaType;
use InvalidArgumentException;
use ValueError;

class SimpleTypeFactory implements Factory
{
    public function __construct(
        private readonly string|null $name = null,
        private readonly DataType $type = DataType::String,
        private readonly SchemaType $schemaType = SchemaType::VenetianBlind,
        private Restriction|null $restriction = null
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
        } catch (ValueError) {
            throw new InvalidArgumentException('Invalid type for simpleType');
        }
    }

    public function setRestriction(Restriction $restriction): self
    {
        $this->restriction = $restriction;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function build(): Type|Node
    {
        $name = match ($this->schemaType) {
            SchemaType::VenetianBlind => $this->name,
            SchemaType::RussianDoll, SchemaType::SalamiSlice => null,
        };

        return new SimpleType($name, $this->type, $this->restriction);
    }
}
