<?php

namespace DMT\XsdBuilder\Elements;

interface ParentType
{
    public function addElement(ElementNode $element): ParentType;

    public function addAttribute(AttributeNode $attribute): ParentType;
}
