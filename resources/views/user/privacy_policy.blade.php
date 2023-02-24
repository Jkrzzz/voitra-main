@extends('user.layouts.layout')

@section('title','プライバシーポリシー')
@section('right-header-img')
    <img src="{{ asset('user/images/policy-header.png') }}">
@endsection
@section('content')
    <div class="page">
        <div class="section">
            <div class="container">
                <h4 class="section-title">Privacy policy</h4>
                <h1 class="section-sub-title">プライバシーポリシー</h1>

                <div class="d-flex justify-content-center">
                    <div class="policy-box">
                        <h2 class="policy-title">第1条 （適用範囲）</h2>
                        <div class="policy-content">
                            <p>
                                本プライバシーポリシーは、本利用規約と一体となるものとして、株式会社オルツ（以下「当社」といいます。）の提供する本サービスの利用および本サイトの閲覧に適用されます。ユーザーは、本利用規約および本プライバシーポリシーに同意した場合にのみ本サービスを利用し本サイトを閲覧することができるものとします。本プライバシーポリシーの内容に同意いただけない場合は、ただちにブラウザを閉じ本サイトの閲覧を中止してください。 </p>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-center">
                    <div class="policy-box">
                        <h2 class="policy-title">第2条 (用語の定義）</h2>
                        <div class="policy-content">
                            <p>
                                本プライバシーポリシーにおいて、以下に掲げる用語は以下の各号に掲げる内容を意味するものとします。本条に定める他、本利用規約に定める用語は、別段の定めがある場合または文脈上明らかに異なる意味を有する場合を除き、本プライバシーポリシーにおいても同じ内容を意味します。</p>
                            <ul>
                                <li>(1)「広告配信事業者」とは、当社が契約する広告配信事業者をいいます。</li>
                                <li>(2)「保有個人データ」とは、個人情報保護法第2条第7項に定める保有個人データをいいます。</li>
                                <li>(3)「本プライバシーポリシー」とは、AI GIJIROKUプライバシーポリシーをいい、更新された内容を含むものとします。</li>
                                <li>(4)「本利用規約」とは、AI GIJIROKU利用規約をいい、更新された内容を含むものとします。</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-center">
                    <div class="policy-box">
                        <h2 class="policy-title">第3条 (プライバシーポリシーへの同意）</h2>
                        <div class="policy-content">
                            <p>ユーザーは、本利用契約を締結し、本サービスを利用しまたは本サイトの閲覧を継続することにより、本プライバシーポリシーに同意したものとします。</p>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-center">
                    <div class="policy-box mb-0">
                        <h2 class="policy-title">第4条 （本サービスにおいて取得する情報）</h2>
                        <div class="policy-content">
                            <p>
                                当社は、本サービスにおいてユーザーから以下に掲げる情報を取得することがあります。ユーザーが以下に掲げる情報の提供に同意しない場合、本サービスをご利用いただくことはできません。</p>
                            <ul>
                                <li>(1) ユーザー認証情報、ユーザーによる本サービスの登録もしくは登録内容の変更により取得する情報、およびユーザーからの問い合わせもしくは連絡を通じて取得する情報。以下に掲げる情報を含みますがこれらに限られないものとします。
                                </li>
                                <li>
                                    <span><i class="fas fa-circle"></i> 氏名</span>
                                    <span><i class="fas fa-circle"></i> メールアドレス</span>
                                    <span><i class="fas fa-circle"></i> 会社名</span>
                                    <span><i class="fas fa-circle"></i> 電話番号</span>
                                    <span><i class="fas fa-circle"></i> カスタマーサポートへの問い合わせからの情報</span>
                                    <span><i class="fas fa-circle"></i> 評価または苦情その他のユーザーからのフィードバック情報</span>
                                </li>
                                <li><p>(2) ユーザーによる本サービスの利用または本サイトの閲覧を通じて自動的に取得する情報。</p>
                                    <p>位置情報</p>
                                    <p>本サービスの利用状況に関する情報（動作設定の情報、ファイルのアップロード数、クラッシュ発生時のデバイスの向きを含みますがこれらに限られません。）</p>
                                    <p>本サービスへのアクセス日時</p>
                                    <p>本サービスを利用する際に使用したデバイスのOS、アプリケーションおよびブラウザの種類およびバージョン情報ならびに閲覧したページ（ユーザーが本サービスを利用する前に利用した第三者のウェブサイトを含みます）</p>
                                    <p>本サービスを利用する際に使用した機器の情報、ハードウェアのモデル、IPアドレス、MACアドレスその他の一意の識別子、選択言語、広告識別子、シリアル番号、機器の動作情報およびモバイルネットワーク情報</p>
                                    <p class="pb-0">本サービスの利用にあたり当社に送信した音声データ、当社又は当社の委託を受けた者が ユーザーの音声データを処理して生成したテキストデータ等</p>
                                </li>
                                <li><p>(3) 第三者の運営するサービスを通じて取得する情報</p>
                                    <p class="pb-0">ユーザーが第三者の運営するサービスを通じて当社によるユーザー情報の取得を許可した場合、当社はユーザーの情報を取得することがあります。その場合、本サービスの向上やユーザーの関心にあった広告を提供するために、当社が独自にユーザーから取得する情報と、第三者から得た情報を適合させることがあります。</p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
