<?php

declare(strict_types=1);

namespace DMT\Test\XsdBuilder\Nodes;

use DMT\XsdBuilder\DataType;
use DMT\XsdBuilder\Nodes\SimpleType;
use DMT\XsdBuilder\Restrictions\Expression;
use PHPUnit\Framework\TestCase;

class SimpleTypeTest extends TestCase
{
    public function testSimpleTypeToNode(): void
    {
        $simpleType = new SimpleType('mandatory', DataType::Boolean);

        $element = $simpleType->toNode();

        $this->assertSame('simpleType', $element->localName);
        $this->assertSame('mandatory', $element->getAttribute('name'));
        $this->assertSame(DataType::Boolean->type(), $element->getAttribute('type'));
    }

    public function testSimpleTypeWithRestrictionToNode(): void
    {
        $simpleType = new SimpleType('initials', DataType::String, new Expression(DataType::String, '[A-Z]{1,3}'));

        $element = $simpleType->toNode();

        $this->assertSame('simpleType', $element->localName);
        $this->assertSame('initials', $element->getAttribute('name'));
        $this->assertSame('restriction', $element->childNodes[0]->localName);
        $this->assertSame(DataType::String->type(), $element->childNodes[0]->getAttribute('base'));
    }
}
