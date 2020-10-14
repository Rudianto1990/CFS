<?php
//ini_set('max_execution_time', 0);
//ini_set("memory_limit", "-1");
ini_set('memory_limit','256M');
//ini_set('max_execution_time', 0);
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

$mpdf = new mPDF('utf-8',array(260,297));
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
	//border: 1px solid green;
    $html = '<style type="text/css" text-align= "center">
				body{font:14px Arial;font-weight:normal;}div.body{padding:20px;padding-top:5px;}
				table{table-layout: fixed;width: 880px;}td, th{overflow: hidden;}
				@page{margin-top:150px;margin-bottom:0px;margin-right:35px;margin-left:35px;}
				h1{font-size:14px;font-weight:bold;}h2{font-size:13px;font-weight:bold;}
			</style>';
    return $html;
}

function getHTML($data,$p) {
	$header = '
		<table>
			<tr>
				<td>
					<hr color="white" width="100%">
					<table>
						<tr>
							<td style="font-size: 16px;color: white;text-align:center;"><strong>SURAT PENYERAHAN PETIKEMAS (SP2)</strong></td>
						</tr>
					</table>
					<hr color="white" width="100%">
					<table>
						<tr>
						  <td style="width:150px;vertical-align:top">Nomor Petikemas</td>
						  <td style="width: 10px;vertical-align:top">:</td>
						  <td style="font-size: 24px;width:260px"><strong>'.$data['NO_CONT'].'</strong></td>
						  <td></td>
						  <td style="width:100px;vertical-align:bottom">Nomor Order</td>
						  <td style="width: 10px;vertical-align:bottom">:</td>
						  <td style="width:250px;vertical-align:bottom">'.$data['NO_ORDER'].'</td>
						</tr>
						<tr>
						  <td>Ukuran Petikemas</td>
						  <td>:</td>
						  <td>'.$data['UK_CONT'].'</td>
						  <td></td>
						  <td>Nomor SP2</td>
						  <td>:</td>
						  <td>'.$data['NO_SP2'].'</td>
						</tr>
						<tr>
						  <td>Nama Kapal / Voyage</td>
						  <td>:</td>
						  <td>'.$data['NM_ANGKUT'].' / '.$data['NO_VOYAGE'].'</td>
						  <td></td>
						  <td>Tanggal Tiba</td>
						  <td>:</td>
						  <td>'.$data['TGL_TIBA'].'</td>
						</tr>
						<tr>
						  <td>Gudang</td>
						  <td>:</td>
						  <td>'.$data['GUDANG'].'</td>
						  <td></td>
						  <td>Nomor B/L</td>
						  <td>:</td>
						  <td>'.$data['NO_BL_AWB'].'</td>
						</tr>
						<tr>
						  <td>Penerima</td>
						  <td>:</td>
						  <td>'.$data['NAMA_FORWARDER'].'</td>
						  <td></td>
						  <td>No. D/O</td>
						  <td>:</td>
						  <td>'.$data['NO_DO'].'</td>
						</tr>
						<tr>
						  <td>Tujuan</td>
						  <td>:</td>
						  <td colspan=5>'.$data['ALAMAT_FORWARDER'].'</td>
						</tr>
						<tr>
						  <td>Nama Pemilik</td>
						  <td>:</td>
						  <td colspan=5>'.$data['CONSIGNEE'].'</td>
						</tr>
						<tr>
						  <td>NPWP Pemilik</td>
						  <td>:</td>
						  <td colspan=5>'.$data['NPWP_CONSIGNEE'].'</td>
						</tr>
						<tr>
						  <td>Alamat Pemilik</td>
						  <td>:</td>
						  <td colspan=5>'.$data['ALAMAT_CONSIGNEE'].'</td>
						</tr>
						<tr>
						  <td>No. Kendaraan</td>
						  <td>:</td>
						  <td colspan=5>'.$data['NO_POLISI_TRUCK'].'</td>
						</tr>
						<tr>
						  <td>Tanggal Delivery</td>
						  <td>:</td>
						  <td colspan=5>'.$data['TGL_KELUAR'].'</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	';
	$body = '
	';
	$footer = '
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
		'Ags','Sep','Okt','Nov','Des','Januari','Februari','Maret','April','Juni','Juli','Agustus','September','Oktober','November','Desember',
    );
    $date = date ($date_format, $timestamp);
    $date = preg_replace ($pattern, $replace, $date);
    $date = "{$date} {$suffix}";
    return $date;
} 

?>