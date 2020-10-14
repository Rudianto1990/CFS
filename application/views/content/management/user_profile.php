<div class="card">
  <div class="card-block p-a-0">
    <div class="box-tab m-b-0" id="rootwizard">
      <ul class="wizard-tabs">
        <li class="active"><a href="#tab1-1" data-toggle="tab">PROFILE PERUSAHAAN</a></li>
        <li><a href="#tab1-2" data-toggle="tab">USER</a></li>
        <li style="width:100%;"> <a data-toggle="" style="text-align:right">
          <button type="button" class="btn btn-primary btn-icon" onclick="save_post('form_data'); return false;">Save <i class="icon-check"></i></button>
          </a> </li>
      </ul>
      <form name="form_data" id="form_data" class="form-horizontal" role="form" action="<?php echo site_url('management/execute/update/user_profile'); ?>" method="post" autocomplete="off" onsubmit="save_post('form_data'); return false;">
      <div class="tab-content">
        <div class="tab-pane p-x-lg active" id="tab1-1">
          <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label class="col-sm-2 control-label-left">NPWP</label>
                  <div class="col-sm-10">
                    <input type="text" name="DATA[NPWP]" id="NPWP" wajib="yes" class="form-control" placeholder="NPWP" value="<?php echo $arr_org['NPWP']; ?>"<?php if($this->newsession->userdata('KD_GROUP')=="USR"){echo "readonly";}?>>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label-left">NAMA</label>
                  <div class="col-sm-10">
                    <input type="text" name="DATA[NAMA]" id="NAMA" wajib="yes" class="form-control" placeholder="NAMA" value="<?php echo $arr_org['NAMA']; ?>"<?php if($this->newsession->userdata('KD_GROUP')=="USR"){echo "readonly";}?>>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label-left">ALAMAT</label>
                  <div class="col-sm-10">
                  	<textarea name="DATA[ALAMAT]" id="ALAMAT" wajib="yes" class="form-control" placeholder="ALAMAT"<?php if($this->newsession->userdata('KD_GROUP')=="USR"){echo "readonly";}?>><?php echo $arr_org['ALAMAT']; ?></textarea>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label-left">NO. TELEPON</label>
                  <div class="col-sm-10">
                    <input type="text" name="DATA[NOTELP]" id="NOTELP" wajib="yes" class="form-control" placeholder="NO. TELEPON" value="<?php echo $arr_org['NOTELP']; ?>"<?php if($this->newsession->userdata('KD_GROUP')=="USR"){echo "readonly";}?>>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label-left">NO. FAX</label>
                  <div class="col-sm-10">
                    <input type="text" name="DATA[NOFAX]" id="NOFAX" wajib="yes" class="form-control" placeholder="NO. FAX" value="<?php echo $arr_org['NOFAX']; ?>"<?php if($this->newsession->userdata('KD_GROUP')=="USR"){echo "readonly";}?>>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label-left">EMAIL</label>
                  <div class="col-sm-10">
                    <input type="text" name="DATA[EMAIL]" id="EMAIL_PROFILE" wajib="yes" class="form-control" placeholder="EMAIL" value="<?php echo $arr_org['EMAIL']; ?>"<?php if($this->newsession->userdata('KD_GROUP')=="USR"){echo "readonly";}?>>
                  </div>
                </div>
              </div>
            
          </div>
        </div>
        <div class="tab-pane p-x-lg" id="tab1-2">
          <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label class="col-sm-2 control-label-left">NAMA LENGKAP</label>
                  <div class="col-sm-10">
                    <input type="text" name="USER[NM_LENGKAP]" id="NM_LENGKAP" wajib="yes" class="form-control" placeholder="NAMA LENGKAP" value="<?php echo $arr_usr['NM_LENGKAP']; ?>">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label-left">HANDPHONE</label>
                  <div class="col-sm-10">
                    <input type="text" name="USER[HANDPHONE]" id="HANDPHONE" wajib="yes" class="form-control" placeholder="HANDPHONE" value="<?php echo $arr_usr['HANDPHONE']; ?>">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label-left">EMAIL</label>
                  <div class="col-sm-10">
                    <input type="text" name="EMAIL" id="EMAIL" wajib="yes" class="form-control" placeholder="EMAIL" value="<?php echo $arr_usr['EMAIL']; ?>">
                  </div>
                </div>
              </div>
          </div>
        </div>
      </div>
      </form>
    </div>
  </div>
</div>
</div> 
<script>
$(document).ready(function() {
	$("#form_data").validate({
		rules: {
			EMAIL: {
				remote: {
					url: "<?php echo site_url();?>/management/umail/1",
					type: "post",
					data: {
						login: function(){
							return $('#form_data :input[name="EMAIL"]').val();
						}
					}
				}
			}
		},
		messages:{
			EMAIL:{
				remote: jQuery.validator.format("email sudah ada.")
			}
		}
    });
});
</script>