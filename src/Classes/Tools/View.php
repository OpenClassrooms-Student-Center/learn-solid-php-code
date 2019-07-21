<?php

namespace App\Classes\Tools;

class View
{
    public static function render($template, $parameters)
    {
        $templatePath = VIEWS . $template . '.html.php';

        ob_start();
        // les paramètres seront utilisés lors de l'appel de la fonction
        $parameters;
        require $templatePath;

        return ob_get_clean();
    }

    public static function sendHttpResponse($content, $code = 200)
    {
        http_response_code($code);
        header('Content-Type: text/html');

        echo $content;
    }
}
