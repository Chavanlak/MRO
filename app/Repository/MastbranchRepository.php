<?php
namespace App\Repository;
use Illuminate\Support\Facades\Session;
use App\Models\Mastbranchinfo;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Repository\PermissionBMRepository;
class MastbranchRepository{
    public static function getallBranch(){
        return Mastbranchinfo::all();
    }
    //เพิ่มเข้ามา display ชื่อสาขา
    public static function getBranchName($branchid){
        return Mastbranchinfo::where('MBranchInfo_Code','=',$branchid)->first()->Location;
    }

    public static function selectbranch(){
        $branches = Mastbranchinfo::select(['MBranchInfo_Code','Location'])
        ->whereNotIn('MBranchInfo_Code',['HO'])
        ->where('branch_active',1)
        ->where(function($query){
            $query->whereNull('closed')
            ->orWhere('closed', 0);
        })->get();
        return $branches;
    }
    public static function getBranchandEmailByCode($branchCode)
{
    return Mastbranchinfo::select(['MBranchInfo_Code', 'Location', 'email'])
        ->where('MBranchInfo_Code', $branchCode)
        ->first();
}
    public static function getBranchNameByEmail($email){
        return Mastbranchinfo::where('email', $email)
            ->value('Location'); // ดึงชื่อสาขาจากอีเมล
    }
    public static function getBranchInfoByEmail($email){
        return Mastbranchinfo::where('email',$email)
        ->first(); // ดึงข้อมูลของสาขาที่มีอีเมลตรงกับที่ระบุ
    }
    // public static function getallBranchEmail(){
    //     return Mastbranchinfo::whereNotNull('email')
    //     ->select('email')->get();
    // }
    public static function getallBranchEmail(){
        return Mastbranchinfo::whereNotNull('email')
        ->first();
    }
    public static function getBranchandEmail(){
        return Mastbranchinfo::select(['MBranchInfo_Code', 'Location', 'email'])
            ->whereNotIn('MBranchInfo_Code', ['HO'])
            ->where('branch_active', 1)
            ->where(function($query) {
                $query->whereNull('closed')
                      ->orWhere('closed', 0)
                      ->whereNotNull('email')
                      ->whereNotNull('Location'); // 💡 เพิ่มบรรทัดนี้
            })->get();
    }
    public static function getEmailByCode($branchCode)
    {
        return Mastbranchinfo::where('MBranchInfo_Code', $branchCode)
            ->value('email'); // ดึง email ของ branch
    }

    //old
    // public static function findEmailByname($branchname){
    //     return Mastbranchinfo::where('Location','=',$branchname)
    //     ->first()
    //     ->email; // ดึงอีเมลของสาขาจากชื่อสาขา
    // }
    public static function findEmailByname($branchname){
        // if(Session::get('permis_BM') == 'N' || Session::get('permis_BM') == 'n'){
        //     return Mastbranchinfo::where('Location','=',$branchname)
        //         ->first()
        //         ->email; // ดึงอีเมลของสาขาจากชื่อสาขา
        // }
        // else{
        //     $branchid = PermissionBMRepository::getBranchCode(Session::get('staffcode'));
        //     return Mastbranchinfo::where('MBranchInfo_Code',branchid)->first()->email;
        // }
         return Mastbranchinfo::where('MBranchInfo_Code',$branchname)->first()->email;

    }

    }

?>
