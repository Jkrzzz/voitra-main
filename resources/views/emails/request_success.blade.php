@extends('user.layouts.mail_layout')
@section('content')
<div class="mail-template">
  <p>{{$data['user']->name}}様</p>
  <p>【voitra】ブラッシュアッププランの予約を頂きありがとうございます。</p>
  <p>　---------------------------------------</p>
  <p>　※まだブラッシュアッププランは確定しておりませんのでご注意下さい。</p>
  <p>　---------------------------------------</p>
  <p>　ご予約いただいた内容を元に、納品日の確認を行います。</p>
  <p>　最大１営業日を目安にご連絡いたしますので今しばらくお待ち下さい。</p>
  <p>　※お急ぎの場合は、別途ご連絡をお願いします。</p>
  <p>　予約詳細は、マイページをご確認ください。</p>
  <p>　{{ $app['url']->to('/') }}</p>
    @foreach ( $data['order']->audios as $audio)
        <p>ファイル名：{{ $audio->name }}</p>
    @endforeach
  <p>　＜今後の流れ＞</p>
  <p>　「【voitra】ブラッシュアッププラン 納品予定日のお知らせ」というタイトルの</p>
  <p>　メールで納品予定日をお知らせ致します。</p>
  <p>　納品予定日の通知から24時間以内にご確認いただき、</p>
  <p>　内容に承諾頂けましたら、決済及びお申込みにお進み下さい。</p>
  <p>　＜ご注意＞</p>
  <p>　納品予定日の通知から24時間以上経過しますと、納期がずれ、</p>
  <p>　お申込みいただくことができなくなりますので予めご了承下さい。</p>
  <p>　＜注意事項＞</p>
  <p>　・ブラッシュアッププランの対応言語は日本語のみとなります。</p>
  <p>　・雑音などが含まれている場合や、認識が困難な専門用語や固有名詞などが含まれる場合は、正確にテキスト化できない可能性がございます。</p>
  <p>　・本サービスは、完全なテキスト修正を保証するものではございません。（独特な言い回しや発音など）</p>
  <p>　・ブラッシュアッププランは、文章の内容や量により、納品希望日にお答えできない場合がございます。ご予約完了後、正式な納品予定日をご確認の上お申し込み下さい。</p>
  <p>※当メールは送信専用メールアドレスから配信されています。</p>
  <p>このままご返信いただいてもお答えできませんのでご了承ください。</p>
  <p>※当メールにお心当たりの無い場合は、下記URLにアクセスし、</p>
  <p>　お問い合わせフォームよりご連絡下さい。</p>
  <p>URL：{{ $app['url']->to('/contact') }}</p>
</div>
@endsection