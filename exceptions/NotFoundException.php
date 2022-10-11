<?php

namespace app\core\exceptions;

class NotFoundException extends \Exception
{
    /**
    * @property $code Exception code
    */
    protected $code = 404;

    /**
    * @property $message Error message for Exception
    */
    protected $message = 'Not Found';
}