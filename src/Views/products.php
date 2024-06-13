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
  <p><?= $siteTitle ?> Yönetim Paneline Hoş Geldiniz Sayın <b><?= $_SESSION['username'] ?></b>,<br> Yukarıdaki menüden yapmak istediğiniz işleme göre istediğiniz sayfaya girip işleminizi gerçekleştirebilirsiniz.</p>
  <button class="button w-50" data-bs-toggle="modal" data-bs-target="#addProductModal">Ürün Ekle</button>


  <div class="table-responsive">
    <table class="table table-striped ">
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
            <td><?= $product['productPrice'] ?> TL</td>
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
  </div>
    <div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
          </div>
        <div class="modal-body">
            <div class="row justify-content-center">
              <div class="col-lg-8">
                    <h5 class="card-title text-center mb-4">Ürün Ekle</h5>
                    <form method="POST">
                      <div class="row mb-3">
                        <div class="col">
                          <label for="productName" class="form-label">Ürün Adı</label>
                          <input type="text" id="productName" name="productName" class="form-control">
                        </div>
                        <div class="col">
                          <label for="productDesc" class="form-label">Ürün Açıklaması</label>
                          <input type="text" id="productDesc" name="productDesc" class="form-control">
                        </div>
                        <div class="col">
                          <label for="productPrice" class="form-label">Ürün Fiyatı</label>
                          <input type="text" id="productPrice" name="productPrice" class="form-control">
                        </div>
                        <div class="col">
                          <label for="productSize" class="form-label">Ürün Boyutu</label>
                          <select name="productSize" class="form-select" id="productSize">
                            <option value="0">Tek Boyut</option>
                            <option value="1">Büyük - Küçük</option>
                            <option value="2">Büyük - Orta - Küçük</option>
                          </select>
                        </div>
                      </div>
                      <div class="row mb-3">
                        <div class="col">
                          <label for="productSmallPrice" class="form-label">Küçük Boyutta Eklenecek Fiyat</label>
                          <input type="text" id="productSmallPrice" name="productSmallPrice" class="form-control">
                        </div>
                        <div class="col">
                          <label for="productMediumPrice" class="form-label">Orta Boyutta Eklenecek Fiyat</label>
                          <input type="text" id="productMediumPrice" name="productMediumPrice" class="form-control">
                        </div>
                        <div class="col">
                          <label for="productLargePrice" class="form-label">Büyük Boyutta Eklenecek Fiyat</label>
                          <input type="text" id="productLargePrice" name="productLargePrice" class="form-control">
                        </div>
                        <dv class="col">
                          <label for="productCategory" class="form-label">Ürün Kategorisi</label>
                          <select name="productCategory" id="productCategory" class="form-select">
                            <!-- Kategori Seçenekleri -->
                          </select>
                        </div>
                      </div>
                      <div class="row mb-3">
                        <div class="col">
                          <label for="productImage" class="form-label">Ürün Resmi</label>
                          <input type="file" id="productImage" name="productImage" class="form-control">
                        </div>
                      </div>
                      <div class="text-center">
                        <button type="submit" class="btn btn-primary">Ürünü Ekle</button>
                      </div>
                    </form>
                  </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="/assets/js/javascript.php?file=ajax.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap5.min.js"></script>
<script src="/assets/js/javascript.php?file=admin.js"></script>

</body>
</html>




