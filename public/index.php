<?php

use NestPHP\Common\BaseModule;
require_once "../vendor/autoload.php";

/**
 * @Module({
 *  "controllers":["CatsController::class"],
 *  "providers":["CatsService::class"]
 * })
 */
class CatsModule extends BaseModule{
    public function __construct(){
        parent::__construct();
    }
    public function meow(){
        return $this->controller->meow();
    }
}

$cat = new CatsModule();
$cat->meow();