<div class="card">
  <div class="card-block p-a-0">
    <div class="box-tab m-b-0" id="rootwizard">
      <ul class="wizard-tabs">
        <li class="active"><a href="#tab_aju" data-toggle="tab">DATA PENGAJUAN PLP</a></li>
        <li><a href="#tab_kms" data-toggle="tab">DATA KEMASAN PLP</a></li>
        <li style="width:100%;">&nbsp;</li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane p-x-lg active" id="tab_aju">
          <div class="row">
            <div class="col-md-6">
              <div class="card bg-white">
                <div class="card-header">DATA HEADER</div>
                <div class="card-block p-a-0">
                  <div class="table-responsive">
                    <table class="table m-b-0">
                      <tbody>
                        <tr>
                          <th width="35%">SARANA ANGKUT</th>
                          <td width="65%"><?php echo $arrhdr['NAMA_KAPAL']." [".$arrhdr['KD_KAPAL']."]"." - ".$arrhdr['NM_ANGKUT']; ?></td>
                        </tr>
                        <?php /*?><tr>
                          <th>CALL SIGN</th>
                          <td><?php echo $arrhdr['CALL_SIGN']; ?></td>
                        </tr><?php */?>
                        <tr>
                          <th>PEL. MUAT</th>
                          <td><?php echo $arrhdr['PEL_MUAT']; ?></td>
                        </tr>
                        <tr>
                          <th>PEL. TRANSIT</th>
                          <td><?php echo $arrhdr['PEL_TRANSIT']; ?></td>
                        </tr>
                        <tr>
                          <th>PEL. BONGKAR</th>
                          <td><?php echo $arrhdr['PEL_BONGKAR']; ?></td>
                        </tr>
                        <tr>
                          <th>NO. VOYAGE/FLIGHT</th>
                          <td><?php echo $arrhdr['NO_VOY_FLIGHT']; ?></td>
                        </tr>
                        <tr>
                          <th>TGL. TIBA</th>
                          <td><?php echo $arrhdr['TGL_TIBA']; ?></td>
                        </tr>
                        <tr>
                          <th>DATA BC11</th>
                          <td><?php echo "NO. ".$arrhdr['NO_BC11']." TGL. ".$arrhdr['TGL_BC11']; ?></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="card bg-white">
                <div class="card-header">DATA PENGAJUAN PLP</div>
                <div class="card-block p-a-0">
                  <div class="table-responsive">
                    <table class="table m-b-0">
                      <tbody>
                        <tr>
                          <th width="30%">SURAT</th>
                          <td><?php echo "NO. ".$arrplp['NO_SURAT']." TGL. ".$arrplp['TGL_SURAT']; ?></td>
                        </tr>
                        <tr>
                          <th>TPS TUJUAN</th>
                          <td><?php echo $arrplp['TPS_TUJUAN']." [".$arrplp['KD_TPS_TUJUAN']."]"; ?></td>
                        </tr>
                        <tr>
                          <th>GUDANG TUJUAN</th>
                          <td><?php echo $arrplp['GUDANG_TUJUAN']." [".$arrplp['KD_GUDANG_TUJUAN']."]" ?></td>
                        </tr>
                        <tr>
                          <th>YOR ASAL</th>
                          <td><?php echo $arrplp['YOR_ASAL']; ?></td>
                        </tr>
                        <tr>
                          <th>YOR TUJUAN</th>
                          <td><?php echo $arrplp['YOR_TUJUAN']; ?></td>
                        </tr>
                        <tr>
                          <th>NAMA PEMOHON</th>
                          <td><?php echo $arrplp['NM_PEMOHON']; ?></td>
                        </tr>
                        <tr>
                          <th>ALASAN PLP</th>
                          <td><?php echo $arrplp['ALASAN_PLP']; ?></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="tab-pane p-x-lg" id="tab_kms">
        	<?php echo $table_kemasan; ?>
        </div>
      </div>
    </div>
  </div>
</div>
