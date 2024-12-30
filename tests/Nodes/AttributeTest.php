<?php

declare(strict_types=1);

namespace DMT\Test\XsdBuilder\Nodes;

use DMT\XsdBuilder\DataType;
use DMT\XsdBuilder\Nodes\Attribute;
use PHPUnit\Framework\TestCase;

class AttributeTest extends TestCase
{
    public function testAttributeToNode(): void
    {
        $attribute = new Attribute('version', DataType::String, '1.0');

        $element = $attribute->toNode();

        $this->assertSame('attribute', $element->localName);
        $this->assertSame('version', $element->getAttribute('name'));
        $this->assertSame(DataType::String->type(), $element->getAttribute('type'));
        $this->assertSame('1.0', $element->getAttribute('default'));
    }
}
