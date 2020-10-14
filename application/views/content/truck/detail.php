            <div class="panel">
             <div class="panel-body container-fluid">
                <div class="row">
                  <div class="col-sm-12">
                    <form class="form-horizontal" role="form" autocomplete="off">
                      <div class="panel-body container-fluid">
                        <div class="row">
                          <div class="form-group form-material">
                            <label class="col-sm-3 control-label-left">ID TRUCKER</label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control <?php echo ($arrdata['ID']!="")?"focus":""; ?>" value="<?php echo $arrdata['ID']; ?>" readonly="readonly">
                              <div class="hint"></div>
                            </div>
                          </div>
                          <div class="form-group form-material">
                            <label class="col-sm-3 control-label-left">NAMA TRUCKER</label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control <?php echo ($arrdata['NM_TRUCKER']!="")?"focus":""; ?>" value="<?php echo $arrdata['NM_TRUCKER']; ?>" readonly="readonly">
                              <div class="hint"></div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
                <?php echo $table_truck; ?>
              </div>
            </div>
