<div class="modal fade" id="change-default" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body text-center notification modal-change-default">
        <div class="btn-close-modal" data-dismiss="modal">
          <i class="fas fa-times-circle "></i>
        </div>
        <h4 id="notify-title">デフォルト設定 </h4>
        <p class="notify-body">
          @foreach ($cards as $card)
          <div class="row card-item">
            <div class="col-md-1 col-1">
              <input type="radio" name="default" {{$card['default'] == 1 ? 'checked': ''}} value="{{ $card['card_id'] }}" data-number="{{ $card['card_number'] }}">
            </div>
            <div class="col-md-4 col-3">
              <img src="{{ asset('user/images/'.$card['type'].'.png') }}" />
            </div>
            <div class="col-md-6 col-7">
              <span>{{ $card['card_number'] }}</span>
            </div>
          </div>
          @endforeach
        </p>
        <div class="text-center">
          <button type="button" class="btn-secondary-info group mr-3" data-dismiss="modal"><i class="far fa-arrow-alt-circle-left"></i> <span id='text-prev'>戻る</span></button>
          <button type="button" id="set-default" class="btn-primary-info group"><span id='text'>確認</span><i class="far fa-arrow-alt-circle-right"></i></button>
        </div>
      </div>
    </div>
  </div>
</div>
