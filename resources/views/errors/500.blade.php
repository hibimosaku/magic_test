@extends('errors::minimal')

@section('title', __('Server Error'))
@section('code', '500')
@section('message', __('Server Error,サーバ内部でエラーが発生した場合に返されるエラーコードです。何らかの処理が予期せず失敗した場合に表示されます。'))