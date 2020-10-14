<div class="col-md-12">
    <div class="block">
    	<div class="col-md-6">
        	<div class="block block-drop-shadow">
                <div class="header">
                    <h2>KODE &amp; NAMA DENAH</h2>
                </div>
                <div class="content content-transparent np">
                    <div class="list list-contacts">
                        <a href="javascript:void(0)" class="list-item">                                
                            <div class="list-text">
                                <span class="list-text-name">KODE DENAH</span>
                                <div class="list-text-info"><i class="icon-info-sign"></i> <?php echo $arrgudang[0]['ID']; ?></div>
                            </div>
                            <div class="list-status list-status-online"></div>
                        </a>
                        <a href="javascript:void(0)" class="list-item">  
                            <div class="list-text">
                                <span class="list-text-name">NAMA DENAH</span>
                                <div class="list-text-info"><i class="icon-info-sign"></i> <?php echo $arrgudang[0]['NAMA']; ?></div>
                            </div>
                            <div class="list-status list-status-online"></div>
                        </a>                      
                    </div>                        
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
        	<div class="block block-drop-shadow">
                <div class="header">
                    <h2>TIPE &amp; UKURAN DENAH</h2>
                </div>
                <div class="content content-transparent np">
                    <div class="list list-contacts">
                        <a href="javascript:void(0)" class="list-item">                                
                            <div class="list-text">
                                <span class="list-text-name">TIPE DENAH</span>
                                <div class="list-text-info"><i class="icon-info-sign"></i> <?php echo ($arrgudang[0]['KD_TIPE_GUDANG']=="LAP")?"LAPANGAN":"GUDANG"; ?></div>
                            </div>
                            <div class="list-status list-status-online"></div>
                        </a>
                        <a href="javascript:void(0)" class="list-item">  
                            <div class="list-text">
                                <span class="list-text-name">UKURAN DENAH</span>
                                <div class="list-text-info"><i class="icon-info-sign"></i> <?php echo "PANJANG : ".$arrgudang[0]['PANJANG']." &amp; LEBAR : ".$arrgudang[0]['LEBAR']; ?></div>
                            </div>
                            <div class="list-status list-status-online"></div>
                        </a>                  
                    </div>                        
                </div>
            </div>
        </div>
	</div>
</div>
<script>get_div('referensi/get_data/get_denah','denahDetail','<?php echo $arrgudang[0]['ID']; ?>'); </script>
<div class="col-md-12">
    <div class="block block-drop-shadow">
        <div class="header">
            <h2>DETAIL DENAH</h2>
        </div>
        <div class="content content-transparent np">
            <div class="list list-contacts">            	
                <br style="clear:both;">
            	<div id="denahDetail" style="overflow:auto"></div>
                <br style="clear:both;">
            </div>
        </div>
    </div>
</div>