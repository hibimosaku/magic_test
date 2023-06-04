@extends('errors::minimal')

@section('title', __('Service Unavailable'))
@section('code', '503')
@section('message', __('Service Unavailable,サーバが一時的にリクエストに応答できない場合に返されるエラーコードです。メンテナンス中や一時的なオーバーロード時などに使用されます。'))