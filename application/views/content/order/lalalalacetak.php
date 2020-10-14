<?php

$z = $_SERVER['PHP_SELF'];
//print_r($z);die();
$k = explode('/',$z);
$key = $k[7];
$key = explode('~',$key);
$CAR = $key[0];
$ID = $key[1];
$SQL = "SELECT A.NO_ORDER,A.JENIS_BILLING,A.NAMA_FORWARDER,A.NPWP_FORWARDER,A.ALAMAT_FORWARDER,A.NO_DO,A.NO_BL_AWB,
A.TGL_TIBA,A.NM_ANGKUT,B.NAMA_GUDANG,C.NAMA_TPS
FROM t_order_hdr A JOIN reff_gudang B ON A.KD_GUDANG_TUJUAN = B.KD_GUDANG JOIN reff_tps C ON A.KD_TPS_ASAL = C.KD_TPS
WHERE A.NO_ORDER='".$CAR."' AND A.ID='".$ID."'";
$SQL2 = "SELECT B.NO_CONT, B.KD_CONT_UKURAN,B.ID, B.KD_CONT_JENIS
FROM t_order_hdr A LEFT JOIN t_order_cont B ON A.ID=B.ID
WHERE A.NO_ORDER='".$CAR."' AND A.ID='".$ID."'";
	$q = $this->db->query($SQL);
	$q2 = $this->db->query($SQL2);
        $header = $q->result_array();
        $container = $q2->result_array();
$andbilling = "";
$x = count($container)-1;
for($i=0;$i<=$x;$i++){
	if($i==0){$andbilling = " AND D.NO_ORDER='".$container[$i]['NO_ORDER']."'";}
	elseif($i==$x){$andbilling .= " OR D.NO_ORDER='".$container[$i]['NO_ORDER']."'";}
	else{$andbilling .= " OR D.NO_ORDER='".$container[$i]['NO_ORDER']."'";}
}
$SQL3 = "SELECT B.KODE_BILL,D.ID,C.DESKRIPSI,B.SATUAN,C.TARIF_DASAR,B.QTY*C.TARIF_DASAR AS TOTAL
FROM t_billing_cfshdr A
JOIN t_billing_cfsdtl B ON A.ID=B.ID
JOIN reff_billing_cfs C ON B.KODE_BILL=C.KODE_BILL
JOIN t_order_hdr D ON A.NO_ORDER = D.NO_ORDER
WHERE 1=1".$andbilling;
	$q3 = $this->db->query($SQL3);
        $billing = $q3->result_array();
$jeniskemas = substr($header[0]['NO_ORDER'],0,3);
if($jeniskemas=='KMS'){
	$header[0]['NO_ORDER']="LCL KEMASAN";
}elseif($jeniskemas=='CON'){
	$header[0]['NO_ORDER'] = "LCL PETIKEMAS";
}
//ini_set('max_execution_time', 0);
//ini_set("memory_limit", "-1");
ini_set('memory_limit','256M');
//ini_set('max_execution_time', 0);
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
	
  
$mpdf = new mPDF('utf-8','A4');


//$mpdf =new mPDF('utf-8', 'A4-L');

$html = getStyle();
$html .= '<body><div class="body">';
//$html .= getHTML($data, $datadtl);
$html .= getHTML($header, $container,$billing);
$html .= '</div></body>';
//$mpdf=new mPDF('','A4');
//$html .= mb_convert_encoding($html, 'UTF-8', 'UTF-8');
$mpdf->WriteHTML($html);

//$mpdf->allow_charset_conversion=true;
//$mpdf->charset_in='UTF-8';

$mpdf->Output();
exit;
function getStyle() {
    $html = '<style type="text/css" text-align= "center">
						body{
                               font:12px Arial;
							   font-weight: normal; 
                        }			   
                        div.body{
                                padding:20px;	
                                padding-top:5px;
								
                        }
                        table{
                                border-collapse:separate; 
                                border-spacing:0;	
                                width:100%;
                        }
						
						@page {		
								margin-top: 0.6px;
   								margin-bottom: 0px;
    							margin-right: 42px;
    							margin-left: 42px;
						}
						h1 {
								font-size: 8px;
								font-weight:normal;
						}
						h2 {
								font-size: 6px;
								font-weight:normal;
						}
                </style>
<style>
table {
    width:100%;
}
table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
}
th, td {
    padding: 5px;
    text-align: left;
}
table th {
}

table tr {
}
table, tr, td {
  border: 3px;
}
tr.noBorder td {
  border: 0;
  
}
td.noBorders th{
  border: 0;
}

table th {
}
th.black{
    background-color: #EDEDED;
    color: white;
}
table tr {
}
tr.black{
    background-color: #A9A9A9;
    color: white;
}

table tr {
}
tr.grey{
    background-color: #E8E8E8;
    color: white;
}

</style>
				';
    return $html;
}

function getHTML($header, $container,$billing) {
	$header = '
	<div style="text-align:center;">
							<h3 class="box-title">
								IPC CFS CENTER CABANG TANJUNG PRIOK
							</h3>
						</div>
	<br/>
	<br/>
	<div style="text-align:left;">
	<table>
	<tr >
	<td >
		<table>
						<tr>
						  <th style="width:80px">
							<h1>ALAMAT</h1>
						  </th>
						  <th style="width:10px">
							<h1>:</h1>
						  </th>
						  <th style="width:120px">
							<h1>Jl. Raya Pelabuhan No.8 Tanjung Priok Jakarta 14310</h1>
						  </th>
						  <th style="width:50px">
							<h1></h1>
						  </th>
						  <th style="width:80px">
							<h1></h1>
						  </th>
						  <th style="width:10px">
							<h1></h1>
						  </th>
						  <th style="width:120px">
							<h1></h1>
						  </th>
						</tr>
						
						<tr>
						  <th style="width:80px">
							<h1>NPWP</h1>
						  </th>
						  <th style="width:10px">
							<h1>:</h1>
						  </th>
						  <th style="width:120px">
							<h1>02.432443.xxx.xx.xxx</h1>
						  </th>
						  <th style="width:50px">
							<h1></h1>
						  </th>
						  <th colspan="3" style="width:210px">
							<h1>Berdasarkan Peraturan Dirjen Pajak</h1>
						  </th>
						</tr>
						
						<tr>
						  <th style="width:80px">
							<h1>P.PKP No</h1>
						  </th>
						  <th style="width:10px">
							<h1>:</h1>
						  </th>
						  <th style="width:120px">
							<h1>02.432443.xxx.xx.xxx</h1>
						  </th>
						  <th style="width:50px">
							<h1></h1>
						  </th>
						  <th style="width:80px">
							<h1>No.</h1>
						  </th>
						  <th style="width:10px">
							<h1>:</h1>
						  </th>
						  <th style="width:120px">
							<h1>PER-33/PJ/2014</h1>
						  </th>
						</tr>
						
						<tr>
						  <th style="width:80px">
							<h1></h1>
						  </th>
						  <th style="width:10px">
							<h1></h1>
						  </th>
						  <th style="width:120px">
							<h1></h1>
						  </th>
						  <th style="width:50px">
							<h1></h1>
						  </th>
						  <th style="width:80px">
							<h1>Tanggal</h1>
						  </th>
						  <th style="width:10px">
							<h1>:</h1>
						  </th>
						  <th style="width:120px">
							<h1>30 Desember 2014</h1>
						  </th>
						</tr>
		</table>
		
	<hr color="black" width="100%">
		<table>
			<tr class="black">
			<td><h1>PROFORMA INVOICE PELAYANAN JASA : LCL CARGO'
			//$header[0]['JENIS_BILLING']
			.'</h1></td>
			</tr>

		</table>
		
		<table>
						<tr>
						  <th style="width:80px">
							<h1></h1>
						  </th>
						  <th style="width:10px">
							<h1></h1>
						  </th>
						  <th style="width:100px">
							<h1></h1>
						  </th>
						  <th style="width:150px">
							<h1></h1>
						  </th>
						  <th style="width:140px">
							<h1></h1>
						  </th>
						  <th style="width:10px">
							<h1></h1>
						  </th>
						  <th style="width:100px">
							<h1></h1>
						  </th>
						</tr>
						
						<tr>
						  <th style="width:80px">
							<h1>Kepada</h1>
						  </th>
						  <th style="width:10px">
							<h1>:</h1>
						  </th>
						  <th style="width:100px">
							<h1>'.$header[0]['NAMA_FORWARDER'].'</h1>
						  </th>
						  <th style="width:150px">
							<h1></h1>
						  </th>
						  <th style="width:140px">
							<h1>No.DO</h1>
						  </th>
						  <th style="width:10px">
							<h1>:</h1>
						  </th>
						  <th style="width:100px">
							<h1>'.$header[0]['NO_DO'].'</h1>
						  </th>
						</tr>
						
						<tr>
						  <th style="width:80px">
							<h1>NPWP</h1>
						  </th>
						  <th style="width:10px">
							<h1>:</h1>
						  </th>
						  <th style="width:100px">
							<h1>'.$header[0]['NPWP_FORWARDER'].'</h1>
						  </th>
						  <th style="width:150px">
							<h1></h1>
						  </th>
						  <th style="width:140px">
							<h1>No.BL</h1>
						  </th>
						  <th style="width:10px">
							<h1>:</h1>
						  </th>
						  <th style="width:100px">
							<h1>'.$header[0]['NO_BL_AWB'].'</h1>
						  </th>
						</tr>
						
						<tr>
						  <th style="width:80px">
							<h1>Alamat</h1>
						  </th>
						  <th style="width:10px">
							<h1>:</h1>
						  </th>
						  <th style="width:100px">
							<h1>'.$header[0]['ALAMAT_FORWARDER'].'</h1>
						  </th>
						  <th style="width:150px">
							<h1></h1>
						  </th>
						  <th style="width:140px">
							<h1>Tanggal Tiba</h1>
						  </th>
						  <th style="width:10px">
							<h1>:</h1>
						  </th>
						  <th style="width:100px">
							<h1>'.$header[0]['TGL_TIBA'].'</h1>
						  </th>
						</tr>

						<tr>
						  <th style="width:80px">
							<h1></h1>
						  </th>
						  <th style="width:10px">
							<h1></h1>
						  </th>
						  <th style="width:100px">
							<h1></h1>
						  </th>
						  <th style="width:150px">
							<h1></h1>
						  </th>
						  <th style="width:140px">
							<h1>Nama Angkut</h1>
						  </th>
						  <th style="width:10px">
							<h1>:</h1>
						  </th>
						  <th style="width:100px">
							<h1>'.$header[0]['NM_ANGKUT'].'</h1>
						  </th>
						</tr>
						
						
						<tr>
						  <th style="width:80px">
							<h1></h1>
						  </th>
						  <th style="width:10px">
							<h1></h1>
						  </th>
						  <th style="width:100px">
							<h1></h1>
						  </th>
						  <th style="width:150px">
							<h1></h1>
						  </th>
						  <th style="width:140px">
							<h1>No Container</h1>
						  </th>
						  <th style="width:10px">
							<h1>:</h1>
						  </th>
						  <th style="width:100px">
							<h1>'.$header[0]['NM_ANGKUT'].'</h1>
						  </th>
						</tr>
		</table>
					
	<hr color="black" width="100%">
		<table>
						<tr>
						  <th style="width:80px">
							<h1>Lokasi</h1>
						  </th>
						  <th style="width:10px">
							<h1>:</h1>
						  </th>
						  <th style="width:100px">
							<h1>'.$header[0]['NAMA_GUDANG'].'</h1>
						  </th>
						</tr>
						<tr>
						  <th style="width:80px">
							<h1>Weight/Measure</h1>
						  </th>
						  <th style="width:10px">
							<h1>:</h1>
						  </th>
						  <th style="width:100px">
							<h1>'.$header[0]['NAMA_TPS'].'</h1>
						  </th>
						</tr>
						
						<tr>
						  <th style="width:80px">
							<h1></h1>
						  </th>
						  <th style="width:10px">
							<h1></h1>
						  </th>
						  <th style="width:100px">
							<h1></h1>
						  </th>
						  <th style="width:150px">
							<h1></h1>
						  </th>
						  <th style="width:140px">
							<h1></h1>
						  </th>
						  <th style="width:10px">
							<h1></h1>
						  </th>
						  <th style="width:100px">
							<h1></h1>
						  </th>
						</tr>
		</table>
	</td>
	</tr>

	</table>

	</div>';
	$b = count($container)-1;
	$alreadycont = "";
	$no=0;
	$totalall=0;
	for($p=0;$p<=$b;$p++){
		$blackorno = "";
		if($p%2==0){
			$blackorno='';
			}else{
				$blackorno='class="grey"';
			}
		$tablecontainer .= '
						<tr '.$blackorno.'>
						  <th style="width:10px">
							<h1>'.$p.'</h1>
						  </th>
						  <th style="width:220px;">
							<h1>'.$container[$p]['NO_CONT'].'</h1>
						  </th>
						  
						  <th style="width:30px;text-align:center;">
							<h1>'.$container[$p]['KD_CONT_UKURAN'].'</h1>
						  </th>
						  <th style="width:80px;text-align:center;">
							<h1>'.$container[$p]['KD_CONT_JENIS'].'</h1>
						  </th>
						</tr>
		';
		$l = count($billing)-1;
		$title = "";
		for($m=0;$m<=$l;$m++){
			if($container[$p]['ID']==$billing[$m]['ID']){
			$no=$no+1;
				if($m%2==0){
					$billblackorno='';
				}else{
					$billblackorno='class="grey"';
				}	
				$tableisibilling .= '
						<tr '.$billblackorno.'>
						  <th style="width:10px;text-align:center;">
							<h1>'.$no.'</h1>
						  </th>
						  <th style="width:220px;text-align:center;">
							<h1>'.$billing[$m]['DESKRIPSI'].'</h1>
						  </th>
						  
						  <th style="width:120px;text-align:center;">
							<h1>'.$billing[$m]['TARIF_DASAR'].'</h1>
						  </th>
						  <th style="width:120px;text-align:center;">
							<h1>'.$billing[$m]['TOTAL'].'</h1>
						  </th>
						</tr>';
				$subtotalbilling = $subtotalbilling+$billing[$m]['TOTAL'];
			}
		}
		$ppnbilling = $subtotalbilling*10/100;
		$totalbilling = $subtotalbilling+$ppnbilling;
	if($title<>$container[$p]['ID']){
					$totalall = $totalall + $totalbilling;
					$tablebilling2 = '
							<br>
				<table>
				<tr class="noBorder">
				<td class="noBorders">
					<table align="right">
									<tr>
									  <th style="width:10px;text-align:center;">
										<h1>Sub Total</h1>
									  </th>
									  <th style="width:220px;text-align:center;">
										<h1>'.$subtotalbilling.'</h1>
									  </th>
									  
									</tr>
									<tr>
									  <th style="width:10px;text-align:center;">
										<h1>Ppn(10%)</h1>
									  </th>
									  <th style="width:220px;text-align:center;">
										<h1>'.$ppnbilling.'</h1>
									  </th>
									</tr>
									<tr>
									  <th style="width:10px;text-align:center;">
										<h1>Ppn(10%)</h1>
									  </th>
									  <th style="width:220px;text-align:center;">
										<h1>'.$totalbilling.'</h1>
									  </th>
									</tr>
					</table>
				</td>
				</tr>
				</table>';

				$tablebilling .= '
				<div style="text-align:left;">
					<h1><b>DATA BILLING CONTAINER '.$container[$p]['ID'].'</b><h1>
				</div>
				<br>
					<table>
						<tr class="noBorder">
							<td>
								<table align="left">
									<tr class="black">
										<th style="width:10px;text-align:center;">
											<h1>No.</h1>
										</th>
										<th style="width:220px;text-align:center;">
											<h1>Item Tagihan</h1>
										</th>
									  
									  <th style="width:120px;text-align:center;">
										<h1>Tarif</h1>
									  </th>
									  <th style="width:120px;text-align:center;">
										<h1>Jumlah</h1>
									  </th>
									</tr>
									'.$tableisibilling.'
					</table>
				</td>
				</tr>
				</table>'.$tablebilling2;
			$title = $billing[$m]['ID'];
				}
				$tableisibilling = "";
				$no=0;
	}
	$body = '
	<div style="text-align:left;">
				<h1><b>DATA CONTAINER</b><h1>
	</div>
				<br>
	<table>
	<tr class="noBorder">
	<td>
		<table align="left">
						<tr class="black">
						  <th style="width:10px;text-align:center;">
							<h1>No.</h1>
						  </th>
						  <th style="width:220px;text-align:center;">
							<h1>Item Tagihan</h1>
						  </th>
						  <th style="width:30px;text-align:center;">
							<h1>Qty</h1>
						  </th>						  
						  <th style="width:30px;text-align:center;">
							<h1>Satuan</h1>
						  </th>
						  <th style="width:80px;text-align:center;">
							<h1>Tarif (Rp)</h1>
						  </th>
						  <th style="width:80px;text-align:center;">
							<h1>Jumlah</h1>
						  </th>
						</tr>
						'.$tablecontainer.'
		</table>
	</td>
	</tr>
	</table>
	<br>'.$tablebilling.'
				 '; 
	$body2 = 	'<table>
				<tr class="noBorder">
				<td class="noBorders">
					<table align="right">
									
									<tr>
									  <th style="width:10px;text-align:left;">
										<h1>Sub Total</h1>
									  </th>
									  <th style="width:220px;text-align:right;">
										<h1>'.$totalall.'</h1>
									  </th>
									</tr>
									<tr>
									  <th style="width:10px;text-align:left;">
										<h1>PPn (10%)</h1>
									  </th>
									  <th style="width:220px;text-align:right;">
										<h1>'.$totalall.'</h1>
									  </th>
									</tr>
									<tr>
									  <th style="width:10px;text-align:left;">
										<h1>Total</h1>
									  </th>
									  <th style="width:220px;text-align:right;">
										<h1>'.$totalall.'</h1>
									  </th>
									</tr>
					</table>
				</td>
				</tr>
				</table>';
	$terbilang = terbilang($totalall);
	$footer = '		<table>
				<tr class="noBorder">
				<td class="noBorders">
					<table align="left">
									
									<tr>
									  <th style="width:50px;">
										<h1>Terbilang</h1>
									  </th>
									  <th style="width:3px;">
										<h1>:</h1>
									  </th>
									  <th style="width:220px;">
										<h1>'.$terbilang.'</h1>
									  </th>
									</tr>
					</table>
				</td>
				</tr>
				</table>
					<hr color="black" width="100%">
				<br>
				<br>
				<table>
				<tr>
				<td class="noBorders">
					<table align="left">
									
									<tr>
									  <th style="width:10px;text-align:left;">
										<h1>
										KETENTUAN :
										</h1>
									  </th>
									</tr>
					</table>
				</td>
				
				<td class="noBorders">
				
				<table align="right">
									
									<tr>
									  <th style="width:10px;text-align:left;">
										<h1>
										TANJUNG PRIOK, '.date("l, d F Y").'
									</tr>
					</table>
				</td>
				</tr>
				<tr>
				<td>
					<table align="left">
									
									<tr>
									  <th style="width:10px;text-align:left;">
										<h2>
										Dalam waktu 8 hari setelah nota ini diterima,tidak ada pengajuan keberatan
										<br>
										saudara dianggap setuju.
										<br>
										Terhadap nota yang diajukan koreksi terlebih dahulu.
										<br>
										Pembayaran harus dilunasi dalam 8 hari kerja setelah nota ini diterima,jika
										<br>
										tidak,dikenakan denda 2% perbulan atau sanksi lainnya.
										<br>
										Tidak dibenarkan memberi imbalan kepada petugas.
										</h2>
									  </th>
									</tr>
					</table>
				</td>
				</tr>
				</table>';
	$html = '<header>'.$header.'</header>'.
			'<body>'.$body.$body2.'<body>'.
			'<footer>'.$footer.'</footer>';
	
    $htmls = '<br><br>
             <br><br><br><br>
				<table>
				  <tbody>
					<tr>
					  <th width="35%">NOMOR BL</th>
					  <td width="65%">JK9910238</td>
					</tr>
					<tr>
					  <th>NOMOR PROFORMA INVOICE</th>
					  <td>LKK2312312</td>
					</tr>
					<tr>
					  <th>TANGGAL</th>
					  <th>14-9-2016</th>
					</tr>
				  </tbody>
				</table>
			  <br>
              <table>
                <tr><th style="text-align:center">BILLING LAYANAN TERMINAL PLP</th></tr>
				<tr>
				  <td>
					<table>
						<tr>
						  <th style="width:40px">NO</th>
						  <th style="width:460px">NAMA ITEM</th>
						  <th style="width:160px">TARIF</th>
						</tr>
						<tr>
						  <td>1</td><td>TES BARANG</td><td style="text-align:right">Rp 100.000,-</td>
						</tr>
						<tr>
						  <th colspan="2" style="text-align:right">SUB TOTAL :</th>
						  <th style="text-align:right">Rp 100.000,-</th>
						</tr>
					</table>
				  </td>
				</tr>
				<tr>
				  <th style="text-align:center">TOTAL : Rp 100.000,-</th>
				</tr>
              </table>
			  <br>
			  <div style="text-align:center"><h1><strong>TOTAL BIAYA LAYANAN : Rp 100.000,-</strong></h1></div>
			 '; 
			
    return $html;
	
	
}
function Terbilang($x)
{
  $abil = array("", "SATU", "DUA", "TIGA", "EMPAT", "LIMA", "ENAM", "TUJUH", "DELAPAN", "SEMBILAN", "SEPULUH", "SEBELAS");
  if ($x < 12)
    return " " . $abil[$x];
  elseif ($x < 20)
    return Terbilang($x - 10) . "BELAS RUPIAH";
  elseif ($x < 100)
    return Terbilang($x / 10) . " PULUH RUPIAH" . Terbilang($x % 10);
  elseif ($x < 200)
    return " seratus" . Terbilang($x - 100);
  elseif ($x < 1000)
    return Terbilang($x / 100) . " RATUS RUPIAH" . Terbilang($x % 100);
  elseif ($x < 2000)
    return " seribu" . Terbilang($x - 1000);
  elseif ($x < 1000000)
    return Terbilang($x / 1000) . " RIBU RUPIAH" . Terbilang($x % 1000);
  elseif ($x < 1000000000)
    return Terbilang($x / 1000000) . " JUTA RUPIAH" . Terbilang($x % 1000000);
}

?>