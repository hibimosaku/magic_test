<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ config('app.name', 'Laravel') }}</title>
  <link rel="stylesheet" href="https://unpkg.com/ress@4.0.0/dist/ress.min.css">

  <!-- Scripts -->
  <!-- @vite(['resources/css/app.css', 'resources/js/app.js']) -->
  @vite(['resources/css/test.scss'])
  <link rel="stylesheet" href="{{ asset('css/stripe.css') }}">
  <!-- <link rel="stylesheet" href="{{ asset('css/test.scss') }}"> -->

  <script src="https://js.stripe.com/v3/"></script>


</head>

<body>
  <header class="header">
    <h1>logo</h1>
    <nav class="header_nav">
      <ul class="header_menu">
        <li><a href="{{route('top')}}">TOP</a></li>
        <li><a href="{{route('cart.index')}}">カート</a></li>
      </ul>
    </nav>
  </header>
  <main>
    @yield('content')
  </main>
</body>

</html>