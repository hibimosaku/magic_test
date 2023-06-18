@extends('layouts.layout-nav')

@section('content')


<form method="POST" action="{{ route('cart.add') }}">
  @csrf
  <input type="hidden" name="item_id" value="{{ $item->id }}">
  <input type="hidden" name="name_print_num" value="{{ $item->name_print_num }}">
  <p>商品名：{{ $item->name }}</p>
  <img style="height:50px;" src="{{ asset('images/'. $item->imageFirst->filename ?? '') }}">
  <img style="height:50px;" src="{{ asset('images/'. $item->imageSecond->filename ?? '') }}">
  <img style="height:50px;" src="{{ asset('images/'. $item->imageThird->filename ?? '') }}">
  <img style="height:50px;" src="{{ asset('images/'. $item->imageFourth->filename ?? '') }}">
  <p>商品説明：{{ $item->information }}</p>
  <p id="price">価格：{{ number_format($item->price) }}円</p>
  色：<select name="color" id="">
    @foreach($products as $product)
    <option value="{{$product->color->id}}">{{$product->color->name}}</option>
    @endforeach
  </select><br>
  サイズ：<select name="size">
    @foreach($sizes as $size)
    <option value="{{$size->id}}">{{$size->name}}</option>
    @endforeach
  </select><br>
  @if($item['name_print_num'] > 0)
  名入れ1:<input type="text" name="name_print1" value="{{ old('name_print1') }}"><br>
  @endif
  @error('name_print1')
  <p style="color:red;">{{ $message }}</p>
  @enderror
  @if($item['name_print_num'] > 1)
  名入れ2:<input type="text" name="name_print2" value="{{ old('name_print2') }}"><br>
  @endif
  @error('name_print2')
  <p style="color:red;">{{ $message }}</p>
  @enderror
  @if($item['name_print_num'] > 2)
  名入れ3:<input type="text" name="name_print3" value="{{ old('name_print3') }}"><br>
  @endif
  @error('name_print3')
  <p style="color:red;">{{ $message }}</p>
  @enderror

  数：<select name="num">
    @for ($i = 1; $i <= 5; $i++) <option value="{{ $i }}">{{ $i }}</option>
      @endfor
  </select><br>
  <p id="sum"></p>
  <a class="button" href="{{route('item.showAll')}}">戻る</a>
  <button class="button" type="submit">カートに入れる</button>
</form>
<br>
<a class="button" href="{{route('cart.index')}}">カートに移動する</a>

<script>
  // 初期値の設定
  const select = document.querySelector("select[name='num']");
  let price = document.querySelector("#price").textContent.replace(/[^0-9]/g, '');
  let num = select.value;
  document.querySelector("#sum").textContent = `合計：${(num * price).toLocaleString()}円`;

  // select要素のchangeイベントリスナーの設定
  select.addEventListener('change', function() {
    let num = this.value;
    document.querySelector("#sum").textContent = `合計：${(num * price).toLocaleString()}円`;
  });
</script>
@endsection