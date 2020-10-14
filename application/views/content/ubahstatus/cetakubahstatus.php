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
						
					
						
                </style>';
				
				
    return $html;
}





function getHTML($data) {
	//$tgl = date_create($data["TGL_BC11"]);
	//$TGL_BC11 = date_format($tgl, "d M Y");
	$namapemohon = $data['NAMA_PEMOHON']; //print_r($namapemohon);die();
	
    //print_r($data);die();
	
	
	

    $html = '<br><br>
             
             <br><br><br><br>
            
		
			  <table border="0">
                                    <tr>
                                        <td style="vertical-align:top;">Nomor  </td>
                                        <td style="vertical-align:top;">: </td>
                                        <td style="vertical-align:top;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$data['NO_SURAT'].'</td>
                                    </tr>
                                    <tr>
                                        <td style="vertical-align:top;">Lampiran  </td>
                                        <td style="vertical-align:top;">: </td>
                                        <td style="vertical-align:top;">Surat Pernyataan,Fotocopy Mawb, Hawb, Invoice, Cargo Manifes, Do							
</td>
                                    </tr>
                                    <tr>
                                        <td style="vertical-align:top;">Hal  </td>
                                        <td style="vertical-align:top;">: </td>
                                        <td style="vertical-align:top;">Permohonan Pindah Lokasi Penimbunan					
</td>
                                    </tr>
                                 
						
                                    <tr>
                                        <td colspan="3" style="vertical-align:top;"></td>
                                    </tr>
                                </table>
								
								 <table border="0">
                              		<tr>
										<td></td>
										<td></td>
										<td> </td>
									</tr>
									<tr>
										<td></td>
										<td></td>
										<td> </td>
									</tr>
									<tr>
										<td> Yth. Kepala KPU Bea dan Cukai Tipe C Soekarno-Hatta</td>
										<td> </td>
										<td> </td>
									</tr>
									<tr>
										<td> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; u.p. Kepala Bidang Pelayanan dan Fasilitas Pabean dan Cukai II</td>
										<td> </td>
										<td> </td>
									</tr>
									<tr>
										<td></td>
										<td></td>
										<td> </td>
									</tr>
									<tr>
										<td></td>
										<td></td>
										<td> </td>
									</tr>
									<tr>
										<td></td>
										<td></td>
										<td> </td>
									</tr>
									<tr>
										<td>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Dengan ini kami mengajukan permohonan Pindah Lokasi Penimbunan barang import yang belum</td>
										<td></td>
										<td> </td>
									</tr>
                                   	<tr>
										<td>diselesaikan kewajiban pabeannya (PLP) sebagai berikut:       </td>
										<td></td>
										<td> </td>
									</tr>
									<tr>
										<td></td>
										<td></td>
										<td> </td>
									</tr>
                                </table>
								
								<table>
									<tr>
										<td></td>
										<td></td>
										<td> </td>
									</tr>
									<tr>
										<td>BC 1.1 Nomor  :  '.$data['NO_BC11'].' </td>
										<td>&nbsp; &nbsp; &nbsp; Pos  :  '.$data['NO_POS_BC11'].'</td>
										<td>&nbsp; &nbsp; &nbsp; Tanggal  : '.FormatDate($data['TGL_BC11']).' </td>
									</tr>
									<tr>
										<td></td>
										<td></td>
										<td> </td>
									</tr>
								
								</table>
             <table border="1" width="100%" cellpadding="0" cellspacing="0">
                    <tr>
							<td align = "center" rowspan = "2" width="5%">No. Urut</th>
                            <td align = "center" colspan = "2" width="20%">Kemasan</th>
							
							<td align = "center" colspan = "2" width="20%">Dokumen AWB / BL</th>
                            <td align = "center" rowspan = "2" width="20%">Keputusan Pejabat BC</th>
                           
                    </tr>
				
					<tr>
							<td align = "center">Jenis</td>
							<td align = "center">Jumlah</td>
							<td align = "center">Nomor</td>
							<td align = "center">Tanggal</td>
						
					
					</tr>
                    ' . $addHtmlDetail . '
             </table>
        	 <br>
		  <table border="0" width="100%" cellpadding="0" cellspacing="0">
					
                    <tr>
                            <td width="40%" style="vertical-align:top;">
                                <table border="0">
                                   
									<tr>
                                        <td style="vertical-align:top;">Tps Asal </td>
                                        <td style="vertical-align:top;">: </td>
                                        <td style="vertical-align:top;"> &nbsp;'.$data['TPS_ASAL'].'</td>
                                    </tr>
                                    <tr>
                                        <td style="vertical-align:top;">Tps Tujuan </td>
                                        <td style="vertical-align:top;">: </td>
                                        <td style="vertical-align:top;"> &nbsp;'.$data['TPS_TUJUAN'].'</td>
                                    </tr>
									
                                  
                                 
                                  
                                </table>
								
								
								
								
                            </td>
                            <td width="30%" style="vertical-align:top;">
                                <table border="0">
                                    <tr>
										<td style="vertical-align:top;">Kode Tps</td>
                                        <td style="vertical-align:top;">: </td>
                                        <td style="vertical-align:top;">'. $data['GUDANG_ASAL'] . '</td>
                                    </tr>
                                    <tr>

                                        <td style="vertical-align:top;">Kode Tps </td>
                                        <td style="vertical-align:top;">: </td>
                                        <td style="vertical-align:top;">'.$data['GUDANG_TUJUAN'].'</td>
                                    </tr>
                                   
                                   
                                    
                                </table>
                            </td>
							<td width="30%" style="vertical-align:top;">
                                <table border="0">
                                    <tr>
										 <td style="vertical-align:top;">YOR/SOR : -%</td>
                                    </tr>
                                    <tr>
                                        <td style="vertical-align:top;">YOR/SOR : -%</td>
                                     
                                    </tr>
                                 
                                    
                                </table>
                            </td>
							   

                    </tr>	
             </table>
			   <table border="0">
                                   
									<tr>
                                        <td style="vertical-align:top;" >Alasan &nbsp; </td>
                                        <td style="vertical-align:top;">&nbsp;&nbsp;&nbsp;&nbsp;: </td>
										
                                        <td style="vertical-align:top;">'.$data['ALASAN_PLP'].'</td>
                                    </tr>
                                  
                                 
                                  
               </table>
			   
			 
			 <table border="0">
                      <tr>
                          
						  <td> </td>
                                      
                      </tr>
					  <tr>
                          
						  <td> </td>
                                      
                      </tr>
					  <tr>
                          
						  <td style="vertical-align:top;">Demikian kami sampaikan untuk dapat dipertimbangkan </td>
                                      
                      </tr>
                                 
             </table>
			 
             <br>			 
             <table border="0" width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                            <td>
                                    <div></div>
                                    <div></div>
                                    <br><br><br><br>

                            </td>
							
                            <td  style="text-align: center;" width="35%">
									 <br>
    
									 Pemohon,

                            </td>
							
                    </tr>
                    <br><br><br><br><br>
                    <tr>
                            <td></td>
                            <td style="text-align: center;" width="35%">
                                    <div ><u>(........................................)</u></div>
                                    <div></div>
                            </td>
                    </tr>

             </table>
			 
			 	<br>
			 
			   <table border="0">
                                    <tr>
                                        <td style="vertical-align:top;">Keputusan Pejabat Bea dan Cukai :  </td>
                                    
                                    </tr>
                                    
                               
                </table>
<br>
		
				 <table border="0" width = "36%">
				  					<tr>
                                        <td style="vertical-align:top;">Nomor  </td>
                                        <td style="vertical-align:top;">: </td>
                                        <td style="vertical-align:top;">....................../PLP/2016</td>
                                    </tr>
                                    <tr>
                                        <td style="vertical-align:top;">Tanggal  </td>
                                        <td style="vertical-align:top;">: </td>
                                        <td style="vertical-align:top;">......................'.FormatDate2($data['TGL_SURAT']).'</td>
                                    </tr>
				  
			 </table>
				 <br> 
				 <table border="0">
                              		
									<tr>
										<td> a.n Kepala Kantor,</td>
										<td> </td>
										<td> </td>
									</tr>
									<tr>
										<td> &nbsp; &nbsp; Kepala Bidang PFPC II</td>
										<td> </td>
										<td> </td>
									</tr>
									<tr>
										<td> &nbsp; &nbsp; u.b.</td>
										<td></td>
										<td> </td>
									</tr>
									<tr>
										<td> &nbsp; &nbsp;  '.$JABATAN_KEPALASEKSI.'</td>
										<td></td>
										<td> </td>
									</tr>
									
                  </table>
				  <br><br>
				   <table border="0">
                              		
									<tr>
										<td>&nbsp; &nbsp; </td>
										<td> </td>
										<td> </td>
									</tr>
									<tr>
										<td> &nbsp; &nbsp;  '.$NAMA_KEPALASEKSI.'</td>
										<td> </td>
										<td> </td>
									</tr>
									<tr>
										<td> &nbsp; &nbsp;  '.$NIP.'</td>
										<td> </td>
										<td> </td>
									</tr>
									
									
                  </table>
				  <br>
				  
				  <table border="0" width="100%" cellpadding="0" cellspacing="0">

                    <tr>
                             <td width="47%" style="vertical-align:top;">
							 	  
                                <table style="border:1px solid black;">
                                    <tr>
										<td style="vertical-align:top;">Pengeluaran dari TPS Asal </td>
                                        <td style="vertical-align:top;" width = "52%"></td>
                                        <td style="vertical-align:top;" ></td>
										<td style="vertical-align:top;"></td>
										<td style="vertical-align:top;"></td>
										
                                    </tr>
                                    <tr>
                                        <td style="vertical-align:top;"width = "10%">Tanggal : </td>
                                        <td style="vertical-align:top;" ></td>
                                        <td style="vertical-align:top;">'.$data['KOMODITI'].'</td>
										<td style="vertical-align:top;" ></td>
										<td style="vertical-align:top;" ></td>
                                    </tr>
                                    <tr>
                                        <td style="vertical-align:top;">Pukul :</td>
                                        <td style="vertical-align:top;"></td>
                                        <td style="vertical-align:top;">'.$data['KOMODITI'].'</td>
										<td style="vertical-align:top;" ></td>
										<td style="vertical-align:top;" ></td>
                                    </tr>
									 <tr>
                                        <td style="vertical-align:top;">No. Segel :</td>
                                        <td style="vertical-align:top;"> </td>
                                        <td style="vertical-align:top;">'.$data['KOMODITI'].'</td>
										<td style="vertical-align:top;" ></td>
										<td style="vertical-align:top;" ></td>
                                    </tr>
                                  	<tr>
										
                                        <td> </td>
                                        <td></td>
                                        <td></td>
										<td></td>
                                        <td></td>
                                    </tr>
									<tr>
										
                                        <td> </td>
                                        <td></td>
                                        <td></td>
										<td></td>
                                        <td></td>
                                    </tr>
									 <tr>
										
                                        <td> </td>
                                        <td></td>
                                        <td></td>
										<td></td>
                                        <td></td>
                                    </tr>
									 <tr>
										
                                        <td> </td>
                                        <td></td>
                                        <td></td>
										<td></td>
                                        <td></td>
                                    </tr>
                                   	<tr>
										
                                        <td style="vertical-align:top;">Pejabat Bea dan Cukai : </td>
                                        <td style="vertical-align:top;"> </td>
                                        <td></td>
										<td></td>
                                        <td></td>
                                    </tr>
									<tr>
										
                                        <td style="vertical-align:top;">Nama : </td>
                                        <td style="vertical-align:top;"> </td>
                                        <td></td>
										<td></td>
                                        <td></td>
                                    </tr>

										<tr>
										
                                        <td style="vertical-align:top;">NIP :</td>
                                        <td style="vertical-align:top;"> </td>
                                        <td></td>
										<td></td>
                                        <td></td>
                                    </tr>
										<tr>
										
                                        <td style="vertical-align:top;">Tanda Tangan :</td>
                                        <td style="vertical-align:top;"></td>
                                        <td></td>
										<td></td>
                                        <td></td>
                                    </tr>
								
									<br><br><br><br><br><br>
                                   
                                    
                                </table>
                            </td>
                            <td width="47%" style="vertical-align:top;">
                                <table style="border:1px solid black;">
                                    <tr>
										<td style="vertical-align:top;">Pemasukan ke TPS Tujuan </td>
                                        <td style="vertical-align:top;" width = "53%"></td>
                                        <td style="vertical-align:top;" ></td>
										<td style="vertical-align:top;"></td>
										<td style="vertical-align:top;"></td>
										
                                    </tr>
                                    <tr>
                                        <td style="vertical-align:top;">Tanggal :</td>
                                        <td style="vertical-align:top;"> </td>
                                        <td style="vertical-align:top;">'.$data['KOMODITI'].'</td>
										<td style="vertical-align:top;" ></td>
										<td style="vertical-align:top;" ></td>
                                    </tr>
                                    <tr>
                                        <td style="vertical-align:top;">Pukul :</td>
                                        <td style="vertical-align:top;"></td>
                                        <td style="vertical-align:top;">'.$data['KOMODITI'].'</td>
										<td style="vertical-align:top;" ></td>
										<td style="vertical-align:top;" ></td>
                                    </tr>
									 <tr>
                                        <td style="vertical-align:top;">No. Segel :  </td>
                                        <td style="vertical-align:top;"> </td>
                                        <td style="vertical-align:top;">'.$data['KOMODITI'].'</td>
										<td style="vertical-align:top;" ></td>
										<td style="vertical-align:top;" ></td>
                                    </tr>
                                  	<tr>
										
                                        <td> </td>
                                        <td></td>
                                        <td></td>
										<td></td>
                                        <td></td>
                                    </tr>
									<tr>
										
                                        <td> </td>
                                        <td></td>
                                        <td></td>
										<td></td>
                                        <td></td>
                                    </tr>
									 <tr>
										
                                        <td> </td>
                                        <td></td>
                                        <td></td>
										<td></td>
                                        <td></td>
                                    </tr>
									 <tr>
										
                                        <td> </td>
                                        <td></td>
                                        <td></td>
										<td></td>
                                        <td></td>
                                    </tr>
                                   	<tr>
										
                                        <td style="vertical-align:top;">Pejabat Bea dan Cukai : </td>
                                        <td style="vertical-align:top;"> </td>
                                        <td></td>
										<td></td>
                                        <td></td>
                                    </tr>
									<tr>
										
                                        <td style="vertical-align:top;">Nama : </td>
                                        <td style="vertical-align:top;"> </td>
                                        <td></td>
										<td></td>
                                        <td></td>
                                    </tr>

										<tr>
										
                                        <td style="vertical-align:top;">NIP :</td>
                                        <td style="vertical-align:top;"> </td>
                                        <td></td>
										<td></td>
                                        <td></td>
                                    </tr>
										<tr>
										
                                        <td style="vertical-align:top;">Tanda Tangan :</td>
                                        <td style="vertical-align:top;"> </td>
                                        <td></td>
										<td></td>
                                        <td></td>
                                    </tr>
								
									<br><br><br><br><br><br>
                                   
                                    
                                </table>
                            </td>
                    </tr>	
             </table>
			  <table border="0">
                                   
									<tr>
                                        <td style="font-size: 10px;">*Coret yang tidak perlu / diisi oleh Pejabat Bea dan Cukai     </td>
                                       
                                    </tr>
                                  
                                 
                                  
               </table>
			 
			 <pagebreak /> 
			 
			 
			 <br><br><br><br><br>
			 <p align="center" style="font-size:15px;"><u>SURAT PERNYATAAN</u></p>
			 <br><br><br><br>
			 
			 <table border="0" width="75%" align="center">
			 <tr>
			 <td align="justify"><p align="justify" style="font-size:14px;">Berdasarkan Peraturan Direktur Jendral Bea dan Cukai Nomor P-06/BC/2015 tanggal 06 April 2015 mengenai tata laksana Pindah Lokasi Penimbunan Barang Import yang  belum diselesaikan kewajiban pabeannya dari satu tempat Penimbunan sementara ke tempat penimbunan sementara lainnya,maka dengan ini kami yang bertanda tangan di bawah ini: </p>
			 </td>
			 </tr>
			 </table>
			 <br>
		
			  <table border="0" width="60%" align="center" style="font-size:14px;">
                                    <tr>
                                        <td>Nama  </td>
                                        <td>: </td>
                                        <td> '.$NAMA_PEMOHON.'</td>
                                    </tr>
                                     <tr>
                                        <td style="vertical-align:top;">Jabatan  </td>
                                        <td style="vertical-align:top;">: </td>
                                        <td style="vertical-align:top;">'.$JABATAN.'</td>
                                    </tr>
                                     <tr>
                                        <td style="vertical-align:top;">Perusahaan  </td>
                                        <td style="vertical-align:top;">: </td>
                                        <td style="vertical-align:top;">PT.SDV Logistics Indonesia</td>
                                    </tr>
									 <tr>
                                        <td style="vertical-align:top;"> </td>
                                        <td style="vertical-align:top;"></td>
                                        <td style="vertical-align:top;">Komplek Pergudangan Taman Niaga Soewarna</td>
                                    </tr>
									<tr>
                                        <td style="vertical-align:top;"> </td>
                                        <td style="vertical-align:top;"></td>
                                        <td style="vertical-align:top;">Unit E 8 Blok B Lot 7-8 Int l Airport</td>
                                    </tr>
									<tr>
                                        <td style="vertical-align:top;"> </td>
                                        <td style="vertical-align:top;"></td>
                                        <td style="vertical-align:top;">Soekarno-Hatta Tangerang Banten</td>
                                    </tr>
									 
									
									
								
									           
               </table>
			   <br>
			   
			  <table border="0" width="75%" align="center">
			 	<tr>
			 		<td align="justify"><p align="justify" style="font-size:14px;">Menyatakan bahwa untuk permohonan pindah lokasi penimbunan atas barang dengan data sebagai berikut: </p>
			 		</td>
			 	</tr>
			  </table>
			 <br>
			 
						
			  <table border="0" width="60%" align="center" style="font-size:14px;">
                                    <tr>
                                        <td width = "19.4%">Mawb </td>
                                        <td width = "1.7%">: </td>
                                        <td> '.$data['NO_MASTER_BL_AWB'].'</td>
                                    </tr>
                                     <tr>
                                        <td style="vertical-align:top;">Jumlah  </td>
                                        <td style="vertical-align:top;">: </td>
                                        <td style="vertical-align:top;">'.$data['JML_KMSSUM'].'</td>
                                    </tr>
                                     <tr>
                                        <td style="vertical-align:top;"></td>
                                        <td style="vertical-align:top;"></td>
                                        <td style="vertical-align:top;"></td>
                                    </tr>
									 <tr>
                                        <td style="vertical-align:top;"> </td>
                                        <td style="vertical-align:top;"></td>
                                        <td style="vertical-align:top;"></td>
                                    </tr>
								                                   
               </table>
			   <br>
			   
			   <table border="0" width="75%" align="center">
			   			<tr>
			   				<td align="justify"><p align="justify" style="font-size:14px;">Masih tersedia ruang atau tempat penimbunan bagi konsolidation barang import tersebut di TPS tujuan.</p>
			   				</td>
			   			</tr>
			   </table>
			   <br>
			   
			   <table border="0" width="75%" align="center">
			   			<tr>

			   				<td align="justify"><p align="justify" style="font-size:14px;">Selama proses penimbunan lokasi penimbunan dari lini 1 ke TPS tujuan,kami bersedia bertanggung jawab atas bea masuk,dan pajak dalam rangka import yang terhutang atas barang yang diberi izin PLP sampai dengan barang import tersebut selesai di pindahkan ke TPS tujuan,sebagaimana diatur dalam pasal 32 undang undang nomor 17 tahun 2006 tentang perubahan atas undang undang nomor 10 tahun 1995 tentang kepabeanan.Segala biaya dan resiko terkait pelaksanan PLP menjadi tanggung jawab kami.</p>			
			  
			   				</td>
			   			</tr>
			   </table>
			   <br>
			   
			   <table border="0" width="75%" align="center">
			   			<tr>
			   				<td align="justify"><p align="justify" style="font-size:14px;">Demikian surat pernyataan ini dibuat dengan sebenarnya dan untuk dipergunakan sebagai-mana mestinya.</p>			
			  
			 			   </td>
			   			</tr>
			   </table>
			   <br><br><br><br><br><br>
			
			   
		
			    <table border="0" width="100%" cellpadding="0" cellspacing="0" style="font-size:14px;">
                     <tr>
                            <td>
                                    <div></div>
                                    <div></div>
                                    <br>
                            </td>
                            <td  style="text-align: center;" width="45.5%">	
									Tangerang, '.FormatDate($data['TGL_SURAT']).'
                            </td>		
                    </tr>
					<tr>
                            <td>
                                    <div></div>
                                    <div></div>
                                    <br><br><br><br>

                            </td>
							
                            <td  style="text-align: center;" width="45.5%">
						
									
                            </td>
							
                    </tr>
                    <br><br><br><br><br><br>
                    <tr>
                            <td></td>
                            <td style="text-align: center;" width="45.5%">
                                    <div>'.$NAMA_PEMOHON.'</div>
                                    <div></div>
                            </td>
							
                    </tr>
					  <tr>
                            <td></td>
                            <td style="text-align: center;" width="45.5%">
                                    <div>( '.$JABATAN.' )</div>
                                    <div></div>
                            </td>
							
                    </tr>

             </table>
			   		
			 '; 
			
    return $html;
	
	
}

?>