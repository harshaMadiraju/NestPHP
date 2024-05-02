<?php

namespace App;

use NestPHP\Common\BaseModule;

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