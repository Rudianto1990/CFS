<div class="panel">
  <div class="ribbon ribbon-clip ribbon-primary">
  	<span class="ribbon-inner">
		<i class="icon md-boat margin-0" aria-hidden="true"></i> <?php echo $title; ?>
    </span>
  </div>
  <button type="submit" class="btn btn-sm btn-primary navbar-right navbar-btn waves-effect waves-light" onclick="save_post('form_request','divtblrequestdokumen'); return false;" <?php echo ($action == "detail") ? "disabled" : ""; ?>>
  	<i class="icon md-badge-check"></i> SAVE
  </button>
  <div class="panel-body container-fluid">
    <div class="row">
      <div class="col-sm-12">
        <form name="form_request" id="form_request" class="form-horizontal" role="form" action="<?php echo site_url('execute/process/'.$action.'/request_dokumen/'.$id); ?>" method="post" autocomplete="off" onsubmit="save_post('form_request','divtblrequestdokumen'); return false;" popup="1">
          <div class="panel-body container-fluid">
            <div class="row">
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">JENIS DOKUMEN</label>
                <div class="col-sm-9">
                  <?php 
if($action == 'detail')
{
echo $arr_dokumen[$arrdata['KD_DOK_INOUT']];    
}
else
{
  echo form_dropdown('DATA[KD_DOK_INOUT]',$arr_dokumen,$arrdata['KD_DOK_INOUT'],'id="KD_DOK_INOUT" mandatory="yes" class="form-control"');
}
?>
                 <!-- <div class="hint">JENIS DOKUMEN</div> -->
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">DOKUMEN</label>
                <div class="col-sm-6">
                  <input type="text" name="DATA[NO_DOK_INOUT]" id="NO_DOK_INOUT" mandatory="yes" class="form-control" placeholder="NOMOR DOKUMEN" value="<?php echo $arrdata['NO_DOK_INOUT']; ?>" <?php echo ($action == "detail") ? "readonly" : ""; ?>>
                  <div class="hint">NOMOR DOKUMEN</div>
                </div>
                <div class="col-sm-3">
                  <input type="text" name="DATA[TGL_DOK_INOUT]" id="TGL_DOK_INOUT" mandatory="yes" class="form-control date" placeholder="TANGGAL DOKUMEN" value="<?php echo validate(date_input($arrdata['TGL_DOK_INOUT'])); ?>" <?php echo ($action == "detail") ? "readonly" : ""; ?>>
                  <div class="hint">TANGGAL DOKUMEN</div>
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-3 control-label">NPWP</label>
                <div class="col-sm-9">
                  <input type="text" name="DATA[NPWP_CONSIGNEE]" id="NPWP_CONSIGNEE" class="form-control" placeholder="NPWP CONSIGNEE" value="<?php echo $arrdata['NPWP_CONSIGNEE']; ?>" <?php echo ($action == "detail") ? "readonly" : ""; ?>>
                  <div class="hint">NPWP CONSIGNEE</div>
                </div>
              </div>
            </div>
          </div>
          <input type="hidden" name="action" id="action" readonly="readonly" value="<?php echo site_url('respon/'.$url.'/post'); ?>"/>
        </form>
      </div>
    </div>
  </div>
</div>
<script>
$(function(){
	date('date');
});
</script>