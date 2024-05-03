<?php

namespace NestPHP\Common;

use NestPHP\Helpers\Dump;
use NestPHP\Routing\Route;
use NestPHP\Routing\Router;
use ReflectionClass;

class BaseModule extends Module{

    private $controllers=[];
    private $providers=[];
    private Router $router;

    public function __construct(){
        $this->registerModule();
        $this->router = new Router();
        // Register routes
        $this->router->registerRoutes($this->controllers, $this->providers);
    }

    private function registerModule(){
        $reflectionClass = new ReflectionClass($this);
        $docComment = $reflectionClass->getDocComment();
        if($docComment){
            if(preg_match("/@Module\((.*)\)/s", $docComment, $matches)){
                if(!empty($matches[1])){
                    $matches[1] = preg_replace("/[\*]+/","", $matches[1]);
                    $config = json_decode($matches[1],true);
                    if($config!==null){
                        $this->configureModuleRegistration($config);
                    }
                }
            }
        }
    }

    protected function configureModuleRegistration($config){
        if(isset($config["controllers"]) && isset($config["providers"])){
            if(count($config["controllers"]) == count($config['providers'])){
                foreach($config["controllers"] as $controllerClass){
                    $this->assignDependencyClasses($controllerClass,"Controller");
                }
                
                foreach($config["providers"] as $providerClass){
                    $this->assignDependencyClasses($providerClass,"Service");
                }
                
                // $this->instantiateDependencyClass();
            }
            else{
                throw new \Exception("Each Controller Class Must have an Service Class");
            }
        }

    }

    private function assignDependencyClasses($class,$type){
        $class = str_replace("::class","", $class);
        $fully_qualified_class_name  = "App\\$class";       
        switch($type){
            case "Controller": $this->controllers[] = $fully_qualified_class_name; break;
            case "Service": $this->providers[] = $fully_qualified_class_name; break;
        }
    }
    
    public function handleRequest(string $method, string $path): mixed {
        return $this->router->handleRequest($method, $path);
    }

}