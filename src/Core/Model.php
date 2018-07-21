<?php

namespace Core;

class Model
{
    protected $errors = array();
    protected $data;

    public function hasError()
    {
        return !empty($this->errors);
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function getData()
    {
        return $this->data;
    }
}
