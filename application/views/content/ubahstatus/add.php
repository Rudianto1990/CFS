    <link href="<?php echo base_url();?>assets/css/jquery.tagit.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url();?>assets/css/tagit.ui-zendesk.css" rel="stylesheet" type="text/css">
 <script src="<?php echo base_url();?>assets/js/tag-it.js" type="text/javascript" charset="utf-8"></script>
<div class="card">
  <div class="card-block p-a-0">
    <div class="box-tab m-b-0" id="rootwizard">
      <ul class="wizard-tabs">
        <li class="active"><a href="#tab1" data-toggle="tab">PERMOHONAN CFS</a></li>
        <li style="width:100%;"> <a data-toggle="" style="text-align:right">
          <button type="button" class="btn btn-primary btn-icon" onclick="save_ajax('form_data'); return false;">Save <i class="icon-check"></i></button>
          </a> </li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane p-x-lg active" id="tab1">
          <form name="form_data" id="form_data" class="form-horizontal" role="form" action="<?php echo 'status/execute/'.$act.'/'.$ID; ?>" method="post" enctype= "multipart/form-data" autocomplete="off" onsubmit="save_ajax('form_data'); return false;">
            <div class="form-group">
              <label class="col-sm-3 control-label-left">TERMINAL</label>
              <div class="col-sm-8"> 
                <input type="text" value="<?=$arrhdr['GUDANGASAL'];?>"  wajib="yes" id="NAMA_ASAL" class="form-control" placeholder="TERMINAL"> 
                <input type="hidden" name="GUDANG_ASAL" value="<?=$arrhdr['KD_GUDANG_ASAL'];?>" wajib="yes" id="GUDANG_ASAL" class="form-control">
                <input type="hidden" name="TPS_ASAL" value="<?=$arrhdr['KD_TPS_ASAL'];?>" wajib="yes" id="TPS_ASAL" class="form-control">
              </div>
			  <div class="col-sm-1" style="padding-top:2px">
				<button type="button" class="btn btn-primary btn-sm" onclick="popup_searchtwo('popup/popup_search/terminal/TPS_ASAL|GUDANG_ASAL|NAMA_ASAL/2','','60','600')"> <span class="icon-magnifier"></span></button>
			  </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label-left">WAREHOUSE</label>
              <div class="col-sm-8"> 
                <input type="text" value="<?=$arrhdr['GUDANGTUJUAN'];?>" value="" wajib="yes" id="NAMA_TUJUAN" class="form-control" placeholder="WAREHOUSE">
                <input type="hidden" name="GUDANG_TUJUAN" value="<?=$arrhdr['KD_GUDANG_TUJUAN'];?>" wajib="yes" id="GUDANG_TUJUAN" class="form-control">
                <input type="hidden" name="TPS_TUJUAN" value="<?=$arrhdr['KD_TPS_TUJUAN'];?>" wajib="yes" id="TPS_TUJUAN" class="form-control">
              </div>
			  <div class="col-sm-1" style="padding-top:2px">
				<button type="button" class="btn btn-primary btn-sm" onclick="popup_searchtwo('popup/popup_search/warehouse/TPS_TUJUAN|GUDANG_TUJUAN|NAMA_TUJUAN/2','','60','600')"> <span class="icon-magnifier"></span></button>
			  </div>
            </div>
            <br><br>
            <div class="form-group">
              <label class="col-sm-3 control-label-left">NAMA PEMOHON</label>              
              <div class="col-sm-9"> 
                <input type="text"  name="NM_LENGKAP" id="NM_LENGKAP" class="form-control" placeholder="NAMA PEMOHON" value="<?php echo strtoupper($this->newsession->userdata('NM_LENGKAP')); ?>" readonly> 
              </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label-left">NAMA KAPAL</label>
                <div class="col-sm-5"> 
                  <input type="text" wajib="yes" value="<?php echo $arrhdr['NAMA_KAPAL']; ?>" name="NAMA_KAPAL" id="NAMA_KAPAL" class="form-control" maxlength="255" placeholder="NAMA KAPAL">                  
                </div>
                <div class="col-sm-4">
                  <input type="text" name="CALL_SIGN" value="<?php echo $arrhdr['CALL_SIGN']; ?>" id="CALL_SIGN" maxlength="50" class="form-control" placeholder="CALL SIGN">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label-left">NO. VOYAGE</label>
                <div class="col-sm-5"> 
                  <input type="text" name="NO_VOYAGE" value="<?=$arrhdr['NO_VOY_FLIGHT'];?>" wajib="yes" id="NO_VOYAGE" class="form-control" maxlength="20" placeholder="NOMOR VOYAGE">
                </div>
                <div class="col-sm-4"> 
                  <div class="input-prepend input-group"><span class="add-on input-group-addon"><i class="icon-calendar"></i></span>
                    <input class="form-control drp" type="text" value="<?php echo $arrhdr['TGL_TIBA'];?>"  placeholder="TANGGAL TIBA" name="TGL_TIBA" id="TGL_TIBA" data-provide="datepicker" wajib="yes">
                  </div> 
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label-left">NO. BC 1.1</label>
                <div class="col-sm-5"> 
                  <input type="text" name="NO_BC11" wajib="yes" maxlength="50" value="<?php echo $arrhdr['NO_BC11']; ?>" id="NO_BC11" class="form-control" placeholder="NOMOR BC 1.1">
                </div>
                <div class="col-sm-4"> 
                  <div class="input-prepend input-group"><span class="add-on input-group-addon"><i class="icon-calendar"></i></span>
                    <input class="form-control drp" type="text" value="<?php echo $arrhdr['TGL_BC11'];?>" placeholder="TANGGAL BC 1.1" name="TGL_BC11" id="TGL_BC11" data-provide="datepicker" wajib="yes">
                  </div> 
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label-left">FILE DOKUMEN</label>
				<?php
				if($act == "update"){
				  if($num_rows1 > 0){$i=0;
					foreach ($arrfile as $key) {
					  $butts=($i==0)?'<button type="button" class="btn btn-primary btn-sm" id="addButton1"><i class="glyphicon glyphicon-plus"></i></button>':'<button type="button" class="remove1 btn btn-danger btn-sm" id="removeButton'.$i.'"><i class="glyphicon glyphicon-trash"></i></button>';
					  echo ($i==0)?'':'<div class="ok"><div class="form-group">';
						echo '<div class="col-sm-5'; echo ($i==0)?'':' col-sm-offset-3'; echo '">
								<a href="http://103.29.187.215/cfs-center/uploadCFS/PermohonanCFS/'.$key->FOLDER.'/'.$key->FILE_DOKUMEN.'" target="_blank">
									<input type="text" class="form-control" name="FILE_DOKUMEN2[]" id="FILE_DOKUMEN2'.$i.'" value="'.$key->FILE_DOKUMEN.'" placeholder="FILE DOKUMEN" readonly/>
								</a>
								<input type="file" class="form-control" name="FILE_DOKUMEN[]" id="FILE_DOKUMEN'.$i.'" placeholder="FILE DOKUMEN" style="display:none" disabled/>
							  </div>
							  <div class="col-sm-2">';
								$options = array('DO'=>'DO','MANIFEST'=>'MANIFEST','OTHER'=>'OTHER');
								$js = 'class="form-control" id="JNS_FILE_DOKUMEN"';
								echo form_dropdown('JNS_FILE_DOKUMEN[]', $options, $key->JNS_FILE_DOKUMEN, $js);
						echo '</div>
							  <div class="col-sm-2" style="padding-top:2px">
								<button type="button" class="btn btn-warning btn-sm" id="editButton'.$i.'" onclick="editFile('.$i.');"><i class="glyphicon glyphicon-edit"></i></button>
								<button type="button" class="btn btn-warning btn-sm" id="cancelButton'.$i.'" onclick="cancelFile('.$i.');" style="display:none" disabled><i class="glyphicon glyphicon-remove"></i></button>
								'.$butts.'
							  </div>
							</div>';
					  echo ($i==0)?'':'</div>';
					  $i++;
					}
					echo '<input type="hidden" name="tmpFile" id="tmpFile">';
				  }else{
					  echo '<div class="col-sm-5"> 
								<input type="file" class="form-control" name="FILE_DOKUMEN[]" id="FILE_DOKUMEN" placeholder="FILE DOKUMEN" wajib="yes"/>
							</div>
							<div class="col-sm-3">';
								$options = array('DO'=>'DO','MANIFEST'=>'MANIFEST','OTHER'=>'OTHER');
								$js = 'class="form-control" id="JNS_FILE_DOKUMEN"';
								echo form_dropdown('JNS_FILE_DOKUMEN[]', $options, '', $js);
					  echo '</div>
							<div class="col-sm-1" style="padding-top:2px">
								<button type="button" class="btn btn-primary btn-sm" id="addButton1"><i class="glyphicon glyphicon-plus"></i></button>
							</div>
						</div>';
				  }
				}else{
				  echo '<div class="col-sm-5"> 
							<input type="file" class="form-control" name="FILE_DOKUMEN[]" id="FILE_DOKUMEN" placeholder="FILE DOKUMEN" wajib="yes"/>
						</div>
						<div class="col-sm-3">';
							$options = array('DO'=>'DO','MANIFEST'=>'MANIFEST','OTHER'=>'OTHER');
							$js = 'class="form-control" id="JNS_FILE_DOKUMEN"';
							echo form_dropdown('JNS_FILE_DOKUMEN[]', $options, '', $js);
				  echo '</div>
						<div class="col-sm-1" style="padding-top:2px">
							<button type="button" class="btn btn-primary btn-sm" id="addButton1"><i class="glyphicon glyphicon-plus"></i></button>
						</div>
					</div>';
				}
				?>
			<div id="TextBoxContainer1"></div>
			<br><br>
            <div class="form-group">
				<label class="col-sm-3 control-label-left">NO. KONTAINER</label>              
				<div class="col-sm-9"> 
					<button type="button" class="btn btn-primary btn-icon" id="addButton"><i class="glyphicon glyphicon-plus"></i> Tambah Data</button>
					<br><br>
					<?php
					if($act == "update"){
						if($num_rows > 0){
							foreach ($arrcont as $key) {
								echo '<div class="form-inline"> 
									<input type="text" name="NO_CONT[]" maxlength="11" id="NO_CONT1" value="'.$key->NO_CONT.'" wajib="yes" class="rank form-control" placeholder="NO KONTAINER" >
									<select wajib="yes" class="rank form-control" name="UKURAN_CONT[]" id="UKURAN_CONT1">';
								foreach ($CONT as $c) {
									if($key->KD_CONT_UKURAN == $c->ID){
										echo '<option value="'.$c->ID.'" selected="selected">'.$c->NAMA.'</option>'; 
									} else {
										echo '<option value="'.$c->ID.'">'.$c->NAMA.'</option>'; 
									}
								}	 
								echo '</select>
									 &nbsp;<button type="button" class="remove btn btn-danger" id="removeButton">Hapus</button></div><br>
								';
							}
						} else {
							echo '<div class="form-inline">
							<input type="text" name="NO_CONT[]" maxlength="11" id="NO_CONT1" wajib="yes" class="rank form-control" placeholder="NO KONTAINER" > 
							<select wajib="yes" class="rank form-control" name="UKURAN_CONT[]" id="UKURAN_CONT1">';
							foreach ($CONT as $c) {
								echo '<option value="'.$c->ID.'">'.$c->NAMA.'</option>';
							}
							echo '</select></div>';
						}
					} else {
						echo '<div class="form-inline">
						<input type="text" name="NO_CONT[]" maxlength="11" id="NO_CONT1" wajib="yes" class="rank form-control" placeholder="NO KONTAINER" > 
						<select wajib="yes" class="rank form-control" name="UKURAN_CONT[]" id="UKURAN_CONT1">';
						foreach ($CONT as $c) {
							echo '<option value="'.$c->ID.'">'.$c->NAMA.'</option>';
						}
						echo '</select></div>';
					}
					?>
					<br>
					<div id="TextBoxContainer" class="form-inline">
						<!--Textboxes will be added here -->
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
$(function(){
	var i=1;
	date('drp');
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
	autocomplete('NAMA_KAPAL','/autocomplete/status/reff_kapal/ship_name',function(event, ui){
		event.preventDefault();
		$('#NAMA_KAPAL').val(ui.item.NAMA);
		$('#CALL_SIGN').val(ui.item.CALLSIGN);
	});
    $("#addButton").bind("click", function () {
        var div = $("<div />");
        div.html(GetDynamicTextBox(""));
        $("#TextBoxContainer").append(div);
    });
    $("#addButton1").bind("click", function () {
		var e = document.getElementsByTagName('input');
		var s = 0;
		for(var ii=0; ii < e.length; ii++) {
		if(e[ii].type== "file" && e[ii].name=="FILE_DOKUMEN[]" ) { s++  ; }
		}
		//console.log ( s ) ;
		if(s<5){
			var div = $("<div id='ok"+s+"' class='ok'/>");
			div.html(GetDynamicTextBox1(s,'<?php echo $act; ?>'));
			$("#TextBoxContainer1").append(div);
		}
    });
    $("body").on("click", ".remove", function () {
        $(this).closest("div").remove();
    });
    $("body").on("click", ".remove1", function () {
        $(this).closest(".ok").remove();
    });
});
function GetDynamicTextBox() {
    return '<input type="text" name="NO_CONT[]" maxlength="11" id="NO_CONT1" wajib="yes" class="rank form-control" style="margin-bottom: 20px;" placeholder="NO KONTAINER" >' 
    + ' <select wajib="yes" class="rank form-control" name="UKURAN_CONT[]" id="UKURAN_CONT1" style="margin-bottom: 20px;"><?php
	  foreach ($CONT as $c) {
	  
   echo '<option value="'.$c->ID.'">'.$c->NAMA.'</option>';
  }
	?></select>&nbsp;' +'<button type="button" class="remove btn btn-danger" id="removeButton" style="margin-bottom: 20px;">Hapus</button>'
}
function GetDynamicTextBox1(i,up) {
	var dd = '';
	dd=(up=='update')?2:3;
    return '<div class="form-group"><div class="col-sm-5 col-sm-offset-3"><input type="file" class="form-control" name="FILE_DOKUMEN[]" id="FILE_DOKUMEN'+i+'" placeholder="FILE DOKUMEN" wajib="yes"/></div><div class="col-sm-'+dd+'"><?php $options = array('DO'=>'DO','MANIFEST'=>'MANIFEST','OTHER'=>'OTHER');$js = 'class="form-control" id="JNS_FILE_DOKUMEN"';echo form_dropdown('JNS_FILE_DOKUMEN[]', $options, '', $js); ?></div><div class="col-sm-1" style="padding-top:2px"><button type="button" class="remove1 btn btn-danger btn-sm" id="removeButton1" style="margin-bottom: 5px;"><i class="glyphicon glyphicon-trash"></i></button></div></div>'
}
function editFile(i) {
	$("#cancelButton"+i).show();
	$("#cancelButton"+i).removeAttr('disabled');
	$("#editButton"+i).hide();
	$("#editButton"+i).attr('disabled', 'disabled');
	/* if(i!=0){
		$("#removeButton"+i).show();
		$("#removeButton"+i).removeAttr('disabled');
	} */
	$("#FILE_DOKUMEN2"+i).hide();
	$("#FILE_DOKUMEN"+i).show();
	$("#FILE_DOKUMEN"+i).attr('wajib', 'yes');
	$("#FILE_DOKUMEN"+i).removeAttr('disabled');
	tmpFile('edit',$("#FILE_DOKUMEN2"+i).val());
}
function cancelFile(i) {
	$("#cancelButton"+i).hide();
	$("#cancelButton"+i).attr('disabled', 'disabled');
	$("#editButton"+i).show();
	$("#editButton"+i).removeAttr('disabled');
	/* if(i!=0){
		$("#removeButton"+i).hide();
		$("#removeButton"+i).attr('disabled', 'disabled');
	} */
	$("#FILE_DOKUMEN2"+i).show();
	$("#FILE_DOKUMEN"+i).hide();
	$("#FILE_DOKUMEN"+i).removeAttr('wajib');
	$("#FILE_DOKUMEN"+i).attr('disabled', 'disabled');
	document.getElementById("FILE_DOKUMEN"+i).style.display = "none";
	tmpFile('',$("#FILE_DOKUMEN2"+i).val());
}
function tmpFile(status,id){
	var valtemp = $('#tmpFile').val();
	if(status=='edit'){
		if(strpos(valtemp,id)===false){
			$('#tmpFile').val(id+"*"+$('#tmpFile').val());
		}
	}else{
		$('#tmpFile').val($('#tmpFile').val().replace(id+'*',''));
	}
}
</script>