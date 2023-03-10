@extends('user.layouts.mail_layout')
@section('content')
<div class="mail-template">
  <p>{{$data['user']->name}}様</p>

  <p>お申し込みいただきました「【voitra】AI文字起こしプラン」のテキスト化が完了いたしました。</p>
  @foreach ( $data['order']->audios as $audio)
      <p>ファイル名：{{ $audio->name }}</p>
  @endforeach
  <p>下記マイページより、完了したテキストをご確認ください。</p>
  <p>
      尚、追加でテキストを修正希望の場合は、「ブラッシュアッププラン」をご依頼ください。 <br>
      {{ $app['url']->to('/audio/new-brushup/'.$data['order']->id) }}
  </p>

  <p>＜注意事項＞</p>
  <p>
  <ul>
    　<li>ブラッシュアッププランの対応言語は日本語のみとなります。</li>
    　<li>雑音などが含まれている場合や、認識が困難な専門用語や固有名詞などが含まれる場合は、正確にテキスト化できない可能性がございます。</li>
    　<li>本サービスは、完全なテキスト修正を保証するものではございません。（独特な言い回しや発音など）</li>
    　<li>ブラッシュアッププランは、文章の内容や量により、納品希望日にお答えできない場合がございます。ご予約完了後、正式な納品予定日をご確認の上お申し込み下さい。</li>
  </ul>
  </p>

  <p>※当メールは送信専用メールアドレスから配信されています。<br>
        このままご返信いただいてもお答えできませんのでご了承ください。</p>

    <p>※当メールにお心当たりの無い場合は、下記URLにアクセスし、<br>
        お問い合わせフォームよりご連絡下さい。<br>
        URL：{{ $app['url']->to('/contact') }}</p>
</div>
@endsection
