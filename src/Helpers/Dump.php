<?php

namespace NestPHP\Helpers;

class Dump{
    public static function dd($data){
        $html='';
        $html.='<div class="" style="background-color:#000;color:#ffffff">';
        $html.='<pre>';
        var_dump($data);
        $html.='</pre>';
        
        echo $html;
    }
}