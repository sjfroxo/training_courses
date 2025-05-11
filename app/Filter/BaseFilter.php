<?php

namespace App\Filter;

abstract class BaseFilter implements BaseFilterInterface
{
    /**
     * @var array
     */
    protected array $params = [];

    public function __construct()
    {
    }

    public function getParams(): array {
        return $this->params;
    }

    public function filter()
    {

    }
}
