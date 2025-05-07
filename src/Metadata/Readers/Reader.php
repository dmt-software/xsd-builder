<?php

declare(strict_types=1);

namespace DMT\XsdBuilder\Metadata\Readers;

use DMT\XsdBuilder\Metadata\ClassMetadata;
use DMT\XsdBuilder\Metadata\PropertyMetadata;
use ReflectionClass;
use ReflectionProperty;

interface Reader
{
    public function readComplexType(ReflectionClass $reflectionClass): ClassMetadata;
    public function readSimpleType(ReflectionProperty $reflectionProperty): ClassMetadata;
    public function readElement(ReflectionProperty $reflectionProperty): PropertyMetadata;
    public function readAttribute(ReflectionProperty $reflectionProperty): PropertyMetadata;
}
