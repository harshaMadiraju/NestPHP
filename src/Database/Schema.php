<?php

namespace NestPHP\Database;

use ReflectionClass;

class Schema{

    private $capsule;

    public function __construct($capsule)
    {
        $this->capsule = $capsule;
    }
    
    public function registerSchemas(){
        // Directory where schemas are located
        $schemasDirectory = __DIR__ . '/../../app';

        // Scan Schema directories
        $SchemaFolders = scandir($schemasDirectory);
        foreach ($SchemaFolders as $folder) {
            if ($folder !== '.' && $folder !== '..' && is_dir("$schemasDirectory/$folder")) {
               $namespace_suffix = $folder;
                // Look for Schema files within the directory folder
                // Because all schemas must be specied as NameSchema.php
                $SchemaFiles = glob("$schemasDirectory/$folder/*Schema*.php");
                foreach ($SchemaFiles as $file) {
                    $className = basename($file,".php");
                    $className = "\\App\\$namespace_suffix\\$className";
                    $dummy = new $className($this->capsule);
                }
            }
        }
    }
}