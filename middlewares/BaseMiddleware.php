<?php

namespace assaad\core\middlewares;

use assaad\core\Application;

abstract class BaseMiddleware
{
    abstract public function execute();

    public function getCurrentActionName()
    {
        return Application::$assaad->controller->action;
    }
}