<?php

namespace App\Http\Controllers;

use App\Repository\EquipmentRepository;
use App\Repository\EquipmentTypeRepository;
use App\Repository\MastbranchRepository;
use App\Repository\NotirepairRepository;
use Illuminate\Http\Request;

class EquipmentController extends Controller
{
// public static function ShowAllEquipment()
// {
//     $equipment = EquipmentRepository::getallEquipment();
//     return view('/repair2',compact('equipment'));
// }

// แสดงรายการอุปกรณ์ทั้งหมดในหน้า repair2
// public static function ShowAllEquipment(Request $req)
// {
//     // dd($req->category); //oject category
//     // ตรวจสอบว่ามีการส่งค่า category มาหรือไม่
//     $equipment = EquipmentRepository::getequipmentById($req->category);
//     $branchmail = MastbranchRepository::getallBranchEmail();
//     // $zoneEmail = NotirepairRepository::getSelectZoneEmail();
//     $emailRepair = EquipmentTypeRepository::getEmailRepair($req->category);
//     // $emailRepair = EquipmentTypeRepository::getEmailRepairById($req->mailrepair);

//     $branchname = $req->branch;
//     $emailZone = NotirepairRepository::getSelectZoneEmail();
//     // $zone = $emailZone->where('email', $req->zone)->first();
//     $zone = $emailZone->email;

//     // $zonename = $req->zone;
//     // $zoneEmail = NotirepairRepository::getemailZone($zonename);
//     // $zoneData = $req->zone;

//     // $emailZone = null;
//     // if ($zoneData) {
//     //     // 3. Decode the JSON string to get a PHP object.
//     //     $zoneObject = json_decode($zoneData);

//     //     // 4. Check if the object and its email property exist.
//     //     if ($zoneObject && isset($zoneObject->email)) {
//     //         $emailZone = $zoneObject->email;
//     //     }
//     // }
//     //ส่งค่าพารามิเตอร์ไปยัง view
//     // dd($req->all());
//     // dd($zone);
//     // return view('/repair2',compact('equipment','branchmail','zoneEmail','branchname','zonename','emailRepair'));
//     return view('/repair2',compact('equipment','branchmail','branchname','emailRepair','zone'));

// }
public static function ShowAllEquipment(Request $req)
{
    // dd($req->category); //oject category
    // ตรวจสอบว่ามีการส่งค่า category มาหรือไม่
    $equipment = EquipmentRepository::getequipmentById($req->category);

    //เดิม
    $branchmail = MastbranchRepository::getallBranchEmail();
    $branch = $branchmail->email;
    //เพิ่ม
    $branchname = $req->branch;

//ใหม่
    // $branchmail = MastbranchRepository::getallBranchEmail();
    // $branch = $branchmail->email;
    // $branchInfo = MastbranchRepository::getBranchInfoByEmail($branch);
    // $branchname = $branchInfo->Location;




    // $branchname =MastbranchRepository::getBranchNameByEmail($branch);

    // $branchInfo = MastbranchRepository::getBranchInfoByEmail($branch);
    // $branchname = $branchInfo->Location;
    // $branchInfo =MastbranchRepository::getBranchNameByEmail($branch);
    // $branchname = $branchInfo->Location;

    // 💡 ดึงข้อมูลสาขาโดยใช้ MBranchInfo_Code ที่ถูกส่งมาจากฟอร์ม
    // $branchInfo = MastbranchRepository::getBranchandEmailByCode($req->branch);
    // $branch = $branchInfo->email;
    // $branchname = $branchInfo->Location;
    $emailRepair = EquipmentTypeRepository::getEmailRepair($req->category);




    // $branchname = $req->branch;
// ใช้อันนี้
    // $staffName = $req->zone;
    // $staffName = NotirepairRepository::getAllStaffName();
    // $name = $staffName->StaffName;
    $emailZone = NotirepairRepository::getSelectZoneEmail();
    $zone = $emailZone->email;
    $zoneInfo = NotirepairRepository::getZoneInfoByEmail($zone);

    $staffname = $zoneInfo->StaffName;


    //new step1
    // $branchEmail = $req->branch; //ตรงกับ  select name="branch" ในหน้า repair
    // $zoneEmail = $req->zone;

//step2
    $branchEmail = MastbranchRepository::findEmailByname($req->branch); // ดึงอีเมลของสาขาจากชื่อสาขา
    $zoneEmail = NotirepairRepository::findZoneEmailByName($req->zone); // ดึงอีเมลของโซนจากชื่อโซน
    $zonename = $req->zone; // ชื่อโซนที่ส่งมาจากฟอร์ม

    // $emailZone = NotirepairRepository::getNameandZoneEmail();

    // dd($emailZone);

    // $zone = $emailZone->email;

    // dd($req->all());
    // dd($zone);
    //เดิม
    return view('/repair2',compact('equipment','branch','emailRepair','zone','staffname','branchname','branchEmail','zoneEmail','zonename'));


    //ใหม่
    // return view('/repair2', compact('equipment', 'branchname', 'emailRepair', 'zone', 'staffname'));
    // return view('/repair2',compact('equipment','branchmail','branchname','emailRepair','zone'));

}
// public static function ShowAllEquipment(Request $req)
// {
//     // ... โค้ดส่วนอื่น ๆ ...

//     // ดึงข้อมูลอีเมลของ Zone
//     $zoneEmailObject = NotirepairRepository::getZoneEmailByStaffName($req->zone);
//     $zoneEmail = $zoneEmailObject->email; // ดึงแค่ค่าอีเมล

//     // ดึงข้อมูลอีเมลของสาขา
//     $branchEmailObject = MastbranchRepository::getBranchEmailByLocation($req->branch);
//     $branchEmail = $branchEmailObject->email; // ดึงแค่ค่าอีเมล

//     // ส่งค่าพารามิเตอร์ทั้งหมดไปยัง view
//     return view('/repair2', compact('equipment', 'zoneEmail', 'branchEmail', 'branchname', 'zonename', 'emailRepair'));
// }
}
?>
