@inject('provider', 'App\Http\Controllers\ServiceProvider')

@extends('admin.layouts.layout')

@section('content')
    <div class="card">
        <div class="card-header">認識結果</div>
        <div class="card-body">
            <form method="post" id="form-audio">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>ファイル名</label>
                            <input type="text" name="name" class="form-control" value="{{$audio->name}}" disabled>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>音声</label>
                            <div>
                                <audio controls style="width: 50%">
                                    <source src="{{ $audio->url }}" type="audio/ogg">
                                    <source src="{{ $audio->url }}" type="audio/mpeg">
                                    Your browser does not support the audio element.
                                </audio>
                            </div>
                        </div>
                    </div>
                    @if($audio->diarization == 1)
                    <div class="col-md-12 d-flex align-items-center" STYLE="justify-content: right">
                        <div class="form-group">
                            <input type="file" hidden id="input-csv" accept=".csv">
                            <button type="button" class="btn btn-common-outline ml-2" id="upload-csv">Upload</button>
                            <label id="label-input-csv"></label>
                        </div>
                    </div>
                    @endif
                    <div class="col-md-12 mt-4">
                        <div class="form-group">
                            <label>ブラッシュアップ結果</label>
                            <div class="edited-result">
                                @if( $audio->diarization == 1)
                                    @if($audio->edited_result)
                                        <div class="option-box admin" style="height: 500px">
                                            @if($audio->edited_result)
                                                @php $spks = $provider::spk2id(json_decode($audio->edited_result)) @endphp
                                                @foreach(json_decode($audio->edited_result) as $edited_result)
                                                    @if(trim($edited_result->text) != '')
                                                        <div class="edit-item">
                                                            <div class="top-edit">
                                                                <select class="speaker-edit">
                                                                    @for($i = 1; $i <=15; $i++)
                                                                        <option
                                                                            value="{{$i}}" {{$spks[$edited_result->speaker] == $i ? 'selected' : ''}}>
                                                                            スピーカー {{$i}}</option>
                                                                    @endfor
                                                                </select>
                                                                <div class="d-flex align-items-center time-edit-group">
                                                                    <p class="mr-2">開始</p>
                                                                    <input type="text" name="start"
                                                                           class="time-edit mr-3 html-duration-picker"
                                                                           value="{{gmdate("H:i:s", $edited_result->start)}}">
                                                                    <p class="mr-2">終了</p>
                                                                    <input type="text" name="stop"
                                                                           class="time-edit mr-2 html-duration-picker"
                                                                           value="{{gmdate("H:i:s", $edited_result->stop)}}">
                                                                </div>
                                                            </div>
                                                            <p contenteditable="true" class="edit-content">
                                                                {{$edited_result->text}}
                                                            </p>
                                                            {{-- <input type="hidden" name="path"
                                                                   value="{{$edited_result->path}}"> --}}
                                                            <i class="far fa-times-circle edit-close"></i>
                                                            <div class="edit-drop-area"></div>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </div>
                                    @endif
                                @else
                                    <textarea style="min-height: 235px" name="api_result" class="form-control"
                                              id="content">{{ $audio->edited_result }}</textarea>
                                @endif
                            </div>
                        </div>
                    </div>
                    @if( $audio->diarization == 1)
                        <div class="col-md-12">
                            <div class="text-right mt-5">
                                <button class="btn-primary-info" type="button" id="add-edit-item" style="color: white">
                                    追加 <i class="fas fa-plus-circle"></i>
                                </button>
                            </div>
                        </div>
                    @endif
                    <div class="col-md-12 mt-4 text-right">
                        <a href="/admin/orders/{{$order->id}}/audio/{{$audio->id}}">
                            <button type="button" class="btn btn-common-outline">キャンセル</button>
                        </a>
                        <button type="button" class="btn btn-common" id="submit">編集結果を保存</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <input type="hidden" name="order_id" value="{{ $order->id }}">
    <input type="hidden" name="audio_id" value="{{ $audio->id }}">
    <input type="hidden" name="diarization" value="{{ $audio->diarization }}">
    <div class="modal fade info-modal" id="delete-edit-item" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <div class="modal-body px-3">
                    <div class="btn-close-modal" data-dismiss="modal">
                        <i class="fas fa-times-circle"></i>
                    </div>
                    <img src="{{ asset('/user/images/info.png') }}">
                    <h4 class="notification-title">ダイアログ削除</h4>
                    <p class="notification-body" style="font-size: 18px">
                        「<span class="delete-text-content"></span>」の内容を削除してもよろしいでしょうか？
                    </p>
                    <div class="text-center">
                        <button type="button" class="btn-secondary-info group mr-3" data-dismiss="modal"><i
                                class="far fa-arrow-alt-circle-left"></i> いいえ
                        </button>
                        <button type="submit" id="delete-item" class="btn-primary-info group">はい <i
                                class="far fa-arrow-alt-circle-right"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade info-modal" id="delete-edit-item-success" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="btn-close-modal" data-dismiss="modal">
                        <i class="fas fa-times-circle"></i>
                    </div>
                    <img src="{{ asset('/user/images/icon-success.png') }}">
                    <h4 class="notification-title">ダイアログを削除しました</h4>
                    <div class="text-center">
                        <button type="button" class="btn-primary-info btn-ok" data-dismiss="modal">OK</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade info-modal" id="save-fail" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="btn-close-modal" data-dismiss="modal">
                        <i class="fas fa-times-circle"></i>
                    </div>
                    <img src="{{ asset('/user/images/info.png') }}">
                    <h4 class="notification-title">未入力項目があります。</h4>
                    <p class="notification-body">
                        入力してください。
                    </p>
                    <div class="text-center">
                        <button type="button" class="btn-primary-info btn-ok" data-dismiss="modal">OK</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade info-modal" id="confirm_modal" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="btn-close-modal" data-dismiss="modal">
                        <i class="fas fa-times-circle "></i>
                    </div>
                    <img src="{{ asset('/user/images/icon-success.png') }}">
                    <h4 class="notification-title"></h4>
                    <p class="notification-body">このドキュメントは変更されました。 変更を保存しますか？</p>
                    <div class="text-center">
                        <button type="button" class="btn-secondary-info group mr-3" data-dismiss="modal"><i
                                class="far fa-arrow-alt-circle-left"></i> <span id='text-prev'>キャンセル</span></button>
                        <button type="button" id="save" class="btn-primary-info group" data-dismiss="modal">
                            <span>保存 </span><i class="far fa-arrow-alt-circle-right"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('/user/js/html-duration-picker.min.js')}}"></script>
    <script>
        var spk2id = function (data) {
            if (data) {
                let spks = [];
                let res = {};
                for (let x of data) {
                    if (!spks.includes(x['speaker'])) {
                        spks.push(x['speaker'])
                    }
                }
                for (let i = 1; i <= spks.length; i++) {
                    res[spks[i-1]] = spks[i-1]
                }
                return res
            }
        }
        const id = $('input[name=order_id]').val()
        const audioId = $('input[name=audio_id]').val()
        $("#export-csv").click(async function (event) {
            event.preventDefault();
            await fetch('/admin/audio/export/' + id + '/' + audioId, {
                method: 'GET',
            })
                .then(r => r.json().then(data => data))
                .then(response => {
                    if (response.success) {
                        var link = document.createElement("a");
                        link.setAttribute('download', response.filename);
                        link.href = response.url;
                        document.body.appendChild(link);
                        link.click();
                        link.remove();
                    }
                })
                .catch((error) => {
                    console.log(error)
                });
        })

        $("#upload-csv").click(async function (event) {
            event.preventDefault();
            $("#input-csv").prop('disabled', false);
            $("#input-csv").click();
        })

        $('body').on("change", "#input-csv", function (event) {
            var data = new FormData();
            data.append('file', event.target.files[0]);
            data.append('type', $('input[name=diarization]').val());
            data.append('_token', "{{ csrf_token() }}");
            console.log(event.target.files);
            $("#label-input-csv").html(event.target.files[0].name);
            $("#input-csv").val('');
            fetch('/admin/audio/upload_csv', {
                method: 'POST',
                body: data
            })
                .then(r => r.json().then(data => data))
                .then(response => {
                    $('.edited-result').html('');
                    let edited_result_html = '';
                    if ($('input[name=diarization]').val() == 1) {
                        let speakers = spk2id(response.data);

                        for (let i = 0; i < response.data.length; i++) {
                            if (response.data[i].text != '' && response.data[i].text != null) {
                                let options = '';
                                for (let z = 1; z <= 15; z++) {
                                    options += `<option
                                            value="${z}" ${speakers[response.data[i].speaker] == z ? 'selected' : ''}>
                                                                                    スピーカー ${z}</option>`
                                }
                                edited_result_html += `<div class="edit-item">
                                                            <div class="top-edit">
                                                                <select class="speaker-edit">
                                                                  ${options}
                                </select>
                                <div class="d-flex align-items-center time-edit-group">
                                    <p class="mr-2">開始</p>
                                    <input type="text" name="start"
                                           class="time-edit mr-3 html-duration-picker"
                                           value="${new Date(response.data[i].start * 1000).toISOString().substr(11, 8)}">
                                                                    <p class="mr-2">終了</p>
                                                                    <input type="text" name="stop"
                                                                           class="time-edit mr-2 html-duration-picker"
                                                                           value="${new Date(response.data[i].stop * 1000).toISOString().substr(11, 8)}">
                                                                </div>
                                                            </div>
                                                            <p contenteditable="true" class="edit-content">
                                                                ${response.data[i].text}
                                </p>
                                <input type="hidden" name="path"
                                       value="${response.data[i].path}">
                                                            <i class="far fa-times-circle edit-close"></i>
                                                            <div class="edit-drop-area"></div>
                                                        </div>`
                            }
                        }
                        $('.edited-result').html(` <div class="option-box admin" style="height: 500px">
                                                     ${edited_result_html}
                                                   </div>`)
                    } else {
                        edited_result_html = `<textarea style="min-height: 235px" name="edited_result" class="form-control">${response.data ? response.data : ''}</textarea>`
                        $('.edited-result').html(`${edited_result_html}`)
                    }

                    $('.edit-item').draggable({
                        cursor: 'pointer',
                        revert: true,
                        revertDuration: 200,
                        opacity: 0.5,
                        drag: function( event, ui ) {
                            $('.edit-drop-area').not($(this).find('.edit-drop-area')).not($(this).prev().find('.edit-drop-area')).addClass('dragging')
                        },
                        stop: function( event, ui ) {
                            $('.edit-drop-area').removeClass('dragging')
                        }
                    })
                    HtmlDurationPicker.refresh()
                })
                .catch((error) => {
                    console.log(error);
                    alert("File error");
                });
        })
        $('#add-edit-item').click(function () {
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
            console.log(edit_content.length)
            if (edit_content.length > 30) {
                edit_content = edit_content.slice(0, 30) + '...'
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

        $('#submit').click(function () {
            $('#confirm_modal').modal('show');
        })

        function hmsToSec(hms) {
            const a = hms.split(':')
            return (+a[0]) * 60 * 60 + (+a[1]) * 60 + (+a[2])
        }

        $(document).on("click", "#save", function (e) {
            let data = {
                'audio_id': $('input[name=audio_id]').val(),
                'order_id': $('input[name=order_id]').val()
            }
            let isFalse = 0

            let content = []
            if ($('input[name=diarization]').val() == 1) {
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
                    url: "/admin/orders/audio",
                    type: "post",
                    data: data,
                    success: function (response) {
                        $("body").removeClass("load");
                        window.location.href = `/admin/orders/${id}/audio/${audioId}`
                    },
                    error: function (e) {
                        $("body").removeClass("load");
                        console.log(e)
                    },
                });
            }
        });
    </script>
@endsection

