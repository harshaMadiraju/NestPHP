<?php

namespace App\Cats;

use NestPHP\Routing\Attributes\Get;
use NestPHP\Routing\Attributes\Route;


#[Route('/cats')]
class CatsController{

    private $service;

    public function __construct($service){
        $this->service = $service;
    }

    #[Get('/meow')]
    public function meow(){
        $this->service->meow();
    }
}