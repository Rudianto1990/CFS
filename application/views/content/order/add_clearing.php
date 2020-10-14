<div class="card">
  <div class="card-block p-a-0">
    <div class="box-tab m-b-0" id="rootwizard">
      <ul class="wizard-tabs">
        <li class="active"><a href="#tab1" data-toggle="tab"><?php echo $title; ?></a></li>
        <li style="width:100%;"> <a data-toggle="" style="text-align:right">
          <?php if($act=='save' || $arrhdr['KD_STATUS']=='100'){?><button type="button" class="btn btn-primary btn-icon" id="buti" onclick="<?php echo ($act=='proses')?'process_popup(\'form_data\',\'divtblclearing\',\''.$gd.'\');':'save_popup(\'form_data\',\'divtblclearing\');';?> return false;"><?php echo ($act=='proses')?'PROCESS':'SAVE';?><i class="icon-check"></i></button><?php } ?>
          </a> </li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane p-x-lg active" id="tab1">
          <form name="form_data" id="form_data" class="form-horizontal" role="form" action="<?php echo site_url('order/execute/'.$act.'/clearing/'.$id); ?>" method="post" autocomplete="off" onsubmit="<?php echo ($act=='proses')?'process_popup(\'form_data\',\'divtblclearing\',\''.$gd.'\');':'save_popup(\'form_data\',\'divtblclearing\');';?> return false;">
			<?php if($act=='proses'){?>
			<div class="form-group">
              <label class="col-sm-3 control-label-left">NO PEMBAYARAN PETIKEMAS</label>
              <div class="col-sm-9">
                <input type="text" name="NO_PIB" value="<?php echo $arrhdr['NO_ORDER']; ?>" id="NO_PIB" class="form-control" readonly>
              </div>
            </div>
			<?php }?>
            <div class="form-group">
              <!--label class="col-sm-3 control-label-left">NO PERMOHONAN CFS</label-->
              <div class="col-sm-9">
                <input type="hidden" name="NO_PERMOHONAN_CFS" value="<?php echo $arrhdr['NO_PERMOHONAN_CFS']; ?>" id="NO_PERMOHONAN_CFS" class="form-control" placeholder="NOMOR PERMOHONAN CFS" maxlength="50" <?php echo ($act=='proses')?'readonly':'';?>>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label-left">NO BL</label>
              <div class="col-sm-9">
                <input type="text" name="NO_BL_AWB" value="<?php echo $arrhdr['NO_BL_AWB']; ?>" wajib="yes" id="NO_BL_AWB" class="form-control" placeholder="NOMOR BL" maxlength="50" <?php echo ($act=='proses')?'readonly':'';?>>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label-left">JENIS PEMBAYARAN</label>
              <div class="col-sm-9">
                <select name="JENIS_BAYAR" wajib="yes" id="JENIS_BAYAR" class="form-control" <?php echo ($act=='proses')?'readonly':'';?>>
					<option></option>
					<option value="A" <?php echo ($arrhdr['JENIS_BAYAR']=='A')?'selected':''; ?>>CASH</option>
					<!--<option value="B" <?php echo ($arrhdr['JENIS_BAYAR']=='B')?'selected':''; ?>>KREDIT</option> -->
				</select>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label-left">TANGGAL KELUAR</label>
              <div class="col-sm-9">
                <div class="input-prepend input-group"><span class="add-on input-group-addon"><i class="icon-calendar"></i></span>
                  <input class="form-control drp" type="text" value="<?php echo $arrhdr['TGL_KELUAR']; ?>"  placeholder="TANGGAL KELUAR" name="TGL_KELUAR" id="TGL_KELUAR" data-provide="datepicker" wajib="yes" <?php echo ($act=='proses')?'readonly':'';?>>
                </div>
              </div>
            </div>
                <input type="hidden" name="NAMA_AGEN" value="<?php echo $arrhdr['NAMA_AGEN']; ?>" wajib="no" id="NAMA_AGEN" class="form-control" placeholder="NAMA AGEN" maxlength="50" <?php echo ($act=='proses')?'readonly':'';?>>
            <!--div class="form-group">
              <label class="col-sm-3 control-label-left">NAMA AGEN</label>
              <div class="col-sm-9">
              </div>
            </div-->
            <div class="form-group">
              <label class="col-sm-3 control-label-left">NAMA PBM</label>
              <div class="col-sm-9">
                <input type="text" name="NAMA_FORWARDER" value="<?php echo $arrhdr['NAMA_FORWARDER']; ?>" id="NAMA_FORWARDER" class="form-control" placeholder="NAMA PBM" maxlength="50" <?php echo ($act=='proses')?'readonly':'';?>>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label-left">NPWP PBM</label>
              <div class="col-sm-9">
                <input type="text" name="NPWP_FORWARDER" value="<?php echo $arrhdr['NPWP_FORWARDER']; ?>" id="NPWP_FORWARDER" class="form-control" placeholder="NPWP PBM" maxlength="15" readonly>
              </div>
            </div>
			<div class="form-group">
			  <label class="col-sm-3 control-label-left">ALAMAT PBM</label>
			  <div class="col-sm-9">
				<textarea name="ALAMAT_FORWARDER" id="ALAMAT_FORWARDER" wajib="no" class="form-control" placeholder="ALAMAT PBM" readonly><?php echo $arrhdr['ALAMAT_FORWARDER']; ?></textarea>
			  </div>
			</div>
            <div class="form-group">
              <label class="col-sm-3 control-label-left">NAMA PEMILIK</label>
              <div class="col-sm-9">
                <input type="text" name="NAMA_CONSIGNEE" value="<?php echo $arrhdr['CONSIGNEE']; ?>" wajib="no" id="NAMA_CONSIGNEE" class="form-control" placeholder="NAMA PEMILIK" maxlength="50" <?php echo ($act=='proses')?'readonly':'';?>>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label-left">NPWP PEMILIK</label>
              <div class="col-sm-9">
                <input type="text" name="NPWP_CONSIGNEE" value="<?php echo $arrhdr['NPWP_CONSIGNEE']; ?>" wajib="no" id="NPWP_CONSIGNEE" class="form-control" placeholder="NPWP PEMILIK" maxlength="15" <?php echo ($act=='proses')?'readonly':'';?>>
              </div>
            </div>
			<div class="form-group">
			  <label class="col-sm-3 control-label-left">ALAMAT PEMILIK</label>
			  <div class="col-sm-9">
				<input type="text" name="ALAMAT_CONSIGNEE" id="ALAMAT_CONSIGNEE" wajib="no" class="form-control" placeholder="ALAMAT PEMILIK" value="<?php echo $arrhdr['ALAMAT_CONSIGNEE']; ?>" <?php echo ($act=='proses')?'readonly':'';?>>
			  </div>
			</div>
            <div class="form-group">
              <label class="col-sm-3 control-label-left">TERMINAL ASAL</label>
              <div class="col-sm-<?php echo ($act=='proses')?'9':'8';?>">
                <input type="text" value="<?=$arrhdr['GUDANGASAL'];?>"  wajib="yes" id="NAMA_ASAL" class="form-control" placeholder="TERMINAL ASAL" <?php echo ($act=='proses')?'readonly':'';?>> 
                <input type="hidden" name="GUDANG_ASAL" value="<?=$arrhdr['KD_GUDANG_ASAL'];?>" wajib="yes" id="GUDANG_ASAL" class="form-control">
                <input type="hidden" name="TPS_ASAL" value="<?=$arrhdr['KD_TPS_ASAL'];?>" wajib="yes" id="TPS_ASAL" class="form-control">
              </div>
			  <?php if ($act!='proses') { ?>
			  <div class="col-sm-1" style="padding-top:2px">
				<button type="button" class="btn btn-primary btn-sm" onclick="popup_searchtwo('popup/popup_search/terminal/TPS_ASAL|GUDANG_ASAL|NAMA_ASAL/2','','60','600')"> <span class="icon-magnifier"></span></button>
			  </div>
			  <?php } ?>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label-left">GUDANG TUJUAN</label>
              <div class="col-sm-<?php echo ($act=='proses')?'9':'8';?>">
                <input type="text" value="<?=$arrhdr['GUDANGTUJUAN'];?>" value="" wajib="yes" id="NAMA_TUJUAN" class="form-control" placeholder="WAREHOUSE" <?php echo ($act=='proses')?'readonly':'';?>>
                <input type="hidden" name="GUDANG_TUJUAN" value="<?=$arrhdr['KD_GUDANG_TUJUAN'];?>" wajib="yes" id="GUDANG_TUJUAN" class="form-control">
                <input type="hidden" name="TPS_TUJUAN" value="<?=$arrhdr['KD_TPS_TUJUAN'];?>" wajib="yes" id="TPS_TUJUAN" class="form-control">
              </div>
			  <?php if ($act!='proses') { ?>
			  <div class="col-sm-1" style="padding-top:2px">
				<button type="button" class="btn btn-primary btn-sm" onclick="popup_searchtwo('popup/popup_search/warehouse/TPS_TUJUAN|GUDANG_TUJUAN|NAMA_TUJUAN/2','','60','600')"> <span class="icon-magnifier"></span></button>
			  </div>
			  <?php } ?>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label-left" >BC 1.1</label>
              <div class="col-sm-5">
                <input type="text" class="form-control" name="NO_BC11" id="NO_BC11" wajib="no" placeholder="NOMOR BC 1.1" value="<?php echo $arrhdr['NO_BC11']; ?>" maxlength="50" <?php echo ($act=='proses')?'readonly':'';?>>
              </div>
              <div class="col-sm-4">
                <div class="input-prepend input-group"><span class="add-on input-group-addon"><i class="icon-calendar"></i></span>
                  <input class="form-control drp" type="text" value="<?php echo $arrhdr['TGL_BC11']; ?>"  placeholder="TANGGAL BC 1.1" name="TGL_BC11" id="TGL_BC11" data-provide="datepicker" wajib="no" <?php echo ($act=='proses')?'readonly':'';?>>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label-left">KAPAL</label>
              <div class="col-sm-5">
                <input type="text" class="form-control" name="NAMA_KAPAL" id="NAMA_KAPAL" wajib="no" placeholder="NAMA KAPAL" value="<?php echo $arrhdr['NM_ANGKUT']; ?>" maxlength="50" <?php echo ($act=='proses')?'readonly':'';?>>
              </div>
              <div class="col-sm-4">
                <input type="text" class="form-control" name="CALL_SIGN" id="CALL_SIGN" wajib="no" placeholder="CALLSIGN" value="<?php echo $arrhdr['CALL_SIGN']; ?>" maxlength="50" <?php echo ($act=='proses')?'readonly':'';?>>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label-left"></label>
              <div class="col-sm-5">
                <input type="text" class="form-control" name="NO_VOY_FLIGHT" id="NO_VOY_FLIGHT" wajib="no" placeholder="NOMOR VOYAGE" value="<?php echo $arrhdr['NO_VOYAGE']; ?>" maxlength="50" <?php echo ($act=='proses')?'readonly':'';?>>
              </div>
              <div class="col-sm-4">
                <div class="input-prepend input-group"><span class="add-on input-group-addon"><i class="icon-calendar"></i></span>
                  <input class="form-control drp" type="text" value="<?php echo $arrhdr['TGL_TIBA']; ?>"  placeholder="TANGGAL TIBA" name="TGL_TIBA" id="TGL_TIBA" data-provide="datepicker" wajib="no" <?php echo ($act=='proses')?'readonly':'';?>>
                </div>
              </div>
            </div>
			<div class="card">
			  <div class="card-block p-a-0">
				<div class="box-tab m-b-0" id="rootwizard">
				  <ul class="wizard-tabs">
					<li class="active"><a href="#tab_kemasan" data-toggle="tab">DATA KONTAINER</a></li>
					<li>&nbsp;</li>
				  </ul>
				  <div class="tab-content">
					<div class="tab-pane p-x-lg active" id="tab_kemasan">
					  <div class="table-responsive">
						<table class="tabelajax responsive m-b-0" id="tblconte">
						  <tbody>
							<tr>
							  <th width="1%">
								<?php if ($act!='proses') { ?>
								  <input type="checkbox" id="tb_chkalltblconte" onclick="tb_chkall('tblconte',this.checked)" class="tb_chkall">
								<?php } else { echo 'No'; } ?>
							  </th>
							  <th>NO KONTAINER</th>
							  <th>UKURAN</th>
							  <th>NO POLISI TRUCK</th>
							  <th>KETERANGAN</th>
							</tr>
							<?php 
							if($act == "update" || $act == "proses"){
								$readonly = ($act=='proses')?'readonly':'';
								if($num_rows > 0){$io=1;
									foreach ($arrcont as $key) {
										echo '<tr>';
										echo ($act == "update")?'<td><input type="checkbox" name="tb_chktblconte[]" id="tb_chktblconte'.$io.'" class="tb_chk" value="'.$key->TB_CHK.'" onclick="tb_chk(\'tblconte\',this.checked,this.value)" data="'.$io.'" wajib="yes" '.$readonly.' checked></td>':'<td>'.$io.'</td>';
										echo '<td><input type="text" name="NO_CONT[]" maxlength="11" id="NO_CONT'.$io.'" onkeyup="change_cont('.$io.')" class="rank form-control" placeholder="NO KONTAINER" value="'.$key->NO_CONT.'" wajib="yes" '.$readonly.'></td>';
										echo '<td><select class="rank form-control" name="UKURAN_CONT[]" id="UKURAN_CONT'.$io.'" onchange="change_cont('.$io.')" wajib="yes" '.$readonly.'>';
										foreach ($CONT as $c) {
											if($key->KD_CONT_UKURAN == $c->ID){
												echo '<option value="'.$c->ID.'" selected="selected">'.$c->NAMA.'</option>'; 
											} else {
												echo '<option value="'.$c->ID.'">'.$c->NAMA.'</option>'; 
											}
										}	
										echo '</select></td>';
										echo '<td><input type="text" name="NO_POLISI_TRUCK[]" maxlength="11" id="NO_POL'.$io.'" onkeyup="change_cont('.$io.')" class="rank form-control" placeholder="NO POLISI TRUCK" value="'.$key->NO_POLISI_TRUCK.'" wajib="yes" '.$readonly.'></td>';
										echo '<td>SIAP</td></tr>';
									}
								}
							}
							?>
						  </tbody>
						</table>
						<input type="hidden" name="tmpchktblconte" id="tmpchktblconte" value="<?php echo $kontainer; ?>" wajib="yes" readonly="">
					  </div>
					  <br>
					<?php if ($act!='proses') { ?>
					  <button type="button" class="btn btn-primary btn-icon" onclick="GetDynamicTr()" id="addButton1"><i class="glyphicon glyphicon-plus"></i> Tambah Data</button>
					<?php } ?>
					</div>
				  </div>
				</div>
			  </div>
			</div>
            <input type="hidden" name="ID_DATA" value="<?php echo $ID_DATA; ?>" readonly="readonly"/>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
  jQuery(function($){
      $("#NPWP_FORWARDER, #NPWP_CONSIGNEE").mask("99.999.999.9-999.999");
  });
$(function(){
  date('drp');
  autocomplete('NO_BL_AWB','/autocomplete/ppbarang/no_bl/nama3',function(event, ui){
	  var rows = document.getElementById('tblconte').getElementsByTagName("tr").length;
	  if(rows>1){
	  console.log('rows = '+rows);
		for(var i = 1; i < rows; i++){
		  document.getElementById("tblconte").deleteRow(1);
		}
	  }
    $('#NO_BL_AWB').val(ui.item.NO_BL_AWB);
    $('#GUDANG_TUJUAN').val(ui.item.KD_GUDANG_TUJUAN);
    $('#TPS_TUJUAN').val(ui.item.KD_TPS);
    $('#NAMA_TUJUAN').val(ui.item.GUDANG);
    $('#NO_BC11').val(ui.item.NO_BC11);
    $('#TGL_BC11').val(ui.item.TGL_BC11);
    $('#NAMA_KAPAL').val(ui.item.NM_ANGKUT);
    $('#CALL_SIGN').val(ui.item.CALL_SIGN);
    $('#NO_VOY_FLIGHT').val(ui.item.NO_VOY_FLIGHT);
    $('#TGL_TIBA').val(ui.item.TGL_TIBA);
    $('#NAMA_CONSIGNEE').val(ui.item.CONSIGNEE);
    $('#NPWP_CONSIGNEE').val(ui.item.NPWP_CONSIGNEE);
	var response = ui.item.KONTAINER;
	var jj=1;
	for(var i = 0; i < response.length; i++){
		if(response[i].NOD==ui.item.NOH){
			var ds='';var wajib='';
			if(response[i].STATUS=='SIAP'){
				ds='';
				wajib='wajib="yes"';
			}else{
				ds='disabled';
				wajib='';
			}
			var option='';
			<?php foreach ($CONT as $c) {?>
				tes = '<?php echo $c->ID; ?>';
				if(response[i].KD_CONT_UKURAN == tes){
					option += '<?php echo '<option value="'.$c->ID.'" selected>'.$c->NAMA.'</option>'?>';
				}else{
					option += '<?php echo '<option value="'.$c->ID.'">'.$c->NAMA.'</option>'?>';
				}
			<?php } ?>
			var table = document.getElementById("tblconte");
			var row = table.insertRow(1);
			var cell1 = row.insertCell(0);
			var cell2 = row.insertCell(1);
			var cell3 = row.insertCell(2);
			var cell4 = row.insertCell(3);
			var cell5 = row.insertCell(4);
			cell1.innerHTML = '<input type="checkbox" name="tb_chktblconte[]" id="tb_chktblconte'+jj+'" class="tb_chk" value="'+response[i].NO_CONT + "~" + response[i].KD_CONT_UKURAN + "~" + response[i].STATUS+'" onclick="tb_chk(\'tblconte\',this.checked,this.value)" data="'+jj+'" '+wajib+' '+ds+'>';
			cell2.innerHTML = '<input type="text" name="NO_CONT[]" maxlength="11" id="NO_CONT'+jj+'" onkeyup="change_cont('+jj+')" class="rank form-control" placeholder="NO KONTAINER" value="'+response[i].NO_CONT+'" '+wajib+' '+ds+'>';
			cell3.innerHTML = '<select class="rank form-control" name="UKURAN_CONT[]" id="UKURAN_CONT'+jj+'" onchange="change_cont('+jj+')" '+wajib+' '+ds+'>'+option+'</select>';
			cell4.innerHTML = '<input type="text" name="NO_POLISI_TRUCK[]" maxlength="11" id="NO_POL'+jj+'" onkeyup="change_cont('+jj+')" class="rank form-control" placeholder="NO POLISI TRUCK" '+wajib+' '+ds+'>';
			cell5.innerHTML = response[i].STATUS;
		}
	}
  });
	autocomplete('NAMA_ASAL','/autocomplete/status/reff_gudang/nama/1',function(event, ui){
		$('#NAMA_ASAL').val(ui.item.NAMA);
		$('#GUDANG_ASAL').val(ui.item.GUDANG);
		$('#TPS_ASAL').val(ui.item.TPS);
	});
	autocomplete('NAMA_TUJUAN','/autocomplete/status/reff_gudang/nama/2',function(event, ui){    
		$('#NAMA_TUJUAN').val(ui.item.NAMA);
		$('#GUDANG_TUJUAN').val(ui.item.GUDANG);
		$('#TPS_TUJUAN').val(ui.item.TPS);
	});
  autocomplete('NAMA_FORWARDER','/autocomplete/ppbarang/no_bl/organisasi',function(event, ui){
    event.preventDefault();
    $('#NAMA_FORWARDER').val(ui.item.NAMA);
    $('#NPWP_FORWARDER').val(ui.item.NPWP);
    $('#ALAMAT_FORWARDER').val(ui.item.ALAMAT);
  });
	autocomplete('NAMA_KAPAL','/autocomplete/status/reff_kapal/ship_name',function(event, ui){
		event.preventDefault();
		$('#NAMA_KAPAL').val(ui.item.NAMA);
		$('#CALL_SIGN').val(ui.item.CALLSIGN);
	});
    $("#tblconte").on("click", ".remove1", function () {
        $(this).closest("tr").remove();
    });
});
function GetDynamicTr() {
	var option='';
	<?php foreach ($CONT as $c) {?>
		option += '<?php echo '<option value="'.$c->ID.'">'.$c->NAMA.'</option>'?>';
	<?php } ?>
	var ds='';
    var table = document.getElementById("tblconte");
	var rows = table.getElementsByTagName("tr").length;
    var row = table.insertRow(rows);
	var cell1 = row.insertCell(0);
	var cell2 = row.insertCell(1);
	var cell3 = row.insertCell(2);
	var cell4 = row.insertCell(3);
	var cell5 = row.insertCell(4);
	cell1.innerHTML = '<input type="checkbox" name="tb_chktblconte[]" id="tb_chktblconte'+rows+'" class="tb_chk" value="~20~" onclick="tb_chk(\'tblconte\',this.checked,this.value)" wajib="yes" data="'+rows+'" '+ds+'>';
	cell2.innerHTML = '<input type="text" name="NO_CONT[]" maxlength="11" id="NO_CONT'+rows+'" wajib="yes" onkeyup="change_cont('+rows+')" class="rank form-control" placeholder="NO KONTAINER" value=""'+ds+'>';
	cell3.innerHTML = '<select class="rank form-control" name="UKURAN_CONT[]" id="UKURAN_CONT'+rows+'" wajib="yes" onchange="change_cont('+rows+')" '+ds+'>'+option+'</select>';
	cell4.innerHTML = '<input type="text" name="NO_POLISI_TRUCK[]" maxlength="11" id="NO_POL'+rows+'" wajib="yes" onkeyup="change_cont('+rows+')"class="rank form-control" placeholder="NO POLISI TRUCK" '+ds+'>';
	cell5.innerHTML = '<button type="button" class="remove1 btn btn-danger" id="remove'+rows+'">Hapus</button>';
}
function change_cont(mm) {
    var option_result = document.getElementById("tb_chktblconte"+mm).value;
    var result = document.getElementById("NO_CONT"+mm).value;
    var result2 = document.getElementById("UKURAN_CONT"+mm).value;
    var result3 = document.getElementById("NO_POL"+mm).value;
    document.getElementById('tb_chktblconte'+mm).value = result+'~'+result2+'~'+result3;
}
</script>
