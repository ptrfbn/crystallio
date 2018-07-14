<?php

namespace Core;

class Cluster
{
    public static function init()
    {
        require ROOT_DIR . 'src/routes.php';

        Router::start();
    }
}
