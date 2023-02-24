<div class="modal fade" id="add_new_card" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index: 9999">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content" style="background: #F5F7F8">
      <div class="modal-body text-center notification" style="padding: 25px 20px">
        <div class="btn-close-modal" data-dismiss="modal">
          <i class="fas fa-times-circle "></i>
        </div>
        <div>
          <span class="block-title" style="color: black">決済カード情報入力</span>
          <hr>
          <div class="list-credit">
            <div class="item">
              <img src="{{ asset('user/images/visa.png') }}" />
            </div>
            <div class="item">
              <img src="{{ asset('user/images/master.png') }}" />
            </div>
            <div class="item">
              <img src="{{ asset('user/images/jbc.png') }}" />
            </div>
            <div class="item">
              <img src="{{ asset('user/images/diner.png') }}" />
            </div>
            <div class="item">
              <img src="{{ asset('user/images/amexpress.png') }}" />
            </div>
          </div>
          <div class="form-row add-new-card">
            <div class="form-group col-md-12 text-left">
              <label for="inputCity">カード名義</label>
              <input type="text" class="form-control" id="username" name="username" placeholder="TARO YAMADA">
            </div>
            <div class="form-group col-md-12 text-left">
              <label for="inputCity">クレジットカード番号</label>
              <input type="text" class="form-control" id="card_number" placeholder="0000 0000 0000 0000">
            </div>
            <div class="form-group col-md-6 text-left">
              <label for="inputState">有効期間</label>
              <input type="text" class="form-control" id="cc-exp" name="expdate" placeholder="MM/YY">
            </div>
            <div class="form-group col-md-6 text-left">
              <label for="inputZip">セキュリティコード</label>
              <input maxlength="4" type="password" class="form-control" id="cc-csc" placeholder="0000">
            </div>
          </div>
        </div>
        </p>
        <div class="text-center">
          <button type="button" class="btn-secondary-info group mr-3" data-dismiss="modal"><i class="far fa-arrow-alt-circle-left"></i> <span id='text-prev'>戻る</span></button>
          <button type="button" id='add-new-card' class="btn-primary-info group">確認<i class="far fa-arrow-alt-circle-right"></i></button>
        </div>
      </div>
    </div>
  </div>
</div>
