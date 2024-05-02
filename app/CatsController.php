<?php

namespace App;

use NestPHP\Routing\Route;

#[Route(method: 'GET', path: '/cats')]
class CatsController{

    private $service;

    public function __construct($service){
        $this->service = $service;
    }

    #[Route(method: 'GET', path: '/meow')]
    public function meow(){
        $this->service->meow();
    }
}