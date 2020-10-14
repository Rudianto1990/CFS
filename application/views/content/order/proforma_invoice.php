<?php
//ini_set('max_execution_time', 0);
//ini_set("memory_limit", "-1");
ini_set('memory_limit','256M');
//ini_set('max_execution_time', 0);
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

$mpdf = new mPDF('utf-8',array(85,200));
$html = getStyle();
$html .= '<body><div class="body">';
$html .= getHTML($data, $datadtl);
$html .= '</div></body>';
$mpdf->WriteHTML($html);
$mpdf->debug = true;
$mpdf->Output($data['NO_PROFORMA_INVOICE'].".pdf",'I');
exit;

function getStyle() {
	//border: 1px solid green;
    $html = '<style type="text/css" text-align= "center">
				body{font:12px Arial;font-weight:normal;}div.body{padding:1px;padding-top:0px;}
				table{table-layout: fixed;}td, th{overflow: hidden;}
				@page{margin-top:0px;margin-bottom:0px;margin-right:0px;margin-left:10px;}
			</style>';
    return $html;
				//h1{font-size:14px;font-weight:bold;}h2{font-size:12px;font-weight:bold;}
}

function getHTML($data, $datadtl) {
	$TGL_KEGIATAN=($data['JENIS_TRANSAKSI']=='BARU')?$data['TGL_STRIPPING'].' s/d '.$data['TGL_KELUAR']:$data['TGL_KELUAR_LAMA'].' s/d '.$data['TGL_KELUAR'];
	$ppn = ($data['JENIS_ORGANISASI']=='BUMN')?'Tidak Dipungut':number_format($data['PPN'], '0', ',', '.');
	$org=($data['NAMA_FORWARDER']=='')?$data['CONSIGNEE']:$data['NAMA_FORWARDER'];
	$orgnp=($data['NPWP_FORWARDER']=='')?$data['NPWP_CONSIGNEE']:$data['NPWP_FORWARDER'];
	$orgal=($data['ALAMAT_FORWARDER']=='')?$data['ALAMAT_CONSIGNEE']:$data['ALAMAT_FORWARDER'];
    $arrRowDetail = count($datadtl);
    sort($arrRowDetail);$no=1;
	for ($p=0;$p<$arrRowDetail;$p++) {
		$blackorno = ($p%2==0)?"":'';
		$tablecontainer .= '
			<tr '.$blackorno.'>
			  <td>'.$datadtl[$p]['DESKRIPSI'].'</td>
			  <td style="text-align:center;vertical-align:top">'.ceil($datadtl[$p]['QTY']).'</td>
			  <td style="text-align:center;vertical-align:top">'.$datadtl[$p]['HARI'].'</td>
			  <td style="text-align:right;vertical-align:top">'.number_format($datadtl[$p]['TOTAL'], '0', ',', '.').'</td>
			</tr>
		';
		$no++;
	}
	$header = '
		<div><h3 class="box-title"><img alt="Header" width="100%" src="/var/www/html/dev/cfs-center/assets/images/Logo_header_invoice.png"/></h3></div>
<div style="text-align:center;"><b style="color:white">asd</b><barcode code="*PRO%'.$data['NO_ORDER'].'%'.$data['NO_PROFORMA_INVOICE'].'#" size="1.2" type="QR" error="M" class="barcode" disableborder=1/></div>	
<table>
						<tr>
						  <td>No. Order</td>
						  <td>:</td>
						  <td>'.$data['NO_ORDER'].'</td>
						</tr>
						<tr>
						  <td>No. Proforma</td>
						  <td>:</td>
						  <td>'.$data['NO_PROFORMA_INVOICE'].'</td>
						</tr>
						<tr>
						  <td>Tanggal</td>
						  <td>:</td>
						  <td>'.indonesian_date().'</td>
						</tr>
						<tr><td colspan=3 style="color:white;">a</td></tr>
						<tr>
						  <td colspan=3>'.$org.'</td>
						</tr>
						<tr>
						  <td colspan=3>'.$orgnp.'</td>
						</tr>
						<tr>
						  <td colspan=3 style="vertical-align:top">'.$orgal.'</td>
						</tr>
						<tr><td colspan=3 style="color:white;">a</td></tr>
						<tr>
						  <td style="vertical-align:top">No. B/L</td>
						  <td style="vertical-align:top">:</td>
						  <td style="vertical-align:top">'.$data['NO_BL_AWB'].'</td>
						</tr>
						<tr>
						  <td style="vertical-align:top"></td>
						  <td style="vertical-align:top"></td>
						  <td style="vertical-align:top">'.$data['WEIGHT'].' Kg / '.$data['MEASURE'].' M<sup>3</sup> / '.$data['JML_KMS'].' '.$data['JNS_KMS'].'</td>
						</tr>
						<tr>
						  <td>Tanggal Stripping</td>
						  <td>:</td>
						  <td>'.$data['TGL_STRIPPING'].'</td>
						</tr>
						<tr>
						  <td>Tanggal Kegiatan</td>
						  <td>:</td>
						  <td>'.$TGL_KEGIATAN.'</td>
						</tr>
						</table>
<hr>
<table>
						<tr>
						  <td style="width:160px">Tagihan</td>
						  <td style="text-align:center;">QTY</td>
						  <td style="text-align:center;">Hari</td>
						  <td style="text-align:right;width:100px">Jumlah</td>
						</tr>
						'.$tablecontainer.'
						</table>
<hr>
<table>
						<tr>
						  <td style="font-weight:bold;width:175px">Sub Total</td>
						  <td style="font-weight:bold;">: Rp.</td>
						  <td style="text-align:right;font-weight:bold;width:100px">'.number_format($data['SUBTOTAL'], '0', ',', '.').'</td>
						</tr>
						<tr>
						  <td style="font-weight:bold">PPn (10%)</td>
						  <td style="font-weight:bold">: Rp.</td>
						  <td style="text-align:right;font-weight:bold">'.$ppn.'</td>
						</tr>
						<tr>
						  <td style="font-weight:bold">Total</td>
						  <td style="font-weight:bold">: Rp.</td>
						  <td style="text-align:right;font-weight:bold">'.number_format($data['TOTAL'], '0', ',', '.').'</td>
						</tr>
					</table>
					<br>
					<table>
						<tr>
						  <td style="vertical-align:top">Terbilang</td>
						  <td style="vertical-align:top">:</td>
						  <td>'.terbilang($data['TOTAL']).' RUPIAH</td>
						</tr>
					</table>
	';
	$body = '
	';
	$footer = '
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

function indonesian_date ($timestamp = '', $date_format = 'd-m-Y H:i:s', $suffix = '') {
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