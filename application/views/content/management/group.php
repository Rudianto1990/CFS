<div class="card">
  <div class="card-block p-a-0">
    <div class="box-tab m-b-0" id="rootwizard">
      <ul class="wizard-tabs">
        <li class="active"><a href="#tab1" data-toggle="tab">GROUP</a></li>
        <li style="width:100%;"> <a data-toggle="" style="text-align:right">
          <button type="button" class="btn btn-primary btn-icon" onclick="save_popup('form_data','divtblgroup'); return false;">Save <i class="icon-check"></i></button>
          </a> </li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane p-x-lg active" id="tab1">
          <form name="form_data" id="form_data" class="form-horizontal" role="form" action="<?php echo site_url('management/execute/'.$act.'/group/'.$id); ?>" method="post" autocomplete="off" onsubmit="save_popup('form_data','divtblgroup'); return false;">
            <div class="form-group">
              <label class="col-sm-2 control-label-left">KODE GROUP</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="DATA[ID]" id="ID" wajib="yes" placeholder="KODE" value="<?php echo $arrhdr['ID']; ?>"<?php echo ($act=="update")?"readonly":""; ?>>
              </div>
            </div>
            <div class="form-group">
            <label class="col-sm-2 control-label-left">NAMA GROUP</label>
            <div class="col-sm-10">
              <input type="text" name="DATA[NAMA]" id="NAMA" wajib="yes" class="form-control" placeholder="NAMA" value="<?php echo $arrhdr['NAMA']; ?>">
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
