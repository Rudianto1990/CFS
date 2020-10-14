<div class="panel">
  <div class="panel-group panel-group-continuous" id="AccordionContinuous" aria-multiselectable="true" role="tablist">
    <div class="panel">
   <!--   <div class="panel-heading" id="HeadingContinuousOne" role="tab"> <a class="panel-title" data-parent="#AccordionContinuous" data-toggle="collapse" href="#CollapseContinuousOne" aria-controls="CollapseContinuousOne" aria-expanded="false"> <i class="icon fa fa-ship margin-0" aria-hidden="true"></i> DISCHARGE</a> </div> -->
      <div class="panel-collapse collapse" id="CollapseContinuousOne" aria-labelledby="HeadingContinuousOne" role="tabpanel">
        <div class="panel-body">
            <div class="panel">
             <div class="panel-body container-fluid">
                <div class="row">
                  <div class="col-sm-12">
                    <form class="form-horizontal" role="form" autocomplete="off">
                      <div class="panel-body container-fluid">
                        <div class="row">
                          <div class="form-group form-material">
                            <label class="col-sm-3 control-label">KAPAL</label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control <?php echo ($arrdata['NM_ANGKUT']!="")?"focus":""; ?>" value="<?php echo $arrdata['NM_ANGKUT']; ?>" readonly="readonly">
                              <div class="hint">NAMA KAPAL</div>
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
                              <input type="text" class="form-control <?php echo ($arrdata['KD_PEL_BONGKAR']!="")?"focus":""; ?>" mandatory="yes" value="<?php echo $arrdata['KD_PEL_BONGKAR']; ?>" readonly="readonly">
                              <div class="hint">KODE PELABUHAN</div>
                            </div>
                            <div class="col-sm-7">
                              <input type="text" class="form-control <?php echo ($arrdata['PEL_BONGKAR']!="")?"focus":""; ?>" mandatory="yes" value="<?php echo $arrdata['PEL_BONGKAR']; ?>" readonly="readonly">
                              <div class="hint">NAMA PELABUHAN</div>
                            </div>
                          </div>
                          <div class="form-group form-material">
                            <label class="col-sm-3 control-label">VOYAGE</label>
                            <div class="col-sm-9">
                              <input type="text" mandatory="yes" class="form-control <?php echo ($arrdata['NO_VOY_FLIGHT']!="")?"focus":""; ?>" value="<?php echo $arrdata['NO_VOY_FLIGHT']; ?>" readonly="readonly">
                              <div class="hint">NOMOR VOYAGE</div>
                            </div>
                          </div>
                          <div class="form-group form-material">
                            <label class="col-sm-3 control-label">TANGGAL TIBA</label>
                            <div class="col-sm-9">
                              <input class="form-control <?php echo ($arrdata['TGL_TIBA']!="")?"focus":""; ?>" type="text" value="<?php echo $arrdata['TGL_TIBA']; ?>" readonly="readonly">
                              <div class="hint">TANGGAL TIBA</div>
                            </div>
                          </div>
                          <div class="form-group form-material">
                            <label class="col-sm-3 control-label">BC11</label>
                            <div class="col-sm-5">
                              <input type="text" class="form-control <?php echo ($arrdata['NO_BC11']!="")?"focus":""; ?>" value="<?php echo $arrdata['NO_BC11']; ?>" maxlength="10" readonly="readonly">
                              <div class="hint">NOMOR BC11</div>
                            </div>
                            <div class="col-sm-4">
                              <input type="text" class="form-control <?php echo ($arrdata['TGL_BC11']!="")?"focus":""; ?>" value="<?php echo $arrdata['TGL_BC11']; ?>" readonly="readonly">
                              <div class="hint">TANGGAL BC11</div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
        </div>
      </div>
    </div>
    <div class="panel">
      <div class="panel-heading" id="HeadingContinuousTwo" role="tab"> <a class="panel-title collapsed" data-parent="#AccordionContinuous" data-toggle="collapse" href="#CollapseContinuousTwo" aria-controls="CollapseContinuousTwo" aria-expanded="true"> <i class="icon glyphicon glyphicon-edit margin-0" aria-hidden="true"></i> PENGAJUAN PLP</a></div>
      <div class="panel-collapse collapse in" id="CollapseContinuousTwo" aria-labelledby="HeadingContinuousTwo" role="tabpanel">
        <div class="panel-body container-fluid">
          <div class="panel">
            <div class="panel-body container-fluid">
              <div class="row">
                <div class="col-sm-12">
                  <form class="form-horizontal" role="form" autocomplete="off">
                    <div class="panel-body container-fluid">
                      <div class="row">
                        <div class="form-group form-material">
                          <label class="col-sm-3 control-label">SURAT PLP</label>
                          <div class="col-sm-6">
                            <input type="text" class="form-control <?php echo ($arrdata['NO_SURAT']!="")?"focus":""; ?>" value="<?php echo $arrdata['NO_SURAT']; ?>" readonly="readonly">
                            <div class="hint">NOMOR SURAT</div>
                          </div>
                          <div class="col-sm-3">
                            <input type="text" class="form-control <?php echo ($arrdata['TGL_SURAT']!="")?"focus":""; ?>" value="<?php echo $arrdata['TGL_SURAT']; ?>" readonly="readonly">
                            <div class="hint">TANGGAL SURAT</div>
                          </div>
                        </div>
                        <div class="form-group form-material">
                          <label class="col-sm-3 control-label">GUDANG TUJUAN</label>
                          <div class="col-sm-2">
                            <input type="text" class="form-control <?php echo ($arrdata['KD_GUDANG_TUJUAN']!="")?"focus":""; ?>" value="<?php echo $arrdata['KD_GUDANG_TUJUAN']; ?>" readonly="readonly">
                            <div class="hint">KODE GUDANG</div>
                          </div>
                          <div class="col-sm-7">
                            <input type="text" class="form-control <?php echo ($arrdata['GUDANG_TUJUAN']!="")?"focus":""; ?>" value="<?php echo $arrdata['GUDANG_TUJUAN']; ?>" readonly="readonly">
                            <div class="hint">NAMA GUDANG</div>
                          </div>
                        </div>
                        <div class="form-group form-material">
                          <label class="col-sm-3 control-label">YOR ASAL</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control <?php echo ($arrdata['YOR_ASAL']!="")?"focus":""; ?>" value="<?php echo $arrdata['YOR_ASAL']; ?>" readonly="readonly">
                            <div class="hint">YOR ASAL</div>
                          </div>
                        </div>
                        <div class="form-group form-material">
                          <label class="col-sm-3 control-label">YOR TUJUAN</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control <?php echo ($arrdata['YOR_TUJUAN']!="")?"focus":""; ?>" value="<?php echo $arrdata['YOR_TUJUAN']; ?>" readonly="readonly">
                            <div class="hint">YOR TUJUAN</div>
                          </div>
                        </div>
                        <div class="form-group form-material">
                          <label class="col-sm-3 control-label">ALASAN PLP</label>
                          <div class="col-sm-9">
                            <textarea class="form-control <?php echo ($arrdata['ALASAN_PLP']!="")?"focus":""; ?>" readonly="readonly"><?php echo $arrdata['ALASAN_PLP']; ?></textarea>
                            <div class="hint">ALASAN PLP</div>
                          </div>
                        </div>
                        <div class="form-group form-material">
                          <label class="col-sm-3 control-label">NAMA PEMOHON</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control <?php echo ($arrdata['NM_PEMOHON']!="")?"focus":""; ?>" value="<?php echo $arrdata['NM_PEMOHON']; ?>" readonly="readonly">
                            <div class="hint">NAMA PEMOHON</div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
               <?php echo $table_kontainer; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
