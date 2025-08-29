<?php
namespace App\Repository;
use App\Models\Notirepair;
use Illuminate\Support\Facades\DB;
use App\Models\Zone;
class NotirepairRepository{
    public static function getAllNotirepair(){
        return Zone::all();
    }
    public static function getAllStaffName(){
        return Zone::where('StaffName')->first();
    }
    public static function getAllNames(){
        return Zone::where('FirstName','LastName')->first();
    }
    public static function getSelectZoneEmail(){
        return Zone::whereNotNull('email')->first();
    }
    public static function getNameandZoneEmail(){
        return Zone::select(['StaffName', 'email'])
            ->whereNotNull('email')
            ->first();
    }
    public static function getZoneInfoByEmail($email){
        return Zone::where('email', $email)
            ->first(); // ดึงข้อมูลของ zone ที่มี email ตรงกับที่ระบุ
    }
    public static function getEmailByCode($zoneId)
    {
        return Zone::where('zoneId', $zoneId)
            ->value('email'); // ดึง email ของ branch
    }
    public static function getemailZone($zonename){
        return Zone::where('email', $zonename)->value('email');
    }
    // public static function save($branch){
    //     $notirepair = new Notirepair();
    //     $notirepair->branch = $branch;
    // }
    public static function saveNotiRepair($equipmentId,$DeatailNotirepair,$Zone,$branch){
        $noti = new Notirepair();
        $noti->equipmentId = $equipmentId;
        $noti->DeatailNotirepair = $DeatailNotirepair;
        $noti->Zone = $Zone;
        $noti->branch = $branch;
        $noti->save();
        return $noti;
    }
    // public static function findZoneEmailByName($zonename){
    //     return Zone::where('StaffName','=',$zonename)
    //         ->first(['email']);
    // }
  public static function findZoneEmailByName($zonename){
        return Zone::where('StaffName','=',$zonename)
            ->first()
            ->email;
    }

}

?>
