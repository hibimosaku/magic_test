@extends('layouts.layout-nav')

@section('content')
{{ $items->links('pagination') }}
<!-- カテゴリ分類 -->
<!-- formに書いているcategoryはselectのnameのこと -->
<form action="{{route('top',['category','order','keyword'])}}">
    @csrf
    検索キーワード：<input id="keyword" style="border:1px solid black;" type="text" name="keyword" value={{Request::get('keyword')}}><br>
    カテゴリー：<select name="category" id="category">
        <option value="0" @if(e(Request::get('category')==="0" )) selected @endif>all</option>
        @foreach($categories as $category)
        <option value="{{$category->id}}" @if(\Request::get('category')==$category->id) selected @endif>{{$category->name}}</option>
        @endforeach
    </select>
    <p>並び替え：<br>
        <input type="radio" name="order" value="no" @if(e(Request::get('order')==="no" )) checked @endif checked>変更なし
        <input type="radio" name="order" value="latest" @if(e(Request::get('order')==="latest" )) checked @endif>最新順
        <input type="radio" name="order" value="priceHigh" @if(e(Request::get('order')==="priceHigh" )) checked @endif>価格高い順
        <input type="radio" name="order" value="pricelow" @if(e(Request::get('order')==="pricelow" )) checked @endif>価格低い順
    </p>
</form>
<p>件数：{{$items->total()}}件</p>
@if($items->count() > 0)
@foreach($items as $item)
<div>
    <a href="{{ route('item.show', ['id' => $item->id]) }}">
        <p>id：{{ $item->id }}</p>
        <p>名前：{{ $item->name }}</p>
        @if ($item->imageFirst)
        <!-- <p>{{ $item->imageFirst->filename }}</p> -->
        <p>カテゴリー：{{ $item->secondaryCategory->name}}</p>
        <p>{{ number_format($item->price) }}円</p>
        <p>作成日：{{ $item->created_at }}</p>
        <img style="height:50px;" src="{{ asset('images/'. $item->imageFirst->filename) }}">
        @else
        <p>画像なし</p>
        @endif
    </a>
</div>
@endforeach
@else
<p>該当商品はございません。</p>
@endif

<div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">
    @if (Route::has('login'))
    <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
        @auth
        <a href="{{ url('/dashboard') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Dashboard</a>
        @else
        <a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Log in</a>

        @if (Route::has('register'))
        <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">Register</a>
        @endif
        @endauth
    </div>
    @endif
</div>
<script>
    const category = document.querySelector('#category')
    category.addEventListener('change', function(e) {
        this.form.submit();
    })

    const keyword = document.querySelector('#keyword')
    keyword.addEventListener('change', function(e) {
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
            const categoryId = category.value;
            const keywordValue = keyword.value;
            const selectedOrder = document.querySelector('input[name="order"]:checked').value;

            // カテゴリー情報をクエリパラメータとして追加
            url.searchParams.set('category', categoryId);
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