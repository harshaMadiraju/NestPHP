<?php

namespace NestPHP\Routing;

use NestPHP\Routing\Attributes\Route;
use ReflectionClass;
use ReflectionMethod;

class Router {
    private array $routes = [];

    public function registerRoutes(array $controllers, array $providers): void {
        foreach ($controllers as $index => $controllerClass) {
            $reflectionClass = new ReflectionClass($controllerClass);
            $classAttributes = $reflectionClass->getAttributes();
            
            // Extract class route prefix
            $routePrefix = '';
            foreach ($classAttributes as $attribute) {
                if (basename($attribute->getName()) === 'Route') {
                    // echo  basename($attribute->getName());
                    $routePrefix = $attribute->getArguments()[0];
                    break;
                }
            }
    
            $methods = $reflectionClass->getMethods(ReflectionMethod::IS_PUBLIC);
            
            foreach ($methods as $method) {
                $routeAnnotation = $this->getMethodRouteAnnotation($method);
                if ($routeAnnotation) {
                    // Assuming $providers is an array of corresponding service classes
                    $providerClass = $providers[$index];
                    $this->addRoute(
                        $routeAnnotation->method,
                        $routePrefix . $routeAnnotation->path,
                        $controllerClass,
                        $method->name,
                        $providerClass
                    );
                }
            }
        }
    }
    
    private function getMethodRouteAnnotation(ReflectionMethod $method): ?Route {
        $attributes = $method->getAttributes();
        return !empty($attributes) ? $attributes[0]->newInstance() : null;
    }

    public function addRoute(string $method, string $path, string $controllerClass, string $methodName,string $providerClass): void {
        $this->routes[$method][$path] = ['controller' => $controllerClass, 'method' => $methodName,'provider' => $providerClass,];
    }

    public function handleRequest(string $method, string $path): mixed {
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