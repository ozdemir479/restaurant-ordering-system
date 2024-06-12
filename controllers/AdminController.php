<?php
use Table\DB;
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
                    echo jsonKit::failWithoutHRC("Kullanıcı Adı Veya Şifre Hatalı", 400);
                    return false;
                }
            } else {
                echo jsonKit::failWithoutHRC("Captcha Kodu Doğrulanamadı");
                return false;
            }
        } else {
            echo jsonKit::failWithoutHRC("Kullanıcı Adı Veya Şifre Hatalı", 400);
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
}
?>
