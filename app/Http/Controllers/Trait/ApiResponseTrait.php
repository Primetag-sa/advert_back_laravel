<?php

namespace App\Http\Controllers\Trait;


trait ApiResponseTrait
{
    public function apiResponseSuccess($data = null, $message = null)
    {
        $array = [
            'message' => $message,
            'status' => true,
            'data' => $data,

        ];
        return response($array);
    }
    public function apiTokenResponseSuccess($data = null, $message = null, $token = null)
    {
        $array = [
            'message' => $message,
            'status' => true,
            'data' => $data,
            'token' => $token

        ];
        return response($array);
    }
    public function apiResponseFaild($message = null, $error = null, $statusCode = null)
    {
        $array = [
            'message' => $message,
            'status' => $statusCode ?? false,
            'error' => $error
        ];
        return response($array);
    }
    public function apiResponseSuccessInsert($message = "success insert")
    {
        $array = [
            'status' => 'success',
            'message' => $message,
        ];
        return response($array);
    }

    public function apiResponseEmpty()
    {
        $array = [
            'message' => 'success',
            'status' => 404,
        ];
        return response($array);
    }

    public function apiResponseSuccessDelete($message = "success Delete")
    {
        $array = [
            'status' => 'success',
            'message' => $message,
        ];
        return response($array);
    }
}
