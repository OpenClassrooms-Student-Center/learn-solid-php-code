<?php

namespace App\Classes\Tools;

class HttpResponse
{
    public static function send(string $content)
    {
        header('HTTP/1.1 200 OK', true, 200);
        header('Content-Type: text/html');

        echo $content;
    }

    public static function sendNotFound()
    {
        header('HTTP/1.0 404 Not Found');
        header('Content-Type: text/html');
    }

    public static function sendError(string $error)
    {
        header('HTTP/1.0 500 Internal Server Error');
        header('Content-Type: text/html');

        echo $error;
    }
}
