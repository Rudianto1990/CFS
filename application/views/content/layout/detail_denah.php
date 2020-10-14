
<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/style.css">
<body onload="createTable()"> <!-- onload="createTable()" -->

<div class="panel">
	<div class="ribbon ribbon-clip ribbon-primary">
  	<span class="ribbon-inner">
		<i class="icon md-boat margin-0" aria-hidden="true"></i> <?php echo "Detail Denah"; ?>
    </span>
  </div>
	<div class="panel-body">
		<!----><div align="center">
			<h1>&nbsp;</h1>
		</div>
	<div class="row">
		<div class="col-md-6">
          <!-- Example Panel Fullscreen -->
          <div class="panel">
            <div class="panel-heading">
              <h3 class="panel-title">KODE & NAMA DENAH</h3>
            </div>
            <div class="panel-body">
              <div class="col-sm-6 col-lg-6">
              <!-- Example User -->
              <div class="example-wrap margin-lg-0">
                <ul class="list-group list-group-full">
                  <li class="list-group-item">
                    <div class="media">
                      <div class="media-body">
                        <h4 class="media-heading">KODE DENAH</h4>
                        <small><?php echo $arrdata[0]['KD_GUDANG_DTL']; ?></small>
						<input type="hidden" name="gudang" id="gudang" value="<?php echo $arrdata[0]['KD_GUDANG_DTL']; ?>">
                      </div>
                      <div class="media-right">
                        <span class="status status-lg status-online"></span>
                      </div>
                    </div>
                  </li>
                  <li class="list-group-item">
                    <div class="media">
                      <div class="media-body">
                        <h4 class="media-heading">NAMA GUDANG LAPANGAN</h4>
                        <small><?php echo $arrdata[0]['NAMA_GUDANG_LAPANGAN']; ?></small>
                      </div>
                      <div class="media-right">
                        <span class="status status-lg status-busy"></span>
                      </div>
                    </div>
                  </li>
                </ul>
              </div>
              <!-- End Example User -->
            </div>
            </div>
          </div>
          <!-- End Example Panel Fullscreen -->
        </div>
		<div class="col-md-6">
          <!-- Example Panel Refresh -->
          <div class="panel">
            <div class="panel-heading">
              <h3 class="panel-title">TIPE & UKURAN DENAH</h3>
            </div>
            <div class="panel-body">
              <div class="col-sm-6 col-lg-6">
              <!-- Example User -->
              <div class="example-wrap margin-lg-0">
                <ul class="list-group list-group-full">
                  <li class="list-group-item">
                    <div class="media">
                      <div class="media-body">
                        <h4 class="media-heading">TIPE DENAH</h4>
                        <small><?php echo $arrdata[0]['KD_GUDANG']; ?></small>
                      </div>
                      <div class="media-right">
                        <span class="status status-lg status-online"></span>
                      </div>
                    </div>
                  </li>
                  <li class="list-group-item">
                    <div class="media">
                      <div class="media-body">
                        <h4 class="media-heading">UKURAN DENAH</h4>
                        <small>PANJANG : <?php echo $arrdata[0]['PANJANG']; ?> & LEBAR : <?php echo $arrdata[0]['LEBAR']; ?></small>
                      </div>
                      <div class="media-right">
                        <span class="status status-lg status-busy"></span>
                      </div>
                    </div>
                  </li>
                </ul>
              </div>
              <!-- End Example User -->
            </div>
            </div>
          </div>
          <!-- End Example Panel Refresh -->
        </div>
	</div>
		<form name="tablegen" id="tbl">
			<!-- <label>Panjang: <input type="text" name="rows" id="rows"/></label><br />
			<label>Lebar: <input type="text" name="cols" id="cols"/></label><br/> -->
			<input type="hidden" name="panjang" id="panjang" value="<?php echo $arrdata[0]['PANJANG']; ?>" />
			<input type="hidden" name="lebar" id="lebar" value="<?php echo $arrdata[0]['LEBAR']; ?>"/>
		<!-- <input name="generate" type="button" value="Create Table!" onclick='createTable();'/> -->
		</form>
		<div id="alert"></div>
		<div id="res"> </div>
		<div id="wrapper"></div>
	</div>
	<!-- Modal -->
	<div class="modal fade myModal" id="" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<!-- Modal Header -->
				<div class="modal-header">
					<button type="button" class="close"
					   data-dismiss="modal">
						   <span aria-hidden="true">&times;</span>
						   <span class="sr-only">Close</span>
					</button>
					<h4 class="modal-title" id="myModalLabel">
					   Tambah
					</h4>
				</div>

				<!-- Modal Body -->
				<div class="modal-body">

				<form class="form-horizontal" action="" method="post" role="form">
					<div class="form-group">
						<label  class="col-sm-2 control-label"
								  for="KODE">KODE</label>
						<div class="col-sm-10">
							<input type="text" class="form-control"
							id="KODE" value="<?php echo $arrdata[0]['KD_GUDANG_DTL']; ?>" readonly  placeholder="KODE"/>
						</div>
					  </div>
					  <div class="form-group">
						<label  class="col-sm-2 control-label"
								  for="inputEmail3">BLOK</label>
						<div class="col-sm-10">
							<input type="hidden" name="blok" class="form-control"
							id="BLOK" value="<?php echo $arrdata[0]['KD_GUDANG_DTL']; ?>" placeholder="BLOK"/>
							<input type="text" name="nm_blok" class="form-control"
							id="NM_BLOK" value="<?php //echo $arrdata[0]['KD_GUDANG_DTL']; ?>" placeholder="BLOK"/>
						</div>
						<input type="hidden" name="kd_gdg" id="kd_gdg" value="<?php echo $arrdata[0]['KD_GUDANG_DTL']; ?>">
						<input type="hidden" name="xx" id="xx" value="<?php //echo $arrdata[0]['KD_GUDANG_DTL']; ?>">
						<input type="hidden" name="yy" id="yy" value="<?php //echo $arrdata[0]['KD_GUDANG_DTL']; ?>">
					  </div>
					  <div class="form-group">
						<label class="col-sm-2 control-label"
							  for="inputPassword3" >TIER</label>
						<div class="col-sm-10">
							<select class="form-control focus" name="PENUMPUKAN" id="PENUMPUKAN">
							  <option value="0"></option>
							  <option value="1">1</option>
							  <option value="2">2</option>
							  <option value="3">3</option>
							  <option value="4">4</option>
							</select>
						</div>
					  </div>
					  <div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
						  <div class="checkbox">
							<label>
								<!--<input type="checkbox"/> Remember me-->
							</label>
						  </div>
						</div>
					  </div>
					  <div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
						  <!--<button type="submit" class="btn btn-default">Sign in</button>-->
						</div>
					  </div>
						<!-- Modal Footer -->
						<div class="modal-footer">
							<button type="button" class="btn btn-default"
									data-dismiss="modal">
										Close
							</button>
							<button type="button" id="addBlok2" class="btn btn-primary">
								Save changes
							</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div><!-- tutup modal -->
	
	<!-- Modal Update -->
	<div class="modal fade myModalUpdate" id="" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<!-- Modal Header -->
				<div class="modal-header">
					<button type="button" class="close"
					   data-dismiss="modal">
						   <span aria-hidden="true">&times;</span>
						   <span class="sr-only">Close</span>
					</button>
					<h4 class="modal-title" id="myModalLabel">
					   Update
					</h4>
				</div>

				<!-- Modal Body -->
				<div class="modal-body">

				<form class="form-horizontal" action="" method="post" role="form">
					<div class="form-group">
						<label  class="col-sm-2 control-label"
								  for="KODE">KODE</label>
						<div class="col-sm-10">
							<input type="text" class="form-control"
							id="KODE2" value="<?php echo $arrdata[0]['KD_GUDANG_DTL']; ?>" readonly  placeholder="KODE"/>
						</div>
					  </div>
					  <div class="form-group">
						<label  class="col-sm-2 control-label"
								  for="inputEmail3">BLOK</label>
						<div class="col-sm-10">
							<input type="text" name="update_nm_blok" class="form-control"
							id="NM_BLOK_UPDT"  value="<?php //echo $iddata[0]['NM_BLOK']; ?>" placeholder="NM_BLOK"/>
						</div>
						<div class="col-sm-10">
							<input type="hidden" name="blok2" class="form-control"
							id="BLOK2" readonly="readonly" value="<?php //echo $arrdata[0]['KD_GUDANG_DTL']; ?>" placeholder="BLOK2"/>
						</div>
						<input type="hidden" name="kd_gdg2" id="kd_gdg2" value="<?php echo $arrdata[0]['KD_GUDANG_DTL']; ?>">
						<input type="hidden" name="xx2" id="xx2" value="<?php //echo $arrdata[0]['KD_GUDANG_DTL']; ?>">
						<input type="hidden" name="yy2" id="yy2" value="<?php //echo $arrdata[0]['KD_GUDANG_DTL']; ?>">
						<input type="hidden" name="PENUMPUKAN21" id="PENUMPUKAN21" value="<?php //echo $arrdata[0]['KD_GUDANG_DTL']; ?>">
						
					  </div>
					  <div class="form-group">
						<label class="col-sm-2 control-label"
							  for="inputPassword3" >TIER</label>
						<div class="col-sm-10">
						<?php //$data_level = "<div id=\"level4d\"></div>"; //echo $data_level; ?>
							<select class="form-control focus" name="PENUMPUKAN2" id="PENUMPUKAN2">
							  <!--<option id="level4" value="<?php //echo $data_level; ?>"></option>-->
							  <option value="1">1</option>
							  <option value="2">2</option>
							  <option value="3">3</option>
							  <option value="4">4</option>
							</select>
						</div>
					  </div>
					  <div class="form-group">
							<label  class="col-sm-2 control-label"
									  for="ACT">ACTION</label>
							<div class="col-sm-10">
								<select class="form-control focus" name="ACT2" id="ACT2">
								  <option value="update">UPDATE</option>
								  <option value="delete">DELETE</option>
								</select>
							</div>
					  <div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
						  <div class="checkbox">
							<label>
								<!--<input type="checkbox"/> Remember me-->
							</label>
						  </div>
						</div>
					  </div>
					  <div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
						  <!--<button type="submit" class="btn btn-default">Sign in</button>-->
						</div>
					  </div>
						<!-- Modal Footer -->
						<div class="modal-footer">
							<button type="button" class="btn btn-default"
									data-dismiss="modal">
										Close
							</button>
							<button type="button" id="updateBlok" class="btn btn-primary">
								Update
							</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div><!-- tutup modal Update -->
</div>
<div>
</div>
</div>
</body>
<?php
	foreach($iddata as $value){
		$arrlapangan[] = $value;//['IDDATA'];
	}
	//print_r("sini".$arrlapangan[0]['KD_GUDANG_DTL,']);die();
	for ($a = 0; $a < count($arrlapangan); $a++) {
		
		$arrExpBl = explode(",", $arrlapangan[$a]['LEVEL_1']);		
		$arrExp = explode(",", $arrlapangan[$a]['IDDATA']);	
		$arrExpNmBlok = explode(",", $arrlapangan[$a]['NM_BLOK']);
		#print_r($arrExpNmBlok);die();
		for ($b = 0; $b < count($arrExp); $b++) {
			$arrTemp[] = $arrExp[$b];
			$arrTempBl[] = $arrExpBl[$b];
			$arrTempNmBlok[$arrExpBl[$b]] = $arrExpNmBlok[$b];
		}
	}
	
	//print_r($arrTempBl);
	echo "<input type='hidden' readonly id='temp' value='".json_encode($arrTemp)."'>";
	echo "<input type='hidden' readonly id='tempBl' value='".json_encode($arrTempBl)."'>";
	echo "<input type='hidden' readonly id='tempNmBlok' value='".json_encode($arrTempNmBlok)."'>";
?>
<script type="application/javascript">
function act(id){
	//alert("sini " + id);
	var ids = id;
	var idsSplit = ids.split("-");
	var x = idsSplit[0];
	var y = idsSplit[1];
	$('.myModal').modal();
	var kd_gdg = document.getElementById('kd_gdg').value;
	$('input[name="blok"]').val(kd_gdg +"/"+ x +"-"+ y);
	$('input[name="nm_blok"]').val(kd_gdg +"/"+ x +"-"+ y);
	$('input[name="xx"]').val(x);
	$('input[name="yy"]').val(y);

	$("#addBlok2").click(function(){
		if ($("#PENUMPUKAN")[0].selectedIndex <= 0) {
			alert("TIER HARUS DIISI");
			return false;
		}
		var id = document.getElementById('KODE').value;
		var blok = document.getElementById('BLOK').value;
		var nm_blok = document.getElementById('NM_BLOK').value;
		var penumpukan = document.getElementById('PENUMPUKAN').value;
		var xxx = document.getElementById('xx').value;
		var yyy = document.getElementById('yy').value;
		//alert("data "+ id + "," + blok + "," + penumpukan );
		$.ajax({
			type: "post",
			url: "<?php echo site_url(); ?>/setting/insertToDenah",
			data: { kode:id, nm_blok:nm_blok, blok:blok, penumpukan:penumpukan, xx:xxx, yy:yyy },
			success:function(data){
				var data = $.parseJSON(data);
				//alert(data.alert);
				console.log(data);
				document.getElementById("alert").innerHTML = data.alert;
				setTimeout(function () {
					document.getElementById("alert").innerHTML = '';
				}, 5000);
				$('.myModal').modal('hide');
				if (data.alert) {
					return false;
				}else{
					window.location.reload(true);
				}
			}
		});
	});
}

	function actEks(id){
		var kd2 = document.getElementById('KODE2').value;
		var id = id;
		var idsSplit = id.split("-");
		var x2 = idsSplit[0];
		var y2 = idsSplit[1];

		$('input[name="blok2"]').val(kd2 +"/"+ x2 +"-"+ y2);
		/*$('input[name="update_nm_blok"]').val(kd2 +"/"+ x2 +"-"+ y2);*/
		$('input[name="xx2"]').val(x2);
		$('input[name="yy2"]').val(y2);
		//console.log("BLOK"+kd2+'/'+id);
		var id_split = kd2 +"/"+ x2 +"-"+ y2;
		$('.myModalUpdate').modal();
		
		$.ajax({
			type: "post",
			url: "<?php echo site_url(); ?>/setting/getNmBlok",
			data: { id:id_split },
			success:function(data){
				var obj = $.parseJSON(data);
				var nm_blok = obj[0]['NM_BLOK'];
				var blok = obj[0]['LEVEL_1'];
				$('input[name="update_nm_blok"]').val(nm_blok);
				//document.getElementById('dtl_blok').innerHTML = nm_blok;
				//console.log("sini"+obj[0]['LEVEL_1']);
			}
		});

		$.ajax({
			type: "post",
			url: "<?php echo site_url(); ?>/setting/updateDenah",
			data: { id:id_split },
			success:function(data){
				var obj = $.parseJSON(data);
				var LEVEL_4 = obj['LEVEL_4'];
				$('input[name="PENUMPUKAN21"]').val(LEVEL_4);
				$("#PENUMPUKAN2 option[value='"+LEVEL_4+"']").attr("selected", "selected");
				$('#level4').html('');
				document.getElementById('level4').innerHTML = LEVEL_4;
				document.getElementById('level4d').innerHTML = LEVEL_4;
				//var cont = Object.keys(obj).length;
				console.log("total = " + LEVEL_4);
				console.log(data);
			}
		});
				
		$("#updateBlok").click(function(){
			var id2 = document.getElementById('KODE2').value;
			var blok2 = document.getElementById('BLOK2').value;
			var penumpukan2 = document.getElementById('PENUMPUKAN2').value;
			var xxx2 = document.getElementById('xx2').value;
			var yyy2 = document.getElementById('yy2').value;
			var nm_blok = document.getElementById('NM_BLOK_UPDT').value;
			var textact = $( "#ACT2 option:selected" ).text();
			if (textact == "DELETE") {
				$.ajax({
					type: "post",
					url: "<?php echo site_url(); ?>/setting/deleteToDenah",
					data: { kode:id2, blok:blok2, penumpukan:penumpukan2, xx:xxx2, yy:yyy2, nm_blok:nm_blok },
					success:function(data){
						console.log(data);
					}
				});
				$('.myModalUpdate').modal('hide');
				window.location.reload(true);
				//console.log("sini delete = "+textact);
			} else {
				$.ajax({
					type: "post",
					url: "<?php echo site_url(); ?>/setting/updateToDenah",
					data: { kode:id2, blok:blok2, penumpukan:penumpukan2, xx:xxx2, yy:yyy2, nm_blok:nm_blok },
					success:function(data){
						var data = $.parseJSON(data);
				//alert(data.alert);
				console.log(data);
				document.getElementById("alert").innerHTML = data.alert;
				setTimeout(function () {
					document.getElementById("alert").innerHTML = '';
				}, 5000);
				$('.myModalUpdate').modal('hide');
				if (data.alert) {
					return false;
				}else{
					window.location.reload(true);
				}
					}
				});
				$('.myModalUpdate').modal('hide');
				window.location.reload(true);
				//console.log("sini update = "+textact);
			}
			
			//$('.myModalUpdate').modal('hide');
		});
	}
</script>
<script type="application/javascript">
function createTable()
{
    var num_rows = document.getElementById('panjang').value; //y
    var num_cols = document.getElementById('lebar').value; //x
    var theader = '<table class="table act"  border="1" style="border-collapse: collapse;" cellpadding="8">\n';
    var tbody = '';
    var kode_gudang = document.getElementById('gudang').getAttribute('value');
    var val = document.getElementById('temp').getAttribute('value');
	var valBl = document.getElementById('tempBl').getAttribute('value');
	var valNmBlok = document.getElementById('tempNmBlok').getAttribute('value');
	/*console.log(valNmBlok);
	return false;*/
	var data_array = val.split(",");
	var data_parsed = JSON.parse(data_array);
	
	var data_blok = valBl.split(",");
	var data_parsed_bl = JSON.parse(data_blok);
	var data_nm_blok = valNmBlok.split(",");
	var data_parsed_nm_blok = JSON.parse(data_nm_blok);
	/*console.log(data_parsed_nm_blok);
	return false;*/
	//console.log("sini"+data_parsed_nm_blok);
	if(data_parsed !== null){
		var cont = Object.keys(data_parsed).length;
		var set = '0';
		var data_loop = new Array();
		var data_loop_bl = new Array();
		var data_loop_nm_blok = new Array();
		for (var a = 0; a < cont; a++) {
			data_loop.push(data_parsed[a]);
			data_loop_bl.push(data_parsed_bl[a]);
			data_loop_nm_blok.push(data_parsed_nm_blok[a]);
		}
	}
	/*alert(data_parsed_nm_blok['CIC/11-3']);
	return false;*/

	
	var addstyle = "";
	var textData = "";
	var textContent = "";
    for( var i=0; i<num_rows;i++){
        tbody += '<tr>';
        for( var j=0; j<num_cols;j++){
			if ($.inArray(kode_gudang+'/'+j+'-'+i, data_loop_bl) >= 0) {
			//if( data_loop.indexOf(j+'-'+i) !== -1 ){
				addstyle = "background:green;color:#fff;width:100px;text-space-collapse";
				
				//console.log("sini textData = "+ textData);
				var n = i.toString().length;
				var n2 = j.toString().length;
				var click = "actEks(this.id)";
				
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
				
				textContent = kode_gudang + ''+ nol2 + j + '' + nol + i;
				textData = data_parsed_nm_blok[kode_gudang+'/'+j+'-'+i];
				/*console.log(j+'-'+i);
				return false;*/
			}else {
				addstyle = "width:100px;text-space-collapse";
				textData = "";
				textContent = ".";
				click = "act(this.id)";
			}
            tbody += '<td style= "'+addstyle+'" onclick="'+click+'" class="star" id='+j+'-'+i+'>';
            //tbody += 'Cell ' + i + ',' + j;
			tbody += textData;
            tbody += '</td>'
        }
        tbody += '</tr>\n';
    }
    var tfooter = '</table>';
    document.getElementById('wrapper').innerHTML = theader + tbody + tfooter;

		$('.star').click(function(){
			//alert("sini");
		  $(this).toggleClass("red-cell");
		});
    return false;
}
</script>
