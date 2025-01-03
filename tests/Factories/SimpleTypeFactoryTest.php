<?php

namespace DMT\Test\XsdBuilder\Factories;

use DMT\XsdBuilder\Factories\SimpleTypeFactory;
use DMT\XsdBuilder\Restrictions\Expression;
use DMT\XsdBuilder\Types\DataType;
use PHPUnit\Framework\TestCase;

class SimpleTypeFactoryTest extends TestCase
{
    public function testCreateSimpleType(): void
    {
        $simpleType = SimpleTypeFactory::create('name', 'string')->build();

        $node = $simpleType->toNode();

        $this->assertSame('simpleType', $node->localName);
        $this->assertSame('name', $node->getAttribute('name'));
        $this->assertSame(DataType::String->type(), $node->getAttribute('type'));
    }

    public function testCreateSimpleTypeWithRestriction(): void
    {
        $simpleType = SimpleTypeFactory::create('char', DataType::String)
            ->setRestriction(new Expression(DataType::String, '[A-Z]{1}'))
            ->build();

        $node = $simpleType->toNode();

        $this->assertSame('simpleType', $node->localName);
        $this->assertSame('char', $node->getAttribute('name'));
        $this->assertSame('restriction', $node->firstChild->localName);
    }
}
