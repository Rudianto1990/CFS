<div class="panel">
  <div class="ribbon ribbon-clip ribbon-primary"> <span class="ribbon-inner"> <i class="icon md-boat margin-0" aria-hidden="true"></i> <?php echo $title; ?> </span> </div>
  <div>&nbsp;</div>
  <div>&nbsp;</div>
  <div class="panel-body container-fluid">
    <div class="row">
      <div class="col-sm-12">
        <form name="form_data" id="form_data" class="form-horizontal" role="form" method="post" autocomplete="off" onsubmit="save_post('form_data','divtbldischarge'); return false;" popup="1">
          <div class="panel-body container-fluid">
            <div class="row">
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">PESAWAT/KAPAL</label>
                <div class="col-sm-9">
                  <input type="hidden" class="form-control focus" name="KD_KAPAL" id="KD_KAPAL" mandatory="yes" placeholder="KODE KAPAL" value="<?php echo $arrdata['KD_KAPAL']; ?>" readonly="readonly">
                  <input type="text" name="NM_ANGKUT" id="NM_ANGKUT" mandatory="yes" class="form-control focus" placeholder="NAMA ANGKUT" value="<?php echo $arrdata['NM_ANGKUT']; ?>" readonly="readonly">
                  <div class="hint">NAMA PESAWAT/KAPAL</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">PELABUHAN MUAT</label>
                <div class="col-sm-2">
                  <input type="text" name="KD_PEL_MUAT" mandatory="yes" class="form-control focus" placeholder="KODE PELABUHAN" value="<?php echo $arrdata['KD_PEL_MUAT']; ?>" readonly="readonly">
                  <div class="hint">KODE PELABUHAN</div>
                </div>
                <div class="col-sm-7">
                  <input type="text" name="PELABUHAN_MUAT" mandatory="yes" class="form-control focus" placeholder="NAMA PELABUHAN" value="<?php echo $arrdata['PEL_MUAT']; ?>" readonly="readonly">
                  <div class="hint">NAMA PELABUHAN</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">PELABUHAN TRANSIT</label>
                <div class="col-sm-2">
                  <input type="text" name="KD_PEL_TRANSIT" class="form-control focus" placeholder="KODE PELABUHAN" value="<?php echo $arrdata['KD_PEL_TRANSIT']; ?>" readonly="readonly">
                  <div class="hint">KODE PELABUHAN</div>
                </div>
                <div class="col-sm-7">
                  <input type="text" name="PELABUHAN_TRANSIT" class="form-control focus" placeholder="NAMA PELABUHAN" value="<?php echo $arrdata['PEL_TRANSIT']; ?>" readonly="readonly">
                  <div class="hint">NAMA PELABUHAN</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">PELABUHAN BONGKAR</label>
                <div class="col-sm-2">
                  <input type="text" name="KD_PEL_BONGKAR" class="form-control focus" mandatory="yes" placeholder="KODE PELABUHAN" value="<?php echo $arrdata['KD_PEL_BONGKAR']; ?>" readonly="readonly">
                  <div class="hint">KODE PELABUHAN</div>
                </div>
                <div class="col-sm-7">
                  <input type="text" name="PELABUHAN_BONGKAR" class="form-control focus" mandatory="yes" placeholder="NAMA PELABUHAN" value="<?php echo $arrdata['PEL_BONGKAR']; ?>" readonly="readonly">
                  <div class="hint">NAMA PELABUHAN</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">VOYAGE/FLIGHT</label>
                <div class="col-sm-9">
                  <input type="text" name="NO_VOY_FLIGHT" id="NO_VOY_FLIGHT" mandatory="yes" class="form-control focus" placeholder="NOMOR VOYAGE / FLIGHT" value="<?php echo $arrdata['NO_VOY_FLIGHT']; ?>" readonly="readonly">
                  <div class="hint">NOMOR VOYAGE/FLIGHT</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">TANGGAL TIBA/BERANGKAT</label>
                <div class="col-sm-9">
                  <input class="form-control focus" type="text" placeholder="TANGGAL TIBA/BERANGKAT" name="TGL_TIBA" id="TGL_TIBA" mandatory="yes" value="<?php echo $arrdata['TGL_TIBA']; ?>" readonly="readonly">
                  <div class="hint">TANGGAL TIBA/BERANGKAT</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">BC11</label>
                <div class="col-sm-5">
                  <input type="text" name="NO_BC11" id="NO_BC11" mandatory="yes" class="form-control focus" placeholder="NOMOR BC11" value="<?php echo $arrdata['NO_BC11']; ?>" maxlength="10" readonly="readonly">
                  <div class="hint">NOMOR BC11</div>
                </div>
                <div class="col-sm-4">
                  <input class="form-control focus" type="text" placeholder="TANGGAL BC11" name="TGL_BC11" id="TGL_BC11" mandatory="yes" value="<?php echo $arrdata['TGL_BC11']; ?>" readonly="readonly">
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
<div class="panel">
  <div class="ribbon ribbon-clip ribbon-primary">
  <span class="ribbon-inner"> <i class="icon md-collection-item margin-0" aria-hidden="true"></i> DATA DETAIL </span>
  </div>
  <div>&nbsp;</div>
  <div>&nbsp;</div>
  <div>&nbsp;</div>
  <div class="nav nav-tabs-horizontal nav-tabs-inverse nav-tabs-animate">
    <ul class="nav nav-tabs nav-tabs" data-plugin="nav-tabs" role="tablist">
      <li class="active" role="presentation">
        <a data-toggle="tab" href="#kontainer" aria-controls="kontainer" role="tab">
            <i class="icon md-view-list margin-0" aria-hidden="true"></i> KONTAINER
        </a>
      </li>
      <?php if(set_setting('SETDATAKEMASAN') == 'Y'): ?>
      <li role="presentation" class="">
        <a data-toggle="tab" href="#kemasan" aria-controls="kemasan"role="tab">
            <i class="icon md-widgets margin-0" aria-hidden="true"></i> KEMASAN
        </a>
      </li>
      <?php endif; ?>
    </ul>
    <div class="tab-content">
      <div class="tab-pane active animation-slide-top" id="kontainer" role="tabpanel">
        <?php echo $table_kontainer; ?>
      </div>
      <?php if(set_setting('SETDATAKEMASAN') == 'Y'): ?>
      <div class="tab-pane animation-slide-top" id="kemasan" role="tabpanel">
        <?php echo $table_kemasan; ?>
      </div>
      <?php endif; ?>
    </div>
  </div>
</div>
