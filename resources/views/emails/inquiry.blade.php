<?php
$prefectures = config('prefectures');
?>

@extends('layouts.layout-nonav')

@section('content')
<h2>問い合わせ</h2>
<hr>
<form action="{{route('inquiry.send')}}">
  名前<input type=" text" name="name" value="{{ old('name', session('user_info.name', '')) }}"><br>
  @error('name')
  <p style="color:red;">{{ $message }}</p>
  @enderror
  メールアドレス<input type="email" name="email" value="{{ old('email', session('user_info.email', '')) }}"><br>
  @error('email')
  <p style="color:red;">{{ $message }}</p>
  @enderror
  電話番号<input type="number" name="tel" value="{{ old('tel', session('user_info.tel', '')) }}"><br>
  @error('tel')
  <p style="color:red;">{{ $message }}</p>
  @enderror

  <h3>住所</h3>
  郵便番号<input type="number" name="postal_code" value="{{ old('postal_code',session('user_info.postal_code',''))}}"><br>
  @error('postal_code')
  <p style="color:red;">{{ $message }}</p>
  @enderror
  都道府県
  <select name="prefecture" id="" value="{{ old('prefecture')}}">
    @foreach ($prefectures as $value => $label)
    <option value="{{ $label }}" @if(old('prefecture',session('user_info.prefecture',''))==$label) selected @endif>{{ $label }}</option>
    @endforeach
  </select><br>
  @error('prefecture')
  <p style="color:red;">{{ $message }}</p>
  @enderror
  市区町村<input type="text" name="city" value="{{ old('city',session('user_info.city',''))}}"><br>
  @error('city')
  <p style="color:red;">{{ $message }}</p>
  @enderror
  番地<input type="text" name="address1" value="{{ old('address1',session('user_info.address1',''))}}"><br>
  @error('address1')
  <p style="color:red;">{{ $message }}</p>
  @enderror
  建物・部屋番号<input type="text" name="address2" value="{{ old('address2',session('user_info.address2',''))}}"><br>
  @error('address2')
  <p style="color:red;">{{ $message }}</p>
  @enderror
  <button class="button" type="submit">送信</button>
</form>







@endsection