<?php

namespace App;

class CatsController{

    private $service;

    public function __construct($service){
        $this->service = $service;
    }

    public function meow(){
        $this->service->meow();
    }
}