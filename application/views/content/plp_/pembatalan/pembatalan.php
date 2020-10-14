<div class="card">
  <div class="card-block p-a-0">
    <div class="box-tab m-b-0" id="rootwizard">
      <ul class="wizard-tabs">
        <li class="active"><a href="#tab1" data-toggle="tab">DATA PEMBATALAN</a></li>
        <li style="width:100%;"> <a data-toggle="" style="text-align:right">
          <button type="button" class="btn btn-primary btn-icon" onclick="save_multiple_post('form_data|tblkemasanplp'); return false;">Save <i class="icon-check"></i></button>
          </a> </li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane p-x-lg active" id="tab1">
          <div class="row">
            <div class="col-md-12">
              <form name="form_data" id="form_data" class="form-horizontal" role="form" action="<?php echo site_url('plp/execute/'.$act.'/pembatalan/'.$ID); ?>" method="post" autocomplete="off">
              	<div class="form-group">
                  <label class="col-sm-2 control-label-left">NO. PLP</label>
                  <div class="col-sm-7">
                    <input type="text" class="form-control" name="NO_PLP" id="NO_PLP" wajib="yes" placeholder="NOMOR" value="<?php echo $arrhdr['NO_PLP']; ?>" readonly="readonly">
                  </div>
                  <div class="col-sm-2">
                    <div class="input-prepend input-group"><span class="add-on input-group-addon"><i class="icon-calendar"></i></span>
                      <input class="form-control" type="text" placeholder="TANGGAL PLP" name="TGL_PLP" id="TGL_PLP" data-provide="datepicker" wajib="yes" value="<?php echo date_en($arrhdr['TGL_PLP']); ?>" readonly="readonly">
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label-left">TPS</label>
                  <div class="col-sm-2">
                  	<input type="hidden" name="DATA[KD_TPS]" id="KD_TPS" wajib="yes" value="<?php echo $arrhdr['KD_TPS']; ?>" readonly="readonly">
                    <input type="text" name="DATA[KD_TPS]" id="KD_TPS" wajib="yes" class="form-control" placeholder="KODE TPS" value="<?php echo $arrhdr['KD_TPS']; ?>" readonly="readonly">
                  </div>
                  <div class="col-sm-7">
                    <input type="text" name="TPS" id="TPS" wajib="yes" class="form-control" placeholder="TPS" value="<?php echo $arrhdr['TPS']; ?>" readonly="readonly">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label-left">SURAT</label>
                  <div class="col-sm-7">
                    <input type="text" class="form-control" name="DATA[NO_SURAT]" id="NO_SURAT" wajib="yes" placeholder="NOMOR"  value="<?php echo $arrhdr['NO_SURAT']; ?>">
                  </div>
                  <div class="col-sm-2">
                    <div class="input-prepend input-group"><span class="add-on input-group-addon"><i class="icon-calendar"></i></span>
                      <input class="form-control drp" type="text" placeholder="TANGGAL SURAT" name="DATA[TGL_SURAT]" id="TGL_SURAT" data-provide="datepicker" wajib="yes" value="<?php echo date_en($arrhdr['TGL_SURAT']); ?>">
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label-left">NAMA PEMOHON</label>
                  <div class="col-sm-9">
                    <input type="text" name="DATA[NM_PEMOHON]" id="NM_PEMOHON" wajib="yes" class="form-control" placeholder="NAMA PEMOHON" value="<?php echo $arrhdr['NM_PEMOHON']; ?>">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label-left">ALASAN PEMBATALAN</label>
                  <div class="col-sm-9">
                    <textarea name="DATA[ALASAN]" id="ALASAN" class="form-control" placeholder="ALASAN" ><?php echo $arrhdr['ALASAN']; ?></textarea>
                  </div>
                </div>
              </form>
            </div>
          </div>
          <div class="card">
          <div class="card-block p-a-0">
            <div class="box-tab m-b-0" id="rootwizard">
              <ul class="wizard-tabs">
                <li class="active"><a href="#tab_kemasan" data-toggle="tab">DATA KEMASAN</a></li>
                <li>&nbsp;</li>
              </ul>
              <div class="tab-content">
                <div class="tab-pane p-x-lg active" id="tab_kemasan">
                    <?php echo $table_kemasan; ?>
                </div>
              </div>
            </div>
          </div>
       	</div>
        </div>
      </div>
    </div>
  </div>
</div> 
