<?php
	$STATUSX = array($arrhdr["STATUS"]=>"selected");
	$STATUS .="<option value='ACTIVE' ".$STATUSX['ACTIVE'].">ACTIVE</option>";
    $STATUS .="<option value='INACTIVE' ".$STATUSX['INACTIVE'].">INACTIVE</option>";
	
	

?>

<div class="card">
  <div class="card-block p-a-0">
    <div class="box-tab m-b-0" id="rootwizard">
      <ul class="wizard-tabs">
        <li class="active"><a href="#tab1" data-toggle="tab">DAFTAR ORGANISASI</a></li>
        <li style="width:100%;"> <a data-toggle="" style="text-align:right">
          <button type="button" class="btn btn-primary btn-icon" onclick="save_post('form_data'); return false;">Save <i class="icon-check"></i></button>
          </a> </li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane p-x-lg active" id="tab1">
          <form name="form_data" id="form_data" class="form-horizontal" role="form" action="<?php echo site_url('usermanagement/execute/'.$act.'/organisasi/'.$ID); ?>" method="post" autocomplete="off" onsubmit="save_post('form_data'); return false;">
		  
		  
		  	<div class="form-group">
              <label class="col-sm-2 control-label-left">TIPE</label>
              <div class="col-sm-5">
            
				<?php echo form_dropdown('DATA[KD_TIPE_ORGANISASI]',$arr_tipe,$arrhdr['KD_TIPE_ORGANISASI'],'id="KD_TIPE_ORGANISASI" wajib="yes" class="form-control"'); ?>
				
              </div>
              <input type="hidden" class="form-control" name="ID" id="ID"  placeholder="KODE" value="<?php echo $arrhdr['ID']; ?>">
            </div>
			
			<div class="form-group">
              <label class="col-sm-2 control-label-left">NPWP</label>
              <div class="col-sm-5">
                <input type="text" name="DATA[NPWP]" id="NPWP" wajib="yes" class="form-control" placeholder="NPWP" value="<?php echo $arrhdr['NPWP']; ?>">
              </div>
             </div>
			 
			 	
			<div class="form-group">
              <label class="col-sm-2 control-label-left">NAMA</label>
              <div class="col-sm-5">
                <input type="text" name="DATA[NAMA]" id="NAMA" wajib="yes" class="form-control" placeholder="NAMA" value="<?php echo $arrhdr['NAMA']; ?>">
              </div>
             </div>
			 
			 	
			<div class="form-group">
              <label class="col-sm-2 control-label-left">ALAMAT</label>
              <div class="col-sm-5">
                <input type="text" name="DATA[ALAMAT]" id="ALAMAT" wajib="yes" class="form-control" placeholder="ALAMAT" value="<?php echo $arrhdr['ALAMAT']; ?>">
              </div>
             </div>
			 
			 
			 <div class="form-group">
              <label class="col-sm-2 control-label-left">NO TELEPON</label>
              <div class="col-sm-5">
                <input type="text" name="DATA[NOTELP]" id="NOTELP" wajib="yes" class="form-control" placeholder="NOTELP" value="<?php echo $arrhdr['NOTELP']; ?>">
              </div>
             </div>
			 
			 <div class="form-group">
              <label class="col-sm-2 control-label-left">NO FAX</label>
              <div class="col-sm-5">
                <input type="text" name="DATA[NOFAX]" id="NOFAX" wajib="yes" class="form-control" placeholder="NOFAX" value="<?php echo $arrhdr['NOFAX']; ?>">
              </div>
             </div>
			 
			 <div class="form-group">
              <label class="col-sm-2 control-label-left">EMAIL</label>
              <div class="col-sm-5">
                <input type="text" name="DATA[EMAIL]" id="EMAIL" wajib="yes" class="form-control" placeholder="EMAIL" value="<?php echo $arrhdr['EMAIL']; ?>">
              </div>
             </div>
			
			
          
			
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
$(function(){
	autocomplete('NAMA_KAPAL','/tps/autocomplete/mst_kapal',function(event, ui){
		$('#KD_KAPAL').val(ui.item.KD_KAPAL);
	});
	autocomplete('KD_PEL_MUAT','/tps/autocomplete/mst_port/kode',function(event, ui){
		$('#PELABUHAN_MUAT').val(ui.item.NAMA);
	});
	autocomplete('PELABUHAN_MUAT','/tps/autocomplete/mst_port/nama',function(event, ui){
		$('#KD_PEL_MUAT').val(ui.item.KODE);
	});
	autocomplete('KD_PEL_TRANSIT','/tps/autocomplete/mst_port/kode',function(event, ui){
		$('#PELABUHAN_TRANSIT').val(ui.item.NAMA);
	});
	autocomplete('PELABUHAN_TRANSIT','/tps/autocomplete/mst_port/nama',function(event, ui){
		$('#KD_PEL_TRANSIT').val(ui.item.KODE);
	});
	autocomplete('KD_PEL_BONGKAR','/tps/autocomplete/mst_port/kode',function(event, ui){
		$('#PELABUHAN_BONGKAR').val(ui.item.NAMA);
	});
	autocomplete('PELABUHAN_BONGKAR','/tps/autocomplete/mst_port/nama',function(event, ui){
		$('#KD_PEL_BONGKAR').val(ui.item.KODE);
	});
});
</script> 
