@inject('provider', 'App\Http\Controllers\ServiceProvider')

@extends('admin.layouts.layout')
@section('style')
    <link rel="stylesheet" href="{{ asset('/user/css/boostrap-rating.css') }}">
    <style>
        .rating-symbol .far {
            margin-left: 0;
        }

        .rating-symbol .fas {
            color: #FFC100;
        }

        .rating-symbol .fas.empty {
            color: #8F8F8F;
            cursor: default;
        }

        .rating-symbol .fa-star {
            font-size: 20px;
            cursor: pointer;
        }

        .rating-symbol .fa-star.rated {
            font-size: 20px;
            cursor: default;
        }

        .rating-symbol {
            margin: 0 3px;
        }
    </style>
@endsection
@section('content')
    <div class="card">
        <div class="card-header">認識結果</div>
        <div class="card-body">
            <form method="post" id="form-audio">

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
                                @if($audio->status == 3)
                                    <p style="color: #8C8C8C">
                                        VOITRAの利用規約により、自動削除されました。</p>
                                @else
                                    <audio controls style="width: 50%">
                                        <source src="{{ $audio->url }}" type="audio/ogg">
                                        <source src="{{ $audio->url }}" type="audio/mpeg">
                                        Your browser does not support the audio element.
                                    </audio>
                                @endif
                            </div>
                        </div>
                    </div>
                    @if($audio->diarization == 1 && $audio->status != 3)
                        <div class="col-md-12 d-flex align-items-center" STYLE="justify-content: right">
                            <div class="form-group">
                                <button class="btn btn-common-outline" id="export-csv">Export</button>
                                <input type="file" hidden id="input-csv" accept=".csv">
                                <label id="label-input-csv"></label>
                            </div>
                        </div>
                    @endif
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Googleの認識結果</label>
                            @if($audio->status == 3)
                                <div class="option-box-deleted">
                                    VOITRAの利用規約により、自動削除されました。
                                </div>
                            @else
                                @if( $audio->diarization == 1 && $audio->api_result)
                                    <div class="option-box admin">
                                        @if($audio->api_result)
                                            @php $spks = $provider::spk2id(json_decode($audio->api_result)) @endphp
                                            @foreach(json_decode($audio->api_result) as $api_result)
                                                @if(trim($api_result->text) != '')
                                                    <div class="row mb-2">
                                                        <div class="col-md-2 col-12">
                                                            <p class="option-speaker speaker-{{$spks[$api_result->speaker] <= 4 ? $spks[$api_result->speaker] : $spks[$api_result->speaker] % 5}}">
                                                                スピーカー{{$api_result->speaker}}</p>
                                                            <p class="option-time">{{gmdate("H:i:s", $api_result->start)}}</p>
                                                        </div>
                                                        <div class="col-md-10 col-12">
                                                            <p class="option-result speaker-{{$spks[$api_result->speaker] <= 4 ? $spks[$api_result->speaker] : $spks[$api_result->speaker] % 5}}">{{$api_result->text}}</p>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        @endif
                                    </div>
                                @else
                                    <textarea style="min-height: 235px" name="api_result" class="form-control"
                                              readonly>{{ $audio->api_result }}</textarea>
                                @endif
                            @endif
                        </div>
                    </div>
                    @if($order->plan == 2)
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>ブラッシュアップ結果</label>
                            @if($audio->status == 3)
                                <div class="option-box-deleted">
                                    VOITRAの利用規約により、自動削除されました。
                                </div>
                            @else
                                @if( $audio->diarization == 1 && $audio->edited_result)
                                    <div class="option-box admin">
                                        @if($audio->edited_result)
                                            @php $spks = $provider::spk2id(json_decode($audio->edited_result)) @endphp
                                            @foreach(json_decode($audio->edited_result) as $edited_result)
                                                @if(trim($edited_result->text) != '')
                                                    <div class="row mb-2">
                                                        <div class="col-md-2 col-12">
                                                            <p class="option-speaker speaker-{{$spks[$edited_result->speaker] <= 4 ? $spks[$edited_result->speaker] : $spks[$edited_result->speaker] % 5}}">
                                                                スピーカー{{$edited_result->speaker}}</p>
                                                            <p class="option-time">{{gmdate("H:i:s", $edited_result->start)}}</p>
                                                        </div>
                                                        <div class="col-md-10 col-12">
                                                            <p class="option-result speaker-{{$spks[$edited_result->speaker] <= 4 ? $spks[$edited_result->speaker] : $spks[$edited_result->speaker] % 5}}">{{$edited_result->text}}</p>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        @endif
                                    </div>
                                @else
                                    <textarea style="min-height: 235px" name="api_result" class="form-control"
                                              readonly>{{ $audio->edited_result }}</textarea>
                                @endif
                            @endif
                        </div>
                    </div>
                    @endif
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>{{ $order->plan == 1 ? 'プラン１の満足度' : 'プラン２の満足度'}}</label>
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="hidden"
                                        name="rate-plan-2"
                                        class="rating"
                                        data-filled="fas fa-star"
                                        data-empty="fas fa-star empty"
                                        value="{{$order->pivot->rate}}"
                                        disabled
                                    />
                                </div>
                                <div class="col-md-6 text-right">
                                    <span class="feedback-date">{{$order->pivot->rate_at}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>{{ $order->plan == 1 ? 'プラン１のレビュー' : 'プラン２のレビュー'}}</label>
                                </div>
                                <div class="col-md-6 text-right">
                                    <span class="feedback-date ml-0">{{$order->pivot->comment_at}}</span>
                                </div>
                            </div>
                            <textarea class="form-control" name="comment" style="min-height: 120px"
                                      disabled>{{$order->pivot->comment}}</textarea>
                        </div>
                    </div>
                    <div class="col-md-12 mt-4 text-right">
                        <a href="/admin/orders/{{$order->id}}/edit">
                            <button type="button" class="btn btn-common-outline">戻る</button>
                        </a>
                        @if($order->plan == 2 && ((in_array($order->status,[3, 11, 12, 6]) && $isEditStaff && $isAdmin) || (in_array($order->status,[11]) && !$isAdmin && $isEditStaff)))
                            <a href="/admin/orders/{{$order->id}}/audio/{{$audio->id}}/edit">
                                <button type="button"
                                        class="btn btn-common-outline">{{$order->status == 6 ? '納品後編集' : '編集'}}</button>
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>
    <input type="hidden" name="order_id" value="{{ $order->id }}">
    <input type="hidden" name="audio_id" value="{{ $audio->id }}">
    <input type="hidden" name="diarization" value="{{ $audio->diarization }}">
@endsection
@section('script')
    <script src="{{ asset('/user/js/boostrap-rating.min.js')}} "></script>
    <script>
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
    </script>
@endsection
