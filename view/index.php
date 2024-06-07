<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <title>droplet | POS - Customer Order System</title>
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="description" content>
      <meta name="author" content>
      <link href="assets/css/vendor.min.css" rel="stylesheet">
      <link href="assets/css/app.min.css" rel="stylesheet">
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
                           <div class="logo-img"><?php
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
                              $categories = MenuHandler::getCategories();
                              foreach($categories as $category):
                              ?> 
                              <li class="nav-item">
                                 <a class="nav-link" href="#" data-filter="<?= $category['categorySlug'] ?>">
                                 <i class="<?= $category['categoryFA'] ?> "></i> <?= $category['categoryName'] ?> 
                                 </a>
                              </li>
                              <?php endforeach; ?> 
                           </ul>
                        </div>
                     </div>
                     <div id="messageBox" class="message-box">
                        <div class="message-content">
                           <span class="close" id="closeButton">&times;</span>
                           <h2>Yeni Mesaj</h2>
                           <p> <!-- Jsden gelecek mesaj --> </p>
                        </div>
                     </div>
                  </div>
                  
                  <div class="pos-content">
                     <div class="pos-content-container h-100">
                        <div class="row gx-4">
                           <?php
                           $menus = MenuHandler::getMenus();
                           foreach($menus as $menu):
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
                                             if(@$menu['productSize'] == 2):
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
                                             <?php
                                             endif;
                                             ?> 
                                          </div>
                                          <div class="mb-2">
                                             <div class="fw-bold">Add On:</div>
                                             <div class="option-list">
                                                <div class="option">
                                                   <input type="checkbox" name="addon[sos]" value="true" class="option-input" id="<?= $menu['id'] ?>_addon1">
                                                   <label class="option-label" for="<?= $menu['id'] ?>_addon1">
                                                   <span class="option-text">More BBQ sos</span>
                                                   <span class="option-price">+0.00</span>
                                                   </label>
                                                </div>
                                                <div class="option">
                                                   <input type="checkbox" name="addon[ff]" value="true" class="option-input" id="<?= $menu['id'] ?>_addon2">
                                                   <label class="option-label" for="<?= $menu['id'] ?>_addon2">
                                                   <span class="option-text">Extra french fries</span>
                                                   <span class="option-price">+1.00</span>
                                                   </label>
                                                </div>
                                                <div class="option">
                                                   <input type="checkbox" name="addon[ms]" value="true" class="option-input" id="<?= $menu['id'] ?>_addon3">
                                                   <label class="option-label" for="<?= $menu['id'] ?>_addon3">
                                                   <span class="option-text">Mushroom soup</span>
                                                   <span class="option-price">+3.50</span>
                                                   </label>
                                                </div>
                                                <div class="option">
                                                   <input type="checkbox" name="addon[ms]" value="true" class="option-input" id="<?= $menu['id'] ?>_addon4">
                                                   <label class="option-label" for="<?= $menu['id'] ?>_addon4">
                                                   <span class="option-text">Lemon Juice (set)</span>
                                                   <span class="option-price">+2.50</span>
                                                   </label>
                                                </div>
                                             </div>
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
                           <script>


                           </script>
                           <?php endforeach; ?> 
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
                              <div class="title">
                              <?php 
                              $tableNumber = (int) @$_POST['masa'];
                              $tableNumber = str_pad($tableNumber, 2, "0", STR_PAD_LEFT);
                              echo "Masa ".$tableNumber;
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
                                    <button type="submit" class="btn btn-theme flex-fill d-flex align-items-center justify-content-center">
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
         <div class="app-theme-panel">
            <div class="app-theme-panel-container">
               <a href="javascript:;" data-toggle="theme-panel-expand" class="app-theme-toggle-btn"><i class="bi bi-sliders"></i></a>
               <div class="app-theme-panel-content">
                  <div class="fw-bold text-body mb-2">
                     Theme Color
                  </div>
                  <div class="app-theme-list">
                     <div class="app-theme-list-item"><a href="javascript:;" class="app-theme-list-link bg-pink" data-theme-class="theme-pink" data-toggle="theme-selector" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-container="body" data-bs-title="Pink"></a></div>
                     <div class="app-theme-list-item"><a href="javascript:;" class="app-theme-list-link bg-red" data-theme-class="theme-red" data-toggle="theme-selector" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-container="body" data-bs-title="Red"></a></div>
                     <div class="app-theme-list-item"><a href="javascript:;" class="app-theme-list-link bg-warning" data-theme-class="theme-warning" data-toggle="theme-selector" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-container="body" data-bs-title="Orange"></a></div>
                     <div class="app-theme-list-item"><a href="javascript:;" class="app-theme-list-link bg-yellow" data-theme-class="theme-yellow" data-toggle="theme-selector" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-container="body" data-bs-title="Yellow"></a></div>
                     <div class="app-theme-list-item"><a href="javascript:;" class="app-theme-list-link bg-lime" data-theme-class="theme-lime" data-toggle="theme-selector" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-container="body" data-bs-title="Lime"></a></div>
                     <div class="app-theme-list-item"><a href="javascript:;" class="app-theme-list-link bg-green" data-theme-class="theme-green" data-toggle="theme-selector" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-container="body" data-bs-title="Green"></a></div>
                     <div class="app-theme-list-item"><a href="javascript:;" class="app-theme-list-link bg-teal" data-theme-class="theme-teal" data-toggle="theme-selector" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-container="body" data-bs-title="Teal"></a></div>
                     <div class="app-theme-list-item"><a href="javascript:;" class="app-theme-list-link bg-info" data-theme-class="theme-info" data-toggle="theme-selector" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-container="body" data-bs-title="Cyan"></a></div>
                     <div class="app-theme-list-item active"><a href="javascript:;" class="app-theme-list-link bg-primary" data-theme-class data-toggle="theme-selector" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-container="body" data-bs-title="Default"></a></div>
                     <div class="app-theme-list-item"><a href="javascript:;" class="app-theme-list-link bg-purple" data-theme-class="theme-purple" data-toggle="theme-selector" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-container="body" data-bs-title="Purple"></a></div>
                     <div class="app-theme-list-item"><a href="javascript:;" class="app-theme-list-link bg-indigo" data-theme-class="theme-indigo" data-toggle="theme-selector" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-container="body" data-bs-title="Indigo"></a></div>
                     <div class="app-theme-list-item"><a href="javascript:;" class="app-theme-list-link bg-gray-200" data-theme-class="theme-gray-500" data-toggle="theme-selector" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-container="body" data-bs-title="Gray"></a></div>
                  </div>
                  <hr class="opacity-1">
                  <div class="row mt-10px">
                     <div class="col-8">
                        <div class="fw-bold text-body d-flex mb-1 align-items-center">
                           Dark Mode
                           <i class="bi bi-moon-fill ms-2 my-n1 fs-5 text-body text-opacity-25"></i>
                        </div>
                        <div class="lh-sm">
                           <small class="text-body opacity-50">Adjust the appearance to reduce glare and give your eyes a break.</small>
                        </div>
                     </div>
                     <div class="col-4 d-flex">
                        <div class="form-check form-switch ms-auto mb-0">
                           <input type="checkbox" class="form-check-input" name="app-theme-dark-mode" data-toggle="theme-dark-mode" id="appThemeDarkMode" value="1">
                           <label class="form-check-label" for="appThemeDarkMode"></label>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <a href="#" data-toggle="scroll-to-top" class="btn-scroll-top fade"><i class="fa fa-arrow-up"></i></a>
      </div>



      <script src="assets/js/custom.js"></script>
      <script src="assets/js/vendor.min.js" type="f557d77c454a941eb67815a2-text/javascript"></script>
      <script src="assets/js/app.min.js" type="f557d77c454a941eb67815a2-text/javascript"></script>
      <script src="assets/js/demo/pos-customer-order.demo.js" type="f557d77c454a941eb67815a2-text/javascript"></script>

      <script async src="https://www.googletagmanager.com/gtag/js?id=UA-53034621-1" type="f557d77c454a941eb67815a2-text/javascript"></script>
      <script src="../cdn-cgi/scripts/7d0fa10a/cloudflare-static/rocket-loader.min.js" data-cf-settings="f557d77c454a941eb67815a2-|49" defer></script>
   </body>
</html>