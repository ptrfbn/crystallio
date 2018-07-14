<?php

namespace Core;

class Controller
{
    protected $model;

    protected function __construct($model)
    {
        $this->model = $model;
    }
}
