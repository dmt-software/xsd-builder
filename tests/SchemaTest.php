<?php

namespace DMT\Test\XsdBuilder;

use DMT\XsdBuilder\DataType;
use DMT\XsdBuilder\Nodes\ComplexType;
use DMT\XsdBuilder\Nodes\Element;
use DMT\XsdBuilder\Schema;
use DOMDocument;
use DOMException;
use DOMXPath;
use PHPUnit\Framework\TestCase;

class SchemaTest extends TestCase
{
    public function testVenetianBlindSchema(): void
    {
        $document = new DOMDocument(encoding: 'utf-8');
        $xpath = new DOMXPath($document);

        $complexType = new ComplexType('userType');
        $complexType->addElement(new Element('name', DataType::String));
        $complexType->addElement(new Element('password', DataType::String));

        $schema = new Schema();
        $schema->addType($complexType);
        $schema->addNode(new Element('user', 'userType'));
        $schema->renderSchema($document);

        $this->assertCount(1, $xpath->query('//*[local-name() = "complexType" and @name="userType"]'));
        $this->assertCount(1, $xpath->query('//*[local-name() = "element" and @type="userType"]'));
    }

    public function testRussianDollSchema(): void
    {
        $document = new DOMDocument(encoding: 'utf-8');
        $xpath = new DOMXPath($document);

        $complexType = new ComplexType();
        $complexType->addElement(new Element('name', DataType::String));
        $complexType->addElement(new Element('password', DataType::String));

        $schema = new Schema();
        $schema->addNode(new Element('user', $complexType));
        $schema->renderSchema($document);

        $this->assertCount(1, $xpath->query('//*[local-name() = "element" and @name="user"]'));
        $this->assertCount(1, $xpath->query('//*[@name="user"]/*[local-name() = "complexType"]'));
    }

    public function testInvalidSchema(): void
    {
        $this->expectException(DOMException::class);

        $schema = new Schema();
        $schema->addNode(new Element('id', DataType::String));
        $schema->addNode(new Element('id', DataType::Integer));
        $schema->renderSchema(new DOMDocument());
    }
}