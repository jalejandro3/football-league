<?php

namespace App\Exceptions;

use Exception;

class ApplicationException extends Exception
{
    protected $code = 400;
}
