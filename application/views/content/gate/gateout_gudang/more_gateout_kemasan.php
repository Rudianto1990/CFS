<div class="card">
  <div class="card-block p-a-0">
    <div class="box-tab m-b-0" id="rootwizard">
      <ul class="wizard-tabs">
        <li class="active"><a href="#tab_loading" data-toggle="tab">DATA GATE OUT</a></li>
        <li><a href="#tab_kemasan" data-toggle="tab">DATA KEMASAN</a></li>
        <li style="width:100%;"> <a data-toggle="" style="text-align:right">
          <button type="button" class="btn btn-primary btn-icon" onclick="save_popup('frm_kemasan','divtblkemasan'); return false;">GATE OUT<i class="icon-check"></i></button>
          </a> </li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane p-x-lg active" id="tab_loading">
          <form name="frm_kemasan" id="frm_kemasan" class="form-horizontal" role="form" action="<?php echo site_url('gate/execute/update/more_out_gudang-kms'); ?>" method="post" autocomplete="off" onsubmit="save_popup('frm_kemasan','divtblkemasan'); return false;">
            <div class="row">
              <div class="col-md-6">
              	<div class="form-group">
                  <label class="col-sm-3 control-label-left">JENIS DOKUMEN</label>
                  <div class="col-sm-2">
                    <input type="text" name="DATA[KD_DOK_OUT]" id="KD_DOK_OUT" wajib="yes" class="form-control" readonly="readonly" placeholder="KODE" value="<?php echo $arrkms['KD_DOK_OUT']; ?>">
                  </div>
                  <div class="col-sm-5">
                    <input type="text" name="NAMA_DOK_OUT" id="NAMA_DOK_OUT" wajib="yes" class="form-control" placeholder="DOKUMEN" value="<?php echo $arrkms['NAMA_DOK_OUT']; ?>">
                  </div>
                  <div class="col-sm-1" style="padding-top:3px">
                    <button type="button" class="btn btn-primary btn-sm" onclick="popup_searchtwo('popup/popup_search/dok_bc|IMP','','60','600')"> <span class="icon-magnifier"></span></button>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label-left">DOKUMEN</label>
                  <div class="col-sm-4">
                    <input type="text" name="DATA[NO_DOK_OUT]" id="NO_DOK_OUT" wajib="yes" class="form-control" placeholder="NOMOR" value="<?php echo $arrkms['NO_DOK_OUT']; ?>">
                  </div>
                  <div class="col-sm-4">
                    <div class="input-prepend input-group"><span class="add-on input-group-addon"><i class="icon-calendar"></i></span>
                      <input class="form-control drp" type="text" placeholder="TANGGAL" name="DATA[TGL_DOK_OUT]" id="TGL_DOK_OUT" data-provide="datepicker" wajib="yes" value="<?php echo date_en($arrkms['TGL_DOK_OUT']); ?>">
                    </div>
                  </div>
                </div>
              	<div class="form-group">
                  <label class="col-sm-3 control-label-left">ANGKUTAN</label>
                  <div class="col-sm-8"> <?php echo form_dropdown('DATA[KD_SARANA_ANGKUT_OUT]',$arr_angkutan,$arrkms['KD_SARANA_ANGKUT_OUT'],'id="KD_SARANA_ANGKUT_OUT" wajib="yes" class="form-control"'); ?> </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label class="col-sm-3 control-label-left">NO. POLISI</label>
                  <div class="col-sm-8">
                    <input type="text" name="DATA[NO_POL_OUT]" id="NO_POL_OUT" wajib="yes" class="form-control" placeholder="NOMOR POLISI" value="<?php echo $arrkms['NO_POL_OUT']; ?>">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label-left">STATUS</label>
                  <div class="col-sm-8"> <?php echo form_dropdown('DATA[KD_CONT_STATUS_OUT]',$arr_status_cont,$arrkms['KD_CONT_STATUS_OUT'],'id="KD_CONT_STATUS_OUT" wajib="yes" class="form-control"'); ?> </div>
                </div>
                <?php if(set_setting('SETWKINOUT') == 'Y'): ?>
                <div class="form-group">
                  <label class="col-sm-3 control-label-left">GATE OUT</label>
                  <div class="col-sm-8">
                    <div class="input-prepend input-group"><span class="add-on input-group-addon"><i class="icon-calendar"></i></span>
                      <input class="form-control drptime" type="text" placeholder="TANGGAL" name="DATA[WK_OUT]" id="WK_OUT" data-provide="datepicker" wajib="yes" value="<?php echo $arrkms['WK_OUT']; ?>">
                    </div>
                  </div>
                </div>
                <?php endif; ?>
              </div>
            </div>
            <input type="hidden" name="id" id="id" readonly="readonly" value="<?php echo $id; ?>" />
            </form>
        </div>
        <div class="tab-pane" id="tab_kemasan">
        	<?php echo $table_kemasan; ?>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
$(function(){
	autocomplete('NAMA_DOK_OUT','/gate/autocomplete/mst_dok_bc/IMP',function(event, ui){
		$('#KD_DOK_OUT').val(ui.item.KODE);
	});
	date('drp');
	datetime('drptime');
});
</script>  
