<?php
//ini_set('max_execution_time', 0);
//ini_set("memory_limit", "-1");
ini_set('memory_limit','256M');
//ini_set('max_execution_time', 0);
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

$mpdf = new mPDF('utf-8',array(240,320));
$html = getStyle();
$html .= '<body><div class="body">';
$html .= getHTML($data, $datadtl);
// $footer2 = '
// <table>
// <tr>
//   <td><h1>KETENTUAN : </h1></td>
// </tr>
// <tr>
//   <td>Dalam waktu 5 hari kerja setelah invoice diterima. <br>Jika tidak ada pengajuan keberatan, maka saudara dianggap setuju.</td>
// </tr>
// </table>
// ';
$footer2 = '';
$html .= '</div>'.$footer2.'</body>';
$mpdf->WriteHTML($html);
$mpdf->debug = true;
$mpdf->Output($data['NO_INVOICE'].".pdf",'I');
exit;

function getStyle() {
	//border: 1px solid green;
    $html = '<style type="text/css" text-align= "center">
				body{font:14px Arial;font-weight:normal;}div.body{padding:20px;padding-top:5px;}
				table{table-layout: fixed;width: 870px;}td, th{overflow: hidden;}
				@page{margin-top:210px;margin-bottom:0px;margin-right:35px;margin-left:35px;}
				h1{font-size:14px;font-weight:bold;}h2{font-size:13px;font-weight:bold;}
			</style>';
    return $html;
}

function getHTML($data, $datadtl) {
	$ppn = ($data['JENIS_ORGANISASI']=='BUMN')?'Tidak Dipungut':number_format($data['PPN'], '0', ',', '.');
	//<div><h3 class="box-title"><img alt="Header" width="60%" src="/var/www/html/dev/cfs-center/assets/images/Logo_header_invoice.png"/></h3></div>
	$TGL_KEGIATAN=($data['JENIS_TRANSAKSI']=='BARU')?$data['TGL_STRIPPING'].' s/d '.$data['TGL_KELUAR']:$data['TGL_KELUAR_LAMA'].' s/d '.$data['TGL_KELUAR'];
	$COSTUMER=($data['NAMA_FORWARDER']==NULL)?$data['CONSIGNEE']:$data['NAMA_FORWARDER'];
	$NPWP_COSTUMER=($data['NPWP_FORWARDER']==NULL)?$data['NPWP_CONSIGNEE']:$data['NPWP_FORWARDER'];
	$ALAMAT_COSTUMER=($data['ALAMAT_FORWARDER']==NULL)?$data['ALAMAT_CONSIGNEE']:$data['ALAMAT_FORWARDER'];
	$header = '
		<table>
			<tr>
				<td>
					<table>
						<tr>
						  <td></td>
						  <td style="width:100px">No. Nota</td>
						  <td style="width:10px">:</td>
						  <td style="width:250px">'.$data['NO_INVOICE'].'</td>
						</tr>
						<tr>
						  <td></td>
						  <td style="width:100px">Ex. Nota</td>
						  <td style="width:10px">:</td>
						  <td style="width:250px">'.$data['EX_NOTA'].'</td>
						</tr>
						<tr>
						  <td></td>
						  <td style="width:100px">No. Order</td>
						  <td style="width:10px">:</td>
						  <td style="width:250px">'.$data['NO_ORDER'].'</td>
						</tr>
						<tr>
						  <td></td>
						  <td>Tanggal</td>
						  <td>:</td>
						  <td>'.indonesian_date().'</td>
						</tr>
						<tr><td></td></tr>
						<tr><td></td></tr>
						<tr>
						  <td></td>
						  <td colspan=3>Nota Berlaku Sebagai Faktur Pajak Berdasarkan Peraturan Dirjen Pajak PER-33/PJ/2014 Tanggal 30 Desember 2014</td>
						</tr>
					</table>
					<table>
						<tr>
							<td><h1 style="font-weight:bold">NOTA DAN PERHITUNGAN PELAYANAN JASA : LCL CARGO</td>
						</tr>
					</table>
					<hr color="black" width="100%">
					<table>
						<tr>
						  <td style="width:120px">Kepada</td>
						  <td style="width: 10px">:</td>
						  <td style="width:300px">'.$COSTUMER.'</td>
						  <td></td>
						  <td style="width:100px">No. DO</td>
						  <td style="width: 10px">:</td>
						  <td style="width:250px">'.$data['NO_DO'].'</td>
						</tr>
						<tr>
						  <td>NPWP</td>
						  <td>:</td>
						  <td>'.$NPWP_COSTUMER.'</td>
						  <td></td>
						  <td>No BL</td>
						  <td>:</td>
						  <td>'.$data['NO_BL_AWB'].'</td>
						</tr>
						<tr>
						  <td style="vertical-align:top">Alamat</td>
						  <td style="vertical-align:top">:</td>
						  <td style="vertical-align:top" rowspan=2>'.$ALAMAT_COSTUMER.'</td>
						  <td></td>
						  <td>Tanggal Tiba</td>
						  <td>:</td>
						  <td>'.$data['TGL_TIBA'].'</td>
						</tr>
						<tr>
						  <td></td>
						  <td></td>
						  <td></td>
						  <td>Nama Kapal</td>
						  <td>:</td>
						  <td>'.$data['NM_ANGKUT'].'</td>
						</tr>
						<tr>
						  <td></td>
						  <td></td>
						  <td><h2></h2></td>
						  <td></td>
						  <td>No Container</td>
						  <td>:</td>
						  <td>'.$data['NO_CONT_ASAL'].'</td>
						</tr>
						<tr>
						  <td>Nama Pemilik</td>
						  <td>:</td>
						  <td><h2>'.$data['CONSIGNEE'].'</h2></td>
						  <td></td>
						  <td>Pembayaran</td>
						  <td>:</td>
						  <td>'.$data['JENIS_PEMBAYARAN'].'</td>
						</tr>
						<tr>
						  <td style="vertical-align:top">Alamat Pemilik</td>
						  <td style="vertical-align:top">:</td>
						  <td colspan=5 style="vertical-align:top"><h2>'.$data['ALAMAT_CONSIGNEE'].'</h2></td>
						</tr>
					</table>
					<hr color="black" width="100%">
					<table>
						<tr>
						  <td style="width:120px">Lokasi</td>
						  <td style="width:10px">:</td>
						  <td>'.$data['GUDANG'].'</td>
						</tr>
						<tr>
						  <td>Weight/Measure</td>
						  <td>:</td>
						  <td>'.$data['WEIGHT'].' Kg / '.$data['MEASURE'].' M3</td>
						</tr>
						<tr>
						  <td>Status Transaksi</td>
						  <td>:</td>
						  <td>'.$data['JENIS_TRANSAKSI'].'</td>
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
						<tr><td></td></tr>
					</table>
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
			  <td style="text-align:center;">'.$no.'</td>
			  <td>'.$datadtl[$p]['DESKRIPSI'].'</td>
			  <td style="text-align:center;">'.$datadtl[$p]['QTY'].'</td>
			  <td style="text-align:center;">'.$datadtl[$p]['HARI'].'</td>
			  <td style="text-align:center;">'.$datadtl[$p]['SATUAN'].'</td>
			  <td style="text-align:right;">'.number_format($datadtl[$p]['TARIF_DASAR'], '0', ',', '.').'</td>
			  <td style="text-align:right;">'.number_format($datadtl[$p]['TOTAL'], '0', ',', '.').'</td>
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
						  <td style="width:30px;text-align:center;"><h2>No</h2></td>
						  <td><h2>Item Tagihan</h2></td>
						  <td style="width:60px;text-align:center;"><h2>Qty</h2></td>
						  <td style="width:60px;text-align:center;"><h2>Hari</h2></td>
						  <td style="width:60px;text-align:center;"><h2>Satuan</h2></td>
						  <td style="width:100px;text-align:right;"><h2>Tarif (Rp)</h2></td>
						  <td style="width:100px;text-align:right;"><h2>Jumlah</h2></td>
						</tr>
						'.$tablecontainer.'
					</table>
					<hr color="black" width="100%">
					<table>
						<tr>
						  <td></td>
						  <td style="width:100px;">Sub Total</td>
						  <td style="width:50px;">: Rp.</td>
						  <td style="width:150px;text-align:right;">'.number_format($data['SUBTOTAL'], '0', ',', '.').'</td>
						</tr>
						<tr>
						  <td></td>
						  <td>PPn (10%)</td>
						  <td>: Rp.</td>
						  <td style="text-align:right;">'.$ppn.'</td>
						</tr>
						<tr>
						  <td></td>
						  <td>Total</td>
						  <td>: Rp.</td>
						  <td style="text-align:right;">'.number_format($data['TOTAL'], '0', ',', '.').'</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	';
	$footer = '
		<table>
			<tr>
				<td>
					<table>
						<tr>
						  <td style="width:100px">Terbilang</td>
						  <td style="width:10px">:</td>
						  <td>'.terbilang($data['TOTAL']).' RUPIAH</td>
						</tr>
					</table>
				</td>
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

function indonesian_date ($timestamp = '', $date_format = 'l, j F Y H:i:s', $suffix = '') {
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
