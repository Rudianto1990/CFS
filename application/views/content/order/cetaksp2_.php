<?php
//ini_set('max_execution_time', 0);
//ini_set("memory_limit", "-1");
ini_set('memory_limit','256M');
//ini_set('max_execution_time', 0);
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

$mpdf = new mPDF('utf-8','A4');
$html = getStyle();
$html .= '<body><div class="body">';
$arrRowDetail = count($datadtl);
sort($arrRowDetail);$no=1;
for ($p=0;$p<$arrRowDetail;$p++) {
$html .= getHTML($datadtl[$p],$p);
}
$html .= '</div></body>';
$mpdf->WriteHTML($html);
$mpdf->debug = true;
$mpdf->Output();
exit;

function getStyle() {
    $html = '<style type="text/css" text-align= "center">
				body{font:12px Arial;font-weight:normal;}div.body{padding:20px;padding-top:5px;}
                table{border-collapse:separate;border-spacing:0;width:100%;}
				@page{margin-top:0.6px;margin-bottom:0px;margin-right:42px;margin-left:42px;}
				h1{font-size:8px;font-weight:normal;}h2{font-size:6px;font-weight:normal;}table{table-layout: fixed;width:100%;}
				table, th, td {table-layout: fixed;border: 0px solid black;border-collapse: collapse;overflow: hidden;display: inline-block;}th, td {padding: 5px;text-align: left;}
				table, tr, td {table-layout: fixed;border: 0px;}tr.noBorder td {border: 0;}td.noBorders th{border: 0;}th.black{background-color: #EDEDED;color: white;}
				tr.black{background-color: #656563;color: white;}tr.grey{background-color: #E8E8E8;color: white;}
			</style>';
    return $html;
}

function getHTML($data,$p) {
	$header = '
		<div><h3 class="box-title"><img alt="Header" width="60%" src="/var/www/html/dev/cfs-center/assets/images/Logo_header_invoice.png"/></h3></div>
		<div style="text-align:left;">
			<table>
				<tr>
					<td>
						<hr color="black" width="100%">
						<table>
							<tr>
								<td width="660px" style="font-size: 16px;text-align:center;"><strong>SURAT PENYERAHAN PETIKEMAS (SP2)</strong></td>
							</tr>
						</table>
						<hr color="black" width="100%">
						<table>
							<tr>
							  <th style="width:80px"><h1>Nomor Petikemas</h1></th>
							  <th style="width:10px"><h1>:</h1></th>
							  <th style="width:120px"><h1>'.$data['NO_CONT'].'</h1></th>
							  <th style="width:50px"><h1></h1></th>
							  <th style="width:80px"><h1>Nomor SP2</h1></th>
							  <th style="width:10px"><h1>:</h1></th>
							  <th style="width:120px"><h1>'.$data['NO_SP2'].'</h1></th>
							</tr>
							<tr>
							  <th style="width:80px"><h1>Ukuran Petikemas</h1></th>
							  <th style="width:10px"><h1>:</h1></th>
							  <th style="width:120px"><h1>'.$data['UK_CONT'].'</h1></th>
							  <th style="width:50px"><h1></h1></th>
							  <th style="width:80px"><h1>Tanggal Tiba</h1></th>
							  <th style="width:10px"><h1>:</h1></th>
							  <th style="width:120px"><h1>'.$data['TGL_TIBA'].'</h1></th>
							</tr>
							<tr>
							  <th style="width:80px"><h1>Nama Kapal / Voyage</h1></th>
							  <th style="width:10px"><h1>:</h1></th>
							  <th style="width:120px"><h1>'.$data['NM_ANGKUT'].' / '.$data['NO_VOYAGE'].'</h1></th>
							  <th style="width:50px"><h1></h1></th>
							  <th style="width:80px"><h1>Nomor B/L</h1></th>
							  <th style="width:10px"><h1>:</h1></th>
							  <th style="width:120px"><h1>'.$data['NO_BL_AWB'].'</h1></th>
							</tr>
							<tr>
							  <th style="width:80px"><h1>Gudang</h1></th>
							  <th style="width:10px"><h1>:</h1></th>
							  <th style="width:120px"><h1>'.$data['GUDANG'].'</h1></th>
							  <th style="width:50px"><h1></h1></th>
							  <th style="width:80px"><h1>No. D/O</h1></th>
							  <th style="width:10px"><h1>:</h1></th>
							  <th style="width:120px"><h1>'.$data['NO_DO'].'</h1></th>
							</tr>
							<tr>
							  <th style="width:80px"><h1>Penerima</h1></th>
							  <th style="width:10px"><h1>:</h1></th>
							  <th style="width:120px" colspan=5><h1>'.$data['NAMA_FORWARDER'].'</h1></th>
							</tr>
							<tr>
							  <th style="width:80px"><h1>Tujuan</h1></th>
							  <th style="width:10px"><h1>:</h1></th>
							  <th style="width:120px" colspan=5><h1>'.$data['ALAMAT_FORWARDER'].'</h1></th>
							</tr>
							<tr>
							  <th style="width:80px"><h1>Nama Pemilik</h1></th>
							  <th style="width:10px"><h1>:</h1></th>
							  <th style="width:120px" colspan=5><h1>'.$data['CONSIGNEE'].'</h1></th>
							</tr>
							<tr>
							  <th style="width:80px"><h1>NPWP Pemilik</h1></th>
							  <th style="width:10px"><h1>:</h1></th>
							  <th style="width:120px" colspan=5><h1>'.$data['NPWP_CONSIGNEE'].'</h1></th>
							</tr>
							<tr>
							  <th style="width:80px;vertical-align:top"><h1>Alamat Pemilik</h1></th>
							  <th style="width:10px;vertical-align:top"><h1>:</h1></th>
							  <th style="width:120px;vertical-align:top" colspan=5><h1>'.$data['ALAMAT_CONSIGNEE'].'</h1></th>
							</tr>
							<tr>
							  <th style="width:80px"><h1>No. Kendaraan</h1></th>
							  <th style="width:10px"><h1>:</h1></th>
							  <th style="width:120px" colspan=5><h1>'.$data['NO_POLISI_TRUCK'].'</h1></th>
							</tr>
						</table>
						<hr color="black" width="100%">
					</td>
				</tr>
			</table>
		</div>
	';
	$body = '
		<table>
			<tr class="noBorder">
				<td><img alt="Header" src="/var/www/html/dev/cfs-center/assets/images/sp2.jpg"/></td>
			</tr>
		</table>
		<hr color="black" width="100%">
	';
	$footer = '
		<table align="left" border=1>
			<tr>
			  <th style="width:10px;text-align:left;">
				REMARKS:
				<h1>Kontainer dalam kondisi baik / rusak :</h1>
				<br><br><br><br><br>
			  </th>
			</tr>
		</table>
	';
	$pagebreak=($p==0)?'':'<pagebreak><br>';
	$html = $pagebreak.'<header>'.$header.'</header>'.
			'<body>'.$body.'<body>'.
			'<footer>'.$footer.'</footer>';			
    return $html;
}

function Terbilang($x){
  $abil = array("", "SATU", "DUA", "TIGA", "EMPAT", "LIMA", "ENAM", "TUJUH", "DELAPAN", "SEMBILAN", "SEPULUH", "SEBELAS");
  if ($x < 12)
    return " " . $abil[$x];
  elseif ($x < 20)
    return Terbilang($x - 10) . " BELAS";
  elseif ($x < 100)
    return Terbilang($x / 10) . " PULUH" . Terbilang($x % 10);
  elseif ($x < 200)
    return " SERATUS" . Terbilang($x - 100);
  elseif ($x < 1000)
    return Terbilang($x / 100) . " RATUS" . Terbilang($x % 100);
  elseif ($x < 2000)
    return " SERIBU" . Terbilang($x - 1000);
  elseif ($x < 1000000)
    return Terbilang($x / 1000) . " RIBU" . Terbilang($x % 1000);
  elseif ($x < 1000000000)
    return Terbilang($x / 1000000) . " JUTA" . Terbilang($x % 1000000);
}

function indonesian_date ($timestamp = '', $date_format = 'l, j F Y', $suffix = '') {
    if (trim ($timestamp) == '') { $timestamp = time (); }
    elseif (!ctype_digit ($timestamp)) { $timestamp = strtotime ($timestamp); }
    // remove S (st,nd,rd,th) there are no such things in indonesia :p
	// $suffix untuk waktu bagian. contoh WIB,WITA,WIT
    $date_format = preg_replace ("/S/", "", $date_format);
    $pattern = array (
        '/Mon[^day]/','/Tue[^sday]/','/Wed[^nesday]/','/Thu[^rsday]/','/Fri[^day]/','/Sat[^urday]/','/Sun[^day]/','/Monday/','/Tuesday/',
        '/Wednesday/','/Thursday/','/Friday/','/Saturday/','/Sunday/','/Jan[^uary]/','/Feb[^ruary]/','/Mar[^ch]/','/Apr[^il]/','/May/',
        '/Jun[^e]/','/Jul[^y]/','/Aug[^ust]/','/Sep[^tember]/','/Oct[^ober]/','/Nov[^ember]/','/Dec[^ember]/','/January/','/February/','/March/',
        '/April/','/June/','/July/','/August/','/September/','/October/','/November/','/December/',
    );
    $replace = array ( 
		'Sen','Sel','Rab','Kam','Jum','Sab','Min','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu','Jan','Feb','Mar','Apr','Mei','Jun','Jul',
		'Ags','Sep','Okt','Nov','Des','Januari','Februari','Maret','April','Juni','Juli','Agustus','Sepember','Oktober','November','Desember',
    );
    $date = date ($date_format, $timestamp);
    $date = preg_replace ($pattern, $replace, $date);
    $date = "{$date} {$suffix}";
    return $date;
} 

?>