@extends('layouts.layout-nav')

@section('content')
<div>hero画面</div>

@foreach ($images as $image)
<!-- <div class="slide">
  <img style="height:150px;" src="{{ $image }}" alt="Slide Image">
</div> -->
<div id="slider" class="splide">
  <div class="splide__track">
    <ul class="splide__list">
      @foreach ($images as $image)
      <li class="splide__slide">
        <img src="{{ $image }}" alt="Slide Image">
      </li>
      @endforeach
    </ul>
  </div>
</div>
@endforeach
@endsection
<script src="
https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js
"></script>
<link href="
https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css
" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/@splidejs/splide-extension-auto-scroll@0.4.2/dist/js/splide-extension-auto-scroll.min.js"></script>
<!-- Splide Initialization -->
<script>
  document.addEventListener('DOMContentLoaded', function() {
    new Splide('#slider', {
      mediaQuery: "min",
      fixedWidth: "24rem",
      heightRatio: 0.3,
      gap: 16,
      type: "loop",
      arrows: false,
      drag: "free",
      flickPower: 100,
      pagination: false,
      autoScroll: {
        speed: 0.5,
        pauseOnHover: false,
        pauseOnFocus: true,
      },
      // breakpoints: {
      //   1025: {
      //     gap: 24,
      //     fixedWidth: "36rem",
      //   },
      // },
    }).mount(window.splide.Extensions);
  });
</script>