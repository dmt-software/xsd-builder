<?php

namespace DMT\XsdBuilder;

use DMT\XsdBuilder\Nodes\Node;
use DMT\XsdBuilder\Nodes\TypeNode;
use DOMDocument;
use DOMException;

class Schema
{
    public const namespace = 'http://www.w3.org/2001/XMLSchema';

    /** @var array<int, TypeNode> */
    private array $types = [];
    /** @var array<int, Node> */
    private array $nodes = [];

    public function addType(TypeNode $type): self
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
    public function renderSchema(DOMDocument $document): void
    {
        $schema = $document->createElementNS(self::namespace, 'xs:schema');

        $document->formatOutput = true;
        $document->appendChild($schema);

        foreach ($this->types as $type) {
            $schema->appendChild($type->toNode($document));
        }

        foreach ($this->nodes as $node) {
            $schema->appendChild($node->toNode($document));
        }

        if (!$document->schemaValidate(__DIR__ . '/../docs/schema.xsd')) {
            throw new DOMException('Invalid XML schema');
        }
    }
}
