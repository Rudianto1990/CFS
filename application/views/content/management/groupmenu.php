<div class="card">
  <div class="card-block p-a-0">
    <div class="box-tab m-b-0" id="rootwizard">
      <ul class="wizard-tabs">
        <li class="active"><a href="#tab1" data-toggle="tab">GROUP MENU</a></li>
        <li style="width:100%;"> <a data-toggle="" style="text-align:right">
          <button type="button" class="btn btn-primary btn-icon" onclick="save_popup('form_data','divtblgroupmenu'); return false;">Save <i class="icon-check"></i></button></a>
        </li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane p-x-lg active" id="tab1">
          <form name="form_data" id="form_data" class="form-horizontal" role="form" action="<?php echo site_url('management/execute/' . $act . '/groupmenu/' . $ID); ?>" method="post" autocomplete="off" onsubmit="save_post('form_data','divtblgroupmenu'); return false;">
            <div class="form-group">
              <label class="col-sm-2 control-label-left">TIPE ORGANISASI</label>
              <div class="col-sm-2">
                <input type="text" class="form-control" name="ID" id="ID" wajib="yes" placeholder="KODE" readonly="readonly" value="<?php echo $arrhdr['ID']; ?>">
              </div>
              <div class="col-sm-8">
                <input type="text" name="NAMA" id="NAMA" wajib="yes" class="form-control" placeholder="TIPE ORGANISASI" value="<?php echo strtoupper($arrhdr['NAMA']); ?>" <?php echo ($act == "update") ? "readonly" : ""; ?>>
              </div>
              <!--div class="col-sm-1" style="padding-top:2px">
                  <button type="button" class="btn btn-primary btn-sm" onclick="popup_searchtwo('popup/popup_search/tipe_organisasi/ID|NAMA/2','','60','600')" <?php //echo ($act == "update") ? "disabled" : ""; ?>> <span class="icon-magnifier"></span></button>
              </div-->
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label-left">KODE GROUP</label>
              <div class="col-sm-2">
                <input type="text" class="form-control" name="GROUP" id="GROUP" wajib="yes" placeholder="KODE" readonly="readonly" value="<?php echo $arrhdr['GROUP']; ?>">
              </div>
              <div class="col-sm-8">
                <input type="text" name="NAMA_GROUP" id="NAMA_GROUP" wajib="yes" class="form-control" placeholder="NAMA GROUP" value="<?php echo strtoupper($arrhdr['NAMA GROUP']); ?>" <?php echo ($act == "update") ? "readonly" : ""; ?>>
              </div>
              <!--div class="col-sm-1" style="padding-top:2px">
                  <button type="button" class="btn btn-primary btn-sm" onclick="popup_searchtwo('popup/popup_search/tipe_organisasi/ID|NAMA/2','','60','600')" <?php //echo ($act == "update") ? "disabled" : ""; ?>> <span class="icon-magnifier"></span></button>
              </div-->
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label-left">MENU</label>
              <div class="col-sm-2">
                <input type="checkbox" name="CBX_ALL" id="CBX_ALL" onclick="check_all(this.checked);"> CHECK ALL
              </div>
              <div class="col-sm-8">
                <?php echo $menus;  ?>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
  function check_all(status){
    if(status==false){
      $('.KD_MENU').prop("checked",status);
    }else{
      $('.KD_MENU').prop("checked",status);
    }
  }
  $(function(){
    autocomplete('NAMA','/autocomplete/management/reff_tipe_organisasi/nama',function(event, ui){
      event.preventDefault();
      $('#NAMA').val(ui.item.value);
      $('#ID').val(ui.item.NAMANYA);
    });
    autocomplete('NAMA_GROUP','/autocomplete/management/app_group/nama',function(event, ui){
      event.preventDefault();
      $('#NAMA_GROUP').val(ui.item.value);
      $('#GROUP').val(ui.item.NAMANYA);
    });
  });
</script>
