<?php

namespace App\Helpers;


use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ResponseHelper
{
    public static function successResponse($data, string $message = null, $code = ResponseAlias::HTTP_OK): JsonResponse
    {
        return response()->json(['message' => $message, 'data' => $data, 'code' => $code], $code);
    }


    public static function errorResponse($error, $code = ResponseAlias::HTTP_BAD_REQUEST, $key = '')
    {
        $message = '';
        if (is_array($error)) {
            foreach ($error as $value) {
                if ($message) {
                    $message .= ', ';
                }
                $message .= (is_array($value) ? $value[0] : $value);
            }
        } else {
            $message = $error;
        }
        $output = ['error' => $message, 'code' => $code];
        if ($key) {
            $output['key'] = $key;
        }
        return response()->json($output, $code);
    }
}
