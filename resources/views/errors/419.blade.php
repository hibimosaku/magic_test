@extends('errors::minimal')

@section('title', __('Page Expired'))
@section('code', '419')
@section('message', __('Page Expired,Authentication Timeout: LaravelのCSRFトークンの検証に失敗した場合に返されるエラーコードです。セッションがタイムアウトしたか、無効になった場合に発生することがあります。'))