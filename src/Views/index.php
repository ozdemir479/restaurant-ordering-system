<?php
$siteInfo = MainController::getSiteInfo();
$siteTitle = $siteInfo['siteTitle'];
?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <title><?= $siteTitle ?> | Sipariş</title>
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link href="../../assets/css/vendor.min.css" rel="stylesheet">
      <link href="../../assets/css/app.min.css" rel="stylesheet">
      <link rel="stylesheet" href="/assets/css/custom.css">
      <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
   </head>
   
   <body class="pace-top">
      <div id="app" class="app app-content-full-height app-without-sidebar app-without-header">
         <div id="content" class="app-content p-0">
            <div class="pos pos-with-menu pos-with-sidebar" id="pos">
               <div class="pos-container">   
                  <div class="pos-menu">
                     <div class="logo">
                        <a href="javascript:;">
                           <div class="logo-img">
                              <?php
                                 $siteInfo = MenuHandler::getSiteInfo();
                                 $siteLogoFA = $siteInfo['siteLogoFA'];
                                 $siteLogo = $siteInfo['siteLogo'];
                                 if($siteLogoFA){
                                    echo '<i class="'.$siteLogoFA.'"></i>';
                                 } else {
                                    echo '<img src="'.$siteLogo.'" alt="logo">';
                                 } 
                                 ?> 
                           </div>
                           <div class="logo-text">Pine & Dine</div>
                        </a>
                     </div>
                     <div class="nav-container">
                        <div class="h-100" data-scrollbar="true" data-skip-mobile="true">
                           <ul class="nav nav-tabs">
                              <li class="nav-item">
                                 <a class="nav-link active" href="#" data-filter="all">
                                 <i class="fa fa-fw fa-utensils"></i> Hepsi
                                 </a>
                              </li>
                              <?php
                                 $apiURL = 'http://'.$_SERVER['SERVER_NAME'].'/api/getCategories';
                                 
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
                                 foreach ($response['data'] as $category) {
                                 ?> 
                              <li class="nav-item">
                                 <a class="nav-link" href="#" data-filter="<?= $category['categorySlug'] ?>">
                                 <i class="<?= $category['categoryFA'] ?> "></i> <?= $category['categoryName'] ?> 
                                 </a>
                              </li>
                              <?php
                                 }}
                                 ?> 
                           </ul>
                        </div>
                     </div>
                     <div id="notification" class="d-none">
                          <div class="alert alert-info alert-dismissible fade show" role="alert">
                           <div id="notificationText"></div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                          </div>
                        </div>
                     </div>
                  <div class="pos-content">
                     <div class="pos-content-container h-100">
                        <div class="row gx-4">
                           <?php
                              $apiURL = 'http://'.$_SERVER['SERVER_NAME'].'/api/getProducts';
                              
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
                              foreach ($response['data'] as $menu) {
                              ?> 
                           <div class="col-xxl-3 col-xl-4 col-lg-6 col-md-4 col-sm-6 pb-4" data-type="<?= $menu['categorySlug'] ?>">
                              <a href="#" class="pos-product" data-bs-toggle="modal" data-bs-target="#product_<?= $menu['id'] ?>">
                                 <div class="img" style="background-image: url(<?= $menu['productImage'] ?>)"></div>
                                 <div class="info">
                                    <div class="title"><?= $menu['productName'] ?></div>
                                    <div class="desc"><?= $menu['productDesc'] ?></div>
                                    <div class="price"><?= $menu['productPrice'] ?> TL</div>
                                 </div>
                              </a>
                           </div>
                           <div class="modal modal-pos fade" id="product_<?= $menu['id'] ?>">
                              <div class="modal-dialog modal-lg">
                                 <div class="modal-content border-0">
                                    <a href="#" data-bs-dismiss="modal" class="btn-close position-absolute top-0 end-0 m-4"></a>
                                    <div class="modal-pos-product">
                                       <div class="modal-pos-product-img">
                                          <div class="img" style="background-image: url(<?= $menu['productImage'] ?>)"></div>
                                       </div>
                                       <div class="modal-pos-product-info">
                                          <div id="productName_<?= $menu['id'] ?>" class="fs-4 fw-semibold"><?= $menu['productName'] ?></div>
                                          <div class="text-body text-opacity-50 mb-2">
                                             <?= $menu['productDesc'] ?>
                                          </div>
                                          <div id="productPrice_<?= $menu['id'] ?>" class="fs-3 fw-bold mb-3"><?= $menu['productPrice'] ?> TL</div>
                                          <div class="d-flex mb-3">
                                             <a href="#" class="btn btn-secondary"><i class="fa fa-minus"></i></a>
                                             <input type="text" class="form-control w-50px fw-bold mx-2 text-center" name="qty" value="1">
                                             <a href="#" class="btn btn-secondary"><i class="fa fa-plus"></i></a>
                                          </div>
                                          <hr class="opacity-1">
                                          <div class="mb-2">
                                             <?php 
                                                if($menu['productSize'] == 2):
                                                ?> 
                                             <div class="fw-bold">Boy:</div>
                                             <div class="option-list">
                                                <div class="option">
                                                   <input type="radio" id="<?= $menu['id'] ?>_size3" name="<?= $menu['id'] ?>_size" class="option-input" checked>
                                                   <label class="option-label" for="<?= $menu['id'] ?>_size3">
                                                   <span class="option-text">Küçük</span>
                                                   <span class="option-price">+<?= $menu['productSmall'] ?></span>
                                                   </label>
                                                </div>
                                                <div class="option">
                                                   <input type="radio" id="<?= $menu['id'] ?>_size2" name="<?= $menu['id'] ?>_size" class="option-input">
                                                   <label class="option-label" for="<?= $menu['id'] ?>_size2">
                                                   <span class="option-text">Orta</span>
                                                   <span class="option-price">+<?= $menu['productMedium'] ?></span>
                                                   </label>
                                                </div>
                                                <div class="option">
                                                   <input type="radio" id="<?= $menu['id'] ?>_size1" name="<?= $menu['id'] ?>_size" class="option-input">
                                                   <label class="option-label" for="<?= $menu['id'] ?>_size1">
                                                   <span class="option-text">Büyük</span>
                                                   <span class="option-price">+<?= $menu['productLarge'] ?></span>
                                                   </label>
                                                </div>
                                             </div>
                                             <?php endif; ?> 
                                          </div>
                                          <div class="mb-2">
                                             <?php
                                                $apiURL = 'http://'.$_SERVER['SERVER_NAME'].'/api/getAddons?product='.$menu['id'];
                                                                  
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
                                                echo '<div class="fw-bold">Ekstra:</div>';
                                                echo '<div class="option-list">';
                                                foreach ($response['data'] as $addon) {
                                                ?>       
                                             <div class="option">
                                                <input type="checkbox" name="addon[<?= $addon['addon'] ?>]" value="true" class="option-input" id="<?= $addon['id'] ?>_addon">
                                                <label class="option-label" for="<?= $addon['id'] ?>_addon">
                                                <span class="option-text"><?= $addon['addon'] ?></span>
                                                <span class="option-price">+<?= $addon['addonPrice'] ?></span>
                                                </label>
                                             </div>
                                             <?php
                                                }
                                                echo '</div>';
                                                };
                                                ?>
                                          </div>
                                          <hr class="opacity-1">
                                          <div class="row">
                                             <div class="col-4">
                                                <a href="#" class="btn btn-default fw-semibold mb-0 d-block py-3" data-bs-dismiss="modal">Cancel</a>
                                             </div>
                                             <div class="col-8">
                                                <button onclick="addToCart(<?= $menu['id'] ?>, <?= $menu['productPrice'] ?>, '<?= $menu['productName'] ?>', '<?= $menu['productImage'] ?>', '<?= $menu['productDesc'] ?>')" id="addToCart" class="btn btn-theme fw-semibold d-flex justify-content-center align-items-center py-3 m-0 add-to-cart">Add to cart <i class="fa fa-plus ms-2 my-n3"></i></button>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <?php
                              }}
                              ?> 
                        </div>
                     </div>
                     
                  </div>
                  <div class="pos-sidebar" id="pos-sidebar">
                     <div class="h-100 d-flex flex-column p-0">
                        <div class="pos-sidebar-header">
                           <div class="back-btn">
                              <button type="button" data-toggle-class="pos-mobile-sidebar-toggled" data-toggle-target="#pos" class="btn">
                              <i class="fa fa-chevron-left"></i>
                              </button>
                           </div>
                           <div class="icon"><i class="fa fa-plate-wheat"></i></div>
                           <div id="tableNumber" class="title">
                              Masa 
                              <?php 
                              $tableNumber = (int) @$_GET['masa'];
                              $tableNumber = str_pad($tableNumber, 2, "0", STR_PAD_LEFT);
                              echo $tableNumber;
                              ?> 
                           </div>
                           <div class="order small">Sipariş</div>
                        </div>
                        <div class="pos-sidebar-nav small">
                           <ul class="nav nav-tabs nav-fill">
                              <li class="nav-item">
                                 <a class="nav-link active" href="#" data-bs-toggle="tab" data-bs-target="#newOrderTab">Yeni Sipariş</a>
                              </li>
                           </ul>
                        </div>
                        <div class="pos-sidebar-body tab-content" data-scrollbar="true" data-height="100%">
                           <form method="POST">
                              <div class="tab-pane fade h-100 show active" id="newOrderTab">
                                 <!-- Products -->
                              </div>
                        </div>
                        <div class="pos-sidebar-footer">
                        <div class="d-flex align-items-center mb-2">
                        <div>Toplam</div>
                        <div class="flex-1 text-end h4 mb-0"> <span id="totalPrice">0</span> TL</div>
                        </div>
                        <div class="mt-3">
                        <div class="d-flex">
                        <button href="#" id="garson" class="btn btn-default w-125px me-10px d-flex align-items-center justify-content-center">
                        <span>
                        <i class="fa fa-bell fa-lg my-10px d-block"></i>
                        <span class="small fw-semibold">Garson Çağır</span>
                        </span>
                        </button>
                        <button type="submit" id="order" class="btn btn-theme flex-fill d-flex align-items-center justify-content-center">
                        <span>
                        <i class="fa fa-cash-register fa-lg my-10px d-block"></i>
                        <span class="small fw-semibold">Sipariş Ver</span>
                        </span>
                        </button>
                        </div>
                        </div>
                        </div>
                        </form>
                     </div>
                  </div>
               </div>
            </div>
            <a href="#" class="pos-mobile-sidebar-toggler" data-toggle-class="pos-mobile-sidebar-toggled" data-toggle-target="#pos">
            <i class="fa fa-shopping-bag"></i>
            <span class="badge">0</span>
            </a>
         </div>
         <a href="#" data-toggle="scroll-to-top" class="btn-scroll-top fade"><i class="fa fa-arrow-up"></i></a>
      </div>

      <script src="/assets/js/javascript.php?file=custom.js"></script>
      <script src="/assets/js/javascript.php?file=vendor.min.js" type="f557d77c454a941eb67815a2-text/javascript"></script>
      <script src="/assets/js/javascript.php?file=app.min.js" type="f557d77c454a941eb67815a2-text/javascript"></script>
      <script src="/assets/js/javascript.php?file=rocket-loader.min.js" data-cf-settings="f557d77c454a941eb67815a2-|49" defer></script>
   </body>
</html>