<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Success json response body.
     *
     * @param array $msg Response message
     * @param int $code Response code
     * @return JsonResponse
     */
    public function success(array $msg, int $code): JsonResponse
    {
        return response()->json($msg, $code, [], JSON_UNESCAPED_SLASHES);
    }
}
