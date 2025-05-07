<?php

declare(strict_types=1);

namespace DMT\XsdBuilder\Factories;

use DMT\XsdBuilder\Elements\ComplexType;
use DMT\XsdBuilder\Elements\Node;
use DMT\XsdBuilder\Elements\Type;
use DMT\XsdBuilder\Types\ListType;
use DMT\XsdBuilder\Types\SchemaType;
use InvalidArgumentException;
use ValueError;

class ComplexTypeFactory implements Factory
{
    public function __construct(
        private readonly string $name,
        private readonly ListType $type = ListType::Sequence,
        private readonly SchemaType $schemaType = SchemaType::VenetianBlind,
    ) {
    }


    /**
     * @inheritDoc
     */
    public static function create(string $name, mixed $type, SchemaType $schemaType = null): self
    {
        try {
            if (is_string($type)) {
                $type = ListType::from($type);
            }

            return new self(
                $name,
                $type ?? ListType::Sequence,
                $schemaType ?? SchemaType::VenetianBlind
            );
        } catch (ValueError) {
            throw new InvalidArgumentException('Invalid list type for complexType');
        }
    }

    /**
     * @inheritDoc
     */
    public function build(): ComplexType
    {
        $name = match ($this->schemaType) {
            SchemaType::VenetianBlind => $this->name,
            SchemaType::RussianDoll, SchemaType::SalamiSlice => null,
        };

        return new ComplexType($name, $this->type);
    }
}
