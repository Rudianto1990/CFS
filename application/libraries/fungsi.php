<?php
 if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
class Fungsi
{
	function FormatHS($varnohs){
		if (!is_null($varnohs)){
			$varresult = '';
			$varresult = substr($varnohs,0,4).".".substr($varnohs,4,2).".".substr($varnohs,6,2).".".substr($varnohs,8,2);
			return $varresult;
		}
	}	
	function FormatNPWP($varnpwp){
		$varresult = '';
		$varresult = substr($varnpwp,0,2).".".substr($varnpwp,2,3).".".substr($varnpwp,5,3).".".substr($varnpwp,8,1)."-".substr($varnpwp,9,3).".".substr($varnpwp,12,3);
		return $varresult;
	}	
	function FormatDate($vardate)
	{
		$pecah1 = explode("-", $vardate);
		$tanggal = intval($pecah1[2]);
		$arrayBulan = array("", "January", "February", "March", "April", "May", "June", "July",
							"August", "September", "October", "November", "December");
		$bulan = $arrayBulan[intval($pecah1[1])];
		//$bulan = intval($pecah[1]);
		$tahun = intval($pecah1[0]);
		$balik = $tanggal." ".$bulan." ".$tahun;
		return $balik;
	}
	function FormatRupiah($angka,$decimal){
		$rupiah=number_format($angka,$decimal,'.',',');		
		return $rupiah;
	}	
	function dateformat($date){
	   if (strstr($date, "-"))   {
			   $date = preg_split("/[\/]|[-]+/", $date);
			   $date = $date[2]."-".$date[1]."-".$date[0];
			   return $date;
	   }
	   else if (strstr($date, "/"))   {
			   $date = preg_split("/[\/]|[-]+/", $date);
			   $date = $date[2]."-".$date[1]."-".$date[0];
			   return $date;
	   }
	   else if (strstr($date, ".")) {
			   $date = preg_split("[.]", $date);
			   $date = $date[2]."-".$date[1]."-".$date[0];
			   return $date;
	   }
	   return false;
	}
	function replace($input,$var){
		if (!is_null($input)){
			$varresult = '';
			$varresult = str_replace($var,'',$input);
			return $varresult;
		}
	}
	
	function FormatDateLengkap($vardate)
	{
		$pecah1 = explode("-", $vardate);
		$tanggal = intval($pecah1[2]);
		$arrayBulan = array("", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli",
							"Agustus", "September", "Oktober", "November", "Desember");
		$bulan = $arrayBulan[intval($pecah1[1])];
		$tahun = intval($pecah1[0]);
		$balik = $tanggal." ".$bulan." ".$tahun;
		return $balik;
	}
	function FormatDateLengkap2($vardate)
	{
		$pecah1 = explode("-", $vardate);
		$tanggal = intval($pecah1[0]);
		$arrayBulan = array("", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli",
							"Agustus", "September", "Oktober", "November", "Desember");
		$bulan = $arrayBulan[intval($pecah1[1])];
		$tahun = intval($pecah1[2]);
		$balik = $tanggal." ".$bulan." ".$tahun;
		return $balik;
	}
		
	function FormatAju($var){
		if (!is_null($var)){
			$varresult = '';
			$varresult = substr($var,0,6)."-".substr($var,7,6)."-".substr($var,13,8)."-".substr($var,21,6);
			return $varresult;
		}
	}
	function buatBarcode($kode,$seqreq,$tglCetak='')
	{
		date_default_timezone_set('Asia/Jakarta');
		$returnBarcode = "";
		if ($kode == "1")
		{
			if ($tglCetak != "")
			{
				$seqreqBarcode = $seqreq;
				$akhir = strtotime($tglCetak);
				$awal = strtotime(substr($tglCetak,0,10)." 00:00:00");
				$timestamp = $akhir-$awal;
				$returnBarcode = $kode.str_pad($seqreqBarcode,6,"0",STR_PAD_LEFT).$timestamp;
			}
		}
		else
		{
			$returnBarcode = $kode.$seqreq;
		}
		//$returnBarcode = "";
		return $returnBarcode;
	}
}
?>