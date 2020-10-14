<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if(!function_exists('format_terbilang'))
{
	function format_terbilang($num,$dec=4){
		$stext = array(
			"Nol",
			"Satu",
			"Dua",
			"Tiga",
			"Empat",
			"Lima",
			"Enam",
			"Tujuh",
			"Delapan",
			"Sembilan",
			"Sepuluh",
			"Sebelas"
		);
		$say  = array(
			"Ribu",
			"Juta",
			"Milyar",
			"Triliun",
			"Biliun" // remember limitation of float

		);
		$w = "";

		if ($num <0 ) {
			$w  = "Minus ";
			//make positive
			$num *= -1;
		}

		$snum = number_format($num,$dec,",",".");
	   // die($snum);
		$strnum =  explode(".",substr($snum,0,strrpos($snum,",")));
		//parse decimalnya
		$koma = substr($snum,strrpos($snum,",")+1);

		$isone = substr($num,0,1)  ==1;
		if (count($strnum)==1) {
			$num = $strnum[0];
			switch (strlen($num)) {
				case 1:
				case 2:
					if (!isset($stext[$strnum[0]])){
						if($num<20){
							$w .=$stext[substr($num,1)]." Belas";
						}else{
							$w .= $stext[substr($num,0,1)]." Puluh ".
								(intval(substr($num,1))==0 ? "" : $stext[substr($num,1)]);
						}
					}else{
						$w .= $stext[$strnum[0]];
					}
					break;
				case 3:
					$w .=  ($isone ? "Seratus" : format_terbilang(substr($num,0,1)) .
						" Ratus").
						" ".(intval(substr($num,1))==0 ? "" : format_terbilang(substr($num,1)));
					break;
				case 4:
					$w .=  ($isone ? "Seribu" : format_terbilang(substr($num,0,1)) .
						" Ribu").
						" ".(intval(substr($num,1))==0 ? "" : format_terbilang(substr($num,1)));
					break;
				default:
					break;
			}
		}else{
			$text = $say[count($strnum)-2];
			$w = ($isone && strlen($strnum[0])==1 && count($strnum) <=2? "Se".strtolower($text) : format_terbilang($strnum[0]).' '.$text);
			array_shift($strnum);
			$i =count($strnum)-2;
			foreach ($strnum as $k=>$v) {
				if (intval($v)) {
					$w.= ' '.format_terbilang($v).' '.($i >=0 ? $say[$i] : "");
				}
				$i--;
			}
		}
		$w = trim($w);
		if ($dec = intval($koma)) {
			$w .= " koma ". format_terbilang($koma);
		}
		return trim($w);
	}
}

if(!function_exists('set_setting')){
	function set_setting($type=""){
		$content = "";
		$data = array();
		$ci =& get_instance();
		$ci->load->database();
		$status = 'N';
		$KD_ORG = $ci->newsession->userdata('KD_ORGANISASI');
		$KD_GROUP = $ci->newsession->userdata('KD_GROUP');
		if($KD_GROUP=="SPA")
			$status = 'Y';
		$SQL = "SELECT KD_STATUS FROM app_setting
				WHERE KD_ORG_SENDER = ".$ci->db->escape($KD_ORG)."
				AND KD_APRF = ".$ci->db->escape($type);
		$result = $ci->db->query($SQL);
		if($result->num_rows() > 0){
			$row = $result->row();
			$status = $row->KD_STATUS;
		}
		return $status;
	}
}

if(!function_exists('date_en')){
	function date_en($vardate){
		if (!is_null($vardate)){
			$varindexdate = explode("-",$vardate);
			return $varindexdate[2]."-".$varindexdate[1]."-".$varindexdate[0];
		}
		else{
			return NULL;
		}
	}
}

if(!function_exists('date_input')){
	function date_input($vardate,$type=""){
		$return = "";
		if (trim($vardate) != ""){
			$arrdatetime = explode(" ",$vardate);
			if($arrdatetime!="")
				$time = " ".$arrdatetime[1];
			if($type=="auto"){
				$time = " ".date('H:i:s');
			}
			$arrdate = explode("-",$arrdatetime[0]);
			$return = $arrdate[2]."-".$arrdate[1]."-".$arrdate[0].$time;
		}
		return $return;
	}
}

if(!function_exists('grant')){
	function grant(){
		$ci =& get_instance();
		$ci->load->database();
		$iduser = $ci->newsession->userdata('ID');
		$kd_group = $ci->newsession->userdata('KD_GROUP');
		$tipe_org = $ci->newsession->userdata('TIPE_ORGANISASI');
		$furi = substr($ci->uri->slash_segment(1).$ci->uri->slash_segment(2),0,-1);
		$return = "";
		if($kd_group=="SPA"){
			$return = 'W';
		}else{
			$query = "SELECT A.ID, B.HAK_AKSES
					  FROM app_menu A
					  INNER JOIN app_user_menu B ON B.KD_MENU=A.ID
					  WHERE B.KD_USER = '".$iduser."'
					  AND A.URL_CI = '".$furi."'";

			$query = "SELECT * FROM (
						SELECT A.ID, B.HAK_AKSES
						FROM app_menu A
						INNER JOIN app_group_menu B ON B.KD_MENU=A.ID
						WHERE B.KD_GROUP = '".$kd_group."' AND B.KD_TIPE_ORGANISASI = '".$tipe_org."' AND A.URL_CI = '".$furi."'
						UNION
						SELECT AU.ID, BU.HAK_AKSES
						FROM app_menu AU
						INNER JOIN app_user_menu BU ON BU.KD_MENU=AU.ID
						WHERE BU.KD_USER = '".$iduser."' AND AU.URL_CI = '".$furi."'
						)X
						ORDER BY X.HAK_AKSES
						LIMIT 1";
			$result = $ci->db->query($query);
			if($result->num_rows() > 0){
				$akses = $result->row()->HAK_AKSES;
				$return = $akses;
			}
		}
		return $return;
	}
}

if(!function_exists('validate')){
	function validate($data, $type="TEXT"){
		if(trim(strtoupper($data))==""){
        	$return = NULL;
		} else {
			switch ($type) {
				case "TEXT":
					$return = trim(strtoupper($data));
					break;
				case "DATE":
					$arrdate = explode("/",trim($data));
					$d = $arrdate[0];
					$m = $arrdate[1];
					$y = $arrdate[2];
					$return = trim($y."-".$m."-".$d);
					break;
			}
		}
		return $return;
	}
}
if(!function_exists('validate_date')){
	function validate_date($date){
		if(strlen($date)==10){
			$arrdata  = explode('/', $date);
			if(count($arrdata) == 3) {
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
}

if (!function_exists('FormatDate')){
	function FormatDate($vardate){
		$pecah1 = explode("-", $vardate);
		$tanggal = intval($pecah1[2]);
		$arrayBulan = array("", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli",
							"Agustus", "September", "Oktober", "November", "Desember");
		$bulan = $arrayBulan[intval($pecah1[1])];
		$tahun = intval($pecah1[0]);
		$balik = $tanggal." ".$bulan." ".$tahun;
		return $balik;
	}
}

if (!function_exists('FormatDate3')){
	function FormatDate3($vardate){
		$pecah1 = explode("-", $vardate);
		$tanggal = intval($pecah1[2]);
		$arrayBulan = array("", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli",
							"Agustus", "September", "Oktober", "November", "Desember");
		$bulan = $arrayBulan[intval($pecah1[1])];
		$tahun = intval($pecah1[0]);
		$balik = $tahun." ".$bulan." ".$tanggal;
		return $balik;
	}
}

if (!function_exists('FormatRupiah'))
{
	function FormatRupiah($angka,$decimal){
		$rupiah = number_format($angka,$decimal,'.',',');
		return $rupiah;
	}
}

if (!function_exists('FormatDate2')){
	function FormatDate2($vardate){
		$pecah1 = explode("-", $vardate);

		$arrayBulan = array("", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli",
							"Agustus", "September", "Oktober", "November", "Desember");
		$bulan = $arrayBulan[intval($pecah1[1])];
		$tahun = intval($pecah1[0]);
		$balik = $bulan." ".$tahun;
		return $balik;
	}
}

if (!function_exists('format_npwp')){
	function format_npwp($n){
		$length = strlen($n);
		if($length == 15){
			$npwp = substr($n,0,2);
			$npwp .= ".";
			$npwp .= substr($n,2,3);
			$npwp .= ".";
			$npwp .= substr($n,5,3);
			$npwp .= ".";
			$npwp .= substr($n,8,1);
			$npwp .= "-";
			$npwp .= substr($n,9,3);
			$npwp .= ".";
			$npwp .= substr($n,12,3);
		}else{
			$npwp = $n;
		}
		return $npwp;
	}
}

if(!function_exists('str_xml')){
	function str_xml($data){
		if(strtoupper(trim($data))==""){
        	$return = "";
		}else{
			$return = str_replace("&","&amp;",$data);
			$return = str_replace("'","&apos;",$return);
			$return = str_replace("\"","&quot;",$return);
			$return = str_replace("<","&lt;",$return);
			$return = str_replace(">","&gt;",$return);
			$return = trim($return);
		}
		return $return;
	}
}

?>
