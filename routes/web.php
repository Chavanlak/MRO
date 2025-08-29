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


// Route::get('/logintest',function(){
//     return view('login');
// });



// Route::get('/send-multiple-gmails', [EmailController::class, 'sendMultipleGmails']);
// Route::get('/branch', [MastbranchinfoController::class, 'getselectBranch']);
// Route::post('/branchpost', [MastbranchinfoController::class, 'saveBranch']);
// Route::get('/Zone',[NotiRepairController::class,'showallManegers']);

//ใช้ตรง login
Route::get('/',[UserController::class, 'login'])->name('login');
Route::post('/loginpost',[UserController::class,'loginPost']);
Route::get('logineror',[UserController::class,'logineror']);
Route::post('/logout', [UserController::class, 'logout'])->name('logout');

//ใช้3 อันนี้
Route::get('/repair', [NotiRepairController::class,'ShowRepairForm'])->middleware('customauth');
Route::get('/repair/repair2', [EquipmentController::class, 'ShowAllEquipment'])->middleware('customauth');
Route::post('/repair/submit', [NotiRepairController::class, 'saveNotiRepair'])->middleware('customauth');



// Route::get('/repair/repair2', [MastbranchinfoController::class,'showRepair2Form'])->middleware('customauth');
// ถ้าต้องการ filter email
// Route::get('/repair/mail', [NotiRepairController::class, 'getemail'])->middleware('customauth');



// Route::get('/uploadfile',[FileUploadController::class,'createFile']);
// // Route::post('/store',[FileUploadController::class,'uploadeFile']);
// Route::post('/store',[FileUploadController::class,'store']);

// Route::get('/email', function () {
//     $name = 'Test Mail';
//     Mail::to('tgirepaircenter@gmail.com')->send(new TestMail($name));

// });
// Route::get('/testmail', [EmailController::class, 'sendEmailTother']);
// Route::get('/emailpic', [EmailController::class, 'saveNotiRepair']);

// Route::get('/sendmail', [EmailController::class, 'index']);
// Route::get('/picshow/{notirepairId}',[FileUploadController::class,'getPicturePathfromNotiRepairId']);

// Route::get('/email', function () {
//     return view('email');
// });

