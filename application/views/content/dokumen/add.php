<div class="card">
  <div class="card-block p-a-0">
    <div class="box-tab m-b-0" id="rootwizard">
      <ul class="wizard-tabs">
        <li class="active"><a href="#tab1-1" data-toggle="tab">HEADER</a></li>
        <li><a href="#tab1-2" data-toggle="tab">DETAIL</a></li>
        <li style="width:100%;"> <a data-toggle="" style="text-align:right">
          <button type="button" class="btn btn-primary btn-icon" onclick="save_post('form_data'); return false;">Save <i class="icon-check"></i></button>
          </a> </li>
      </ul>
      <form name="form_data" id="form_data" class="form-horizontal" role="form" action="<?php echo site_url('dokumen/execute/'.$act.'/impor'); ?>" method="post" autocomplete="off" onsubmit="save_post('form_data'); return false;">
      <div class="tab-content">
        <div class="tab-pane p-x-lg active" id="tab1-1">
          <div class="row">
              <div class="col-md-12">
				<input type="hidden" name="ID_DATA" value="<?php echo $ID_DATA; ?>" readonly="readonly"/>
                <div class="form-group">
                  <label class="col-sm-3 control-label-left">CAR</label>
                  <div class="col-sm-9">
                    <input type="text" name="CAR" id="CAR" wajib="yes" class="form-control" placeholder="CAR" onkeyup="cek();" value="<?php echo $arrhdr['CAR']; ?>">
                  </div>
                </div>
                 <div class="form-group">
                  <label class="col-sm-3 control-label-left">JENIS DOKUMEN</label>
                  <div class="col-sm-9">
					<?php 
					  echo form_dropdown('KD_DOK_INOUT',$arr_dokumen,$arrhdr['KD_DOK_INOUT'],'id="KD_DOK_INOUT" wajib="yes" class="form-control"');
					?>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label-left">NO. DOKUMEN</label>
                  <div class="col-sm-5">
                    <input type="text" name="NO_DOK_INOUT" id="NO_DOK_INOUT" wajib="yes" class="form-control" placeholder="NO. DOKUMEN" value="<?php echo $arrhdr['NO_DOK_INOUT']; ?>">
                  </div>
                  <div class="col-sm-4"> 
                    <div class="input-prepend input-group"><span class="add-on input-group-addon"><i class="icon-calendar"></i></span>
                      <input class="form-control drp" type="text" value="<?=date_input($arrhdr['TGL_DOK_INOUT']);?>" placeholder="TANGGAL DOKUMEN" name="TGL_DOK_INOUT" id="TGL_DOK_INOUT" data-provide="datepicker" wajib="yes">
                    </div> 
				  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label-left">DAFTAR PABEAN</label>
                  <div class="col-sm-5">
                    <input type="text" name="NO_DAFTAR_PABEAN" id="NO_DAFTAR_PABEAN" wajib="yes" class="form-control" placeholder="NO. DAFTAR PABEAN" value="<?php echo $arrhdr['NO_DAFTAR_PABEAN']; ?>">
                  </div>
                  <div class="col-sm-4"> 
                    <div class="input-prepend input-group"><span class="add-on input-group-addon"><i class="icon-calendar"></i></span>
                      <input class="form-control drp" type="text" value="<?=date_input($arrhdr['TGL_DAFTAR_PABEAN']);?>" placeholder="TGL DAFTAR PABEAN" name="TGL_DAFTAR_PABEAN" id="TGL_DAFTAR_PABEAN" data-provide="datepicker" wajib="yes">
                    </div> 
				  </div>
                </div>
				<div class="form-group">
				  <label class="col-sm-3 control-label-left">KANTOR BC</label>
				  <div class="col-sm-2">
					<input type="text" class="form-control" name="KD_KANTOR" id="KD_KANTOR" wajib="yes" onkeyup="cek();" placeholder="KODE" value="<?php echo $arrhdr['KD_KANTOR']; ?>" maxlength="6" readonly>
				  </div>
				  <div class="col-sm-7">
					<input type="text" class="form-control" id="NM_KPBC" placeholder="NAMA KPBC" value="<?php echo $arrhdr['NM_KPBC']; ?>">
				  </div>
				</div>
				<div class="form-group">
				  <label class="col-sm-3 control-label-left">KANTOR PENGAWAS</label>
				  <div class="col-sm-2">
					<input type="text" class="form-control" name="KD_KANTOR_PENGAWAS" id="KD_KANTOR_PENGAWAS" onkeyup="cek();" placeholder="KODE" value="<?php echo $arrhdr['KD_KANTOR_PENGAWAS']; ?>" maxlength="6" readonly>
				  </div>
				  <div class="col-sm-7">
					<input type="text" class="form-control" id="NM_KP_PENG" placeholder="NAMA KANTOR PENGAWAS" value="<?php echo $arrhdr['NM_KP_PENG']; ?>">
				  </div>
				</div>
				<div class="form-group">
				  <label class="col-sm-3 control-label-left">KANTOR BONGKAR</label>
				  <div class="col-sm-2">
					<input type="text" class="form-control" name="KD_KANTOR_BONGKAR" id="KD_KANTOR_BONGKAR" onkeyup="cek();" placeholder="KODE" value="<?php echo $arrhdr['KD_KANTOR_BONGKAR']; ?>" maxlength="6" readonly>
				  </div>
				  <div class="col-sm-7">
					<input type="text" class="form-control" id="NM_KP_BONG" placeholder="NAMA KANTOR BONGKAR" value="<?php echo $arrhdr['NM_KP_BONG']; ?>">
				  </div>
				</div>
				<div class="form-group">
				  <label class="col-sm-3 control-label-left">GUDANG</label>
				  <div class="col-sm-2">
					<input type="text" class="form-control" name="KD_GUDANG" id="KD_GUDANG" wajib="yes" onkeyup="cek();" placeholder="KODE" value="<?php echo $arrhdr['KD_GUDANG']; ?>" maxlength="6" readonly>
				  </div>
				  <div class="col-sm-7">
					<input type="text" class="form-control" id="NM_GUDANG" placeholder="NAMA GUDANG" value="<?php echo $arrhdr['NM_GUDANG']; ?>">
				  </div>
				</div>
                <div class="form-group">
                  <label class="col-sm-3 control-label-left"><b>CONSIGNEE</b></label>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 col-sm-offset-1 control-label-left">NAMA</label>
                  <div class="col-sm-9">
                    <input type="text" name="CONSIGNEE" id="CONSIGNEE" wajib="yes" class="form-control" placeholder="NAMA CONSIGNEE" value="<?php echo $arrhdr['CONSIGNEE']; ?>">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 col-sm-offset-1 control-label-left">NPWP/ID</label>
                  <div class="col-sm-9">
                    <input type="text" name="ID_CONSIGNEE" id="ID_CONSIGNEE" wajib="yes" class="form-control" placeholder="NPWP/ID CONSIGNEE" value="<?php echo $arrhdr['ID_CONSIGNEE']; ?>">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 col-sm-offset-1 control-label-left">ALAMAT</label>
                  <div class="col-sm-9">
                  	<textarea name="ALAMAT_CONSIGNEE" id="ALAMAT_CONSIGNEE" wajib="yes" class="form-control" placeholder="ALAMAT CONSIGNEE"><?php echo $arrhdr['ALAMAT_CONSIGNEE']; ?></textarea>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label-left"><b>PPJK</b></label>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 col-sm-offset-1 control-label-left">NAMA PPJK</label>
                  <div class="col-sm-9">
                    <input type="text" name="NAMA_PPJK" id="NAMA_PPJK" class="form-control" placeholder="NAMA PPJK" value="<?php echo $arrhdr['NAMA_PPJK']; ?>">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 col-sm-offset-1 control-label-left">NPWP/ID PPJK</label>
                  <div class="col-sm-9">
                    <input type="text" name="NPWP_PPJK" id="NPWP_PPJK" class="form-control" placeholder="NPWP PPJK" value="<?php echo $arrhdr['NPWP_PPJK']; ?>">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 col-sm-offset-1 control-label-left">ALAMAT PPJK</label>
                  <div class="col-sm-9">
                  	<textarea name="ALAMAT_PPJK" id="ALAMAT_PPJK" class="form-control" placeholder="ALAMAT PPJK"><?php echo $arrhdr['ALAMAT_PPJK']; ?></textarea>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label-left">NAMA ANGKUT</label>
                  <div class="col-sm-9">
                    <input type="text" name="NM_ANGKUT" id="NM_ANGKUT" class="form-control" placeholder="NAMA ANGKUT" value="<?php echo $arrhdr['NM_ANGKUT']; ?>">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label-left">NO. VOYAGE</label>
                  <div class="col-sm-9">
                    <input type="text" name="NO_VOY_FLIGHT" id="NO_VOY_FLIGHT" class="form-control" placeholder="NO. VOYAGE" value="<?php echo $arrhdr['NO_VOY_FLIGHT']; ?>">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label-left">JUMLAH</label>
                  <div class="col-sm-5">
                    <input type="text" name="BRUTO" id="BRUTO" class="form-control" placeholder="BRUTO" value="<?php echo $arrhdr['BRUTO']; ?>" onkeyup="cek();">
                  </div>
                  <div class="col-sm-4">
                    <input type="text" name="NETTO" id="NETTO" class="form-control" placeholder="NETTO" value="<?php echo $arrhdr['NETTO']; ?>" onkeyup="cek();">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label-left"><b>BC</b></label>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 col-sm-offset-1 control-label-left">BC 1.1</label>
                  <div class="col-sm-5">
                    <input type="text" name="NO_BC11" id="NO_BC11" class="form-control" placeholder="NO BC11" value="<?php echo $arrhdr['NO_BC11']; ?>">
                  </div>
                  <div class="col-sm-4"> 
                    <div class="input-prepend input-group"><span class="add-on input-group-addon"><i class="icon-calendar"></i></span>
                      <input class="form-control drp" type="text" value="<?=date_input($arrhdr['TGL_BC11']);?>" placeholder="TANGGAL BC 1.1" name="TGL_BC11" id="TGL_BC11" data-provide="datepicker">
                    </div> 
				  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 col-sm-offset-1 control-label-left">POS BC 1.1</label>
                  <div class="col-sm-9">
                    <input type="text" name="NO_POS_BC11" id="NO_POS_BC11" class="form-control" placeholder="NO POS BC11" value="<?php echo $arrhdr['NO_POS_BC11']; ?>">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label-left"><b>BL</b></label>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 col-sm-offset-1 control-label-left">NO. MASTER BL</label>
                  <div class="col-sm-5">
                    <input type="text" name="NO_MASTER_BL_AWB" id="NO_MASTER_BL_AWB" class="form-control" placeholder="NO. MASTER BL" value="<?php echo $arrhdr['NO_MASTER_BL_AWB']; ?>">
                  </div>
                  <div class="col-sm-4"> 
                    <div class="input-prepend input-group"><span class="add-on input-group-addon"><i class="icon-calendar"></i></span>
                      <input class="form-control drp" type="text" value="<?=date_input($arrhdr['TGL_MASTER_BL_AWB']);?>" placeholder="TANGGAL MASTER BL" name="TGL_MASTER_BL_AWB" id="TGL_MASTER_BL_AWB" data-provide="datepicker">
                    </div> 
				  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 col-sm-offset-1 control-label-left">NO. BL</label>
                  <div class="col-sm-5">
                    <input type="text" name="NO_BL_AWB" id="NO_BL_AWB" class="form-control" placeholder="NO. BL" value="<?php echo $arrhdr['NO_BL_AWB']; ?>">
                  </div>
                  <div class="col-sm-4"> 
                    <div class="input-prepend input-group"><span class="add-on input-group-addon"><i class="icon-calendar"></i></span>
                      <input class="form-control drp" type="text" value="<?=date_input($arrhdr['TGL_BL_AWB']);?>" placeholder="TANGGAL BL" name="TGL_BL_AWB" id="TGL_BL_AWB" data-provide="datepicker">
                    </div> 
				  </div>
                </div>
              </div>            
          </div>
        </div>
        <div class="tab-pane p-x-lg" id="tab1-2">
          <div class="row">
		  <div class="col-md-12">
			<div class="form-group">
			  <label class="col-sm-3 control-label-left"><b>KONTAINER</b></label>
			</div>
			<div class="form-group">
			  <label class="col-sm-2 col-sm-offset-1 control-label-left">KONTAINER</label>
			  <div class="col-sm-9"> 
				<?php
				if($act == "update"){
				  if($num_rows > 0){$i=0;
					foreach ($arrcont as $key) {
					  echo '<div class="form-inline"> 
						<input type="text" name="NO_CONT[]" maxlength="11" id="NO_CONT1" value="'.$key->NO_CONT.'" wajib="yes" class="rank form-control" placeholder="NO KONTAINER" style="margin-bottom: 5px;">
						<select wajib="yes" class="rank form-control" name="UKURAN_CONT[]" id="UKURAN_CONT1" style="margin-bottom: 5px;">';
					  foreach ($CONT as $c) {
						if($key->KD_CONT_UKURAN == $c->ID){
						  echo '<option value="'.$c->ID.'" selected="selected">'.$c->NAMA.'</option>'; 
						}else{
						  echo '<option value="'.$c->ID.'">'.$c->NAMA.'</option>'; 
						}
					  } 
					  echo '</select> <select class="rank form-control" name="JENIS_CONT[]" id="JENIS_CONT1" style="margin-bottom: 5px;">';
					  foreach ($JENIS as $c) {
						if($key->KD_CONT_JENIS == $c->ID){
						  echo '<option value="'.$c->ID.'" selected="selected">'	.$c->NAMA.'</option>'; 
						}else{
						  echo '<option value="'.$c->ID.'">'.$c->NAMA.'</option>'; 
						}
					  }
					  $butts=($i==0)?'<button type="button" class="btn btn-primary" id="addButton" style="margin-bottom: 5px;"><i class="glyphicon glyphicon-plus"></i></button>':'<button type="button" class="remove btn btn-danger" id="removeButton" style="margin-bottom: 5px;"><i class="glyphicon glyphicon-trash"></i></button>';
					  echo '</select>&nbsp;'.$butts.'</div>';
					  $i++;
					}
				  }else{
					echo '<div class="form-inline">
					<input type="text" name="NO_CONT[]" maxlength="11" id="NO_CONT1" wajib="yes" class="rank form-control" placeholder="NO KONTAINER" style="margin-bottom: 5px;"> 
					<select wajib="yes" class="rank form-control" name="UKURAN_CONT[]" id="UKURAN_CONT1" style="margin-bottom: 5px;">';
					foreach ($CONT as $c) {
					  echo '<option value="'.$c->ID.'">'.$c->NAMA.'</option>';
					}
					echo '</select> <select class="rank form-control" name="JENIS_CONT[]" id="JENIS_CONT1" style="margin-bottom: 5px;">';
					foreach ($JENIS as $c) {
					  echo '<option value="'.$c->ID.'">'.$c->NAMA.'</option>';
					}
					echo '</select> <button type="button" class="btn btn-primary" id="addButton" style="margin-bottom: 5px;"><i class="glyphicon glyphicon-plus"></i></button></div>';
				  }
				}else{
				  echo '<div class="form-inline">
				  <input type="text" name="NO_CONT[]" maxlength="11" id="NO_CONT1" class="rank form-control" placeholder="NO KONTAINER" style="margin-bottom: 5px;"> 
				  <select class="rank form-control" name="UKURAN_CONT[]" id="UKURAN_CONT1" style="margin-bottom: 5px;">';
				  foreach ($CONT as $c) {
					echo '<option value="'.$c->ID.'">'.$c->NAMA.'</option>';
				  }
				  echo '</select> <select class="rank form-control" name="JENIS_CONT[]" id="JENIS_CONT1" style="margin-bottom: 5px;">';
				  foreach ($JENIS as $c) {
					echo '<option value="'.$c->ID.'">'.$c->NAMA.'</option>';
				  }
				  echo '</select> <button type="button" class="btn btn-primary" id="addButton" style="margin-bottom: 5px;"><i class="glyphicon glyphicon-plus"></i></button></div>';
				}
				?>
				<div id="TextBoxContainer" class="form-inline"></div>
			  </div>
			</div>
			<div class="form-group">
			  <label class="col-sm-3 control-label-left"><b>KEMASAN</b></label>
			</div>
				<?php
				if($act == "update"){
				  if($num_rows1 > 0){$i=0;
					foreach ($arrkms as $key) {
					  $butts=($i==0)?'<button type="button" class="btn btn-primary" id="addButton1"><i class="glyphicon glyphicon-plus"></i></button>':'<button type="button" class="remove1 btn btn-danger" id="removeButton" style="margin-bottom: 5px;"><i class="glyphicon glyphicon-trash"></i></button>';
					  echo ($i==0)?'':'<div id="ok">';
				  echo '<div class="form-group">
						  <label class="col-sm-2 col-sm-offset-1 control-label-left">JENIS</label>
						  <div class="col-sm-2">
							  <input type="text" name="KD_KMS[]" maxlength="2" id="KD_KMS" class="rank form-control" value="'.$key->JNS_KMS.'" aplaceholder="KODE">
						  </div>
						  <div class="col-sm-6">
							  <input type="text" name="JNS_KMS[]" id="JNS_KMS" class="rank form-control" value="'.$key->NM_KMS.'" placeholder="JENIS KEMASAN" >
						  </div>
						</div>
						<div class="form-group">
						  <label class="col-sm-2 col-sm-offset-1 control-label-left">JUMLAH</label>
						  <div class="col-sm-8">
							  <input type="text" name="JML_KMS[]" maxlength="11" id="JML_KMS" class="rank form-control" value="'.$key->JML_KMS.'" placeholder="JUMLAH KEMASAN" onkeyup="cek();">
						  </div>
						</div>
						<div class="form-group">
						  <label class="col-sm-2 col-sm-offset-1 control-label-left">MERK</label>
						  <div class="col-sm-8">
							  <input type="text" name="MERK_KMS[]" id="MERK_KMS" class="rank form-control" value="'.$key->MERK_KMS.'" placeholder="MEREK KEMASAN" >
						  </div>
						</div>
						<div class="form-group">
						  <label class="col-sm-2 col-sm-offset-1 control-label-left"></label>
						  <div class="col-sm-8">
							  '.$butts.'
						  </div>
						</div>';
						echo ($i==0)?'':'</div>';
					  $i++;
					}
				  }else{
				  echo '<div class="form-group">
						  <label class="col-sm-2 col-sm-offset-1 control-label-left">JENIS</label>
						  <div class="col-sm-2">
							  <input type="text" name="KD_KMS[]" maxlength="2" id="KD_KMS" class="rank form-control" placeholder="KODE">
						  </div>
						  <div class="col-sm-6">
							  <input type="text" name="JNS_KMS[]" id="JNS_KMS" class="rank form-control" placeholder="JENIS KEMASAN" >
						  </div>
						</div>
						<div class="form-group">
						  <label class="col-sm-2 col-sm-offset-1 control-label-left">JUMLAH</label>
						  <div class="col-sm-8">
							  <input type="text" name="JML_KMS[]" maxlength="11" id="JML_KMS" class="rank form-control" placeholder="JUMLAH KEMASAN" onkeyup="cek();">
						  </div>
						</div>
						<div class="form-group">
						  <label class="col-sm-2 col-sm-offset-1 control-label-left">MERK</label>
						  <div class="col-sm-8">
							  <input type="text" name="MERK_KMS[]" id="MERK_KMS" class="rank form-control" placeholder="MEREK KEMASAN" >
						  </div>
						</div>
						<div class="form-group">
						  <label class="col-sm-2 col-sm-offset-1 control-label-left"></label>
						  <div class="col-sm-8">
							  <button type="button" class="btn btn-primary" id="addButton1"><i class="glyphicon glyphicon-plus"></i></button>
						  </div>
						</div>';
				  }
				}else{
				  echo '<div class="form-group">
						  <label class="col-sm-2 col-sm-offset-1 control-label-left">JENIS</label>
						  <div class="col-sm-2">
							  <input type="text" name="KD_KMS[]" maxlength="2" id="KD_KMS" class="KD_KMS rank form-control" placeholder="KODE">
						  </div>
						  <div class="col-sm-6">
							  <input type="text" name="JNS_KMS[]" id="JNS_KMS" class="JNS_KMS rank form-control" placeholder="JENIS KEMASAN" >
						  </div>
						</div>
						<div class="form-group">
						  <label class="col-sm-2 col-sm-offset-1 control-label-left">JUMLAH</label>
						  <div class="col-sm-8">
							  <input type="text" name="JML_KMS[]" maxlength="11" id="JML_KMS" class="rank form-control" placeholder="JUMLAH KEMASAN" onkeyup="cek();">
						  </div>
						</div>
						<div class="form-group">
						  <label class="col-sm-2 col-sm-offset-1 control-label-left">MERK</label>
						  <div class="col-sm-8">
							  <input type="text" name="MERK_KMS[]" id="MERK_KMS" class="rank form-control" placeholder="MEREK KEMASAN" >
						  </div>
						</div>
						<div class="form-group">
						  <label class="col-sm-2 col-sm-offset-1 control-label-left"></label>
						  <div class="col-sm-8">
							  <button type="button" class="btn btn-primary" id="addButton1"><i class="glyphicon glyphicon-plus"></i></button>
						  </div>
						</div>';
				}
				?>
				<div id="TextBoxContainer1"></div>
		  </div>
		  </div>
		</div>
        <div class="tab-pane p-x-lg" id="tab1-3">
          <div class="row">
          </div>
        </div>
	  </div>
      </form>
	</div>
  </div> 
</div>
<script>
  function cek() {
	var telpon = document.getElementById('BRUTO');
    telpon.value = telpon.value.replace(/[^0-9.]+/, '');
	var telpon1 = document.getElementById('NETTO');
    telpon1.value = telpon1.value.replace(/[^0-9.]+/, '');
	var car = document.getElementById('CAR');
    car.value = car.value.replace(/[^0-9]+/, '');
	var JML_KMS = document.getElementById('JML_KMS');
    JML_KMS.value = JML_KMS.value.replace(/[^0-9]+/, '');
  };
var count = 0;
$(function () {
  date('drp');
  jQuery(function($){
      $("#NPWP_PPJK").mask("99.999.999.9-999.999");
  });
$('#KD_DOK_INOUT').on('change', function() {
  if(this.value==13){
      $("#ID_CONSIGNEE").unmask("99.999.999.9-999.999");
  }else{
      $("#ID_CONSIGNEE").mask("99.999.999.9-999.999");
 }
});
    $("#addButton").bind("click", function () {
        var div = $("<div />");
        div.html(GetDynamicTextBox(""));
        $("#TextBoxContainer").append(div);
    });
    $("#addButton1").bind("click", function () {
        var div = $("<div id='ok'/>");
        div.html(GetDynamicTextBox1(++count));
        $("#TextBoxContainer1").append(div);
    });
    $("body").on("click", ".remove", function () {
        $(this).closest("div").remove();
    });
    $("body").on("click", ".remove1", function () {
        $(this).closest("#ok").remove();
    });
  autocomplete('CONSIGNEE','/autocomplete/dokumen/manual/consignee/1',function(event, ui){    
    $('#CONSIGNEE').val(ui.item.CONSIGNEE);
    $('#ID_CONSIGNEE').val(ui.item.ID_CONSIGNEE);
    $('#ALAMAT_CONSIGNEE').val(ui.item.ALAMAT_CONSIGNEE);
  });
  autocomplete('NAMA_PPJK','/autocomplete/dokumen/manual/ppjk/1',function(event, ui){    
    $('#NAMA_PPJK').val(ui.item.NAMA_PPJK);
    $('#NPWP_PPJK').val(ui.item.NPWP_PPJK);
    $('#ALAMAT_PPJK').val(ui.item.ALAMAT_PPJK);
  });
  autocomplete('NM_GUDANG','/autocomplete/status/reff_gudang/nama/2',function(event, ui){    
    $('#NM_GUDANG').val(ui.item.NAMA);
    $('#KD_GUDANG').val(ui.item.GUDANG);
  });
  autocomplete('KD_KMS','/autocomplete/status/reff_kemasan/id/2',function(event, ui){    
    $('#KD_KMS').val(ui.item.KD_KMS);
    $('#JNS_KMS').val(ui.item.JNS_KMS);
  });
  autocomplete('JNS_KMS','/autocomplete/status/reff_kemasan/nama/2',function(event, ui){    
    $('#KD_KMS').val(ui.item.KD_KMS);
    $('#JNS_KMS').val(ui.item.JNS_KMS);
  });
  autocomplete('NM_KPBC','/autocomplete/status/reff_kpbc/nama',function(event, ui){
    event.preventDefault();
    $('#KD_KANTOR').val(ui.item.KODE);
    $('#NM_KPBC').val(ui.item.NAMA);
  });
  autocomplete('NM_KP_PENG','/autocomplete/status/reff_kpbc/nama',function(event, ui){
    event.preventDefault();
    $('#KD_KANTOR_PENGAWAS').val(ui.item.KODE);
    $('#NM_KP_PENG').val(ui.item.NAMA);
  });
  autocomplete('NM_KP_BONG','/autocomplete/status/reff_kpbc/nama',function(event, ui){
    event.preventDefault();
    $('#KD_KANTOR_BONGKAR').val(ui.item.KODE);
    $('#NM_KP_BONG').val(ui.item.NAMA);
  });
});
function GetDynamicTextBox() {
    return '<input type="text" name="NO_CONT[]" maxlength="11" id="NO_CONT1" class="rank form-control" style="margin-bottom: 5px;" placeholder="NO KONTAINER" >' 
    + ' <select class="rank form-control" name="UKURAN_CONT[]" id="UKURAN_CONT1" style="margin-bottom: 5px;"><?php
	  foreach ($CONT as $c) {
	  
   echo '<option value="'.$c->ID.'">'.$c->NAMA.'</option>';
  }
  echo '</select>&nbsp;<select class="rank form-control" name="JENIS_CONT[]" id="JENIS_CONT1" style="margin-bottom: 5px;">';
  foreach ($JENIS as $c) {
	echo '<option value="'.$c->ID.'">'.$c->NAMA.'</option>';
  }
	?></select>&nbsp;' +'<button type="button" class="remove btn btn-danger" id="removeButton" style="margin-bottom: 5px;"><i class="glyphicon glyphicon-trash"></i></button>'
}
function GetDynamicTextBox1(id) {
    return '<script>function cek'+id+'() {var JML_KMS = document.getElementById("JML_KMS'+id+'");JML_KMS.value = JML_KMS.value.replace(/[^0-9+]+/, "");};autocomplete("KD_KMS'+id+'","/autocomplete/status/reff_kemasan/id/2",function(event, ui){ $("#KD_KMS'+id+'").val(ui.item.KD_KMS);$("#JNS_KMS'+id+'").val(ui.item.JNS_KMS);});  autocomplete("JNS_KMS'+id+'","/autocomplete/status/reff_kemasan/nama/2",function(event, ui){$("#KD_KMS'+id+'").val(ui.item.KD_KMS);$("#JNS_KMS'+id+'").val(ui.item.JNS_KMS);});<\/script><div class="form-group"><label class="col-sm-2 col-sm-offset-1 control-label-left">JENIS</label><div class="col-sm-2"><input type="text" name="KD_KMS[]" maxlength="2" id="KD_KMS'+id+'" class="KD_KMS rank form-control" placeholder="KODE"></div><div class="col-sm-6"><input type="text" name="JNS_KMS[]" id="JNS_KMS'+id+'" class="JNS_KMS rank form-control" placeholder="JENIS KEMASAN"></div></div><div class="form-group"><label class="col-sm-2 col-sm-offset-1 control-label-left">JUMLAH</label><div class="col-sm-8"><input type="text" name="JML_KMS[]" maxlength="11" id="JML_KMS'+id+'" class="rank form-control" placeholder="JUMLAH KEMASAN" onkeyup="cek'+id+'();"></div></div><div class="form-group"><label class="col-sm-2 col-sm-offset-1 control-label-left">MERK</label><div class="col-sm-8"><input type="text" name="MERK_KMS[]" id="MERK_KMS" class="rank form-control" placeholder="MEREK KEMASAN"></div></div><div class="form-group"><label class="col-sm-2 col-sm-offset-1 control-label-left"></label><div class="col-sm-8"><button type="button" class="remove1 btn btn-danger" id="removeButton" style="margin-bottom: 5px;"><i class="glyphicon glyphicon-trash"></i></button></div></div>'
}
</script>