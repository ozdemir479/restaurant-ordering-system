<?php
use Models\DB;
class Admin{
    public static function login(){
        session_start();
        $username = DB::filter(@$_GET['username']);
        $password = DB::filter(@$_GET['password']); 
        $captcha = DB::filter(@$_GET['captcha']); 

        
        $sql = DB::table("users")->where("username", $username)->first();
        if($sql){
            if($captcha === $_SESSION['captcha']){
                $hashed_password = $sql['password'];
            
                if(password_verify($password, $hashed_password)){
                    $_SESSION['username'] = $sql['username'];
                    $_SESSION['email'] = $sql['email'];
                    echo jsonKit::success("Giriş Başarılı", 200);
                    return true;
                    } else {
                    echo jsonKit::failWithoutHRC("Kullanıcı Adı Veya Şifre Hatalı");
                    return false;
                }
            } else {
                echo jsonKit::failWithoutHRC("Captcha Kodu Doğrulanamadı");
                return false;
            }
        } else {
            echo jsonKit::failWithoutHRC("Kullanıcı Adı Veya Şifre Hatalı");
            return false;
        }
    }

    public static function checkAuth(){
        session_start();
        if(!isset($_SESSION['username'])){
            self::logout();
        }
    }

    public static function logout(){
        session_start();
        session_destroy();
        header("Location: /admin/login");
        echo jsonKit::success("Çıkış Başarılı", 200);
        exit;
    }

    public static function getWaiters(){
        $sql = DB::table('waiterCalls')->get();
        jsonKit::json($sql, "Veri Bulundu", 200);
    }

    public static function insertWaiter(){
        $tableNumber = DB::filter(@$_POST['tableNumber']);
        try {
            if($tableNumber){
                $sql = DB::table('waiterCalls')->insert([
                    'tableNumber' => $tableNumber,
                ]);
                if($sql){
                    echo jsonKit::success("Kayıt Başarılı", 200);
                }
            } else {
                echo jsonKit::fail("Masa Numarası Gönderilmedi", 400);
            }

        } catch(Exception $e){
            echo jsonKit::fail($e->getMessage(), $e->getCode());
        }
    }
}
