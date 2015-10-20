<?php

namespace Chemdex;

use Slim\App as Router;

class App {

    protected $router;
    protected $config;
    protected $env;

    public function __construct(Config $config) {
        $this->config = $config;
        $this->env = $config->get('environment');

        $this->router = new Router();

        $this->setupEnvironment();
    }

    protected function setupEnvironment() {
        if ($this->env instanceof Closure) {
            $this->env->call($this);
            return;
        }

        switch($this->env) {
            case 'prod':
            case 'production':
                break;
            case 'test':
            case 'testing':
                break;
            case 'dev':
            case 'development':
            default:
                
        }
    }

    public function start() {
        $this->router->run();
    }

}
