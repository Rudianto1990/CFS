<table class="tabelajax responsive m-b-0" border='1'> 
<tr class="headcontent"> 
	<th width=2>NO</th>
	<th>NO. BL/AWB</th>
	<th>JUMLAH KEMASAN</th>
	<th>JENIS KEMASAN</th> 
	<th>CONTAINER ASAL</th> 
	<th>NAMA KAPAL</th>
	<th>NO. VOYAGE</th>
	<th>STATUS</th>
</tr>

 	<?php
// $jml = count($arrhdr);
 	//print_r($arrhdr);
	$no=1;
    foreach ($arrhdr as $v2) {
		if($v2['WK_OUT']==null){
			$status=$v2['GATE IN'];
		}else{
			$status=$v2['GATE OUT'];
		}
       echo' 	<tr> 
 		<td width=2>'.$no.'</td> 
 		<td>'.$v2['NO BL'].'</td> 
 		<td>'.$v2['JUMLAH KEMASAN'].'</td>
		<td>'.$v2['JENIS KEMASAN'].'</td> 
 		<td>'.$v2['KONTAINER ASAL'].'</td> 
 		<td>'.$v2['NAMA KAPAL'].'</td> 
 		<td>'.$v2['NO VOYAGE/FLIGHT'].'</td> 
 		<td>'.$status.'</td> 
		</tr>';$no++;
    }

 	?>
 
</table>
