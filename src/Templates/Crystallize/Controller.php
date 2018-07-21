<?php

namespace Templates\Crystallize;

use Core\Controller as BaseController;
use Core\Crystal;

class Controller extends BaseController
{
    public function __construct($model)
    {
        parent::__construct($model);

        if (!isset($_POST) || !array_key_exists('words', $_POST)) {
            return;
        }

        $words = $_POST['words'];

        if (!is_array($words) || empty($words)) {
            return;
        }

        array_map(function ($word) {
            preg_replace('/[^A-Za-zÄÖÜẞäöüß]/', '', $word);
        }, $words);

        $crystal_words = array();

        // Checking for whitelist/blacklist

        foreach ($words as $key => $word) {
            $result = $this->model->checkWhitelist($word);
            if ($result) {
                unset($words[$key]);
                $lemma = $result->lemma;
                $gender = $result->gender;

                $data = array(
                    'lemma' => $lemma,
                    'word' => $word,
                    'gender' => $gender,
                );
                $this->model->addToDataset($data);
            }

            if ($this->model->checkBlacklist($word)) {
                unset($words[$key]);
            }
        }

        // Using crystal api to get the genders

        $crystal = new Crystal();
        $chunks = array_chunk($words, 10);
        $lemma_words = array();

        foreach ($chunks as $chunk) {
            $new_words = $crystal->getCrystallizedWords($chunk);
            $lemma_words = array_merge($lemma_words, $new_words);
        }

        $words_to_blacklist = array_values($words);

        foreach ($lemma_words as $lemma_word) {
            $key = array_search($lemma_word->text, $words_to_blacklist);
            array_splice($words_to_blacklist, $key, 1);
        }

        foreach ($words_to_blacklist as $word) {
            $this->model->saveToBlackList($word);
        }

        $lemmas = array();

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
                $this->model->saveToWhiteList($crystal_word);
                $this->model->addToDataset($crystal_word);
            } else {
                $this->model->saveToBlackList($crystal_word['word']);
            }
        }

    }
}
