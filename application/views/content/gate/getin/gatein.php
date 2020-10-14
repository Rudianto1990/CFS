<div class="card">
  <div class="card-block p-a-0">
    <div class="box-tab m-b-0" id="rootwizard">
      <ul class="wizard-tabs">
        <li class="active"><a href="#tab1" data-toggle="tab"><?php echo $title; ?></a></li>
        <li style="width:100%;"> <a data-toggle="" style="text-align:right">
          <button type="button" class="btn btn-primary btn-icon" onclick="save_post('form_data'); return false;">Save <i class="icon-check"></i></button>
          </a> </li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane p-x-lg active" id="tab1">
 <form name="form_data" id="form_data" class="form-horizontal" role="form" action="<?php echo site_url('execute/process/'.$action.'/kapal/'.$id); ?>" method="post" autocomplete="off" onsubmit="save_post('form_data','divtblkapal'); return false;" popup="1">
<!-- FORM HERE -->
<div class="panel-body container-fluid">
            <div class="row">
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">PESAWAT/KAPAL</label>
                <div class="col-sm-9">
                  <input type="hidden" class="form-control" name="DATA[KD_KAPAL]" id="KD_KAPAL" placeholder="KODE" value="<?php echo $arrdata['KD_KAPAL']; ?>" readonly="readonly">
                  <input type="text" name="DATA[NM_ANGKUT]" id="NM_ANGKUT" mandatory="yes" class="form-control" placeholder="NAMA ANGKUT" value="<?php echo $arrdata['NM_ANGKUT']; ?>">
                  <div class="hint">NAMA PESAWAT/KAPAL</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">PELABUHAN MUAT</label>
                <div class="col-sm-2">
                  <input type="text" name="DATA[KD_PEL_MUAT]" id="KD_PEL_MUAT" mandatory="yes" class="form-control" placeholder="KODE" value="<?php echo $arrdata['KD_PEL_MUAT']; ?>">
                  <div class="hint">KODE PELABUHAN</div>
                </div>
                <div class="col-sm-7">
                  <input type="text" name="PELABUHAN_MUAT" id="PELABUHAN_MUAT" mandatory="yes" class="form-control" placeholder="PELABUHAN MUAT" value="<?php echo $arrdata['PEL_MUAT']; ?>">
                  <div class="hint">NAMA PELABUHAN</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">PELABUHAN TRANSIT</label>
                <div class="col-sm-2">
                  <input type="text" name="DATA[KD_PEL_TRANSIT]" id="KD_PEL_TRANSIT" class="form-control" placeholder="KODE" value="<?php echo $arrdata['KD_PEL_TRANSIT']; ?>">
                  <div class="hint">KODE PELABUHAN</div>
                </div>
                <div class="col-sm-7">
                  <input type="text" name="PELABUHAN_TRANSIT" id="PELABUHAN_TRANSIT" class="form-control" placeholder="PELABUHAN TRANSIT" value="<?php echo $arrdata['PEL_TRANSIT']; ?>">
                  <div class="hint">NAMA PELABUHAN</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">PELABUHAN BONGKAR</label>
                <div class="col-sm-2">
                  <input type="text" name="DATA[KD_PEL_BONGKAR]" id="KD_PEL_BONGKAR" class="form-control" mandatory="yes" placeholder="KODE" value="<?php echo $arrdata['KD_PEL_BONGKAR']; ?>">
                  <div class="hint">KODE PELABUHAN</div>
                </div>
                <div class="col-sm-7">
                  <input type="text" name="PELABUHAN_BONGKAR" id="PELABUHAN_BONGKAR" class="form-control" mandatory="yes" placeholder="PELABUHAN BONGKAR" value="<?php echo $arrdata['PEL_BONGKAR']; ?>">
                  <div class="hint">NAMA PELABUHAN</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">VOYAGE/FLIGHT</label>
                <div class="col-sm-9">
                  <input type="text" name="DATA[NO_VOY_FLIGHT]" id="NO_VOY_FLIGHT" mandatory="yes" class="form-control" placeholder="NOMOR VOYAGE / FLIGHT" value="<?php echo $arrdata['NO_VOY_FLIGHT']; ?>">
                  <div class="hint">NOMOR VOYAGE/FLIGHT</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">TANGGAL TIBA/BERANGKAT</label>
                <div class="col-sm-9">
                  <input class="form-control date" type="text" placeholder="TANGGAL TIBA/BERANGKAT" name="DATA[TGL_TIBA]" id="TGL_TIBA" mandatory="yes" value="<?php echo $arrdata['TGL_TIBA']; ?>">
                  <div class="hint">TANGGAL TIBA/BERANGKAT</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">BC11</label>
                <div class="col-sm-5">
                  <input type="text" name="DATA[NO_BC11]" id="NO_BC11" mandatory="yes" class="form-control" placeholder="NOMOR BC11" value="<?php echo $arrdata['NO_BC11']; ?>" maxlength="10">
                  <div class="hint">NOMOR BC11</div>
                </div>
                <div class="col-sm-4">
                  <input class="form-control date" type="text" placeholder="TANGGAL BC11" name="DATA[TGL_BC11]" id="TGL_BC11" mandatory="yes" value="<?php echo $arrdata['TGL_BC11']; ?>">
                  <div class="hint">TANGGAL BC11</div>
                </div>
              </div>
            </div>
          </div>
          <input type="hidden" name="DATA[KD_ASAL_BRG]" id="KD_ASAL_BRG" readonly="readonly" value="3"/>
          <input type="hidden" name="action" id="action" readonly="readonly" value="<?php echo site_url('gate/in_container'); ?>"/>
       

<!-- // FORM HERE -->






          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
$(function(){
  date('date');
  autocomplete('NM_ANGKUT','/popup/autocomplete/mst_kapal/nama',function(event, ui){
    $('#KD_KAPAL').val(ui.item.KD_KAPAL);
  });
  autocomplete('KD_PEL_MUAT','/popup/autocomplete/mst_port/kode',function(event, ui){
    $('#PELABUHAN_MUAT').val(ui.item.NAMA);
  });
  autocomplete('PELABUHAN_MUAT','/popup/autocomplete/mst_port/nama',function(event, ui){
    $('#KD_PEL_MUAT').val(ui.item.KODE);
  });
  autocomplete('KD_PEL_TRANSIT','/popup/autocomplete/mst_port/kode',function(event, ui){
    $('#PELABUHAN_TRANSIT').val(ui.item.NAMA);
  });
  autocomplete('PELABUHAN_TRANSIT','/popup/autocomplete/mst_port/nama',function(event, ui){
    $('#KD_PEL_TRANSIT').val(ui.item.KODE);
  });
  autocomplete('KD_PEL_BONGKAR','/popup/autocomplete/mst_port/kode',function(event, ui){
    $('#PELABUHAN_BONGKAR').val(ui.item.NAMA);
  });
  autocomplete('PELABUHAN_BONGKAR','/popup/autocomplete/mst_port/nama',function(event, ui){
    $('#KD_PEL_BONGKAR').val(ui.item.KODE);
  });
});
</script>


