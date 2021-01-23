<?php

namespace App\Exceptions;

use Exception;

/**
 * Class ClientException
 *
 * @package App\Exceptions
 */
class ClientException extends Exception
{
    protected $code = 500;
}
