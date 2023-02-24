(function () {
    var change = false;
    var type = 0;
    $(document).on("change", "#context", function (e) {
        change = true
    });
    var editName = function () {
        let data = {
            audio: $('#audio-id').val(),
            name: $('#audio-name').val()
        };
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('input[name="_token"]').attr("value"),
            },
            url: "/audio/editname",
            type: "post",
            data: data,
            success: function (response) {
                $("body").removeClass("load");
                if (response.success) {
                    $('#name').html(response.name);
                }
            },
            error: function (e) {
                $("body").removeClass("load");
            },
        });
    }

    function byteLength(str) {
        var s = 0;
        var newstr = '';
        for (var i = 0; i < str.length; i++) {
            var code = str.charCodeAt(i);
            s += 1;
            if (code > 0x7f && code <= 0x7ff) s++;
            else if (code > 0x7ff && code <= 0xffff) s += 2;
            if (code >= 0xDC00 && code <= 0xDFFF) i--; //trail surrogate
            if (s < 100) {
                newstr += str[i]
            } else {
                break;
            }
        }
        return newstr;
    }

    $('#audio-name').keyup(function (e) {
        var code = e.key;
        $('#audio-name').val(byteLength($('#audio-name').val()));
        if (code == 'Enter') {
            if ($('#edit-name').hasClass('save-btn')) {
                $('#edit-name').removeClass('save-btn');
                $('#edit-name').addClass('edit-btn');
                $('#audio-name').hide();
                $('.audio-name').show();
                editName()
            }
        }

    })
    // $("#edit-data").click(function (e) {
    //     let url = '/audio/edit/' + $(this).attr('data-id') + '?type=' + type;
    //     window.location.replace(url);
    // })
    $('#edit-name').click(function (e) {
        if ($(this).hasClass('edit-btn')) {
            $(this).removeClass('edit-btn');
            $(this).addClass('save-btn');
            $('#audio-name').show();
            $('#audio-name').focus();
            $('.audio-name').hide();
        } else if ($(this).hasClass('save-btn')) {
            $(this).removeClass('save-btn');
            $(this).addClass('edit-btn');
            $('#audio-name').hide();
            $('.audio-name').show();
            editName()
        }

    })
    $("#save").click(function () {
        $("#confirm_modal img").attr('src', '/user/images/icon-success.png');
        $("#confirm_modal .notification-body").html(
            'このドキュメントは変更されました。 変更を保存しますか？'
        );
        $("#confirm_modal").modal("show");
        $('#action  #text').html('保存');
        $('#action').addClass('save');
    });
    $("#save-quit").click(function () {
        $("#confirm_modal img").attr('src', '/user/images/icon-success.png');
        $("#confirm_modal .notification-body").html(
            'このドキュメントは変更されました。 変更を保存しますか？'
        );
        $("#confirm_modal").modal("show");
        $('#action  #text').html('保存');
        $('#action').addClass('save-quit');
    });
    $(document).on("click", ".save-quit", function (e) {
        let data = {
            'audio_id': $('#audio-id').val(),
            'option': $('#option').val(),
            'type': $('#type').val()
        }
        let isFalse = 0
        if ($('#option').val() == 1) {
            let content = []
            $('.edit-item').each(function () {
                if ($(this).find('.edit-content').text().trim().length == 0) {
                    isFalse = 1
                }
                content.push({
                    'start': hmsToSec($(this).find('.time-edit[name=start]').val()),
                    'stop': hmsToSec($(this).find('.time-edit[name=stop]').val()),
                    'speaker': $(this).find('.speaker-edit').val(),
                    'text': $(this).find('.edit-content').text().trim(),
                    'path': $(this).find('input[name=path]').val(),
                })
            })
            data.content = JSON.stringify(content)
        } else {
            data.content = $('#content').val()
        }
        if (isFalse) {
            $('#save-fail').modal('show')
        } else {
            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": $('input[name="_token"]').attr("value"),
                },
                url: "/audio/save",
                type: "post",
                data: data,
                success: function (response) {
                    $("body").removeClass("load");
                    window.location.replace('/audio/view/' + $('#audio-id').val())
                },
                error: function (e) {
                    $("body").removeClass("load");
                },
            });
        }
    });
    $(document).on("click", '#cancel-brushup', function (e) {
        let data = {
            'audios': [$('#audio-id').val()],
        }
        $("body").addClass("load");
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('input[name="_token"]').attr("value"),
            },
            url: "/audio/cancel-brushup",
            type: "post",
            data: data,
            success: function (response) {
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
                }
            },
            error: function (e) {
                $("body").removeClass("load");
                $("#modal-error .notification-title").html(
                    "このファイルは<br>ブラッシュアップ再依頼できません。"
                );
                $("#modal-error .notification-body").html(
                    "ファイルは処理中もしくはブラッシュアップ済みです。"
                );
            },
        });
    })

    function hmsToSec(hms) {
        const a = hms.split(':')
        return (+a[0]) * 60 * 60 + (+a[1]) * 60 + (+a[2])
    }

    $(document).on("click", ".save", function (e) {
        let data = {
            'audio_id': $('#audio-id').val(),
            'option': $('#option').val(),
            'type': $('#type').val()
        }
        let isFalse = 0
        if ($('#option').val() == 1) {
            let content = []
            $('.edit-item').each(function () {
                if ($(this).find('.edit-content').text().trim().length == 0) {
                    isFalse = 1
                }
                content.push({
                    'start': hmsToSec($(this).find('.time-edit[name=start]').val()),
                    'stop': hmsToSec($(this).find('.time-edit[name=stop]').val()),
                    'speaker': $(this).find('.speaker-edit').val(),
                    'text': $(this).find('.edit-content').text().trim(),
                    'path': $(this).find('input[name=path]').val(),
                })
            })
            data.content = JSON.stringify(content)
        } else {
            data.content = $('#content').val()
        }

        if (isFalse) {
            $('#save-fail').modal('show')
        } else {
            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": $('input[name="_token"]').attr("value"),
                },
                url: "/audio/save",
                type: "post",
                data: data,
                success: function (response) {
                    $("body").removeClass("load");
                },
                error: function (e) {
                    $("body").removeClass("load");
                },
            });
        }
    });
    $("#cancel").click(function () {
        $("#confirm_modal img").attr('src', '/user/images/icon-x_fill.png');
        $("#confirm_modal .notification-title").html(
            '保存しましか？'
        );
        $("#confirm_modal .notification-body").html(
            '編集をキャンセルすると、編集内容が破棄されますが、よろしいですか？'
        );
        $("#confirm_modal").modal("show");
        $('#action  #text').html('破棄');
        $('#action').addClass('cancel');
    });
    $(document).on("click", ".cancel", function (e) {
        window.location.replace('/audio/view/' + $('#audio-id').val())
    });

    $(document).on("change", ".checkbox-p2", function (e) {
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

    $("#brush-up").click(function () {
        let data = {
            audios: [$('#audio-id').val()],
        };
        if ($('input[name=feedbackPlan]').val() != 0) {
            $('#feedback_modal .rating').rating('rate', 0)
            $('#feedback_modal textarea').val('')
            $('#feedback_modal').modal('show')
        } else {
            brushUp(data);
        }
        $('#not-feedback').click(function () {
            brushUp(data);
        })
    });

    function brushUp(data) {
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('input[name="_token"]').attr("value"),
            },
            url: "/audio/brushup",
            type: "post",
            data: data,
            success: function (response) {
                $("body").removeClass("load");
                if (response.success) {
                    if (response.order_id) {
                        window.location.replace(
                            "/audio/brushup/" + response.order_id
                        );
                    }
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
            error: function (e) {
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

    $("#download").click(function () {
        $("#confirm_modal img").attr('src', '/user/images/download-icon.png');
        $("#confirm_modal .notification-title").html(
            $('#audio-name').val()
        );
        $("#confirm_modal .notification-body").html(
            '選択したファイルをダウンロードします。よろしいですか'
        );
        $('#action').addClass('download');
        $('#action #text').html('ダウンロード');
        $("#confirm_modal").modal("show");
    });

    $(document).on("click", ".download", function (e) {
        let data = {
            audios: [$('#audio-id').val()],
            type: 1,
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
            success: function (response) {
                if (response.success) {
                    var link = document.createElement("a");
                    link.setAttribute('download', response.filename);
                    link.href = response.url.replace(response.filename, encodeURI(response.filename));
                    document.body.appendChild(link);
                    link.click();
                    link.remove();
                }
                $("body").removeClass("load");
            },
            error: function (e) {
                $("body").removeClass("load");
            },
        });
    }

    $("#delete").click(function () {
        $("#confirm_modal img").attr('src', '/user/images/remove-icon.png');
        $("#confirm_modal .notification-title").html(
            $('#audio-name').val()
        );
        $("#confirm_modal .notification-body").html(
            'こちらのファイルを削除します。\nよろしいですか？ '
        );
        $('#action').addClass('delete');
        $("#confirm_modal").modal("show");
    });

    $(document).on("click", ".delete", function (e) {
        let data = {
            audios: [$('#audio-id').val()],
            type: 1,
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
            success: function (response) {
                if (response.success) {
                    window.location.replace('/audio');
                }
                $("body").removeClass("load");
            },
            error: function (e) {
                $("body").removeClass("load");
            },
        });
    }

    $('.cs-checkbox').change(function (e) {
        $('.cs-checkbox').prop("checked", false);
        $(this).prop("checked", true);
        let id = $(this).attr('id');
        switch (id) {
            case 'type-edited':
                type = 2
                break;
            case 'type-brushup':
                type = 1
                break;
            default:
                type = 0
                break;
        }
    })
    $('#add-edit-item').click(function () {
        const num_speaker = $('#num_speaker').val();
        let option_html = '';
        for (let i = 1; i <= 15; i++) {
            option_html += `<option value="${i}">スピーカー ${i}</option>`
        }
        $('.option-box').append(`<div class="edit-item">
                                            <div class="top-edit">
                                                <select class="speaker-edit">
                                                   ${option_html}
                                                </select>
                                                <div class="d-flex align-items-center time-edit-group">
                                                    <p class="mr-2">開始</p>
                                                    <input type="text" name="start" class="time-edit mr-3 html-duration-picker" value="">
                                                    <p class="mr-2">終了</p>
                                                    <input type="text" name="stop" class="time-edit mr-2 html-duration-picker" value="">
                                                </div>
                                            </div>
                                            <p contenteditable="true" class="edit-content"> </p>
                                             <input type="hidden" name="path" value="">
                                            <i class="far fa-times-circle edit-close"></i>
                                             <div class="edit-drop-area"></div>
                                        </div>`)
        $('.edit-item').draggable({
            cursor: 'pointer',
            revert: true,
            revertDuration: 200,
            opacity: 0.5,
            drag: function (event, ui) {
                $('.edit-drop-area').not($(this).find('.edit-drop-area')).not($(this).prev().find('.edit-drop-area')).addClass('dragging')
            },
            stop: function (event, ui) {
                $('.edit-drop-area').removeClass('dragging')
            }
        })
        HtmlDurationPicker.refresh()
        $('.option-box').scrollTop(99999999999)
    })
    let delete_item = null
    $('body').on('click', '.edit-close', function () {
        $('#delete-edit-item').modal('show');
        let edit_content = $(this).parent().find('.edit-content').text().trim();
        if (edit_content.length > 50) {
            edit_content = edit_content.substr(0, 50) + '...';
        }
        $('#delete-edit-item .delete-text-content').html(edit_content)
        delete_item = $(this).parent();
    })
    $('#delete-item').click(function () {
        delete_item.remove()
        $('#delete-edit-item').modal('hide');
        $('#delete-edit-item-success').modal('show');
    })

    $('.edit-item').draggable({
        cursor: 'pointer',
        axis: 'y',
        revert: true,
        revertDuration: 200,
        opacity: 0.5,
        drag: function (event, ui) {
            $('.edit-drop-area').not($(this).find('.edit-drop-area')).not($(this).prev().find('.edit-drop-area')).addClass('dragging')
        },
        stop: function (event, ui) {
            $('.edit-drop-area').removeClass('dragging')
        }
    })
    $('.edit-drop-area').droppable({
        tolerance: "touch",
        hoverClass: "drop-hover",
        drop: function (event, ui) {
            const draggingItem = $('.edit-item.ui-draggable-dragging')
            const cantDrop = draggingItem.prev().find('.edit-drop-area')
            let drop = $(this).not(cantDrop).parent()
            if (drop.length >= 1) {
                // $('.edit-item').draggable({
                //     cursor: 'pointer',
                //     revert: true,
                //     revertDuration: 200,
                //     opacity: 0.5,
                //     drag: function( event, ui ) {
                //         $('.edit-drop-area').not($(this).find('.edit-drop-area')).not($(this).prev().find('.edit-drop-area')).addClass('dragging')
                //     },
                //     stop: function( event, ui ) {
                //         $('.edit-drop-area').removeClass('dragging')
                //     }
                // })
                // draggingItem.remove()
                swapElement(drop, draggingItem)
            }
        }
    })
    $('body').on('click', '.edit-content', function () {
        $(".edit-item").draggable("disable");
    }).on('focusout', '.edit-content', function () {
        $(".edit-item").draggable("enable");
    })

    function swapElement(a, b) {
        // create a temporary marker div
        var aNext = $('<div>').insertAfter(a);
        a.insertAfter(b);
        b.insertBefore(aNext);
        // remove marker div
        aNext.remove();
    }

    $('.rating').change(function () {
        const rate = $(this).val()
        let feedback_box;
        if ($(this).attr('data-popup') == 1) {
            feedback_box = $(this).parent().parent()
        } else {
            feedback_box = $(this).parent().parent().parent()
        }
        if (rate > 0) {
            $(feedback_box.find('.submit-feedback')).removeAttr('disabled')
        } else {
            $(feedback_box.find('.submit-feedback')).attr('disabled', true)
        }
    })

    $('.comment-box textarea').keyup(function () {
        const comment = $(this).val()
        const feedback_box = $(this).parent().parent()
        feedback_box.find('.count-char span').text($(this).val().length)
        if (feedback_box.find('.rating').is(':disabled')) {
            if (comment.length > 0) {
                $(feedback_box.find('.submit-feedback')).removeAttr('disabled')
            } else {
                $(feedback_box.find('.submit-feedback')).attr('disabled', true)
            }
        }
    })
    $('.comment-box textarea').keydown(function () {
        const comment = $(this).val()
        const feedback_box = $(this).parent().parent()
        feedback_box.find('.count-char span').text(comment.length)
    })
    $('.comment-box textarea').keyup(function () {
        const comment = $(this).val()
        if (comment.length > 255) {
            $(this).val(comment.substring(0, 255))
        }
    })
    let feedback = {};
    $('.submit-feedback').click(function () {
        const feedback_box = $(this).parent().parent()
        const is_rated = feedback_box.find('.rating').is(':disabled')
        feedback.comment = feedback_box.find('textarea').val();
        feedback.plan = feedback_box.attr('data-plan')
        if (is_rated) {
            $('#feedback_confirm_modal .rating').prev().hide()
            if (feedback.plan == 1) {
                $('#feedback_confirm_modal .notification-title').text('AI文字起こしプランのレビュー')
            } else {
                $('#feedback_confirm_modal .notification-title').text('ブラッシュアッププランのレビュー')
            }
        } else {
            if (feedback.plan == 1) {
                $('#feedback_confirm_modal .notification-title').text('AI文字起こしプランの満足度')
            } else {
                $('#feedback_confirm_modal .notification-title').text('ブラッシュアッププランの満足度')
            }

            feedback.rate = feedback_box.find('.rating').val();
            $('#feedback_confirm_modal .rating').rating('rate', feedback.rate)
            $('#feedback_confirm_modal .rating').prev().show()
        }

        $('input[name=feedbackPlan]').val(0)
        $('#feedback_confirm_modal textarea').val(feedback.comment)
        if (feedback.comment == null || feedback.comment == '') {
            $('#feedback_confirm_modal .comment-box').hide()
        } else {
            $('#feedback_confirm_modal .comment-box').show()
        }
        $('#feedback_modal').modal('hide')
        $('#feedback_confirm_modal').modal('show')
    })

    $('#send-feedback').click(function () {
        const id = $('#audio-id').val();
        console.log(feedback)
        fetch(`/audio/feedback/${id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': $('input[name=_token]').val()
            },
            body: JSON.stringify(feedback),
        })
            .then(response => response.json())
            .then(data => {
                $('#success_modal .notification-title').text(data.mess.title)
                $('#success_modal .notification-body').text(data.mess.body)
                $('#feedback_confirm_modal').modal('hide')
                $('#success_modal').modal('show')
            })
            .catch((error) => {
                $('#feedback_confirm_modal').modal('hide')
                console.error('Error:', error);
            });
    })
})();
