{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    @foreach ($picPathList as $picPath)
        <img src="{{Storage::url($picPath->filepath)}}" width="100" height="100">
        <br/>
    @endforeach
</body>
</html> --}}
{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    @foreach ($picPathList as $picPath)
     
        <img src="{{ Storage::url($picPath->filepath) }}" width="400" height="400" style="object-fit: cover; max-width: 100%; max-height: 100%;" alt="Image">
        <br/>
    @endforeach
</body>
</html> --}}

{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    @foreach ($picPathList as $file)
        @if ($file->file_type === 'video')
            <video width="400" height="auto" controls>
                <source src="{{ Storage::url($file->filepath) }}" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        @else
            <img src="{{ Storage::url($file->filepath) }}" width="400" height="auto" style="object-fit: cover; max-width: 100%; max-height: 100%;" alt="Image">
        @endif
        <br/>
    @endforeach
</body>
</html> --}}

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    @foreach ($picPathList as $file)
        {{-- ตรวจสอบนามสกุลไฟล์ว่าเป็น .mp4 หรือไม่ --}}
        @if (Str::endsWith($file->filepath, ['.mp4', '.mov', '.avi']))
            <video width="400" height="auto" controls>
                <source src="{{ Storage::url($file->filepath) }}">
                Your browser does not support the video tag.
            </video>
        @else
            <img src="{{ Storage::url($file->filepath) }}" width="400" height="auto" style="object-fit: cover; max-width: 100%; max-height: 100%;" alt="Image">
        @endif
        <br/>
    @endforeach
</body>
</html>