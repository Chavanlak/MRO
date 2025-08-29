<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Session;
use App\Repository\MastbranchRepository;
use App\Repository\NotirepairRepository;
use App\Repository\EquipmentRepository;
use App\Repository\EquipmentTypeRepository;
use App\Repository\PermissionBMRepository;
use App\Models\Notirepair;
use App\Models\FileUpload;
use Illuminate\Http\Request;
use App\Http\Requests\StoreFileRequest;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Mail\EmailCenter;
use App\Mail\NotiMail;

use Illuminate\Notifications\Notification;

class NotiRepairController extends Controller
{
    
    public static function getallManegers(){
        $manegers = NotirepairRepository::getAllNames();
        return view('/branch',compact('manegers'));
    }

    public static function showallManegers()
    {
        $manegers = NotirepairRepository::getAllNotirepair();
        return view('zone', ['manegers' => $manegers]);
    }


    public static function showallZoneEmail(){
        $zoneEmail = NotirepairRepository::getSelectZoneEmail();
        return view('zoneemail',compact('zoneEmail'));
    }
    public function handleForm(Request $request)
    {
    $request->validate([
        'branch' => 'required|string',
        'zone' => 'required|string',
        'equipment' => 'required|string',
    ]);

    // เก็บลง session หรือส่งต่อ
    session([
        'selected_branch' => $request->branch,
        'selected_zone' => $request->zone,
        'selected_equipment' => $request->category,
    ]);

    return redirect('repair/form'); // หรือแสดงหน้าถัดไป
    }



    public static function ShowRepairForm(){
        $permis = Session::get('permis_BM');
        $manegers = NotirepairRepository::getAllNotirepair();
        $equipmenttype = EquipmentTypeRepository::getallEquipmentType();
        if($permis == 'N' || $permis == 'n')
        {
            $branch = MastbranchRepository::selectbranch();
            return view('repair',compact('branch', 'manegers','equipmenttype'));

        }
        else
        {
            // $branchid =PermissionBMRepository::getBranchCode(Session::get('staffcode'));
            $branchid =PermissionBMRepository::getBranchCode(Session::get('id'));
            $branchname = MastbranchRepository::getBranchName($branchid);
            return view('repairBM',compact('branchid','branchname','manegers','equipmenttype'));
        }

    }

public static function saveNotiRepair(Request $req){
        $maxSize = 25 *1024 *1024; // 25MB
        foreach ($req->file('filepic') as $file) {
            if ($file->getSize() > $maxSize) {
                // return response()->json(['error' => 'File size exceeds the 25 MB limit.'], 413);
                return redirect()->back()->with('error', 'ขนาดไฟล์เกิน 25 MB กรุณาเลือกไฟล์ใหม่');
            }
        }
        $noti = NotirepairRepository::saveNotiRepair($req->category,$req->detail,$req->email2,$req->email1);
        // $uploadedFiles = []; // เก็บ path ของไฟล์ที่จะส่งทางเมล

        // $mimeType = [];
        // $branchEmail = MastbranchRepository::getallBranchEmail();
        foreach ($req->file('filepic') as $file) {
            $file->getClientOriginalName();
            $filename = explode('.', $file->getClientOriginalName());
            $fileName = $filename[0]."upload".date("Y-m-d").".".$file->getClientOriginalExtension();
            $path = Storage::putFileAs('public/', $file, $fileName);




            $fileup = new FileUpload();
            $fileup->filename = $fileName;
            $fileup->filepath = $path;
            $fileup->NotirepairId = $noti->NotirepairId;
            $fileup->save();
            // $realPath = Storage::path($path);
            // $imageData = Storage::get($path);

        }
       

$data = [
            // 'title'=>'เเจ้งซ่อมอุปกรณ์',
            'title'=>'ทดสอบระบบเเจ้งซ่อมอุปกรณ์ นี่เป็นเพียงการทดสอบการใช้งานเท่านั้นไม่ใช่เมลจริง',
            // 'img' => $uploadedFiles,
            // 'mime'=>$mimeType,
            'linkmail'=>url("picshow/".$noti->NotirepairId),
            // 'branchname'=>$req->branchname,
            // 'emailZone'=>$req->emailZone,
            // 'zonename'=>$req->zonename,
            'branch'=>$req->email1,
            'branchname'=>$req->branch,
            //branch มาจาก <input type="text" name="branch" value="{{ $branchname }}">
            'name'=>$req->session()->get('staffname'),
            // 'branchname'=>$branchname,

            //ใช้อันนี้
            // 'zone'=>$req->zone,
            'zone'=>$req->email2,
            //zone มาจาก <input type="text" name="zone" value="{{ $zonename}}"> หน้าrepair2
            'staffname' => $req->zone,
            'equipmentname'=>EquipmentRepository::getEquipmentnameByID($req->category)->equipmentName

        ];
     // 5️⃣ ส่งเมลทั้ง branch และ zone
    

        //ใช้อันนี้
        Mail::to($req->email1)->send(new NotiMail($data));
        Mail::to($req->email2)->send(new NotiMail($data));
        Mail::to($req->email3)->send(new NotiMail($data));
        // dd("Email sent successfully!");
      
        return view('email');
    }


}
