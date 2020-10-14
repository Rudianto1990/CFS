<div class="card">
  <div class="card-block p-a-0">
    <div class="box-tab m-b-0" id="rootwizard">
      <ul class="wizard-tabs">
        <li class="active"><a href="#tab1" data-toggle="tab">PRIVILEGE</a></li>
        <li style="width:100%;"> <a data-toggle="" style="text-align:right">
          <button type="button" class="btn btn-primary btn-icon" onclick="save_popup('form_data','divtblprivilege'); return false;">Save <i class="icon-check"></i></button>
          </a> </li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane p-x-lg active" id="tab1">
          <form name="form_data" id="form_data" class="form-horizontal" role="form" action="<?php echo site_url('management/execute/'.$act.'/privilege/'.$ID); ?>" method="post" autocomplete="off" onsubmit="save_post('form_data','divtblprivilege'); return false;">
            <div class="form-group">
              <label class="col-sm-2 control-label-left">KODE USER</label>
              <div class="col-sm-2">
                <input type="text" class="form-control" name="DATA[KD_USER]" id="KD_USER" wajib="yes" placeholder="KODE" readonly="readonly" value="<?php echo $arrhdr['KD_USER']; ?>">
              </div>
              <div class="col-sm-7">
                <input type="text" name="NAMA_USERLOGIN" id="NAMA_USERLOGIN" wajib="yes" class="form-control" placeholder="NAMA USER" value="<?php echo strtoupper($arrhdr['USER']); ?>" <?php echo ($act=="update")?"readonly":""; ?>>
              </div>
              <div class="col-sm-1" style="padding-top:2px">
                <button type="button" class="btn btn-primary btn-sm" onclick="popup_searchtwo('popup/popup_search/appuser/KD_USER|NAMA_USERLOGIN|NM_LENGKAP/2','','60','600')" <?php echo ($act=="update")?"disabled":""; ?>> <span class="icon-magnifier"></span></button>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label-left">KODE MENU</label>
              <div class="col-sm-2">
                <input type="text" class="form-control" name="DATA[KD_MENU]" id="KD_MENU" wajib="yes" placeholder="KODE" readonly="readonly" value="<?php echo $arrhdr['KD_MENU']; ?>">
              </div>
              <div class="col-sm-7">
              	<input type="text" name="NAMA_MENU" id="NAMA_MENU" wajib="yes" class="form-control" placeholder="NAMA MENU" value="<?php echo strtoupper($arrhdr['MENU']); ?>" <?php echo ($act=="update")?"readonly":""; ?>>
              </div>
              <div class="col-sm-1" style="padding-top:2px">
                <button type="button" class="btn btn-primary btn-sm" onclick="popup_searchtwo('popup/popup_search/appmenu/KD_MENU|NAMA_MENU/2','','60','600')" <?php echo ($act=="update")?"disabled":""; ?>> <span class="icon-magnifier"></span></button>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label-left">HAK AKSES</label>
              <div class="col-sm-10"> <?php echo form_dropdown('DATA[HAK_AKSES]',array('R'=>'READ','W'=>'WRITE'),$arrhdr['HAK_AKSES'],'id="HAK_AKSES" class="form-control"'); ?> </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
