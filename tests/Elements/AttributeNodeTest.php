<?php

declare(strict_types=1);

namespace DMT\Test\XsdBuilder\Elements;

use DMT\XsdBuilder\Elements\AttributeNode;
use DMT\XsdBuilder\Elements\SimpleType;
use DMT\XsdBuilder\Types\DataType;
use PHPUnit\Framework\TestCase;

class AttributeNodeTest extends TestCase
{
    public function testAttributeToNode(): void
    {
        $attribute = new AttributeNode('version', DataType::String, '1.0');

        $node = $attribute->toNode();

        $this->assertSame('attribute', $node->localName);
        $this->assertSame('version', $node->getAttribute('name'));
        $this->assertSame(DataType::String->type(), $node->getAttribute('type'));
        $this->assertSame('1.0', $node->getAttribute('default'));
    }

    public function testAttributeForSimpleTypeToNode(): void
    {
        $attribute = new AttributeNode('version', new SimpleType('versionType', DataType::String), '1.0');

        $node = $attribute->toNode();

        $this->assertSame('attribute', $node->localName);
        $this->assertSame('version', $node->getAttribute('name'));
        $this->assertSame('simpleType', $node->firstChild->localName);
        $this->assertSame('1.0', $node->getAttribute('default'));
    }
}
