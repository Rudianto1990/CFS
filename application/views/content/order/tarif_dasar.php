<div class="card">
  <div class="card-block p-a-0">
    <div class="box-tab m-b-0" id="rootwizard">
      <ul class="wizard-tabs">
        <li class="active"><a href="#tab1" data-toggle="tab">TARIF DASAR</a></li>
        <li style="width:100%;"> <a data-toggle="" style="text-align:right">
          <button type="button" class="btn btn-primary btn-icon" onclick="save_popup('form_data','divtbltarif_dasar'); return false;">Save <i class="icon-check"></i></button>
          </a> </li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane p-x-lg active" id="tab1">
          <form name="form_data" id="form_data" class="form-horizontal" role="form" action="<?php echo site_url('order/execute/'.$act.'/tarif_dasar/'.$id); ?>" method="post" autocomplete="off" onsubmit="save_popup('form_data','divtbltarif_dasar'); return false;">
            <div class="form-group">
              <label class="col-sm-2 control-label-left">KODE TARIF</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="DATA[KODE_BILL]" id="ID" wajib="yes" placeholder="KODE TARIF" value="<?php echo $arrhdr['KODE_BILL']; ?>">
              </div>
            </div>
            <div class="form-group">
				<label class="col-sm-2 control-label-left">DESKRIPSI</label>
				<div class="col-sm-10">
				  <input type="text" name="DATA[DESKRIPSI]" id="NAMA" wajib="yes" class="form-control" placeholder="DESKRIPSI" value="<?php echo $arrhdr['DESKRIPSI']; ?>">
				</div>
			</div>
            <div class="form-group">
				<label class="col-sm-2 control-label-left">TARIF DASAR</label>
				<div class="col-sm-10">
				  <input type="text" name="DATA[TARIF_DASAR]" id="TARIF_DASAR" wajib="no" class="form-control" placeholder="TARIF DASAR" value="<?php echo $arrhdr['TARIF_DASAR']; ?>">
				</div>
            </div>
            <div class="form-group">
				<label class="col-sm-2 control-label-left">SATUAN</label>
				<div class="col-sm-10">
				  <input type="text" name="DATA[KETERANGAN]" id="KETERANGAN" wajib="no" class="form-control" placeholder="SATUAN" value="<?php echo $arrhdr['KETERANGAN']; ?>">
				</div>
			</div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
