<?php

namespace Templates\Crystallize;

use Core\Model as BaseModel;

class Model extends BaseModel
{
    public function __construct()
    {
        parent::__construct();

        var_dump($this->db->select('noun', array('lemma', 'gender'), array('id' => 2)));exit;
    }
}
