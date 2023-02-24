(function() {
    var listSelectT1 = [];
    var listSelectT2 = [];
    $.fn.DataTable.ext.pager.numbers_length = 5;
    $("#order-p1").DataTable({
        paging: true,
        lengthChange: true,
        searching: false,
        ordering: false,
        info: true,
        autoWidth: false,
        order: [1, 2, 3, 4],
        language: {
            decimal: ".",
            thousands: ",",
            sLengthMenu: "_MENU_ 件/ページ ",
            sZeroRecords: "データはありません。",
            sInfoPostFix: "",
            sSearch: "検索:",
            sUrl: "",
            oPaginate: {
                sFirst: "<<",
                sPrevious: "<",
                sNext: ">",
                sLast: ">>",
            },
        },
        pageLength: 8,
        sDom: 'rt<"pagination"ipl>',
    });
    $("#order-p2").DataTable({
        paging: true,
        lengthChange: true,
        searching: false,
        ordering: false,
        info: true,
        autoWidth: false,
        order: [1, 2, 3, 4],
        language: {
            decimal: ".",
            thousands: ",",
            sLengthMenu: "_MENU_ 件/ページ ",
            sZeroRecords: "データはありません。",
            sInfoPostFix: "",
            sSearch: "検索:",
            sUrl: "",
            oPaginate: {
                sFirst: "<<",
                sPrevious: "<",
                sNext: ">",
                sLast: ">>",
            },
        },
        pageLength: 8,
        sDom: 'rt<"pagination"ipl>',
    });
    $(document).on("change", ".checkbox-p1", function(e) {
        let id = $(this).closest("tr[data-id]").attr("data-id");
        if (!listSelectT1.includes(id)) {
            listSelectT1.push(id);
        } else {
            const index = listSelectT1.indexOf(id);
            if (index > -1) {
                listSelectT1.splice(index, 1);
            }
        }
        if (!$(this).is(":checked")) {
            $(".select-order-p1").prop("checked", false);
        }
    });
    $(document).on("change", ".checkbox-p2", function(e) {
        let id = $(this).closest("tr[data-id]").attr("data-id");
        if (!listSelectT2.includes(id)) {
            listSelectT2.push(id);
        } else {
            const index = listSelectT2.indexOf(id);
            if (index > -1) {
                listSelectT2.splice(index, 1);
            }
        }
        if (!$(this).is(":checked")) {
            $(".select-order-p2").prop("checked", false);
        }
    });
    $(".select-order-p1").change(function(e) {
        listSelectT1 = [];
        if ($(this).is(":checked")) {
            $(this)
                .closest("table")
                .find("td input:checkbox").not(':disabled')
                .prop("checked", true);
            $(this)
                .closest("table")
                .find("td input:checkbox").not(':disabled')
                .each((index, e) => {
                    let id = $(e).closest("tr[data-id]").attr("data-id");
                    // if (!listSelectT1.includes(id)) {
                        listSelectT1.push(id);
                    // } else {
                    //     const index = listSelectT1.indexOf(id);
                    //     if (index > -1) {
                    //         listSelectT1.splice(index, 1);
                    //     }
                    // }
                });
        } else {
            $(this)
                .closest("table")
                .find("td input:checkbox")
                .prop("checked", false);
        }
        console.log(listSelectT1)
    });
    $(".select-order-p2").change(function(e) {
        listSelectT2 = [];
        if ($(this).is(":checked")) {
            $(this)
                .closest("table")
                .find(".checkbox-p2").not(':disabled')
                .prop("checked", true);
            $(this)
                .closest("table")
                .find(".checkbox-p2").not(':disabled')
                .each((index, e) => {
                    let id = $(e).closest("tr[data-id]").attr("data-id");
                    // if (!listSelectT2.includes(id)) {
                        listSelectT2.push(id);
                    // } else {
                    //     const index = listSelectT2.indexOf(id);
                    //     if (index > -1) {
                    //         listSelectT2.splice(index, 1);
                    //     }
                    // }
                });
        } else {
            $(this)
                .closest("table")
                .find(".checkbox-p2")
                .prop("checked", false);
        }
    });

    $("#brush-up").click(function() {
        if (listSelectT1.length <= 0) {
            showNofile();
            return
        }
        let data = {
            audios: listSelectT1,
        };
        brushUp(data);
    });

    function showNofile() {
        $("#notify-modal .notify-body").html(
            "ファイルを選択してください。"
        );
        $('#notify-modal').modal('show');
    }

    function brushUp(data) {
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
                    $("#modal-error .notification-title").html();
                    $("#modal-error .notification-body").html(
                        "このファイルはブラッシュアップ依頼できません。"
                    );
                    $('#modal-error').modal('show');
                }
            },
            error: function(e) {
                $("body").removeClass("load");
                $("#modal-error .notification-title").html();
                $("#modal-error .notification-body").html(
                    "このファイルはブラッシュアップ依頼できません。"
                );
                $('#modal-error').modal('show');
            },
        });
    }
    $("#download-p1").click(function() {
        if (listSelectT1.length <= 0) {
            showNofile();
            return
        }
        $("#confirm_modal img").attr('src', '/user/images/download-icon.png');
        $("#confirm_modal .notification-body").html(
            '選択したファイルをダウンロードします。よろしいですか'
        );
        $('#action').removeClass('download-p2');
        $('#action').removeClass('delete-p1');
        $('#action').removeClass('delete-p2');
        $('#action').addClass('download-p1');
        $('#action #text').html('ダウンロード');
        $("#confirm_modal").modal("show");
    });
    $("#download-p2").click(function() {
        if (listSelectT2.length <= 0) {
            showNofile();
            return
        }
        $("#confirm_modal img").attr('src', '/user/images/download-icon.png');
        $("#confirm_modal .notification-body").html(
            '選択したファイルをダウンロードします。よろしいですか'
        );
        $('#action').removeClass('download-p1');
        $('#action').removeClass('delete-p1');
        $('#action').removeClass('delete-p2');
        $('#action').addClass('download-p2');
        $('#action #text').html('ダウンロード');
        $("#confirm_modal").modal("show");
    });

    $(document).on("click", ".download-p1", function(e) {
        let data = {
            audios: listSelectT1,
            type: 1,
        };
        download(data);
    });

    $(document).on("click", ".download-p2", function(e) {
        let data = {
            audios: listSelectT2,
            type: 2,
        };
        download(data);
    });

    function download(data) {
        $("body").addClass("load");
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('input[name="_token"]').attr("value"),
            },
            url: "/audio/download",
            type: "post",
            data: data,
            success: function(response) {
                if (response.success) {
                    var link = document.createElement("a");
                    link.setAttribute('download', response.filename);
                    link.href = response.url;
                    document.body.appendChild(link);
                    link.click();
                    link.remove();
                }
                $("body").removeClass("load");
            },
            error: function(e) {
                console.log(e)
                $("#modal-error .notification-title").html();
                $("#modal-error .notification-body").html(e.responseJSON.msg);
                $('#modal-error').modal('show');
                $("body").removeClass("load");
            },
        });
    }
    $("#cancel-brushup").click(function() {
        if (listSelectT2.length <= 0) {
            showNofile();
            return
        }
        let data = {
            audios: listSelectT2,
            type: 1,
        };
        cancelBrushup(data);
    });

    function cancelBrushup(data) {
        $("body").addClass("load");
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('input[name="_token"]').attr("value"),
            },
            url: "/audio/cancel-brushup",
            type: "post",
            data: data,
            success: function(response) {
                $("body").removeClass("load");
                if (response.success) {
                    window.location.replace(
                        "/audio/brushup/" + response.order_id
                    );
                } else {
                    $("#modal-error .notification-title").html(
                        "このファイルは<br>ブラッシュアップ再依頼できません。"
                    );
                    $("#modal-error .notification-body").html(
                        "ファイルは処理中もしくはブラッシュアップ済みです。"
                    );
                    $('#modal-error').modal('show');
                }
            },
            error: function(e) {
                $("body").removeClass("load");
                $("#modal-error .notification-title").html(
                    "このファイルは<br>ブラッシュアップ再依頼できません。"
                );
                $("#modal-error .notification-body").html(
                    "ファイルは処理中もしくはブラッシュアップ済みです。"
                );
                $('#modal-error').modal('show');
            },
        });
    }
    $("#delete-p1").click(function() {
        if (listSelectT1.length <= 0) {
            showNofile();
            return
        }
        $("#confirm_modal img").attr('src', '/user/images/remove-icon.png');
        $("#confirm_modal .notification-body").html(
            'こちらのファイルを削除します。\nよろしいですか？ '
        );
        $('#action').removeClass('download-p2');
        $('#action').removeClass('download-p1');
        $('#action').removeClass('delete-p2');
        $('#text').html('削除');
        $("#confirm_modal").modal("show");
        $('#action').addClass('delete-p1');
    });
    $("#delete-p2").click(function() {
        if (listSelectT2.length <= 0) {
            showNofile();
            return
        }
        $("#confirm_modal img").attr('src', '/user/images/remove-icon.png');
        $("#confirm_modal .notification-body").html(
            'こちらのファイルを削除します。\nよろしいですか？ '
        );
        $('#action').removeClass('download-p2');
        $('#action').removeClass('download-p1');
        $('#action').removeClass('delete-p1');
        $('#text').html('削除');
        $('#action').addClass('delete-p2');
        $("#confirm_modal").modal("show");
    });

    $(document).on("click", ".delete-p1", function(e) {
        let data = {
            audios: listSelectT1,
            type: 1,
        };
        deleteAudio(data);
    });

    $(document).on("click", ".delete-p2", function(e) {
        let data = {
            audios: listSelectT2,
            type: 2,
        };
        deleteAudio(data);
    });

    function deleteAudio(data) {
        $("body").addClass("load");
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('input[name="_token"]').attr("value"),
            },
            url: "/audio/delete",
            type: "delete",
            data: data,
            success: function(response) {
                if (response.success) {
                    window.location.reload();
                }
                // console.log(response)
                $("body").removeClass("load");
            },
            error: function(e) {
                $("body").removeClass("load");
               $("#modal-error .notification-title").html(
                    "削除できません。"
                );
                $("#modal-error .notification-body").html(
                    "このファイルは処理中のため、削除できません。"
                );
                $('#modal-error').modal('show');
            },
        });
    }
    $('.checkmark').click(function() {
        $('.regular-checkbox').trigger('click')
    })
})();
