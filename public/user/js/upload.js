(function() {
    function Init() {
        var fileSelect = document.getElementById("file-upload"),
            fileDrag = document.getElementById("file-drag");

        $('#file-upload-btn').on('click', function(e) {
            e.preventDefault();
            $('#file-upload').click()
        })
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
        if (!e.target.files) {
            fileSelect = document.getElementById("file-upload");
            fileSelect.files = e.dataTransfer.files;
        }
        var totalFileSize = filesize;
        var fileSizeLimit = 256 * 1024 * 1024;
        fileDragHover(e);
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
        if (files.length > 5) {
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
            upload();
        }
    }

    function upload() {
        $('body').addClass('load');
        $('#lang').val($('#language').val());
        $('#file-upload-form').submit();
    }
    if (window.File && window.FileList && window.FileReader) {
        Init();
    } else {
        document.getElementById("file-drag").style.display = "none";
    }

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
    $(document).on('click', '#register-trail', function(e) {
        // register()
        $('#modal_register_trail').modal('show');
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
})();
