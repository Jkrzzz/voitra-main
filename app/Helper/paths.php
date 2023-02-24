<?php

define('TXN_FAILURE_CODE', 'failure');
define('TXN_PENDING_CODE', 'pending');
define('TXN_SUCCESS_CODE', 'success');
define('PAY_NOW_ID_FAILURE_CODE', 'failure');
define('PAY_NOW_ID_PENDING_CODE', 'pending');
define('PAY_NOW_ID_SUCCESS_CODE', 'success');

define('AUTH_CODE_OK', 'OK');
define('AUTH_CODE_NG', 'NG');
define('AUTH_CODE_HOLD', 'HD');

define('TARGET_GROUP_ID', 'VOITRA');
define('MEMBER_GROUP_ID', 'VOITRA_MEMBER_PRD_');
define('DELIVERY_ID', 'VOITRADEID');
define('ORDER_TYPE', 1);
define('BRUSHUP_TYPE', 2);
define('SERVICE_TYPE', 3);
define('ORDER_SERVICE_TYPE', 4);

define('VOITRA_POSTPAID_FEE', 350);
#PAYMENT METHOD
define('PAYMENT_CREDIT', 1);
define('PAYMENT_POSTPAID', 2);

#PAYMENT STATUS
define('PAYMENT_CANCEL', 0);
define('PAYMENT_NG', 1);
define('PAYMENT_HOLD', 2);
define('PAYMENT_DONE', 3);
define('PAYMENT_VERIFIED', 4);
define('PAYMENT_RESERVE', 5);
define('PAYMENT_REFUND', 6);

#ORDER STATUS
define('ORDER_DISABLE', 0);
define('ORDER_PROCESSING', 1);
define('ORDER_DONE', 2);
define('ORDER_ERROR', 3);
define('ORDER_DELETED', 4);
define('ORDER_CANCEL', 7);
define('ORDER_HOLD', 8);
define('ORDER_RESERVE', 9);

#BRUSHUP STATUS
define('BRUSHUP_CANCEL', 0);
define('BRUSHUP_REQUESTED', 1);
define('BRUSHUP_ASSIGNED', 4);
define('BRUSHUP_CONFIRM', 5);
define('BRUSHUP_ESTIMATED', 2);
define('BRUSHUP_PAID', 3);
define('BRUSHUP_DONE', 6);
define('BRUSHUP_EXPIRED', 7);
define('BRUSHUP_ERROR', 8);

#servicePaymentStatus
define('SERVICE_DISABLE', 0);
define('SERVICE_PROCESSING', 1);
define('SERVICE_CANCEL', 7);
define('SERVICE_HOLD', 8);
define('SERVICE_RESERVE', 9);

define('NORMAL_PAGE_TITLE', 'VeriTrans 4G - 会員カード管理サンプル画面');

define('ERROR_PAGE_TITLE', 'System Error');
