<?php
use Table\DB;

class MainController {
    public static function getSiteInfo(){
        $sql = DB::table("siteSettings")->first();
        return $sql;
    }
}