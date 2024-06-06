<?php
require("models/DB.php");
use Table\DB;

class MenuHandler{
    public static function getMenus(){
        $results = DB::table('products')
        ->select(['products.id', 'products.productName', 'products.productPrice', 'products.productDesc', 'products.productImage', 'categories.categorySlug'])
        ->join('categories', 'productCategory', '=', 'id') 
        ->get();
        return $results;
    }

    public static function getCategories(){
        $sql = DB::table("categories")->get();
        return $sql;
    }

    public static function getMenusTest(){
        $results = DB::table('products')
        ->select(['products.id', 'products.productName', 'products.productPrice', 'products.productDesc', 'products.productImage', 'categories.categorySlug'])
        ->join('categories', 'productCategory', '=', 'id') 
        ->get();
    
    
    
        echo json_encode($results);
    }
    
    
}