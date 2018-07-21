<?php

namespace Core;

class Crystal
{
    protected $host;
    protected $token;

    public function __construct()
    {
        $this->host = CRYSTAL_API_HOST;
        $this->token = CRYSTAL_API_TOKEN;
    }

    public function getCrystallizedWords($words)
    {
        $flat_words = rawurlencode(implode(' ', $words));

        $url = $this->getBaseUrl() . $flat_words;
        $response = file_get_contents($url);

        return json_decode($response);
    }

    protected function getBaseUrl()
    {
        return $this->host . '/?token=' . $this->token . '&text=';
    }

}
