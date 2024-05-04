<?php

namespace NestPHP\Database;
use Illuminate\Database\Capsule\Manager as Capsule;


class Connection{

    private $capsule;
    
    public function __construct() {
        $this->capsule = new Capsule;

        $this->capsule->addConnection([
            'driver'    => 'mysql',
            'host'      => 'localhost',
            'database'  => 'nest_php',
            'username'  => 'root',
            'password'  => '',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ]);

        // Make Eloquent use the Capsule Manager
        $this->capsule->setAsGlobal();

    }

    public function bootEloquent()
    {
        // Boot Eloquent after the connection is set up
        $this->capsule->bootEloquent();
    }

    public function getCapsule()
    {
        return $this->capsule;
    }


}