<?php


namespace App\Cats;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CatsSchema {

    private $capsule;

    public function __construct($capsule){
        $this->capsule = $capsule;
        $schema = $this->capsule->schema();
        if (!$schema->hasTable('cats')) {
            $this->capsule->schema()->create('cats', function (Blueprint $table) {
                $table->increments('id');
                $table->string('cat_name');
                $table->timestamps();
            });
        }
    }

    public function drop(){
        if (Schema::hasTable('cats')) {
            Schema::drop('cats');
        }
    }
}