<?php

class jsonKit
{
    public static function json($data, $message, $http_response_code = 200) {
        if(!is_array($data)){
            $http_response_code = $message;
            $message = $data;
        }

        if($http_response_code == 200){
            $json = [
                'status' => true,
                'message' => $message,
                'data' => $data
            ];
        } else {
            $json = [
                'status' => false,
                'message' => $message
            ];
        }
        header('Content-Type: application/json; charset=utf-8');
        $json = json_encode($json, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES);
        http_response_code($http_response_code);
        echo $json;
    }

    public static function success($message) {
        $json = [
            'status' => true,
            'message' => $message,
        ];
        header('Content-Type: application/json; charset=utf-8');
        $json = json_encode($json, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES);
        echo $json;
    }

    public static function failWithoutHRC($message) {
        $json = [
            'status' => false,
            'message' => $message,
        ];
        header('Content-Type: application/json; charset=utf-8');
        $json = json_encode($json, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES);
        echo $json;
    }
}