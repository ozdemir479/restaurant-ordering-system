<?php
include("./routes/class.php");
include("./controllers/TestController.php");
use TestController\TestController;
// Örnek bir GET route tanımlama
Route::get('/', function () {
    echo "Ana sayfa";
});

// Örnek bir POST route tanımlama
Route::get('/user', ['TestController', 'index']);


Route::get('/open-file', function () {
    $dosya_icerik = file_get_contents('view/index.php');
    echo $dosya_icerik;
});


Route::dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);


