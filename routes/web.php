<?php

use App\Http\Controllers\UserController;

use App\Http\Controllers\EmailController;
use App\Http\Controllers\MastbranchinfoController;
use App\Http\Controllers\NotiRepairController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\FileUploadController;
use App\Mail\EmailCenter;
use App\Mail\TestMail;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Mail;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/logintest',function(){
    return view('login');
});

Route::get('/login',[UserController::class, 'login'])->name('login');
Route::post('/loginpost',[UserController::class,'loginPost']);

Route::get('logineror',[UserController::class,'logineror']);
// Route::get('/showrepair',[UserController::class,'showrepair']);

Route::get('/logout',[UserController::class,'logout'])->name('logout');
// Route::get('/repair', [UserController::class, 'showrepair'])->middleware('customauth');

// Route::get('/branch', [MastbranchinfoController::class, 'getselectBranch'])->middleware('customauth');
// Route::post('/branch', [MastbranchinfoController::class, 'storeBranch'])->middleware('customauth')->name('store.branch');
Route::get('/send-multiple-gmails', [EmailController::class, 'sendMultipleGmails']);
Route::get('/branch', [MastbranchinfoController::class, 'getselectBranch']);
Route::post('/branchpost', [MastbranchinfoController::class, 'saveBranch']);
Route::get('/Zone',[NotiRepairController::class,'showallManegers']);
// Route::get('/showbranch',[MastbranchinfoController::class,'showallBranch']);
// Route::get('/nav', function () {
//     return view('navbar');
// });
Route::get('/layout', function () {
    return view('layout.mainlayout');
});
//  action="{{ route('select.branch') }}" method="POST"
// routes/web.php
Route::get('/repair', [NotiRepairController::class,'ShowRepairForm'])->middleware('customauth');
// Route::post('/repair', [NotiRepairController::class, 'handleForm'])->middleware('customauth');
// Route::get('/repair/equipment', [EquipmentController::class, 'ShowAllEquipmentType'])->middleware('customauth');
Route::get('/repair/repair2', [EquipmentController::class, 'ShowAllEquipment'])->middleware('customauth');
// Route::get('repair/mail', [MastbranchinfoController::class, 'getemail'])->middleware('customauth');
Route::post('/repair/submit', [NotiRepairController::class, 'saveNotiRepair'])->middleware('customauth');
// Route::post('/submit-repair', [NotiRepairController::class, 'submitRepair'])->middleware('customauth'); // ถ้าคุณมีฟอร์มส่งแจ้งซ่อม


// Route::get('/repair/repair2', [MastbranchinfoController::class,'showRepair2Form'])->middleware('customauth');
// ถ้าต้องการ filter email
Route::get('/repair/mail', [NotiRepairController::class, 'getemail'])->middleware('customauth');


// Route::post('/repair', [NotiRepairController::class, 'handleForm']);
// Route::get('/repair/form', [NotiRepairController::class, 'showForm']);

//upload
// Route::get('/uploadfile',[FileUploadController::class,'getallUploadFile']);
// Route::post('/uploadfilepost',[FileUploadController::class,'savefile']);


// Route::post('/uploadfilepost',[FileUploadController::class,'getFileById']);
// Route::get('/file', function () {
//     return view('fileupload');
Route::get('/uploadfile',[FileUploadController::class,'createFile']);
// Route::post('/store',[FileUploadController::class,'uploadeFile']);
Route::post('/store',[FileUploadController::class,'store']);
// });
// Route::get('/mail', function () {
//     return view('email');
// });
// Mail::to('repaircentertgi@gmail.com')->send((new EmailCenter($name)));

// Route::get('/email', function () {
//     $name = 'Email Center';
//     Mail::to('repaircentertgi@gmail.com')->send(new EmailCenter($name));
//     // return "ส่งอีเมลแล้ว";
// });

// Route::get('/email', function () {
//     $name = 'Email Center';
//     $attachments = [
//         // 'path/to/attachment1.pdf',
//         // 'path/to/attachment2.jpg',
//     ];
//     Mail::to('

Route::get('/email', function () {
    $name = 'Test Mail';
    Mail::to('tgirepaircenter@gmail.com')->send(new TestMail($name));

});
Route::get('/testmail', [EmailController::class, 'sendEmailTother']);
Route::get('/emailpic', [EmailController::class, 'saveNotiRepair']);

Route::get('/sendmail', [EmailController::class, 'index']);
Route::get('/picshow/{notirepairId}',[FileUploadController::class,'getPicturePathfromNotiRepairId']);

Route::get('/email', function () {
    return view('email');
});
//check email
// Route::get('/show', [MastbranchinfoController::class, 'showallBranch']);
