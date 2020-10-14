<div class="card">
  <div class="card-block p-a-0">
    <div class="box-tab m-b-0" id="rootwizard">
      <ul class="wizard-tabs">
        <li class="active"><a href="#tab1" data-toggle="tab">DATA BONGKAR</a></li>
        <li><a href="#tab2" data-toggle="tab">DATA PENGAJUAN</a></li>
        <li style="width:100%;"> <a data-toggle="" style="text-align:right">
          <button type="button" class="btn btn-primary btn-icon" onclick="save_multiple_post('form_data|tblkemasan'); return false;">Save <i class="icon-check"></i></button>
          </a> </li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane p-x-lg active" id="tab1">
          <div class="row">
            <div class="col-md-6">
              <div class="card-block p-a-0">
                <div class="table-responsive">
                  <table class="table m-b-0">
                    <tbody>
                      <tr>
                        <th>SARANA ANGKUT</th>
                        <td><?php echo $arrhdr['NAMA_KAPAL']." [".$arrhdr['KD_KAPAL']."]"." - ".$arrhdr['NM_ANGKUT']; ?></td>
                      </tr>
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
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="card-block p-a-0">
                <div class="table-responsive">
                  <table class="table m-b-0">
                    <tbody>
                      <tr>
                        <th>NO. VOYAGE / FLIGHT</th>
                        <td><?php echo $arrhdr['NO_VOY_FLIGHT']; ?></td>
                      </tr>
                      <tr>
                        <th>TGL. TIBA / BERANGKAT</th>
                        <td><?php echo date_en($arrhdr['TGL_TIBA']); ?></td>
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
        </div>
        <div class="tab-pane p-x-lg" id="tab2">
          <div class="row">
            <div class="col-md-12">
              <form name="form_data" id="form_data" class="form-horizontal" role="form" action="<?php echo site_url('plp/execute/'.$act.'/pengajuan/'.$ID); ?>" method="post" autocomplete="off" onsubmit="save_post('form_data'); return false;">
                <div class="form-group">
                  <label class="col-sm-2 control-label-left">SURAT</label>
                  <div class="col-sm-7">
                    <input type="text" class="form-control" name="DATA[NO_SURAT]" id="NO_SURAT" wajib="yes" placeholder="NOMOR"  value="<?php echo $arrplp['NO_SURAT']; ?>">
                  </div>
                  <div class="col-sm-2">
                    <div class="input-prepend input-group"><span class="add-on input-group-addon"><i class="icon-calendar"></i></span>
                      <input class="form-control drp" type="text" placeholder="TANGGAL SURAT" name="DATA[TGL_SURAT]" id="TGL_SURAT" data-provide="datepicker" wajib="yes" value="<?php echo $arrplp['TGL_SURAT']; ?>">
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label-left">KODE GUDANG TUJUAN</label>
                  <div class="col-sm-2">
                  	<input type="hidden" name="DATA[KD_TPS_TUJUAN]" id="KD_TPS_TUJUAN" wajib="yes" value="<?php echo $arrplp['KD_TPS_TUJUAN']; ?>" readonly="readonly">
                    <input type="text" name="DATA[KD_GUDANG_TUJUAN]" id="KD_GUDANG_TUJUAN" wajib="yes" class="form-control" placeholder="KODE GUDANG TUJUAN" value="<?php echo $arrplp['KD_GUDANG_TUJUAN']; ?>">
                  </div>
                  <div class="col-sm-7">
                    <input type="text" name="GUDANG_TUJUAN" id="GUDANG_TUJUAN" wajib="yes" class="form-control" placeholder="NAMA GUDANG TUJUAN" value="<?php echo $arrplp['GUDANG_TUJUAN']; ?>">
                  </div>
                  <div class="col-sm-1" style="padding-top:2px">
                    <button type="button" class="btn btn-primary btn-sm" onclick="popup_search('popup/popup_search/gudang/KD_GUDANG_TUJUAN|GUDANG_TUJUAN|KD_TPS_TUJUAN','','60','600')"> <span class="icon-magnifier"></span></button>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label-left">ALASAN PLP</label>
                  <div class="col-sm-9">
                    <textarea name="NAMA_ALASAN_PLP" id="NAMA_ALASAN_PLP" class="form-control" placeholder="ALASAN PLP" ><?php echo $arrplp['ALASAN_PLP']; ?></textarea>
                  </div>
                  <input type="hidden" name="DATA[KD_ALASAN_PLP]" id="KD_ALASAN_PLP" wajib="yes" class="form-control" placeholder="KD ALASAN PLP" value="<?php echo $arrplp['KD_ALASAN_PLP']; ?>">
                  <div class="col-sm-1" style="padding-top:2px">
                    <button type="button" class="btn btn-primary btn-sm" onclick="popup_search('popup/popup_search/alasanplp/KD_ALASAN_PLP|NAMA_ALASAN_PLP','','60','600')"> <span class="icon-magnifier"></span></button>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label-left">YOR ASAL</label>
                  <div class="col-sm-9">
                    <input type="text" name="DATA[YOR_ASAL]" id="YOR_ASAL" class="form-control" placeholder="YOR ASAL" value="<?php echo $arrplp['YOR_ASAL']; ?>">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label-left">YOR TUJUAN</label>
                  <div class="col-sm-9">
                    <input type="text" name="DATA[YOR_TUJUAN]" id="YOR_TUJUAN" class="form-control" placeholder="YOR TUJUAN" value="<?php echo $arrplp['YOR_TUJUAN']; ?>">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label-left">NAMA PEMOHON</label>
                  <div class="col-sm-9">
                    <input type="text" name="DATA[NM_PEMOHON]" id="NM_PEMOHON" wajib="yes" class="form-control" placeholder="NAMA PEMOHON" value="<?php echo $arrplp['NM_PEMOHON']; ?>">
                  </div>
                </div>
                 <input type="hidden" name="DATA[KD_KAPAL]" id="KD_KAPAL" wajib="yes" value="<?php echo $arrhdr['KD_KAPAL']; ?>" readonly="readonly">
                 <input type="hidden" name="DATA[NM_ANGKUT]" id="NM_ANGKUT" wajib="yes" value="<?php echo $arrhdr['NM_ANGKUT']; ?>" readonly="readonly">
                 <input type="hidden" name="DATA[NO_VOY_FLIGHT]" id="NO_VOY_FLIGHT" wajib="yes" value="<?php echo $arrhdr['NO_VOY_FLIGHT']; ?>" readonly="readonly">
                 <input type="hidden" name="DATA[TGL_TIBA]" id="TGL_TIBA" wajib="yes" value="<?php echo $arrhdr['TGL_TIBA']; ?>" readonly="readonly">
                 <input type="hidden" name="DATA[NO_BC11]" id="NO_BC11" wajib="yes" value="<?php echo $arrhdr['NO_BC11']; ?>" readonly="readonly">
                 <input type="hidden" name="DATA[TGL_BC11]" id="TGL_BC11" wajib="yes" value="<?php echo $arrhdr['TGL_BC11']; ?>" readonly="readonly">
              </form>
            </div>
          </div>
          
          <div class="card">
          <div class="card-block p-a-0">
            <div class="box-tab m-b-0" id="rootwizard">
              <ul class="wizard-tabs">
                <li class="active"><a href="#tab_kemasan" data-toggle="tab">DATA KEMASAN</a></li>
                <li>&nbsp;</li>
              </ul>
              <div class="tab-content">
                <div class="tab-pane p-x-lg active" id="tab_kemasan">
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
<script>
$(function(){
	autocomplete('KD_GUDANG_TUJUAN','/plp/autocomplete/mst_gudang/kode',function(event, ui){
		$('#GUDANG_TUJUAN').val(ui.item.NAMAGUDANG);
		$('#KD_TPS_TUJUAN').val(ui.item.KODETPS);
	});
	autocomplete('GUDANG_TUJUAN','/plp/autocomplete/mst_gudang/nama',function(event, ui){
		$('#KD_TPS_TUJUAN').val(ui.item.KODETPS);
		$('#KD_GUDANG_TUJUAN').val(ui.item.KODEGUDANG);
	});
	autocomplete('NAMA_ALASAN_PLP','/plp/autocomplete/mst_alasan_plp',function(event, ui){
		$('#KD_ALASAN_PLP').val(ui.item.KODE);
	});
});
</script> 
