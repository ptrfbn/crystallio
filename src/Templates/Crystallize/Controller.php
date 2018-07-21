<?php

namespace Templates\Crystallize;

use Core\Controller as BaseController;
use Core\Crystal;

class Controller extends BaseController
{
    public function __construct($model)
    {
        parent::__construct($model);

        $words = $_POST['words'];

        array_map(function ($word) {
            preg_replace('/[^A-Za-zÄÖÜẞäöüß]/', '', $word);
        }, $words);

        $crystal = new Crystal();
        $chunks = array_chunk($words, 2);
        $lemma_words = array();

        foreach ($chunks as $chunk) {
            $new_words = $crystal->getCrystallizedWords($chunk);
            $lemma_words = array_merge($lemma_words, $new_words);
        }

        $lemmas = array();
        $crystal_words = array();

        foreach ($lemma_words as $lemma_word) {
            $word = $lemma_word->text;
            $lemma = $lemma_word->lemma;

            $crystal_words[$lemma] = array(
                'lemma' => $lemma,
                'word' => $word,
            );
            $lemmas[] = $lemma;
        }

        $gender_words = $this->model->getGenders($lemmas);

        foreach ($gender_words as $gender_word) {
            $lemma = $gender_word->lemma;
            $gender = $gender_word->gender;
            $crystal_words[$lemma]['gender'] = $gender;
        }

        foreach ($crystal_words as $crystal_word) {
            if (array_key_exists('gender', $crystal_word)) {
                $this->model->addToDataset($crystal_word);
            }
        }
    }
}
