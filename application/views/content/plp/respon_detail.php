<div class="panel">
  <div class="panel-group panel-group-continuous" id="AccordionContinuous" aria-multiselectable="true" role="tablist">
    <div class="panel">
      <div class="panel-heading" id="HeadingContinuous" role="tab"> <a class="panel-title collapsed" data-parent="#AccordionContinuous" data-toggle="collapse" href="#CollapseContinuous" aria-controls="CollapseContinuous" aria-expanded="true"> <i class="icon glyphicon glyphicon-upload margin-0" aria-hidden="true"></i> RESPONS PLP</a> </a> </div>
      <div class="panel-collapse collapse in" id="CollapseContinuous" aria-labelledby="HeadingContinuous" role="tabpanel">
        <div class="panel-body container-fluid">
          <div class="panel">
            <div class="ribbon ribbon-clip ribbon-primary"><span class="ribbon-inner">RESPONS PLP</span></div>
            <div>&nbsp;</div>
            <div>&nbsp;</div>
            <div class="panel-body container-fluid">
              <div class="row">
                <div class="col-sm-12">
                  <form class="form-horizontal" role="form" autocomplete="off">
                    <div class="panel-body container-fluid">
                      <div class="row">
                        <div class="form-group form-material">
                          <label class="col-sm-3 control-label">NOMOR PLP</label>
                          <div class="col-sm-6">
                            <input type="text" class="form-control <?php echo ($arrdata['NO_PLP']!="")?"focus":""; ?>" value="<?php echo $arrdata['NO_PLP']; ?>" readonly="readonly">
                            <div class="hint">NOMOR PLP</div>
                          </div>
                          <div class="col-sm-3">
                            <input type="text" class="form-control <?php echo ($arrdata['TGL_PLP']!="")?"focus":""; ?>" value="<?php echo $arrdata['TGL_PLP']; ?>" readonly="readonly">
                            <div class="hint">TANGGAL PLP</div>
                          </div>
                        </div>
                        <div class="form-group form-material">
                          <label class="col-sm-3 control-label">KPBC</label>
                          <div class="col-sm-2">
                            <input type="text" class="form-control <?php echo ($arrdata['KD_KPBC']!="")?"focus":""; ?>" value="<?php echo $arrdata['KD_KPBC']; ?>" readonly="readonly">
                            <div class="hint">KODE KPBC</div>
                          </div>
                          <div class="col-sm-7">
                            <input type="text" class="form-control <?php echo ($arrdata['KPBC']!="")?"focus":""; ?>" value="<?php echo $arrdata['KPBC']; ?>" readonly="readonly">
                            <div class="hint">NAMA KPBC</div>
                          </div>
                        </div>
                        <div class="form-group form-material">
                          <label class="col-sm-3 control-label">ALASAN REJECT</label>
                          <div class="col-sm-9">
                            <textarea class="form-control <?php echo ($arrdata['ALASAN_REJECT']!="")?"focus":""; ?>" readonly="readonly"><?php echo $arrdata['ALASAN_REJECT']; ?></textarea>
                            <div class="hint">ALASAN REJECT</div>
                          </div>
                        </div>
                        <div class="form-group form-material">
                          <label class="col-sm-3 control-label">REF NUMBER</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control <?php echo ($arrdata['REF_NUMBER']!="")?"focus":""; ?>" value="<?php echo $arrdata['REF_NUMBER']; ?>" readonly="readonly">
                            <div class="hint">REF NUMBER</div>
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
