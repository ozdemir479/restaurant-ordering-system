<?php
use Table\DB;

class MainController {
    public static function getSiteInfo(){
        $sql = DB::table("siteSettings")->first();
        return $sql;
    }

    public function getRestourantLocation(){
       $siteSettings = self::getSiteInfo();
       $longitudeStart = $siteSettings['longitudeStart'];
       $longituteEnd = $siteSettings['longituteEnd'];
       $latitudeStart = $siteSettings['latitudeStart'];
       $latitudeEnd = $siteSettings['latitudeEnd'];
       $data = [
         'longitudeStart' => $longitudeStart,
         'longitudeEnd' => $longituteEnd,
         'latitudeStart' => $latitudeStart,
         'latitudeEnd' => $latitudeEnd,
       ];
       jsonKit::json($data, "Veri Bulundu", 200);
    }
}