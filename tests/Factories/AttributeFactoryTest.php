<?php

declare(strict_types=1);

namespace DMT\Test\XsdBuilder\Factories;

use DMT\XsdBuilder\Elements\SimpleType;
use DMT\XsdBuilder\Factories\AttributeFactory;
use DMT\XsdBuilder\Types\DataType;
use DMT\XsdBuilder\Types\SchemaType;
use DMT\XsdBuilder\Types\UseType;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class AttributeFactoryTest extends TestCase
{
    public function testCreateAttributeForInternalType(): void
    {
        $attribute = AttributeFactory::create('environment', 'string')
            ->setUse('required')
            ->setDefault('test')
            ->build();

        $node = $attribute->toNode();

        $this->assertSame('attribute', $node->localName);
        $this->assertSame('environment', $node->getAttribute('name'));
        $this->assertSame(DataType::String->type(), $node->getAttribute('type'));
        $this->assertSame('required', $node->getAttribute('use'));
        $this->assertSame('test', $node->getAttribute('default'));
    }

    public function testCreateAttributeForSimpleType(): void
    {
        $attribute = AttributeFactory::create('name', new SimpleType('nameType', DataType::String))
            ->setUse('optional')
            ->build();

        $node = $attribute->toNode();

        $this->assertSame('attribute', $node->localName);
        $this->assertSame('name', $node->getAttribute('name'));
        $this->assertSame('nameType', $node->getAttribute('type'));
        $this->assertSame('optional', $node->getAttribute('use'));
    }

    public function testCreateAttributeForSimpleTypeRussianDollDesign(): void
    {
        $attribute = AttributeFactory::create('name', new SimpleType(null, DataType::String), SchemaType::RussianDoll)
            ->build();

        $node = $attribute->toNode();

        $this->assertSame('attribute', $node->localName);
        $this->assertSame('name', $node->getAttribute('name'));
        $this->assertSame('simpleType', $node->firstChild->localName);
    }

    #[DataProvider('provideInvalidData')]
    public  function testErrorCreatingAttribute(array $arguments = []): void
    {
        $this->expectException(InvalidArgumentException::class);

        AttributeFactory::create('name', $arguments['type'])
            ->setUse($arguments['use'] ?? UseType::Optional)
            ->setDefault($arguments['default'] ?? '')
            ->build();
    }

    public static function provideInvalidData(): array
    {
        return [
            'invalid type' => [['type' => 'unknown']],
            'invalid maxOccurs' => [['type' => 'string', 'use' => 'restricted']],
            'invalid default value' => [['type' => 'string', 'default' => [1, 2]]],
        ];
    }
}
