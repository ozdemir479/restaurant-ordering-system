<?php
require_once("models/Cache.php");
class test{
    public static function test(){
        Cache::write('example', 'Hello, world!');
        echo Cache::read('example'); // Hello, world!

    }
}