<?php

namespace app\core\exceptions;

class ForbidenException extends \Exception
{
    /**
    * @property $code Exception code
    */
    protected  $code = 403;

    /**
    * @property $message Error message after Exception
    */
    protected $message = 'You don\'t have access this page';
}