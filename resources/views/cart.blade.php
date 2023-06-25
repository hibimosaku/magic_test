<?php
$url = env('APP_URL');
?>
@extends('layouts.layout-nav')
@section('content')
@if(!$cart)
<p>カート空です</p>
@else
<p>合計金額:{{number_format($allSum)}}円</p>
<form method="POST" action="{{route('order.index')}}">
  @csrf
  <input type="hidden" name="cart" value="{{ json_encode($cart) }}">

  <button class="button" type="submit">購入手続きへ</button>
  <hr>
</form>

@foreach($cart as $item)
<a href="{{route('item.show',['id' => $item['itemId']])}}">商品のページに戻る</a><br>
<img style="height:50px;" src="{{ asset('images/item/'. $item['image1'] ?? '') }}">
<img style="height:50px;" src="{{ asset('images/item/'. $item['image2'] ?? '') }}">
<img style="height:50px;" src="{{ asset('images/item/'. $item['image3'] ?? '') }}">
<img style="height:50px;" src="{{ asset('images/item/'. $item['image4'] ?? '') }}">
<p class="abc">名前：{{$item['name']}}</p>
<p>色：{{$item['colorName']}}</p>
<p>サイズ：{{$item['sizeName']}}</p>
<p>価格：{{number_format($item['price'])}}</p>
@if($item['name_print_num'] > 0)
<p>名入れ1：{{$item['name_print1']}}</p>
@endif
@if($item['name_print_num'] > 1)
<p>名入れ2：{{$item['name_print2']}}</p>
@endif
@if($item['name_print_num'] > 2)
<p>名入れ3：{{$item['name_print3']}}</p>
@endif
@if($item['image_path'])
<img src="{{ asset('storage/' . $item['image_path']) }}" alt="画像">
@endif

<form method="POST" action="{{ route('cart.updateNum',['id' =>$item['itemId'],'color' =>$item['color'],'size' =>$item['size']]) }}">
  @csrf
  @method('PUT')
  個数：
  <select name="num" onchange="this.form.submit()">
    @if(isset($item['num']) && $item['num'] > $ITEMNUM )
    <option value="{{ $item['num'] }}" selected>{{ $item['num'] }}</option>
    @endif
    @for ($i = 1; $i <= $ITEMNUM; $i++) <option value="{{ $i }}" {{ isset($item['num']) && $item['num'] == $i ? 'selected' : '' }}>{{ $i }}</option>
      @endfor
  </select><br>
</form>

<p>合計{{number_format($item['price'] * $item['num'])}}</p>
<form method="POST" action="{{ route('cart.delete',['id' =>$item['itemId'],'color' =>$item['color'],'size' =>$item['size']]) }}">
  @csrf
  @method('DELETE')
  <button class="button" type="submit">削除</button>
</form>
@endforeach

<hr>

@endif

@endsection