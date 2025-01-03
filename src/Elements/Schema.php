<?php

namespace DMT\XsdBuilder\Elements;

use DOMDocument;
use DOMException;
use InvalidArgumentException;

class Schema implements ParentType, ParentNode
{
    public const NAMESPACE = 'http://www.w3.org/2001/XMLSchema';

    /** @var array<int, Type> */
    private array $types = [];
    /** @var array<int, Node> */
    private array $nodes = [];

    public function __construct(private DOMDocument $document)
    {
    }

    public function addSimpleType(SimpleType $simpleType): self
    {
        $this->types[] = $simpleType;

        return $this;
    }

    public function addComplexType(ComplexType $complexType): self
    {
        $this->types[] = $complexType;

        return $this;
    }

    public function addAttribute(AttributeNode $attribute): self
    {
        $this->nodes[] = $attribute;

        return $this;
    }

    public function addElement(ElementNode $element): self
    {
        $this->nodes[] = $element;

        return $this;
    }

    /** @throws DOMException */
    public function renderSchema(): DOMDocument
    {
        $schema = $this->document->firstChild;

        if (!$schema) {
            $schema = $this->document->appendChild($this->document->createElementNS(self::NAMESPACE, 'xs:schema'));
        }

        if ($schema->localName !== 'schema' || $schema->namespaceURI !== self::NAMESPACE) {
            throw new InvalidArgumentException('Invalid schema provided');
        }

        foreach ($this->types as $type) {
            $schema->appendChild($type->toNode($this->document));
        }

        foreach ($this->nodes as $node) {
            $schema->appendChild($node->toNode($this->document));
        }

        if (!$this->document->schemaValidate(__DIR__ . '/../../res/schema.xsd')) {
            throw new DOMException('Invalid XML schema');
        }

        return $this->document;
    }
}
