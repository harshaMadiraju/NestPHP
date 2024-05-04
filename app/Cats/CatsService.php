<?php

namespace App\Cats;

use NestPHP\Http\Response;

class CatsService{
    private $repository;

    public function __construct(){
        $this->repository = new CatsEntity();
    }

    public function meow(){
        $data = $this->repository->all()->toArray();
        Response::ok('Meow From the service',$data);
    }
}