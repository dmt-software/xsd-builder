<?php

declare(strict_types=1);

namespace DMT\XsdBuilder\Types;

enum UseType: string
{
    case Optional = 'optional';
    case Required = 'required';
    case Prohibited = 'prohibited';
}
