<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as controller;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

class BaseController extends Controller
{
    public function sendResponse($result, $message, $code = 200)
    {
        $response = [
            'success' => true,
            'data' => $result,
            'message' => $message
        ];
        return response()->json($response, $code);
    }

    public function sendError($error, $errorMessage = [], $code = 404)
    {
        $response = [
            'success' => false,
            'message' => $error
        ];
        if (!empty($errorMessage)) {
            $response['data'] = $errorMessage;
        }
        return response()->json($response, $code);
    }
}
