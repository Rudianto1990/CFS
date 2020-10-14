<div class="card">
    <div class="card-block p-a-0">
        <div class="box-tab m-b-0" id="rootwizard">
            <ul class="wizard-tabs">
                <li class="active"><a href="#tab1" data-toggle="tab">DAFTAR USER</a></li>
                <li style="width:100%;"> <a data-toggle="" style="text-align:right">
                        <button type="button" class="btn btn-primary btn-icon" onclick="save_popup('form_data','divtbluser'); return false;">Save <i class="icon-check"></i></button>
                    </a> </li>
            </ul>
            <div class="tab-content">
				<?php $KD_GROUP=$this->newsession->userdata('KD_GROUP');?>
                <div class="tab-pane p-x-lg active" id="tab1">
                    <form name="form_data" id="form_data" class="form-horizontal" role="form" action="<?php echo site_url('management/execute/' . $act . '/user/' . $ID); ?>" method="post" autocomplete="off" onsubmit="save_popup('form_data','divtbluser'); return false;">
                        <div class="form-group">
                            <label class="col-sm-2 control-label-left">ORGANISASI</label>
                            <div class="col-sm-<?php if($KD_GROUP=="SPA"){echo "9";}else{echo "10";}?>">
                                <input type="hidden" class="form-control" name="DATA[KD_ORGANISASI]" id="KD_ORGANISASI" wajib="yes" placeholder="NPWP ORGANISASI" readonly="readonly" value="<?php if($KD_GROUP=="ADM"){echo $this->newsession->userdata('KD_ORGANISASI');}else{echo $arrhdr['KD_ORGANISASI'];} ?>">
                                <input type="text" name="NAMA_ORGANISASI" id="NAMA_ORGANISASI" wajib="yes" class="form-control" placeholder="NAMA ORGANISASI" value="<?php if($KD_GROUP=="ADM"){echo strtoupper($this->newsession->userdata('NM_PERSH'));}else{echo strtoupper($arrhdr['NAMA_ORGANISASI']);} ?>" readonly>
                            </div><?php if($KD_GROUP=="SPA"){?>
                            <div class="col-sm-1" style="padding-top:2px">
                                <button type="button" class="btn btn-primary btn-sm" onclick="popup_searchtwo('popup/popup_search/organisasi/KD_ORGANISASI|NAMA_ORGANISASI/2','','60','600')"> <span class="icon-magnifier"></span></button>
                            </div><?php }?>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label-left">USERNAME</label>
                            <div class="col-sm-10">
                                <input type="text" name="USERLOGIN" id="USERLOGIN" wajib="yes" onkeyup="cek();" class="form-control" placeholder="USERNAME" value="<?php echo $arrhdr['USERLOGIN']; ?>" <?php echo ($act=="update") ? "readonly" : ""; ?>>
                                <!--input type="text" name="USERLOGIN" id="USERLOGIN" wajib="yes" class="form-control" placeholder="USERNAME" value="<?php echo ($KD_GROUP=="ADM") ? ($act=="save") ? $this->newsession->userdata('KD_ORGANISASI')."." : "" : ""; echo $arrhdr['USERLOGIN']; ?>" <?php echo ($act=="update") ? "readonly" : ""; ?>-->
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label-left">PASSWORD</label>
                            <div class="col-sm-10">
                                <input type="text" name="DATA[PASSWORD]" id="PASSWORD" <?php echo ($act == "save") ? 'wajib="yes"' : ""; ?> class="form-control" placeholder="PASSWORD">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label-left">NAMA LENGKAP</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="DATA[NM_LENGKAP]" id="NM_LENGKAP" onkeyup="cek();" wajib="yes" placeholder="NAMA LENGKAP"  value="<?php echo $arrhdr['NM_LENGKAP']; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label-left">HANDPHONE</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="DATA[HANDPHONE]" id="HANDPHONE" onkeyup="cek();" wajib="yes" placeholder="HANDPHONE" maxlength='15' value="<?php echo $arrhdr['HANDPHONE']; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label-left">EMAIL</label>
                            <div class="col-sm-10">
                                <input type="email" class="form-control" name="EMAIL" id="EMAIL" wajib="yes" placeholder="EMAIL"  value="<?php echo $arrhdr['EMAIL']; ?>" <?php echo ($act=="update") ? "readonly" : ""; ?>>
                            </div>
                        </div>
                        <!--div class="form-group">
                            <label class="col-sm-2 control-label-left">GUDANG</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" name="DATA[KD_GUDANG]" id="KD_GUDANG" placeholder="KODE" readonly="readonly" value="<?php echo $arrhdr['KD_GUDANG']; ?>">
                            </div>
                            <div class="col-sm-6">
                                <input type="text" name="NAMA_GUDANG" id="NAMA_GUDANG" class="form-control" placeholder="NAMA" value="<?php echo strtoupper($arrhdr['NAMA_GUDANG']); ?>">
                                <input type="hidden" name="DATA[KD_TPS]" id="KD_TPS" class="form-control" placeholder="KODE TPS" value="<?php echo strtoupper($arrhdr['KD_TPS']); ?>">
                            </div>
                            <div class="col-sm-1" style="padding-top:2px">
                                <button type="button" class="btn btn-primary btn-sm" onclick="popup_searchtwo('popup/popup_search/gudang/KD_GUDANG|NAMA_GUDANG|KD_TPS/2','','60','600')"> <span class="icon-magnifier"></span></button>
                            </div>
                        </div-->
                        <div class="form-group">
                            <label class="col-sm-2 control-label-left">GROUP</label>
                            <div class="col-sm-10"> <?php echo form_dropdown('DATA[KD_GROUP]', $arr_group, $arrhdr['KD_GROUP'], 'id="KD_GROUP" wajib="yes" class="form-control"'); ?> </div>
                            <input type="hidden" class="form-control" name="ID" id="ID"  placeholder="KODE" value="<?php echo $arrhdr['ID']; ?>">
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label-left">STATUS</label>
                            <div class="col-sm-10">
                                <?php echo form_dropdown('DATA[KD_STATUS]', array('ACTIVE' => 'ACTIVE', 'INACTIVE' => 'INACTIVE'), $arrhdr['KD_STATUS'], 'id="KD_STATUS" wajib="yes" class="form-control"'); ?>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
	function cek() {
		var telpon = document.getElementById('HANDPHONE');
			telpon.value = telpon.value.replace(/[^0-9+]+/, '');
		var fullname = document.getElementById('NM_LENGKAP');
			fullname.value = fullname.value.replace(/[^a-zA-Z ,.'-]+/, '');
		var username = document.getElementById('USERLOGIN');
			username.value = username.value.replace(/[^a-zA-Z0-9._-]+/, '');
	};

<?php /*if($KD_GROUP=="ADM"){
echo "var readOnlyLength = $('#KD_ORGANISASI').val().length + 1;
//var readOnlyLength = $('#field').val().length;
 $('#output').text(readOnlyLength);

$('#USERLOGIN').on('keypress, keydown', function(event) {
    var \$field = $(this);
    $('#output').text(event.which + '-' + this.selectionStart);
    if ((event.which != 37 && (event.which != 39))
        && ((this.selectionStart < readOnlyLength)
        || ((this.selectionStart == readOnlyLength) && (event.which == 8)))) {
        return false;
    }
});";        
}*/?> 
    $(function(){
        autocomplete('NAMA_ORGANISASI','/tps/autocomplete/mst_org',function(event, ui){
            $('#KD_ORGANISASI').val(ui.item.KD_ORGANISASI);
        });
        autocomplete('NAMA_GUDANG','/tps/autocomplete/mst_gudang',function(event, ui){
            $('#KD_TPS').val(ui.item.KD_TPS);
            $('#KD_GUDANG').val(ui.item.KD_GUDANG);
        });
    });
//document.getElementById('USERLOGIN').onclick = function() {document.getElementById('USERLOGIN').readOnly = false;};
//document.getElementById('EMAIL').onclick = function() {document.getElementById('EMAIL').readOnly = false;};
$(document).ready(function() {
	jQuery.validator.addMethod("isi", function(value, element) {
	return value !== "<?php echo $this->newsession->userdata('KD_ORGANISASI')."."; ?>";
	}, "username tidak valid");
	jQuery.validator.addMethod("noSpace", function(value, element) {
	return value.indexOf(" ") < 0 && value !== "";
	}, "Tidak boleh menggunakan spasi");
	jQuery.validator.addMethod("regex",function(value, element, regexp) {
	var re = new RegExp(regexp);
	return this.optional(element) || re.test(value);
	}, "Please check your input.");
	$("#form_data").validate({
		rules: {
			USERLOGIN: {
				<?php #if($KD_GROUP=="ADM"){echo "isi: true,";}?>
				remote: {
					url: "<?php echo site_url();?>/management/uname",
					type: "post",
					data: {
						login: function(){
							return $('#form_data :input[name="USERLOGIN"]').val();
						}
					}
				}
			},
			EMAIL: {
				remote: {
					url: "<?php echo site_url();?>/management/umail",
					type: "post",
					data: {
						login: function(){
							return $('#form_data :input[name="EMAIL"]').val();
						}
					}
				}
			}
		},
		messages:{
			USERLOGIN:{
				remote: jQuery.validator.format("username sudah ada.")
			},
			EMAIL:{
				remote: jQuery.validator.format("email sudah ada.")
			}
		}
    });
});
</script> 