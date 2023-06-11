@extends('layouts.layout-nonav')

@section('content')
注文を受け付けました。<br>
ありがとうございます。<br>
メール（自動送信）でお送りしています。<br>


@if($pay == 'cash')
代引きで受け付けました。<br>
Tシャツをお送りいたしますので、その際、お支払いよろしくお願いします。<br>
@elseif($pay == 'bank')
振込で受け付けました。<br>
後日、振込先をメールでお送りします。<br>
振込確認後、Tシャツをお送りいたします。<br>
@elseif($pay == 'credit')
クレジット支払いで受け付けました。<br>
Tシャツをお送りいたします。<br>

@else
他。失敗しているかも。

@endif

{{request()->query('redirect_status')}}
@endsection