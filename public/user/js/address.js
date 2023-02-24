$(function () {

    if (window.performance && window.performance.navigation.type == window.performance.navigation.TYPE_BACK_FORWARD) {
        // location.reload();
        $('#accept').prop('checked', false);
    }

    $(".form-normal .checkmark").click(function () {
        $(".regular-checkbox").trigger("click");
    });

    $(".password-input .password-icon").click(function () {
        if ($(this).prev().attr("type") === "password") {
            $(this).prev().attr("type", "text");
            $(this).attr("class", "fas fa-eye-slash password-icon");
        } else {
            $(this).prev().attr("type", "password");
            $(this).attr("class", "fas fa-eye password-icon");
        }
    });

    if ($("#notification").val() !== undefined) {
        $("#modal-notification").modal("show");
    }
    var address_id = null;

    function deleteAddress(data) {
        $("body").addClass("load");
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('input[name="_token"]').attr("value"),
            },
            url: "/address/delete",
            type: "post",
            data: {
                address_id: data,
            },
            success: function (response) {
                $("body").removeClass("load");
                if (response.success) {
                    $("#modal-success .success-title").html(
                        "請求先を削除しました。"
                    );
                    $("#modal-success .success-body").html("");
                    $("#modal-success").modal("show");
                    $("#modal-success").on("hidden.bs.modal", function () {
                        window.location.reload();
                    });
                }
            },
            error: function (e) {
                $("body").removeClass("load");
            },
        });
    }

    $(".remove-address").on("click", function (e) {
        e.preventDefault();
        address_id = $(e.target).attr("data-value");
        let def = $(e.target).attr("data-def");
        if (def && def == 1) {
            $("#notify-modal img").attr("src", "/user/images/info.png");
            $("#notify-modal #notify-title").html("デフォルト請求先です。");
            $("#notify-modal .notify-body").html(
                "月額払いに使用されているデフォルト請\n求先です。デフォルト請求先を変更して\nから削除してください。"
            );
            $("#notify-modal button").html("OK");
            $("#notify-modal").modal("show");
        } else {
            let a = $(e.target).parents().closest(".address-item").find('.addr-body').html();;
            $("#delete-address-modal").modal("show");
            $("#delete-address-modal .notify-body").html(
                '<div class="addr-body">' + a + "</div>"
            );
        }
    });
    $("#delete-address").on("click", function (e) {
        deleteAddress(address_id);
    });
    $(".select-item").on("click", function (e) {
        $("#address_id").val($(e.target).attr("data-value"));
        submit = true;
        $("#form-order").submit();
    });
    $.validator.addMethod(
        "validateTel",
        function (value, element) {
            return (
                this.optional(element) ||
                /^(0([1-9]{1}[1-9]\d{3}|[1-9]{2}\d{3}|[1-9]{2}\d{1}\d{2}|[1-9]{2}\d{2}\d{1})\d{4}|0[789]0\d{4}\d{4}|050\d{4}\d{4})$/.test(
                    value
                )
            );
        },
        "電話番号の形式が間違っています。（ハイフン無し）"
    );
    $.validator.addMethod(
        "isEmail",
        function (value, element) {
            return (
                this.optional(element) ||
                /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(
                    value
                )
            );
        },
        "有効なメールアドレスを入力してください。"
    );
    function sleep(time) {
        return new Promise((resolve) => setTimeout(resolve, time));
    }
    var submit = false;
    $("form").validate({
        rules: {
            type: "required",
            name: {
                required: true,
                minlength: 2,
                maxlength: 150,
            },
            tel: {
                required: true,
                validateTel: true,
            },
            mobile: {
                validateTel: true,
            },
            email: {
                required: true,
                isEmail: true,
                minlength: 7,
                maxlength: 100,
            },
            zipcode: {
                required: true,
                digits: true,
                minlength: 7,
                maxlength: 8,
            },
            address1: "required",
            address2: {
                required: true,
                minlength: 2,
                maxlength: 31,
            },
            address3: {
                required: true,
                minlength: 2,
                maxlength: 35,
            },
            company_name: {
                required: true,
                minlength: 2,
                maxlength: 35,
            },
            department_name: {
                required: true,
                minlength: 2,
                maxlength: 35,
            },
        },
        messages: {
            type: "選択してください。",
            name: {
                required: "入力してください。",
                minlength: "適切な情報を入力してください。",
                maxlength: "適切な情報を入力してください。",
            },
            tel: {
                required: "入力してください。",
            },
            email: {
                required: "入力してください。",
                minlength: "適切な情報を入力してください。",
                maxlength: "適切な情報を入力してください。",
            },
            zipcode: {
                required: "入力してください。",
                digits: "適切な情報を入力してください。",
                minlength: "適切な情報を入力してください。",
                maxlength: "適切な情報を入力してください。",
            },
            address1: "入力してください。",
            address2: {
                required: "入力してください。",
                minlength: "適切な情報を入力してください。",
                maxlength: "適切な情報を入力してください。",
            },
            address3: {
                required: "入力してください。",
                minlength: "適切な情報を入力してください。",
                maxlength: "適切な情報を入力してください。",
            },
            company_name: {
                required: "入力してください。",
                minlength: "適切な情報を入力してください。",
                maxlength: "適切な情報を入力してください。",
            },
            department_name: {
                required: "入力してください。",
                minlength: "適切な情報を入力してください。",
                maxlength: "適切な情報を入力してください。",
            },
        },
        submitHandler: function (form) {
            $("body").addClass("load");
            if (submit) {
                submit = false;
                $("input").prop("disabled", false);
                $("select").prop("disabled", false);
                form.submit();
            }
            sleep(500).then(() => {
                submit = true;
                $(".create").hide();
                $(".confirm").show();
                $('.notify-warning').hide();
                $('.notify-warning-confirm').show();
                $(".location-register").addClass("form-confirm");
                $("input").prop("disabled", true);
                $("input[name=mobile]").attr('placeholder', '');
                $("select").prop("disabled", true);
                $(".sub-title").html("請求先確認");
                window.scrollTo({ top: 0, behavior: 'smooth' });
                $("#check-zip").hide();
                $("body").removeClass("load");
            });
        },
    });
    $(".make-default").on("click", function (e) {
        address_id = $(e.target).attr("data-value");
        $("#confirm_modal img").attr("src", "/user/images/info.png");
        $("#confirm_modal .notification-title").html("デファルト設定確認");
        $("#confirm_modal #text").html("設定");
        $("#confirm_modal .notification-body").html('');
        $("#confirm_modal .notification-body").html(
            "以下の請求先をデファルトに設定します。</br>よろしいでしょうか？"
        );
        let a = $(e.target).parents().closest(".address-item").find('.addr-body').html();
        $("#confirm_modal .notification-body").append(
            '<div class="addr-body text-left" style="color: #000000; width: 80%; margin: 20px auto; background: #F2F2F2; padding: 15px 30px">' + a + "</div>"
        );
        $("#confirm_modal").modal("show");
    });

    $("#action").on("click", function (e) {
        $("body").addClass("load");
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('input[name="_token"]').attr("value"),
            },
            url: "/address/change_default",
            type: "post",
            data: {
                address_id: address_id,
            },
            success: function (response) {
                $("body").removeClass("load");
                if (response.success) {
                    window.location.reload();
                }
            },
            error: function (e) {
                $("body").removeClass("load");
            },
        });
    });

    $(".edit-data").click(function (e) {
        e.preventDefault();
        $("body").addClass("load");
        sleep(500).then(() => {
            submit = false;
            $(".create").show();
            $(".confirm").hide();
            $('.notify-warning').show();
            $('.notify-warning-confirm').hide();
            $("input").prop("disabled", false);
            $("select").prop("disabled", false);
            $(".location-register").removeClass("form-confirm");
            if ($('input[name=is_edit_page]').val() == 1) {
                $(".sub-title").html("請求先修正");
            } else {
                $(".sub-title").html("新しい請求先を追加する");
            }
            $("input[name=mobile]").attr('placeholder', '09012345678');
            $("#check-zip").show();
            $("body").removeClass("load");
        });
    });
    if ($('#type').val() == 1) {
        $('input[name=company_name]').removeAttr('disabled')
        $('input[name=department_name]').removeAttr('disabled')
        $('input[name=company_name]').parent().parent().show()
        $('input[name=department_name]').parent().parent().show()
    } else {
        $('input[name=company_name]').attr('disabled', true)
        $('input[name=department_name]').attr('disabled', true)
        $('input[name=company_name]').parent().parent().hide()
        $('input[name=department_name]').parent().parent().hide()
    }
    $('#type').change(function () {
        if ($(this).val() == 1) {
            $('input[name=company_name]').removeAttr('disabled')
            $('input[name=department_name]').removeAttr('disabled')
            $('input[name=company_name]').parent().parent().show()
            $('input[name=department_name]').parent().parent().show()
        } else {
            $('input[name=company_name]').attr('disabled', true)
            $('input[name=department_name]').attr('disabled', true)
            $('input[name=company_name]').parent().parent().hide()
            $('input[name=department_name]').parent().parent().hide()
        }
    })
});
