<a href="{{route('top')}}">topに戻る</a><br>
<a href="{{route('cart.index')}}">カートに戻る</a><br>

<form action="route('success')">

      @foreach($cart as $item)
            <img style="height:50px;" src="{{ asset('images/'. $item['image1'] ?? '') }}">
            <p>名前：{{$item['name']}}</p>
            <p>色：{{$item['colorName']}}</p>
            <p>サイズ：{{$item['sizeName']}}</p>
            <p>価格：{{number_format($item['price'])}}円</p>
            <p>数：{{$item['num']}}</p>
            <p>合計：{{number_format($item['price']*$item['num'])}}円</p><hr>
      @endforeach
      <p>総額：{{number_format($allSum)}}円</p>
      <p>支払い方法：{{$pay}}</p>
      <p>送り先</p>
      <p>〒{{$postal_code}}</p>
      <p>{{$prefecture}}{{$city}}{{$address1}}{{$address2}}</p>
      <button>注文決定</button>
</form>