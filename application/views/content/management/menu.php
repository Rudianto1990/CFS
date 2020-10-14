<div class="card">
    <div class="card-block p-a-0">
        <div class="box-tab m-b-0" id="rootwizard">
            <ul class="wizard-tabs">
                <li class="active"><a href="#tab1" data-toggle="tab">MENU</a></li>
                <li style="width:100%;"> <a data-toggle="" style="text-align:right">
                        <button type="button" class="btn btn-primary btn-icon" onclick="save_popup('form_data','divtblmenu'); return false;">Save <i class="icon-check"></i></button>
                    </a> </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane p-x-lg active" id="tab1">
                    <form name="form_data" id="form_data" class="form-horizontal" role="form" action="<?php echo site_url('management/execute/' . $act . '/menu/' . $ID); ?>" method="post" autocomplete="off" onsubmit="save_popup('form_data','divtblmenu'); return false;">
                        <div class="form-group">
                            <label class="col-sm-2 control-label-left">NAMA PARENT</label>
                            <div class="col-sm-10"> <?php echo form_dropdown('DATA[ID_PARENT]', $arr_parent, $arrhdr['ID_PARENT'], 'id="ID_PARENT" class="form-control"'); ?> </div>
                            <input type="hidden" class="form-control" name="ID" id="ID"  placeholder="KODE" value="<?php echo $arrhdr['ID']; ?>">
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label-left">JUDUL MENU</label>
                            <div class="col-sm-10">
                                <input type="text" name="DATA[JUDUL_MENU]" id="JUDUL_MENU" wajib="yes" class="form-control" placeholder="JUDUL MENU" value="<?php echo $arrhdr['JUDUL_MENU']; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label-left">URL</label>
                            <div class="col-sm-10">
                                <input type="text" name="DATA[URL]" id="URL" wajib="yes" class="form-control" placeholder="URL" value="<?php echo $arrhdr['URL']; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label-left">URUTAN</label>
                            <div class="col-sm-10">
                                <input type="text" name="DATA[URUTAN]" id="URUTAN" wajib="yes" class="form-control" placeholder="URUTAN" value="<?php echo $arrhdr['URUTAN']; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label-left">TIPE</label>
                            <div class="col-sm-10">
                                <?php echo form_dropdown('DATA[TIPE]', array('F' => 'FOLDER', 'M' => 'MENU'), $arrhdr['TIPE'], 'id="TIPE" class="form-control"'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label-left">TARGET</label>
                            <div class="col-sm-10">
                                <?php echo form_dropdown('DATA[TARGET]', array('_SELF' => '_SELF', '_BLANK' => '_BLANK'), $arrhdr['TARGET'], 'id="TARGET" class="form-control"'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label-left">ACTION</label>
                            <div class="col-sm-10">
                                <?php echo form_dropdown('DATA[ACTION]', array('ONHREF' => 'ONHREF', 'ONCLICK' => 'ONCLICK'), $arrhdr['ACTION'], 'id="ACTION" class="form-control"'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label-left">ICON</label>
                            <div class="col-sm-10">
                                <input type="text" name="DATA[CLS_ICON]" id="CLS_ICON"  class="form-control" placeholder="CLS ICON" value="<?php echo $arrhdr['CLS_ICON']; ?>">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> 
