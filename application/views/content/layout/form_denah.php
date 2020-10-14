<style type="text/css">
#kiri
{
	width:48%;
	background-color:rgba(255, 235, 59, 0.88);
	float:left;
}
#kanan
{
	width:48%;
	background-color:rgba(76, 175, 80, 0.95);
	float:right;
}
#lay_cic
{
	background-color:#3F51B5;
}
</style>
<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/custom.css">
<body onload="createTable()">
<div class="panel">
	<div class="panel-body">

		<div align="center">
			<h1>LAYOUT DAN KAPASITAS LAPANGAN </h1>
			
		</div>
		<hr>
		<div>
	    	<h4>KETERANGAN:</h4>
	    </div>
	    <div class="media">
          <div class="media-body">
            <div class="list-text-info">
            	<span class="list-text-info"><span class="label label-success">&nbsp; &nbsp;</span></span>
            	<i class="icon-info-sign"></i>
               		KAPASITAS KURANG DARI SAMA DENGAN 25%
            </div>
          </div>
        </div>
	    <div class="media">
          <div class="media-body">
            <div class="list-text-info">
            	<span class="list-text-name"><span class="label label-info">&nbsp; &nbsp;</span></span>
            	<i class="icon-info-sign"></i>
               		KAPASITAS LEBIH DARI SAMA DENGAN 25% &amp; KURANG DARI SAMA DENGAN 50%
            </div>
          </div>
        </div>
	    <div class="media">
          <div class="media-body">
            <div class="list-text-info">
            	<span class="list-text-name"><span class="label label-warning">&nbsp; &nbsp;</span></span>
            	<i class="icon-info-sign"></i>
               		KAPASITAS LEBIH DARI SAMA DENGAN 50% &amp; KURANG DARI SAMA DENGAN 99%
            </div>
          </div>
        </div>
	    <div class="media">
          <div class="media-body">
            <div class="list-text-info">
            	<span class="list-text-name"><span class="label label-danger">&nbsp; &nbsp;</span></span>
            	<i class="icon-info-sign"></i>
               			KAPASITAS SAMA DENGAN 100%
            </div>
          </div>
        </div>
        <div>&nbsp;&nbsp;&nbsp;</div>
		<input type="hidden" name="panjang_ya" id="panjang_ya" value="<?php echo $arrdata_ya[0]['PANJANG']; ?>" />
		<input type="hidden" name="lebar_ya" id="lebar_ya" value="<?php echo $arrdata_ya[0]['LEBAR']; ?>"/>
		<input type="hidden" name="panjang_yb" id="panjang_yb" value="<?php echo $arrdata_yb[0]['PANJANG']; ?>" />
		<input type="hidden" name="lebar_yb" id="lebar_yb" value="<?php echo $arrdata_yb[0]['LEBAR']; ?>"/>
		<input type="hidden" name="panjang_cic" id="panjang_cic" value="<?php echo $arrdata_cic[0]['PANJANG']; ?>" />
		<input type="hidden" name="lebar_cic" id="lebar_cic" value="<?php echo $arrdata_cic[0]['LEBAR']; ?>"/>
		<div id="kiri">
			<div align="Center">
				<h3> <span class="label label-primary">YA</span></h3>
			</div>
			<div id="lapangan_ya"> </div>
		</div>
		<div id="kanan">
			<div align="Center">
				<h3> <span class="label label-primary">YB</span></h3>
			</div>
			<div id="lapangan_yb"> </div>
		</div>
	</div>
		<div class="panel-body">
			<div id="lay_cic">
				<div align="Center">
					<h3> <span class="label label-danger">CIC</span></h3>
				</div>
				<div id="lapangan_cic"></div>
			</div>
		</div> 	
            <!-- Modal -->
			<div class="myModal2 modal fade" role="dialog">
			  <div class="modal-dialog">

				<!-- Modal content-->
				<div class="modal-content">
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">DETAIL BLOK <span id="dtl_blok"></span></h4>
				  </div>
				  <div class="modal-body">
					   <div>
							<ul id="list_item" class="reset"></ul>
					   </div>
				  </div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				  </div>
				</div>

			  </div>
			</div><!-- tutup modal2 -->
        </div>
</body>
<?php
	foreach($arrdata_lap_ya as $value){
		$arrlapangan[] = $value;//['IDDATA'];
	}
	for ($a = 0; $a < count($arrlapangan); $a++) {
		$arrExpBl = explode(",", $arrlapangan[$a]['LEVEL_1']);	
		$arrExpNmBlok_ya = explode(",", $arrlapangan[$a]['NM_BLOK']);	
		$arrExp = explode(",", $arrlapangan[$a]['IDDATA']);
		for ($b = 0; $b < count($arrExp); $b++) {
			$arrTemp[] = $arrExp[$b];
			$arrTempBl[] = $arrExpBl[$b];
			$arrTempNmBlok[$arrExpBl[$b]] = $arrExpNmBlok_ya[$b];
		}
	}
	echo "<input type='hidden' readonly id='tempIddata' value='".json_encode($arrTemp)."'>";
	echo "<input type='hidden' readonly id='layout_ya' value='".json_encode($arrTempBl)."'>";
	echo "<input type='hidden' readonly id='nm_blok_ya' value='".json_encode($arrTempNmBlok)."'>";
	
	foreach($arrdata_lap_yb as $value){
		$arrlapangan_yb[] = $value;//['IDDATA'];
	}
	//print_r("sini ". $arrlapangan_yb);die();
	for ($aa = 0; $aa < count($arrlapangan_yb); $aa++) {
		$arrExpBl_yb = explode(",", $arrlapangan_yb[$aa]['LEVEL_1']);		
		$arrExp = explode(",", $arrlapangan_yb[$aa]['IDDATA']);	
		$arrExpNmBlok = explode(",", $arrlapangan_yb[$aa]['NM_BLOK']);
		$arrExpStatus = explode(",", $arrlapangan_yb[$aa]['KD_STATUS']);
		for ($bb = 0; $bb < count($arrExp); $bb++) {
			$arrTemp_yb[] = $arrExp[$bb];
			$arrTempBl_yb[] = $arrExpBl_yb[$bb];
			$arrTempNmBlok_yb[$arrExpBl_yb[$bb]] = $arrExpNmBlok[$bb];
			$arrTempStatus_yb[] = $arrExpStatus[$bb];
		}
	}
	//print_r("sini ". $arrTempBl_yb);die();
	echo "<input type='hidden' readonly id='tempIddata_yb' value='".json_encode($arrTemp_yb)."'>";
	echo "<input type='hidden' readonly id='layout_yb' value='".json_encode($arrTempBl_yb)."'>";
	echo "<input type='hidden' readonly id='nm_blok_yb' value='".json_encode($arrTempNmBlok_yb)."'>";
	echo "<input type='hidden' readonly id='status_yb' value='".json_encode($arrTempStatus_yb)."'>";
	
	foreach($arrdata_lap_cic as $value){
		$arrlapangan_cic[] = $value;//['IDDATA'];
	}
	//print_r("sini ". $arrlapangan_cic);die();
	for ($aaa = 0; $aaa < count($arrlapangan_cic); $aaa++) {
		$arrExpBl_cic = explode(",", $arrlapangan_cic[$aaa]['LEVEL_1']);		
		$arrExpCic = explode(",", $arrlapangan_cic[$aaa]['IDDATA']);
		$arrExpNmBlokCic = explode(",", $arrlapangan_cic[$aaa]['NM_BLOK']);
		$arrExpStatusCic = explode(",", $arrlapangan_cic[$aaa]['KD_STATUS']);
		for ($bbb = 0; $bbb < count($arrExpCic); $bbb++) {
			$arrTemp_cic[] = $arrExpCic[$bbb];
			$arrTempBl_cic[] = $arrExpBl_cic[$bbb];
			$arrTempStatus_cic[] = $arrExpStatusCic[$bbb];
			$arrTempNmBlok_cic[$arrExpBl_cic[$bbb]] = $arrExpNmBlokCic[$bbb];
		}
	}
	//print_r("sini ". $arrTempBl_yb);die();
	echo "<input type='hidden' readonly id='tempIddata_cic' value='".json_encode($arrTemp_cic)."'>";
	echo "<input type='hidden' readonly id='layout_cic' value='".json_encode($arrTempBl_cic)."'>";
	echo "<input type='hidden' readonly id='status_cic' value='".json_encode($arrTempStatus_cic)."'>";
	echo "<input type='hidden' readonly id='nm_blok_cic' value='".json_encode($arrTempNmBlok_cic)."'>";
?>
<script>
	function getActDtl(id){
		//alert(id);
		//return false;
		$.ajax({
			type: "post",
			async: true,
			url: "<?php echo site_url(); ?>/setting/getDenah",
			data: { id:id },
			cache: false,
			success:function(data){
				var obj = $.parseJSON(data);
				var cont = Object.keys(obj).length;
				//console.log("total = " + cont);
				var no = cont;
				$('#list_item').html('');
                $.each(obj, function (index, object) {
					//console.log("TOTAL = "+object['USE']);
					//if(object['USE'] == 1){
						$('#list_item').append('<li><h4>No. KONTAINER' + ' ' + no + ' : ' + ' <span class="label label-primary">' + object['NO_CONT'] + '</span>&nbsp;&nbsp;&nbsp;'+object['STAT']+ '</h4></li>');
					/*}else {
						//alert("suni");
						$('#list_item').append('<li><h4>No. TIER' + ' ' + no + ' : ' + ' <span class="label label-primary">' + '-' + '</span></h4></li>');
					}*/
					no--;
					//console.log(object);
                })
				console.log(data);
			}
		});
		
		$.ajax({
			type: "post",
			url: "<?php echo site_url(); ?>/setting/getNmBlok",
			data: { id:id },
			success:function(data){
				var obj = $.parseJSON(data);
				var nm_blok = obj[0]['NM_BLOK'];
				var blok = obj[0]['LEVEL_1'];
				document.getElementById('dtl_blok').innerHTML = nm_blok;
				//console.log("sini"+obj[0]['LEVEL_1']);
			}
		});
		//document.getElementById('dtl_blok').innerHTML = id;
		$('.myModal2').modal();
		
		//$('.myModal2').modal('hide');
	}
	
    function createTable()
    {
        var num_rows = document.getElementById('panjang_ya').value;//y
        var num_cols = document.getElementById('lebar_ya').value;//x
        var theader = '<table class="myTable" border="1" style="border-collapse: collapse;" cellpadding="8">\n';
        var tbody = '';
        var val = document.getElementById('tempIddata').getAttribute('value');
		var valBl = document.getElementById('layout_ya').getAttribute('value');
		var valNmBlok_ya = document.getElementById('nm_blok_ya').getAttribute('value');
		
		//alert(valBl);
		//return false;
		var data_array = val.split(",");
		var data_parsed = JSON.parse(data_array);
		
		var data_blok = valBl.split(",");
		var data_parsed_bl = JSON.parse(data_blok);

		var data_NmBlok = valNmBlok_ya.split(",");
		var data_parsed_NmBlok = JSON.parse(data_NmBlok);
		//console.log("data_parsed_NmBlok = "+valNmBlok_ya);
		//alert(data_parsed_bl);
		//return false;
		if(data_parsed !== null){
			var cont = Object.keys(data_parsed).length;
			var set = '0';
			var data_loop = new Array();
			var data_loop_bl = new Array();
			var data_loop_NmBlok = new Array();
			for (var a = 0; a < cont; a++) {
				data_loop.push(data_parsed[a]);
				data_loop_bl.push(data_parsed_bl[a]);
				data_loop_NmBlok.push(data_parsed_NmBlok[a]);
			}
		}
		
		var tampung = new Array();
		var addstyle = "";
		var textData = "";
		var textContentYa = "";
		for( var i=0; i<num_rows;i++){
			tbody += '<tr>';
			for( var j=0; j<num_cols;j++){
				/**/if ($.inArray('YA/'+j+'-'+i, data_loop_bl) >= 0) {
				//if( data_loop.indexOf(j+'-'+i) !== -1 ){
					addstyle = "background:green;color:#fff;width:100px;text-space-collapse";
					//textData = data_loop_NmBlok.shift();
					var klik = "getActDtl(this.id)";
					var n = i.toString().length;
					var n2 = j.toString().length;
					//console.log("sini n = "+ n);
					//console.log("sini j = "+ j);
					if(n == 1){
						var nol = "0";
						//console.log("sini j1 = "+ j);
					}else{
						nol = "";
					}
					
					if(n2 == 1){
						var nol2 = "0";
					}else {
						nol2 = "";
					}
					textContentYa = 'YA'+ nol2 + j + '' + nol + i;				
					textContentYa1 = 'YA/' + j + '-' + i;
					textData = data_parsed_NmBlok[textContentYa1];
					tampung.push(textData);
					//tampung.push(textContentYa1);
				}else {
					addstyle = "background:#fff;color:#fff;width:100px;text-space-collapse";
					textData = ".";
					textContentYa = ".";
					klik = "";
				}
				tbody += '<td style= "'+addstyle+'" onclick="'+klik+'" id="'+textData+'">';//id="YA/'+j+'-'+i+'"
				tbody += textData;//'YA/' + i + '-' + j;
				//tbody += textData;
				tbody += '</td>'
			}
			tbody += '</tr>\n';
		}
        var tfooter = '</table>';
        document.getElementById('lapangan_ya').innerHTML = theader + tbody + tfooter;
		
		var num_rows2 = document.getElementById('panjang_yb').value;
        var num_cols2 = document.getElementById('lebar_yb').value;
        var theader2 = '<table class="myTable" border="1" style="border-collapse: collapse;" cellpadding="8">\n';
        var tbody2 = '';
        var val_yb = document.getElementById('tempIddata_yb').getAttribute('value');
		var valBl_yb = document.getElementById('layout_yb').getAttribute('value');
		var valStatus_yb = document.getElementById('status_yb').getAttribute('value');
		var valNmBlok_yb = document.getElementById('nm_blok_yb').getAttribute('value');
		
		var data_array_yb = val_yb.split(",");
		var data_parsed_yb = JSON.parse(data_array_yb);
		var data_blok_yb = valBl_yb.split(",");
		var data_parsed_bl_yb = JSON.parse(data_blok_yb);
		var data_status_yb = valStatus_yb.split(",");
		var data_parsed_status_yb = JSON.parse(data_status_yb);
		var data_nm_blok_yb = valNmBlok_yb.split(",");
		var data_parsed_nm_blok_yb = JSON.parse(data_nm_blok_yb);
		//console.log("status "+data_parsed_status_yb);
		if(data_parsed_yb !== null){
			var cont = Object.keys(data_parsed_yb).length;
			var set = '0';
			var data_loop_yb = new Array();
			var data_loop_bl_yb = new Array();
			var data_loop_status_yb = new Array();
			var data_loop_nmblok_yb = new Array();
			for (var a = 0; a < cont; a++) {
				data_loop_yb.push(data_parsed_yb[a]);
				data_loop_bl_yb.push(data_parsed_bl_yb[a]);
				data_loop_status_yb.push(data_parsed_status_yb[a]);
				data_loop_nmblok_yb.push(data_parsed_nm_blok_yb[a]);
			}
		}

		var addstyle_yb = "";
		var textData_yb = "";
		var textContentYb = "";
        for( var ii=0; ii<num_rows2;ii++)
        {
            tbody2 += '<tr>';
            for( var jj=0; jj<num_cols2;jj++)
            {
				if ($.inArray('YB/'+jj+'-'+ii, data_loop_bl_yb) >= 0) {
				//if( data_loop.indexOf(j+'-'+i) !== -1 ){
					addstyle_yb = "background:green;color:#fff;width:100px;text-space-collapse";
					var n = ii.toString().length;
					var n2 = jj.toString().length;
					var klik = "getActDtl(this.id)";
					/*if(data_loop_status_yb == '001'){
						addstyle_yb = "background:green;color:red;width:100px;text-space-collapse";
					}*/
					if(n == 1){
						var nol = "0";
						//console.log("sini j1 = "+ j);
					}else{
						nol = "";
					}
					
					if(n2 == 1){
						var nol2 = "0";
					}else {
						nol2 = "";
					}
					textContentYb = 'YB'+ nol2 + jj + '' + nol + ii;
					textContentYb1 = 'YB/' + jj + '-' + ii;
					//tampung.push(textContentYb1);
					textData_yb = data_parsed_nm_blok_yb[textContentYb1];
					tampung.push(textData_yb);
					//textData_yb = data_loop_nmblok_yb.shift();
				}else {
					addstyle_yb = "background:#fff;color:#fff;width:100px;text-space-collapse";
					textData_yb = ".";
					textContentYb = ".";
					klik = ".";
				}
				
				
			tbody2 += '<td style= "'+addstyle_yb+'" onclick="'+klik+'" class="star" id="'+textData_yb+'">';//id="YB/'+jj+'-'+ii+'"
                tbody2 += textData_yb;//'YB/'+ii + '-' + jj;
				//tbody2 += textData_yb;
                tbody2 += '</td>'
            }
            tbody2 += '</tr>';
        }
        var tfooter2 = '</table>';
        document.getElementById('lapangan_yb').innerHTML = theader2 + tbody2 + tfooter2;
		
		var num_rows3 = document.getElementById('panjang_cic').value;
        var num_cols3 = document.getElementById('lebar_cic').value;
        var theader3 = '<table class="myTable" border="1" style="border-collapse: collapse;" cellpadding="8">\n';
        var tbody3 = '';
        var val_cic = document.getElementById('tempIddata_cic').getAttribute('value');
		var valBl_cic = document.getElementById('layout_cic').getAttribute('value');
		var valStatus_cic = document.getElementById('status_cic').getAttribute('value');
		var valNmBlok_cic = document.getElementById('nm_blok_cic').getAttribute('value');
		
		var data_array_cic = val_cic.split(",");
		var data_parsed_cic = JSON.parse(data_array_cic);
		var data_blok_cic = valBl_cic.split(",");
		var data_parsed_bl_cic = JSON.parse(data_blok_cic);
		var data_status_cic = valStatus_cic.split(",");
		var data_parsed_status_cic = JSON.parse(data_status_cic);
		var data_NmBlok_cic = valNmBlok_cic.split(",");
		var data_parsed_NmBlok_cic = JSON.parse(data_NmBlok_cic);
		
		if(data_parsed_cic !== null){
			var cont = Object.keys(data_parsed_cic).length;
			var set = '0';
			var data_loop_cic = new Array();
			var data_loop_bl_cic = new Array();
			var data_loop_status_cic = new Array();
			var data_loop_nm_blok_cic = new Array();
			for (var aj = 0; aj < cont; aj++) {
				data_loop_cic.push(data_parsed_cic[aj]);
				data_loop_bl_cic.push(data_parsed_bl_cic[aj]);
				data_loop_status_cic.push(data_parsed_status_cic[aj]);
				data_loop_nm_blok_cic.push(data_parsed_NmBlok_cic[aj]);
			}
		}

		var addstyle_cic = "";
		var textData_cic = "";
		var textContentcic = "";
        for( var iii=0; iii<num_rows3;iii++)
        {
            tbody3 += '<tr>';
            for( var jjj=0; jjj<num_cols3;jjj++)
            {
				if ($.inArray('CIC/'+jjj+'-'+iii, data_loop_bl_cic) >= 0) {
					addstyle_cic = "background:green;color:#fff;width:100px;text-space-collapse";
					//textData_cic = data_loop_nm_blok_cic.shift();
					var n = iii.toString().length;
					var n2 = jjj.toString().length;
					var klik = "getActDtl(this.id)";
					if(n == 1){
						var nol = "0";
						//console.log("sini j1 = "+ j);
					}else{
						nol = "";
					}
					
					if(n2 == 1){
						var nol2 = "0";
					}else {
						nol2 = "";
					}
					textContentcic = 'CIC'+ nol2 + jjj + '' + nol + iii;
					textContentcic1 = 'CIC/' + jjj + '-' + iii;
					//tampung.push(textContentcic1);
					textData_cic = data_parsed_NmBlok_cic[textContentcic1];
					tampung.push(textData_cic);
				}else {
					addstyle_cic = "background:#fff;color:#fff;width:100px;text-space-collapse";
					textData_cic = ".";
					textContentcic = ".";
					klik = ".";
				}
			tbody3 += '<td style= "'+addstyle_cic+'" onclick="'+klik+'" class="star" id="'+textData_cic+'">';//id="CIC/'+jjj+'-'+iii+'"
                tbody3 += textData_cic;
                tbody3 += '</td>'
            }
            tbody3 += '</tr>\n';
        }
        var tfooter3 = '</table>';
        document.getElementById('lapangan_cic').innerHTML = theader3 + tbody3 + tfooter3;
		
		var contArray = tampung.length;
		if(contArray > 0){
			//changecolor('YB/1-1','orange');
			for(var z=0; z < contArray; z++){
				$.ajax({
					type : 'post',
					url: '<?php echo site_url(); ?>/setting/countData/'+tampung[z],
					data: { id: tampung[z] },
					cache: false,
					success:function(data){
						var obj = $.parseJSON(data);
						console.log(obj);
						var tier = obj[0]['tier'];
						var container = obj[0]['total'];
						var lokasi = obj[0]['lokasi'];
						if(container >= 0){
							//console.log('sini '+lokasi+'/'+container+'-'+tier);
							var hitung = parseFloat(container) / parseFloat(tier);
							var hitungan = parseFloat(hitung.toFixed(2));
						} else {
							var hitung = 0;
						}
						console.log(hitungan);
												
						if(hitungan == 1){
							changecolor(lokasi,'red');
						} else if(hitungan > 0.5 && hitungan < 1){
							changecolor(lokasi,'orange');
						} else if(hitungan >= 0.25 && hitungan <= 0.5 ){
							changecolor(lokasi,'blue');
						} 
					}
				});
			}
		}
    }
	function changecolor(id,color){
		document.getElementById(id).style.background = color;
	}
	
</script>