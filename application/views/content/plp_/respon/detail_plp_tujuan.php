<div class="card">
  <div class="card-block p-a-0">
    <div class="box-tab m-b-0" id="rootwizard">
      <ul class="wizard-tabs">
        <li class="active"><a href="#tab_batal" data-toggle="tab">DATA RESPON PLP TUJUAN</a></li>
        <li style="width:100%;">&nbsp;</li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane p-x-lg active" id="tab_batal">
          <div class="row">
            <div class="col-md-12">
              <div class="card bg-white">
                <div class="card-header">DATA RESPON PLP TUJUAN</div>
                <div class="card-block p-a-0">
                  <div class="table-responsive">
                    <table class="table m-b-0">
                      <tbody>
                      	<tr>
                          <th width="20%">PLP</th>
                          <td width="75%"><?php echo "NO. ".$arrhdr['NO_PLP']." TGL. ".date_input($arrhdr['TGL_PLP']); ?></td>
                        </tr>
                        <tr>
                          <th>SURAT</th>
                          <td><?php echo "NO. ".$arrhdr['NO_SURAT']." TGL. ".date_input($arrhdr['TGL_SURAT']); ?></td>
                        </tr>
                        <tr>
                          <th>KODE KPBC</th>
                          <td><?php echo $arrhdr['KD_KPBC']; ?></td>
                        </tr>
                        <tr>
                          <th>TPS ASAL</th>
                          <td><?php echo $arrhdr['TPS_ASAL']." [".$arrhdr['KD_TPS_ASAL']."]"; ?></td>
                        </tr>
                        <tr>
                          <th>TPS TUJUAN</th>
                          <td><?php echo $arrhdr['TPS_TUJUAN']." [".$arrhdr['KD_TPS_TUJUAN']."]"; ?></td>
                        </tr>
                        <tr>
                          <th>GUDANG TUJUAN</th>
                          <td><?php echo $arrhdr['GUDANG_TUJUAN']." [".$arrhdr['KD_GUDANG_TUJUAN']."]" ?></td>
                        </tr>
                        <tr>
                          <th>DATA PENGANGKUT</th>
                          <td>
						  	<?php echo "NAMA ANGKUT : ".$arrhdr['NM_ANGKUT']."<BR>"; ?>
                            <?php echo "NO. VOYAGE/FLIGHT : ".$arrhdr['NO_VOY_FLIGHT']."<BR>"; ?>
                            <?php echo "CALL SIGN : ".$arrhdr['CALL_SIGN']."<BR>"; ?>
                            <?php echo "TGL. TIBA : ".date_input($arrhdr['TGL_TIBA'])."<BR>"; ?>
                            <?php echo "NO. BC11 : ".$arrhdr['NO_BC11']."<BR>"; ?>
                            <?php echo "TGL. BC11 : ".date_input($arrhdr['TGL_BC11'])."<BR>"; ?>
                          </td>
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
                    <li class="active"><a href="#tab_kms" data-toggle="tab">DATA KEMASAN</a></li>
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
