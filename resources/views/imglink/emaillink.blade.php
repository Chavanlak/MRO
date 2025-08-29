
{{-- old --}}
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
</html> --}}


{{-- new --}}

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
        <div style="text-align: center; margin-bottom: 15px;">
            @if (Str::endsWith($file->filepath, ['.mp4', '.mov', '.avi']))
                <video width="400" height="auto" controls>
                    <source src="{{ Storage::url($file->filepath) }}">
                    Your browser does not support the video tag.
                </video>
            @else
                <img src="{{ Storage::url($file->filepath) }}" width="400" height="auto" style="object-fit: cover; max-width: 100%; max-height: 100%;" alt="Image">
            @endif
        </div>
    @endforeach
</body>
</html>

{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery</title>
    <style>
        .gallery {
            display: flex;
            gap: 10px;
            justify-content: center; 
            flex-wrap: nowrap;       
            overflow-x: auto;        
        }
        .gallery img, .gallery video {
            width: 300px;
            height: 200px;
            object-fit: cover;
           
        }
    </style>
</head>
<body>
    <div class="gallery">
        @foreach ($picPathList as $file)
            @if (Str::endsWith($file->filepath, ['.mp4', '.mov', '.avi']))
                <video controls>
                    <source src="{{ Storage::url($file->filepath) }}">
                    Your browser does not support the video tag.
                </video>
            @else
                <img src="{{ Storage::url($file->filepath) }}" alt="Image">
            @endif
        @endforeach
    </div>
</body>
</html> --}}

