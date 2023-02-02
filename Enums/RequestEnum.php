<?php

namespace Enums;

enum RequestEnum: string
{
    case METHOD_GET = 'GET';
    case METHOD_POST = 'POST';
    case METHOD_PATCH = 'PATCH';
}
