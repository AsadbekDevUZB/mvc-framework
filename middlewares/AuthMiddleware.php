<?php

namespace assaad\core\middlewares;

use app\core\Application;
use assaad\core\assaadlication;
use assaad\core\exceptions\ForbidenException;

class AuthMiddleware extends BaseMiddleware
{
    public array $actions = [];

    /**
     * @param array $actions
     */
    public function __construct(array $actions)
    {
        $this->actions = $actions;
    }


    public function execute()
    {
       if(Application::isGuest()){
           if(in_array($this->getCurrentActionName(),$this->actions)){
                throw new ForbidenException();
           }
       }
    }

}