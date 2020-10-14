<div class="col-md-12">
    <div class="block block-drop-shadow">
        <div class="header">
            <h2>DENAH LAPANGAN</h2>
        </div>
        <div class="content content-transparent np">
            <div class="list list-contacts">
                <div class="seat-administration">
                    <div class="seat-grid"></div>
                </div>
                <div>&nbsp;</div>
                 <div class="col-md-3">
                <select name="lapangan" id="lapangan" class="form-control" onchange="get_div('referensi/get_denah','divDenah',this.value)">
                    <option value=""></option>
                    <?php foreach($arrgudangcombo as $data){ ?>
                    <option value="<?php echo $data['ID']; ?>"><?php echo $data['NAMA']." [".$data['KD_GUDANG']."]"; ?></option>	
                    <?php } ?>
                </select>
                </div>
                <div class="col-md-3">
                    <button type="button" class="btn" onclick="popup_search('popup/popup_add/denah/add','','800','500')">
                    	<i class="icon-plus"></i> Tambah
                   	</button>
           		</div>
                <div>&nbsp;</div>
                <div>&nbsp;</div>
                <script>
					get_div('referensi/get_denah','divDenah','');
                </script>
                <div>&nbsp;</div>
                    <div class="col-md-12">
                        <div id="divDenah" style="overflow:auto"></div>
                    </div>
                <div>&nbsp;</div>
                </div>
            </div>
        </div>
    </div>
</div>