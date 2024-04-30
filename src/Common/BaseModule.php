<?php

namespace NestPHP\Common;

class BaseModule extends Module{

    private $controllers;
    private $providers;

    public function __construct(){
        $reflectionClass = new \ReflectionClass($this);
        $docComment = $reflectionClass->getDocComment();
        
        if($docComment){
            if(preg_match("/@Module\((.*)\)/s", $docComment, $matches)){
                if(!empty($matches[1])){
                    $matches[1] = preg_replace("/[\*]+/","", $matches[1]);
                    $config = json_decode($matches[1],true);
                    if($config!==null){
                        $this->configure($config);
                    }
                }
            }
        }
    }

    protected function configure($config){
        if(isset($config["controllers"]) && isset($config["providers"])){
            if(count($config["controllers"]) == count($config['providers'])){
                foreach($config["controllers"] as $controllerClass){
                    $this->assign($controllerClass,"Controller");
                }
                
                foreach($config["providers"] as $providerClass){
                    $this->assign($providerClass,"Service");
                }
                
                $this->instantiate();
            }
            else{
                throw new \Exception("Each Controller Class Must have an Service Class");
            }
        }

    }

    private function assign($class,$type){
        $class = str_replace("::class","", $class);
        $fully_qualified_class_name  = "App\\$class";       
        switch($type){
            case "Controller": $this->controllers[] = $fully_qualified_class_name; break;
            case "Service": $this->providers[] = $fully_qualified_class_name; break;
        }
    }

    private function instantiate(){
        for($i= 0;$i<count($this->controllers);$i++){
            $this->controller = new $this->controllers[$i](new $this->providers[$i]);
        }
    }
}