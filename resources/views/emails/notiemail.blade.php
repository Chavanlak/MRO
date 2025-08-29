{{-- @component('mail::message')
{{$NotiData['title']}}

Noti-picture data is




@foreach ($NotiData['img'] as $imgitem)
<img src="data:image/jpeg;base64,{{ $imgitem }}" width="100" height="100">

@endforeach


Thank you for your purchase!

@endcomponent --}}

{{--  --}}
@component('mail::message')
{{$NotiData['title']}}

{{-- Panel displaying branch name --}}
@component('mail::panel')
เมลสาขา: {{ $NotiData['branch'] }}
เเจ้งซ่อมจากสาขา: {{ $NotiData['branchname'] }}
ผู้แจ้ง: {{ $NotiData['name'] }}
@endcomponent

{{-- Panel displaying zone name --}}
@component('mail::panel')
เมลโซน: {{ $NotiData['zone'] }}
ผู้ดูแล: {{ $NotiData['staffname'] }}


@endcomponent

{{-- Panel displaying equipment name --}}
@component('mail::panel')
เเจ้งปัญหา {{ $NotiData['equipmentname'] }}
@endcomponent

{{-- Button linking to the repair file --}}
@component('mail::button', ['url' => $NotiData['linkmail']])
ไฟล์การเเจ้งซ่อม
@endcomponent

{{-- Optional: Display images if they exist in the data --}}
@if(isset($NotiData['img']) && !empty($NotiData['img']))
Noti-picture data:

@foreach ($NotiData['img'] as $imgitem)
<img src="data:image/jpeg;base64,{{ $imgitem }}" width="100" height="100">

@endforeach
@endif

@endcomponent


