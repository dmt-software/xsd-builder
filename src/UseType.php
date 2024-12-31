<?php

namespace DMT\XsdBuilder;

enum UseType: string
{
    case Optional = 'optional';
    case Required = 'required';
    case Prohibited = 'prohibited';
}
