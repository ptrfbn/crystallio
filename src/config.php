<?php

define('ROOT_DIR', __DIR__ . '/../');

$database_auth = parse_ini_file(ROOT_DIR . 'env/database.ini');
define('DB_HOST', $database_auth['DB_HOST']);
define('DB_NAME', $database_auth['DB_NAME']);
define('DB_USER', $database_auth['DB_USER']);
define('DB_PASS', $database_auth['DB_PASS']);
