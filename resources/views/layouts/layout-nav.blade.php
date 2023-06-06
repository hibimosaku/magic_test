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
  @vite(['resources/css/style.scss'])
  <!-- <link rel="stylesheet" href="{{ asset('css/stripe.css') }}"> -->
  <!-- <link rel="stylesheet" href="{{ asset('css/test.scss') }}"> -->

  <script src="https://js.stripe.com/v3/"></script>


</head>

<body>
  @include('components.header')
  <div class="container-nav">
    <nav class="lnav">ローカルナビ</nav>
    <main class="main">
      @yield('content')
    </main>
    <footer class="footer">
      <p>footer</p>
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

    </footer>
  </div>
</body>

</html>