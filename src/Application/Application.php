<?php

namespace App\Application;

class Application
{
    private array $handler = [];

    public function post($route, $handler): void
    {
        $this->handler[] = ['POST', $route, $handler];
    }

    public function get($route, $handler): void
    {
        $this->handler[] = ['GET', $route, $handler];
    }

    public function run()
    {
        $uri = $_SERVER['REQUEST_URI'];
        $method = $_SERVER['REQUEST_METHOD'];
        foreach ($this->handler as $item) {
            [$handlerMethod, $route, $handler] = $item;
//            var_dump($uri, $route);
            if ($method === $handlerMethod && $route === $uri) {
                echo $handler();
                return;
            }
        }
    }
}
