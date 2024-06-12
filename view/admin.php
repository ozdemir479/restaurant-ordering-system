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
  <title>Yönetici Paneli</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
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

<div id="container" class="container mt-4">
  <h2><?= $siteTitle ?> | Yönetici Paneli</h2>
  <p><?= $siteTitle ?> Yönetim Paneline Hoş Geldiniz Sayın <b><?= $_SESSION['username'] ?></b>,<br> Yukarı tarafta gördüğünüz seçeneklerden yapmak istediğiniz işleme göre istediğiniz sayfaya girip işleminizi gerçekleştirebilirsiniz.</p>

</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
