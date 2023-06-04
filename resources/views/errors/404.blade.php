@extends('errors::minimal')

@section('title', __('Not Found'))
@section('code', '404')
@section('message', __('Not Found,リクエストされたリソースが存在しない場合に返されるエラーコードです。リソースが見つからなかったことを示します。'))