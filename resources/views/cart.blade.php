<a href="{{route('top')}}">topに戻る</a><br>
@if(!$cart)
<p>カート空です</p>
@else
  <p>合計金額:{{number_format($allSum)}}円</p>
  <form method="GET" action="{{route('order.index')}}">
    <input type="hidden" name="cart" value="{{ json_encode($cart) }}">
    <button type="submit">購入手続きへ</button>
  </form>
  <hr>

<!-- <a href="{{ url()->previous() }}">前のページに移動</a><br> -->
  @foreach($cart as $item)
    <a href="{{route('item.show',['id' => $item['itemId']])}}">商品のページに戻る</a><br>
      <img style="height:50px;" src="{{ asset('images/'. $item['image1'] ?? '') }}">
      <img style="height:50px;" src="{{ asset('images/'. $item['image2'] ?? '') }}">
      <img style="height:50px;" src="{{ asset('images/'. $item['image3'] ?? '') }}">
      <img style="height:50px;" src="{{ asset('images/'. $item['image4'] ?? '') }}">
      <p>名前：{{$item['name']}}</p>
      <p>色：{{$item['colorName']}}</p>
      <p>サイズ：{{$item['sizeName']}}</p>
      <p>価格：{{number_format($item['price'])}}</p>

      <form method="POST" action="{{ route('cart.update',['id' =>$item['itemId'],'color' =>$item['color'],'size' =>$item['size']]) }}">
        @csrf
        @method('PUT')
        <select name="num" onChange="this.form.submit()">
            @if(isset($item['num']) && $item['num'] > $ITEMNUM )
                <option value="{{ $item['num'] }}" selected>{{ $item['num'] }}</option>
            @endif
            @for ($i = 1; $i <= $ITEMNUM; $i++)
                <option value="{{ $i }}" {{ isset($item['num']) && $item['num'] == $i ? 'selected' : '' }}>{{ $i }}</option>
            @endfor
        </select>
      </form>
      <p>合計{{number_format($item['price'] * $item['num'])}}</p>

      <form method="POST" action="{{ route('cart.delete',['id' =>$item['itemId'],'color' =>$item['color'],'size' =>$item['size']]) }}">
        @csrf
        @method('DELETE')
        <button type="submit">削除</button>
      </form>
      <hr>
  @endforeach
@endif