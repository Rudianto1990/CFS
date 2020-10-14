<?php
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
$html .= getHTML($data, $datadtl);
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
                                border-collapse:collapse; 
                                border-spacing:0;	
                                width:100%;
                        }
						@page {		
								margin-top: 0.6px;
   								margin-bottom: 0px;
    							margin-right: 42px;
    							margin-left: 42px;
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
    background-color: #EDEDED;
    color: black;
}
</style>
				';
    return $html;
}

function getHTML($data, $datadtl) {
    $html = '<br><br>
             <br><br><br><br>
				<table>
				  <tbody>
					<tr>
					  <th width="35%">NOMOR BL</th>
					  <td width="65%">JK9910238'.$arrhdr['NO_BL'].'</td>
					</tr>
					<tr>
					  <th>NOMOR PROFORMA INVOICE</th>
					  <td>LKK2312312'.$arrhdr['WK_GATE_IN'].'</td>
					</tr>
					<tr>
					  <th>TANGGAL</th>
					  <td>14-9-2016'.$arrhdr['TGL_STATUS'].'</td>
					</tr>
				  </tbody>
				</table>
			  <br>
              <table>
                <tr><th style="text-align:center">DAFTAR TARIF LAYANAN CFS WAREHOUSE</th></tr>
				<tr>
				  <th>1. CFS</th>
				</tr>
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
				  <th>2. OPERATOR</th>
				</tr>
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
				  <th style="text-align:center">TOTAL : Rp 200.000,-</th>
				</tr>
  			  </table>
			  <br>
			  <div style="text-align:center"><h1><strong>TOTAL BIAYA LAYANAN : Rp 200.000,-</strong></h1></div>
			 '; 
			
    return $html;
	
	
}

?>