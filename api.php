<?php

class Chemdex {

    public static function init() {
        chdir(__DIR__);
        require_once('vendor/autoload.php');

        $config = new \Chemdex\Config();
        $config->loadFile('config', false);
    }
}
