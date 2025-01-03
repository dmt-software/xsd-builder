<?php

declare(strict_types=1);

namespace DMT\Test\XsdBuilder\Factories;

use DMT\XsdBuilder\Elements\ComplexType;
use DMT\XsdBuilder\Elements\SimpleType;
use DMT\XsdBuilder\Factories\ElementFactory;
use DMT\XsdBuilder\Types\DataType;
use DMT\XsdBuilder\Types\SchemaType;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class ElementFactoryTest extends TestCase
{
    public function testCreateElementForInternalType(): void
    {
        $element = ElementFactory::create('test', 'string')
            ->setMinOccurs(1)
            ->setMaxOccurs(1)
            ->setDefault(false)
            ->build();

        $node = $element->toNode();

        $this->assertSame('element', $node->localName);
        $this->assertSame(DataType::String->type(), $node->getAttribute('type'));
        $this->assertSame('1', $node->getAttribute('minOccurs'));
        $this->assertSame('1', $node->getAttribute('maxOccurs'));
        $this->assertSame('false', $node->getAttribute('default'));
    }

    public function testCreateElementForSimpleType(): void
    {
        $element = ElementFactory::create('name', new SimpleType('nameType', DataType::String))
            ->setMinOccurs(0)
            ->setMaxOccurs('unbounded')
            ->build();

        $node = $element->toNode();

        $this->assertSame('element', $node->localName);
        $this->assertSame('name', $node->getAttribute('name'));
        $this->assertSame('nameType', $node->getAttribute('type'));
        $this->assertSame('0', $node->getAttribute('minOccurs'));
        $this->assertSame('unbounded', $node->getAttribute('maxOccurs'));
    }

    public function testCreateElementForSimpleTypeRussianDollDesign(): void
    {
        $element = ElementFactory::create('name', new SimpleType(null, DataType::String), SchemaType::RussianDoll)
            ->setMinOccurs(0)
            ->build();

        $node = $element->toNode();

        $this->assertSame('element', $node->localName);
        $this->assertSame('name', $node->getAttribute('name'));
        $this->assertSame('simpleType', $node->firstChild->localName);
        $this->assertSame('0', $node->getAttribute('minOccurs'));
    }

    #[DataProvider('provideInvalidData')]
    public function testErrorCreatingElement(array $arguments = []): void
    {
        $this->expectException(InvalidArgumentException::class);

        $element = ElementFactory::create('test', $arguments['type'])
            ->setMaxOccurs($arguments['maxOccurs'] ?? 1);

        if ($arguments['default'] ?? false) {
            $element->setDefault($arguments['default']);
        }

        $element->build();
    }

    public static function provideInvalidData(): array
    {
        return [
            'invalid type' => [['type' => 'unknown']],
            'invalid maxOccurs' => [['type' => 'string', 'maxOccurs' => 'restricted']],
            'invalid default value' => [['type' => 'string', 'default' => [1, 2]]],
            'default for complexType' => [['type' =>  new ComplexType(), 'default' => 'value']],
        ];
    }
}
