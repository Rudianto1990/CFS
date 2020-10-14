<div class="panel">
  <div class="ribbon ribbon-clip ribbon-primary">
  	<span class="ribbon-inner">
		<i class="icon md-view-list margin-0" aria-hidden="true"></i> <?php echo $title; ?>
    </span>
  </div>
  <button type="submit" class="btn btn-sm btn-primary navbar-right navbar-btn waves-effect waves-light" onclick="save_post('form_cont','divtblkontainer'); return false;">
  	<i class="icon md-badge-check"></i> SAVE
  </button>
  <div class="panel-body container-fluid">
    <div class="row">
      <div class="col-sm-12">
        <form name="form_cont" id="form_cont" class="form-horizontal" role="form" action="<?php echo site_url('execute/process/'.$action.'/kontainer_in/'.$id); ?>" method="post" autocomplete="off" onsubmit="save_post('form_cont','divtblkontainer'); return false;" popup="1">
          <div class="panel-body container-fluid">
            <div class="row">
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">KONTAINER</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="DATA[NO_CONT]" id="NO_CONT" mandatory="yes" placeholder="NOMOR KONTAINER" value="<?php echo $arrdata['NO_CONT']; ?>" maxlength="11">
                  <div class="hint">NOMOR KONTAINER</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">UKURAN</label>
                <div class="col-sm-9">
                  <?php echo form_dropdown('DATA[KD_CONT_UKURAN]',$arr_ukuran,$arrdata['KD_CONT_UKURAN'],'id="KD_CONT_UKURAN" mandatory="yes" class="form-control"'); ?>
                  <div class="hint">UKURAN KONTAINER</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">JENIS</label>
                <div class="col-sm-9">
                  <?php echo form_dropdown('DATA[KD_CONT_JENIS]',$arr_jenis,$arrdata['KD_CONT_JENIS'],'id="KD_CONT_JENIS" mandatory="yes" class="form-control"'); ?>
                  <div class="hint">JENIS KONTAINER</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">STATUS</label>
                <div class="col-sm-9">
                  <?php echo form_dropdown('DATA[KD_CONT_STATUS_IN]',$arr_status,$arrdata['KD_CONT_STATUS_IN'],'id="KD_CONT_STATUS_IN" mandatory="yes" class="form-control"'); ?>
                  <div class="hint">STATUS KONTAINER</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">TIPE</label>
                <div class="col-sm-5">
                  <?php echo form_dropdown('DATA[KD_CONT_TIPE]',$arr_tipe,$arrdata['KD_CONT_TIPE'],'id="KD_CONT_TIPE" mandatory="yes" class="form-control" onChange="cont_tipe(this.value)"'); ?>
                  <div class="hint">TIPE KONTAINER</div>
                </div>
                <div class="col-sm-4">
                  <input type="text" name="DATA[TEMPERATURE]" id="TEMPERATURE" class="form-control" placeholder="TEMPERATURE" value="<?php echo $arrdata['TEMPERATURE']; ?>" <?php echo ($arrdata['TEMPERATURE']=="")?"disabled":"mandatory=\"yes\""; ?>>
                  <div class="hint">TEMPERATURE</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">ISO CODE</label>
                <div class="col-sm-8">
                  <input type="text" name="DATA[KD_ISO_CODE]" id="KD_ISO_CODE" mandatory="yes" class="form-control" placeholder="ISO CODE" value="<?php echo $arrdata['KD_ISO_CODE']; ?>">
                  <div class="hint">ISO CODE</div>
                </div>
                <div class="col-sm-1">
                  <button type="button" class="btn btn-sm btn-primary" onclick="popup_searchtwo('popup/popup_search/iso_code/KD_ISO_CODE/2'); ">
                    <i class="icon md-search"></i>
                  </button>
               </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">MASTER BL/AWB</label>
                <div class="col-sm-5">
                  <input type="text" name="DATA[NO_MASTER_BL_AWB]" id="NO_MASTER_BL_AWB" mandatory="yes" class="form-control" placeholder="NOMOR MASTER BL/AWB" value="<?php echo $arrdata['NO_MASTER_BL_AWB']; ?>">
                  <div class="hint">NOMOR MASTER BL/AWB</div>
                </div>
                <div class="col-sm-4">
                  <input class="form-control date" type="text" placeholder="TANGGAL MASTER BL/AWB" name="DATA[TGL_MASTER_BL_AWB]" id="TGL_MASTER_BL_AWB" mandatory="yes" value="<?php echo $arrdata['TGL_MASTER_BL_AWB']; ?>">
                  <div class="hint">TANGGAL MASTER BL/AWB</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">BL/AWB</label>
                <div class="col-sm-5">
                  <input type="text" name="DATA[NO_BL_AWB]" id="NO_BL_AWB" mandatory="yes" class="form-control" placeholder="NOMOR BL/AWB" value="<?php echo $arrdata['NO_BL_AWB']; ?>">
                  <div class="hint">NOMOR BL/AWB</div>
                </div>
                <div class="col-sm-4">
                  <input class="form-control date" type="text" placeholder="TANGGAL BL/AWB" name="DATA[TGL_BL_AWB]" id="TGL_BL_AWB" mandatory="yes" value="<?php echo $arrdata['TGL_BL_AWB']; ?>">
                  <div class="hint">TANGGAL BL/AWB</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">NOMOR POS BC11</label>
                <div class="col-sm-9">
                  <input type="text" name="DATA[NO_POS_BC11]" mandatory="yes" id="NO_POS_BC11" class="form-control" placeholder="NOMOR POS BC11" value="<?php echo $arrdata['NO_POS_BC11']; ?>">
                  <div class="hint">NOMOR POS BC11</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">BRUTO</label>
                <div class="col-sm-9">
                  <input type="text" name="DATA[BRUTO]" mandatory="yes" id="BRUTO" class="form-control" placeholder="BRUTO" value="<?php echo $arrdata['BRUTO']; ?>">
                  <div class="hint">BRUTO</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">SEGEL</label>
                <div class="col-sm-5">
                  <?php echo form_dropdown('DATA[KONDISI_SEGEL]',array(''=>'','BAIK'=>'BAIK','RUSAK'=>'RUSAK'),$arrdata['KONDISI_SEGEL'],'id="KONDISI_SEGEL" mandatory="yes" class="form-control"'); ?>
                  <div class="hint">KONDISI SEGEL</div>
                </div>
                <div class="col-sm-4">
                  <input type="text" name="DATA[NO_SEGEL]" mandatory="yes" id="NO_SEGEL" class="form-control" value="<?php echo $arrdata['NO_SEGEL']; ?>" placeholder="NOMOR SEGEL">
                  <div class="hint">NOMOR SEGEL</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">CONSIGNEE</label>
                <div class="col-sm-9">
                  <input type="hidden" name="DATA[KD_ORG_CONSIGNEE]" id="KD_ORG_CONSIGNEE" class="form-control" value="<?php echo $arrdata['KD_ORG_CONSIGNEE']; ?>" readonly="readonly">
                  <input type="text" name="CONSIGNEE" mandatory="yes" id="CONSIGNEE" class="form-control" value="<?php echo $arrdata['CONSIGNEE']; ?>" placeholder="CONSIGNEE">
                  <div class="hint">CONSIGNEE</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">LOKASI TIMBUN</label>
                <div class="col-sm-9">
                  <input type="text" name="DATA[KD_TIMBUN]" mandatory="yes" id="KD_TIMBUN" class="form-control" placeholder="LOKASI TIMBUN" value="<?php echo $arrdata['KD_TIMBUN']; ?>">
                  <div class="hint">LOKASI TIMBUN</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">PELABUHAN MUAT</label>
                <div class="col-sm-3">
                  <input type="text" name="DATA[KD_PEL_MUAT]" id="KD_PEL_MUAT" mandatory="yes" class="form-control" placeholder="KODE PELABUHAN" value="<?php echo $arrdata['KD_PEL_MUAT']; ?>">
                  <div class="hint">KODE PELABUHAN</div>
                </div>
                <div class="col-sm-6">
                  <input type="text" name="PEL_MUAT" id="PEL_MUAT" mandatory="yes" class="form-control" placeholder="PELABUHAN MUAT" value="<?php echo $arrdata['PEL_MUAT']; ?>">
                  <div class="hint">NAMA PELABUHAN</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">PELABUHAN TRANSIT</label>
                <div class="col-sm-3">
                  <input type="text" name="DATA[KD_PEL_TRANSIT]" id="KD_PEL_TRANSIT" class="form-control" placeholder="KODE PELABUHAN" value="<?php echo $arrdata['KD_PEL_TRANSIT']; ?>">
                  <div class="hint">KODE PELABUHAN</div>
                </div>
                <div class="col-sm-6">
                  <input type="text" name="PEL_TRANSIT" id="PEL_TRANSIT" class="form-control" placeholder="PELABUHAN TRANSIT" value="<?php echo $arrdata['PEL_TRANSIT']; ?>">
                  <div class="hint">NAMA PELABUHAN</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">PELABUHAN BONGKAR</label>
                <div class="col-sm-3">
                  <input type="text" name="DATA[KD_PEL_BONGKAR]" id="KD_PEL_BONGKAR" class="form-control" mandatory="yes" placeholder="KODE PELABUHAN" value="<?php echo $arrdata['KD_PEL_BONGKAR']; ?>">
                  <div class="hint">KODE PELABUHAN</div>
                </div>
                <div class="col-sm-6">
                  <input type="text" name="PEL_BONGKAR" id="PEL_BONGKAR" class="form-control" mandatory="yes" placeholder="PELABUHAN BONGKAR" value="<?php echo $arrdata['PEL_BONGKAR']; ?>">
                  <div class="hint">NAMA PELABUHAN</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">JENIS DOKUMEN</label>
                <div class="col-sm-8">
                  <input type="hidden" name="DATA[KD_DOK_IN]" id="KD_DOK_IN" class="form-control" mandatory="yes" value="<?php echo $arrdata['KD_DOK_IN']; ?>" readonly="readonly">
                  <input type="text" name="JENIS_DOK_IN" id="JENIS_DOK_IN" class="form-control" mandatory="yes" placeholder="JENIS DOKUMEN" value="<?php echo $arrdata['DOK_IN']; ?>">
                  <div class="hint">JENIS DOKUMEN</div>
                </div>
                <div class="col-sm-1">
                  <button type="button" class="btn btn-primary btn-sm" onclick="popup_searchtwo('popup/popup_search/mst_dokbc|EXP/KD_DOK_IN|JENIS_DOK_IN/2');"><span class="icon md-search"></span></button>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">DOKUMEN</label>
                <div class="col-sm-5">
                  <input type="text" name="DATA[NO_DOK_IN]" id="NO_DOK_IN" class="form-control" mandatory="yes" placeholder="NOMOR DOKUMEN" value="<?php echo $arrdata['NO_DOK_IN']; ?>">
                  <div class="hint">NOMOR DOKUMEN</div>
                </div>
                <div class="col-sm-4">
                  <input type="text" name="DATA[TGL_DOK_IN]" id="TGL_DOK_IN" class="form-control date" mandatory="yes" placeholder="TANGGAL DOKUMEN" value="<?php echo $arrdata['TGL_DOK_IN']; ?>" maxlength="10">
                  <div class="hint">TANGGAL DOKUMEN</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">SARANA ANGKUT</label>
                <div class="col-sm-5">
                  <?php echo form_dropdown('DATA[KD_SARANA_ANGKUT_IN]',$arr_angkut,$arrdata['KD_SARANA_ANGKUT_IN'],'id="KD_SARANA_ANGKUT_IN" mandatory="yes" class="form-control"'); ?>
                  <div class="hint">SARANA ANGKUT</div>
                </div>
                <div class="col-sm-4">
                  <input type="text" name="DATA[NO_POL_IN]" id="NO_POL_IN" class="form-control" mandatory="yes" placeholder="NOMOR POLISI" value="<?php echo $arrdata['NO_POL_IN']; ?>">
                  <div class="hint">NOMOR POLISI</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">DAFTAR PABEAN</label>
                <div class="col-sm-5">
                  <input type="text" name="DATA[NO_DAFTAR_PABEAN]" id="NO_DAFTAR_PABEAN" class="form-control" mandatory="yes" placeholder="NOMOR DAFTAR PABEAN" value="<?php echo $arrdata['NO_DAFTAR_PABEAN']; ?>">
                  <div class="hint">NOMOR DAFTAR PABEAN</div>
                </div>
                <div class="col-sm-4">
                  <input type="text" name="DATA[TGL_DAFTAR_PABEAN]" id="TGL_DAFTAR_PABEAN" class="form-control date" mandatory="yes" placeholder="TANGGAL DAFTAR PABEAN" value="<?php echo $arrdata['TGL_DAFTAR_PABEAN']; ?>" maxlength="10">
                  <div class="hint">TANGGAL DAFTAR PABEAN</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">IJIN TPS</label>
                <div class="col-sm-5">
                  <input type="text" name="DATA[NO_IJIN_TPS]" id="NO_IJIN_TPS" class="form-control" mandatory="yes" placeholder="NOMOR IJIN TPS" value="<?php echo $arrdata['NO_IJIN_TPS']; ?>">
                  <div class="hint">NOMOR IJIN TPS</div>
                </div>
                <div class="col-sm-4">
                  <input type="text" name="DATA[TGL_IJIN_TPS]" id="TGL_IJIN_TPS" class="form-control date" mandatory="yes" placeholder="TANGGAL IJIN TPS" value="<?php echo $arrdata['TGL_IJIN_TPS']; ?>" maxlength="10">
                  <div class="hint">TANGGAL IJIN TPS</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">GATE IN</label>
                <div class="col-sm-9">
                  <input class="form-control datetime" type="text" placeholder="GATE IN" name="DATA[WK_IN]" id="WK_IN" mandatory="yes" value="<?php echo $arrdata['WK_IN']; ?>">
                  <div class="hint">GATE IN</div>
                </div>
              </div>
            </div>
          </div>
          <input type="hidden" name="action" id="action" value="<?php echo site_url('codeco/gatein_kontainer/post/'.$post); ?>" readonly="readonly"/>
        </form>
      </div>
    </div>
  </div>
</div>
<script>
function cont_tipe(val){
	$('#TEMPERATURE').removeAttr('style');
	if(val=="RFR"){
		$('#TEMPERATURE').attr('disabled',false);
		$('#TEMPERATURE').val('');
		$('#TEMPERATURE').attr('mandatory','yes');
	}else{
		$('#TEMPERATURE').attr('disabled',true);
		$('#TEMPERATURE').val('');
		$('#TEMPERATURE').removeAttr('mandatory');
	}
}
$(function(){
	date('date');
	datetime('datetime');
	autocomplete('KD_PEL_MUAT','/popup/autocomplete/mst_port/kode',function(event, ui){
		$('#PEL_MUAT').val(ui.item.NAMA);
	});
	autocomplete('PEL_MUAT','/popup/autocomplete/mst_port/nama',function(event, ui){
		$('#KD_PEL_MUAT').val(ui.item.KODE);
	});
	autocomplete('KD_PEL_TRANSIT','/popup/autocomplete/mst_port/kode',function(event, ui){
		$('#PEL_TRANSIT').val(ui.item.NAMA);
	});
	autocomplete('PEL_TRANSIT','/popup/autocomplete/mst_port/nama',function(event, ui){
		$('#KD_PEL_TRANSIT').val(ui.item.KODE);
	});
	autocomplete('KD_PEL_BONGKAR','/popup/autocomplete/mst_port/kode',function(event, ui){
		$('#PEL_BONGKAR').val(ui.item.NAMA);
	});
	autocomplete('PEL_BONGKAR','/popup/autocomplete/mst_port/nama',function(event, ui){
		$('#KD_PEL_BONGKAR').val(ui.item.KODE);
	});
	autocomplete('JENIS_DOK_IN','/popup/autocomplete/mst_dok_bc/exp',function(event, ui){
		$('#KD_DOK_IN').val(ui.item.KODE);
	});
	autocomplete('CONSIGNEE','/popup/autocomplete/mst_organisasi/cons',function(event, ui){
		$('#KD_ORG_CONSIGNEE').val(ui.item.KODE);
	});
	autocomplete('KD_ISO_CODE','/popup/autocomplete/mst_isocode',function(event, ui){
		$('#KD_ISO_CODE').val(ui.item.KODE);
	});
});
</script>