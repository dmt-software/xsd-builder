<?php

declare(strict_types=1);

namespace DMT\XsdBuilder\Elements;

interface ParentType
{
    public function addElement(ElementNode $element): ParentType;

    public function addAttribute(AttributeNode $attribute): ParentType;
}
