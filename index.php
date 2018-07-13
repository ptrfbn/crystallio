<?php

use Core\Cluster;

require __DIR__ . '/src/config.php';
$loader = require __DIR__ . '/vendor/autoload.php';
$loader->add('Core\\', __DIR__ . '/src/');

Cluster::init();
