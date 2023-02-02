<?php

namespace Enums;

enum MimeTypeEnum: string
{
    case M_TYPE_JSON = 'application/json';
    case M_TYPE_MERGE_PATCH = 'json-merge-patch';
}
