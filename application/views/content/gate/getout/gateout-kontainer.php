<div class="panel">
  <div class="ribbon ribbon-clip ribbon-primary">
  	<span class="ribbon-inner">
		<i class="icon md-view-list margin-0" aria-hidden="true"></i> <?php echo $title; ?>
    </span>
  </div>
  <button type="submit" class="btn btn-sm btn-primary navbar-right navbar-btn waves-effect waves-light" onclick="save_post('form_cont','divtblkontainer'); return false;">
  	<i class="icon md-badge-check"></i> SAVE
  </button>
  <div>&nbsp;</div>
  <div>&nbsp;</div>
  <div>&nbsp;</div>
  <div class="panel-group panel-group-continuous" id="exampleAccordionContinuous" aria-multiselectable="true" role="tablist">
      <div class="panel">
        <div class="panel-heading" id="exampleHeadingContinuousOne" role="tab">
          <a class="panel-title" data-parent="#exampleAccordionContinuous" data-toggle="collapse" href="#exampleCollapseContinuousOne" aria-controls="exampleCollapseContinuousOne" aria-expanded="true">
          	DISCHARGE
          </a>
        </div>
        <div class="panel-collapse collapse" id="exampleCollapseContinuousOne" aria-labelledby="exampleHeadingContinuousOne" role="tabpanel">
          <div class="panel-body">
          <form class="form-horizontal" role="form" method="post" autocomplete="off" popup="1">
          <div class="panel-body container-fluid">
            <div class="row">
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">KONTAINER</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control <?php echo ($arrdata['NO_CONT']!="")?"focus":""; ?>" value="<?php echo $arrdata['NO_CONT']; ?>" readonly="readonly">
                  <div class="hint">NOMOR KONTAINER</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">UKURAN</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control <?php echo ($arrdata['CONT_UKURAN']!="")?"focus":""; ?>" value="<?php echo $arrdata['CONT_UKURAN']; ?>" readonly="readonly">
                  <div class="hint">UKURAN KONTAINER</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">JENIS</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control <?php echo ($arrdata['KD_CONT_JENIS']!="")?"focus":""; ?>" value="<?php echo $arrdata['CONT_JENIS']; ?>" readonly="readonly">
                  <div class="hint">JENIS KONTAINER</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">STATUS</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control <?php echo ($arrdata['KD_CONT_STATUS_IN']!="")?"focus":""; ?>" value="<?php echo $arrdata['CONT_STATUS_IN']; ?>" readonly="readonly">
                  <div class="hint">STATUS KONTAINER</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">TIPE</label>
                <div class="col-sm-5">
                  <input type="text" class="form-control <?php echo ($arrdata['KD_CONT_TIPE']!="")?"focus":""; ?>" value="<?php echo $arrdata['CONT_TIPE']; ?>" readonly="readonly">
                  <div class="hint">TIPE KONTAINER</div>
                </div>
                <div class="col-sm-4">
                  <input type="text" class="form-control <?php echo ($arrdata['TEMPERATURE']!="")?"focus":""; ?>" value="<?php echo $arrdata['TEMPERATURE']; ?>" readonly="readonly">
                  <div class="hint">TEMPERATURE</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">ISO CODE</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control <?php echo ($arrdata['KD_ISO_CODE']!="")?"focus":""; ?>" value="<?php echo $arrdata['ISO_CODE']; ?>" readonly="readonly">
                  <div class="hint">ISO CODE</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">MASTER BL/AWB</label>
                <div class="col-sm-5">
                  <input type="text" class="form-control <?php echo ($arrdata['NO_MASTER_BL_AWB']!="")?"focus":""; ?>" value="<?php echo $arrdata['NO_MASTER_BL_AWB']; ?>" readonly="readonly">
                  <div class="hint">NOMOR MASTER BL/AWB</div>
                </div>
                <div class="col-sm-4">
                  <input class="form-control <?php echo ($arrdata['TGL_MASTER_BL_AWB']!="")?"focus":""; ?>" type="text" value="<?php echo $arrdata['TGL_MASTER_BL_AWB']; ?>" readonly="readonly">
                  <div class="hint">TANGGAL MASTER BL/AWB</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">BL/AWB</label>
                <div class="col-sm-5">
                  <input type="text" class="form-control <?php echo ($arrdata['NO_BL_AWB']!="")?"focus":""; ?>" value="<?php echo $arrdata['NO_BL_AWB']; ?>" readonly="readonly">
                  <div class="hint">NOMOR BL/AWB</div>
                </div>
                <div class="col-sm-4">
                  <input class="form-control <?php echo ($arrdata['TGL_BL_AWB']!="")?"focus":""; ?>" type="text" value="<?php echo $arrdata['TGL_BL_AWB']; ?>" readonly="readonly">
                  <div class="hint">TANGGAL BL/AWB</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">NOMOR POS BC11</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control <?php echo ($arrdata['NO_POS_BC11']!="")?"focus":""; ?>" value="<?php echo $arrdata['NO_POS_BC11']; ?>" readonly="readonly">
                  <div class="hint">NOMOR POS BC11</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">BRUTO</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control <?php echo ($arrdata['BRUTO']!="")?"focus":""; ?>" value="<?php echo $arrdata['BRUTO']; ?>" readonly="readonly">
                  <div class="hint">BRUTO</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">SEGEL</label>
                <div class="col-sm-5">
                  <input type="text" class="form-control <?php echo ($arrdata['KONDISI_SEGEL']!="")?"focus":""; ?>" value="<?php echo $arrdata['KONDISI_SEGEL']; ?>" readonly="readonly">
                  <div class="hint">KONDISI SEGEL</div>
                </div>
                <div class="col-sm-4">
                  <input type="text" class="form-control <?php echo ($arrdata['NO_SEGEL']!="")?"focus":""; ?>" value="<?php echo $arrdata['NO_SEGEL']; ?>" readonly="readonly">
                  <div class="hint">NOMOR SEGEL</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">CONSIGNEE</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control <?php echo ($arrdata['CONSIGNEE']!="")?"focus":""; ?>" value="<?php echo $arrdata['CONSIGNEE']; ?>" readonly="readonly">
                  <div class="hint">CONSIGNEE</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">LOKASI TIMBUN</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control <?php echo ($arrdata['KD_TIMBUN']!="")?"focus":""; ?>" value="<?php echo $arrdata['KD_TIMBUN']; ?>" readonly="readonly">
                  <div class="hint">LOKASI TIMBUN</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">PELABUHAN MUAT</label>
                <div class="col-sm-2">
                  <input type="text" class="form-control <?php echo ($arrdata['KD_PEL_MUAT']!="")?"focus":""; ?>" value="<?php echo $arrdata['KD_PEL_MUAT']; ?>" readonly="readonly">
                  <div class="hint">KODE PELABUHAN</div>
                </div>
                <div class="col-sm-7">
                  <input type="text" class="form-control <?php echo ($arrdata['PEL_MUAT']!="")?"focus":""; ?>" value="<?php echo $arrdata['PEL_MUAT']; ?>" readonly="readonly">
                  <div class="hint">NAMA PELABUHAN</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">PELABUHAN TRANSIT</label>
                <div class="col-sm-2">
                  <input type="text" class="form-control <?php echo ($arrdata['KD_PEL_TRANSIT']!="")?"focus":""; ?>" value="<?php echo $arrdata['KD_PEL_TRANSIT']; ?>" readonly="readonly">
                  <div class="hint">KODE PELABUHAN</div>
                </div>
                <div class="col-sm-7">
                  <input type="text" class="form-control <?php echo ($arrdata['PEL_TRANSIT']!="")?"focus":""; ?>" value="<?php echo $arrdata['PEL_TRANSIT']; ?>" readonly="readonly">
                  <div class="hint">NAMA PELABUHAN</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">PELABUHAN BONGKAR</label>
                <div class="col-sm-2">
                  <input type="text" class="form-control <?php echo ($arrdata['KD_PEL_BONGKAR']!="")?"focus":""; ?>" value="<?php echo $arrdata['KD_PEL_BONGKAR']; ?>" readonly="readonly">
                  <div class="hint">KODE PELABUHAN</div>
                </div>
                <div class="col-sm-7">
                  <input type="text" class="form-control <?php echo ($arrdata['PEL_BONGKAR']!="")?"focus":""; ?>" value="<?php echo $arrdata['PEL_BONGKAR']; ?>" readonly="readonly">
                  <div class="hint">NAMA PELABUHAN</div>
                </div>
              </div>
              <?php /*?><div class="form-group form-material">
                <label class="col-sm-3 control-label">JENIS DOKUMEN</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control <?php echo ($arrdata['DOK_IN']!="")?"focus":""; ?>" value="<?php echo $arrdata['DOK_IN']; ?>" readonly="readonly">
                  <div class="hint">JENIS DOKUMEN</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">DOKUMEN</label>
                <div class="col-sm-5">
                  <input type="text" class="form-control <?php echo ($arrdata['NO_DOK_IN']!="")?"focus":""; ?>" value="<?php echo $arrdata['NO_DOK_IN']; ?>" readonly="readonly">
                  <div class="hint">NOMOR DOKUMEN</div>
                </div>
                <div class="col-sm-4">
                  <input type="text" class="form-control <?php echo ($arrdata['TGL_DOK_IN']!="")?"focus":""; ?>" value="<?php echo $arrdata['TGL_DOK_IN']; ?>" readonly="readonly">
                  <div class="hint">TANGGAL DOKUMEN</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">SARANA ANGKUT</label>
                <div class="col-sm-5">
                  <input type="text" class="form-control <?php echo ($arrdata['SARANA_ANGKUT_IN']!="")?"focus":""; ?>" value="<?php echo $arrdata['SARANA_ANGKUT_IN']; ?>" readonly="readonly">
                  <div class="hint">SARANA ANGKUT</div>
                </div>
                <div class="col-sm-4">
                  <input type="text" class="form-control <?php echo ($arrdata['NO_POL_IN']!="")?"focus":""; ?>" value="<?php echo $arrdata['NO_POL_IN']; ?>" readonly="readonly">
                  <div class="hint">NOMOR POLISI</div>
                </div>
              </div><?php */?>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">DISCHARGE</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control <?php echo ($arrdata['WK_IN']!="")?"focus":""; ?>" value="<?php echo $arrdata['WK_IN']; ?>">
                  <div class="hint">DISCHARGE</div>
                </div>
              </div>
            </div>
          </div>
        </form>
          </div>
        </div>
      </div>
      <div class="panel">
        <div class="panel-heading" id="exampleHeadingContinuousTwo" role="tab">
          <a class="panel-title collapsed" data-parent="#exampleAccordionContinuous" data-toggle="collapse"
          href="#exampleCollapseContinuousTwo" aria-controls="exampleCollapseContinuousTwo"
          aria-expanded="false">
          GATE OUT
        </a>
        </div>
        <div class="panel-collapse collapse in" id="exampleCollapseContinuousTwo" aria-labelledby="exampleHeadingContinuousTwo" role="tabpanel">
          <div class="panel-body">
          	<form name="form_cont" id="form_cont" class="form-horizontal" role="form" action="<?php echo site_url('execute/process/'.$action.'/kontainer_out/'.$id); ?>" method="post" autocomplete="off" onsubmit="save_post('form_cont','divtblkontainer'); return false;" popup="1">
              <div class="panel-body container-fluid">
                <div class="row">
                  <div class="form-group form-material">
                    <label class="col-sm-3 control-label">STATUS KONTAINER</label>
                    <div class="col-sm-9">
                      <?php echo form_dropdown('DATA[KD_CONT_STATUS_OUT]',$arr_status,$arrdata['KD_CONT_STATUS_OUT'],'id="KD_CONT_STATUS_OUT" mandatory="yes" class="form-control"'); ?>
                      <div class="hint">STATUS KONTAINER</div>
                    </div>
                  </div>
                  <div class="form-group form-material">
                    <label class="col-sm-3 control-label">JENIS DOKUMEN</label>
                    <div class="col-sm-8">
                      <input type="hidden" name="DATA[KD_DOK_OUT]" id="KD_DOK_OUT" class="form-control" mandatory="yes" value="<?php echo $arrdata['KD_DOK_OUT']; ?>" readonly="readonly">
                      <input type="text" name="JENIS_DOK_OUT" id="JENIS_DOK_OUT" class="form-control" mandatory="yes" placeholder="JENIS DOKUMEN" value="<?php echo $arrdata['DOK_OUT']; ?>">
                      <div class="hint">JENIS DOKUMEN</div>
                    </div>
                    <div class="col-sm-1">
                      <button type="button" class="btn btn-primary btn-sm" onclick="popup_searchtwo('popup/popup_search/mst_dokbc|IMP/KD_DOK_OUT|JENIS_DOK_OUT/2');"><span class="icon md-search"></span></button>
                    </div>
                  </div>
                  <div class="form-group form-material">
                    <label class="col-sm-3 control-label">DOKUMEN</label>
                    <div class="col-sm-5">
                      <input type="text" name="DATA[NO_DOK_OUT]" id="NO_DOK_OUT" class="form-control" mandatory="yes" placeholder="NOMOR DOKUMEN" value="<?php echo $arrdata['NO_DOK_OUT']; ?>">
                      <div class="hint">NOMOR DOKUMEN</div>
                    </div>
                    <div class="col-sm-4">
                      <input type="text" name="DATA[TGL_DOK_OUT]" id="TGL_DOK_OUT" class="form-control date" mandatory="yes" placeholder="TANGGAL DOKUMEN" value="<?php echo $arrdata['TGL_DOK_OUT']; ?>" maxlength="10">
                      <div class="hint">TANGGAL DOKUMEN</div>
                    </div>
                  </div>
                  <div class="form-group form-material">
                    <label class="col-sm-3 control-label">SARANA ANGKUT</label>
                    <div class="col-sm-5">
                      <?php echo form_dropdown('DATA[KD_SARANA_ANGKUT_OUT]',$arr_angkut,$arrdata['KD_SARANA_ANGKUT_OUT'],'id="KD_SARANA_ANGKUT_OUT" mandatory="yes" class="form-control"'); ?>
                      <div class="hint">SARANA ANGKUT</div>
                    </div>
                    <div class="col-sm-4">
                      <input type="text" name="DATA[NO_POL_OUT]" id="NO_POL_OUT" class="form-control" mandatory="yes" placeholder="NOMOR POLISI" value="<?php echo $arrdata['NO_POL_OUT']; ?>">
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
                    <label class="col-sm-3 control-label">SEGEL BC</label>
                    <div class="col-sm-5">
                      <input type="text" name="DATA[NO_SEGEL_BC]" id="NO_SEGEL_BC" class="form-control" mandatory="yes" placeholder="NOMOR SEGEL BC" value="<?php echo $arrdata['NO_SEGEL_BC']; ?>">
                      <div class="hint">NOMOR SEGEL BC</div>
                    </div>
                    <div class="col-sm-4">
                      <input type="text" name="DATA[TGL_SEGEL_BC]" id="TGL_SEGEL_BC" class="form-control date" mandatory="yes" placeholder="TANGGAL SEGEL BC" value="<?php echo $arrdata['TGL_SEGEL_BC']; ?>" maxlength="10">
                      <div class="hint">TANGGAL SEGEL BC</div>
                    </div>
                  </div>
                  <div class="form-group form-material">
                    <label class="col-sm-3 control-label">GUDANG TUJUAN</label>
                    <div class="col-sm-9">
                      <input type="text" name="DATA[KD_GUDANG_TUJUAN]" id="KD_GUDANG_TUJUAN" class="form-control" placeholder="KODE GUDANG TUJUAN" value="<?php echo $arrdata['KD_GUDANG_TUJUAN']; ?>" maxlength="10">
                      <div class="hint">KODE GUDANG TUJUAN</div>
                    </div>
                  </div>
                  <div class="form-group form-material">
                    <label class="col-sm-3 control-label">GATE OUT</label>
                    <div class="col-sm-9">
                      <input class="form-control datetime" type="text" placeholder="GATE OUT" name="DATA[WK_OUT]" id="WK_OUT" mandatory="yes" value="<?php echo $arrdata['WK_OUT']; ?>">
                      <div class="hint">GATE OUT</div>
                    </div>
                  </div>
                </div>
              </div>
              <input type="hidden" name="action" id="action" value="<?php echo site_url('codeco/gateout_kontainer/post/'.$post); ?>" readonly="readonly"/>
            </form>
          </div>
        </div>
      </div>
  </div>
</div>
<script>
$(function(){
	date('date');
	datetime('datetime');
	autocomplete('JENIS_DOK_OUT','/popup/autocomplete/mst_dok_bc/imp',function(event, ui){
		$('#KD_DOK_OUT').val(ui.item.KODE);
	});
});
</script>