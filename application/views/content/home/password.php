<div class="card">
  <div class="card-block p-a-0">
    <div class="box-tab m-b-0" id="rootwizard">
      <ul class="wizard-tabs">
        <li><a href="#tab1-1" data-toggle="tab">RESET PASSWORD</a></li>
        <li style="width:100%;"> <a data-toggle="" style="text-align:right">
          <button type="button" class="btn btn-primary btn-icon" onclick="save_post('form_data'); return false;">Reset <i class="icon-check"></i></button>
          </a> </li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane p-x-lg active" id="tab1-1">
          <div class="row">
            <form name="form_data" id="form_data" class="form-horizontal" role="form" action="<?php echo site_url('home/execute/update/reset_password'); ?>" method="post" autocomplete="off" onsubmit="save_post('form_kemasan'); return false;">
              <div class="col-md-12">
                <div class="form-group">
                  <label class="col-sm-2 control-label-left">PASSWORD LAMA</label>
                  <div class="col-sm-10">
                    <input type="password" name="DATA[PASS_OLD]" id="PASS_OLD" wajib="yes" class="form-control" placeholder="PASSWORD LAMA">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label-left">PASSWORD BARU</label>
                  <div class="col-sm-10">
                    <input type="password" name="DATA[PASS_NEW]" id="PASS_NEW" wajib="yes" class="form-control" placeholder="PASSWORD BARU">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label-left">KONFIRMASI PASSWORD</label>
                  <div class="col-sm-10">
                    <input type="password" name="DATA[PASS_CONFIRM]" id="PASS_CONFIRM" wajib="yes" class="form-control" placeholder="KONFIRMASI PASSWORD">
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div> 
