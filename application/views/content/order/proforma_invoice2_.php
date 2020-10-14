<?php
//ini_set('max_execution_time', 0);
//ini_set("memory_limit", "-1");
ini_set('memory_limit','256M');
//ini_set('max_execution_time', 0);
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

    $arrRowDetail = count($datadtl);
	//echo $arrRowDetail;print_r($datadtl);
    sort($arrRowDetail);$tableheadercontainer='';
	for ($p=0;$p<$arrRowDetail;$p++) {
		$check = "SELECT B.NO_CONT, func_name(B.KD_UK_CONT,'CONT_UKURAN') AS UKURAN_CONT, 
		DATE_FORMAT(C.TGL_KELUAR, '%d-%m-%Y') AS TGL_KELUAR,
		func_name(C.KD_GUDANG_TUJUAN,'GUDANG') AS LOKASI, func_name(C.KD_GUDANG_ASAL,'GUDANG') as TERMINAL_ASAL 
		from t_billing_cfshdr A join t_billing_cfsdtl B on B.ID=A.ID JOIN t_order_hdr C ON C.NO_ORDER=A.NO_ORDER
		where A.NO_ORDER='".$data['NO_ORDER']."' AND B.NO_CONT='".$datadtl[$p]['NO_CONT']."' LIMIT 1";
		//echo $check.'<br>';
		$checkss=$this->db->query($check);
		$resulte = $checkss->row_array();
		$SQL = "select C.DESKRIPSI, B.NO_CONT,B.QTY, B.SATUAN, B.TARIF_DASAR, B.TOTAL from t_billing_cfshdr A 
					join t_billing_cfsdtl B on A.ID=B.ID left JOIN reff_billing_cfs C on C.KODE_BILL=B.KODE_BILL
		WHERE B.NO_CONT = '".$datadtl[$p]['NO_CONT']."' and A.NO_ORDER='".$data['NO_ORDER']."'";
		$check1 = $this->db->query($SQL);
		$resulte1 = $check1->result_array();
		$no=1;$p1=0;//var_dump($resulte);var_dump($resulte1);
		foreach ($resulte1 as $row) {
			$blackorno = ($p1%2==0)?"":'class="grey"';
			$tablecontainer .= '
				<tr '.$blackorno.'>
				  <th><h1>'.$no.'</h1></th>
				  <th><h1>'.$row['DESKRIPSI'].'</h1></th>
				  <th style="text-align:right;"><h1>'.$row['QTY'].'</h1></th>
				  <th style="text-align:right;"><h1>'.$row['SATUAN'].'</h1></th>
				  <th style="text-align:right;"><h1>'.$row['TARIF_DASAR'].'</h1></th>
				  <th style="text-align:right;"><h1>'.$row['TOTAL'].'</h1></th>
				</tr>
			';
			$no++;$p1++;
		}
		$tableheadercontainer .= '
			<table>
				<tr>
				  <th style="width:80px"><h1>Lokasi</h1></th>
				  <th style="width:10px"><h1>:</h1></th>
				  <th style="width:100px"><h1>'.$resulte['LOKASI'].'</h1></th>
				</tr>
				<tr>
				  <th style="width:80px"><h1>Terminal Asal</h1></th>
				  <th style="width:10px"><h1>:</h1></th>
				  <th style="width:100px"><h1>'.$resulte['TERMINAL_ASAL'].'</h1></th>
				</tr>
				<tr>
				  <th style="width:80px"><h1>No Container</h1></th>
				  <th style="width:10px"><h1>:</h1></th>
				  <th style="width:100px"><h1>'.$resulte['NO_CONT'].' / '.$resulte['UKURAN_CONT'].'</h1></th>
				</tr>
				<tr>
				  <th style="width:80px"><h1>Tanggal Delivery</h1></th>
				  <th style="width:10px"><h1>:</h1></th>
				  <th style="width:100px"><h1>'.$resulte['TGL_KELUAR'].'</h1></th>
				</tr>
				<tr><th colspan=7></th></tr>
			</table>
		<table>
			<tr class="noBorder">
				<td>
					<table align="left">
						<tr class="black" width="660px">
						  <th style="width:10px;text-align:center;"><h1 style="color:white; font-weight:bold">No.</h1></th>
						  <th style="width:280px;text-align:center;"><h1 style="color:white; font-weight:bold">Item Tagihan</h1></th>
						  <th style="width:60px;text-align:center;"><h1 style="color:white; font-weight:bold">Qty</h1></th>						  
						  <th style="width:100px;text-align:center;"><h1 style="color:white; font-weight:bold">Satuan</h1></th>
						  <th style="width:100px;text-align:center;"><h1 style="color:white; font-weight:bold">Tarif (Rp)</h1></th>
						  <th style="width:100px;text-align:center;"><h1 style="color:white; font-weight:bold">Jumlah</h1></th>
						</tr>
						'.$tablecontainer.'
					</table>
				</td>
			</tr>
		</table><br>
		';
	}

$mpdf = new mPDF('utf-8','A4');
$html = getStyle();
$html .= '<body><div class="body">';
$html .= getHTML($data, $tableheadercontainer);
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

function getHTML($data, $tableheadercontainer) {
	$ppn = ($data['JENIS_ORGANISASI']=='BUMN')?'Tidak Dipungut':number_format($data['PPN'], '0', ',', '.');
	$header = '
		<div><h3 class="box-title"><img alt="Header" width="60%" src="/var/www/html/dev/cfs-center/assets/images/Logo_header_invoice.png"/></h3></div>
		<div style="text-align:left;">
			<table>
				<tr>
					<td>
						<table>
							<tr>
							  <th style="width:80px"><h1 style="color:white;">ALAMAT</h1></th>
							  <th style="width:10px"><h1 style="color:white;">:</h1></th>
							  <th style="width:120px"><h1 style="color:white;">Jl. Raya Pelabuhan No.8 Tanjung Priok Jakarta 14310</h1></th>
							  <th style="width:50px"><h1></h1></th>
							  <th style="width:80px"><h1>No. Proforma</h1></th>
							  <th style="width:10px"><h1>:</h1></th>
							  <th style="width:120px"><h1>'.$data['NO_PROFORMA_INVOICE'].'</h1></th>
							</tr>
						</table>
						<table>
							<tr class="black">
								<td width="660px"><h1 style="color:white; font-weight:bold">PROFORMA INVOICE PELAYANAN JASA : LCL PETI KEMAS</h1></td>
							</tr>
						</table>
						<hr color="black" width="100%">
						<table>
							<tr>
							  <th style="width:80px"><h1>Kepada</h1></th>
							  <th style="width:10px"><h1>:</h1></th>
							  <th style="width:120px"><h1>'.$data['NAMA_FORWARDER'].'</h1></th>
							  <th style="width:50px"><h1></h1></th>
							  <th style="width:80px"><h1>No. DO</h1></th>
							  <th style="width:10px"><h1>:</h1></th>
							  <th style="width:120px"><h1>'.$data['NO_DO'].'</h1></th>
							</tr>
							<tr>
							  <th style="width:80px"><h1>NPWP</h1></th>
							  <th style="width:10px"><h1>:</h1></th>
							  <th style="width:120px"><h1>'.$data['NPWP_FORWARDER'].'</h1></th>
							  <th style="width:50px"><h1></h1></th>
							  <th style="width:80px"><h1>No BL</h1></th>
							  <th style="width:10px"><h1>:</h1></th>
							  <th style="width:120px"><h1>'.$data['NO_BL_AWB'].'</h1></th>
							</tr>
							<tr>
							  <th style="width:80px;vertical-align:top"><h1>Alamat</h1></th>
							  <th style="width:10px;vertical-align:top"><h1>:</h1></th>
							  <th style="width:120px;vertical-align:top" rowspan=2><h1>'.wordwrap($data['ALAMAT_FORWARDER'],50,"<br>\n").'</h1></th>
							  <th style="width:50px"><h1></h1></th>
							  <th style="width:80px"><h1>Tanggal Tiba</h1></th>
							  <th style="width:10px"><h1>:</h1></th>
							  <th style="width:120px"><h1>'.$data['TGL_TIBA'].'</h1></th>
							</tr>
							<tr>
							  <th style="width:80px"><h1></h1></th>
							  <th style="width:10px"><h1></h1></th>
							  <th style="width:50px"><h1></h1></th>
							  <th style="width:80px"><h1>Nama Angkut</h1></th>
							  <th style="width:10px"><h1>:</h1></th>
							  <th style="width:120px"><h1>'.$data['NM_ANGKUT'].'</h1></th>
							</tr>
							<tr>
							  <th style="width:80px"><h1>Nama Pemilik</h1></th>
							  <th style="width:10px"><h1>:</h1></th>
							  <th style="width:120px"><h1>'.$data['CONSIGNEE'].'</h1></th>
							  <th style="width:50px"><h1></h1></th>
							  <th style="width:80px"><h1></h1></th>
							  <th style="width:10px"><h1></h1></th>
							  <th style="width:120px"><h1></h1></th>
							</tr>
							<tr>
							  <th style="width:80px"><h1>NPWP Pemilik</h1></th>
							  <th style="width:10px"><h1>:</h1></th>
							  <th style="width:120px"><h1>'.$data['NPWP_CONSIGNEE'].'</h1></th>
							  <th style="width:50px"><h1></h1></th>
							  <th style="width:80px"><h1></h1></th>
							  <th style="width:10px"><h1></h1></th>
							  <th style="width:120px"><h1></h1></th>
							</tr>
							<tr>
							  <th style="width:80px;vertical-align:top"><h1>Alamat Pemilik</h1></th>
							  <th style="width:10px;vertical-align:top"><h1>:</h1></th>
							  <th style="width:120px;vertical-align:top" colspan=5><h1>'.$data['ALAMAT_CONSIGNEE'].'</h1></th>
							</tr>
							<tr>
							  <th style="width:80px"><h1></h1></th>
							  <th style="width:10px"><h1></h1></th>
							  <th style="width:120px"><h1 style="color:white;">Jl. Raya Pelabuhan No.8 Tanjung Priok Jakarta 14310</h1></th>
							  <th style="width:50px"><h1></h1></th>
							  <th style="width:80px"><h1></h1></th>
							  <th style="width:10px"><h1></h1></th>
							  <th style="width:120px"><h1></h1></th>
							</tr>
						</table>
						<hr color="black" width="100%">
					</td>
				</tr>
			</table>
		</div>
	';
		
    //$arrRowDetail = count($datadtl);
	//echo $arrRowDetail;print_r($datadtl);
    /* sort($arrRowDetail);
	for ($p=0;$p<$arrRowDetail;$p++) {
		$check = "SELECT B.NO_CONT, func_name(B.KD_UK_CONT,'CONT_UKURAN') AS UKURAN_CONT, 
		func_name(C.KD_GUDANG_TUJUAN,'GUDANG') AS LOKASI, func_name(C.KD_GUDANG_ASAL,'GUDANG') as TERMINAL_ASAL 
		from t_billing_cfshdr A join t_billing_cfsdtl B on B.ID=A.ID JOIN t_order_hdr C ON C.NO_ORDER=A.NO_ORDER
		where A.NO_ORDER='".$data['NO_ORDER']."' AND B.NO_CONT='".$datadtl[$p]['NO_CONT']."' LIMIT 1";
		echo $check.'<br>'; */
		/* $checkss=$this->db->query($check);
		$resulte = $checkss->row_array();
		$tableheadercontainer .= '
			<table>
				<tr>
				  <th style="width:80px"><h1>Lokasi</h1></th>
				  <th style="width:10px"><h1>:</h1></th>
				  <th style="width:100px"><h1>'.$resulte['LOKASI'].'</h1></th>
				</tr>
				<tr>
				  <th style="width:80px"><h1>Terminal Asal</h1></th>
				  <th style="width:10px"><h1>:</h1></th>
				  <th style="width:100px"><h1>'.$resulte['TERMINAL_ASAL'].'</h1></th>
				</tr>
				<tr>
				  <th style="width:80px"><h1>No Container</h1></th>
				  <th style="width:10px"><h1>:</h1></th>
				  <th style="width:100px"><h1>'.$resulte['NO_CONT'].'</h1></th>
				</tr>
				<tr>
				  <th style="width:80px"><h1>Ukuran</h1></th>
				  <th style="width:10px"><h1>:</h1></th>
				  <th style="width:100px"><h1>'.$resulte['UKURAN_CONT'].'</h1></th>
				</tr>
				<tr><th colspan=7></th></tr>
			</table>'; */
		/* <table>
			<tr class="noBorder">
				<td>
					<table align="left">
						<tr class="black" width="660px">
						  <th style="width:10px;text-align:center;"><h1 style="color:white; font-weight:bold">No.</h1></th>
						  <th style="width:280px;text-align:center;"><h1 style="color:white; font-weight:bold">Item Tagihan</h1></th>
						  <th style="width:60px;text-align:center;"><h1 style="color:white; font-weight:bold">Qty</h1></th>						  
						  <th style="width:100px;text-align:center;"><h1 style="color:white; font-weight:bold">Satuan</h1></th>
						  <th style="width:100px;text-align:center;"><h1 style="color:white; font-weight:bold">Tarif (Rp)</h1></th>
						  <th style="width:100px;text-align:center;"><h1 style="color:white; font-weight:bold">Jumlah</h1></th>
						</tr>
						'.$tablecontainer.'
					</table>
				</td>
			</tr>
		</table>
		'; */
		/* $SQL = "select C.NO_ORDER,(case when (C.JENIS_BAYAR = 'C') THEN 'KREDIT' ELSE 'CASH' END) as JENIS_BAYAR,C.SUBTOTAL,C.ADMINISTRASI,C.PPN,C.TOTAL as TOTAL_BAYAR, 
		A.ID, A.NO_CONT, B.DESKRIPSI as 'NAMA ITEM', A.TARIF_DASAR as 'TARIF DASAR', A.QTY, A.TOTAL
		from t_billing_cfsdtl A join reff_billing_cfs B on A.KODE_BILL=B.KODE_BILL JOIN t_billing_cfshdr C ON C.ID=A.ID
		WHERE A.NO_CONT = '".$datadtl[$p]['NO_CONT']."' and C.NO_ORDER='".$data['NO_ORDER']."';
		$check1 = $this->db->query($SQL);
		$resulte1 = $check1->result_array();
		$no=1;$p=0;
		foreach ($resulte1 as $row) {
			$blackorno = ($p%2==0)?"":'class="grey"';
			$tablecontainer .= '
				<tr '.$blackorno.'>
				  <th><h1>'.$no.'</h1></th>
				  <th><h1>'.$row['DESKRIPSI'].'</h1></th>
				  <th><h1>'.$row['QTY'].'</h1></th>
				  <th><h1>'.$row['SATUAN'].'</h1></th>
				  <th><h1>'.$row['TARIF_DASAR'].'</h1></th>
				  <th><h1>'.$row['TOTAL'].'</h1></th>
				</tr>
			';
			$no++;$p++;
		} */
	//}
	$body = $tableheadercontainer.'
		<table>
			<tr class="noBorder">
				<td class="noBorders">
					<table align="right">
						<tr>
						  <th style="width:10px;text-align:left;"><h1>Sub Total</h1></th>
						  <th style="width:220px;text-align:right;"><h1>'.number_format($data['SUBTOTAL'], '0', ',', '.').'</h1></th>
						</tr>
						<tr>
						  <th style="width:10px;text-align:left;"><h1>PPn (10%)</h1></th>
						  <th style="width:220px;text-align:right;"><h1>'.$ppn.'</h1></th>
						</tr>
						<tr>
						  <th style="width:10px;text-align:left;"><h1>Total</h1></th>
						  <th style="width:220px;text-align:right;"><h1>'.number_format($data['TOTAL'], '0', ',', '.').'</h1></th>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	';
	$footer = '
		<table>
			<tr class="noBorder">
				<td class="noBorders">
					<table align="left">
						<tr>
						  <th style="width:50px;"><h1>Terbilang</h1></th>
						  <th style="width:3px;"><h1>:</h1></th>
						  <th style="width:220px;"><h1>'.terbilang($data['TOTAL']).' RUPIAH</h1></th>
						</tr>
					</table>
				</td>
			</tr>
		</table>
		<hr color="black" width="100%"><br><br>
		<table>
			<tr>
				<td class="noBorders"><table align="left"><tr><th style="width:10px;text-align:left;"><h1>KETENTUAN :</h1></th></tr></table></td>
				<td class="noBorders">
					<table align="right"><tr><th style="width:10px;text-align:left;"><h1>TANJUNG PRIOK, '.indonesian_date().'</tr></table>
				</td>
			</tr>
			<tr>
				<td>
					<table align="left" border=1>
						<tr>
						  <th style="width:10px;text-align:left;">
							<h2>Dalam waktu 5 hari setelah nota ini diterima, tidak ada pengajuan keberatan<br>saudara dianggap setuju.<br>Terhadap nota yang diajukan koreksi terlebih dahulu.<br>Pembayaran harus dilunasi dalam 5 hari kerja setelah nota ini diterima, jika <br>tidak, dikenakan denda 2% perbulan atau sanksi lainnya.<br>Tidak dibenarkan memberi imbalan kepada petugas.</h2>
						  </th>
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