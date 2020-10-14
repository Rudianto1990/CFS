<div class="panel">
  <div class="panel-group panel-group-continuous" id="exampleAccordionContinuous" aria-multiselectable="true" role="tablist">
    <div class="panel">
      <div class="panel-heading" id="exampleHeadingContinuousOne" role="tab"> <a class="panel-title" data-parent="#exampleAccordionContinuous" data-toggle="collapse" href="#exampleCollapseContinuousOne" aria-controls="exampleCollapseContinuousOne" aria-expanded="false"> <i class="icon md-email-open margin-0" aria-hidden="true"></i> RESPONS PLP</a></div>
      <div class="panel-collapse collapse" id="exampleCollapseContinuousOne" aria-labelledby="exampleHeadingContinuousOne" role="tabpanel">
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
      <div class="panel-heading" id="exampleHeadingContinuousTwo" role="tab"><a class="panel-title collapsed" data-parent="#exampleAccordionContinuous" data-toggle="collapse" href="#exampleCollapseContinuousTwo" aria-controls="exampleCollapseContinuousTwo" aria-expanded="true"> <i class="icon md-comment-edit margin-0" aria-hidden="true"></i> PEMBATALAN PLP</a></div>
      <div class="panel-collapse collapse in" id="exampleCollapseContinuousTwo" aria-labelledby="exampleHeadingContinuousTwo" role="tabpanel">
        <div class="panel-body container-fluid">
          <div class="panel">
            <div class="ribbon ribbon-clip ribbon-primary"><span class="ribbon-inner">PEMBATALAN PLP</span> </div>
            <button type="submit" class="btn btn-sm btn-primary navbar-right navbar-btn waves-effect waves-light" onclick="save_multiple_post('form_data|tblresponplpkontainer'); return false;"> <i class="icon md-badge-check"></i> SAVE </button>
            <div class="panel-body container-fluid">
              <div class="row">
                <div class="col-sm-12">
                  <form name="form_data" id="form_data" class="form-horizontal" role="form" action="<?php echo site_url('execute/process/'.$action.'/pembatalan_plp/'.$id); ?>" method="post" autocomplete="off">
                    <div class="panel-body container-fluid">
                      <div class="row">
                        <div class="form-group form-material">
                          <label class="col-sm-3 control-label">SURAT PEMBATALAN PLP</label>
                          <div class="col-sm-6">
                            <input type="text" class="form-control" name="DATA[NO_SURAT]" id="NO_SURAT" mandatory="yes" placeholder="NOMOR SURAT" value="<?php echo $arrdata['NO_SURAT']; ?>">
                            <div class="hint">NOMOR SURAT PEMBATALAN</div>
                          </div>
                          <div class="col-sm-3">
                            <input class="form-control date" type="text" placeholder="TANGGAL SURAT" name="DATA[TGL_SURAT]" id="TGL_SURAT" mandatory="yes" value="<?php echo $arrdata['TGL_SURAT']; ?>">
                            <div class="hint">TANGGAL SURAT PEMBATALAN</div>
                          </div>
                        </div>
                        <div class="form-group form-material">
                          <label class="col-sm-3 control-label">ALASAN PEMBATALAN</label>
                          <div class="col-sm-9">
                            <textarea name="DATA[ALASAN]" id="ALASAN" mandatory="yes" class="form-control" placeholder="ALASAN PEMBATALAN"><?php echo $arrdata['ALASAN']; ?></textarea>
                            <div class="hint">ALASAN PEMBATALAN</div>
                          </div>
                        </div>
                        <div class="form-group form-material">
                          <label class="col-sm-3 control-label">NAMA PEMOHON</label>
                          <div class="col-sm-9">
                            <input type="text" name="DATA[NM_PEMOHON]" id="NM_PEMOHON" mandatory="yes" class="form-control" placeholder="NAMA PEMOHON" value="<?php echo $arrdata['NM_PEMOHON']; ?>">
                            <div class="hint">NAMA PEMOHON</div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <input type="hidden" name="action" id="action" readonly="readonly" value="<?php echo site_url('plp/pembatalan'); ?>"/>
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