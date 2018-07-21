<?php

namespace Templates\Crystallize;

use Core\Model as BaseModel;

class Model extends BaseModel
{
    protected $table = 'noun';
    protected $columns = array('lemma', 'gender');
    protected $whitelist_table = 'whitelist';
    protected $blacklist_table = 'blacklist';

    public function __construct()
    {
        parent::__construct();
    }

    public function getGenders($words)
    {
        if (empty($words)) {
            return array();
        }

        return $this->db->selectIn($this->table, $this->columns, array('lemma' => $words));
    }

    public function saveToWhiteList($word)
    {
        $data = array(
            'lemma' => $word['lemma'],
            'noun' => $word['word'],
            'gender' => $word['gender'],
        );

        $this->db->insert($this->whitelist_table, $data);
    }

    public function saveToBlackList($word)
    {
        $data = array(
            'noun' => $word,
        );

        $this->db->insert($this->blacklist_table, $data);
    }

    public function checkWhitelist($word)
    {
        $result = $this->db->select(
            $this->whitelist_table,
            array('noun', 'lemma', 'gender'),
            array('noun' => $word)
        );

        return !empty($result) ? $result[0] : false;
    }

    public function checkBlacklist($word)
    {
        $result = $this->db->select(
            $this->blacklist_table,
            array('noun'),
            array('noun' => $word)
        );

        return !empty($result) ? true : false;
    }

    public function addToDataset($word)
    {
        $this->data[$word['word']] = $word;
    }
}
