<?php

class TestController {
    public function index(){
        echo file_get_contents("view/index.php");
    }
}