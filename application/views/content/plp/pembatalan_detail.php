<div class="panel">
  <div class="panel-group panel-group-continuous" id="AccordionContinuous" aria-multiselectable="true" role="tablist">
    <div class="panel">
<!--      <div class="panel-heading" id="HeadingContinuousOne" role="tab"> <a class="panel-title" data-parent="#AccordionContinuous" data-toggle="collapse" href="#CollapseContinuousOne" aria-controls="CollapseContinuousOne" aria-expanded="false"><i class="icon glyphicon glyphicon-download margin-0" aria-hidden="true"></i> RESPONS PLP</a></div> -->
      <div class="panel-collapse collapse" id="CollapseContinuousOne" aria-labelledby="HeadingContinuousOne" role="tabpanel">
        <div class="panel-body">
            <div class="panel">
              <div class="ribbon ribbon-clip ribbon-primary"> <span class="ribbon-inner">RESPONS PLP</span></div>
              <div>&nbsp;</div>
              <div class="panel-body container-fluid">
                <div class="row">
                  <div class="col-sm-12">
                    <form class="form-horizontal" role="form" autocomplete="off">
                      <div class="panel-body container-fluid">
                        <div class="row">
                          <div class="form-group form-material">
                            <label class="col-sm-3 control-label">SURAT PLP</label>
                            <div class="col-sm-6">
                              <input type="text" class="form-control <?php echo ($arrdata['NO_PLP']!="")?"focus":""; ?>" value="<?php echo $arrdata['NO_PLP']; ?>" readonly="readonly">
                              <div class="hint">NO. PLP</div>
                            </div>
                            <div class="col-sm-3">
                              <input type="text" class="form-control <?php echo ($arrdata['TGL_PLP']!="")?"focus":""; ?>" value="<?php echo $arrdata['TGL_PLP']; ?>" readonly="readonly">
                              <div class="hint">TGL. PLP</div>
                            </div>
                          </div>
                          <div class="form-group form-material">
                            <label class="col-sm-3 control-label">KPBC</label>
                            <div class="col-sm-3">
                              <input type="text" class="form-control <?php echo ($arrdata['KD_KPBC']!="")?"focus":""; ?>" value="<?php echo $arrdata['KD_KPBC']; ?>" readonly="readonly">
                              <div class="hint">KODE KPBC</div>
                            </div>
                            <div class="col-sm-6">
                              <input type="text" class="form-control <?php echo ($arrdata['KPBC']!="")?"focus":""; ?>" value="<?php echo $arrdata['KPBC']; ?>" readonly="readonly">
                              <div class="hint">NAMA KPBC</div>
                            </div>
                          </div>
                          <div class="form-group form-material">
                            <label class="col-sm-3 control-label">ALASAN REJECT</label>
                            <div class="col-sm-9">
                              <textarea class="form-control <?php echo ($arrdata['ALASAN_REJECT']!="")?"focus":""; ?>"><?php echo $arrdata['ALASAN_REJECT']; ?></textarea>
                              <div class="hint">ALASAN REJECT</div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
                <?php echo $table_respon_kontainer; ?>
              </div>
            </div>
        </div>
      </div>
    </div>
    <div class="panel">
      <div class="panel-heading" id="HeadingContinuousTwo" role="tab"><a class="panel-title collapsed" data-parent="#AccordionContinuous" data-toggle="collapse" href="#CollapseContinuousTwo" aria-controls="CollapseContinuousTwo" aria-expanded="true"> <i class="icon glyphicon glyphicon-upload margin-0" aria-hidden="true"></i>PENGAJUAN BATAL PLP</a></div>
      <div class="panel-collapse collapse in" id="CollapseContinuousTwo" aria-labelledby="HeadingContinuousTwo" role="tabpanel">
        <div class="panel-body container-fluid">
          <div class="panel">
            <div class="ribbon ribbon-clip ribbon-primary"><span class="ribbon-inner">PENGAJUAN BATAL PLP</span> </div>
            <div>&nbsp;</div>
            <div class="panel-body container-fluid">
              <div class="row">
                <div class="col-sm-12">
                  <form name="form_data" id="form_data" class="form-horizontal" role="form" action="<?php echo site_url('execute/process/'.$action.'/pembatalan_plp/'.$id); ?>" method="post" autocomplete="off">
                    <div class="panel-body container-fluid">
                      <div class="row">
                        <div class="form-group form-material">
                          <label class="col-sm-3 control-label">SURAT PEMBATALAN PLP</label>
                          <div class="col-sm-6">
                            <input type="text" class="form-control <?php echo ($arrdata['NO_SURAT']!="")?"focus":""; ?>" value="<?php echo $arrdata['NO_SURAT']; ?>" readonly="readonly">
                            <div class="hint">NOMOR SURAT PEMBATALAN</div>
                          </div>
                          <div class="col-sm-3">
                            <input type="text" class="form-control <?php echo ($arrdata['TGL_SURAT']!="")?"focus":""; ?>" value="<?php echo $arrdata['TGL_SURAT']; ?>" readonly="readonly">
                            <div class="hint">TANGGAL SURAT PEMBATALAN</div>
                          </div>
                        </div>
                        <div class="form-group form-material">
                          <label class="col-sm-3 control-label">ALASAN PEMBATALAN</label>
                          <div class="col-sm-9">
                            <textarea class="form-control <?php echo ($arrdata['ALASAN']!="")?"focus":""; ?>" readonly="readonly"><?php echo $arrdata['ALASAN']; ?></textarea>
                            <div class="hint">ALASAN PEMBATALAN</div>
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
               <?php echo $table_pembatalan_kontainer; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>