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
    // public static function getallManegers(){
    //     $manegers = NotirepairRepository::getAllNotirepair();
    //     return view('notirepair',compact('manegers'));
    // }
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

// public function showForm()
// {
//     // ตรวจสอบว่ามี session ครบไหมด้วยก็ได้
//     if (!session()->has('selected_branch')) {
//         return redirect('/branch')->with('error', 'กรุณาเลือกสาขาก่อน');
//     }

//     return view('repairform');
// }
// public function showRepairForm()
// {
//     // ดึงข้อมูลสาขา และ manegers มาใส่ view
//     $branch = Mastbranchinfo::where('branch_active', 1)->get();
//     $manegers = Maneger::all(); // หรือ query ข้อมูลโซน/คนจัดการ ตามที่มีจริง

//     return view('repair', compact('branch', 'manegers'));
// }

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
            $branchid =PermissionBMRepository::getBranchCode(Session::get('staffcode'));
            $branchname = MastbranchRepository::getBranchName($branchid);
            return view('repairBM',compact('branchid','branchname','manegers','equipmenttype'));
        }

    }
//     public static function saveNotiRepair(Request $req){
//         $noti = NotirepairRepository::saveNotiRepair($req->category,$req->detail);
//         $uploadedFiles = []; // เก็บ path ของไฟล์ที่จะส่งทางเมล

//        $mimeType = [];
//         foreach ($req->file('filepic') as $file) {
//         $file->getClientOriginalName();
//         $filename = explode('.', $file->getClientOriginalName());
//         $fileName = $filename[0]."upload".date("Y-m-d").".".$file->getClientOriginalExtension();
//         $path = Storage::putFileAs('public/', $file, $fileName);

//         $fileup = new FileUpload();
//         $fileup->filename = $fileName;
//         $fileup->filepath = $path;
//         $fileup->NotirepairId = $noti->NotirepairId;
//         $fileup->save();
//         $realPath = Storage::path($path);
//         $imageData = Storage::get($path);

//         $uploadedFiles[] = [
//             'data' => base64_encode($imageData),
//             'mime' => str_replace('image/', '', mime_content_type($realPath))
//         ];
// }
//         // $file = $req->file('filepic');
//         // $file->getClientOriginalName();
//         // $filename = explode('.', $file->getClientOriginalName());
//         // $fileName = $filename[0]."_upload_".date("Y-m-d").".".$file->getClientOriginalExtension();
//         // // $fileName = $req->filepic."_upload_".date("Y-m-d").".".$file->getClientOriginalExtension();
//         // $path = Storage::putFileAs('public/',$file,$fileName);

//         // $fileup = new FileUpload();
//         // $fileup->filename = $fileName;
//         // $fileup->filepath = $path;
//         // $fileup->NotirepairId = $noti->NotirepairId;
//         // $fileup->save();
//     //     Mail::raw("รายละเอียดการแจ้งซ่อม: ".$req->detail, function($message) use ($uploadedFiles) {
//     //     $message->to('smartmeow11@gmail.com')
//     //             ->subject('แจ้งซ่อมใหม่เข้ามา');

//     //     foreach ($uploadedFiles as $filePath) {
//     //         $message->attach($filePath);
//     //     }
//     // });
//     // dd($uploadedFiles);
//        $data = [
//         'title'=>'Noti with pic email',
//         'img' => $uploadedFiles,
//         'mime'=>$mimeType
//         ];
//         // เพิ่มบรรทัดนี้เพื่อตรวจสอบข้อมูลก่อนส่งอีเมล
// // dd($data['img']);
//          Mail::to("tgirepaircenter@gmail.com")->send(new NotiMail($data));
//          dd("Email sent successfully!");
// //  dd($data);
//     //     return redirect('/repair');
//         // return redirect('/email');

//         // dd($filename[0]."_upload_".date("Y-m-d").".".$file->getClientOriginalExtension());

//     }
public static function saveNotiRepair(Request $req){
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
            $realPath = Storage::path($path);
            $imageData = Storage::get($path);

            // $uploadedFiles[] = [
            //     'data' => base64_encode($imageData),
            //     'mime' => str_replace('image/', '', mime_content_type($realPath))
            // ];
        }
        // $zoneInfo = NotirepairRepository::getZoneInfoByEmail($req->email2);
        // $staffName = $zoneInfo->StaffName;
        // $branchInfo = MastbranchRepository::getBranchInfoByEmail($req->email1);
        // $branchname = $branchInfo ? $branchInfo->Location : 'ไม่ระบุสาขา';
        // $branch_email = $branchInfo ? $branchInfo->email : 'ไม่ระบุอีเมล';
        // $branchname = MastbranchRepository::getBranchNameByEmail($req->email1);
        // $branchname = $branchInfo->Location;
        // $branchInfo = MastbranchRepository::getBranchInfoByEmail($req->email1);
        // $branchname = $branchInfo->Location;
        if ($req->email1=='example@mail.com') {

                $data = [
                            'title'=>'เเจ้งซ่อมอุปกรณ์',
                            // 'img' => $uploadedFiles,
                            // 'mime'=>$mimeType,
                            'linkmail'=>url("picshow/".$noti->NotirepairId),
                            'branch'=>'ไม่มีอีเมลสาขา',
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
        } else {

            $data = [
                        'title'=>'เเจ้งซ่อมอุปกรณ์',
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
                }
            // 5️⃣ ส่งเมลทั้ง branch และ zone
            // $emailsToSend = [];
            // if ($branchEmail) $emailsToSend[] = $branchEmail;
            // if ($req->zoneMail) $emailsToSend[] = $req->zoneMail;

            // if (!empty($emailsToSend)) {
            //     Mail::to($emailsToSend)->send(new NotiMail($data));
            // }

            // if ($req->zoneMail) {
            //     Mail::to($req->zoneMail)->send(new NotiMail($data));
            // }
                //อันนี้ก็ใช้
                // Mail::to($req->mail)->send(new NotiMail($data));

                // Mail::to("smartmeow11@gmail.com")->send(new NotiMail($data));

                //ใช้อันนี้
                Mail::to($req->email1)->send(new NotiMail($data));
                Mail::to($req->email2)->send(new NotiMail($data));
                Mail::to($req->email3)->send(new NotiMail($data));
                // dd("Email sent successfully!");
                // $recipients = [
                //     $req->email1,
                //     $req->email2,
                //     $req->email3,
                // ];

                // Mail::to($recipients)->send(new NotiMail($data));
                return view('email');
            }

        // public static function SaveNotisendtoemail(Request $req){
        //     $noti = NotirepairRepository::saveNotiRepair($req->category,$req->detail);
        //     $attachments = []; // เก็บ path ของไฟล์ที่จะส่งทางเมล
        //     foreach ($req->file('filepic') as $file) {
        //         $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        //         $fileName = $filename . "_upload_" . date("Y-m-d") . "." . $file->getClientOriginalExtension();
        //         $path = Storage::putFileAs('public/', $file, $fileName);

        //         // บันทึกลง DB
        //         $fileup = new FileUpload();
        //         $fileup->filename = $fileName;
        //         $fileup->filepath = $path;
        //         $fileup->NotirepairId = $noti->NotirepairId;
        //         $fileup->save();

        //         // เก็บ path สำหรับแนบเมล
        //         $attachments[] = storage_path('app/' . $path);

        //         // Mail::to('repaircentertgi@gmail.com')->send(new EmailCenter($attachments));
        //         // Mail::to('someone@example.com')->send(new EmailCenter($noti, $attachments));
        //         // return redirect('/email');
        //         Mail::send(new EmailCenter('Pol', $attachments));
        //         return redirect('/email');
        //     }

        // }
    }
