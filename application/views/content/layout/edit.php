<script>
$(document).ready(function(){
	$("#form_wizard").smartWizard();
});
</script>
<div class="col-md-12">
    <div class="block">
        <form name="form_gudang" action="<?php echo site_url('referensi/proses_data/update_denah');?>" autocomplete="off" method="post" onsubmit="validasigudang(); return false;">
    	<div id="form_wizard" class="swMain">
            <ul>
                <li>
                    <a href="#step-1">
                        <span class="stepNumber">1</span>
                        <span class="stepDesc">
                            EDIT DENAH
                        </span>
                    </a>
            	</li>
            </ul>
            <div id="step-1">	
            <h2 class="StepTitle">EDIT DENAH</h2>
                <div class="col-md-6">
                    <div class="form-row">
                        <div class="col-md-4">KODE LAPANGAN/GUDANG</div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="kode" name="kode" placeholder="KODE LAPANGAN/GUDANG" maxlength="10" wajib="yes" value="<?php echo $arrgudang[0]['ID']; ?>" readonly="readonly">
                        </div>
                    </div>               
                    <div class="form-row">
                        <div class="col-md-4">NAMA LAPANGAN/GUDANG</div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="nama" name="nama" placeholder="NAMA LAPANGAN/GUDANG" maxlength="100" wajib="yes" value="<?php echo $arrgudang[0]['NAMA']; ?>">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-row">
                        <div class="col-md-4">TIPE</div>
                        <div class="col-md-8">
                            <select class="form-control" id="tipe" name="tipe" wajib="yes">
                            	<option value=""></option>
                                <option value="LAP" <?php echo ($arrgudang[0]['KD_TIPE_GUDANG']=="LAP")?"selected":""; ?>>LAPANGAN</option>
                                <option value="GDG" <?php echo ($arrgudang[0]['KD_TIPE_GUDANG']=="GDG")?"selected":""; ?>>GUDANG</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="col-md-4">PANJANG &amp; LEBAR</div>
                        <div class="col-md-4">
                            <input type="text" class="form-control" id="panjang" name="panjang" placeholder="PANJANG" wajib="yes" format="angka" value="<?php echo $arrgudang[0]['PANJANG']; ?>">
                        </div>
                         <div class="col-md-4">
                            <input type="text" class="form-control input-sm" id="lebar" name="lebar" placeholder="LEBAR" wajib="yes" format="angka" value="<?php echo $arrgudang[0]['LEBAR']; ?>">
                        </div>
                    </div>
                </div>
        	</div>
		</div>
      	</form>
	</div>
</div>