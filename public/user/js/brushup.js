$(function() {
    var getDate = function() {
        let init = 3;
        var date = new Date((new Date()).getTime() + 3 * 24 * 60 * 60 * 1000);
        if (date.getDay() == 0) {
            date = new Date((new Date()).getTime() + 4 * 24 * 60 * 60 * 1000);
        } else if (date.getDay() == 6) {
            date = new Date((new Date()).getTime() + 5 * 24 * 60 * 60 * 1000);
        }
        return date;
    }
    $.datepicker.regional['ja'] = {
        closeText: '閉じる',
        prevText: '&#x3c;前',
        nextText: '次&#x3e;',
        currentText: '今日',
        monthNames: ['1月','2月','3月','4月','5月','6月',
            '7月','8月','9月','10月','11月','12月'],
        monthNamesShort: ['1月','2月','3月','4月','5月','6月',
            '7月','8月','9月','10月','11月','12月'],
        dayNames: ['日曜日','月曜日','火曜日','水曜日','木曜日','金曜日','土曜日'],
        dayNamesShort: ['日','月','火','水','木','金','土'],
        dayNamesMin: ['日','月','火','水','木','金','土'],
        weekHeader: '週',
        dateFormat: 'yy/mm/dd',
        firstDay: 0,
        isRTL: false,
        showMonthAfterYear: true,
        yearSuffix: '年'};
    $.datepicker.setDefaults($.datepicker.regional['ja']);
    $('.date').datepicker({
        minDate: 2,
        dateFormat: "yy/mm/dd",
        beforeShowDay: $.datepicker.noWeekends
    }).datepicker('setDate', getDate());
    $('#brushup-request').click(function(e) {
        $('form')[0].submit();
    })
    $("#accept").on("change", function(e) {
        if ($("#accept").is(":checked")) {
            $("#payment").removeAttr("disabled");
        } else {
            $("#payment").prop("disabled", "disabled");
        }
        if ($("#accept").is(":checked")) {
            $("#complete").removeAttr("disabled");
        } else {
            $("#complete").prop("disabled", "disabled");
        }
    });
    $('#payment').click(function() {
        $('#form-order').submit();
    })
    $('#complete').click(function() {
        $("body").removeClass("load");
        $('#form-order').submit();
    })
    $(document).on('click', '.show-notify', function(e) {
        $("#modal-error .notification-body").html(
            "AI文字起こしプランのテキスト化が完了しましたら発注いただけます。"
        );
        $('#modal-error').modal('show');
    })
    $(document).on('click', '.brushup', function(e) {
        let data = {
            audios: audios && audios.length > 0 ? audios.map(e => e.id) : []
        }
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('input[name="_token"]').attr("value"),
            },
            url: "/audio/brushup",
            type: "post",
            data: data,
            success: function(response) {
                $("body").removeClass("load");
                if (response.success) {
                    if (response.order_id) {
                        window.location.replace(
                            "/audio/brushup/" + response.order_id
                        );
                    }
                } else {
                    $("#modal-error .notification-body").html(
                        "ファイルを処理中です。"
                    );
                    $('#modal-error').modal('show');
                }
            },
            error: function(e) {
                $("body").removeClass("load");
                $("#modal-error .notification-body").html(
                    "ファイルを処理中です。"
                );
                $('#modal-error').modal('show');
            },
        });
    })
    if (window.performance && window.performance.navigation.type == window.performance.navigation.TYPE_BACK_FORWARD) {
        location.reload();
    }
    $("#postpaid-accept").on("change", function(e) {
        if ($("#postpaid-accept").is(":checked")) {
            $("#postpaid-confirm").removeAttr("disabled");
        } else {
            $("#postpaid-confirm").prop("disabled", "disabled");
        }
    });
    $('#payment-method').on('change', function(e) {
        if (e.target.value == 2) {
            if (sessionStorage.getItem('#postpaid_privacy') !== 'true') {
                $('#postpaid_privacy').modal('show');
            } else {
                $('#method').val(2);
                $("#postpaid-noty").show()
            }
        } else {
            $('#method').val(1);
            $("#postpaid-noty").hide()
        }
    })
    $("#postpaid-confirm").on("click", function(e) {
        sessionStorage.setItem('#postpaid_privacy', 'true');
        $('#method').val(2);
        $("#postpaid-noty").show()
    });
    $('#postpaid_privacy').on('hidden.bs.modal', function () {
        if (sessionStorage.getItem('#postpaid_privacy') !== 'true') {
            $('#payment-method').val(1);
            $('#method').val(1);
            $("#postpaid-noty").hide()
        }
    });
    $('#coupon_code').keyup(function (){
        const code = $(this).val()
        if (code.trim().length > 0) {
            $('#use_coupon').removeAttr('disabled')
        } else {
            $('#use_coupon').attr('disabled', true)
        }

    })
    const isUseCoupon = $('input[name=is_use_coupon]').val()
    const coupon = $('input[name=coupon]').val()
    if (isUseCoupon == 1){
        if (coupon == 'null') {
            $('#modal-error .notification-body').text('入力したクーポンは利用できません。')
            $('#modal-error .btn-close-modal').hide()
            $('#modal-error .btn-common').removeAttr('data-dismiss')
            $('#modal-error .btn-common').click(function (){
                window.location.href = `/audio/confirm-request/${$('#order-id').val()}`
            })
            $('#modal-error').modal({
                'backdrop' : 'static'
            })
            $('#modal-error').modal('show')
        }
    }
    $('#use_coupon').click(function (){
        const coupon_code = $('#coupon_code').val()
        window.location.href = `/audio/confirm-request/${$('#order-id').val()}?coupon_code=${coupon_code}`
    })
    $('#remove-coupon').click(function (){
        window.location.href = `/audio/confirm-request/${$('#order-id').val()}`
    })
});
