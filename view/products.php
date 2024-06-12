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
  <!-- DataTables CSS -->
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap5.min.css">
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
          <a class="nav-link" href="#">Çıkış Yap</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<div id="container" class="container mt-4">
  <h2><?= $siteTitle ?> | Yönetici Paneli</h2>
  <p><?= $siteTitle ?> Yönetim Paneline Hoş Geldiniz Sayın <b><?= $_SESSION['username'] ?></b>,<br> Yukarıdaki menüden yapmak istediğiniz işleme göre istediğiniz sayfaya girip işleminizi gerçekleştirebilirsiniz.</p>

  <div class="table-responsive">
    <table id="productTable" class="table table-striped table-bordered">
      <thead>
        <tr>
          <th>ID</th>
          <th>Ürün Adı</th>
          <th>Açıklama</th>
          <th>Fiyat</th>
          <th>Boyutlar</th>
          <th>Kategori</th>
          <th>Oluşturulma Tarihi</th>
          <th>Resim</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $apiURL = $siteInfo['siteURL'].'/api/getProducts';
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $apiURL,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
        ));
        $response = json_decode(curl_exec($curl), true);
        $err = curl_error($curl);
        curl_close($curl);
        if($response['status'] == true){
          foreach ($response['data'] as $product) {
        ?> 
          <tr>
            <td><?= $product['id'] ?></td>
            <td><?= $product['productName'] ?></td>
            <td><?= $product['productDesc'] ?></td>
            <td><?= $product['productPrice'] ?></td>
            <td><?= $product['productSize'] ?></td>
            <td><?= $product['categoryName'] ?></td>
            <td><?= $product['product_created_at'] ?></td>
            <td><img style="max-width: 100px; height: auto;" src="../<?=$product['productImage']?>" alt="Ürün Resmi"></td>
          </tr>
        <?php
          }
        }
        ?> 
      </tbody>
    </table>
  </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- DataTables JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap5.min.js"></script>
<script>
$(document).ready(function() {
  $('#productTable').DataTable({
    "language": {
      "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Turkish.json"
    }
  });
});
</script>
</body>
</html>
