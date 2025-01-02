<?php

declare(strict_types=1);

namespace DMT\XsdBuilder\Types;

enum DataType: string
{
    case Boolean = 'boolean';
    case DateTime = 'dateTime';
    case Decimal = 'decimal';
    case Integer = 'integer';
    case String = 'string';

    public function type(): string
    {
        return sprintf('xs:%s', $this->value);
    }
}
