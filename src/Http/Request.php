<?php

namespace NestPHP\Http;

class Request {

    public static function method() 
    {
        return $_SERVER['REQUEST_METHOD'];
    }


    public static function uri() 
    {
        return $_SERVER['REQUEST_URI'];
    }


    public static function headers() 
    {
        // Check if function exists (for built-in web server compatibility)
        if (function_exists('getallheaders')) {
            return getallheaders();
        }

        // For non-Apache environments (e.g., built-in PHP server)
        $headers = [];
        foreach ($_SERVER as $name => $value) {
            if (substr($name, 0, 5) == 'HTTP_') {
                $name = str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))));
                $headers[$name] = $value;
            }
        }
        return $headers;
    }


    public static function body() 
    {
        return file_get_contents('php://input');
    }


    public static function bodyType() 
    {
        $contentType = $_SERVER['CONTENT_TYPE'] ?? '';

        // Check if the content type indicates JSON
        if (stripos($contentType, 'application/json') !== false) {
            return 'json';
        }

        // Check if the content type indicates form data
        if (stripos($contentType, 'application/x-www-form-urlencoded') !== false) {
            return 'form-data';
        }
        
        // Default to unknown type
        return 'unknown';
    }

    public static function params() 
    {
        return array_merge($_GET, $_POST);
    }

    public static function all() 
    {
        // Merge $_GET, $_POST, and parsed JSON data
        return array_merge($_GET, $_POST, static::body());
    }
}