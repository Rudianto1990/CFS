<div class="panel">
  <div class="ribbon ribbon-clip ribbon-primary"> <span class="ribbon-inner"> <i class="icon md-view-list margin-0" aria-hidden="true"></i> <?php echo $title; ?> </span> </div>
  <button type="submit" class="btn btn-sm btn-primary navbar-right navbar-btn waves-effect waves-light" onclick="save_post('form_kms','divtblkemasan'); return false;"> <i class="icon md-badge-check"></i> SAVE </button>
  <div>&nbsp;</div>
  <div>&nbsp;</div>
  <div>&nbsp;</div>
  <div class="panel-group panel-group-continuous" id="exampleAccordionContinuous" aria-multiselectable="true" role="tablist">
    <div class="panel">
      <div class="panel-heading" id="exampleHeadingContinuousOne" role="tab"> <a class="panel-title" data-parent="#exampleAccordionContinuous" data-toggle="collapse" href="#exampleCollapseContinuousOne" aria-controls="exampleCollapseContinuousOne" aria-expanded="true"> DISCHARGE </a> </div>
      <div class="panel-collapse collapse" id="exampleCollapseContinuousOne" aria-labelledby="exampleHeadingContinuousOne" role="tabpanel">
        <div class="panel-body">
          <form class="form-horizontal" role="form" autocomplete="off" popup="1">
          <div class="panel-body container-fluid">
            <div class="row">
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">KONTAINER ASAL</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control <?php echo ($arrdata['NO_CONT_ASAL']!="")?"focus":""; ?>" value="<?php echo $arrdata['NO_CONT_ASAL']; ?>" readonly="readonly">
                  <div class="hint">NOMOR KONTAINER ASAL</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">KEMASAN</label>
                <div class="col-sm-3">
                  <input type="text" class="form-control <?php echo ($arrdata['KD_KEMASAN']!="")?"focus":""; ?>" value="<?php echo $arrdata['KD_KEMASAN']; ?>" readonly="readonly">
                  <div class="hint">KODE KEMASAN</div>
                </div>
                <div class="col-sm-6">
                  <input type="text" class="form-control <?php echo ($arrdata['KEMASAN']!="")?"focus":""; ?>" value="<?php echo $arrdata['KEMASAN']; ?>" readonly="readonly">
                  <div class="hint">NAMA KEMASAN</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">KOMODITI</label>
                <div class="col-sm-9">
                  <textarea class="form-control <?php echo ($arrdata['KOMODITI']!="")?"focus":""; ?>" readonly="readonly"><?php echo $arrdata['KOMODITI']; ?></textarea>
                  <div class="hint">KOMODITI</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">JUMLAH</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control <?php echo ($arrdata['JUMLAH']!="")?"focus":""; ?>" value="<?php echo $arrdata['JUMLAH']; ?>" readonly="readonly">
                  <div class="hint">JUMLAH</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">BRUTO</label>
                <div class="col-sm-5">
                  <input type="text" class="form-control <?php echo ($arrdata['BRUTO']!="")?"focus":""; ?>" value="<?php echo $arrdata['BRUTO']; ?>" readonly="readonly">
                  <div class="hint">BRUTO</div>
                </div>
                <div class="col-sm-4">
                  <input type="text" class="form-control <?php echo ($arrdata['CHARGE_BRUTO']!="")?"focus":""; ?>" value="<?php echo $arrdata['CHARGE_BRUTO']; ?>" readonly="readonly">
                  <div class="hint">CHARGE BRUTO</div>
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
                  <input type="text" class="form-control focus" value="<?php echo $arrdata['DOK_IN']; ?>" readonly="readonly">
                  <div class="hint">JENIS DOKUMEN</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">DOKUMEN</label>
                <div class="col-sm-5">
                  <input type="text" class="form-control focus" value="<?php echo $arrdata['NO_DOK_IN']; ?>" readonly="readonly">
                  <div class="hint">NOMOR DOKUMEN</div>
                </div>
                <div class="col-sm-4">
                  <input type="text" class="form-control focus" value="<?php echo $arrdata['TGL_DOK_IN']; ?>" readonly="readonly">
                  <div class="hint">TANGGAL DOKUMEN</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">SARANA ANGKUT</label>
                <div class="col-sm-5">
                  <input type="text" class="form-control focus" value="<?php echo $arrdata['SARANA_ANGKUT_IN']; ?>" readonly="readonly">
                  <div class="hint">SARANA ANGKUT</div>
                </div>
                <div class="col-sm-4">
                  <input type="text" class="form-control focus" value="<?php echo $arrdata['NO_POL_IN']; ?>" readonly="readonly">
                  <div class="hint">NOMOR POLISI</div>
                </div>
              </div><?php */?>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">DISCHARGE</label>
                <div class="col-sm-9">
                  <input class="form-control focus" type="text" value="<?php echo $arrdata['WK_IN']; ?>" readonly="readonly">
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
      <div class="panel-heading" id="exampleHeadingContinuousTwo" role="tab"> <a class="panel-title collapsed" data-parent="#exampleAccordionContinuous" data-toggle="collapse"
          href="#exampleCollapseContinuousTwo" aria-controls="exampleCollapseContinuousTwo"
          aria-expanded="false"> GATE OUT </a> </div>
      <div class="panel-collapse collapse in" id="exampleCollapseContinuousTwo" aria-labelledby="exampleHeadingContinuousTwo" role="tabpanel">
        <div class="panel-body">
          <form name="form_kms" id="form_kms" class="form-horizontal" role="form" action="<?php echo site_url('execute/process/'.$action.'/kemasan_out/'.$id); ?>" method="post" autocomplete="off" onsubmit="save_post('form_cont','divtblkemasan'); return false;" popup="1">
            <div class="panel-body container-fluid">
              <div class="row">
                <div class="form-group form-material">
                  <label class="col-sm-3 control-label">JENIS DOKUMEN</label>
                  <div class="col-sm-9">
                    <input type="hidden" name="DATA[KD_DOK_OUT]" id="KD_DOK_OUT" class="form-control" mandatory="yes" value="<?php echo $arrdata['KD_DOK_OUT']; ?>" readonly="readonly">
                    <input type="text" name="JENIS_DOK_OUT" id="JENIS_DOK_OUT" class="form-control" mandatory="yes" placeholder="JENIS DOKUMEN" value="<?php echo $arrdata['DOK_OUT']; ?>">
                    <div class="hint">JENIS DOKUMEN</div>
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
                  <div class="col-sm-5"> <?php echo form_dropdown('DATA[KD_SARANA_ANGKUT_OUT]',$arr_angkut,$arrdata['KD_SARANA_ANGKUT_OUT'],'id="KD_SARANA_ANGKUT_OUT" mandatory="yes" class="form-control"'); ?>
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
            <input type="hidden" name="action" id="action" value="<?php echo site_url('codeco/gateout_kemasan/post/'.$post); ?>" readonly="readonly"/>
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