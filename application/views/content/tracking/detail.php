<div class="card">
  <div class="card-block p-a-0">
    <div class="box-tab m-b-0" id="rootwizard">
      <ul class="wizard-tabs">
        <li class="active"><a href="#tab1" data-toggle="tab">TRACKING</a></li>
        <li class="active"><a href="#tab1" data-toggle="tab">DETAIL</a></li>
      </ul>
      <div class="tab-content" style="overflow: auto">
        <div class="tab-pane p-x-lg active" id="tab1" style="overflow: auto">
          <form class="form-horizontal" role="form" autocomplete="off">
            <div class="row">
              <div class="form-group form-material">
                <label class="col-sm-offset-1 col-sm-2 control-label-left">NO. BL/AWB</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control focus" value="<?php echo $arrdata['NO BL/AWB']; ?>" readonly="readonly">
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-offset-1 col-sm-2 control-label-left">JENIS KEMASAN</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control focus" value="<?php echo $arrdata['JENIS KEMASAN']; ?>" readonly="readonly">
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-offset-1 col-sm-2 control-label-left">JUMLAH KEMASAN</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control focus" value="<?php echo $arrdata['JUMLAH KEMASAN']; ?>" readonly="readonly">
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-offset-1 col-sm-2 control-label-left">CONTAINER ASAL</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control focus" value="<?php echo $arrdata['CONTAINER ASAL']; ?>" readonly="readonly">
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-offset-1 col-sm-2 control-label-left">NAMA KAPAL</label>
                <div class="col-sm-5">
                  <input type="text" class="form-control focus" value="<?php echo $arrdata['NAMA KAPAL']; ?>" readonly="readonly">
                </div>
                <div class="col-sm-3">
                  <input type="text" class="form-control focus" value="<?php echo $arrdata['CALL SIGN']; ?>" readonly="readonly">
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-offset-1 col-sm-2 control-label-left">NO VOYAGE</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control focus" value="<?php echo $arrdata['NO VOYAGE']; ?>" readonly="readonly">
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-offset-1 col-sm-2 control-label-left">TGL. TIBA</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control focus" value="<?php echo $arrdata['TGL. TIBA']; ?>" readonly="readonly">
                </div>
              </div>
              <div class="form-group form-material">
                <label class="col-sm-offset-1 col-sm-2 control-label-left"><?php echo ($arrdata['GATE IN']!='')?'RECEIVING':'DELIVERY'; ?></label>
                <div class="col-sm-8">
                  <input type="text" class="form-control focus" value="<?php echo ($arrdata['GATE IN']!='')?$arrdata['GATE IN']:$arrdata['GATE OUT']; ?>" readonly="readonly">
                </div>
              </div>
              <!--div class="form-group form-material">
                <label class="col-sm-offset-1 col-sm-2 control-label-left">DELIVERY</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control focus" value="<?php echo $arrdata['GATE OUT']; ?>" readonly="readonly">
                </div>
              </div-->
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
