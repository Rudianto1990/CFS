<div class="panel">
  <div class="ribbon ribbon-clip ribbon-primary">
  	<span class="ribbon-inner">
		<i class="icon md-view-list margin-0" aria-hidden="true"></i>DETAIL RESPON DOKUMEN IMPOR <?php //echo $title; ?>
    </span>
  </div>
  <div>&nbsp;</div>
  <div class="panel-group panel-group-continuous" id="AccordionContinuous" aria-multiselectable="true" role="tablist">
      <div class="panel">
        <div class="panel-heading" id="HeadingContinuousOne" role="tab">
          <a class="panel-title" data-parent="#AccordionContinuous" data-toggle="collapse" href="#CollapseContinuousOne" aria-controls="CollapseContinuousOne" aria-expanded="true">
          	<i class="icon md-view-dashboard margin-0" aria-hidden="true"></i> HEADER
          </a>
        </div>
        <div class="panel-collapse collapse in" id="CollapseContinuousOne" aria-labelledby="HeadingContinuousOne" role="tabpanel">
          <div class="panel-body">
            <form name="form_data" id="form_data" class="form-horizontal" role="form" method="post" autocomplete="off" onsubmit="save_post('form_data','divtbldischarge'); return false;" popup="1">
            <div class="panel-body container-fluid">
                <div class="row">
                   <div class="form-group form-material">
                    <label class="col-sm-3 control-label">CAR</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control focus" value="<?php echo $arrdata['CAR']; ?>" readonly="readonly">
                      <div class="hint">CAR</div>
                    </div>
                  </div>
                  <div class="form-group form-material">
                    <label class="col-sm-3 control-label">JENIS DOKUMEN</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control focus" value="<?php echo $arrdata['JENIS_DOK']; ?>" readonly="readonly">
                      <div class="hint">JENIS DOKUMEN</div>
                    </div>
                  </div>
                  <div class="form-group form-material">
                    <label class="col-sm-3 control-label">DOKUMEN</label>
                    <div class="col-sm-6">
                      <input type="text" class="form-control focus" value="<?php echo $arrdata['NO_DOK_INOUT']; ?>" readonly="readonly">
                      <div class="hint">NOMOR DOKUMEN</div>
                    </div>
                    <div class="col-sm-3">
                      <input type="text" class="form-control focus" value="<?php echo validate(date_input($arrdata['TGL_DOK_INOUT'])); ?>" readonly="readonly">
                      <div class="hint">TANGGAL DOKUMEN</div>
                    </div>
                  </div>
                  <div class="form-group form-material">
                    <label class="col-sm-3 control-label">DAFTAR PABEAN</label>
                    <div class="col-sm-6">
                      <input type="text" class="form-control focus" value="<?php echo $arrdata['NO_DAFTAR_PABEAN']; ?>" readonly="readonly">
                      <div class="hint">NOMOR DAFTAR PABEAN</div>
                    </div>
                    <div class="col-sm-3">
                      <input type="text" class="form-control focus" value="<?php echo validate(date_input($arrdata['TGL_DAFTAR_PABEAN'])); ?>" readonly="readonly">
                      <div class="hint">TANGGAL DAFTAR PABEAN</div>
                    </div>
                  </div>
                  <div class="form-group form-material">
                    <label class="col-sm-3 control-label">CONSIGNEE</label>
                    <div class="col-sm-3">
                      <input type="text" class="form-control focus" value="<?php echo $arrdata['NPWP_CONSIGNEE']; ?>" readonly="readonly">
                      <div class="hint">IDENTITAS CONSIGNEE</div>
                    </div>
                    <div class="col-sm-6">
                      <input type="text" class="form-control focus" value="<?php echo $arrdata['NM_CONSIGNEE']; ?>" readonly="readonly">
                      <div class="hint">NAMA CONSIGNEE</div>
                    </div>
                  </div>
                  <div class="form-group form-material">
                    <label class="col-sm-3 control-label">ALAMAT CONSIGNEE</label>
                    <div class="col-sm-9">
                      <textarea class="form-control focus" readonly="readonly"><?php echo $arrdata['ALAMAT_CONSIGNEE']; ?></textarea>
                      <div class="hint">ALAMAT CONSIGNEE</div>
                    </div>
                  </div>
                  <div class="form-group form-material">
                    <label class="col-sm-3 control-label">PPJK</label>
                    <div class="col-sm-3">
                      <input type="text" class="form-control focus" value="<?php echo $arrdata['NPWP_PPJK']; ?>" readonly="readonly">
                      <div class="hint">IDENTITAS PPJK</div>
                    </div>
                    <div class="col-sm-6">
                      <input type="text" class="form-control focus" value="<?php echo $arrdata['NAMA_PPJK']; ?>" readonly="readonly">
                      <div class="hint">NAMA PPJK</div>
                    </div>
                  </div>
                  <div class="form-group form-material">
                    <label class="col-sm-3 control-label">ALAMAT PPJK</label>
                    <div class="col-sm-9">
                      <textarea class="form-control focus" readonly="readonly"><?php echo $arrdata['ALAMAT_PPJK']; ?></textarea>
                      <div class="hint">ALAMAT PPJK</div>
                    </div>
                  </div>
                  <div class="form-group form-material">
                    <label class="col-sm-3 control-label">NAMA ANGKUT</label>
                    <div class="col-sm-6">
                      <input type="text" class="form-control focus" value="<?php echo $arrdata['NM_ANGKUT']; ?>" readonly="readonly">
                      <div class="hint">NAMA ANGKUT</div>
                    </div>
                    <div class="col-sm-3">
                      <input type="text" class="form-control focus" value="<?php echo $arrdata['NO_VOY_FLIGHT']; ?>" readonly="readonly">
                      <div class="hint">NOMOR VOYAGE</div>
                    </div>
                  </div>
                  <div class="form-group form-material">
                    <label class="col-sm-3 control-label">GUDANG</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control focus" value="<?php echo $arrdata['GUDANG']; ?>" readonly="readonly">
                      <div class="hint">NAMA GUDANG</div>
                    </div>
                  </div>
                  <div class="form-group form-material">
                    <label class="col-sm-3 control-label">JUMLAH</label>
                    <div class="col-sm-3">
                      <input type="text" class="form-control focus" value="<?php echo $arrdata['JML_CONT']; ?>" readonly="readonly">
                      <div class="hint">JUMLAH KONTAINER</div>
                    </div>
                    <div class="col-sm-3">
                      <input type="text" class="form-control focus" value="<?php echo $arrdata['BRUTO']; ?>" readonly="readonly">
                      <div class="hint">BRUTO</div>
                    </div>
                    <div class="col-sm-3">
                      <input type="text" class="form-control focus" value="<?php echo $arrdata['NETTO']; ?>" readonly="readonly">
                      <div class="hint">NETTO</div>
                    </div>
                  </div>
                  <div class="form-group form-material">
                    <label class="col-sm-3 control-label">BC11</label>
                    <div class="col-sm-6">
                      <input type="text" class="form-control focus" value="<?php echo $arrdata['NO_BC11']; ?>" readonly="readonly">
                      <div class="hint">NOMOR BC11</div>
                    </div>
                    <div class="col-sm-3">
                      <input type="text" class="form-control focus" value="<?php echo validate(date_input($arrdata['TGL_BC11'])); ?>" readonly="readonly">
                      <div class="hint">TANGGAL BC11</div>
                    </div>
                  </div>
                  <div class="form-group form-material">
                    <label class="col-sm-3 control-label">POS BC11</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control focus" value="<?php echo $arrdata['NO_POS_BC11']; ?>" readonly="readonly">
                      <div class="hint">NOMOR POS BC11</div>
                    </div>
                  </div>
                  <div class="form-group form-material">
                    <label class="col-sm-3 control-label">MASTER BL/AWB</label>
                    <div class="col-sm-6">
                      <input type="text" class="form-control focus" value="<?php echo $arrdata['NO_MASTER_BL_AWB']; ?>" readonly="readonly">
                      <div class="hint">NOMOR MASTER BL/AWB</div>
                    </div>
                    <div class="col-sm-3">
                      <input type="text" class="form-control focus" value="<?php echo validate(date_input($arrdata['TGL_MASTER_BL_AWB'])); ?>" readonly="readonly">
                      <div class="hint">TANGGAL MASTER BL/AWB</div>
                    </div>
                  </div>
                  <div class="form-group form-material">
                    <label class="col-sm-3 control-label">BL/AWB</label>
                    <div class="col-sm-6">
                      <input type="text" class="form-control focus" value="<?php echo $arrdata['NO_BL_AWB']; ?>" readonly="readonly">
                      <div class="hint">NOMOR BL/AWB</div>
                    </div>
                    <div class="col-sm-3">
                      <input type="text" class="form-control focus" value="<?php echo validate(date_input($arrdata['TGL_BL_AWB'])); ?>" readonly="readonly">
                      <div class="hint">TANGGAL BL/AWB</div>
                    </div>
                  </div>
                  <div class="form-group form-material">
                    <label class="col-sm-3 control-label">WAKTU REKAM</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control focus" value="<?php echo validate(date_input($arrdata['TGL_STATUS'])); ?>" readonly="readonly">
                      <div class="hint">WAKTU REKAM</div>
                    </div>
                  </div>
                </div>
            </div>
            </form>
          </div>
        </div>
      </div>
      <div class="panel">
        <div class="panel-heading" id="HeadingContinuousTwo" role="tab">
          <a class="panel-title collapsed" data-parent="#AccordionContinuous" data-toggle="collapse" href="#CollapseContinuousTwo" aria-controls="CollapseContinuousTwo" aria-expanded="false">
          <i class="icon md-view-headline margin-0" aria-hidden="true"></i> DETAIL</a>
        </a>
        </div>
        <div class="panel-collapse collapse" id="CollapseContinuousTwo" aria-labelledby="HeadingContinuousTwo" role="tabpanel">
          <div class="panel-body container-fluid">
          	<?php echo $table_detail; ?>
          </div>
          <div class="panel-body container-fluid">
          	<?php echo $table_kms_detail; ?>
          </div>
        </div>
      </div>
  </div>
</div>
