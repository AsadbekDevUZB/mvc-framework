<?php

namespace assaad\core;

use assaad\core\middlewares\BaseMiddleware;

class Controller
{

    /**
     * @property $action Get Current action
     */
    public string $action = '';
    public string $layout = 'main';
    /**
    * @var $middlewares BaseMiddleware
    *
    **/
    protected array $middlewares = [];

    public function render($view,$params = [])
    {
        return Application::$app->route->renderView($view,$params);
    }

    public function setLayout($layout)
    {
        $this->layout = $layout;
    }

    public function registerMiddleware(BaseMiddleware $middleware)
    {
        $this->middlewares[] = $middleware;
    }

    /**
     * @return BaseMiddleware
     */
    public function getMiddlewares()
    {
        return $this->middlewares;
    }

    /**
     * @param BaseMiddleware $middlewares
     */
    public function setMiddlewares($middlewares): void
    {
        $this->middlewares = $middlewares;
    }


}