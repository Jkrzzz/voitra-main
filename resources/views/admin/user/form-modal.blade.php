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
                                <label for="email">メールアドレス:</label>
                                <input class="form-control" name="email" id="email" type="email" maxlength="255">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="company_name">会社名:</label>
                                <input class="form-control" name="company_name" id="company_name" type="text" maxlength="255">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">名前:</label>
                                <input class="form-control" name="name" id="name" type="text" maxlength="255">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="industry">業種:</label>
                                <select class="form-control" id="industry" name="industry">
                                    @foreach($industryConst as $key => $industry)
                                        <option value="{{ $key }}">{{ $industry }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="furigana_name">フリガナ:</label>
                                <input class="form-control" name="furigana_name" id="furigana_name" type="text" maxlength="255">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="address">会社住所:</label>
                                <input class="form-control" name="address" id="address" type="text" maxlength="255">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone_number">電話番号:</label>
                                <input class="form-control" name="phone_number" id="phone_number" type="text"
                                       maxlength="255">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="company_phone_number">会社電話番号:</label>
                                <input class="form-control" name="company_phone_number" id="company_phone_number" type="text"
                                       maxlength="255">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="language">利用言語:</label>
                                <select class="form-control" id="language" name="language">
                                    @foreach($languageConst as $key => $lang)
                                        <option value="{{ $key }}">{{ $lang }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="address">担当部署:</label>
                                <input class="form-control" name="department" id="department" type="text">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="gender">性別:</label>
                                <select class="form-control" id="gender" name="gender">
                                    @foreach($genderConst as $key => $gender)
                                        <option value="{{ $key }}">{{ $gender }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">ステータス:</label>
                                <select class="form-control" id="status" name="status">
                                    @foreach($statusConst as $key => $item)
                                        <option value="{{ $key }}">{{ $item }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="date_of_birth">生年月日:</label>
                                <input class="form-control" name="date_of_birth" id="date_of_birth" type="date">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="userType">法人/個人:</label>
                                <select class="form-control" id="userType" name="userType">
                                    @foreach($userTypeConst as $key => $type)
                                        <option value="{{ $key }}">{{ $type }}</option>
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
                'phone_number': {
                    required: true,
                }
            },
            messages: {
                'name': {
                    required: 'username is required!'
                },
                'email': {
                    required: 'email is required!'
                },
                'phone_number': {
                    required: 'phone_number is required!'
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
