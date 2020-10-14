<div class="card">
  <div class="card-block p-a-0">
    <div class="box-tab m-b-0" id="rootwizard">
      <ul class="wizard-tabs">
        <li class="active"><a href="#gatein" data-toggle="tab">DATA KONTAINER</a></li>
        <li style="width:100%;"> <a data-toggle="" style="text-align:right"> 
          <button type="button" class="btn btn-primary btn-icon" onclick="save_popup('frm_kemasan','divtblkemasan'); return false;">DISCHARGE <i class="icon-check"></i></button>
          </a> </li>
      </ul>
      <div class="tab-content">
        <div class="row">
          <div class="tab-pane p-x-lg active" id="gatein">
            <form name="frm_kemasan" id="frm_kemasan" class="form-horizontal" role="form" action="<?php echo site_url('tps/execute/'.$exec.'/bongkaran_kapal-discharge_kemasan/'.$ID); ?>" method="post" autocomplete="off" onsubmit="save_popup('frm_kemasan','divtblkemasan'); return false;">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="col-sm-3 control-label-left">NO. KONTAINER</label>
                  <div class="col-sm-8">
                    <input type="text" name="DATA[NO_CONT]" id="NO_CONT" wajib="yes" class="form-control" placeholder="KONTAINER" value="<?php echo $arrcont['NO_CONT']; ?>">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label-left">UKURAN</label>
                  <div class="col-sm-8">
                    <?php echo form_dropdown('DATA[KD_CONT_UKURAN]',$arr_cont_ukuran,$arrcont['KD_CONT_UKURAN'],'id="KD_CONT_UKURAN" wajib="yes" class="form-control"'); ?> 
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label-left">JENIS</label>
                  <div class="col-sm-8">
                    <?php echo form_dropdown('DATA[KD_CONT_JENIS]',$arr_cont_jenis,$arrcont['KD_CONT_JENIS'],'id="KD_CONT_JENIS" wajib="yes" class="form-control"'); ?> 
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label-left">TIPE</label>
                  <div class="col-sm-8">
                    <?php echo form_dropdown('DATA[KD_CONT_TIPE]',$arr_cont_tipe,$arrcont['KD_CONT_TIPE'],'id="KD_CONT_TIPE" wajib="yes" class="form-control"'); ?> 
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label-left">ISO CODE</label>
                  <div class="col-sm-8">
                    <?php echo form_dropdown('DATA[KD_ISO_CODE]',$arr_iso,$arrcont['KD_ISO_CODE'],'id="KD_ISO_CODE" wajib="yes" class="form-control"'); ?> 
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label-left">BRUTO</label>
                  <div class="col-sm-8">
                    <input type="text" name="DATA[BRUTO]" id="BRUTO" wajib="yes" class="form-control" placeholder="BRUTO" value="<?php echo $arrcont['BRUTO']; ?>">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label-left">SEGEL</label>
                  <div class="col-sm-5">
                    <input type="text" name="DATA[NO_MASTER_BL_AWB]" id="NO_MASTER_BL_AWB" wajib="yes" class="form-control" placeholder="NOMOR" value="<?php echo $arrcont['NO_MASTER_BL_AWB']; ?>">
                  </div>
                  <div class="col-sm-3">
                    <?php echo form_dropdown('DATA[KONDISI_SEGEL]',array('BAIK'=>'BAIK','RUSAK'=>'RUSAK'),$arrcont['KONDISI_SEGEL'],'id="KONDISI_SEGEL" wajib="yes" class="form-control"'); ?>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label-left">BL AWB</label>
                  <div class="col-sm-4">
                    <input type="text" name="DATA[NO_BL_AWB]" id="NO_BL_AWB" wajib="yes" class="form-control" placeholder="NOMOR" value="<?php echo $arrcont['NO_BL_AWB']; ?>">
                  </div>
                  <div class="col-sm-4">
                    <div class="input-prepend input-group"><span class="add-on input-group-addon"><i class="icon-calendar"></i></span>
                      <input class="form-control drp" type="text" placeholder="TANGGAL" name="DATA[TGL_BL_AWB]" id="TGL_BL_AWB" data-provide="datepicker" wajib="yes" value="<?php echo $arrhdr['TGL_BL_AWB']; ?>">
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label-left">MST. BL AWB</label>
                  <div class="col-sm-4">
                    <input type="text" name="DATA[NO_MASTER_BL_AWB]" id="NO_MASTER_BL_AWB" wajib="yes" class="form-control" placeholder="NOMOR" value="<?php echo $arrcont['NO_MASTER_BL_AWB']; ?>">
                  </div>
                  <div class="col-sm-4">
                    <div class="input-prepend input-group"><span class="add-on input-group-addon"><i class="icon-calendar"></i></span>
                      <input class="form-control drp" type="text" placeholder="TANGGAL" name="DATA[TGL_MASTER_BL_AWB]" id="TGL_MASTER_BL_AWB" data-provide="datepicker" wajib="yes" value="<?php echo $arrhdr['TGL_MASTER_BL_AWB']; ?>">
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label class="col-sm-3 control-label-left">CONSIGNEE</label>
                  <div class="col-sm-8">
                    <input type="hidden" name="DATA[KD_ORG_CONSIGNEE]" id="KD_ORG_CONSIGNEE" class="form-control" readonly="readonly" value="<?php echo $arrcont['KD_ORG_CONSIGNEE']; ?>">
                    <input type="text" name="CONSIGNEE" id="CONSIGNEE" wajib="yes" class="form-control" value="<?php echo $arrcont['CONSIGNEE']; ?>">
                  </div>
                  <div class="col-sm-1" style="padding-top:3px">
                    <button type="button" class="btn btn-primary btn-sm" onclick="popup_searchtwo('popup/popup_search/organisasi|CONS','','60','600')"> <span class="icon-magnifier"></span></button>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label-left">LOKASI TIMBUN</label>
                  <div class="col-sm-9">
                    <input type="text" name="DATA[KD_TIMBUN_KAPAL]" id="KD_TIMBUN_KAPAL" wajib="yes" class="form-control" value="<?php echo $arrcont['KD_TIMBUN_KAPAL']; ?>" placeholder="LOKASI TIMBUN KAPAL">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label-left">LOKASI TIMBUN</label>
                  <div class="col-sm-9">
                    <input type="text" name="DATA[KD_TIMBUN]" id="KD_TIMBUN" wajib="yes" class="form-control" placeholder="LOKASI TIMBUN LAPANGAN" value="<?php echo $arrcont['KD_TIMBUN']; ?>">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label-left">PEL. MUAT</label>
                  <div class="col-sm-3">
                    <input type="text" name="DATA[KD_PEL_MUAT]" id="KD_PEL_MUAT_KMS" wajib="yes" class="form-control" readonly="readonly" placeholder="KODE" value="<?php echo $arrcont['KD_PEL_MUAT']; ?>">
                  </div>
                  <div class="col-sm-5">
                    <input type="text" name="PEL_MUAT" id="PEL_MUAT" wajib="yes" class="form-control" placeholder="PELABUHAN" value="<?php echo $arrcont['PEL_MUAT']; ?>">
                  </div>
                  <div class="col-sm-1" style="padding-top:3px">
                    <button type="button" class="btn btn-primary btn-sm" onclick="popup_searchtwo('popup/popup_search/port','','60','600')"> <span class="icon-magnifier"></span></button>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label-left">PEL. TRANSIT</label>
                  <div class="col-sm-3">
                    <input type="text" name="DATA[KD_PEL_TRANSIT]" id="KD_PEL_TRANSIT_KMS" class="form-control" readonly="readonly" placeholder="KODE" value="<?php echo $arrcont['KD_PEL_TRANSIT']; ?>">
                  </div>
                  <div class="col-sm-5">
                    <input type="text" name="PEL_TRANSIT" id="PEL_TRANSIT" class="form-control" placeholder="PELABUHAN" value="<?php echo $arrcont['PEL_TRANSIT']; ?>">
                  </div>
                  <div class="col-sm-1" style="padding-top:3px">
                    <button type="button" class="btn btn-primary btn-sm" onclick="popup_searchtwo('popup/popup_search/port','','60','600')"> <span class="icon-magnifier"></span></button>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label-left">PEL. BONGKAR</label>
                  <div class="col-sm-3">
                    <input type="text" name="DATA[KD_PEL_BONGKAR]" id="KD_PEL_BONGKAR_KMS" wajib="yes" class="form-control" readonly="readonly" placeholder="KODE" value="<?php echo $arrcont['KD_PEL_BONGKAR']; ?>">
                  </div>
                  <div class="col-sm-5">
                    <input type="text" name="PEL_BONGKAR" id="PEL_BONGKAR" wajib="yes" class="form-control" placeholder="PELABUHAN" value="<?php echo $arrcont['PEL_BONGKAR']; ?>">
                  </div>
                  <div class="col-sm-1" style="padding-top:3px">
                    <button type="button" class="btn btn-primary btn-sm" onclick="popup_searchtwo('popup/popup_search/port','','60','600')"> <span class="icon-magnifier"></span></button>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label-left">STATUS</label>
                  <div class="col-sm-9">
                    <?php echo form_dropdown('DATA[KD_CONT_STATUS_IN]',$arr_angkutan,$arrcont['KD_CONT_STATUS_IN'],'id="KD_CONT_STATUS_IN" wajib="yes" class="form-control"'); ?> 
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label-left">ANGKUTAN</label>
                  <div class="col-sm-9">
                    <?php echo form_dropdown('DATA[KD_SARANA_ANGKUT_IN]',$arr_angkutan,$arrcont['KD_SARANA_ANGKUT_IN'],'id="KD_SARANA_ANGKUT_IN" wajib="yes" class="form-control"'); ?> 
                  </div>
                </div>
                <?php if(set_setting('SETWKINOUT') == 'Y'): ?>
                <div class="form-group">
                  <label class="col-sm-3 control-label-left">GATE IN</label>
                  <div class="col-sm-9">
                    <div class="input-prepend input-group"><span class="add-on input-group-addon"><i class="icon-calendar"></i></span>
                      <input class="form-control drp" type="text" placeholder="TANGGAL" name="DATA[WK_IN]" id="WK_IN" data-provide="datepicker" wajib="yes" value="<?php echo $arrcont['WK_IN']; ?>">
                    </div>
                  </div>
                </div>
                <?php endif; ?>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
$(function(){
	autocomplete('KEMASAN','/tps/autocomplete/mst_kemasan',function(event, ui){
		$('#KD_KEMASAN').val(ui.item.KODE);
	});
	autocomplete('NAMA_DOK_IN','/tps/autocomplete/mst_dok_bc/IMP',function(event, ui){
		$('#KD_DOK_IN').val(ui.item.KODE);
	});
	autocomplete('PEL_MUAT','/tps/autocomplete/mst_port',function(event, ui){
		$('#KD_PEL_MUAT_KMS').val(ui.item.KODE);
	});
	autocomplete('PEL_TRANSIT','/tps/autocomplete/mst_port',function(event, ui){
		$('#KD_PEL_TRANSIT_KMS').val(ui.item.KODE);
	});
	autocomplete('PEL_BONGKAR','/tps/autocomplete/mst_port',function(event, ui){
		$('#KD_PEL_BONGKAR_KMS').val(ui.item.KODE);
	});
	autocomplete('CONSIGNEE','/tps/autocomplete/mst_organisasi/CONS',function(event, ui){
		$('#KD_ORG_CONSIGNEE').val(ui.item.KODE);
	});
});
</script>
