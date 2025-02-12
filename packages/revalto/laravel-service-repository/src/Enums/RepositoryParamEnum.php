<?php

namespace Revalto\ServiceRepository\Enums;

enum RepositoryParamEnum: string
{
    case SELECT = 'select';
    case WITH = 'with';
    case LIMIT = 'limit';
    case WITH_COUNT = 'withCount';
}
