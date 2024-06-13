<?php

require_once("models/DB.php");
require_once("jsonKit.php");
require_once("models/Cache.php");

use Table\DB;

class MenuHandler{
    public static function getMenus(){
        $results = DB::table('products')
            ->select(['products.id', 'products.productName', 'products.productSize', 'products.productSmall', 'products.productMedium', 'products.productLarge', 'products.productPrice', 'products.productDesc', 'products.productImage', 'categories.categorySlug', 'categories.categorySlug'])
            ->join('categories', 'productCategory', '=', 'id') 
            ->get();


        return $results;
    }

    public static function getCategories(){
        $sql = DB::table("categories")->get();
        return $sql;
    }

    public static function getAddons($id){
        $cachedAddons = Cache::read('addons_' . $id);
        if ($cachedAddons !== false) {
            return $cachedAddons;
        }

        $addons = self::getList("productaddons", $id, "productId");
        Cache::write('addons_' . $id, $addons);

        return $addons;
    }

    public static function listProducts(){
        $results = DB::table('products')
        ->select([
            'products.id', 'products.productName', 'products.productSize', 
            'products.productSmall', 'products.productMedium', 'products.productLarge', 
            'products.productPrice', 'products.productDesc', 'products.productImage', 'categories.categoryName',
            'products.created_at AS product_created_at', 'products.updated_at AS product_updated_at', 
            'products.deleted_at AS product_deleted_at', 
            'categories.categorySlug',
        ])
        ->join('categories', 'productCategory', '=', 'id') 
        ->get();
    
    jsonKit::json($results, 200);
    
    }

    public static function listCategories(){
        return self::getList("categories", @$_GET['id']);
    }

    public static function listAddons(){
        $productId = DB::filter(@$_GET['product']);
        $id = DB::filter(@$_GET['id']);
        
        if($productId){
            return self::getList("productaddons", $productId, "productId");
        } elseif($id) {
            return self::getList("productaddons", $id);
        } else {
            return self::getList("productaddons");
        }
    }

    public static function getSiteInfo(){
        $siteInfo = DB::table("sitesettings")->first();

        return $siteInfo;
    }

    private static function getList($table, $id = null, $column = "id"){
        $id = DB::filter($id);
        try {
            $query = DB::table($table);
            if($id){
                $query->where($column, $id);
            }
            $result = $query->get();

            if(!empty($result)){
                return jsonKit::json($result, ($table == "categories" ? 'Kategoriler' : ($table == "productaddons" ? 'Eklentiler' : 'Menüler')) . ' Başarıyla Getirildi');
            } else {
                return jsonKit::json("Veri Bulunamadı", 400);
            }
        } catch(Exception $e){
            return jsonKit::json("Bir Hata Oluştu".$e->getMessage(), 500);
        }
    }
}
