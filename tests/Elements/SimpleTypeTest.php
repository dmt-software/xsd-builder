<?php

declare(strict_types=1);

namespace DMT\Test\XsdBuilder\Elements;

use DMT\XsdBuilder\Elements\SimpleType;
use DMT\XsdBuilder\Restrictions\Expression;
use DMT\XsdBuilder\Types\DataType;
use PHPUnit\Framework\TestCase;

class SimpleTypeTest extends TestCase
{
    public function testSimpleTypeToNode(): void
    {
        $simpleType = new SimpleType('mandatory', DataType::Boolean);

        $node = $simpleType->toNode();

        $this->assertSame('simpleType', $node->localName);
        $this->assertSame('mandatory', $node->getAttribute('name'));
        $this->assertSame(DataType::Boolean->type(), $node->getAttribute('type'));
    }

    public function testSimpleTypeWithRestrictionToNode(): void
    {
        $simpleType = new SimpleType('initials', DataType::String, new Expression(DataType::String, '[A-Z]{1,3}'));

        $node = $simpleType->toNode();

        $this->assertSame('simpleType', $node->localName);
        $this->assertSame('initials', $node->getAttribute('name'));
        $this->assertSame('restriction', $node->childNodes[0]->localName);
        $this->assertSame(DataType::String->type(), $node->childNodes[0]->getAttribute('base'));
    }
}
