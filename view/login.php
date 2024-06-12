<?php
session_start();
$siteInfo = MainController::getSiteInfo();
$siteTitle = $siteInfo['siteTitle'];
if(@$_SESSION['username']){
    header("Location: /admin/dashboard");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $siteTitle ?> | Yönetici Paneli</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            background-color: #f8f9fa;
        }
        .login-container {
            color: #FFAEFF;
            background-color: #87308E;
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .login-container h2 {
            margin-bottom: 20px;
            text-align: center;
        }
        .login-container input {
            color: #FFAEFF;
            background-color: #4B1E52;
            border-color: #E677E4;
        }
        .login-container input.focused{
            color: #FFAEFF;
        }
        .login-container input:focus {
            background-color: #4B1E52;
        }
        .login-container input::placeholder {
            color: #FFAEFF;
        }
        .login-container button {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            background-color: #EC85EE; /* Varsayılan arka plan rengi */
            color: #fff; /* Varsayılan metin rengi */
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.2s ease;
        }
        .login-container button:hover {
            background-color: #D56ED1;
        }
        .login-container button:active {
            background-color: #9A3A97;
        }
        .video-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: -1;
        }

        .video-container video {
            position: absolute;
            top: 0;
            left: 0;
            min-width: 100%;
            min-height: 100%;
        }

    </style>
</head>
<body>
<div class="video-container">
        <video autoplay loop muted>
            <source src="/assets/videos/background.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>
        <!-- Diğer içerikler buraya gelebilir -->
    </div>
<div class="container mt-5">
    <div class="login-container">
        <h2>Giriş</h2>
        <form id="loginForm">
            <div class="mb-3">
                <label for="username" class="form-label">Kullanıcı Adı</label>
                <input type="text" onfocus="this.style.color = '#FFAEFF'" onblur="if(this.value==''){this.style.color = '#FFAEFF'}" class="form-control" id="username" autocomplete="username" placeholder="Kullanıcı Adı">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Şifre</label>
                <input type="password" onfocus="this.style.color = '#FFAEFF'" onblur="if(this.value==''){this.style.color = '#FFAEFF'}" class="form-control" id="password" autocomplete="current-password" placeholder="Şifre">
            </div>
            <div class="mb-3">
                <label for="captcha" class="form-label">Captcha</label><br>
                <img src="/captcha/captcha.php" class="rounded mx-auto" alt="captcha"><br><br>
                <input type="text" onfocus="this.style.color = '#FFAEFF'" onblur="if(this.value==''){this.style.color = '#FFAEFF'}" class="form-control" id="captcha" placeholder="Doğrulama Kodunu Girin">
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="remember">
                <label class="form-check-label" for="remember">Beni Hatırla</label>
            </div>
            <button type="button" id="loginButton">Giriş Yap</button>
        </form>
    </div>
</div>

<script>
    $(document).ready(function(){
        $("#loginButton").click(function(){
            var username = $("#username").val();
            var password = $("#password").val();
            var captcha = $("#captcha").val();

            $.ajax({
                type: "GET",
                url: "/api/login",
                contentType: "application/json",
                data: "username=" + username + "&password=" + password + "&captcha=" + captcha,
                success: function(response){
                    if (response.status === true) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Başarılı!',
                            text: 'Giriş başarılı.',
                        });
                        setInterval(function () {
                            window.location.href = "/admin/dashboard";
                        }, 2000);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Hata!',
                            text: response.message,
                        });
                    }
                },
                error: function(){
                    Swal.fire({
                        icon: 'error',
                        title: 'Hata!',
                        text: 'Kullanıcı Adı Veya Şifre Hatalı',
                    });
                }
            });
        });
    });
</script>

</body>
</html>
