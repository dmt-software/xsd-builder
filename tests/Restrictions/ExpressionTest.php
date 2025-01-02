<?php

declare(strict_types=1);

namespace DMT\Test\XsdBuilder\Restrictions;

use DMT\XsdBuilder\Restrictions\Expression;
use DMT\XsdBuilder\Types\DataType;
use PHPUnit\Framework\TestCase;

class ExpressionTest extends TestCase
{
    public function testExpressionToNode(): void
    {
        $expression = new Expression(DataType::Decimal, '[\d]+(\.[\d]+)?');

        $element = $expression->toNode();

        $this->assertSame('restriction', $element->localName);
        $this->assertSame(DataType::Decimal->type(), $element->getAttribute('base'));
        $this->assertSame('pattern', $element->childNodes[0]->localName);
        $this->assertSame('[\d]+(\.[\d]+)?', $element->childNodes[0]->getAttribute('value'));
    }
}
