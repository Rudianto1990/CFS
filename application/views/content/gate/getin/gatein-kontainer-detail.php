<div class="panel">
  <div class="ribbon ribbon-clip ribbon-primary">
  	<span class="ribbon-inner">
		<i class="icon md-view-list margin-0" aria-hidden="true"></i> <?php echo $title; ?>
    </span>
  </div>
  <div>&nbsp;</div>
  <div>&nbsp;</div>
  <div class="panel-body container-fluid">
    <div class="row">
      <div class="col-sm-12">
        <form name="form_cont" id="form_cont" class="form-horizontal" role="form" method="post" autocomplete="off" popup="1">
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
              <div class="form-group form-material">
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
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">DAFTAR PABEAN</label>
                <div class="col-sm-5">
                  <input type="text" class="form-control <?php echo ($arrdata['NO_DAFTAR_PABEAN']!="")?"focus":""; ?>" value="<?php echo $arrdata['NO_DAFTAR_PABEAN']; ?>">
                  <div class="hint">NOMOR DAFTAR PABEAN</div>
                </div>
                <div class="col-sm-4">
                  <input type="text" class="form-control <?php echo ($arrdata['TGL_DAFTAR_PABEAN']!="")?"focus":""; ?>" value="<?php echo $arrdata['TGL_DAFTAR_PABEAN']; ?>" maxlength="10">
                  <div class="hint">TANGGAL DAFTAR PABEAN</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">IJIN TPS</label>
                <div class="col-sm-5">
                  <input type="text" class="form-control <?php echo ($arrdata['NO_IJIN_TPS']!="")?"focus":""; ?>" value="<?php echo $arrdata['NO_IJIN_TPS']; ?>">
                  <div class="hint">NOMOR IJIN TPS</div>
                </div>
                <div class="col-sm-4">
                  <input type="text" class="form-control <?php echo ($arrdata['TGL_IJIN_TPS']!="")?"focus":""; ?>" value="<?php echo $arrdata['TGL_IJIN_TPS']; ?>" maxlength="10">
                  <div class="hint">TANGGAL IJIN TPS</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">GATE IN</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control <?php echo ($arrdata['WK_IN']!="")?"focus":""; ?>" value="<?php echo $arrdata['WK_IN']; ?>" readonly="readonly">
                  <div class="hint">GATE IN</div>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>