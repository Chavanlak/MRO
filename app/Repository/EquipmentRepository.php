<?php
namespace App\Repository;
use App\Models\Equipment;
use Illuminate\Support\Facades\DB;

class EquipmentRepository{
    public static function getallEquipment(){
        return Equipment::all();
    }
    public static function getequipmentById($TypeId){
        return Equipment::where('TypeId', $TypeId)->get();
    }
    public static function getEquipmentnameByID($equipId){
    return Equipment::select(['equipmentName'])->where('equipmentId','=',$equipId)->first();
}

}
?>
