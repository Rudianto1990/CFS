<div class="card">
  <div class="card-block p-a-0">
    <div class="box-tab m-b-0" id="rootwizard">
      <ul class="wizard-tabs">
        <li class="active"><a href="#tab1" data-toggle="tab">ORGANISASI</a></li>
        <li style="width:100%;"> <a data-toggle="" style="text-align:right">
          <button type="button" class="btn btn-primary btn-icon" onclick="save_popup('form_data','divtblpbm'); return false;">Save <i class="icon-check"></i></button>
          </a> </li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane p-x-lg active" id="tab1">
          <form name="form_data" id="form_data" class="form-horizontal" role="form" action="<?php echo site_url('order/execute/'.$act.'/pbm/'.$ID); ?>" method="post" autocomplete="off" onsubmit="save_popup('form_data','divtblpbm'); return false;">
            <div class="form-group">
              <label class="col-sm-2 control-label-left">CUSTOMER NUMBER</label>
              <div class="col-sm-10">
                <input type="text" name="DATA[ID_ORGANISASI]" id="ID_ORGANISASI" wajib="yes" class="form-control" placeholder="CUSTOMER NUMBER" value="<?php echo $arrhdr['ID_ORGANISASI']; ?>">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label-left">NPWP</label>
              <div class="col-sm-10">
                <input type="hidden" name="DATA[KD_TIPE_ORGANISASI]" id="KD_TIPE_ORGANISASI" wajib="yes" class="form-control" value="FWD">
                <input type="text" name="DATA[NPWP]" id="NPWP" wajib="yes" class="form-control" placeholder="NPWP" value="<?php echo $arrhdr['NPWP']; ?>">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label-left">NAMA</label>
              <div class="col-sm-10">
                <input type="text" name="DATA[NAMA]" id="NAMA" wajib="yes" class="form-control" placeholder="NAMA" value="<?php echo $arrhdr['NAMA']; ?>">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label-left">ALAMAT</label>
              <div class="col-sm-10">
                <input type="text" name="DATA[ALAMAT]" id="ALAMAT" wajib="yes" class="form-control" placeholder="ALAMAT" value="<?php echo $arrhdr['ALAMAT']; ?>">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label-left">NO TELEPON</label>
              <div class="col-sm-10">
                <input type="text" name="DATA[NOTELP]" id="NOTELP" wajib="no" class="form-control" placeholder="NOTELP" value="<?php echo $arrhdr['NOTELP']; ?>">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label-left">NO FAX</label>
              <div class="col-sm-10">
                <input type="text" name="DATA[NOFAX]" id="NOFAX" wajib="no" class="form-control" placeholder="NOFAX" value="<?php echo $arrhdr['NOFAX']; ?>">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label-left">EMAIL</label>
              <div class="col-sm-10">
                <input type="text" name="DATA[EMAIL]" id="EMAIL" wajib="no" class="form-control email" placeholder="EMAIL" value="<?php echo $arrhdr['EMAIL']; ?>">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label-left">JENIS PERUSAHAAN</label>
              <div class="col-sm-10">
				<?php echo form_dropdown('DATA[JENIS_ORGANISASI]',array(''=>'','BUMN'=>'BUMN', 'NON-BUMN'=>'NON-BUMN'),$arrhdr['JENIS_ORGANISASI'],'id="JENIS_ORGANISASI" wajib="yes" class="form-control"'); ?>
				</div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
  jQuery(function($){
      $("#NPWP").mask("99.999.999.9-999.999");
  });
  $("#form_data").validate();
</script>
