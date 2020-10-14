<?php
//ini_set('max_execution_time', 0);
//ini_set("memory_limit", "-1");
ini_set('memory_limit','256M');
//ini_set('max_execution_time', 0);
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
//print_r($data);print_r($datadtl);
$mpdf = new mPDF('utf-8',array(240,297));
$html = getStyle();
$html .= '<body><div class="body">';
$html .= getHTML($data, $datadtl);
$html .= '</div></body>';
$mpdf->WriteHTML($html);
$mpdf->debug = true;
$mpdf->Output();
exit;

function getStyle() {
	//border: 1px solid green;
    $html = '<style type="text/css" text-align= "center">
				body{font:14px Arial;font-weight:normal;}div.body{padding:20px;padding-top:5px;}
				table{table-layout: fixed;width: 870px;}td, th{overflow: hidden;}
				@page{margin-top:150px;margin-bottom:0px;margin-right:35px;margin-left:35px;}
				h1{font-size:14px;font-weight:bold;}h2{font-size:13px;font-weight:bold;}
			</style>';
    return $html;
}

function getHTML($data, $datadtl) {
	$header = '
		<table>
			<tr>
				<td>
					<hr color="white" width="100%">
					<table>
						<tr>
							<td style="font-size: 16px;color: white;text-align:center;"><strong>SURAT PENGELUARAN BARANG (SPB)</strong></td>
						</tr>
					</table>
					<hr color="white" width="100%">
					<table>
						<tr>
						  <td style="width:140px">No. Order</td>
						  <td style="width: 10px">:</td>
						  <td style="width:250px">'.$data['NO_ORDER'].'</td>
						  <td></td>
						  <td style="width:110px">Nomor</td>
						  <td style="width: 10px">:</td>
						  <td style="width:270px">'.$data['NO_SP2'].'</td>
						</tr>
						<tr>
						  <td style="width:140px">Gudang/Lapangan</td>
						  <td style="width: 10px">:</td>
						  <td style="width:250px">'.$data['GUDANG'].'</td>
						  <td></td>
						  <td>Dikirim Kepada</td>
						  <td>:</td>
						  <td>'.$data['NAMA_FORWARDER'].'</td>
						</tr>
						<tr>
						  <td>Nama Kapal</td>
						  <td>:</td>
						  <td>'.$data['NM_ANGKUT'].'</td>
						  <td></td>
						  <td style="vertical-align:top">Alamat</td>
						  <td style="vertical-align:top">:</td>
						  <td style="vertical-align:top" rowspan=2>'.wordwrap($data['ALAMAT_FORWARDER'],50,"<br>\n").'</td>
						</tr>
						<tr>
						  <td style="vertical-align:top">No. Voyage</td>
						  <td style="vertical-align:top">:</td>
						  <td style="vertical-align:top">'.$data['NO_VOYAGE'].'</td>
						  <td></td>
						  <td></td>
						  <td></td>
						</tr>
						<tr>
						  <td style="vertical-align:top">Tanggal Kedatangan</td>
						  <td style="vertical-align:top">:</td>
						  <td style="vertical-align:top">'.$data['TGL_TIBA'].'</td>
						  <td></td>
						  <td>Nama Pemilik</td>
						  <td>:</td>
						  <td>'.$data['CONSIGNEE'].'</td>
						</tr>
						<tr>
						  <td>No. Polisi Truck</td>
						  <td>:</td>
						  <td>'.$data['NO_POLISI_TRUCK'].'</td>
						  <td></td>
						  <td>NPWP Pemilik</td>
						  <td>:</td>
						  <td>'.$data['NPWP_CONSIGNEE'].'</td>
						</tr>
						<tr>
						  <td>No. BL</td>
						  <td>:</td>
						  <td>'.$data['NO_BL_AWB'].'</td>
						  <td></td>
						  <td style="vertical-align:top">Alamat Pemilik</td>
						  <td style="vertical-align:top">:</td>
						  <td style="vertical-align:top" rowspan=2>'.wordwrap($data['ALAMAT_CONSIGNEE'],50,"<br>\n").'</td>
						</tr>
						<tr>
						  <td style="vertical-align:top">No. DO</td>
						  <td style="vertical-align:top">:</td>
						  <td style="vertical-align:top">'.$data['NO_DO'].'</td>
						  <td></td>
						  <td style="vertical-align:top"></td>
						  <td style="vertical-align:top"></td>
						</tr>
						<tr>
						  <td style="vertical-align:top">Tanggal Delivery</td>
						  <td style="vertical-align:top">:</td>
						  <td style="vertical-align:top">'.$data['TGL_KELUAR'].'</td>
						</tr>
					</table>
					<hr color="black" width="100%">
				</td>
			</tr>
		</table>
	';
    $arrRowDetail = count($datadtl);
    sort($arrRowDetail);$no=1;
	for ($p=0;$p<$arrRowDetail;$p++) {
		$blackorno = ($p%2==0)?"":'';
		$tablecontainer .= '
			<tr '.$blackorno.'>
			  <td style="text-align:center;font-size:16px">'.$no.'</td>
			  <td style="font-size:16px">'.$datadtl[$p]['MRK_KMS'].'</td>
			  <td style="text-align:center;font-size:16px">'.$datadtl[$p]['JNS_KMS'].'</td>
			  <td style="text-align:center;font-size:16px">'.$datadtl[$p]['JML_KMS'].'</td>
			  <td style="text-align:center;font-size:16px">'.$datadtl[$p]['WEIGHT'].'</td>
			  <td style="text-align:center;font-size:16px">'.$datadtl[$p]['MEASURE'].'</td>
			</tr>
		';
		$no++;
	}
	$body = '
		<table>
			<tr>
				<td>
					<table>
						<tr>
						  <td style="width:50px;text-align:center;"><h2>Sr No</h2></td>
						  <td><h2>Merk No</h2></td>
						  <td style="width:120px;text-align:center;"><h2>Jenis Kemasan</h2></td>
						  <td style="width:80px;text-align:center;"><h2>Jumlah Kemasan</h2></td>
						  <td style="width:80px;text-align:center;"><h2>Ton</h2></td>
						  <td style="width:80px;text-align:center;"><h2>M3</h2></td>
						</tr>
						'.$tablecontainer.'
					</table>
				</td>
			</tr>
		</table>
	';
	$footer = '
	<br><br><br>
		<table>
			<tr>
				<td style="width:250px;text-align:center;"></td>
				<td style="width:250px;text-align:center;"></td>
				<td style="width:250px;text-align:center;">TANJUNG PRIOK, '.indonesian_date().'
				<br><br><br><br><br><br><br><br>
				</td>
			</tr>
			<tr>
				<td style="text-align:center;">(PENERIMA)</td>
				<td style="text-align:center;">(SOPIR TRUCK)</td>
				<td style="text-align:center;">(PETUGAS)</td>
			</tr>
		</table>
	';
	$html = '<header>'.$header.'</header>'.
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