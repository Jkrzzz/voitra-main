(function() {
    function Init() {
        var fileSelect = document.getElementById("file-upload"),
            fileDrag = document.getElementById("file-drag");
        if (fileDrag) {
            $("#file-upload-btn").on("click", function(e) {
                e.preventDefault();
                $("#file-upload").click();
            });
            fileSelect.addEventListener("change", fileSelectHandler, false);

            // Is XHR2 available?
            var xhr = new XMLHttpRequest();
            if (xhr.upload) {
                // File Drop
                fileDrag.addEventListener("dragover", fileDragHover, false);
                fileDrag.addEventListener("dragleave", fileDragHover, false);
                fileDrag.addEventListener("drop", fileSelectHandler, false);
            }
        }
    }

    function fileDragHover(e) {
        var fileDrag = document.getElementById("file-drag");

        e.stopPropagation();
        e.preventDefault();

        fileDrag.className =
            e.type === "dragover" ? "hover" : "modal-body file-upload";
    }

    function fileSelectHandler(e) {
        var files = e.target.files || e.dataTransfer.files;
        let filesize = parseInt(sessionStorage.getItem('filesize'));
        var totalFileSize = filesize;
        var fileSizeLimit = 256 * 1024 * 1024;
        fileDragHover(e);
        var list = $(".audio-detail").length;
        var allow_extensions = ['mp4', 'avi', 'mpeg', 'wmv', 'm4a', 'aac', 'wav', 'mp3', 'wma'];
        for (var i = 0, f;
            (f = files[i]); i++) {
            if (!allow_extensions.includes(f.name.split('.').pop().toLowerCase())) {
                $("#modal-error .notification-body").html(
                    "このファイル形式には対応しておりません。"
                );
                $('#modal-error').modal("show");
                return;
            }
            totalFileSize += f.size;
        }
        if (files.length + list > 5 || files.length + list <= 0) {
            $("#notify-modal #notify-title").html(
                "ファイル個数は５個超えている"
            );
            $("#notify-modal #notify-body").html(
                "アップロードファイル数は５ファイルを超えています。"
            );
            $("#notify-modal").modal("show");
        } else if (totalFileSize > fileSizeLimit) {
            $("#notify-modal #notify-title").html(
                "ファイルのサイズは256Mb超えている"
            );
            $("#notify-modal #notify-body").html(
                "ファイルのサイズは256Mb超えています。"
            );
            $("#notify-modal").modal("show");
        } else {
            sessionStorage.setItem('filesize', totalFileSize);
            upload(files);
        }
    }

    function upload(files) {
        $("body").addClass("load");
        var form_data = new FormData();
        for (file of files) {
            form_data.append("files[]", file);
        }
        form_data.append("language", $("#language").val());
        form_data.append("order_id", $("#order-id").val());
        $("#file-upload").val('');
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('input[name="_token"]').attr("value"),
            },
        });
        $.ajax({
            url: "/upload/add",
            type: "post",
            data: form_data,
            contentType: false,
            processData: false,
            success: function(response) {
                $("body").removeClass("load");
                if (!response.error) {
                    let option = '';
                    for (let i = 1; i < 16; i++) {
                        option += `<option value="${ i }">${ i }</option>`
                    }
                    let register = '';
                    if (!response.isRegisterOption) {
                        register = '<i class="fas fa-question-circle" data-toggle="tooltip" data-placement="top" data-html="true" title="話者分離オプションのご利用にはお申し込みが必要です。"></i>'
                    }

                    for (let index in response.data) {
                        let html =
                            '<div class="audio-detail row" data-value="' + response.data[index].id + '">' +
                            '                        <div class="col-1 col-md-1">' +
                            '                            <svg class="detail-icon" width="15" height="26" viewBox="0 0 15 26" fill="none" xmlns="http://www.w3.org/2000/svg">' +
                            '                                <path d="M13.2905 10V12.5484C13.2905 14.3071 12.6425 15.8935 11.5928 17.0511C10.5404 18.2057 9.09825 18.9185 7.50066 18.9185C5.90306 18.9185 4.45957 18.2072 3.40724 17.0511C2.35754 15.8921 1.70954 14.3057 1.70954 12.5484V10H0V12.5484C0.00131706 16.783 2.90939 20.2716 6.64589 20.741V24.3281H4.4622V26H10.5378V24.3281H8.35411V20.741C12.0906 20.2716 14.9987 16.783 15 12.5484V10H13.2905Z" fill="black" />' +
                            '                                <path d="M10.3727 9.65741C10.2121 9.65741 10.0682 9.55401 10.0152 9.40278L9.73485 8.58179L9.03333 11.0463C8.98636 11.213 8.83333 11.3241 8.66212 11.321C8.49091 11.3164 8.34242 11.1975 8.30303 11.0309L7.58636 8L6.52424 12.25C6.48182 12.4182 6.33182 12.5355 6.15758 12.5355C6.15606 12.5355 6.15455 12.5355 6.15303 12.5355C5.97879 12.5324 5.82727 12.412 5.78939 12.2423L4.93182 8.43056L4.54545 9.45679C4.49091 9.60494 4.35 9.70216 4.19242 9.70216H3V12.4167C3 14.9444 5.0197 17 7.5 17C9.98182 17 12 14.9444 12 12.4167V9.65123C11.9818 9.65432 11.9652 9.65741 11.947 9.65741H10.3727Z" fill="black" />' +
                            '                                <path d="M4.66874 7.70345C4.72785 7.55693 4.88094 7.46644 5.04766 7.4765C5.21438 7.48655 5.35231 7.59715 5.38868 7.74941L6.17834 11L7.23173 7.07574C7.27416 6.91917 7.42422 6.80857 7.59852 6.80857C7.60003 6.80857 7.60003 6.80857 7.60155 6.80857C7.77433 6.81 7.9259 6.92204 7.96531 7.08005L8.70495 9.99308L9.3385 7.91891C9.38397 7.7724 9.52644 7.66897 9.69165 7.66466C9.85685 7.66036 10.0054 7.75659 10.0584 7.90167L10.642 9.48746H11.9469C11.9651 9.48746 11.9833 9.49034 12 9.49177V4.26613C12.003 1.91329 9.98265 0 7.50151 0C5.02038 0 3 1.91329 3 4.26613V9.52768H3.93213L4.66874 7.70345Z" fill="black" />' +
                            '                            </svg>' +
                            '                        </div>' +
                            '                        <div class="col-12 col-md-2 title-res">アップロードファイル</div>' +
                            '                        <div class="col-12 col-md-3">' +
                            '                            <p class="audio-name">' + response.data[index].name + '</p>' +
                            '                        </div>' +
                            '                        <div class="col-6 col-md-2 title-res">言語</div>' +
                            '                        <div class="col-6 col-md-2" data-lang="' + languages[response.data[index].language] + '">' + languages[response.data[index].language] + '</div>' +
                            '                        <div class="col-6 col-md-2 title-res option">話者分離' + register + '</div>' +
                            '                        <div class="col-6 col-md-2"><input type="checkbox" class="diarization"></div>' +
                            '                        <div class="col-6 col-md-2 title-res option">' +
                            '                            話者数' +
                            '<i class="fas fa-question-circle" data-toggle="tooltip" data-placement="top" title="会話の人数を選択して下さい。選択いただいた人数よりも実際の人数が多い場合は、正確に分離されない可能性がございます。"></i>' +
                            '                        </div>' +
                            '                        <div class="col-6 col-md-3">' +
                            '                       <select class="form-control form-control-normal num-spks" disabled>' +
                            '                            <option value="">指定なし</option>' +
                            option +
                            '                        </select>' +
                            '                        </div>' +
                            '                        <div class="col-12 col-md-1 custom-icon">' +
                            '                            <span class="icon-btn remove-audio" data-value="' + response.data[index].id + '"><i class="fas fa-times"></i></span>' +
                            '                        </div>' +
                            '                    </div>'
                        $("#list-audio").append(html);
                    }
                } else {
                    $('#modal-error').modal("show");
                }
            },
            error: function(e) {
                if (e.status == 419) {
                    window.location.replace('/login');
                }
                $("body").removeClass("load");
                $('#modal-error').modal("show");
            },
        });
    }
    if (window.File && window.FileList && window.FileReader) {
        Init();
    } else {
        document.getElementById("file-drag").style.display = "none";
    }
    $(document).on("click", ".remove-audio", function(e) {
        removeAudio(e);
    });
    $("#payment").on("click", function(e) {
        $("#form-order").submit();

    });
    $("#upload-audio").on("click", function(e) {
        let items = $('.audio-detail');
        let data = [];
        let order_id = $('#order_id').val();
        let paynow_option = $('#paynow_option').val();

        for (let item of items) {
            let id = $(item).attr('data-value');
            let lang = $(item).find('.lang-res').first().attr('data-lang');
            let diz = $(item).find('.diarization').first().is(":checked");
            let num = $(item).find('.num-spks').first().val();
            if (parseInt(num) > 30) {
                $("#modal-error .notification-title").html(
                    '30人を超えています。'
                );
                $("#modal-error .notification-body").html(
                    'もう一度入力してください。'
                );
                $('#modal-error').modal("show");
                return
            }
            data.push({
                id: id,
                lang: lang,
                diz: diz,
                num: num,
            })
        }
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('input[name="_token"]').attr("value"),
            },
        });
        $.ajax({
            url: "/audio/create",
            type: "post",
            data: { data: data, order: order_id, paynow_option: paynow_option},
            dataType: "json",
            success: function(response) {
                if (response['success']) {
                    window.location.replace('/upload/order?order_id=' + response['order_id'] + '&paynow_option=' + (paynow_option ? paynow_option : 0));
                }
            },
            error: function(e) {
                $("body").removeClass("load");
                $('#modal-error').modal("show");
            },
        });
    })
    $("#complete").on("click", function(e) {
        $("#form-order").submit();
        $('.upload-container').empty();
        $('.upload-container').html('<div class="upload-container">' +
            '    <div class="block loading">' +
            '        <div class="block-content">' +
            '            <svg width="150" height="100" viewBox="0 0 140 92" fill="none" xmlns="http://www.w3.org/2000/svg">' +
            '                <rect x="120" y="23" width="16" height="45" rx="8" fill="#F7931E">' +
            '                    <animate attributeName="height" attributeType="XML" values="30;90;30" begin="0.3s" dur="0.6s" repeatCount="indefinite"></animate>' +
            '                    <animate attributeName="y" attributeType="XML" values="23; 0; 23" begin="0.3s" dur="0.6s" repeatCount="indefinite"></animate>' +
            '                </rect>' +
            '                <rect x="90" y="23" width="16" height="45" rx="8" fill="#FAAA20">' +
            '                    <animate attributeName="height" attributeType="XML" values="30;90;30" begin="-0.15s" dur="0.6s" repeatCount="indefinite"></animate>' +
            '                    <animate attributeName="y" attributeType="XML" values="23; 0; 23" begin="-0.15s" dur="0.6s" repeatCount="indefinite"></animate>' +
            '                </rect>' +
            '                <rect x="60" y="23" width="15" height="45" rx="7.5" fill="#FFC924">' +
            '                    <animate attributeName="height" attributeType="XML" values="30;90;30" begin="0.3s" dur="0.6s" repeatCount="indefinite"></animate>' +
            '                    <animate attributeName="y" attributeType="XML" values="23; 0; 23" begin="0.3s" dur="0.6s" repeatCount="indefinite"></animate>' +
            '                </rect>' +
            '                <rect x="30" y="23" width="16" height="45" rx="8" fill="#FFD34C">' +
            '                    <animate attributeName="height" attributeType="XML" values="30;90;30" begin="-0.15s" dur="0.6s" repeatCount="indefinite"></animate>' +
            '                    <animate attributeName="y" attributeType="XML" values="23; 0; 23" begin="-0.15s" dur="0.6s" repeatCount="indefinite"></animate>' +
            '                </rect>' +
            '                <rect x="0" y="23" width="16" height="45" rx="8" fill="#FFDD76">' +
            '                    <animate attributeName="height" attributeType="XML" values="30;90;30" begin="0s" dur="0.6s" repeatCount="indefinite"></animate>' +
            '                    <animate attributeName="y" attributeType="XML" values="23; 0; 23" begin="0s" dur="0.6s" repeatCount="indefinite"></animate>' +
            '                </rect>' +
            '            </svg>' +
            '        </div>' +
            '        <div class="block-content">' +
            '            <span class="title">少しお待ちください...</span>' +
            '        </div>' +
            '    </div>' +
            '</div>');
    });

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

    var removeAudio = function(e) {
        var audio_id = $(e.currentTarget).attr("data-value");
        var order_id = $("#order-id").val();
        var form_data = new FormData();
        form_data.append("audio_id", audio_id);
        form_data.append("order_id", order_id);
        $("body").addClass("load");
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('input[name="_token"]').attr("value"),
            },
        });
        $.ajax({
            url: "/upload/remove",
            type: "post",
            data: form_data,
            contentType: false,
            processData: false,
            success: function(response) {
                if (!response.error) {
                    $("div[data-value='" + audio_id + "']").remove();
                    let filesize = parseInt(sessionStorage.getItem('filesize'));
                    sessionStorage.setItem('filesize', filesize - parseInt(response.filesize));
                }
                $("body").removeClass("load");
            },
            error: function(e) {
                console.log(e);
                $("body").removeClass("load");
            },
        });
    };
    $(document).on("change", ".diarization", function(e) {
        if (e.target.checked) {
            $(this).parents('.audio-detail').find('.num-spks').prop('disabled', false);
        } else {
            $(this).parents('.audio-detail').find('.num-spks').prop('disabled', true);
        }
    })

    $('.checkmark').click(function() {
        $('.regular-checkbox').trigger('click')
    })
    // if (window.performance && window.performance.navigation.type == window.performance.navigation.TYPE_BACK_FORWARD) {
    //     location.reload();
    // }

    function register() {
        $("body").addClass("load");
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('input[name="_token"]').attr("value"),
            },
        });
        $.ajax({
            url: "/service/trail",
            type: "post",
            contentType: false,
            processData: false,
            success: function(response) {
                $("body").removeClass("load");
                $("#notify-modal img").attr('src', '/user/images/icon-success.png');
                $("#notify-modal .notify-title").html(
                    '話者分離オプション申し込み完了'
                );
                $("#notify-modal .notify-body").html(
                    '話者分離オプション申し込みが完了しました。 </br>ありがとうございます。'
                );
                $("#notify-modal").modal("show");
                $("#notify-modal button").addClass("reload");
                $('#notify-modal').on('hidden.bs.modal', function() {
                    location.reload();
                })
            },
            error: function(e) {
                $("body").removeClass("load");
                $('#modal-error').modal("show");
            },
        });
    }

    $(document).on('click', '#register-service', function(e) {
        register()
    })

    $(document).on("click", ".register-tt", function(e) {
        $('#modal_register_trail').modal('show');
    })
    $('.back').on('click', function(e) {
        e.preventDefault();
        window.history.back()
    })
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
    $('#coupon_code').on('keyup contextmenu input', function() {
        const code = $(this).val()
        if (code.trim().length > 0) {
            $('#use_coupon').removeAttr('disabled')
        } else {
            $('#use_coupon').attr('disabled', true)
        }
    });
    $('#coupon_code').keyup(function (){
        const code = $(this).val()
        if (code.trim().length > 0) {
            $('#use_coupon').removeAttr('disabled')
        } else {
            $('#use_coupon').attr('disabled', true)
        }
    });
    const isUseCoupon = $('input[name=is_use_coupon]').val()
    const coupon = $('input[name=coupon]').val()
    if (isUseCoupon == 1){
        if (coupon == 'null') {
            $('#modal-error .notification-body').text('入力したクーポンは利用できません。')
            $('#modal-error .btn-close-modal').hide()
            $('#modal-error .btn-common').removeAttr('data-dismiss')
            $('#modal-error .btn-common').click(function (){
                window.location.href = `/upload/order?order_id=${$('#order-id').val()}&paynow_option=${$('#paynow_option').val()}`
            })
            $('#modal-error').modal({
                'backdrop' : 'static'
            })
            $('#modal-error').modal('show')
        }
    }
    $('#use_coupon').click(function (){
        const coupon_code = $('#coupon_code').val()
        window.location.href = `/upload/order?order_id=${$('#order-id').val()}&paynow_option=${$('#paynow_option').val()}&coupon_code=${coupon_code}`
    })
    $('#remove-coupon').click(function (){
        window.location.href = `/upload/order?order_id=${$('#order-id').val()}&paynow_option=${$('#paynow_option').val()}`
    })
})();
