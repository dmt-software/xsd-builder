<?php

declare(strict_types=1);

namespace DMT\XsdBuilder\Types;

enum ListType: string
{
    case All = 'all';
    case Sequence = 'sequence';
}
