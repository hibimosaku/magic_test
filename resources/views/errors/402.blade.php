@extends('errors::minimal')

@section('title', __('Payment Required'))
@section('code', '402')
@section('message', __('Payment Required,支払いが必要なリソースに対して支払いが行われていない場合に返されるエラーコードです。一般的にはあまり使用されません。'))