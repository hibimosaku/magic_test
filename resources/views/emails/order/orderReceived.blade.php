<head>
  <title>注文受付のお知らせ</title>
</head>

<h1>注文受付のお知らせ</h1>
@foreach($cart as $item)
{{$item['name']}}
@endforeach
<p>ありがとうございました。</p>