<div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="formModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formModalTitle"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body audio-result-body">
                <form id="form" action="" method="post">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="form-group">
                                    <label for="id">顧客名:</label>
                                    <input class="form-control" name="id" id="id" type="text" maxlength="255" value="{{$order->id}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="form-group">
                                    <label for="user_name">顧客名:</label>
                                    <input class="form-control" name="user_name" id="user_name" type="text" maxlength="255">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="staff_id">担当スタッフ:</label>
                                <select class="form-control staff-select" id="staff_id" name="staff_id">
                                    <option value="">選択してください</option>
                                    @foreach($staffsConst as $key => $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="total_price">決済金額:</label>
                                <input class="form-control" name="total_price" id="total_price" type="text" maxlength="255">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="total_time">合計時間:</label>
                                <input class="form-control" name="total_time" id="total_time" type="text" maxlength="255">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="deadline">納品予定日:</label>
                                <input class="form-control" name="deadline" id="deadline" type="date" maxlength="255">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="user_estimate">納品希望日:</label>
                                <input class="form-control" name="user_estimate" id="user_estimate" type="date" maxlength="255">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="plan">プラン:</label>
                                <select class="form-control" id="status" name="status">
                                    <option value="1">Plan 1</option>
                                    <option value="2">Plan 2</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 status-input plan-2">
                            <div class="form-group">
                                <label for="status">ステータス:</label>
                                <select class="form-control" id="status" name="status">
                                    @foreach($statusConst as $key => $item)
                                    <option value="{{ $key }}" {{ in_array($key, [0,1,3,7]) ? 'disabled' : ''}}>{{ $item }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 status-input plan-1">
                            <div class="form-group">
                                <label for="status">ステータス:</label>
                                <select class="form-control" id="status" name="status">
                                    @foreach($audioConst as $key => $item)
                                    <option value="{{ $key }}">{{ $item }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="form-group">
                                    <label for="user_estimate">メモ:</label>
                                    <input class="form-control" name="memo" id="memo" type="text">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row times">
                        <div class="col-md-12">
                            <p class="mb-0"><strong>登録時間:</strong> <span></span></p>
                            <p class="mb-0"><strong>最終更新:</strong> <span></span></p>
                        </div>
                    </div>

                    <div class="table-responsive" style="max-height: 200px">
                        <table class="table table-responsive-sm mt-5">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>ファイル名</th>
                                    <th class="text-center">音声</th>
                                    <th class="text-center">ステータス</th>
                                    <th>発注時間</th>
                                    <th class="text-center">操作</th>
                                </tr>
                            </thead>
                            <tbody id="audio-list">
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn  btn-common-outline submit" data-dismiss="modal">閉じる</button>
                <button type="button" class="btn btn-common" id="submit">更新</button>
            </div>

        </div>
    </div>
</div>
<input type="hidden" id="orderStatus" name="orderStatus">
<script>
    $(document).ready(function() {
        $.validator.messages.required = '入力してください。';
        $("#formModal").find('form').validate({
            onfocusout: false,
            onkeyup: false,
            onclick: false,
            errorClass: "is-invalid",
            rules: {
                'total_price': {
                    number: true,
                    min: 0,
                },
                'deadline': {
                    date: true,
                    required: true,
                }
            },
            messages: {
                'total_price': {
                    number: 'total_price must be number!',
                    min: 'total_price must be better then 0!'
                },
                'deadline': {
                    date: '日付形式で入力必要があります。'
                }
            }
        })
        $('#submit').click(function() {
            const result = $("#form").valid();
            if (result) {
                $("#confirm_modal").modal("show");
            }
        });
        $('#action').click(function() {
            $('#form').submit()
        });
    })
</script>
