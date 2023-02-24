<div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="formModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formModalTitle"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form" action="" method="post">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">名前:</label>
                                <input class="form-control" name="name" id="name" type="text" maxlength="255">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">メールアドレス:</label>
                                <input class="form-control" name="email" id="email" type="email" maxlength="255">
                            </div>
                        </div>
                        <div class="col-md-6 password-input">
                            <div class="form-group">
                                <label for="password">パスワード:</label>
                                <input class="form-control" name="password" id="password" type="text" maxlength="255">
                            </div>
                        </div>
                        <div class="col-md-6 status-input">
                            <div class="form-group">
                                <label for="email">ステータス:</label>
                                <select class="form-control" id="status" name="status">
                                    @foreach($statusConst as $key => $item)
                                        <option value="{{ $key }}">{{ $item }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row times">
                        <div class="col-md-12">
                            <p class="mb-0"><strong>登録時間:</strong> <span></span></p>
                            <p class="mb-0"><strong>最終更新:</strong> <span></span></p>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn  btn-common-outline submit" data-dismiss="modal">閉じる</button>
                <button type="button" class="btn btn-common" id="submit">保存</button>
            </div>

        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $("#formModal").find('form').validate({
            onfocusout: false,
            onkeyup: false,
            onclick: false,
            errorClass: "is-invalid",
            rules: {
                'name': {
                    required: true,
                },
                'email': {
                    required: true,
                },
                'password': {
                    required: true,
                }
            },
            messages: {
                'name': {
                    required: 'メールアドレスが必要です。'
                },
                'email': {
                    required: 'メールアドレスが必要です。'
                },
                'password': {
                    required: 'パスワードが必要です。',
                }
            }
        })
        $('#submit').click(function () {
            const result = $("#form").valid();
            if (result) {
                $('#form').submit()
            }
        });
    })
</script>
