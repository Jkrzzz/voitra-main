<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'User\HomeController@index')->name('index');
Route::get('/login', 'User\AuthController@login')->name('login');
Route::post('/login', 'User\AuthController@loginProcess');
Route::get('/register', 'User\AuthController@register');
Route::get('/test', 'User\HomeController@test');
Route::post('/register-confirm', 'User\AuthController@registerConfirm');
Route::post('/register', 'User\AuthController@registerProcess');
Route::post('/register/resend', 'User\AuthController@resendVerify');
Route::get('/register/verify', 'User\AuthController@registerVerify')->name('register.verify');
// Route::get('/logout', 'User\AuthController@logout');
Route::get('/password/forgot', 'User\AuthController@forgotPassword');
Route::post('/password/forgot', 'User\AuthController@forgotPasswordProcess');
Route::get('/password/reset/{id}/{token}', 'User\AuthController@resetPassword')->name('password.reset');;
Route::post('/password/reset', 'User\AuthController@resetPasswordProcess');
Route::get('/user/information', 'User\HomeController@information');
// Route::get('/upload', 'User\HomeController@uploadAudio');
// Route::post('/upload', 'User\HomeController@uploadAudioProcess');
// Route::get('/upload/operations/{name}', 'User\HomeController@uploadAudioOperations');

Route::post('/api/webhook/{orderId}/{audioId}/{token}', 'User\AudioController@textResponse')->name('api.webhook');


Route::prefix('/admin')->group(function () {
    Route::middleware(['auth.admin'])->group(function () {
        Route::get('/orders', 'Admin\OrderController@index');
        Route::get('/orders/download', 'Admin\OrderController@download');
        Route::get('/orders/{id}', 'Admin\OrderController@detail');
        Route::get('/orders/{id}/edit', 'Admin\OrderController@edit');
        // Route::put('/orders/{id}', 'Admin\OrderController@update');
        Route::get('/orders/{id}/audio/{audioId}', 'Admin\OrderController@audioResult');
        Route::get('/orders/{id}/audio/{audioId}/edit', 'Admin\OrderController@editAudioResult');
        Route::post('/orders/audio', 'Admin\OrderController@updateAudio');
        Route::put('/orders/{id}/memo', 'Admin\OrderController@saveMemo');
        Route::put('/orders/{id}/assign/estimate', 'Admin\OrderController@assignEstimate');
        Route::put('/orders/{id}/assign/edit', 'Admin\OrderController@assignEdit');
        Route::put('/orders/{id}/payment/edit', 'Admin\OrderController@paymentEdit');
        Route::put('/orders/{id}/send/estimate', 'Admin\OrderController@sendEstimate');
        Route::put('/orders/{id}/send/edit', 'Admin\OrderController@sendEdit');
        Route::put('/orders/{id}/send-admin/estimate', 'Admin\OrderController@sendAdminEstimate');
        Route::put('/orders/{id}/send-admin/edit', 'Admin\OrderController@sendAdminEdit');
        Route::get('/audio/export/{orderId}/{audioId}', 'Admin\OrderController@exportCsv')->name('audio.export');
        Route::post('/audio/upload_csv', 'Admin\OrderController@updateByCsv')->name('audio.upload_csv');
        Route::get('/information', 'Admin\StaffController@information');
        Route::put('/information', 'Admin\StaffController@changeInformation');
        Route::get('/information/change-password', 'Admin\StaffController@changeInformationPassword');
        Route::post('/information/change-password', 'Admin\StaffController@changeInformationPasswordProcess');
        Route::get('/users/{id}', 'Admin\UserController@detail');

        Route::get('/notifications', 'Admin\NotifyController@index');
        Route::get('/export/notifications', 'Admin\NotifyController@exportNotify');
        Route::get('/notifications/contact', 'Admin\NotifyController@contact');
        Route::post('/notifications/mark-all-as-read', 'Admin\NotifyController@markAllAsRead');
        Route::post('/notifications/mark-as-read', 'Admin\NotifyController@markAsRead');
        Route::post('/notifications/ajax-mark-as-read', 'Admin\NotifyController@ajaxMarkAsRead');
        Route::post('/notifications/ajax-mark-contact-as-read', 'Admin\NotifyController@ajaxMarkContactAsRead');
        Route::post('/messages/send', 'Admin\MessageController@store');
        Route::post('/messages/ajax-mark-as-read', 'Admin\MessageController@ajaxMarkAsRead');
        Route::post('/messages/ajax-mark-all-as-read', 'Admin\MessageController@ajaxMarkAllAsRead');
        Route::put('/users/{id}/memo', 'Admin\UserController@updateMemo');

        Route::middleware(['auth.role.admin'])->group(function () {
            Route::get('/dashboard', 'Admin\HomeController@dashboard')->name('admin.dashboard');
            Route::get('/users', 'Admin\UserController@index');
            Route::get('/export/users', 'Admin\UserController@download')->name('admin.exportUser');
            Route::put('/users/{id}', 'Admin\UserController@update');
            Route::delete('/users/{id}', 'Admin\UserController@delete');
            Route::get('/staffs', 'Admin\StaffController@index');
            Route::get('/staffs/create', 'Admin\StaffController@create');
            Route::post('/staffs', 'Admin\StaffController@store');
            Route::put('/staffs/{id}', 'Admin\StaffController@update');
            Route::get('/staffs/{id}/edit', 'Admin\StaffController@edit');
            // Route::delete('/staffs/{id}', 'Admin\StaffController@delete');
            Route::get('/staffs/{id}', 'Admin\StaffController@detail');
            Route::get('/staffs/{id}/change-password', 'Admin\StaffController@changePassword');
            Route::post('/staffs/{id}/change-password', 'Admin\StaffController@changePasswordProcess');
            Route::get('/settings', 'Admin\SettingController@index');
            Route::put('/settings/{id}', 'Admin\SettingController@setting');
            Route::get('/payments', 'Admin\PaymentController@index');
            Route::get('/payments/download', 'Admin\PaymentController@download');
            Route::put('/change-setting', 'Admin\SettingController@changeSetting');
            Route::get('/coupons', 'Admin\CouponController@index');
            Route::get('/coupons/create', 'Admin\CouponController@create');
            Route::post('/coupons/confirm', 'Admin\CouponController@confirm');
            Route::post('/coupons', 'Admin\CouponController@store');
            Route::get('/coupons/{id}', 'Admin\CouponController@detail');
            Route::get('/coupons/{id}/edit', 'Admin\CouponController@edit');
            Route::put('/coupons/{id}', 'Admin\CouponController@update');

            Route::get('/cancel/{id}', 'Admin\PaymentController@cancelOrder');

        });
    });
    Route::get('/login', 'Admin\AuthController@login');
    Route::post('/login', 'Admin\AuthController@loginProcess');
    Route::get('/logout', 'Admin\AuthController@logout');
});

Route::middleware(['auth.user'])->group(function () {
    Route::get('/upload', 'User\UserController@upload');
    Route::post('/upload', 'User\UserController@uploadAudioProcess');
    Route::get('/upload/detail', 'User\UserController@uploadDetail')->name('upload.detail');
    Route::post('/upload/detail', 'User\UserController@uploadWithService');
    Route::post('/upload/add', 'User\UserController@addAudio');
    Route::post('/upload/remove', 'User\UserController@removeAudio');
    Route::get('/upload/order', 'User\UserController@order')->name('user.order');
    Route::post('/upload/confirm', 'User\UserController@confirm');
    Route::get('/upload/loading', 'User\UserController@loading');
    Route::post('/upload/complete', 'User\UserController@complete');
    Route::get('/upload/operations/{name}', 'User\UserController@uploadAudioOperations');
    Route::get('/audio', 'User\UserController@audioManager')->name('audioManager');
    Route::get('/dashboard', 'User\UserController@uploadAudio');
    Route::get('/audio/edit/{id}', 'User\AudioController@audioEdit')->name('audio.edit');
    Route::get('/audio/view/{id}', 'User\AudioController@audioView')->name('audio.view');
    Route::put('/audio/feedback/{id}', 'User\AudioController@audioFeedback')->name('audio.feedback');

    Route::post('/audio/create', 'User\AudioController@uploadAudioProcess');
    Route::get('/audio/brushup/{id}', 'User\AudioController@brushupOrder')->name('user.brushuporder');
    Route::post('/audio/brushup', 'User\AudioController@brushup')->name('audio.brushup');
    Route::delete('/audio/delete', 'User\AudioController@deleteAudio')->name('audio.delete');
    Route::post('/audio/download', 'User\AudioController@download')->name('audio.download');
    Route::post('/audio/save', 'User\AudioController@save')->name('audio.save');
    Route::post('/audio/brushup-request', 'User\AudioController@requestBrushup')->name('audio.brushupRequest');
    Route::get('/audio/confirm-request/{id}', 'User\AudioController@confirmRequest')->name('audio.confirmRequest');
    Route::post('/audio/brushup-payment', 'User\AudioController@brushupPayment');
    Route::post('/brushup/complete', 'User\PaymentController@brushupComplete');
    Route::post('/audio/editname', 'User\AudioController@editFilename');
    Route::post('/audio/cancel-brushup', 'User\AudioController@cancelBrushup');
    Route::get('/audio/new-brushup/{id}', 'User\AudioController@newBrushup');


    Route::post('/audio/brushup-confirm', 'User\PaymentController@brushupConfirm');
    Route::post('/brushup/confirm', 'User\AudioController@brushupConfirm');

    Route::post('/service/trail', 'User\ServiceController@registerFree');
    Route::get('/service/register', 'User\ServiceController@index');
    Route::get('/service/register/{id}', 'User\ServiceController@registerWithOrder');
    Route::get('/service/payment', 'User\PaymentController@servicePayment');
    Route::post('/service/payment', 'User\PaymentController@servicePayment');
    Route::post('/service/payment/{id}', 'User\PaymentController@servicePayment');
    Route::post('/service/register', 'User\ServiceController@registerService');


    Route::get('/info', 'User\UserController@information');
    Route::get('/info/edit', 'User\UserController@editInformation');
    Route::post('/info/edit', 'User\UserController@editInformationProcess');
    Route::get('/info/change-password', 'User\UserController@changePassword');
    Route::post('/info/change-password', 'User\UserController@changePasswordProcess');
    Route::get('/logout', 'User\AuthController@logout');

    Route::get('/card-management', 'User\PaymentController@cardManagement');
    Route::get('/card-management/new', 'User\PaymentController@formNewCard');
    Route::get('/card-management/add', 'User\PaymentController@formAddCard');
    Route::post('/card-management/add', 'User\PaymentController@addCard');
    Route::post('/card-management/delete', 'User\PaymentController@deleteCard');
    Route::post('/card-management/default', 'User\PaymentController@updateDefault');

    Route::get('/remove-member', 'User\UserController@removeMember');
    Route::get('/remove-member/survey', 'User\UserController@removeMemberSurvey');
    Route::post('/remove-member/survey', 'User\UserController@removeMemberProcess');

    Route::get('/remove-service', 'User\UserController@removeService');
    Route::post('/remove-service', 'User\UserController@removeServiceProcess');

    Route::get('/payment-history', 'User\PaymentController@paymentHistory');
    Route::get('/payment-history/{id}', 'User\PaymentController@paymentHistoryDetail');
    Route::get('/payment-history/{id}/invoice', 'User\PaymentController@invoice');

    Route::post('/upload/payment', 'User\PaymentController@payment');
    Route::post('/upload/payment_service', 'User\PaymentController@paymentWithService');
    Route::get('/upload/payment_service', 'User\PaymentController@paymentWithService');
    Route::post('/upload/pay', 'User\PaymentController@pay');
    Route::post('/upload/paywith_service', 'User\PaymentController@payWithService');

    Route::post('/brushup/pay', 'User\PaymentController@brushupPay');

    Route::get('/address/success', 'User\AddressController@success')->name('addressConfirm');

    Route::get('/service/test/{user_id}', 'User\ServiceController@serviceTest');

    Route::get('/upload/change_card/{order_id}', 'User\PaymentController@changePayCard')->name('changePayCard');
    Route::get('/brushup/change_card/{order_id}', 'User\PaymentController@changeBrushupPayCard')->name('changeBrushupPayCard');
    Route::get('/service/change_card/{order_id}', 'User\PaymentController@changeServicePayCard');
    Route::get('/service/change_card/', 'User\PaymentController@changeServicePayCard')->name('changeServicePayCard');

    Route::get('/address/management', 'User\AddressController@index');
    Route::get('/address/edit/{address_id}', 'User\AddressController@editAddress')->name('editAddress');
    Route::post('/address/edit/{address_id}', 'User\AddressController@updateAddress')->name('updateAddress');
    Route::post('/request/cancel', 'User\PaymentController@cancelRequest');


    Route::get('/address/register', 'User\AddressController@register');
    Route::post('/address/register', 'User\AddressController@addAddress');
    Route::post('/address/delete', 'User\AddressController@delete');
    Route::get('/address/register/payment/{type}/{order_id?}', 'User\AddressController@registerPayment')->name('registerAddressPayment');
    Route::post('/address/register/payment', 'User\AddressController@registerPayment');
    Route::post('/address/register/pay', 'User\AddressController@registerPay');

    Route::post('/address/register/fix', 'User\AddressController@fixAndPay');

    Route::post('/address/change_default', 'User\AddressController@changeDefault');

    Route::get('/upload/change_address/{type}/{order_id?}', 'User\AddressController@changeAddress')->name('changeAddress');
    Route::get('/address/fix/{type}/{order_id?}', 'User\AddressController@fixAddress')->name('fixAddress');

    Route::get('/brushup/change_address/{order_id}', 'User\AddressController@changeBrushupPayCard');
    // Route::get('/service/change_address/{order_id}', 'User\AddressController@changeServicePayCard');
    // Route::get('/service/change_address/', 'User\AddressController@changeServicePayCard');

    Route::get('/payment/{type}/{order_id?}', 'User\PaymentController@repay')->name('repay');
    //coupon
    Route::get('/coupons', 'User\CouponController@list');
    //

});

Route::get('/textmining','User\MailController@planSanMail')->name('textmining');
Route::get('/textmining-complete', 'User\MailController@sendGetMail');
Route::post('/textmining-complete', 'User\MailController@sendMail');

Route::get('/terms-of-using', 'User\HomeController@termsOfUse');
Route::get('/privacy-policy', 'User\HomeController@privacyPolicy');
Route::get('/contact', 'User\HomeController@contact');
Route::post('/contact', 'User\HomeController@confirmContact');
Route::post('/contact/send', 'User\HomeController@sendContact');

// Route::get('/audios', function () {
//     return view('admin.layouts.layout');
// });
