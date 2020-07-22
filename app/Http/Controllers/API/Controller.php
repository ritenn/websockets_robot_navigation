<?php

namespace App\Http\Controllers\API;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * API Response template
     *
     * @param $message
     * @param array $data
     * @param int $code
     * @param bool $error
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function jsonResponse($message, $data = [], $code = 200, $error = false)
    {
        return response()->json([
            'error' => $error,
            'message' => $message,
            'data' => $data,
        ], $code);
    }
}
