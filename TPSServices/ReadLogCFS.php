<?php

set_time_limit(3600);
require_once("config.php");

$sqlerror='';
$main = new main($CONF, $conn);
$main->connect();

/* Read all log*/
/* echo GetPermohonanCFS_success();
echo '<hr>';
echo GetPermohonanCFS_failed();
echo '<hr>';
echo OrderPengeluaranBarang_failed();
echo '<hr>'; */
echo GetOrderExpired();
echo '<hr>';
echo AllGetResponNull();
echo '<hr>';
echo ResetQueue();
echo '<hr>';
/* echo AllServicesFailed();
echo '<hr>'; */

function ResetQueue(){
    global $CONF, $conn;
	$mm='';
	$SQL = "select * from t_antrian_user";
	$Query = $conn->query($SQL);
	if ($Query->size() > 0) {$i=0;
		while ($Query->next()) {
			$ID = $Query->get("KD_LOKET");
			$SQL = "update t_antrian_user A set A.NO_ANTRIAN=NULL where A.KD_LOKET='" . $ID . "'";
			$Execute = $conn->execute($SQL);
		}
		$return = 'Berhasil Reset Antrian.';
	} else {
		$return = 'Error Antrian.';
	}
	return $return;
}

function GetOrderExpired(){
    global $CONF, $conn;
	$mm='';
	$SQL = "select * from t_order_hdr A where A.NO_ORDER like '10%' and A.KD_STATUS not in ('600','700') and A.TGL_KELUAR <= now() order by A.WK_REKAM asc;";
	$Query = $conn->query($SQL);
	if ($Query->size() > 0) {$i=0;
		while ($Query->next()) {
			$ID = $Query->get("NO_ORDER");
			$SQL = "update t_order_hdr A set A.KD_STATUS='600', A.TGL_STATUS=now() where A.NO_ORDER='" . $ID . "'";
			$Execute = $conn->execute($SQL);
			if($Execute){
				$mm .= $ID.'<br>';
				$i++;
			}
		}
		if($i>0){
			$return = $mm.'Order Kadaluwarsa adalah '.$i.' order.';
		}else{
			$return = 'Error Update Data.';
		}
	} else {
		$return = 'Belum ada penundaan pembayaran order.';
	}
	return $return;
}

function GetPermohonanCFS_success(){
    global $CONF, $conn;
	$SQL = "SELECT a.ID FROM app_log_services a WHERE a.METHOD in ('GetPermohonanCFS') and a.RESPONSE not like 
			'%<LOADPERMOHONANCFS>DATA TIDAK ADA.</LOADPERMOHONANCFS>%' AND a.FL_USED='0' order by a.WK_REKAM ASC limit 1000";
	$Query = $conn->query($SQL);
	if ($Query->size() > 0) {
		while ($Query->next()) {
			$ID_LOG = $Query->get("ID");
			$SQL = "UPDATE app_log_services SET FL_USED = '1', WK_USED = NOW() WHERE ID = '" . $ID_LOG . "'";
			$Execute = $conn->execute($SQL);

			$SQL = "INSERT INTO app_log_services_success SELECT * FROM app_log_services WHERE ID = '" . $ID_LOG . "'";
			$Execute = $conn->execute($SQL);

			$SQL = "UPDATE app_log_services_success SET KETERANGAN = 'Data telah terunduh' WHERE ID = '" . $ID_LOG . "'";
			$Execute = $conn->execute($SQL);

			if($Execute){
				$SQL = "DELETE FROM app_log_services WHERE ID = '" . $ID_LOG . "'";
				$Execute = $conn->execute($SQL);
			}
		}
		$return = 'GetPermohonanCFS_success : sukses pindah '.$Query->size().' data.';
	} else {
		$return = 'GetPermohonanCFS_success : data tidak ada.';
	}
	return $return;
}

function GetPermohonanCFS_failed(){
    global $CONF, $conn;
	$SQL = "SELECT a.ID FROM app_log_services a WHERE a.METHOD in ('GetPermohonanCFS') and a.RESPONSE like 
			'%<LOADPERMOHONANCFS>DATA TIDAK ADA.</LOADPERMOHONANCFS>%' AND a.FL_USED='0' order by a.WK_REKAM ASC limit 1000";
	$Query = $conn->query($SQL);
	if ($Query->size() > 0) {
		while ($Query->next()) {
			$ID_LOG = $Query->get("ID");
			$SQL = "UPDATE app_log_services SET FL_USED = '1', WK_USED = NOW() WHERE ID = '" . $ID_LOG . "'";
			$Execute = $conn->execute($SQL);

			$SQL = "INSERT INTO app_log_services_failed SELECT * FROM app_log_services WHERE ID = '" . $ID_LOG . "'";
			$Execute = $conn->execute($SQL);

			$SQL = "UPDATE app_log_services_failed SET KETERANGAN = 'Belum ada data untuk diunduh' WHERE ID = '" . $ID_LOG . "'";
			$Execute = $conn->execute($SQL);

			if($Execute){
				$SQL = "DELETE FROM app_log_services WHERE ID = '" . $ID_LOG . "'";
				$Execute = $conn->execute($SQL);
			}
		}
		$return = 'GetPermohonanCFS_failed : sukses pindah '.$Query->size().' data.';
	} else {
		$return = 'GetPermohonanCFS_failed : data tidak ada.';
	}
	return $return;
}

function OrderPengeluaranBarang_failed(){
    global $CONF, $conn;
	$SQL = "SELECT a.ID FROM app_log_services a WHERE a.METHOD in ('OrderPengeluaranBarang') and a.RESPONSE = 
			'<?xml version=\"1.0\" encoding=\"UTF-8\"?><DOCUMENT><ORDERPENGELUARANBARANG><HEADER><STATUS>FALSE</STATUS><RESPON>Data Tidak Ada</RESPON></HEADER></ORDERPENGELUARANBARANG></DOCUMENT>' AND a.FL_USED='0' order by a.WK_REKAM ASC limit 1000";
	$Query = $conn->query($SQL);
	if ($Query->size() > 0) {
		while ($Query->next()) {
			$ID_LOG = $Query->get("ID");
			$SQL = "UPDATE app_log_services SET FL_USED = '1', WK_USED = NOW() WHERE ID = '" . $ID_LOG . "'";
			$Execute = $conn->execute($SQL);

			$SQL = "INSERT INTO app_log_services_failed SELECT * FROM app_log_services WHERE ID = '" . $ID_LOG . "'";
			$Execute = $conn->execute($SQL);

			$SQL = "UPDATE app_log_services_failed SET KETERANGAN = 'Belum ada data untuk diunduh' WHERE ID = '" . $ID_LOG . "'";
			$Execute = $conn->execute($SQL);

			if($Execute){
				$SQL = "DELETE FROM app_log_services WHERE ID = '" . $ID_LOG . "'";
				$Execute = $conn->execute($SQL);
			}
		}
		$return = 'OrderPengeluaranBarang_failed : sukses pindah '.$Query->size().' data.';
	} else {
		$return = 'OrderPengeluaranBarang_failed : data tidak ada.';
	}
	return $return;
}

function AllGetResponNull(){
    global $CONF, $conn;
	$SQL = "SELECT A.ID, A.METHOD FROM app_log_services A WHERE A.METHOD IN ('GetBC23Permit_FASP','GetDataOB','GetDokumenManual',
			'GetDokumenPabeanPermit_FASP','GetImporPermit','GetImporPermit_FASP','GetResponBatalPLP','GetResponBatalPLPTujuan',
			'GetResponPLP','GetResponPLP_Tujuan','GetSPJM','GetRejectData') and A.WK_REKAM < NOW() - INTERVAL 1 DAY order by a.WK_REKAM ASC limit 1000";
	//select A.METHOD, count(A.ID) as JML from app_log_services A where A.RESPONSE is null 
	//group by A.METHOD having JML >= 1;
	$Query = $conn->query($SQL);
	if ($Query->size() > 0) {
		while ($Query->next()) {
			$ID_LOG = $Query->get("ID");
			$SQL = "UPDATE app_log_services SET FL_USED = '1', WK_USED = NOW() WHERE ID = '" . $ID_LOG . "'";
			$Execute = $conn->execute($SQL);

			$SQL = "INSERT INTO app_log_services_failed SELECT * FROM app_log_services WHERE ID = '" . $ID_LOG . "'";
			$Execute = $conn->execute($SQL);

			$SQL = "UPDATE app_log_services_failed SET KETERANGAN = 'Tidak dapat respon dari BC' WHERE ID = '" . $ID_LOG . "'";
			$Execute = $conn->execute($SQL);

			if($Execute){
				$SQL = "DELETE FROM app_log_services WHERE ID = '" . $ID_LOG . "'";
				$Execute = $conn->execute($SQL);
			}
		}
		$return = 'AllGetResponNull : sukses pindah '.$Query->size().' data.';
	} else {
		$return = 'AllGetResponNull : data tidak ada.';
	}
	return $return;
}

function AllServicesFailed(){
    global $CONF, $conn;
	$SQL = "select A.ID,A.METHOD,A.RESPONSE from app_log_services_failed A where A.METHOD not in ('CoarriCodeco_Container','CoarriCodeco_Kemasan','UploadMohonPLP','UploadBatalPLP') and (A.RESPONSE is null or A.RESPONSE in(
	'<?xml version=\"1.0\" encoding=\"UTF-8\"?><DOCUMENT><LOADPERMOHONANCFS>DATA TIDAK ADA.</LOADPERMOHONANCFS></DOCUMENT>',
	'<RESPON>Belum ada data baru</RESPON>','<RESPON>Anda tidak berhak mengambil data ini...!!!</RESPON>','Data tidak ditemukan',
	'<?xml version=\"1.0\" encoding=\"UTF-8\"?><DOCUMENT><ORDERPENGELUARANBARANG><HEADER><STATUS>FALSE</STATUS><RESPON>Data Tidak Ada</RESPON></HEADER></ORDERPENGELUARANBARANG></DOCUMENT>'))
	order by A.RESPONSE asc limit 1000;";
	$Query = $conn->query($SQL);
	if ($Query->size() > 0) {
		while ($Query->next()) {
			$ID_LOG = $Query->get("ID");
			$SQL = "DELETE FROM app_log_services_failed WHERE ID = '" . $ID_LOG . "'";
			$Execute = $conn->execute($SQL);
		}
		$return = 'AllServicesFailed : sukses hapus '.$Query->size().' data.';
	} else {
		$return = 'AllServicesFailed : data tidak ada.';
	}
	return $return;
}

$main->connect(false);

