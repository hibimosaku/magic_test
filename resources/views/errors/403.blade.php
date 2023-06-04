@extends('errors::minimal')

@section('title', __('Forbidden'))
@section('code', '403')
@section('message', __(リクエストされたリソースへのアクセスが許可されていない場合に返されるエラーコードです。認証は成功しているが、アクセス権が不足している場合に使用されます。,$exception->getMessage() ?: 'Forbidden'))