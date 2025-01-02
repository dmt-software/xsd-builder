<?php

namespace DMT\XsdBuilder\Elements;

use DOMDocument;
use DOMException;
use InvalidArgumentException;

class Schema
{
    public const namespace = 'http://www.w3.org/2001/XMLSchema';

    /** @var array<int, Type> */
    private array $types = [];
    /** @var array<int, Node> */
    private array $nodes = [];

    public function __construct(
        private DOMDocument $document
    ) {
    }

    public function getDocument(): DOMDocument
    {
        return $this->document;
    }

    public function addType(Type $type): self
    {
        $this->types[] = $type;

        return $this;
    }

    public function addNode(Node $node): self
    {
        $this->nodes[] = $node;

        return $this;
    }

    /** @throws DOMException */
    public function renderSchema(): void
    {
        $schema = $this->document->firstChild;

        if (!$schema) {
            $schema = $this->document->appendChild($this->document->createElementNS(self::namespace, 'xs:schema'));
        }

        if ($schema->localName !== 'schema' || $schema->namespaceURI !== self::namespace) {
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
    }
}
