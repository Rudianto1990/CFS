<div class="card">
  <div class="card-block p-a-0">
    <div class="box-tab m-b-0" id="rootwizard">
      <ul class="wizard-tabs">
        <li class="active"><a href="#tab1" data-toggle="tab"><?php echo $title; ?></a></li>
        <li style="width:100%;"> 
		  <a data-toggle="" style="text-align:right"><button type="button" class="btn btn-primary btn-icon" id="buti" onclick="save_popup('form_data','divtbledc'); return false;">SAVE<i class="icon-check"></i></button></a> 
		</li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane p-x-lg active" id="tab1">
          <form name="form_data" id="form_data" class="form-horizontal" role="form" action="<?php echo site_url('order/execute/'.$act.'/edc/'.$id); ?>" method="post" autocomplete="off" onsubmit="save_popup('form_data','divtbledc'); return false;">
			<div class="form-group">
              <label class="col-sm-4 control-label-left">NO ORDER</label>
              <div class="col-sm-8">
                <input type="text" name="NO_ORDER" wajib="yes" id="NO_ORDER" class="form-control" placeholder="NOMOR ORDER" maxlength="50">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-4 control-label-left">BANK</label>
              <div class="col-sm-8">
				  <?php echo form_dropdown('BANK',$bank,'','id="BANK" wajib="yes" class="form-control"'); ?>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-4 control-label-left">BUNDLED INVOICE KEY</label>
              <div class="col-sm-8">
                <input type="text" name="BUNDLED_INVOICE_KEY" id="BUNDLED_INVOICE_KEY" class="form-control" placeholder="BUNDLED INVOICE KEY" maxlength="50">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-4 control-label-left">NAMA PEMILIK</label>
              <div class="col-sm-8">
                <input type="text" name="NAMA_PEMILIK" wajib="yes" id="NAMA_PEMILIK" class="form-control" placeholder="NAMA PEMILIK" maxlength="50">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-4 control-label-left">NPWP PEMILIK</label>
              <div class="col-sm-8">
                <input type="text" name="NPWP_PEMILIK" wajib="yes" id="NPWP_PEMILIK" class="form-control" placeholder="NPWP PEMILIK" maxlength="15">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-4 control-label-left">REFF NO</label>
              <div class="col-sm-8">
                <input type="text" name="REFF_NO" wajib="yes" id="REFF_NO" class="form-control" placeholder="REFF NO" maxlength="50">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-4 control-label-left">TRACE NO</label>
              <div class="col-sm-8">
                <input type="text" name="TRACE_NO" id="TRACE_NO" class="form-control" placeholder="TRACE NO" maxlength="50">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-4 control-label-left">APPROVAL CODE</label>
              <div class="col-sm-8">
                <input type="text" name="APPROVAL_CODE" id="APPROVAL_CODE" class="form-control" placeholder="APPROVAL CODE" maxlength="50">
              </div>
            </div>
			<input type="hidden" name="NO_PROFORMA_INVOICE" wajib="no" id="NO_PROFORMA_INVOICE">
			<input type="hidden" name="AMOUNT" wajib="no" id="AMOUNT" class="form-control">
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
$(function(){
  autocomplete('NO_ORDER','/autocomplete/ppbarang/no_bl/edc',function(event, ui){
    $('#NO_ORDER').val(ui.item.NO_ORDER);
    $('#NAMA_PEMILIK').val(ui.item.NAMA_PEMILIK);
    $('#NPWP_PEMILIK').val(ui.item.NPWP_PEMILIK);
    $('#AMOUNT').val(ui.item.TOTAL);
    $('#NO_PROFORMA_INVOICE').val(ui.item.NO_PROFORMA_INVOICE);
  });
});
</script>
