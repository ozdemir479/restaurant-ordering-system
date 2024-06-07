<?php
include("./routes/class.php");
include("./controllers/TestController.php");
include("./controllers/MenuHandler.php");

Route::get('/', function () {
    echo "Ana sayfa";
});

Route::get('/user', ['MenuHandler', 'getMenus']);
Route::get('/test', ['MenuHandler', 'getMenusTest']);

Route::get('/menu', function () {
    include("./view/index.php");
});
Route::post('/menu', function () {
    include("./view/index.php");
});

Route::dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);