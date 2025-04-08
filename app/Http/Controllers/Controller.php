<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;

interface BaseControllerInterface
{
    public function sendValidationError($message, $errors);
    public function sendResponseOk($message, $data);
    public function sendResponseCreated($message, $data);
    public function sendResponse($status, $message, $data, $status_code);
    public function sendExceptionError($errors);
}

class Controller extends BaseController implements BaseControllerInterface
{
    use AuthorizesRequests, ValidatesRequests;

    public function sendValidationError($message, $errors): Response
    {
        return response([
            'status' => false,
            'message' => $message,
            'errors' => $errors
        ], 200);
    }

    public function sendResponseOk($message, $data): Response
    {
        return response([
            'status' => true,
            'message' => $message,
            'data' => $data
        ], 200);
    }

    public function sendResponseCreated($message, $data): Response
    {
        return response([
            'status' => true,
            'message' => $message,
            'data' => $data
        ], 201);
    }

    public function sendResponse($status, $message, $data, $status_code): Response
    {
        return response([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ], $status_code);
    }

    public function sendExceptionError($errors): Response
    {
        return response([
            'status' => false,
            'message' => "Internal server error. Please try again",
            'errors' => $errors
        ], 500);
    }
}