<?php

// for initial development, use this
ini_set('display_errors', '1');

if (!file_exists('../config.php')) {
    die('App needs to be installed!');
}

require_once '../api.php';

$app = Chemdex::init();
