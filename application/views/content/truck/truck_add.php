<div class="card">
  <div class="card-block p-a-0">
    <div class="box-tab m-b-0" id="rootwizard">
      <ul class="wizard-tabs">
        <li class="active"><a href="#tab1" data-toggle="tab">TRUCK</a></li>
        <li style="width:100%;"> <a data-toggle="" style="text-align:right">
          <button type="button" class="btn btn-primary btn-icon" onclick="save_popup2('form_data','divtbldetail','divtbltrucker'); return false;">Save <i class="icon-check"></i></button>
          </a> </li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane p-x-lg active" id="tab1">
          <form name="form_data" id="form_data" class="form-horizontal" role="form" action="<?php echo site_url('truck/execute/'.$act.'/truck/'.$id); ?>" method="post" autocomplete="off" onsubmit="save_popup2('form_data','divtbldetail','divtbltrucker'); return false;">
            <div class="form-group">
              <label class="col-sm-2 control-label-left">KODE TRUCKER</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="DATA[ID]" id="ID" wajib="yes" placeholder="KODE" value="<?php echo ($act=='save')?$ID:$arrhdr['ID']; ?>"readonly>
              </div>
            </div>
            <div class="form-group">
				<label class="col-sm-2 control-label-left">NO TRUCK</label>
				<div class="col-sm-10">
				  <input type="text" name="DATA[NO_TRUCK]" id="NO_TRUCK" wajib="yes" class="form-control" placeholder="NO_TRUCK" value="<?php echo $arrhdr['NO_TRUCK']; ?>">
				</div>
            </div>
            <div class="form-group">
				<label class="col-sm-2 control-label-left">NO POLISI</label>
				<div class="col-sm-10">
				  <input type="text" name="DATA[NO_POLISI]" id="NO_POLISI" wajib="yes" class="form-control" placeholder="NO_POLISI" value="<?php echo $arrhdr['NO_POLISI']; ?>">
				</div>
            </div>
            <div class="form-group">
				<label class="col-sm-2 control-label-left">TIPE TRUCK</label>
				<div class="col-sm-10">
				  <input type="text" name="DATA[TIPE_TRUCK]" id="TIPE_TRUCK" wajib="yes" class="form-control" placeholder="TIPE_TRUCK" value="<?php echo $arrhdr['TIPE_TRUCK']; ?>">
				</div>
            </div>
            <div class="form-group">
				<label class="col-sm-2 control-label-left">NAMA DRIVER</label>
				<div class="col-sm-10">
				  <input type="text" name="DATA[DRIVER]" id="DRIVER" wajib="yes" class="form-control" placeholder="DRIVER" value="<?php echo $arrhdr['DRIVER']; ?>">
				</div>
            </div>
            <div class="form-group">
				<label class="col-sm-2 control-label-left">STATUS</label>
				<div class="col-sm-10">
					<?php echo form_dropdown('DATA[STATUS]', array('Y' => 'AVAILABLE', 'N' => 'UNAVAILABLE'), $arrhdr['STATUS'], 'id="STATUS" wajib="yes" class="form-control"'); ?>
				</div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
