<div class="card">
  <div class="card-block p-a-0">
    <div class="box-tab m-b-0" id="rootwizard">
      <ul class="wizard-tabs">
        <li class="active"><a href="#tab1" data-toggle="tab"><?php echo $title; ?></a></li>
        <li style="width:100%;"> <a data-toggle="" style="text-align:right">
          <?php if($act=='proses'){?><button type="button" class="btn btn-primary btn-icon" id="buti" onclick="<?php echo 'process_popup(\'form_data\',\'divtblppbarang\',\''.$gd.'\');';?> return false;"><?php echo $label;?><i class="icon-check"></i></button><?php } ?>
          </a> </li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane p-x-lg active" id="tab1">
          <form name="form_data" id="form_data" class="form-horizontal" role="form" action="<?php echo site_url('order/execute/'.$act.'/sppb/'.$id); ?>" method="post" autocomplete="off" onsubmit="<?php echo ($act=='proses')?'process_popup(\'form_data\',\'divtblppbarang\',\''.$gd.'\');':'save_popup(\'form_data\',\'divtblppbarang\');';?> return false;">
      <?php if($act=='proses'){?>
      <div class="form-group">
              <label class="col-sm-4 control-label-left">NO ORDER</label>
              <div class="col-sm-8">
                <input type="text" name="NO_ORDER" value="<?php echo $arrhdr['NO_ORDER']; ?>" id="NO_ORDER" class="form-control" readonly>
              </div>
            </div>
      <?php }?>
            <div class="form-group">
              <label class="col-sm-4 control-label-left">NO BL <?php echo ($act!='proses')?"":'';?></label>
              <div class="col-sm-8">
                <input type="text" name="NO_BL_AWB" value="<?php echo $arrhdr['NO_BL_AWB']; ?>" wajib="yes" id="NO_BL_AWB" class="form-control" placeholder="AUTOCOMPLETE" maxlength="50" <?php echo ($act=='proses')?'readonly':'';?>>
                <input type="hidden" name="NO_BL_AWB1" value="<?php echo $arrhdr['NO_BL_AWB']; ?>" readonly>
              </div>
            </div>
      <div class="form-group">
        <label class="col-sm-4 control-label-left">JENIS TRANSAKSI</label>
        <div class="col-sm-8">
        <input type="text" name="JENIS_TRANSAKSI" value="<?php if($arrhdr['JENIS_TRANSAKSI']=='B'){ echo 'BARU'; }elseif($arrhdr['JENIS_TRANSAKSI']=='P'){ echo 'PERPANJANGAN'; }else{ echo '';} ?>" id="JENIS_TRANSAKSI" placeholder="JENIS TRANSAKSI" class="form-control" readonly> 
        </div>
      </div>
            <div class="form-group">
              <label class="col-sm-3 control-label-left" >SPPB</label>
      </div>
            <div class="form-group">
              <label class="col-sm-offset-1 col-sm-3 control-label-left" >JENIS DOKUMEN IZIN</label>
              <div class="col-sm-8">
               <input type="hidden" name="JENIS_DOK_IZIN" id="JENIS_DOK_IZIN" value="<?php echo $arrhdr['KODE_DOK']; ?>">
               <input type="text" name="DOK_BC" value="<?php echo $arrhdr['DOK_BC']; ?>" id="DOK_BC" class="form-control" placeholder="JENIS DOKUMEN IZIN" maxlength="50" readonly<?php //echo ($act=='proses')?'readonly':'';?>>
              </div>
      </div>
            <div class="form-group">
              <label class="col-sm-offset-1 col-sm-3 control-label-left" >NO SPPB</label>
              <div class="col-sm-4">
                <input type="hidden" name="CAR" id="CAR" value="<?php echo $arrhdr['CAR']; ?>">
                <input type="text" class="form-control" name="NO_SPPB" id="NO_SPPB" wajib="yes" placeholder="NOMOR SPPB" value="<?php echo $arrhdr['NO_SPPB']; ?>" maxlength="50" readonly<?php //echo ($act=='proses')?'readonly':'';?>>
              </div>
              <div class="col-sm-4">
                <div class="input-prepend input-group"><span class="add-on input-group-addon"><i class="icon-calendar"></i></span>
                  <input class="form-control drp" type="text" value="<?php echo $arrhdr['TGL_SPPB']; ?>"  placeholder="TANGGAL SPPB" name="TGL_SPPB" id="TGL_SPPB" data-provide="datepicker" wajib="yes" readonly<?php //echo ($act=='proses')?'readonly':'';?>>
                </div>
              </div>
            </div>
                <input type="hidden" class="form-control" name="KD_KPBC" id="KD_KPBC" wajib="no" onkeyup="cek();" placeholder="KODE KPBC" value="<?php echo $arrhdr['KD_KPBC']; ?>" maxlength="50" <?php echo ($act=='proses')?'readonly':'';?>>
                <input type="hidden" class="form-control" id="NM_KPBC" wajib="no" placeholder="NAMA KPBC" value="<?php echo $arrhdr['NM_KPBC']; ?>" <?php echo ($act=='proses')?'readonly':'';?>>
            <!--div class="form-group">
              <label class="col-sm-4 control-label-left">KODE KPBC</label>
              <div class="col-sm-3">
              </div>
              <div class="col-sm-5">
              </div>
            </div-->
            <div class="form-group">
              <label class="col-sm-4 control-label-left">NAMA PEMILIK</label>
              <div class="col-sm-8">
                <input type="text" name="CONSIGNEE" value="<?php echo $arrhdr['CONSIGNEE']; ?>" wajib="yes" id="CONSIGNEE" class="form-control" placeholder="NAMA PEMILIK" maxlength="50" readonly<?php //echo ($act=='proses')?'readonly':'';?>>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-4 control-label-left">NPWP PEMILIK</label>
              <div class="col-sm-8">
                <input type="text" name="NPWP_CONSIGNEE" value="<?php echo $arrhdr['NPWP_CONSIGNEE']; ?>" wajib="yes" id="NPWP_CONSIGNEE" class="form-control" placeholder="NPWP PEMILIK" readonly<?php //echo ($act=='proses')?'readonly':'';?>>
              </div>
            </div>
      <div class="form-group">
        <label class="col-sm-4 control-label-left">ALAMAT PEMILIK</label>
        <div class="col-sm-8">
        <textarea name="ALAMAT_CONSIGNEE" id="ALAMAT_CONSIGNEE" wajib="no" class="form-control" placeholder="ALAMAT PEMILIK" <?php //echo ($act=='proses')?'readonly':'';?> readonly><?php echo $arrhdr['ALAMAT_CONSIGNEE']; ?></textarea>
        </div>
      </div>
            <div class="form-group">
              <label class="col-sm-4 control-label-left">NAMA KAPAL</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" name="NAMA_KAPAL" id="NAMA_KAPAL" wajib="yes" placeholder="NAMA KAPAL" value="<?php echo htmlspecialchars($arrhdr['NM_ANGKUT']); ?>" maxlength="50" readonly<?php //echo ($act=='proses')?'readonly':'';?>>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-4 control-label-left">NO VOYAGE</label>
              <div class="col-sm-4">
                <input type="text" class="form-control" name="NO_VOY_FLIGHT" id="NO_VOY_FLIGHT" wajib="yes" placeholder="NO VOYAGE" value="<?php echo $arrhdr['NO_VOYAGE']; ?>" maxlength="50" readonly<?php //echo ($act=='proses')?'readonly':'';?>>
              </div>
              <div class="col-sm-4">
                <div class="input-prepend input-group"><span class="add-on input-group-addon"><i class="icon-calendar"></i></span>
                  <input class="form-control drp" type="text" value="<?php echo $arrhdr['TGL_TIBA']; ?>"  placeholder="TANGGAL TIBA" name="TGL_TIBA" id="TGL_TIBA" data-provide="datepicker" wajib="no" <?php echo ($act=='proses' || $arrhdr['TGL_TIBA']!='')?'readonly':'';?>>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-4 control-label-left">NO CONTAINER ASAL</label>
              <div class="col-sm-8">
                <input type="text" name="NO_CONT_ASAL" value="<?php echo $arrhdr['NO_CONT_ASAL']; ?>" wajib="no" id="NO_CONT_ASAL" class="form-control" placeholder="NOMOR CONTAINER ASAL" maxlength="50" <?php echo ($act=='proses' || $arrhdr['NO_CONT_ASAL']!='')?'readonly':'';?>>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-4 control-label-left">TANGGAL STRIPPING</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" name="TGL_STRIPPING" id="TGL_STRIPPING" placeholder="TGL STRIPPING" value="<?php echo $arrhdr['TGL_STRIPPING_B']; ?>" readonly>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-4 control-label-left">NO POLISI TRUCK</label>
              <div class="col-sm-8">
                <input type="text" name="NO_POLISI_TRUCK" value="<?php echo $arrhdr['NO_POLISI_TRUCK']; ?>" wajib="no" id="NO_POLISI_TRUCK" class="form-control" placeholder="NOMOR POLISI TRUCK" maxlength="50" <?php echo ($act=='proses')?'readonly':'';?>>
              </div>
            </div>
      <?php if($act=='proses'){?>
      <div class="form-group" <?php if($arrhdr['TGL_KELUAR_LAMA']=='') echo 'style="display:none;"'; ?>>
        <label class="col-sm-4 control-label-left">TANGGAL KELUAR LAMA</label>
        <div class="col-sm-8">
        <div class="input-prepend input-group"><span class="add-on input-group-addon"><i class="icon-calendar"></i></span>
          <input class="form-control drp" type="text" placeholder="TGL KELUAR LAMA" name="TGL_KELUAR_LAMA" id="TGL_KELUAR_LAMA" data-provide="datepicker" value="<?php echo $arrhdr['TGL_KELUAR_LAMA']; ?>" readonly>
        </div>
        </div>
      </div>
      <?php }?>
            <div class="form-group">
              <label class="col-sm-4 control-label-left">TANGGAL KELUAR</label>
              <div class="col-sm-8">
                <div class="input-prepend input-group"><span class="add-on input-group-addon"><i class="icon-calendar"></i></span>
                  <input class="form-control pdrp" type="text" value="<?php echo $arrhdr['TGL_KELUAR']; ?>"  placeholder="TANGGAL KELUAR" name="TGL_KELUAR" id="TGL_KELUAR" data-provide="datepicker" wajib="yes" <?php echo ($act=='proses')?'readonly':'';?>>
                </div>
              </div>
            </div>
            <!--div class="form-group">
              <label class="col-sm-4 control-label-left">JENIS PEMBAYARAN</label>
              <div class="col-sm-8">
                <select name="JENIS_BAYAR" wajib="yes" id="JENIS_BAYAR" class="form-control" <?php echo ($act=='proses')?'readonly':'';?>>
          <option></option>
          <option value="A" <?php echo ($arrhdr['JENIS_BAYAR']=='A')?'selected':''; ?>>CASH</option>
          <option value="B" <?php echo ($arrhdr['JENIS_BAYAR']=='B')?'selected':''; ?>>KREDIT</option>
        </select>
              </div>
            </div-->
            <div class="form-group">
              <label class="col-sm-3 control-label-left" >D/O</label>
      </div>
            <div class="form-group">
              <label class="col-sm-offset-1 col-sm-3 control-label-left" >NOMOR D/O</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" name="NO_DO" id="NO_DO" wajib="no" placeholder="NOMOR D/O" value="<?php echo $arrhdr['NO_DO']; ?>" maxlength="50" <?php echo ($act=='proses')?'readonly':'';?>>
              </div>
      </div>
            <div class="form-group">
              <label class="col-sm-offset-1 col-sm-3 control-label-left" >TANGGAL D/O</label>
              <div class="col-sm-4">
                <div class="input-prepend input-group"><span class="add-on input-group-addon"><i class="icon-calendar"></i></span>
                  <input class="form-control drp" type="text" value="<?php echo $arrhdr['TGL_DO']; ?>"  placeholder="TANGGAL D/O" name="TGL_DO" id="TGL_DO" data-provide="datepicker" wajib="no" <?php echo ($act=='proses')?'readonly':'';?>>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="input-prepend input-group"><span class="add-on input-group-addon"><i class="icon-calendar"></i></span>
                  <input class="form-control drp" type="text" value="<?php echo $arrhdr['TGL_EXPIRED_DO']; ?>"  placeholder="TANGGAL EXPIRED D/O" name="TGL_EXPIRED_DO" id="TGL_EXPIRED_DO" data-provide="datepicker" wajib="no" <?php echo ($act=='proses')?'readonly':'';?>>
                </div>
              </div>
      </div>
            <!--div class="form-group">
              <label class="col-sm-4 control-label-left">NAMA PBM</label>
              <div class="col-sm-8">
                <input type="text" name="NAMA_FORWARDER" value="<?php echo $arrhdr['NAMA_FORWARDER']; ?>" wajib="no" id="NAMA_FORWARDER" class="form-control" placeholder="NAMA PBM" maxlength="50" <?php echo ($act=='proses')?'readonly':'';?>>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-4 control-label-left">NPWP PBM</label>
              <div class="col-sm-8">
                <input type="text" name="NPWP_FORWARDER" value="<?php echo $arrhdr['NPWP_FORWARDER']; ?>" wajib="no" id="NPWP_FORWARDER" class="form-control" placeholder="NPWP PBM" maxlength="15" readonly>
              </div>
            </div>
      <div class="form-group">
        <label class="col-sm-4 control-label-left">ALAMAT PBM</label>
        <div class="col-sm-8">
        <textarea name="ALAMAT_FORWARDER" id="ALAMAT_FORWARDER" wajib="no" class="form-control" placeholder="ALAMAT PBM" <?php echo ($act=='proses')?'readonly':'';?> readonly><?php echo $arrhdr['ALAMAT_FORWARDER']; ?></textarea>
        </div>
      </div-->
            <div class="form-group">
              <label class="col-sm-4 control-label-left">NAMA COSTUMER</label>
              <div class="col-sm-8">
                <input type="text" name="NAMA_FORWARDER" value="<?php echo $arrhdr['NAMA_FORWARDER']; ?>" wajib="no" id="NAMA_FORWARDER" class="form-control" placeholder="NAMA COSTUMER" maxlength="50" <?php echo ($act=='proses')?'readonly':'';?>>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-4 control-label-left">NPWP COSTUMER</label>
              <div class="col-sm-8">
                <input type="text" name="NPWP_FORWARDER" value="<?php echo $arrhdr['NPWP_FORWARDER']; ?>" wajib="no" id="NPWP_FORWARDER" class="form-control" placeholder="NPWP COSTUMER" maxlength="15" readonly>
              </div>
            </div>
      <div class="form-group">
        <label class="col-sm-4 control-label-left">ALAMAT COSTUMER</label>
        <div class="col-sm-8">
        <textarea name="ALAMAT_FORWARDER" id="ALAMAT_FORWARDER" wajib="no" class="form-control" placeholder="ALAMAT COSTUMER" <?php echo ($act=='proses')?'readonly':'';?> readonly><?php echo $arrhdr['ALAMAT_FORWARDER']; ?></textarea>
        </div>
      </div>
            <div class="form-group">
              <?php echo ($act=='proses')?'<label class="col-sm-4 control-label-left">GUDANG</label>':'';?>
              <div class="col-sm-8">
                <input type="hidden" class="form-control" name="KD_GUDANG_TUJUAN" id="KD_GUDANG_TUJUAN" wajib="yes" placeholder="KD_GUDANG_TUJUAN" value="<?php echo $arrhdr['KD_GUDANG_TUJUAN']; ?>" maxlength="50">
                <input type="<?php echo ($act=='proses')?'text':'hidden';?>" class="form-control" name="GUDANG" id="GUDANG_TUJUAN" wajib="yes" placeholder="GUDANG" value="<?php echo $arrhdr['NM_GUDANG']; ?>" maxlength="50" readonly>
              </div>
            </div>
            <input type="hidden" class="form-control" name="NO_MASTER_BL_AWB" id="NO_MASTER_BL_AWB" placeholder="NO_MASTER_BL_AWB" value="<?php echo $arrhdr['NO_MASTER_BL_AWB']; ?>">
            <input type="hidden" class="form-control" name="TGL_MASTER_BL_AWB" id="TGL_MASTER_BL_AWB" placeholder="TGL_MASTER_BL_AWB" value="<?php echo $arrhdr['TGL_MASTER_BL_AWB']; ?>">
            <input type="hidden" class="form-control" name="TGL_BL_AWB" id="TGL_BL_AWB" placeholder="TGL_BL_AWB" value="<?php echo $arrhdr['TGL_BL_AWB']; ?>">
            <input type="hidden" class="form-control" name="NO_BC11" id="NO_BC11" placeholder="NO_BC11" value="<?php echo $arrhdr['NO_BC11']; ?>">
            <input type="hidden" class="form-control" name="TGL_BC11" id="TGL_BC11" placeholder="TGL_BC11" value="<?php echo $arrhdr['TGL_BC11']; ?>">
            <input type="hidden" class="form-control" name="ID_PERMIT" id="ID_PERMIT" placeholder="ID_PERMIT" value="<?php echo $arrhdr['ID_PERMIT']; ?>">
            <input type="hidden" class="form-control" name="CUSTOMER_NUMBER" id="CUSTOMER_NUMBER" placeholder="CUSTOMER_NUMBER" value="<?php echo $arrhdr['CUSTOMER_NUMBER']; ?>">
      <?php if($act=='save' || $act=='update'){?>
      <div class="text-center">
        <button type="reset" class="btn btn-danger btn-icon">RESET<i class="icon-refresh"></i></button>
        <button type="button" class="btn btn-primary btn-icon" id="buti" onclick="<?php echo 'save_popup(\'form_data\',\'divtblppbarang\');';?> return false;"><?php echo 'SAVE';?><i class="icon-check"></i></button>
      </div>
      <?php } ?>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
  function cek() {
  var telpon = document.getElementById('KD_KPBC');
    telpon.value = telpon.value.replace(/[^0-9+]+/, '');
  };
  /* jQuery(function($){
      $("#NPWP_IMP,#NPWP_FORWARDER").mask("99.999.999.9-999.999");
  }); */
$(function(){
  date('drp');
  past_date('pdrp');
    autocomplete('NO_BL_AWB','/autocomplete/ppbarang/no_bl/nama',function(event, ui){
    $('#NO_MASTER_BL_AWB').val(ui.item.NO_MASTER_BL_AWB);
    $('#TGL_MASTER_BL_AWB').val(ui.item.TGL_MASTER_BL_AWB);
    $('#NO_BL_AWB').val(ui.item.NO_BL_AWB);
    $('#TGL_BL_AWB').val(ui.item.TGL_BL_AWB);
    $('#KD_GUDANG_TUJUAN').val(ui.item.KD_GUDANG_TUJUAN);
    $('#GUDANG_TUJUAN').val(ui.item.NM_GUDANG);
    $('#NO_BC11').val(ui.item.NO_BC11);
    $('#TGL_BC11').val(ui.item.TGL_BC11);
    $('#NAMA_KAPAL').val(ui.item.NM_ANGKUT);
    $('#TGL_TIBA').val(ui.item.TGL_TIBA);
    $('#NO_VOY_FLIGHT').val(ui.item.NO_VOY_FLIGHT);
    $('#CONSIGNEE').val(ui.item.CONSIGNEE);
    $('#NPWP_CONSIGNEE').val(ui.item.NPWP_CONSIGNEE);
    $('#ALAMAT_CONSIGNEE').val(ui.item.ALAMAT_CONSIGNEE);
    $('#ID_PERMIT').val(ui.item.ID_PERMIT);
    $('#JENIS_DOK_IZIN').val(ui.item.KD_DOK);
    $('#DOK_BC').val(ui.item.NM_DOK);
    $('#CAR').val(ui.item.CAR);
    $('#NO_SPPB').val(ui.item.NO_SPPB);
    $('#TGL_SPPB').val(ui.item.TGL_SPPB);
    $('#KD_KPBC').val(ui.item.KD_KANTOR);
    $('#NM_KPBC').val(ui.item.NM_KANTOR);
    $('#NO_CONT_ASAL').val(ui.item.NO_CONT_ASAL);
    $('#TGL_STRIPPING').val(ui.item.TGL_STRIPPING);
    $('#TGL_TIBA').prop('readonly', (ui.item.TGL_TIBA!='')?true:false);
    $('#CUSTOMER_NUMBER').val(ui.item.NUMBER);
    $('#NAMA_FORWARDER').val(ui.item.NAMA_FORWARDER);
    $('#NPWP_FORWARDER').val(ui.item.NPWP_FORWARDER);
    $('#ALAMAT_FORWARDER').val(ui.item.ALAMAT_FORWARDER);
    $('#JENIS_TRANSAKSI').val((ui.item.BL!='')?"PERPANJANGAN":"BARU");
    $('#NO_CONT_ASAL').prop('readonly', (ui.item.NO_CONT_ASAL!='')?true:false);
    $('#NO_SPPB,#TGL_SPPB,#DOK_BC,#NAMA_IMP,#NPWP_IMP,#NAMA_KAPAL,#NO_VOY_FLIGHT').prop('readonly', true);
    });
  autocomplete('GUDANG_TUJUAN','/autocomplete/ppbarang/reff_gudang/nama/2',function(event, ui){
    $('#GUDANG_TUJUAN').val(ui.item.KODE);
    $('#GUDANG_TUJUAN2').val(ui.item.NAMA);
  });
  autocomplete('NAMA_KAPAL','/autocomplete/status/reff_kapal/ship_name',function(event, ui){
    event.preventDefault();
    $('#NAMA_KAPAL').val(ui.item.NAMA);
    $('#CALL_SIGN').val(ui.item.CALLSIGN);
  });
  autocomplete('NAMA_FORWARDER','/autocomplete/ppbarang/no_bl/organisasi',function(event, ui){
    event.preventDefault();
    $('#NAMA_FORWARDER').val(ui.item.NAMA);
    $('#NPWP_FORWARDER').val(ui.item.NPWP);
    $('#ALAMAT_FORWARDER').val(ui.item.ALAMAT);
    $('#CUSTOMER_NUMBER').val(ui.item.NUMBER);
  });
  autocomplete('KD_KPBC','/autocomplete/status/reff_kpbc/nama',function(event, ui){
    event.preventDefault();
    $('#KD_KPBC').val(ui.item.KODE);
    $('#NM_KPBC').val(ui.item.NAMA);
  });
});
</script>
