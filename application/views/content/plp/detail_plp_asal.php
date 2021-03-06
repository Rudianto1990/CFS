<div class="card">
  <div class="card-block p-a-0">
    <div class="box-tab m-b-0" id="rootwizard">
      <ul class="wizard-tabs">
        <li class="active"><a href="#tab_batal" data-toggle="tab">DATA RESPON PLP TPS ASAL</a></li>
        <li style="width:100%;">&nbsp;</li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane p-x-lg active" id="tab_batal">
          <div class="row">
            <div class="col-md-12">
              <div class="card bg-white">
                <div class="card-header">DATA RESPON PLP TPS ASAL</div>
                <div class="card-block p-a-0">
                  <div class="table-responsive">
                    <table class="table m-b-0">
                      <tbody>
                        <tr>
                          <th>REF NUMBER</th>
                          <td><?php echo $arrhdr['REF_NUMBER']; ?></td>
                        </tr>
                      	<tr>
                          <th width="20%">PLP</th>
                          <td width="75%"><?php echo "NO. ".$arrhdr['NO_PLP']." TGL. ".date_input($arrhdr['TGL_PLP']); ?></td>
                        </tr>
                        <tr>
                          <th>KODE KPBC</th>
                          <td><?php echo $arrhdr['KD_KPBC']; ?></td>
                        </tr>
                        <tr>
                          <th>TPS</th>
                          <td><?php echo $arrhdr['TPS']." [".$arrhdr['KD_TPS']."]"; ?></td>
                        </tr>
                        <tr>
                          <th>ALASAN</th>
                          <td><?php echo $arrhdr['ALASAN_REJECT']; ?></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="card">
              <div class="card-block p-a-0">
                <div class="box-tab m-b-0" id="rootwizard">
                  <ul class="wizard-tabs">
                    <li class="active"><a href="#tab_kms" data-toggle="tab">DATA KONTAINER</a></li>
                    <li style="width:100%;">&nbsp;</li>
                  </ul>
                  <div class="tab-content">
                    <div class="tab-pane p-x-lg active" id="tab_kms">
                    	<?php echo $table_kemasan; ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>
