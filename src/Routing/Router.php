<?php

namespace NestPHP\Routing;

use ReflectionClass;
use ReflectionMethod;

class Router {
    private array $routes = [];
    private array $controllers = [];
    private array $providers = [];

    public function __construct($controllers,$providers) {
        $this->controllers = $controllers;
        $this->providers = $providers;
        $this->registerRoutes();
    }

    private function registerRoutes(): void {
        $index = 0;
        foreach ($this->controllers as $controllerClass) {
            $reflectionClass = new ReflectionClass($controllerClass);
            $attributes = $reflectionClass->getAttributes();
            foreach ($attributes as $attribute) {
                $attributeName = $attribute->getName(); // ex: Route
                $attributeParams = $attribute->getArguments(); // class attributes sucha as method and path
                // echo "Attribute: $attributeName, Parameters: "; print_r($attributeParams);
            }

            $methods = $reflectionClass->getMethods(ReflectionMethod::IS_PUBLIC);

            foreach ($methods as $method) {
                $routeAnnotation = $this->getMethodRouteAnnotation($method);
                if ($routeAnnotation) {
                    $this->addRoute(
                        $routeAnnotation->method,
                        $attributeParams['path'].$routeAnnotation->path,
                        $controllerClass,
                        $method->name,
                        $this->providers[$index]
                    );
                }
            }

            $index++;
        }
    }

    private function getMethodRouteAnnotation(ReflectionMethod $method): ?Route {
        $attributes = $method->getAttributes(Route::class);
        return !empty($attributes) ? $attributes[0]->newInstance() : null;
    }

    public function addRoute(string $method, string $path, string $controllerClass, string $methodName,string $providerClass): void {
        $this->routes[$method][$path] = ['controller' => $controllerClass, 'method' => $methodName,'provider' => $providerClass,];
    }

    public function handleRequest(string $method, string $path): mixed {
        echo $method." => ".$path."<br/>";
        echo "<pre>";print_r($this->routes);echo "</pre>";
        exit;
        if (isset($this->routes[$method][$path])) {
            $route = $this->routes[$method][$path];
            $controller = new $route['controller'](new $route['provider']);
            $method = $route['method'];
            return $controller->$method();
        } else {
            // Handle 404 Not Found
            return "404 Not Found";
        }
    }
}