<?php

use Core\Router;
use Core\Template;

Router::get('/', function () {
    Template::load('Index');
});
