<?php

namespace DMT\XsdBuilder\Types;

enum UseType: string
{
    case Optional = 'optional';
    case Required = 'required';
    case Prohibited = 'prohibited';
}
