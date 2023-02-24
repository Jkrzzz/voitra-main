<?php

return [
    'label' => [
        'service_canceled' => 1,
        'membership_canceled' => 2,
        'contact' => 3,
        'brush_up_plan' => 4,
        'postpaid' => 5,
        'message' => 6,
    ],
    'label_title' => [
        1 => 'オプション解約',
        2 => '退会', // ok
        3 => '問い合わせ', // ok
        4 => 'プラン２', // ok
        5 => '後払い', // ok
        6 => 'メッセージ', // ok
    ],
    'type' => [
        'service_canceled' => [
            'id'          => 1,
            'label'       => 1, // service_canceled
            'content_tpl' => '%refname%さんが話者分離オプションを解約しました。',
        ],
        'membership_canceled' => [
            'id'          => 2,
            'label'       => 2, // membership_canceled
            'content_tpl' => '%refname%さんが退会しました。',
        ],
        'contact' => [
            'id'          => 3,
            'label'       => 3, // contact
            'content_tpl' => '%refname%さんから問い合わせが来ました。',
        ],
        'user_est_requested' => [
            'id'          => 4,
            'label'       => 4, // brush_up_plan
            'content_tpl' => '%refname%さんからブラッシュアッププラン 納品予定日確認予約が入りました。',
        ],
        'staff_estimated' => [
            'id'          => 5,
            'label'       => 4, // brush_up_plan
            'content_tpl' => '%refname%さんから納品予定日確認タスクが入りました。',
        ],
        'user_edit_requested' => [
            'id'          => 6,
            'label'       => 4, // brush_up_plan
            'content_tpl' => '%refname%さんからブラッシュアッププラン お申し込みが入りました。',
        ],
        'staff_edited' => [
            'id'          => 7,
            'label'       => 4, // brush_up_plan
            'content_tpl' => '%refname%さんから編集結果確認タスクが入りました。',
        ],
        'postpaid_plan_1_ok' => [
            'id'          => 8,
            'label'       => 5, // postpaid
            'content_tpl' => '%refname%さんの後払いが確定しました。',
        ],
        'postpaid_plan_2_ok' => [
            'id'          => 9,
            'label'       => 5, // postpaid
            'content_tpl' => '%refname%さんの後払いが確定しました。',
        ],
        'postpaid_service_1_ok' => [
            'id'          => 10,
            'label'       => 5, // postpaid
            'content_tpl' => '%refname%さんの後払いが確定しました。',
        ],
        'postpaid_plan_1_plus_ok' => [ // `plan 1+` is `plan 1 + speaker separation option (service 1)`
            'id'          => 11,
            'label'       => 5, // postpaid
            'content_tpl' => '%refname%さんの後払いが確定しました。',
        ],
        'postpaid_plan_1_ng' => [
            'id'          => 12,
            'label'       => 5, // postpaid
            'content_tpl' => '%refname%さんの後払いが失敗しました。',
        ],
        'postpaid_plan_2_ng' => [
            'id'          => 13,
            'label'       => 5, // postpaid
            'content_tpl' => '%refname%さんの後払いが失敗しました。',
        ],
        'postpaid_service_1_ng' => [
            'id'          => 14,
            'label'       => 5, // postpaid
            'content_tpl' => '%refname%さんの後払いが失敗しました。',
        ],
        'postpaid_plan_1_plus_ng' => [ // `plan 1+` is `plan 1 + speaker separation option (service 1)`
            'id'          => 15,
            'label'       => 5, // postpaid
            'content_tpl' => '%refname%さんの後払いが失敗しました。',
        ],
        'postpaid_plan_1_hr' => [
            'id'          => 16,
            'label'       => 5, // postpaid
            'content_tpl' => '%refname%さんの後払いが保留になりました。',
        ],
        'postpaid_plan_2_hr' => [
            'id'          => 17,
            'label'       => 5, // postpaid
            'content_tpl' => '%refname%さんの後払いが保留になりました。',
        ],
        'postpaid_service_1_hr' => [
            'id'          => 18,
            'label'       => 5, // postpaid
            'content_tpl' => '%refname%さんの後払いが保留になりました。',
        ],
        'postpaid_plan_1_plus_hr' => [ // `plan 1+` is `plan 1 + speaker separation option (service 1)`
            'id'          => 19,
            'label'       => 5, // postpaid
            'content_tpl' => '%refname%さんの後払いが保留になりました。',
        ],
        'admin_est_requested' => [
            'id'          => 20,
            'label'       => 4, // brush_up_plan
            'content_tpl' => '管理者から%refname%さんに納品予定日見積りタスクが入りました。',
        ],
        'admin_edit_requested' => [
            'id'          => 21,
            'label'       => 4, // brush_up_plan
            'content_tpl' => '管理者から%refname%さんに編集タスクが入りました。',
        ],
        'admin_message_created' => [
            'id'          => 22,
            'label'       => 6, // message
            'content_tpl' => '管理者からメッセージが来ました。',
        ],
        'staff_message_created' => [
            'id'          => 23,
            'label'       => 6, // message
            'content_tpl' => '%refname%さんからメッセージが来ました。',
        ],
    ],
];
