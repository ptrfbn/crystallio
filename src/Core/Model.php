<?php

namespace Core;

use Core\Database;

class Model
{
    protected $errors = array();
    protected $data;
    protected $db;

    public function __construct()
    {
        $this->db = Database::instance();
    }

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
