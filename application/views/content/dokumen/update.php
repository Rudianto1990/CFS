<div class="card">
  <div class="card-block p-a-0">
    <div class="box-tab m-b-0" id="rootwizard">
      <ul class="wizard-tabs">
        <li class="active"><a href="#tab1-1" data-toggle="tab">HEADER</a></li>
        <li style="width:100%;"> <a data-toggle="" style="text-align:right">
          <button type="button" class="btn btn-primary btn-icon" onclick="save_post('form_data'); return false;">Save <i class="icon-check"></i></button>
          </a> </li>
      </ul>
      <form name="form_data" id="form_data" class="form-horizontal" role="form" action="<?php echo site_url('dokumen/execute/'.$act.'/blgudang'); ?>" method="post" autocomplete="off" onsubmit="save_post('form_data'); return false;">
      <div class="tab-content">
        <div class="tab-pane p-x-lg active" id="tab1-1">
          <div class="row">
              <div class="col-md-12">
				<input type="hidden" name="ID_DATA" value="<?php echo $ID_DATA; ?>" readonly="readonly"/>
                <div class="form-group">
                  <label class="col-sm-3 control-label-left">CAR</label>
                  <div class="col-sm-9">
                    <input type="text" name="CAR" class="form-control" value="<?php echo $arrhdr['CAR']; ?>" readonly>
                  </div>
                </div>
                 <div class="form-group">
                  <label class="col-sm-3 control-label-left">JENIS DOKUMEN</label>
                  <div class="col-sm-9">
                    <input type="text" name="KD_DOK_INOUT" class="form-control" value="<?php echo $arrhdr['KD_DOK']; ?>" readonly>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label-left">NO. DOKUMEN</label>
                  <div class="col-sm-5">
                    <input type="text" name="NO_DOK_INOUT" id="NO_DOK_INOUT" wajib="yes" class="form-control" placeholder="NO. DOKUMEN" value="<?php echo $arrhdr['NO_DOK_INOUT']; ?>" readonly>
                  </div>
                  <div class="col-sm-4"> 
                    <div class="input-prepend input-group"><span class="add-on input-group-addon"><i class="icon-calendar"></i></span>
                      <input class="form-control drp" type="text" value="<?=date_input($arrhdr['TGL_DOK_INOUT']);?>" placeholder="TANGGAL DOKUMEN" name="TGL_DOK_INOUT" id="TGL_DOK_INOUT" data-provide="datepicker" wajib="yes" readonly>
                    </div> 
				  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label-left">NAMA ANGKUT</label>
                  <div class="col-sm-9">
                    <input type="text" name="NM_ANGKUT" id="NM_ANGKUT" class="form-control" placeholder="NAMA ANGKUT" value="<?php echo $arrhdr['NM_ANGKUT']; ?>" readonly>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label-left">NO. VOYAGE</label>
                  <div class="col-sm-9">
                    <input type="text" name="NO_VOY_FLIGHT" id="NO_VOY_FLIGHT" class="form-control" placeholder="NO. VOYAGE" value="<?php echo $arrhdr['NO_VOY_FLIGHT']; ?>">
                  </div>
                </div>
				<div class="form-group">
				  <label class="col-sm-3 control-label-left">GUDANG</label>
				  <div class="col-sm-2">
					<input type="text" class="form-control" name="KD_GUDANG" id="KD_GUDANG" wajib="yes" onkeyup="cek();" placeholder="KODE" value="<?php echo $arrhdr['KD_GUDANG']; ?>" maxlength="6" readonly>
				  </div>
				  <div class="col-sm-7">
					<input type="text" class="form-control" id="NM_GUDANG" placeholder="NAMA GUDANG" value="<?php echo $arrhdr['NM_GUDANG']; ?>">
				  </div>
				</div>
                <div class="form-group">
                  <label class="col-sm-3 control-label-left"><b>BL</b></label>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 col-sm-offset-1 control-label-left">NO. MASTER BL</label>
                  <div class="col-sm-5">
                    <input type="text" name="NO_MASTER_BL_AWB" id="NO_MASTER_BL_AWB" class="form-control" placeholder="NO. MASTER BL" value="<?php echo $arrhdr['NO_MASTER_BL_AWB']; ?>" readonly>
                  </div>
                  <div class="col-sm-4"> 
                    <div class="input-prepend input-group"><span class="add-on input-group-addon"><i class="icon-calendar"></i></span>
                      <input class="form-control drp" type="text" value="<?=date_input($arrhdr['TGL_MASTER_BL_AWB']);?>" placeholder="TANGGAL MASTER BL" name="TGL_MASTER_BL_AWB" id="TGL_MASTER_BL_AWB" data-provide="datepicker" readonly>
                    </div> 
				  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 col-sm-offset-1 control-label-left">NO. BL</label>
                  <div class="col-sm-5">
                    <input type="text" name="NO_BL_AWB" id="NO_BL_AWB" class="form-control" wajib="yes" placeholder="NO. BL" value="<?php echo $arrhdr['NO_BL_AWB']; ?>">
                  </div>
                  <div class="col-sm-4"> 
                    <div class="input-prepend input-group"><span class="add-on input-group-addon"><i class="icon-calendar"></i></span>
                      <input class="form-control drp" type="text" value="<?=date_input($arrhdr['TGL_BL_AWB']);?>" wajib="yes" placeholder="TANGGAL BL" name="TGL_BL_AWB" id="TGL_BL_AWB" data-provide="datepicker">
                    </div> 
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
<script>
$(function () {
  date('drp');
  autocomplete('NM_GUDANG','/autocomplete/status/reff_gudang/nama/2',function(event, ui){    
    $('#NM_GUDANG').val(ui.item.NAMA);
    $('#KD_GUDANG').val(ui.item.GUDANG);
  });
});
</script>