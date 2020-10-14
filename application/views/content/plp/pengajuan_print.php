<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

$mpdf = new mPDF('utf-8', array(190,236));

$html = getStyle();
$html .= '<body><div class="body">';
$html .= getHTML($data);
$html .= '</div></body>';
 
$mpdf->WriteHTML($html);
//$mpdf->SetVisibility('screenonly');
$mpdf->Output();
exit;

function getStyle() {
    $html = '<style type="text/css">
                        body{
                                font:11px Tahoma;
								display:none;
                        }
                        div.body{
                                padding:0px;	
                                padding-top:5px;
                        }
                        table{
                                border-collapse:collapse; 
                                border-spacing:0;	
                                width:100%;
                        }
                </style>';
    return $html;
}

function getHTML($data){
  	$arrRowDetail = count($data);
    sort($arrRowDetail);
    $counter = 1;
    $total_amount = array();
    for ($c = 0; $c < $arrRowDetail; $c++) {
		$status = ($data[$c]['KD_STATUS']=="Y")?"Disetujui":"Ditolak";
        $addHtmlDetail .= '<tr>
								<td align="center">'.$counter.'</td>
                                <td align="center">'.$data[$c]['NO_CONT'].'</td>
                                <td align="center">'.$data[$c]['KD_CONT_UKURAN'].'</td>
                                <td align="center">'.$arrRowDetail.'</td>
								<td align="center">'.$status.'</td>
                           </tr>';
        $counter++;
    }
    $html = '<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="20%" style="vertical-align:top;">Nomor</td>
					<td width="1%" style="vertical-align:top;">:</td>
					<td width="60%" style="vertical-align:top;">'.$data[0]['NO_SURAT'].'</td>
					<td width="5%" style="vertical-align:top;">'.name_date($data[0]['TGL_SURAT']).'</td>
				</tr>
				<tr>
					<td style="vertical-align:top;">Lampiran</td>
					<td style="vertical-align:top;">:</td>
					<td style="vertical-align:top;">-</td>
					<td style="vertical-align:top;">&nbsp;</td>
				</tr>
				<tr>
					<td style="vertical-align:top;">Hal</td>
					<td style="vertical-align:top;">:</td>
					<td style="vertical-align:top;">Permohonan Pindah Lokasi Penimbunan</td>
					<td style="vertical-align:top;">&nbsp;</td>
				</tr>
             </table><br>
			 <table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="100%" style="vertical-align:top;">
						<b>Yth. Kepala KPU Bea dan Cukai Tipe A Tanjung Priok</b>
					</td>
				</tr>
				<tr>
					<td width="100%" style="vertical-align:top;">
						U.p. Kepala seksi Administrasi Manifes
					</td>
				</tr>
             </table><br>
			 <table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="100%" style="vertical-align:top;" colspan="6">
						Dengan ini kami mengajukan permohonan Pindah Lokasi Penimbunan barang impor yang belum diselesaikan kewajiban pabeannya (PLP) sebagai berikut :
					</td>
				</tr>
				<tr>
					<td width="15%" style="vertical-align:top;">BC 1.1 Nomor</td>
					<td width="1%" style="vertical-align:top;">:</td>
					<td width="55%" style="vertical-align:top;">'.$data[0]['NO_BC11'].'</td>
					<td width="10%" style="vertical-align:top;">Tanggal</td>
					<td width="1%" style="vertical-align:top;">:</td>
					<td width="15%" style="vertical-align:top;" align="right">'.name_date($data[0]['TGL_BC11']).'</td>
				</tr>
             </table><br>
             <table border="1" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<th width="5%" style="border:0px solid black" rowspan="2">No.</th>
					<th width="50%" style="border:0px solid black" colspan="3">Petikemas</th>
					<th width="45%" style="border:0px solid black" rowspan="2">Keputusan Pejabat Bea Cukai</th>
				</tr>
				<tr>
					<th style="border:0px solid black">Nomor</th>
					<th style="border:0px solid black">Ukuran</th>
					<th style="border:0px solid black">Jumlah</th>
				</tr>
                    ' . $addHtmlDetail . '
             </table><br>
             <table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="15%">Nama Kapal</td>
					<td width="1%">:</td>
					<td>'.$data[0]['NM_KAPAL'].'</td>
				</tr>
				<tr>
					<td width="15%">No. Voyage</td>
					<td width="1%">:</td>
					<td>'.$data[0]['NO_VOY_FLIGHT'].'</td>
				</tr>
				<tr>
					<td width="15%">TPS ASAL</td>
					<td width="1%">:</td>
					<td>'.$data[0]['TPS_ASAL']." Kode TPS : ".$data[0]['KD_TPS_ASAL']." SOR/YOR : ".$data[0]['YOR_ASAL'].'%</td>
				</tr>
				<tr>
					<td width="15%">TPS Tujuan</td>
					<td width="1%">:</td>
					<td>'.$data[0]['TPS_TUJUAN']." Kode TPS : ".$data[0]['KD_TPS_TUJUAN']." SOR/YOR : ".$data[0]['YOR_TUJUAN'].'%</td>
				</tr>
				<tr>
					<td width="15%" valign="top">Alasan</td>
					<td width="1%" valign="top">:</td>
					<td valign="top">'.$data[0]['ALASAN_PLP'].'</td>
				</tr>
             </table><br>
			 <div style="text-align:justify;">Demikian kami sampaikan untuk dapat dipertimbangkan.</div>
			 <div style="text-align:justify;">Keputusan Pejabat Bea Cukai :</div>
			 <table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="15%">Nomor</td>
					<td width="1%">:</td>
					<td>'.$data[0]['NO_PLP'].'</td>
				</tr>
				<tr>
					<td width="15%">Tanggal</td>
					<td width="1%">:</td>
					<td>'.name_date($data[0]['TGL_PLP']).'</td>
				</tr>
             </table>
			 <table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="1%">A.n</td>
					<td width="25%">Kepala Kantor</td>
					<td width="45%">&nbsp;</td>
					<td width="20%">Pemohon</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>
						Kepala Seksi Administrasi Manifes
						<br><br><br><br><br>
						............................
					</td>
					<td>&nbsp;</td>
					<td>
						<br><br><br><br><br>
						............................
					</td>
				</tr>
             </table><br>
			 <table border="0" width="100%" cellpadding="0" cellspacing="0">
			 	<tr>
					<td colspan="3">Pengeluaran dari TPS Asal</td>
					<td colspan="3">Pemasukan ke TPS Tujuan</td>
				</tr>
			 	<tr>
					<td width="15%">Tanggal</td>
					<td width="1%">:</td>
					<td width="48%">..................................</td>
					<td width="15%">Tanggal</td>
					<td width="1%">:</td>
					<td width="20%">..................................</td>
				</tr>
				<tr>
					<td>Pukul</td>
					<td>:</td>
					<td>..................................</td>
					<td>Pukul</td>
					<td>:</td>
					<td>..................................</td>
				</tr>
             </table><br>
			 <table border="0" width="100%" cellpadding="0" cellspacing="0">
			 	<tr>
					<td colspan="3">Pejabat Bea dan Cukai</td>
					<td colspan="3">Pejabat Bea dan Cukai</td>
				</tr>
				<tr>
					<td width="15%">Nama</td>
					<td width="1%">:</td>
					<td width="48%">..................................</td>
					<td width="15%">Nama</td>
					<td width="1%">:</td>
					<td width="20%">..................................</td>
				</tr>
				<tr>
					<td>NIP</td>
					<td>:</td>
					<td>..................................</td>
					<td>NIP</td>
					<td>:</td>
					<td>..................................</td>
				</tr>
				<tr>
					<td>Tanda Tangan</td>
					<td>:</td>
					<td>..................................</td>
					<td>Tanda Tangan</td>
					<td>:</td>
					<td>..................................</td>
				</tr>
             </table><br><br>
			 <div style="text-align:justify;font-size:8px"><b>Keterangan :</b></div>
			 <ul style="text-align:justify;font-size:8px">
			 	<li><b>Formulir ini dicetak secara otomatis oleh sistem komputer dan tidak memerlukan nama, cap dinas, tanda tangan pemohon dan pejabat.</b></li>
				<li><b>Daftar petikemas / kemasan yang dicetak hanya yang diberikan persetujuan PLP.</b></li>
			 </ul>
			 ';
    return $html;
}

?>