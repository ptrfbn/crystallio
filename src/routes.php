<?php

use Core\Router;
use Core\Template;

Router::get('/', function () {
    Template::load('Index');
});

Router::get('/404', function () {
    Template::load('Http404');
});
