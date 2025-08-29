<?php

namespace App\Http\Controllers;
use App\Models\FileUpload;
use App\Mail\MultipleGmailSender;
use Illuminate\Http\Request;
// use Mail;
Use App\Mail\MarkMail;
use Illuminate\Support\Facades\Mail;
use App\Repository\NotirepairRepository;
use Illuminate\Support\Facades\Storage;
class EmailController extends Controller
{
    public function sendMultipleGmails()
    {
        $recipientEmail = 'another_email@example.com'; // The email address to send to

        $emailsToSend = [
            [
                'subject' => 'Your First Gmail Subject ',
                'content' => 'This is the content for the first email.',
            ],
            [
                'subject' => 'Your Second Gmail Subject ',
                'content' => 'Here\'s the content for the second email, with more details.',
            ],
            [
                'subject' => 'Third Gmail from Laravel ',
                'content' => 'And this is the last email content example.',
            ],
        ];

        foreach ($emailsToSend as $email) {
            Mail::to($recipientEmail)->send(new MultipleGmailSender($email['content'], $email['subject']));
        }
        // foreach ($emailsToSend as $email) {
        //     Mail::to($recipientEmail)->queue(new MultipleGmailSender($email['content'], $email['subject']));
        // }

        return "Multiple Gmails sent successfully to " . $recipientEmail . "!";
    }
    public static function sendEmailTother() {
        $details =[
        'subject' => 'แจ้งซ่อมอุปกรณ์',
        'body' => 'สวัสดีครับ นี่คือข้อความทดสอบการส่งเมล'
        ];

       Mail::raw($details['body'], function($message) use ($details) {
        $message->to('smartmeow11@gmail.com') // ผู้รับ
                ->subject($details['subject']);
    });

        return "Email sent successfully!";
    }

    public static function saveNotiRepair(Request $req)
    {
    $noti = NotirepairRepository::saveNotiRepair($req->category, $req->detail,$req->zoneMail);

    $uploadedFiles = [];

    foreach($req->file('filepic') as $file){
        $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $fileName = $filename."_upload_".date("Y-m-d").".".$file->getClientOriginalExtension();
        $path = Storage::putFileAs('public/', $file, $fileName);

        $fileup = new FileUpload();
        $fileup->filename = $fileName;
        $fileup->filepath = $path;
        $fileup->NotirepairId = $noti->NotirepairId;
        $fileup->save();

        // เก็บ path ไว้ใช้แนบในอีเมล
        $uploadedFiles[] = storage_path('app/'.$path);
    }

    // ส่งอีเมลพร้อมแนบไฟล์
    Mail::raw("รายละเอียดการแจ้งซ่อม: ".$req->detail, function($message) use ($uploadedFiles) {
        $message->to('smartmeow11@gmail.com')
                ->subject('แจ้งซ่อมใหม่เข้ามา');

        foreach ($uploadedFiles as $filePath) {
            $message->attach($filePath);
        }
    });

    // return redirect('/repair');
        return "Email sent successfully!";
}
public function index()
    {
        $data = [
            'title' => 'Example',
            'url' => 'tgirepaircenter@gmail.com'
        ];
       Mail::to("tgirepaircenter@gmail.com")->send(new MarkMail($data));
       dd("Email sent successfully!");
    }
}
