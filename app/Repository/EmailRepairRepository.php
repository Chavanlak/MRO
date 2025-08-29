<?php
namespace App\Repository;
// use App\Models\Equipment;
use App\Models\EmailRepair;
use Illuminate\Support\Facades\DB;

class EmailRepairRepository{
    public static function getAllEmailRepairs(){
        return EmailRepair::all();
    }
    public static function getEmailRepairById($id){
        return EmailRepair::find($id);
    }
    
}


?>