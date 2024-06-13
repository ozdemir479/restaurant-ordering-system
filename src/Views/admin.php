<?php
   $siteInfo = MainController::getSiteInfo();
   $siteTitle = $siteInfo['siteTitle'];
   Admin::checkAuth();
   ?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title><?= $siteTitle ?> | Yönetici Paneli</title>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">
      <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap5.min.css">
      <link rel="stylesheet" href="/assets/css/admin.css">
   </head>
   <body>
      <div id="notification" class="d-none">
        <div class="alert alert-info alert-dismissible fade show" role="alert">
         <div id="notificationText"></div>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      </div>
      <nav class="navbar navbar-expand-lg navbar-light">
         <div class="container-fluid">
            <a class="navbar-brand" href="#">Yönetici Paneli</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
               <ul class="navbar-nav">
                  <li class="nav-item">
                     <a class="nav-link" href="/admin/dashboard">Anasayfa</a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link" href="/admin/products">Ürünler</a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link" href="#">Kategoriler</a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link" href="#">Siparişler</a>
                  </li>
               </ul>
               <ul class="navbar-nav ms-auto">
                  <li class="nav-item">
                     <a class="nav-link" href="#">Ayarlar</a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link" href="/admin/logout">Çıkış Yap</a>
                  </li>
               </ul>
            </div>
         </div>
      </nav>
      <div class="video-container">
         <video autoplay loop muted>
            <source src="/assets/videos/background.mp4" type="video/mp4">
            Tarayıcınınız Video Oynatmayı Desteklemiyor.
         </video>
      </div>
      <div id="container" class="container mt-4">
         <div class="card">
            <div class="card-body">
               <h2><?= $siteTitle ?> | Yönetici Paneli</h2>
               <p><?= $siteTitle ?> Yönetim Paneline Hoş Geldiniz Sayın <b><?= $_SESSION['username'] ?></b>,<br> Yukarı tarafta gördüğünüz seçeneklerden yapmak istediğiniz işleme göre istediğiniz sayfaya girip işleminizi gerçekleştirebilirsiniz.</p>
               <div id="garsonCall"></div>
            </div>
         </div>
      </div>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
      <script src="/assets/js/javascript.php?file=ajax.js"></script>
      <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
      <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>
      <script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap5.min.js"></script>
      <script src="/assets/js/javascript.php?file=admin.js"></script>
      <script src="/assets/js/javascript.php?file=ajax.js"></script>
   </body>
</html>