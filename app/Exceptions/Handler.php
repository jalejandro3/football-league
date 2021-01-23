<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (ApplicationException $e) {});
        $this->reportable(function (ClientException $e) {});
        $this->reportable(function (InputValidationException $e) {});
        $this->reportable(function (ResourceNotFoundException $e) {});
    }

    /**
     * @inheritDoc
     */
    public function render($request, Throwable $e)
    {
        return response()->json(["message: " =>  $e->getMessage()], $e->getCode());
    }
}
