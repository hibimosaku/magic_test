@extends('errors::minimal')

@section('title', __('Too Many Requests'))
@section('code', '429')
@section('message', __('Too Many Requests,クライアントが制限を超えたリクエストを行った場合に返されるエラーコードです。アクセス制限が設定されている場合などに使用されます。'))