<?php

class Route
{
    private static $routes = [];
    private $prefix;

    public static function group($prefix, $callback)
    {
        $callback(new self($prefix));
    }

    public function __construct($prefix)
    {
        $this->prefix = $prefix;
    }

    public function get($path, $callback)
    {
        self::$routes[] = ['method' => 'GET', 'path' => $this->prefix . $path, 'callback' => $callback];
    }

    public function post($path, $callback)
    {
        self::$routes[] = ['method' => 'POST', 'path' => $this->prefix . $path, 'callback' => $callback];
    }

    public static function match($method, $path)
    {
        foreach (self::$routes as $route) {
            if ($route['method'] === $method && $route['path'] === $path) {
                return $route['callback'];
            }
        }
        return null;
    }

    public static function dispatch($method, $path)
    {
        $requestUri = strtok($path, '?');
        $callback = self::match($method, $requestUri);
        if ($callback) {
            if (is_array($callback)) {
                $controller = new $callback[0]();
                $method = $callback[1];
                $controller->$method();
            } else {
                call_user_func($callback);
            }
        } else {
            self::notFound();
        }
    }

    public static function notFound()
    {
        http_response_code(404);
        echo '<!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>404 Not Found</title>
                <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
                <style>
                    body {
                        background-color: #f8f9fa;
                    }
                    .error-container {
                        display: flex;
                        justify-content: center;
                        align-items: center;
                        height: 100vh;
                    }
                    .error-content {
                        text-align: center;
                    }
                </style>
            </head>
            <body>
            
            <div class="error-container">
                <div class="error-content">
                    <h1 class="display-1">404</h1>
                    <p class="lead">Oops! Sayfa bulunamadı.</p>
                    <a href="/" class="btn btn-primary">Ana Sayfaya Dön</a>
                </div>
            </div>
            
            </body>
            </html>
            ';
    }
}

?>
