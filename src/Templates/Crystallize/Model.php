<?php

namespace Templates\Crystallize;

use Core\Model as BaseModel;

class Model extends BaseModel
{
    protected $table = 'noun';
    protected $columns = array('lemma', 'gender');

    public function __construct()
    {
        parent::__construct();
    }

    public function getGenders($words)
    {
        return $this->db->selectIn($this->table, $this->columns, array('lemma' => $words));
    }

    public function addToDataset($word)
    {
        $this->data[$word['word']] = $word;
    }
}
