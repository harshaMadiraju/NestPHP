<?php

namespace App\Cats;
use NestPHP\Http\Response;

class CatsService{
    public function meow(){
        Response::error('Meow From the service');
    }
}