<div class="panel">
  <div class="panel-group panel-group-continuous" id="exampleAccordionContinuous" aria-multiselectable="true" role="tablist">
    <div class="panel">
      <div class="panel-heading" id="exampleHeadingContinuousOne" role="tab"><a class="panel-title" data-parent="#exampleAccordionContinuous" data-toggle="collapse" href="#exampleCollapseContinuousOne" aria-controls="exampleCollapseContinuousOne" aria-expanded="false"> <i class="icon md-boat margin-0" aria-hidden="true"></i> DISCHARGE</a></div>
      <div class="panel-collapse collapse" id="exampleCollapseContinuousOne" aria-labelledby="exampleHeadingContinuousOne" role="tabpanel">
        <div class="panel-body">
            <div class="panel">
              <div class="ribbon ribbon-clip ribbon-primary"> <span class="ribbon-inner">DISCHARGE</span></div>
              <div>&nbsp;</div>
              <div class="panel-body container-fluid">
                <div class="row">
                  <div class="col-sm-12">
                    <form class="form-horizontal" role="form" autocomplete="off">
                      <div class="panel-body container-fluid">
                        <div class="row">
                          <div class="form-group form-material">
                            <label class="col-sm-3 control-label">PESAWAT/KAPAL</label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control <?php echo ($arrdata['NM_ANGKUT']!="")?"focus":""; ?>" value="<?php echo $arrdata['NM_ANGKUT']; ?>" readonly="readonly">
                              <div class="hint">NAMA PESAWAT/KAPAL</div>
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
                            <label class="col-sm-3 control-label">VOYAGE/FLIGHT</label>
                            <div class="col-sm-9">
                              <input type="text" mandatory="yes" class="form-control <?php echo ($arrdata['NO_VOY_FLIGHT']!="")?"focus":""; ?>" value="<?php echo $arrdata['NO_VOY_FLIGHT']; ?>" readonly="readonly">
                              <div class="hint">NOMOR VOYAGE/FLIGHT</div>
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
      <div class="panel-heading" id="exampleHeadingContinuousTwo" role="tab"> <a class="panel-title collapsed" data-parent="#exampleAccordionContinuous" data-toggle="collapse" href="#exampleCollapseContinuousTwo" aria-controls="exampleCollapseContinuousTwo" aria-expanded="true"> <i class="icon md-comment-edit margin-0" aria-hidden="true"></i> PENGAJUAN PLP</a></div>
      <div class="panel-collapse collapse in" id="exampleCollapseContinuousTwo" aria-labelledby="exampleHeadingContinuousTwo" role="tabpanel">
        <div class="panel-body container-fluid">
          <div class="panel">
            <div class="ribbon ribbon-clip ribbon-primary"><span class="ribbon-inner"> PENGAJUAN PLP</span></div>
            <button type="submit" class="btn btn-sm btn-primary navbar-right navbar-btn waves-effect waves-light" onclick="save_multiple_post('form_data|tblkontainer'); return false;"> <i class="icon md-badge-check"></i> SAVE </button>
            <div class="panel-body container-fluid">
              <div class="row">
                <div class="col-sm-12">
                  <form name="form_data" id="form_data" class="form-horizontal" role="form" action="<?php echo site_url('execute/process/'.$action.'/pengajuan_plp/'.$id); ?>" method="post" autocomplete="off">
                    <div class="panel-body container-fluid">
                      <div class="row">
                        <div class="form-group form-material">
                          <label class="col-sm-3 control-label">SURAT PLP</label>
                          <div class="col-sm-6">
                            <input type="text" class="form-control" name="DATA[NO_SURAT]" id="NO_SURAT" mandatory="yes" placeholder="NOMOR"  value="<?php echo $arrdata['NO_SURAT']; ?>">
                            <div class="hint">NOMOR SURAT</div>
                          </div>
                          <div class="col-sm-3">
                            <input class="form-control date" type="text" placeholder="TANGGAL SURAT" name="DATA[TGL_SURAT]" id="TGL_SURAT" mandatory="yes" value="<?php echo $arrdata['TGL_SURAT']; ?>">
                            <div class="hint">TANGGAL SURAT</div>
                          </div>
                        </div>
                        <div class="form-group form-material">
                          <label class="col-sm-3 control-label">GUDANG TUJUAN</label>
                          <div class="col-sm-2">
                            <input type="hidden" name="DATA[KD_TPS_TUJUAN]" id="KD_TPS_TUJUAN" mandatory="yes" value="<?php echo $arrdata['KD_TPS_TUJUAN']; ?>" readonly="readonly">
                            <input type="text" name="DATA[KD_GUDANG_TUJUAN]" id="KD_GUDANG_TUJUAN" mandatory="yes" class="form-control focus" placeholder="KODE GUDANG TUJUAN" value="<?php echo $arrdata['KD_GUDANG_TUJUAN']; ?>" readonly="readonly">
                            <div class="hint">KODE GUDANG</div>
                          </div>
                          <div class="col-sm-6">
                            <input type="text" name="GUDANG_TUJUAN" id="GUDANG_TUJUAN" mandatory="yes" class="form-control focus" placeholder="NAMA GUDANG TUJUAN" value="<?php echo $arrdata['GUDANG_TUJUAN']; ?>" readonly="readonly">
                            <div class="hint">NAMA GUDANG</div>
                          </div>
                          <div class="col-sm-1">
                              <button type="button" class="btn btn-sm btn-primary" onclick="popup_search('popup/popup_search/mst_gudang/KD_TPS_TUJUAN|KD_GUDANG_TUJUAN|GUDANG_TUJUAN/1'); ">
                                <i class="icon md-search"></i>
                              </button>
                           </div>
                        </div>
                        <div class="form-group form-material">
                          <label class="col-sm-3 control-label">YOR ASAL</label>
                          <div class="col-sm-9">
                            <input type="text" name="DATA[YOR_ASAL]" id="YOR_ASAL" mandatory="yes" class="form-control" placeholder="YOR ASAL" value="<?php echo $arrdata['YOR_ASAL']; ?>" data-plugin="formatter" data-pattern="[[99]]%">
                            <div class="hint">YOR ASAL</div>
                          </div>
                        </div>
                        <div class="form-group form-material">
                          <label class="col-sm-3 control-label">YOR TUJUAN</label>
                          <div class="col-sm-9">
                            <input type="text" name="DATA[YOR_TUJUAN]" id="YOR_TUJUAN" mandatory="yes" class="form-control" placeholder="YOR TUJUAN" value="<?php echo $arrdata['YOR_TUJUAN']; ?>" data-plugin="formatter" data-pattern="[[99]]%">
                            <div class="hint">YOR TUJUAN</div>
                          </div>
                        </div>
                        <div class="form-group form-material">
                          <label class="col-sm-3 control-label">ALASAN PLP</label>
                          <div class="col-sm-8">
                          	 <input type="hidden" name="DATA[KD_ALASAN_PLP]" id="KD_ALASAN_PLP" mandatory="yes" class="form-control" placeholder="KD ALASAN PLP" value="<?php echo $arrdata['KD_ALASAN_PLP']; ?>">
                            <textarea name="NAMA_ALASAN_PLP" id="NAMA_ALASAN_PLP" mandatory="yes" class="form-control focus" placeholder="ALASAN PLP" readonly="readonly"><?php echo $arrdata['ALASAN_PLP']; ?></textarea>
                            <div class="hint">ALASAN PLP</div>
                          </div>
                          <div class="col-sm-1">
                              <button type="button" class="btn btn-sm btn-primary" onclick="popup_search('popup/popup_search/mst_alasan_plp/KD_ALASAN_PLP|NAMA_ALASAN_PLP/1'); ">
                                <i class="icon md-search"></i>
                              </button>
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
                    <input type="hidden" name="action" id="action" readonly="readonly" value="<?php echo site_url('plp/pengajuan'); ?>"/>
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
<!---data-plugin="formatter" data-pattern="[[99]].[[99]]%">-->
