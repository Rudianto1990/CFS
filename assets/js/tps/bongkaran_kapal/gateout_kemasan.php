<div class="card">
  <div class="card-block p-a-0">
    <div class="box-tab m-b-0" id="rootwizard">
      <ul class="wizard-tabs">
        <li class="active"><a href="#gatein" data-toggle="tab">DISCHARGE</a></li>
        <li><a href="#gateout" data-toggle="tab">GATE OUT</a></li>
        <li style="width:100%;"> <a data-toggle="" style="text-align:right">
          <button type="button" class="btn btn-primary btn-icon" onclick="save_popup('frm_data','tblkemasan'); return false;">GATE OUT<i class="icon-check"></i></button>
          </a></li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane p-x-lg active" id="gatein">
          <form class="form-horizontal" role="form">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="col-sm-3 control-label-left">KEMASAN</label>
                  <div class="col-sm-2">
                    <input type="text" name="DATA[KD_KEMASAN]" id="KD_KEMASAN" wajib="yes" class="form-control" readonly="readonly" placeholder="KODE" value="<?php echo $arrkms['KD_KEMASAN']; ?>">
                  </div>
                  <div class="col-sm-5">
                    <input type="text" name="KEMASAN" id="KEMASAN" wajib="yes" class="form-control" placeholder="KEMASAN" value="<?php echo $arrkms['KEMASAN']; ?>">
                  </div>
                  <div class="col-sm-1" style="padding-top:3px">
                    <button type="button" class="btn btn-primary btn-sm" onclick="popup_searchtwo('popup/popup_search/kemasan','','60','600')"> <span class="icon-magnifier"></span></button>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label-left">STATUS</label>
                  <div class="col-sm-8"> <?php echo form_dropdown('DATA[KD_CONT_STATUS_IN]',$arr_status_cont,$arrkms['KD_CONT_STATUS_IN'],'id="KD_CONT_STATUS_IN" wajib="yes" class="form-control"'); ?> </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label-left">JUMLAH</label>
                  <div class="col-sm-8">
                    <input type="text" name="DATA[JUMLAH]" id="JUMLAH" wajib="yes" class="form-control" placeholder="JUMLAH" value="<?php echo $arrkms['JUMLAH']; ?>">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label-left">BRUTO</label>
                  <div class="col-sm-8">
                    <input type="text" name="DATA[BRUTO]" id="BRUTO" wajib="yes" class="form-control" placeholder="BRUTO" value="<?php echo $arrkms['BRUTO']; ?>">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label-left">NO. SEGEL</label>
                  <div class="col-sm-8">
                    <input type="text" name="DATA[NO_SEGEL]" id="NO_SEGEL" wajib="yes" class="form-control" placeholder="NOMOR" value="<?php echo $arrkms['NO_SEGEL']; ?>">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label-left">BL AWB</label>
                  <div class="col-sm-4">
                    <input type="text" name="DATA[NO_BL_AWB]" id="NO_BL_AWB" wajib="yes" class="form-control" placeholder="NOMOR" value="<?php echo $arrkms['NO_BL_AWB']; ?>">
                  </div>
                  <div class="col-sm-4">
                    <div class="input-prepend input-group"><span class="add-on input-group-addon"><i class="icon-calendar"></i></span>
                      <input class="form-control drp" type="text" placeholder="TANGGAL" name="DATA[TGL_BL_AWB]" id="TGL_BL_AWB" data-provide="datepicker" wajib="yes" value="<?php echo date_en($arrkms['TGL_BL_AWB']); ?>">
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label-left">MST. BL AWB</label>
                  <div class="col-sm-4">
                    <input type="text" name="DATA[NO_MASTER_BL_AWB]" id="NO_MASTER_BL_AWB" wajib="yes" class="form-control" placeholder="NOMOR" value="<?php echo $arrkms['NO_MASTER_BL_AWB']; ?>">
                  </div>
                  <div class="col-sm-4">
                    <div class="input-prepend input-group"><span class="add-on input-group-addon"><i class="icon-calendar"></i></span>
                      <input class="form-control drp" type="text" placeholder="TANGGAL" name="DATA[TGL_MASTER_BL_AWB]" id="TGL_MASTER_BL_AWB" data-provide="datepicker" wajib="yes" value="<?php echo date_en($arrkms['TGL_MASTER_BL_AWB']); ?>">
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label-left">JENIS DOKUMEN</label>
                  <div class="col-sm-2">
                    <input type="text" name="DATA[KD_DOK_IN]" id="KD_DOK_IN" wajib="yes" class="form-control" readonly="readonly" placeholder="KODE" value="<?php echo $arrkms['KD_DOK_IN']; ?>">
                  </div>
                  <div class="col-sm-5">
                    <input type="text" name="NAMA_DOK_IN" id="NAMA_DOK_IN" wajib="yes" class="form-control" placeholder="DOKUMEN" value="<?php echo $arrkms['NAMA_DOK_IN']; ?>">
                  </div>
                  <div class="col-sm-1" style="padding-top:3px">
                    <button type="button" class="btn btn-primary btn-sm" onclick="popup_searchtwo('popup/popup_search/dok_bc|IMP','','60','600')"> <span class="icon-magnifier"></span></button>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label-left">DOKUMEN</label>
                  <div class="col-sm-4">
                    <input type="text" name="DATA[NO_DOK_IN]" id="NO_DOK_IN" wajib="yes" class="form-control" placeholder="NOMOR" value="<?php echo $arrkms['NO_DOK_IN']; ?>">
                  </div>
                  <div class="col-sm-4">
                    <div class="input-prepend input-group"><span class="add-on input-group-addon"><i class="icon-calendar"></i></span>
                      <input class="form-control drp" type="text" placeholder="TANGGAL" name="DATA[TGL_DOK_IN]" id="TGL_DOK_IN" data-provide="datepicker" wajib="yes" value="<?php echo date_en($arrkms['TGL_DOK_IN']); ?>">
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label class="col-sm-3 control-label-left">CONSIGNEE</label>
                  <div class="col-sm-8">
                    <input type="hidden" name="DATA[KD_ORG_CONSIGNEE]" id="KD_ORG_CONSIGNEE" class="form-control" readonly="readonly" value="<?php echo $arrkms['KD_ORG_CONSIGNEE']; ?>">
                    <input type="text" name="CONSIGNEE" id="CONSIGNEE" wajib="yes" class="form-control" value="<?php echo $arrkms['CONSIGNEE']; ?>">
                  </div>
                  <div class="col-sm-1" style="padding-top:3px">
                    <button type="button" class="btn btn-primary btn-sm" onclick="popup_searchtwo('popup/popup_search/organisasi|CONS','','60','600')"> <span class="icon-magnifier"></span></button>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label-left">NO. POS BC 1.1</label>
                  <div class="col-sm-9">
                    <input type="text" name="DATA[NO_POS_BC11]" id="NO_POS_BC11" wajib="yes" class="form-control" placeholder="NOMOR" value="<?php echo $arrkms['NO_POS_BC11']; ?>">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label-left">LOKASI TIMBUN</label>
                  <div class="col-sm-9">
                    <input type="text" name="DATA[KD_TIMBUN]" id="KD_TIMBUN" wajib="yes" class="form-control" value="<?php echo $arrkms['KD_TIMBUN']; ?>">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label-left">NO. POLISI</label>
                  <div class="col-sm-9">
                    <input type="text" name="DATA[NO_POL_IN]" id="NO_POL_IN" wajib="yes" class="form-control" placeholder="NOMOR" value="<?php echo $arrkms['NO_POL_IN']; ?>">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label-left">PEL. MUAT</label>
                  <div class="col-sm-3">
                    <input type="text" name="DATA[KD_PEL_MUAT]" id="KD_PEL_MUAT_KMS" wajib="yes" class="form-control" readonly="readonly" placeholder="KODE" value="<?php echo $arrkms['KD_PEL_MUAT']; ?>">
                  </div>
                  <div class="col-sm-5">
                    <input type="text" name="PEL_MUAT" id="PEL_MUAT" wajib="yes" class="form-control" placeholder="PELABUHAN" value="<?php echo $arrkms['PEL_MUAT']; ?>">
                  </div>
                  <div class="col-sm-1" style="padding-top:3px">
                    <button type="button" class="btn btn-primary btn-sm" onclick="popup_searchtwo('popup/popup_search/port','','60','600')"> <span class="icon-magnifier"></span></button>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label-left">PEL. TRANSIT</label>
                  <div class="col-sm-3">
                    <input type="text" name="DATA[KD_PEL_TRANSIT]" id="KD_PEL_TRANSIT_KMS" class="form-control" readonly="readonly" placeholder="KODE" value="<?php echo $arrkms['KD_PEL_TRANSIT']; ?>">
                  </div>
                  <div class="col-sm-5">
                    <input type="text" name="PEL_TRANSIT" id="PEL_TRANSIT" class="form-control" placeholder="PELABUHAN" value="<?php echo $arrkms['PEL_TRANSIT']; ?>">
                  </div>
                  <div class="col-sm-1" style="padding-top:3px">
                    <button type="button" class="btn btn-primary btn-sm" onclick="popup_searchtwo('popup/popup_search/port','','60','600')"> <span class="icon-magnifier"></span></button>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label-left">PEL. BONGKAR</label>
                  <div class="col-sm-3">
                    <input type="text" name="DATA[KD_PEL_BONGKAR]" id="KD_PEL_BONGKAR_KMS" wajib="yes" class="form-control" readonly="readonly" placeholder="KODE" value="<?php echo $arrkms['KD_PEL_BONGKAR']; ?>">
                  </div>
                  <div class="col-sm-5">
                    <input type="text" name="PEL_BONGKAR" id="PEL_BONGKAR" wajib="yes" class="form-control" placeholder="PELABUHAN" value="<?php echo $arrkms['PEL_BONGKAR']; ?>">
                  </div>
                  <div class="col-sm-1" style="padding-top:3px">
                    <button type="button" class="btn btn-primary btn-sm" onclick="popup_searchtwo('popup/popup_search/port','','60','600')"> <span class="icon-magnifier"></span></button>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label-left">ANGKUTAN</label>
                  <div class="col-sm-9"> <?php echo form_dropdown('DATA[KD_SARANA_ANGKUT_IN]',$arr_angkutan,$arrkms['KD_SARANA_ANGKUT_IN'],'id="KD_SARANA_ANGKUT_IN" wajib="yes" class="form-control"'); ?> </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label-left">DISCHARGE</label>
                  <div class="col-sm-9">
                    <div class="input-prepend input-group"><span class="add-on input-group-addon"><i class="icon-calendar"></i></span>
                      <input class="form-control drp" type="text" placeholder="TANGGAL" name="DATA[WK_IN]" id="WK_IN" data-provide="datepicker" wajib="yes" value="<?php echo $arrkms['WK_IN']; ?>">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
        <div class="tab-pane p-x-lg" id="gateout">
          <form name="frm_data" id="frm_data" class="form-horizontal" role="form" action="<?php echo site_url('tps/execute/update/bongkaran_kapal-gateout_kemasan/'.$ID); ?>" method="post" autocomplete="off" onsubmit="save_popup('frm_data','tblkemasan'); return false;">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="col-sm-3 control-label-left">JENIS DOKUMEN</label>
                  <div class="col-sm-2">
                    <input type="text" name="DATA[KD_DOK_OUT]" id="KD_DOK_OUT" wajib="yes" class="form-control" readonly="readonly" placeholder="KODE" value="<?php echo $arrkms['KD_DOK_OUT']; ?>">
                  </div>
                  <div class="col-sm-5">
                    <input type="text" name="NAMA_DOK_OUT" id="NAMA_DOK_OUT" wajib="yes" class="form-control" placeholder="DOKUMEN" value="<?php echo $arrkms['NAMA_DOK_OUT']; ?>">
                  </div>
                  <div class="col-sm-1" style="padding-top:3px">
                    <button type="button" class="btn btn-primary btn-sm" onclick="popup_searchtwo('popup/popup_search/dok_bc|IMP','','60','600')"> <span class="icon-magnifier"></span></button>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label-left">DOKUMEN</label>
                  <div class="col-sm-4">
                    <input type="text" name="DATA[NO_DOK_OUT]" id="NO_DOK_OUT" wajib="yes" class="form-control" placeholder="NOMOR" value="<?php echo $arrkms['NO_DOK_OUT']; ?>">
                  </div>
                  <div class="col-sm-4">
                    <div class="input-prepend input-group"><span class="add-on input-group-addon"><i class="icon-calendar"></i></span>
                      <input class="form-control drp" type="text" placeholder="TANGGAL" name="DATA[TGL_DOK_OUT]" id="TGL_DOK_OUT" data-provide="datepicker" wajib="yes" value="<?php echo date_en($arrkms['TGL_DOK_OUT']); ?>">
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label-left">DAFTAR PABEAN</label>
                  <div class="col-sm-4">
                    <input type="text" name="DATA[NO_DAFTAR_PABEAN]" id="NO_DAFTAR_PABEAN" wajib="yes" class="form-control" placeholder="NOMOR" value="<?php echo $arrkms['NO_DAFTAR_PABEAN']; ?>">
                  </div>
                  <div class="col-sm-4">
                    <div class="input-prepend input-group"><span class="add-on input-group-addon"><i class="icon-calendar"></i></span>
                      <input class="form-control drp" type="text" placeholder="TANGGAL" name="DATA[TGL_DAFTAR_PABEAN]" id="TGL_DAFTAR_PABEAN" data-provide="datepicker" wajib="yes" value="<?php echo date_en($arrkms['TGL_DAFTAR_PABEAN']); ?>">
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label-left">SEGEL BC</label>
                  <div class="col-sm-4">
                    <input type="text" name="DATA[NO_SEGEL_BC]" id="NO_SEGEL_BC" wajib="yes" class="form-control" placeholder="NOMOR" value="<?php echo $arrkms['NO_SEGEL_BC']; ?>">
                  </div>
                  <div class="col-sm-4">
                    <div class="input-prepend input-group"><span class="add-on input-group-addon"><i class="icon-calendar"></i></span>
                      <input class="form-control drp" type="text" placeholder="TANGGAL" name="DATA[TGL_SEGEL_BC]" id="TGL_SEGEL_BC" data-provide="datepicker" wajib="yes" value="<?php echo date_en($arrkms['TGL_SEGEL_BC']); ?>">
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label-left">IJIN TPS</label>
                  <div class="col-sm-4">
                    <input type="text" name="DATA[NO_IJIN_TPS]" id="NO_IJIN_TPS" wajib="yes" class="form-control" placeholder="NOMOR" value="<?php echo $arrkms['NO_IJIN_TPS']; ?>">
                  </div>
                  <div class="col-sm-4">
                    <div class="input-prepend input-group"><span class="add-on input-group-addon"><i class="icon-calendar"></i></span>
                      <input class="form-control drp" type="text" placeholder="TANGGAL" name="DATA[TGL_IJIN_TPS]" id="TGL_IJIN_TPS" data-provide="datepicker" wajib="yes" value="<?php echo date_en($arrkms['TGL_IJIN_TPS']); ?>">
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label class="col-sm-3 control-label-left">NO. POLISI</label>
                  <div class="col-sm-9">
                    <input type="text" name="DATA[NO_POL_OUT]" id="NO_POL_OUT" wajib="yes" class="form-control" placeholder="NOMOR" value="<?php echo $arrkms['NO_POL_OUT']; ?>">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label-left">STATUS</label>
                  <div class="col-sm-9"> <?php echo form_dropdown('DATA[KD_CONT_STATUS_OUT]',$arr_status_cont,$arrkms['KD_CONT_STATUS_OUT'],'id="KD_CONT_STATUS_OUT" wajib="yes" class="form-control"'); ?> </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label-left">ANGKUTAN</label>
                  <div class="col-sm-9"> <?php echo form_dropdown('DATA[KD_SARANA_ANGKUT_OUT]',$arr_angkutan,$arrkms['KD_SARANA_ANGKUT_OUT'],'id="KD_SARANA_ANGKUT_OUT" wajib="yes" class="form-control"'); ?> </div>
                </div>
                <?php if(set_setting('SETWKINOUT') == 'Y'): ?>
                <div class="form-group">
                  <label class="col-sm-3 control-label-left">GATE OUT</label>
                  <div class="col-sm-9">
                    <div class="input-prepend input-group"><span class="add-on input-group-addon"><i class="icon-calendar"></i></span>
                      <input class="form-control drp" type="text" placeholder="TANGGAL" name="DATA[WK_OUT]" id="WK_OUT" data-provide="datepicker" wajib="yes" value="<?php echo $arrkms['WK_OUT']; ?>">
                    </div>
                  </div>
                </div>
                <?php endif; ?>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
$(function(){
	autocomplete('NAMA_DOK_OUT','/tps/autocomplete/mst_dok_bc/IMP',function(event, ui){
		$('#KD_DOK_OUT').val(ui.item.KODE);
	});
});
</script>