@extends('errors::minimal')

@section('title', __('Unauthorized'))
@section('code', '401')
@section('message', __('Unauthorized,認証が必要なリソースに対して認証が行われていない場合や、認証情報が不正な場合に返されるエラーコードです。'))