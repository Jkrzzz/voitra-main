@extends('user.layouts.layout')

@section('title','利用規約')
@section('right-header-img')
    <img src="{{ asset('user/images/policy-header.png') }}">
@endsection
@section('content')
    <div class="page">
        <div class="section">
            <div class="container">
                <h4 class="section-title">Terms of using</h4>
                <h1 class="section-sub-title">利用規約</h1>

                <div class="d-flex justify-content-center">
                    <div class="policy-box">
                        <h2 class="policy-title">第1条 (適用範囲）</h2>
                        <div class="policy-content">
                            <p>
                                本利用規約は株式会社オルツ（以下「当社」といいます。）の提供する本サービスの利用に適用されます。ユーザーは本利用規約およびプライバシーポリシーに同意した場合にのみ本サービスを利用することができるものとします。
                            </p>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-center">
                    <div class="policy-box mb-0">
                        <h2 class="policy-title">第2条 (用語の定義）</h2>
                        <div class="policy-content">
                            <p>本利用規約において、以下に掲げる用語は以下の各号に掲げる内容を意味するものとします。</p>
                            <ul>
                                <li>(1)「禁止行為」とは、第12条第1項に掲げる各行為をいいます。</li>
                                <li>(2)「個人情報」とは、生存する個人に関する情報であって、次の各号のいずれかに該当するものをいいます。ユーザーの個人情報には、ユーザーの氏名、電子メールアドレス、組織名、所在地、電話番号、ソーシャル・ネットワークサービスのアカウントを含みます。</li>
                                <li class="my-2"><span>(i) 当該情報に含まれる氏名、生年月日その他の記述等（文書、図画もしくは電磁的記録で作られる記録をいう）に記載され、もしくは記録され、または音声、動作その他の方法を用いて表された一切の事項により特定の個人を識別することができるもの（他の情報と容易に照合することができ、それにより特定の個人を識別することができることとなるものを含む。）</span>
                                    <span>(ii) 個人識別符号が含まれるもの</span></li>
                                <li>(3)「個人情報保護法」とは、個人情報の保護に関する法律（平成15年法律第57号）をいい、その後の改正を含むものとします。</li>
                                <li>(3)「個人情報保護法」とは、個人情報の保護に関する法律（平成15年法律第57号）をいい、その後の改正を含むものとします。</li>
                                <li>(4)「反社会的勢力」とは、暴力団、暴力団員、暴力団関係企業、総会屋、社会運動標ぼうゴロ、政治運動標ぼうゴロ、特殊知能暴力集団、その他反社会的勢力をいいます。</li>
                                <li>(5)「プライバシーポリシー」とは、当社の設定するAI GIJIROKUプライバシーポリシーをいい、更新された内容を含むものとします。</li>
                                <li>(6)「本サービス」とは、当社が提供するAI GIJIROKUに関するすべてのサービス（オプションサービスを含みますが、それに限られません。）をいいます。</li>
                                <li>(7)「本サイト」とは、当社のウェブサイトをいいます。</li>
                                <li>(8)「本利用規約」とは、AI GIJIROKU利用規約をいい、更新された内容を含むものとします。</li>
                                <li>(9)「利用契約」とは、本サービスを利用するため当社とユーザーの間で締結される契約をいいます。</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
