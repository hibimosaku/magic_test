<?php
  $prefectures = config('prefectures');
  
  if(empty($cart)){
    $cart = json_decode(old('cart', '[]'), true);
    // dd($cart);
  }else{
    // dd($cart);
  };
  
?>

<a href="{{route('top')}}">topに戻る</a><br>
<a href="{{route('cart.index')}}">カートに戻る</a><br>





<form method="GET" action="{{ route('order.indexConfirm') }}">    
    @csrf
    <button type="submit">購入確認</button><br>

    <input type="hidden" name="cart" value="{{ json_encode($cart) }}">
    @foreach($cart as $item)
      <img style="height:50px;" src="{{ asset('images/'. $item['image1'] ?? '') }}">
      <img style="height:50px;" src="{{ asset('images/'. $item['image2'] ?? '') }}">
      <p>名前：{{$item['name']}}</p>
      <p>色：{{$item['colorName']}}</p>
      <p>サイズ：{{$item['sizeName']}}</p>
      <p>価格：{{number_format($item['price'])}}円</p>
      <p>数：{{$item['num']}}</p>
      <p>合計：{{number_format($item['price']*$item['num'])}}円</p><hr>
    @endforeach

    
    
    <h3>支払方法</h3>
    <select name="pay" onChange="showContent(this)">
      <option value="" selected></option>
      <option value="credit">クレジット</option>
      <option value="bank">振込</option>
      <option value="cash">代引き</option>
    </select><br>    
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

    <h3>住所</h3>
    郵便番号<input type="text" name="postal_code" value="{{ old('postal_code')}}"><br>
    @error('postal_code')
      <p style="color:red;">{{ $message }}</p>
    @enderror
    都道府県
    <select name="prefecture" id="" value="{{ old('prefecture')}}">
      @foreach ($prefectures as $value => $label)
          <option value="{{ $label }}" @if(old('prefecture')==$label) selected @endif>{{ $label }}</option>
      @endforeach
    </select><br>
    @error('prefecture')
      <p style="color:red;">{{ $message }}</p>
    @enderror
    市区町村<input type="text" name="city"><br>
    @error('city')
      <p style="color:red;">{{ $message }}</p>
    @enderror
    番地<input type="text" name="address1"><br>
    @error('address1')
      <p style="color:red;">{{ $message }}</p>
    @enderror
    建物・部屋番号<input type="text" name="address2"><br>
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
