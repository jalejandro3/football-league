<?php

namespace App\Exceptions;

use Exception;

/**
 * Class ApplicationException
 *
 * @package App\Exceptions
 */
class ApplicationException extends Exception
{
    protected $code = 400;
}
