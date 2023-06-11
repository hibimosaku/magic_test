<?php
$prefectures = config('prefectures');
?>

@extends('layouts.layout-nonav')

@section('content')
<h2>問い合わせ</h2>
<hr>
<form action="{{route('inquiry.send')}}">
  名前<input type=" text" name="name" value="{{ old('name') }}"><br>
  @error('name')
  <p style="color:red;">{{ $message }}</p>
  @enderror
  メールアドレス<input type="email" name="email" value="{{ old('email') }}"><br>
  @error('email')
  <p style="color:red;">{{ $message }}</p>
  @enderror
  電話番号<input type="number" name="tel" value="{{ old('tel')}}"><br>
  @error('tel')
  <p style="color:red;">{{ $message }}</p>
  @enderror

  <h3>住所</h3>
  郵便番号<input type="number" name="postal_code" value="{{ old('postal_code')}}"><br>
  @error('postal_code')
  <p style="color:red;">{{ $message }}</p>
  @enderror
  都道府県
  <select name="prefecture" id="" value="{{ old('prefecture')}}">
    @foreach ($prefectures as $value => $label)
    <option value="{{ $label }}" @if(old('prefecture') selected @endif>{{ $label }}</option>
    @endforeach
  </select><br>
  @error('prefecture')
  <p style="color:red;">{{ $message }}</p>
  @enderror
  市区町村<input type="text" name="city" value="{{ old('city')}}"><br>
  @error('city')
  <p style="color:red;">{{ $message }}</p>
  @enderror
  番地<input type="text" name="address1" value="{{ old('address1')}}"><br>
  @error('address1')
  <p style="color:red;">{{ $message }}</p>
  @enderror
  建物・部屋番号<input type="text" name="address2" value="{{ old('address2')}}"><br>
  @error('address2')
  <p style="color:red;">{{ $message }}</p>
  @enderror
  内容<br>
  <textarea name="content" cols="50" rows="10" maxlength="500">{{ old('content') }}</textarea><br>
  @error('content')
  <p style="color: red;">{{ $message }}</p>
  @enderror

  <button class="button" type="submit">送信</button>
</form>



@endsection