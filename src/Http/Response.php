<?php

namespace NestPHP\Http;

class Response {

    private static array $successCodes = [200,201,202,203,204,205,206,207,208,226];

    private static function format(string $message='',array $data=[],int $statusCode = 200){
        $format = [];
        $format['success'] = false;
        if(in_array($statusCode,self::$successCodes)){
            $format['success'] = true;
        }
        $format['message']=$message;
        $format['data']=$data;
        return $format;
    }

    public static function ok(string $message='',array $data=[],int $statusCode = 200) {
        self::json($message,$data,$statusCode);
    }

    public static function error(string $message='',array $data=[],int $statusCode = 422) {
        self::json($message,$data,$statusCode);
    }
    
    public static function json(string $message='',array $data=[],int $statusCode = 200,array $headers = []) {
        // Set content type to application/json
        $headers['Content-Type'] = 'application/json';
        // Encode the data as JSON
        $body = json_encode(self::format($message,$data,$statusCode));

        http_response_code($statusCode);

        // Set the response headers
        foreach ($headers as $name => $value) {
            header("$name: $value");
        }

        // Send the response body
        echo $body;
    }
}