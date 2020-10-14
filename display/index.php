<html>
	<head>
		<title>Display Antrian CFS Center</title>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.3.0/jquery.min.js" type="text/javascript"></script>
		<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<script type="text/javascript">
			var auto_refresh = setInterval(
			function () {
			   $('#load_content').load('show.php').fadeIn("slow");
			}, 1000); // refresh setiap 10000 milliseconds
		</script>
		<style>
			.bg-1 { 
				/* background-color: #1abc9c;  Green */
				/* color: #ffffff; */
			}
			video {
				width: 100%;
				height: auto;
				position: relative;
			}
			.margi {
				margin-top: 5px;
				margin-bottom: 5px;
			}
			.loket{
				font-size:60px;
			}
			.nomor{
				font-size:90px;
			}
		<!--style>
			video {
				width: 100%;
				height: auto;
				position: relative;
			}
		</style-->
		<style>
			body {
			  background: #f1f1f1;
			  color: #222;
			}

			.container {
			  padding: 20px;
			  width: 600px;
			  display: block;
			  text-align: center;
			  margin: 0 auto;
			}

			.text {
				font-size: 30px;
				height: 500px;
				vertical-align: middle;
				overflow: hidden;
			}

			.text div {
				height: 500px;
				transition: margin-top 1s ease-in-out;
			}
		</style>
	</head>
	<body>
		<div class="container-fluid bg-1">
			<div class="row">
				<br>
				<div class="col-lg-9"><div><img style="width:100%;width:70%;" id="image" src="logo_cfs_cabang.jpg"></div></div>
				<div class="col-lg-3">
					<strong><div id="clock" class="text-center" style="font-size:48px;"></div></strong>
					<div class="text-center" style="font-size:26px;">
						<script type='text/javascript'>
							<!--
							var months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
							var myDays = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jum&#39;at', 'Sabtu'];
							var date = new Date();
							var day = date.getDate();
							var month = date.getMonth();
							var thisDay = date.getDay(),
								thisDay = myDays[thisDay];
							var yy = date.getYear();
							var year = (yy < 1000) ? yy + 1900 : yy;
							document.write(thisDay + ', ' + day + ' ' + months[month] + ' ' + year);
							function showTime() {
								var a_p = "";
								var today = new Date();
								var curr_hour = today.getHours();
								var curr_minute = today.getMinutes();
								var curr_second = today.getSeconds();
								/* if (curr_hour < 12) {
									a_p = "AM";
								} else {
									a_p = "PM";
								}
								if (curr_hour == 0) {
									curr_hour = 12;
								}
								if (curr_hour > 12) {
									curr_hour = curr_hour - 12;
								} */
								curr_hour = checkTime(curr_hour);
								curr_minute = checkTime(curr_minute);
								curr_second = checkTime(curr_second);
								document.getElementById('clock').innerHTML=curr_hour + ":" + curr_minute + ":" + curr_second + " " + a_p;
							}

							function checkTime(i) {
								if (i < 10) {
									i = "0" + i;
								}
								return i;
							}
							setInterval(showTime, 500);
							//-->
						</script>
					</div>
				</div>
			</div>
			<br>
			<div class="row">
				<div id="load_content"></div>
				<div class="col-lg-6">
					<div class="container">
					<video loop autoplay>
						<source src="cfs.mp4" type="video/mp4">
						Your browser does not support the video tag.
					</video>
					</div>
					<div class="container">	
						<table class="table-responsive table">
							<tr>
								<td style="width:23px;">No</td>
								<td style="width:270px;">Nama Tagihan</td>
								<td style="text-align:right;width:70px;">Harga</td>
								<td>Keterangan</td>
							</tr>
						</table>
						<div class="text">
<?php
include ('../TPSServices/config.php' );
$main = new main($CONF, $conn);
$main->connect();
$SQL = "SELECT A.DESKRIPSI,A.TARIF_DASAR,A.KETERANGAN FROM reff_billing_cfs A where A.UKURAN='KEMASAN'"; 
$Query = $conn->query($SQL);
		if ($Query->size() == 0) { 
			for($i=1;$i<=6;$i++){ 
				echo '<div><table class="table-responsive table"><tr><td colspan=4>Tidak ada data</td></tr></table></div>';
			}
		} else { $i=1;$of=0;$jml=$Query->size()/10;
			for($n=0;$n<$jml;$n++){
				echo '
					<div>
						<table class="table-responsive table">';
						$SQL = "SELECT A.DESKRIPSI,A.TARIF_DASAR,A.KETERANGAN FROM reff_billing_cfs A where A.UKURAN='KEMASAN'
						order by A.DESKRIPSI asc LIMIT 10 OFFSET ".$of; 
						$Query = $conn->query($SQL);
						while ($Query->next()) {
							echo '
								<tr>
								  <td style="width:23px;">'.$i.'</td>
								  <td style="width:270px;">'.$Query->get("DESKRIPSI").'</td>
								  <td style="text-align:right;width:70px;">'.number_format($Query->get("TARIF_DASAR")).'</td>
								  <td>'.$Query->get("KETERANGAN").'</td>
								</tr>
							';
							$i++;
						} 
				echo '	</table>
					</div>
				';
				$of+=10;
			}
		}
		?>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-offset-1 col-md-offset-1 col-lg-10 col-md-10">
					<h2 class="margi"><marquee class="">Budayakan Antri. ----- Terima kasih atas kunjungan Anda di CFS Center. -----</marquee></h2>
				</div>
			</div>
		</div>
		<script src="https://code.jquery.com/jquery-3.2.0.min.js"></script>
		<script type="text/javascript">
			var current = 1;
			var height = $('.text').height(); 
			var numberDivs = $('.text').children().length; 
			var first = $('.text div:nth-child(1)'); 
			setInterval(function() {
				var number = current * -height;
				first.css('margin-top', number + 'px');
				if (current === numberDivs) {
					first.css('margin-top', '0px');
					current = 1;
				} else current++;
			}, 10000);
		</script>
	</body>
</html>