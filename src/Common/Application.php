<?php

namespace NestPHP\Common;
use NestPHP\Database\Connection;
use NestPHP\Database\Schema;
use NestPHP\Routing\Router;
use ReflectionClass;

class Application {
    protected $controllers = [];
    protected $providers = [];

    private $router;
    private $db;

    public function __construct() {
        // Read and parse annotations for all modules
        $this->readAndParseAnnotations();
        $this->router = new Router();
        $this->router->registerRoutes($this->controllers,$this->providers);
        
        $this->db = new Connection();
        $this->db->bootEloquent();
        $this->registerSchemas();
    }

    private function readAndParseAnnotations() {
        // Directory where modules are located
        $modulesDirectory = __DIR__ . '/../../app';

        // Scan module directories
        $moduleFolders = scandir($modulesDirectory);
        foreach ($moduleFolders as $folder) {
            if ($folder !== '.' && $folder !== '..' && is_dir("$modulesDirectory/$folder")) {
               $namespace_suffix = $folder;
                // Look for module files within the directory folder
                // Because all modules must be specied as NameModule.php
                $moduleFiles = glob("$modulesDirectory/$folder/*Module*.php");
                foreach ($moduleFiles as $file) {
                    $className = basename($file,".php");
                    $className = "\\App\\$namespace_suffix\\$className";
                    $reflectionClass = new ReflectionClass($className);
                    $docComment = $reflectionClass->getDocComment();
                    if($docComment){
                        if(preg_match("/@Module\((.*)\)/s", $docComment, $matches)){
                            if(!empty($matches[1])){
                                $matches[1] = preg_replace("/[\*]+/","", $matches[1]);
                                $config = json_decode($matches[1],true);
                                if($config!==null){
                                    $this->configureModuleRegistration($config,"\\App\\$namespace_suffix\\");
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    private function configureModuleRegistration(array $config,string $namespace) {
        if (isset($config["controllers"]) && isset($config["providers"])) {
            // Merge controllers and providers from config
            $this->controllers = array_merge($this->controllers,array_map(function($x) use($namespace){ return $namespace.str_replace("::class","",$x); }, $config["controllers"]));
            $this->providers = array_merge($this->providers, array_map(function($x) use($namespace){ return $namespace.str_replace("::class","",$x); }, $config["providers"]));
        }
    }

    public function handleRequest(string $method, string $path): mixed {
        return $this->router->handleRequest($method, $path);
    }

    private function registerSchemas()
    {
        $schema = new Schema($this->db->getCapsule());
        $schema->registerSchemas();
    }
}