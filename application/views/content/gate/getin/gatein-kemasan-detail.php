<div class="panel">
  <div class="ribbon ribbon-clip ribbon-primary">
  	<span class="ribbon-inner">
		<i class="icon md-view-list margin-0" aria-hidden="true"></i> <?php echo $title; ?>
    </span>
  </div>
  <div class="panel-body container-fluid">
    <div class="row">
      <div class="col-sm-12">
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
              <div class="form-group form-material">
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
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">GATE IN</label>
                <div class="col-sm-9">
                  <input class="form-control focus" type="text" value="<?php echo $arrdata['WK_IN']; ?>" readonly="readonly">
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