<div class="card">
  <div class="card-block p-a-0">
    <div class="box-tab m-b-0" id="rootwizard">
      <ul class="wizard-tabs">
        <li class="active"><a href="#gatein" data-toggle="tab">DATA KEMASAN</a></li>
        <li style="width:100%;"> <a data-toggle="" style="text-align:right"> 
          <button type="button" class="btn btn-primary btn-icon" onclick="save_popup('frm_kemasan','divtblkemasan'); return false;">DISCHARGE <i class="icon-check"></i></button>
          </a> </li>
      </ul>
      <div class="tab-content">
        <div class="row">
          <div class="tab-pane p-x-lg active" id="gatein">
            <form name="frm_kemasan" id="frm_kemasan" class="form-horizontal" role="form" action="<?php echo site_url('gate/execute/update/more_in_ex_lini_1-kms/'.$ID); ?>" method="post" autocomplete="off" onsubmit="save_popup('frm_kemasan','divtblkemasan'); return false;">
              <div class="col-sm-6">
                <?php if(set_setting('SETWKINOUT') == 'Y'): ?>
                <div class="form-group">
                  <label class="col-sm-3 control-label-left">GATE IN</label>
                  <div class="col-sm-6">
                    <div class="input-prepend input-group"><span class="add-on input-group-addon"><i class="icon-calendar"></i></span>
                      <input class="form-control drptime" type="text" placeholder="TANGGAL" name="DATA[WK_IN]" id="WK_IN" data-provide="datepicker" wajib="yes" value="<?php echo $arrkms['WK_IN']; ?>">
                    </div>
                  </div>
                </div>
                <?php endif; ?>
              </div>
              <input type="hidden" name="seri" id="seri" value="<?php echo $seri; ?>" readonly="readonly"/>
            </form>
            <div class="col-sm-12">
            	<?php echo $table_kemasan; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
$(function(){
	datetime('drptime');
});