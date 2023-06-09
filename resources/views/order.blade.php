@extends('layouts.layout-nonav')

@section('content')
<?php
$prefectures = config('prefectures');

if (empty($cart)) {
  $cart = json_decode(old('cart', '[]'), true);
}

?>

<form method="GET" action="{{ route('order.indexConfirm') }}">
  @csrf
  <button type="submit" class="button">購入確認</button><br>

  <input type="hidden" name="cart" value="{{ json_encode($cart) }}">
  @foreach($cart as $item)
  <img style="height:50px;" src="{{ asset('images/'. $item['image1'] ?? '') }}">
  <img style="height:50px;" src="{{ asset('images/'. $item['image2'] ?? '') }}">
  <p>名前：{{$item['name']}}</p>
  <p>色：{{$item['colorName']}}</p>
  <p>サイズ：{{$item['sizeName']}}</p>
  <p>価格：{{number_format($item['price'])}}円</p>
  <p>数：{{$item['num']}}</p>
  <p>合計：{{number_format($item['price']*$item['num'])}}円</p>
  <hr>
  @endforeach
  支払方法<select name="pay" onChange="showContent(this)">
    <option value="" selected></option>
    <option value="credit" {{ old('pay', session('user_info.pay')) === 'credit' ? 'selected' : '' }}>クレジット</option>
    <option value="bank" {{ old('pay', session('user_info.pay')) === 'bank' ? 'selected' : '' }}>振込</option>
    <option value="cash" {{ old('pay', session('user_info.pay')) === 'cash' ? 'selected' : '' }}>代引き</option>
  </select>
  <br>
  @error('pay')
  <p style="color:red;">{{ $message }}</p>
  @enderror

  <div>
    <div id="credit" class="payment-content">
      <p>クレジット内容</p>
    </div>
    <div id="bank" class="payment-content" style="display:none;">振込内容</div>
    <div id="cash" class="payment-content" style="display:none;">代引き内容</div>
  </div><br>
  @error('postal_code')
  <p style="color:red;">{{ $message }}</p>
  @enderror

  名前<input type="text" name="name" value="{{ old('name', session('user_info.name', '')) }}"><br>
  @error('name')
  <p style="color:red;">{{ $message }}</p>
  @enderror
  メールアドレス<input type="email" name="email" value="{{ old('email', session('user_info.email', '')) }}"><br>
  @error('email')
  <p style="color:red;">{{ $message }}</p>
  @enderror
  電話番号<input type="number" name="tel" value="{{ old('tel', session('user_info.tel', '')) }}"><br>
  @error('tel')
  <p style="color:red;">{{ $message }}</p>
  @enderror

  <h3>住所</h3>
  郵便番号<input type="number" name="postal_code" value="{{ old('postal_code',session('user_info.postal_code',''))}}"><br>
  @error('postal_code')
  <p style="color:red;">{{ $message }}</p>
  @enderror
  都道府県
  <select name="prefecture" id="" value="{{ old('prefecture')}}">
    @foreach ($prefectures as $value => $label)
    <option value="{{ $label }}" @if(old('prefecture',session('user_info.prefecture',''))==$label) selected @endif>{{ $label }}</option>
    @endforeach
  </select><br>
  @error('prefecture')
  <p style="color:red;">{{ $message }}</p>
  @enderror
  市区町村<input type="text" name="city" value="{{ old('city',session('user_info.city',''))}}"><br>
  @error('city')
  <p style="color:red;">{{ $message }}</p>
  @enderror
  番地<input type="text" name="address1" value="{{ old('address1',session('user_info.address1',''))}}"><br>
  @error('address1')
  <p style="color:red;">{{ $message }}</p>
  @enderror
  建物・部屋番号<input type="text" name="address2" value="{{ old('address2',session('user_info.address2',''))}}"><br>
  @error('address2')
  <p style="color:red;">{{ $message }}</p>
  @enderror
</form>
<script>
  const contents = document.querySelectorAll(".payment-content");
  contents.forEach(content => content.style.display = "none");

  function showContent(element) {
    const selected = element.value;
    contents.forEach(content => content.style.display = "none");
    document.querySelector(`#${selected}`).style.display = "block";
  }
</script>
@endsection