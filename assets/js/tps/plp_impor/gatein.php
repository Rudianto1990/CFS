<div class="card">
  <div class="card-block p-a-0">
    <div class="box-tab m-b-0" id="rootwizard">
      <ul class="wizard-tabs">
        <li class="active"><a href="#tab1" data-toggle="tab">GATE IN</a></li>
        <li><a href="#tab2" data-toggle="tab">KEMASAN</a></li>
        <li style="width:100%;"> <a data-toggle="" style="text-align:right">
          <?php if($act=="add"): ?>
          <button type="button" class="btn btn-primary btn-icon" onclick="save_multiple_post('form_gatein|tblkemasan'); return false;">Save <i class="icon-check"></i></button>
          <?php endif; ?>
          </a> </li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane p-x-lg active" id="tab1">
          <form name="form_gatein" id="form_gatein" class="form-horizontal" role="form" action="<?php echo site_url('tps/execute/save/gate_in'); ?>" method="post" autocomplete="off" onsubmit="save_multiple_post('form_gatein|tblkemasan'); return false;">
            <div class="form-group">
              <label class="col-sm-2 control-label-left">DATA RESPON PLP</label>
              <div class="col-sm-6">
                <input type="text" name="PLP" id="PLP" wajib="yes" class="form-control" placeholder="NOMOR" value="<?php echo $arrhdr['NO_PLP']; ?>">
              </div>
              <div class="col-sm-3">
                <div class="input-prepend input-group"><span class="add-on input-group-addon"><i class="icon-calendar"></i></span>
                  <input class="form-control drp" type="text" placeholder="TANGGAL" name="TGL_PLP" id="TGL_PLP" data-provide="datepicker" wajib="yes" value="<?php echo $arrhdr['TGL_PLP']; ?>">
                </div>
              </div>
              <div class="col-sm-1" style="padding-top:3px">
              <?php if($act=="add"): ?>
                <button type="button" class="btn btn-primary btn-sm btn-icon" onclick="get_respon()"> <span class="icon-magnifier"></span> Search </button>
              <?php endif; ?> 
              </div>
            </div>
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
            <input type="hidden" name="DATA[KD_ASAL_BRG]" id="KD_ASAL_BRG" readonly="readonly" value="2"/>
            <input type="hidden" name="DATA[KD_TPS]" id="KD_TPS" readonly="readonly" value="<?php echo $this->newsession->userdata('KD_TPS'); ?>"/>
            <input type="hidden" name="DATA[KD_GUDANG]" id="KD_GUDANG" readonly="readonly" value="<?php echo $this->newsession->userdata('KD_GUDANG'); ?>"/>
            <input type="hidden" name="ID_HEADER" id="ID_HEADER" readonly="readonly" wajib="yes" value="<?php echo $arrhdr['ID']; ?>"/>
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
	date('drp');
});

function get_respon(){
	var plp = $('#PLP').val();
	var tgl = $('#TGL_PLP').val();
	if(plp=="" && tgl==""){
		swalert('error','Terdapat data yang belum diisi','900');
		return false;
	}
	$.ajax({
		type: 'POST',
		dataType: 'json',
		url: site_url+'/tps/execute/get/respon_plp/'+plp+'|'+tgl,
		data: 'plp='+plp+'&tgl='+tgl,
		beforeSend: function(){Loading(true)},
		success: function(data){
			Loading(false);
			if(data.ID!=""){
				$('#NM_ANGKUT').val(data.NM_ANGKUT);
				$('#NO_VOY_FLIGHT').val(data.NO_VOY_FLIGHT);
				$('#TGL_TIBA').val(data.TGL_TIBA);
				$('#NO_BC11').val(data.NO_BC11);
				$('#TGL_BC11').val(data.TGL_BC11);
				$('#ID_HEADER').val(data.ID);
				swalert('success','Data berhasil ditemukan','900');
				$('#divtblkemasan').load(site_url+'/tps/plp_impor/list/respon_kemasan/'+data.ID+'/post');
			}else{
				swalert('error','Data tidak ditemukan','900');
				cancel('form_gatein');
				$('#divtblkemasan').load(site_url+'/tps/plp_impor/list/respon_kemasan/0/post');
			}
		}
	});
}
</script> 
