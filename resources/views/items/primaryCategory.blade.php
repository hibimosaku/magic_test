@extends('layouts.layout-nav')

@section('content')


<h3>{{$primarycategory->name}}</h3>
<hr>

<section class="search">
  <form action="{{ route('item.showByPrimaryCategory', ['primarycategoryid' => $primarycategory->id, 'category' => $request->category, 'order' => $request->order, 'keyword' => $request->keyword]) }}">

    @csrf
    検索キーワード：<input id="keyword" style="border:1px solid black;" type="search" name="keyword" value={{Request::get('keyword')}}><br>
    カテゴリー：<select name="category" id="category">
      <option value="0" @if(e(Request::get('category')==="0" )) selected @endif>all</option>
      @foreach($secondarycategory as $category)
      <option value="{{$category->id}}" @if(\Request::get('category')==$category->id) selected @endif>{{$category->name}}</option>
      @endforeach
    </select>

    <p>並び替え：<br>
      <input type="radio" name="order" value="no" @if(e(Request::get('order')==="no" )) checked @endif checked>変更なし
      <input type="radio" name="order" value="latest" @if(e(Request::get('order')==="latest" )) checked @endif>最新順
      <input type="radio" name="order" value="priceHigh" @if(e(Request::get('order')==="priceHigh" )) checked @endif>価格高い順
      <input type="radio" name="order" value="priceLow" @if(e(Request::get('order')==="priceLow" )) checked @endif>価格低い順
    </p>
  </form>
  <p>件数：{{$items->total()}}件</p>
</section>
@if($items->count() > 0)
<section class="items">
  @foreach($items as $item)
  <div class="items__item">
    <a href="{{ route('item.show', ['id' => $item->id]) }}">
      <p>id：{{ $item->id }}</p>
      <p>名前：{{ $item->name }}</p>
      @if ($item->imageFirst)
      <!-- <p>{{ $item->imageFirst->filename }}</p> -->
      <p>カテゴリー：{{ $item->secondaryCategory->name}}</p>
      <p>{{ number_format($item->price_tax) }}円</p>
      <p>作成日：{{ $item->created_at }}</p>
      <img style="height:50px;" src="{{ asset('images/item/'. $item->imageFirst->filename) }}">
      @else
      <p>画像なし</p>
      @endif
    </a>
  </div>
  @endforeach
</section>
@else
<p>該当商品はございません。</p>
@endif

<script>
  const keyword = document.querySelector('#keyword')
  keyword.addEventListener('change', function(e) {
    this.form.submit();
  })

  const category = document.querySelector('#category')
  category.addEventListener('change', function(e) {
    this.form.submit();
  })


  const orderRadios = document.getElementsByName('order');

  // ラジオボタンの変更イベントを監視
  orderRadios.forEach(radio => {
    radio.addEventListener('change', function() {
      this.form.submit();
    });
  });
  // ペジネーションのイベント
  const paginationLinks = document.querySelectorAll('.pagination a');
  paginationLinks.forEach(link => {
    link.addEventListener('click', function(e) {
      e.preventDefault();
      const url = new URL(this.href);
      const keywordValue = keyword.value;
      const selectedOrder = document.querySelector('input[name="order"]:checked').value;

      // キーワード情報をクエリパラメータとして追加
      url.searchParams.set('keyword', keywordValue);
      // 並び替え情報をクエリパラメータとして追加
      url.searchParams.set('order', selectedOrder);

      // リンク先にリダイレクト
      window.location.href = url.toString();
    });
  });
</script>

@endsection