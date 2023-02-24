@extends('user.layouts.mail_layout')
@section('content')
<div class="mail-template">
  <p>【voitra 対応】ブラッシュアッププラン 納品予定日確認予約が入りました。</p>
  <p>　ご予約いただいた内容を元に、納品予定日の確認をして下さい。</p>
  <p>　今から24時日以内にお客様へご連絡お願いします。</p>
  <p>　</p>
  <p>　＜仮お申し込み内容＞</p>
  <p>　名前：{{$data['user']->name}}様</p>
  @foreach ($data['order']->audios as $audio)
  <p>　ファイル名： {{$audio->name}} </p>
  <p>　文字数： {{$audio->total_time}} </p>
  <p>　金額： {{$audio->total_price}} </p>
  <p>　希望納品日：{{$audio->orders()->find($data['order']->id)->pivot->user_estimate}} </p>
  @endforeach
  <p>  申込ID: {{ $data['order']->id }}</p>
  <p>　対象ファイルを下記からご確認下さい。</p>
  <p>　{{ $app['url']->to('/') }}</p>
</div>
@endsection
