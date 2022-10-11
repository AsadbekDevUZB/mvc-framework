<?php

namespace app\core\middlewares;

use app\core\Application;

abstract class BaseMiddleware
{
    abstract public function execute();

    public function getCurrentActionName()
    {
        return Application::$app->controller->action;
    }
}