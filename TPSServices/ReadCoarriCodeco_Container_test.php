<?php

set_time_limit(3600);
require_once("config.php");

$method = 'ReadCoarriCodeco_Container';
$KdAPRF = 'CoarriCodeco_Container';
$KodeDokBC = '1';
$sqlerror='';
$main = new main($CONF, $conn);
  $main->connect();
  $SQL = "SELECT a.ID, a.REQUEST FROM app_log_services a WHERE a.METHOD in ('CoarriCodeco_Container') 
AND a.USERNAME='TEST' order by a.WK_REKAM ASC";
  $Query = $conn->query($SQL);
  if ($Query->size() > 0) {
    while ($Query->next()) {
      $ID_LOG = $Query->get("ID");
      $STR_DATA = $Query->get("REQUEST");

      $xml = xml2ary($STR_DATA);
      if (count($xml) > 0) {
        $xml = $xml['DOCUMENT']['_c'];
        $countSPPB = 0;
        $countSPPB = count($xml['COCOCONT']);
		echo $ID_LOG . '<br>';
        if ($countSPPB > 1) {
          for ($c = 0; $c < $countSPPB; $c++) {
            $cocostscont = $xml['COCOCONT'][$c]['_c'];
            Insertcocostscont($KodeDokBC, $cocostscont, $ID_LOG);
          }
        } elseif ($countSPPB == 1) {
          $cocostscont = $xml['COCOCONT']['_c'];
          Insertcocostscont($KodeDokBC, $cocostscont, $ID_LOG);
        }else{
		  echo 'data tidak ada.';
        }
      }else{
		echo 'data tidak ada.';
      }
    }
  } else {
    echo 'data tidak ada.';
  }
  //END

  $main->connect(false);

function Insertcocostscont($KodeDokBC, $cocostscont, $ID_LOG) {
    global $CONF, $conn;
	$detil = $cocostscont['DETIL']['_c'];
	$countCONT = count($detil['CONT']);
	echo 'Jumlah Container = '.$countCONT.'<br>';
}
