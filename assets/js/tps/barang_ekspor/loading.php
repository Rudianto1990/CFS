<div class="card">
  <div class="card-block p-a-0">
    <div class="box-tab m-b-0" id="rootwizard">
      <ul class="wizard-tabs">
        <li class="active"><a href="#tab1" data-toggle="tab">LOADING</a></li>
        <li><a href="#tab2" data-toggle="tab">KEMASAN</a></li>
        <li style="width:100%;"> <a data-toggle="" style="text-align:right"></a></li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane p-x-lg active" id="tab1">
          <form name="frm_data" id="frm_data" class="form-horizontal" role="form" action="<?php echo site_url('tps/execute/save/gate_in'); ?>" method="post" autocomplete="off" onsubmit="save_multiple_post('form_gateout|tblkemasan'); return false;">
            <div class="form-group">
              <label class="col-sm-2 control-label-left">DATA KAPAL</label>
              <div class="col-sm-2">
                <input type="text" class="form-control" name="DATA[KD_KAPAL]" id="KD_KAPAL" wajib="yes" placeholder="KODE" readonly="readonly" value="<?php echo $arrhdr['KD_KAPAL']; ?>">
              </div>
              <div class="col-sm-3">
                <input type="text" name="NAMA_KAPAL" id="NAMA_KAPAL" wajib="yes" class="form-control" placeholder="NAMA KAPAL" value="<?php echo strtoupper($arrhdr['NAMA_KAPAL']); ?>">
              </div>
              <div class="col-sm-4">
                <input type="text" name="DATA[NM_ANGKUT]" id="NM_ANGKUT" wajib="yes" class="form-control" placeholder="NAMA ANGKUT" value="<?php echo $arrhdr['NM_ANGKUT']; ?>">
              </div>
              <div class="col-sm-1" style="padding-top:3px">
                <button type="button" class="btn btn-primary btn-sm" onclick="popup_search('popup/popup_search/kapal','','60','600')"> <span class="icon-magnifier"></span></button>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label-left">PELABUHAN MUAT</label>
              <div class="col-sm-2">
                <input type="text" name="DATA[KD_PEL_MUAT]" id="KD_PEL_MUAT" wajib="yes" class="form-control" placeholder="KODE" readonly="readonly" value="<?php echo $arrhdr['KD_PEL_MUAT']; ?>">
              </div>
              <div class="col-sm-7">
                <input type="text" name="PELABUHAN_MUAT" id="PELABUHAN_MUAT" wajib="yes" class="form-control" placeholder="PELABUHAN MUAT" value="<?php echo $arrhdr['PEL_MUAT']; ?>">
              </div>
              <div class="col-sm-1" style="padding-top:3px">
                <button type="button" class="btn btn-primary btn-sm" onclick="popup_search('popup/popup_search/port','','60','600')"> <span class="icon-magnifier"></span></button>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label-left">PELABUHAN TRANSIT</label>
              <div class="col-sm-2">
                <input type="text" name="DATA[KD_PEL_TRANSIT]" id="KD_PEL_TRANSIT" class="form-control" placeholder="KODE" readonly="readonly" value="<?php echo $arrhdr['KD_PEL_TRANSIT']; ?>">
              </div>
              <div class="col-sm-7">
                <input type="text" name="PELABUHAN_TRANSIT" id="PELABUHAN_TRANSIT" class="form-control" placeholder="PELABUHAN TRANSIT" value="<?php echo $arrhdr['PEL_TRANSIT']; ?>">
              </div>
              <div class="col-sm-1" style="padding-top:3px">
                <button type="button" class="btn btn-primary btn-sm" onclick="popup_search('popup/popup_search/port','','60','600')"> <span class="icon-magnifier"></span></button>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label-left">PELABUHAN BONGKAR</label>
              <div class="col-sm-2">
                <input type="text" name="DATA[KD_PEL_BONGKAR]" id="KD_PEL_BONGKAR" class="form-control" wajib="yes" placeholder="KODE" readonly="readonly" value="<?php echo $arrhdr['KD_PEL_BONGKAR']; ?>">
              </div>
              <div class="col-sm-7">
                <input type="text" name="PELABUHAN_BONGKAR" id="PELABUHAN_BONGKAR" class="form-control" wajib="yes" placeholder="PELABUHAN BONGKAR" value="<?php echo $arrhdr['PEL_BONGKAR']; ?>">
              </div>
              <div class="col-sm-1" style="padding-top:3px">
                <button type="button" class="btn btn-primary btn-sm" onclick="popup_search('popup/popup_search/port','','60','600')"> <span class="icon-magnifier"></span></button>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label-left">NO. VOYAGE FLIGHT</label>
              <div class="col-sm-9">
                <input type="text" name="DATA[NO_VOY_FLIGHT]" id="NO_VOY_FLIGHT" wajib="yes" class="form-control" placeholder="NOMOR VOYAGE FLIGHT" value="<?php echo $arrhdr['NO_VOY_FLIGHT']; ?>">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label-left">TGL. TIBA / BERANGKAT</label>
              <div class="col-sm-3">
                <div class="input-prepend input-group"><span class="add-on input-group-addon"><i class="icon-calendar"></i></span>
                  <input class="form-control drp" type="text" placeholder="TANGGAL TIBA / BERANGKAT" name="DATA[TGL_TIBA]" id="TGL_TIBA" data-provide="datepicker" wajib="yes" value="<?php echo $arrhdr['TGL_TIBA']; ?>">
                </div>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label-left">DATA BC11</label>
              <div class="col-sm-6">
                <input type="text" name="DATA[NO_BC11]" id="NO_BC11" wajib="yes" class="form-control" placeholder="NOMOR" value="<?php echo $arrhdr['NO_BC11']; ?>">
              </div>
              <div class="col-sm-3">
                <div class="input-prepend input-group"><span class="add-on input-group-addon"><i class="icon-calendar"></i></span>
                  <input class="form-control drp" type="text" placeholder="TANGGAL" name="DATA[TGL_BC11]" id="TGL_BC11" data-provide="datepicker" wajib="yes" value="<?php echo $arrhdr['TGL_BC11']; ?>">
                </div>
              </div>
            </div>
          </form>
        </div>
        <div class="tab-pane p-x-lg" id="tab2">
        	<?php echo $table_kemasan; ?>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
$(function(){
	autocomplete('PLP','/tps/autocomplete/res_plp',function(event, ui){
		$('#TGL_PLP').val(ui.item.TGL_PLP);
	});
	autocomplete('NAMA_KAPAL','/tps/autocomplete/mst_kapal',function(event, ui){
		$('#KD_KAPAL').val(ui.item.KD_KAPAL);
	});
	autocomplete('PELABUHAN_MUAT','/tps/autocomplete/mst_port',function(event, ui){
		$('#KD_PEL_MUAT').val(ui.item.KODE);
	});
	autocomplete('PELABUHAN_TRANSIT','/tps/autocomplete/mst_port',function(event, ui){
		$('#KD_PEL_TRANSIT').val(ui.item.KODE);
	});
	autocomplete('PELABUHAN_BONGKAR','/tps/autocomplete/mst_port',function(event, ui){
		$('#KD_PEL_BONGKAR').val(ui.item.KODE);
	});
});
</script> 
