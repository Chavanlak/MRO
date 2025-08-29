<?php
namespace App\Repository;
use App\Models\Equipmenttype;
use App\Models\Equipment;
use Illuminate\Support\Facades\DB;

class EquipmentTypeRepository{
    public static function getallEquipmentType(){
        return Equipmenttype::all();
    }
    public static function getEmailRepairById($emailRepairId){
        return Equipmenttype::where('emailRepairId', $emailRepairId)->get();
    }
    // public static function getEquipmentnameByID($equipId){
    //     return Equipment::select(['equipmentName'])->where('equipmentId','=',$equipId)->first();
    // }
    // public static function getEmailRepair(){
    //     return Equipmenttype::select('emailrepair.emailRepairId','emailrepair.emailRepair'
    //     ,'equipmenttype.TypeName')
    //     ->join('emailrepair','equipmenttype.emailRepairId','=','emailrepair.emailRepairId')
    //     ->orderBy('equipmenttype.TypeId')
    //     ->orderBy('emailrepair.emailRepairId')
    //     ->get();
    // }
    public static function getEmailRepair($typeId)
{
    return Equipmenttype::select(
            'emailrepair.emailRepairId',
            'emailrepair.emailRepair',
            'equipmenttype.TypeName'
        )
        ->join('emailrepair','equipmenttype.emailRepairId','=','emailrepair.emailRepairId')
        ->where('equipmenttype.TypeId', $typeId)  
        ->first();  
}

}
?>
