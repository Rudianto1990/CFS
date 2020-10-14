<div class="panel">
  <div class="ribbon ribbon-clip ribbon-primary">
  	<span class="ribbon-inner">
		<i class="icon md-view-list margin-0" aria-hidden="true"></i> <?php echo $title; ?>
    </span>
  </div>
  <button type="submit" class="btn btn-sm btn-primary navbar-right navbar-btn waves-effect waves-light" onclick="save_post('form_kms','divtblkemasan'); return false;">
  	<i class="icon md-badge-check"></i> SAVE
  </button>
  <div class="panel-body container-fluid">
    <div class="row">
      <div class="col-sm-12">
        <form name="form_kms" id="form_kms" class="form-horizontal" role="form" action="<?php echo site_url('execute/process/'.$action.'/kemasan_in/'.$id); ?>" method="post" autocomplete="off" onsubmit="save_post('form_kms','divtblkemasan'); return false;" popup="1">
          <div class="panel-body container-fluid">
            <div class="row">
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">KONTAINER ASAL</label>
                <div class="col-sm-8">
                  <input type="hidden" class="form-control" name="DATA[ID_CONT_ASAL]" id="ID_CONT_ASAL" value="<?php echo $arrdata['ID_CONT_ASAL']; ?>" readonly="readonly">
                  <input type="text" class="form-control" name="DATA[NO_CONT_ASAL]" id="NO_CONT_ASAL" value="<?php echo $arrdata['NO_CONT_ASAL']; ?>" readonly="readonly">
                  <div class="hint">NOMOR KONTAINER ASAL</div>
                </div>
                <div class="col-sm-1">
                  <button type="button" class="btn btn-sm btn-primary" onclick="popup_searchtwo('popup/popup_search/gatein_kontainer|<?php echo $id; ?>/ID_CONT_ASAL|NO_CONT_ASAL/2'); ">
                  	<i class="icon md-search"></i>
                    </button>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">KEMASAN</label>
                <div class="col-sm-3">
                  <input type="text" class="form-control" name="DATA[KD_KEMASAN]" id="KD_KEMASAN" mandatory="yes" placeholder="KODE KEMASAN" value="<?php echo $arrdata['KD_KEMASAN']; ?>">
                  <div class="hint">KODE KEMASAN</div>
                </div>
                <div class="col-sm-6">
                  <input type="text" class="form-control" name="KEMASAN" id="KEMASAN" mandatory="yes" placeholder="NAMA KEMASAN" value="<?php echo $arrdata['KEMASAN']; ?>">
                  <div class="hint">NAMA KEMASAN</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">KOMODITI</label>
                <div class="col-sm-9">
                  <textarea class="form-control" name="DATA[KOMODITI]" id="KOMODITI" mandatory="yes" placeholder="KOMODITI"><?php echo $arrdata['KOMODITI']; ?></textarea>
                  <div class="hint">KOMODITI</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">JUMLAH</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="DATA[JUMLAH]" id="JUMLAH" mandatory="yes" placeholder="JUMLAH" value="<?php echo $arrdata['JUMLAH']; ?>">
                  <div class="hint">JUMLAH</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">BRUTO</label>
                <div class="col-sm-5">
                  <input type="text" class="form-control" name="DATA[BRUTO]" id="BRUTO" mandatory="yes" value="<?php echo $arrdata['BRUTO']; ?>" placeholder="BRUTO">
                  <div class="hint">BRUTO</div>
                </div>
                <div class="col-sm-4">
                  <input type="text" name="DATA[CHARGE_BRUTO]" id="CHARGE_BRUTO" class="form-control" placeholder="CHARGE BRUTO" value="<?php echo $arrdata['CHARGE_BRUTO']; ?>">
                  <div class="hint">CHARGE BRUTO</div>
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
                <div class="col-sm-2">
                  <input type="text" name="DATA[KD_PEL_MUAT]" id="KD_PEL_MUAT" mandatory="yes" class="form-control" placeholder="KODE PELABUHAN" value="<?php echo $arrdata['KD_PEL_MUAT']; ?>">
                  <div class="hint">KODE PELABUHAN</div>
                </div>
                <div class="col-sm-7">
                  <input type="text" name="PEL_MUAT" id="PEL_MUAT" mandatory="yes" class="form-control" placeholder="PELABUHAN MUAT" value="<?php echo $arrdata['PEL_MUAT']; ?>">
                  <div class="hint">NAMA PELABUHAN</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">PELABUHAN TRANSIT</label>
                <div class="col-sm-2">
                  <input type="text" name="DATA[KD_PEL_TRANSIT]" id="KD_PEL_TRANSIT" class="form-control" placeholder="KODE PELABUHAN" value="<?php echo $arrdata['KD_PEL_TRANSIT']; ?>">
                  <div class="hint">KODE PELABUHAN</div>
                </div>
                <div class="col-sm-7">
                  <input type="text" name="PEL_TRANSIT" id="PEL_TRANSIT" class="form-control" placeholder="PELABUHAN TRANSIT" value="<?php echo $arrdata['PEL_TRANSIT']; ?>">
                  <div class="hint">NAMA PELABUHAN</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">PELABUHAN BONGKAR</label>
                <div class="col-sm-2">
                  <input type="text" name="DATA[KD_PEL_BONGKAR]" id="KD_PEL_BONGKAR" class="form-control" mandatory="yes" placeholder="KODE PELABUHAN" value="<?php echo $arrdata['KD_PEL_BONGKAR']; ?>">
                  <div class="hint">KODE PELABUHAN</div>
                </div>
                <div class="col-sm-7">
                  <input type="text" name="PEL_BONGKAR" id="PEL_BONGKAR" class="form-control" mandatory="yes" placeholder="PELABUHAN BONGKAR" value="<?php echo $arrdata['PEL_BONGKAR']; ?>">
                  <div class="hint">NAMA PELABUHAN</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">JENIS DOKUMEN</label>
                <div class="col-sm-9">
                  <input type="hidden" name="DATA[KD_DOK_IN]" id="KD_DOK_IN" class="form-control" mandatory="yes" value="<?php echo $arrdata['KD_DOK_IN']; ?>" readonly="readonly">
                  <input type="text" name="JENIS_DOK_IN" id="JENIS_DOK_IN" class="form-control" mandatory="yes" placeholder="JENIS DOKUMEN" value="<?php echo $arrdata['DOK_IN']; ?>">
                  <div class="hint">JENIS DOKUMEN</div>
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
                <label class="col-sm-3 control-label">GATE IN</label>
                <div class="col-sm-9">
                  <input class="form-control datetime" type="text" placeholder="GATE IN" name="DATA[WK_IN]" id="WK_IN" mandatory="yes" value="<?php echo $arrdata['WK_IN']; ?>">
                  <div class="hint">GATE IN</div>
                </div>
              </div>
            </div>
          </div>
          <input type="hidden" name="action" id="action" value="<?php echo site_url('codeco/gatein_kemasan/post/'.$post); ?>" readonly="readonly"/>
        </form>
      </div>
    </div>
  </div>
</div>
<script>
$(function(){
	date('date');
	datetime('datetime');
	autocomplete('KD_KEMASAN','/popup/autocomplete/mst_kemasan/kode',function(event, ui){
		$('#KEMASAN').val(ui.item.NAMA);
	});
	autocomplete('KEMASAN','/popup/autocomplete/mst_kemasan/nama',function(event, ui){
		$('#KD_KEMASAN').val(ui.item.KODE);
	});
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
});
</script>