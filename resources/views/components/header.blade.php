<header class="header">
  <h1><a href="{{route('top')}}">MAGIC販売</a></h1>
  @auth
  <p>{{ Auth::user()->name }}さん</p>
  @else
  <p>ゲストさん</p>
  @endauth
  <nav class="header_nav">
    <ul class="header_menu">
      <li><a href="{{route('item.showAll')}}">商品一覧</a></li>
      <li><a href="{{route('guide')}}">利用者ガイド</a></li>
      <li><a href="{{route('cart.index')}}">カート</a></li>
      <li><a href="{{route('inquiry')}}">お問い合わせ</a></li>
      @if (Route::has('login'))
      @auth
      <li><a href="{{route('profile.edit')}}">プロフィール</a></li>
      <li>
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <a :href="route('logout')" onclick="event.preventDefault();
                                                this.closest('form').submit();">
            ログアウト
          </a>
        </form>

      </li>
      @else
      <li>
        <a href="{{ route('login') }}">ログイン</a>
      </li>
      @if (Route::has('register'))
      <li>
        <a href="{{ route('register') }}">新規登録</a>
      </li>
      @endif
      @endauth
      </div>
      @endif
    </ul>
  </nav>
</header>