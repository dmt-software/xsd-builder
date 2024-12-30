<?php

declare(strict_types=1);

namespace DMT\Test\XsdBuilder\Restrictions;

use DMT\XsdBuilder\DataType;
use DMT\XsdBuilder\Restrictions\Enumeration;
use PHPUnit\Framework\TestCase;

class EnumerationTest extends TestCase
{
    public function testEnumerationToNode(): void
    {
        $enumeration = new Enumeration(DataType::String, ['a', 'b', 'c']);

        $element = $enumeration->toNode();

        $this->assertSame('restriction', $element->localName);
        $this->assertCount(3, $element->childNodes);
        $this->assertSame('enumeration', $element->childNodes[0]->localName);
        $this->assertSame('a', $element->childNodes[0]->getAttribute('value'));
        $this->assertSame('enumeration', $element->childNodes[1]->localName);
        $this->assertSame('b', $element->childNodes[1]->getAttribute('value'));
        $this->assertSame('enumeration', $element->childNodes[1]->localName);
        $this->assertSame('c', $element->childNodes[2]->getAttribute('value'));
    }
}
