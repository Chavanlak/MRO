<?php
namespace App\Repository;
use App\Models\PermissionBM;
use Illuminate\Support\Facades\DB;

class PermissionBMRepository{
   public static function getBranchCode($staffcode){
   $branchid = PermissionBM::where('staffcode','=',$staffcode)->first()->branch;
   return $branchid;
   }
   // public static function getBranchCode($id){
   //    $branchid = PermissionBM::where('id','=',$id)->first()->branch;
   //    return $branchid;
   //    }
}


?>
