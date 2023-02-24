<div class="modal fade" id="formAudioResultModal" tabindex="-1" role="dialog"
     aria-labelledby="formAudioResultModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formAudioResultModalTitle"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body audio-result-body">
                <form method="post" id="form-audio">
                    @csrf
                    @method('PUT')
                  <div class="row">
                      <div class="col-md-6">
                          <div class="form-group">
                                <label>ファイル名:</label>
                                <input type="text" name="name" class="form-control" value="">
                          </div>
                      </div>
                      <div class="col-md-6">
                          <div class="form-group">
                              <label>担当スタッフ:</label>
                              <select class="form-control staff-select" id="staff_id"
                                      name="staff_id">
                                  <option value="">--- Choose Staff ---</option>
                                  @foreach($staffsConst as $key => $item)
                                      <option value="{{ $item->id }}">{{ $item->name }}</option>
                                  @endforeach
                              </select>
                          </div>
                      </div>
                      <div class="col-md-12">
                          <div class="form-group">
                              <button class="btn btn-common-outline" id="export-csv">Export</button>
                              <input type="file" hidden id="input-csv" accept=".csv">
                              <button class="btn btn-common-outline" id="upload-csv">Upload</button>
                              <label id="label-input-csv" style="margin-left: 15px;"></label>
                          </div>
                      </div>
                      <div class="col-md-12">
                          <div class="form-group">
                              <label>音声:</label>
                              <div>
                                  <audio controls>
                                      <source src="" type="audio/ogg">
                                      <source src="" type="audio/mpeg">
                                      Your browser does not support the audio element.
                                  </audio>
                              </div>
                          </div>
                      </div>
                      <div class="col-md-12">
                          <div class="form-group">
                              <label>Googleの認識結果:</label>
                              <div class="api_result"></div>
                          </div>
                      </div>
                      <div class="col-md-12 mt-4">
                          <div class="form-group">
                              <label>ブラッシュアップ結果:</label>
                              <div class="edited_result"></div>
                          </div>
                      </div>
                  </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-common-outline submit" data-dismiss="modal">閉じる</button>
                <button type="button" class="btn btn-common submit" id="audio-submit">保存</button>
            </div>
        </div>
    </div>
</div>
<script>
    // $('#audio-submit').click(function () {
    //     $('#form-audio').submit()
    // });
</script>

