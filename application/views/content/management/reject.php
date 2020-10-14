<div class="card">
  <div class="card-block p-a-0">
    <div class="box-tab m-b-0" id="rootwizard">
      <ul class="wizard-tabs">
        <li class="active"><a href="#tab1" data-toggle="tab">FORM REJECT</a></li>
        <li style="width:100%;"> <a data-toggle="" style="text-align:right">
          <button type="button" class="btn btn-primary btn-icon" onclick="save_post('form_data'); return false;">Save <i class="icon-check"></i></button>
          </a> </li>       
      </ul>
      <div class="tab-content">
        <div class="tab-pane p-x-lg active" id="tab1">
          <form name="form_data" id="form_data" class="form-horizontal" role="form" action="<?php echo site_url('management/execute/reject/user'); ?>" method="post" autocomplete="off" onsubmit="save_post('form_data'); return false;">
              <div class="form-group">
                <label class="col-sm-3 control-label-left">Nama Perusahaan</label>
                <div class="col-sm-9"> <?php echo $arrhdr['NAMAPERS']; ?> </div>    
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label-left">Alamat Perusahaan</label>
                <label class="col-sm-9"> <?php echo $arrhdr['ALAMATPERS']; ?></label>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label-left">NPWP</label>
                <div class="col-sm-9"><?php echo $arrhdr['NPWP']; ?> </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label-left">Pemohon</label>
                <div class="col-sm-9"><?php echo $arrhdr['NM_LENGKAP']; ?> </div>
              </div>
              <div class="form-group">
                &nbsp;
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label-left">Alasan</label>
                <div class="col-sm-9"><textarea name="alasan" rows="3" cols="50" autofocus></textarea></div>
              </div>
              <input type="hidden" name="ID" value="<?php echo $ID;?>" readony/>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
