<?php

return [
    'userType' => [
        1 => '法人',
        2 => '個人',
    ],
    'status' => [
        0 => '退会済み',
        1 => 'アクティブ',
        2 => '未承認',
        4 => '停止'
    ],
    'adminOrderStatus' => [
        0 => 'キャンセル', //cancel
        1 => '【Admin】見積者アサイン中', // sau khi nhận reuqest từ khách
        4 => '【Staff】納期確認中', //sau khi assign cho staff estimate
        5 => '【Admin】納期確認中', // đang confirm estimate
        2 => '納期・見積もり確定', // estimated
        3 => '【Admin】編集者アサイン中',
        11 => '【Staff】編集中', // staff bắt đầu edit
        12 => '【Admin】編集結果確認中', // Admin đang confirm kết quả edit
        6 => '納品済み', // done
        7 => '期限切れ', // expired
        8 => 'キャンセル',  // error
        9 => '再入力待ち', // error
    ],
    'userOrderStatus' => [
        0 => 'キャンセル', //cancel
        1 => '予約済み', // requested
        2 => '納期・見積もり確定', // Estimated
        3 => 'ブラッシュアップ中', // Da thanh toan 決済済み -> ブラッシュアップ中
        6 => 'ブラッシュアップ済み', // done
        7 => '期限切れ', // expired
        8 => 'キャンセル', // error
        9 => '再入力待ち', // error
        4 => '予約済み',
        5 => '予約済み',
        11 => 'ブラッシュアップ中',
        12 => 'ブラッシュアップ中',
    ],
    'filterStatus' => [
        0 => 'キャンセル', //cancel
        1 => '未確認', // confirming
        2 => '納期・見積もり確定', // estimated
        3 => '決済済み', // Da thanh toan
        20 => '認識済み', // Da thanh toan
        // 4 => 'アサイン済み', // assigned
        // 5 => '提出済み', // edited
        6 => '納品済み', // done
        7 => '期限切れ', // expired
        8 => 'キャンセル', // error
        9 => '再入力待ち' // error
    ],
    'paymentStatus' => [
        0 => 'キャンセル', //cancel
        1 => '失敗', // ng
        2 => '審査中', //hold
        3 => '支払済み', // done
        4 => '確定済み', // verified
        5 => '保留', // hold
        6 => '取消返金済み', // refund
    ],
    'audioStatus' => [
        0 => 'キャンセル', //cancel
        1 => '処理中', // processing
        2 => '認識済み', // done
        3 => '認識エラー', // error
        4 => '削除', // deleted
        // 5 => '削除', // deleted
        // 6 => '削除', // deleted
        7 => 'キャンセル', //cancel
        8 => '与信中', //hold
        9 => '再入力待ち', //hold
    ],
    'contactType' => [
        1 => '文字起こしについて',
        2 => 'ご注文・お見積りについて',
        3 => '納品について',
        4 => 'ご請求・お支払いについて',
        5 => 'その他のご質問'
    ],
    'gender' => [
        1 => '男性',
        2 => '女性',
        3 => 'その他'
    ],
    'staffAssign' => [
        1 => '納品確認',
        2 => '編集',
        3 => '納品確認＆編集'
    ],
    'paymentType' => [
        1 => 'クレジットカード',
        2 => 'コンビニ後払い（ベリトランス後払い）'
    ],
    'servicePaymentStatus' => [
        0 => 'キャンセル',
        1 => '利用中',
        7 => 'キャンセル', //hold
        8 => '与信中', //hold
        9 => '再入力待ち', //hold
    ],
    'serviceStatus' => [
        0 => 'キャンセル', //cancel
        1 => 'キャンセル',
        2 => '利用中', // ok
        4 => '予約済み',
        7 => '期限切れ', // expired
        8 => 'キャンセル', // error
        9 => '再入力待ち' // error
    ],

    'notifyClass' => [
        1 => 'service-regis',
        2 => 'cancel',
        3 => 'contact',
        4 => 'postpaid',
        5 => 'plan2',
        6 => 'message',
    ],

    'notifyTitle' => [
        1 => 'オプション解約',
        2 => '退会', // ok
        3 => '問い合わせ', // ok
        4 => '後払い', // ok
        5 => 'プラン２', // ok
        6 => 'メッセージ', // ok
    ],

    'couponStatus' => [
        0 => '期限切れ', //Expired
        1 => '公開', //public
        2 => '停止'//stopped
    ],

    'language' => [
        'af-ZA' => 'アフリカーンス語（南アフリカ）',
        'sq-AL' => 'アルバニア語（アルバニア）',
        'am-ET' => 'アムハラ語（エチオピア）',
        'ar-DZ' => 'アラビア語（アルジェリア）',
        'ar-BH' => 'アラビア語（バーレーン）',
        'ar-EG' => 'アラビア語（エジプト）',
        'ar-IQ' => 'アラビア語（イラク）',
        'ar-IL' => 'アラビア語（イスラエル）',
        'ar-JO' => 'アラビア語（ヨルダン）',
        'ar-KW' => 'アラビア語（クウェート）',
        'ar-LB' => 'アラビア語（レバノン）',
        'ar-MA' => 'アラビア語（モロッコ）',
        'ar-OM' => 'アラビア語（オマーン）',
        'ar-QA' => 'アラビア語（カタール）',
        'ar-SA' => 'アラビア語（サウジアラビア）',
        'ar-PS' => 'アラビア語（パレスチナ国）',
        'ar-TN' => 'アラビア語（チュニジア）',
        'ar-AE' => 'アラビア語（アラブ首長国連邦）',
        'ar-YE' => 'アラビア語（イエメン）',
        'hy-AM' => 'アルメニア語（アルメニア）',
        'az-AZ' => 'アゼルバイジャン語（アゼルバイジャン）',
        'eu-ES' => 'バスク語（スペイン）',
        'bn-BD' => 'ベンガル語（バングラデシュ）',
        'bn-IN' => 'ベンガル語（インド）',
        'bs-BA' => 'ボスニア語（ボスニア ヘルツェゴビナ）',
        'bg-BG' => 'ブルガリア語（ブルガリア）',
        'my-MM' => 'ビルマ語（ミャンマー）',
        'ca-ES' => 'カタルーニャ語（スペイン）',
        'yue-Hant-HK' => '広東語（繁体字、香港）',
        'zh（cmn-Hans-CN）' => '中国語（簡体字、中国本土）',
        'zh-TW（cmn-Hant-TW）' => '中国語（繁体字、台湾）',
        'hr-HR' => 'クロアチア語（クロアチア）',
        'cs-CZ' => 'チェコ語（チェコ共和国）',
        'da-DK' => 'デンマーク語（デンマーク）',
        'nl-BE' => 'オランダ語（ベルギー）',
        'nl-NL' => 'オランダ語（オランダ）',
        'en-AU' => '英語（オーストラリア）',
        'en-CA' => '英語（カナダ）',
        'en-GH' => '英語（ガーナ）',
        'en-HK' => '英語（香港）',
        'en-IN' => '英語（インド）',
        'en-IE' => '英語（アイルランド）',
        'en-KE' => '英語（ケニア）',
        'en-NZ' => '英語（ニュージーランド）',
        'en-NG' => '英語（ナイジェリア）',
        'en-PK' => '英語（パキスタン）',
        'en-PH' => '英語（フィリピン）',
        'en-SG' => '英語（シンガポール）',
        'en-ZA' => '英語（南アフリカ）',
        'en-TZ' => '英語（タンザニア）',
        'en-GB' => '英語（イギリス）',
        'en-US' => '英語（米国）',
        'et-EE' => 'エストニア語（エストニア）',
        'fil-PH' => 'フィリピン語（フィリピン）',
        'fi-FI' => 'フィンランド語（フィンランド）',
        'fr-BE' => 'フランス語（ベルギー）',
        'fr-CA' => 'フランス語（カナダ）',
        'fr-FR' => 'フランス語（フランス）',
        'fr-CH' => 'フランス語（スイス）',
        'gl-ES' => 'ガリシア語（スペイン）',
        'ka-GE' => 'ジョージア語（ジョージア）',
        'de-AT' => 'ドイツ語（オーストリア）',
        'de-DE' => 'ドイツ語（ドイツ）',
        'de-CH' => 'ドイツ語（スイス）',
        'el-GR' => 'ギリシャ語（ギリシャ）',
        'gu-IN' => 'グジャラト語（インド）',
        'iw-IL' => 'ヘブライ語（イスラエル）',
        'hi-IN' => 'ヒンディー語（インド）',
        'hu-HU' => 'ハンガリー語（ハンガリー）',
        'is-IS' => 'アイスランド語（アイスランド）',
        'id-ID' => 'インドネシア語（インドネシア）',
        'it-IT' => 'イタリア語（イタリア）',
        'it-CH' => 'イタリア語（スイス）',
        'ja-JP' => '日本語（日本）',
        'jv-ID' => 'ジャワ語（インドネシア）',
        'kn-IN' => 'カンナダ語（インド）',
        'kk-KZ' => 'カザフ語（カザフスタン）',
        'km-KH' => 'クメール語（カンボジア）',
        'ko-KR' => '韓国語（韓国）',
        'lo-LA' => 'ラオ語（ラオス）',
        'lv-LV' => 'ラトビア語（ラトビア）',
        'lt-LT' => 'リトアニア語（リトアニア）',
        'mk-MK' => 'マケドニア語（北マケドニア）',
        'ms-MY' => 'マレー語（マレーシア）',
        'ml-IN' => 'マラヤーラム語（インド）',
        'mr-IN' => 'マラーティー語（インド）',
        'mn-MN' => 'モンゴル語（モンゴル）',
        'ne-NP' => 'ネパール語（ネパール）',
        'no-NO' => 'ノルウェー語（ノルウェー）',
        'fa-IR' => 'ペルシャ語（イラン）',
        'pl-PL' => 'ポーランド語（ポーランド）',
        'pt-BR' => 'ポルトガル語（ブラジル）',
        'pt-PT' => 'ポルトガル語（ポルトガル）',
        'pa-Guru-IN' => 'パンジャブ語（グルムキー、インド）',
        'ro-RO' => 'ルーマニア語（ルーマニア）',
        'ru-RU' => 'ロシア語（ロシア）',
        'sr-RS' => 'セルビア語（セルビア）',
        'si-LK' => 'シンハラ語（スリランカ）',
        'sk-SK' => 'スロバキア語（スロバキア）',
        'sl-SI' => 'スロベニア語（スロベニア）',
        'es-AR' => 'スペイン語（アルゼンチン）',
        'es-BO' => 'スペイン語（ボリビア）',
        'es-CL' => 'スペイン語（チリ）',
        'es-CO' => 'スペイン語（コロンビア）',
        'es-CR' => 'スペイン語（コスタリカ）',
        'es-DO' => 'スペイン語（ドミニカ共和国）',
        'es-EC' => 'スペイン語（エクアドル）',
        'es-SV' => 'スペイン語（エルサルバドル）',
        'es-GT' => 'スペイン語（グアテマラ）',
        'es-HN' => 'スペイン語（ホンジュラス）',
        'es-MX' => 'スペイン語（メキシコ）',
        'es-NI' => 'スペイン語（ニカラグア）',
        'es-PA' => 'スペイン語（パナマ）',
        'es-PY' => 'スペイン語（パラグアイ）',
        'es-PE' => 'スペイン語（ペルー）',
        'es-PR' => 'スペイン語（プエルトリコ）',
        'es-ES' => 'スペイン語（スペイン）',
        'es-US' => 'スペイン語（米国）',
        'es-UY' => 'スペイン語（ウルグアイ）',
        'es-VE' => 'スペイン語（ベネズエラ）',
        'su-ID' => 'スンダ語（インドネシア）',
        'sw-KE' => 'スワヒリ語（ケニア）',
        'sw-TZ' => 'スワヒリ語（タンザニア）',
        'sv-SE' => 'スウェーデン語（スウェーデン）',
        'ta-IN' => 'タミル語（インド）',
        'ta-MY' => 'タミル語（マレーシア）',
        'ta-SG' => 'タミル語（シンガポール）',
        'ta-LK' => 'タミル語（スリランカ）',
        'te-IN' => 'テルグ語（インド）',
        'th-TH' => 'タイ語（タイ）',
        'tr-TR' => 'トルコ語（トルコ）',
        'uk-UA' => 'ウクライナ語（ウクライナ）',
        'ur-IN' => 'ウルドゥー語（インド）',
        'ur-PK' => 'ウルドゥー語（パキスタン）',
        'uz-UZ' => 'ウズベク語（ウズベキスタン）',
        'vi-VN' => 'ベトナム語（ベトナム）',
        'zu-ZA' => 'ズールー語（南アフリカ）'
    ],
    'industry' => [
        1 => '農業・林業',
        2 => '漁業',
        3 => '鉱業・採石業・砂利採取業',
        4 => '建設業',
        5 => '製造業',
        6 => '電気・ガス・熱供給・水道業',
        7 => '情報通信業',
        8 => '運輸業・郵便業',
        9 => '卸売業・小売業',
        10 => '金融業・保険業',
        11 => '不動産業・物品賃貸業',
        12 => '学術研究・専門・技術サービス業',
        13 => '宿泊業・飲食サービス業',
        14 => '生活関連サービス業・娯楽業',
        15 => '教育・学習支援業',
        16 => '医療・福祉',
        17 => '複合サービス事業',
        18 => 'その他のサービス業',
        19 => '公務',
        20 => 'その他',
    ],
    'postpaidErrorStatus' => [
        'c10' => '購入者様氏名情報が不明確です。購入者フルネームをご確認下さい。',
        'c11' => '請求書不達の恐れがございますので、購入者様氏名の文字化け、特殊記号をご確認下さい。',
        'c12' => '請求書不達の恐れがございますので、購人者様氏名が本名かどうかをご確認下さい。本名である場合にはそのまま再送信してください。',
        'c13' => '会社での購入の場合も担当者様のお名前が必要です。氏名に間違いがないかご確認ください。',
        'c14' => '請求書不達の恐れがございますので、購人者様氏名が本名かどうかをご確認下さい。本名である場合には、そのまま再送信してください。',
        'c20' => '住所情報(都道府県、市区町村、地名、番地、他)の不足についてご確認下さい。',
        'c21' => '住所情報に文字化け・特殊記号が使われてないかを確認ください。使われている場合は、修正してください。',
        'c22' => '住所情報に建物名、部屋番号が不足している可能性があります。問題がない場合は、そのまま再送信してください。',
        'c33' => 'ご登録の番地には建物(集合住宅、会社、店舗、施設、学校等)が存在しております。建物名の記載をご確認ください。問題がない場合は、そのまま再送信してください。',
        'c23' => '住所情報に会社名、店舗名が不足している可能性があります。問題がない場合は、そのまま再送信してください。',
        'c24' => '登録住所情報では請求書不達の恐れがございます。住所情報が正しいかご確認ください。',
        'c25' => '配送先が購入者様のご勤務先か確認してください。',
        'c31' => '購入者名が複数のようです。購入代表者の方を入力してください。',
        'c32' => '登録請求先へのご請求については、購入者様のお勤め先である必要がございます。お勤め先であればそのまま再送信してください。そうでない場合は別のご住所をご入力下さい。',
        'c26' => 'ご登録住所に間違い変更が無いかご確認ください。',
        'c27' => '郵便番号と登録ご住所が不一致となっております。ご確認の上、修正してください。',
        'c36' => 'ご登録のご住所に関しまして、旧表記での登録となっております。世当の地域は合併、統合、変更がございますのでご修正いただきますようお願いいたします。',
        'c28' => '住所情報に番地がありません。番地をご確認の上、ご修正下さい。このままで問題がない場合はそのまま再送信してください。',
        'c29' => '住所情報(都道府県、市区町村、番地、他)の重複についてご確認ください。',
        'c34' => 'ご登録の番地部分にスペースがあるため正しく番地を認識できません。番地間にー(ハイフン)のご入力をお願いいたします。',
        'c35' => 'ご登録いただきました番地の所在の確認が取れません。番地情報に誤りがないかご確認願います。このままで問題がない場合はそのまま再送信してください。',
        'c37' => 'ご住所の地名の漢字表記に誤りがございます。正しい内容へご修正願います',
        'c38' => 'ご登録の番地をお調べしたところ該当の建物の確認が取れません。登録内容に誤りがないかご確認願いします。',
        'c30' => 'メールアドレスに不備の可能性があります。正しいメールアドレスをご確認ください。',
        'c40' => '登録の電話番号は現在不通となっているようです。正しい電話番号をご確認ください。',
        'c41' => '固定電話番号がご利用されているものかどうか確認してください。',
        'c39' => 'ご住所とご登録のお電話番号の市外局番の所在地が不ー致となっております。正しい電話番号をご確認の上、修正下さい。',
        'c42' => '',
        'c43' => '登録電話は桁不足若しくは桁過多です。正しい電話番号をご確認の上、ご修正下さい。',
        'c44' => '氏名の「名」の部分のみ一致で、登録住所と商品発送先が相違しています。氏名変更漏れの可能性がありますのでご確認ください。',
        'c50' => '本人確認の為、スコア後払決済サービスから連絡致しますので今しばらくお待ち下さい。',
        'c60' => 'ご登録の注文情報に、他注文情報との重複がございます。詳細をご確認お願い致します。',
        'c65' => '明細情報の合計金額と顧客請求金額に差額がございます。金額をご確認ください。このままで問題がない場合はそのまま送信してください。',
        'c70' => 'ご登録の商材はスコア後払決済サービスではお取り扱いできかねます。恐れ入りますが別決済をご利用ください。',
        'c80' => '詳細は別途ご連絡致します。少々お待ち下さい。',
    ],
    'prefectures' => [
        "01" => "北海道",
        "02" => "青森県",
        "03" => "岩手県",
        "04" => "宮城県",
        "05" => "秋田県",
        "06" => "山形県",
        "07" => "福島県",
        "08" => "茨城県",
        "09" => "栃木県",
        "10" => "群馬県",
        "11" => "埼玉県",
        "12" => "千葉県",
        "13" => "東京都",
        "14" => "神奈川県",
        "15" => "新潟県",
        "16" => "富山県",
        "17" => "石川県",
        "18" => "福井県",
        "19" => "山梨県",
        "20" => "長野県",
        "21" => "岐阜県",
        "22" => "静岡県",
        "23" => "愛知県",
        "24" => "三重県",
        "25" => "滋賀県",
        "26" => "京都府",
        "27" => "大阪府",
        "28" => "兵庫県",
        "29" => "奈良県",
        "30" => "和歌山県",
        "31" => "鳥取県",
        "32" => "島根県",
        "33" => "岡山県",
        "34" => "広島県",
        "35" => "山口県",
        "36" => "徳島県",
        "37" => "香川県",
        "38" => "愛媛県",
        "39" => "高知県",
        "40" => "福岡県",
        "41" => "佐賀県",
        "42" => "長崎県",
        "43" => "熊本県",
        "44" => "大分県",
        "45" => "宮崎県",
        "46" => "鹿児島県",
        "47" => "沖縄県",
    ],
];
