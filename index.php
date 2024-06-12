<?php
include("./routes/class.php");
include("./controllers/MainController.php");
include("./controllers/MenuHandler.php");
include("./controllers/testcontroller.php");
include("./controllers/AdminController.php");
$siteInfo = MainController::getSiteInfo();
$route = new Route('');

$route->get('/menu', function () {
    include("./view/index.php");
});

$route->get('/test', ['test', 'test']);
Route::group('/admin', function($router) {
    $router->get('/dashboard', function () {
        include("./view/admin.php");
    });
    $router->get('/products', function () {
        include("./view/products.php");
    });
    $router->get('/login', function () {
        include("./view/login.php");
    });
    $router->get('/logout', ['admin', 'logout']);
});

Route::group('/user', function($router) {
    $router->get('/profile', function () {
        echo 'Kullanıcı profili';
    });

    $router->post('/update', function () {
        echo 'Kullanıcı bilgileri güncellendi';
    });

    $router->post('/login', function () {
        include("./view/login.php");
    });
});

Route::group('/api', function($router) {

    $router->get('', function (){
        echo "API STATUS => ONLINE";
    });

    $router->get('/', function (){
        echo "API STATUS => ONLINE";
    });

    $router->get('/captcha', function (){
        include("./captcha/captcha.php");
    });

    $router->get('/getProducts', ['MenuHandler', 'listProducts']);

    $router->get('/login', ['Admin', 'login']);

    $router->get('/getCategories', ['MenuHandler', 'listCategories']);

    $router->get('/getAddons', ['MenuHandler', 'listAddons']);

});

Route::dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);