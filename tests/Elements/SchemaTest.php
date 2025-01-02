<?php

namespace DMT\Test\XsdBuilder\Elements;

use DMT\XsdBuilder\Elements\ComplexType;
use DMT\XsdBuilder\Elements\ElementNode;
use DMT\XsdBuilder\Elements\Schema;
use DMT\XsdBuilder\Types\DataType;
use DOMDocument;
use DOMException;
use DOMXPath;
use PHPUnit\Framework\Attributes\RunInSeparateProcess;
use PHPUnit\Framework\TestCase;

class SchemaTest extends TestCase
{
    public function testVenetianBlindSchema(): void
    {
        $document = new DOMDocument(encoding: 'utf-8');
        $xpath = new DOMXPath($document);

        $complexType = new ComplexType('userType');
        $complexType->addElement(new ElementNode('name', DataType::String));
        $complexType->addElement(new ElementNode('password', DataType::String));

        $schema = new Schema($document);
        $schema->addType($complexType);
        $schema->addNode(new ElementNode('user', 'userType'));
        $schema->renderSchema();

        $this->assertCount(1, $xpath->query('//*[local-name() = "complexType" and @name="userType"]'));
        $this->assertCount(1, $xpath->query('//*[local-name() = "element" and @type="userType"]'));
    }

    public function testRussianDollSchema(): void
    {
        $document = new DOMDocument(encoding: 'utf-8');
        $xpath = new DOMXPath($document);

        $complexType = new ComplexType();
        $complexType->addElement(new ElementNode('name', DataType::String));
        $complexType->addElement(new ElementNode('password', DataType::String));

        $schema = new Schema($document);
        $schema->addNode(new ElementNode('user', $complexType));
        $schema->renderSchema();

        $this->assertCount(1, $xpath->query('//*[local-name() = "element" and @name="user"]'));
        $this->assertCount(1, $xpath->query('//*[@name="user"]/*[local-name() = "complexType"]'));
    }

    #[RunInSeparateProcess]
    public function testSchemaIsInvalid(): void
    {
        libxml_use_internal_errors(true);

        $this->expectException(DOMException::class);

        $schema = new Schema(new DOMDocument());
        $schema->addNode(new ElementNode('id', DataType::String));
        $schema->addNode(new ElementNode('id', DataType::Integer));
        $schema->renderSchema();
    }
}
