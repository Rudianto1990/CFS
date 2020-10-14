<?php

set_time_limit(3600);
require_once("config.php");

$method = 'READGETBILLING';
$KdAPRF = 'GETBILLING';
// $KodeDokBC = '1';
//$filename = $CONF['root.dir'] . "CheckScheduler/" . $method . ".txt";
$main = new main($CONF, $conn);
//$CheckFile = $main->CheckFile($filename);
//if (!$CheckFile) {
   // $createFile = $main->createFile($filename);
    $main->connect();

    //BEGIN
    $SQL = "SELECT a.ID, a.STR_DATA FROM mailbox a WHERE a.KD_APRF = 'GETBILLING' AND a.KD_STATUS = '100' order by a.TGL_STATUS ASC limit 5";
    // echo $SQL;die();
    $Query = $conn->query($SQL);
    if ($Query->size() > 0) { 
        while ($Query->next()) {
            $ID_LOG = $Query->get("ID");
            $STR_DATA = $Query->get("STR_DATA");
            // echo $STR_DATA;die();
            $xml = xml2ary($STR_DATA);
            // print_r($xml) ;die();
            if (count($xml) > 0) {
                $xml = $xml['DOCUMENT']['_c'];
                $countSPPB = 0;
                $countSPPB = count($xml['LOADBILLING']);
                // print_r($xml['LOADBILLING']) ;die();
                if ($countSPPB > 1) {
                    for ($c = 0; $c < $countSPPB; $c++) {
                        $LOADBILLING = $xml['LOADBILLING'][$c]['_c'];
                        // echo "oioi";die();
                        // print_r($LOADBILLING);die();
                        InsertBilling($LOADBILLING, $ID_LOG);
                    }
                } elseif ($countSPPB == 1) {
                    $LOADBILLING = $xml['LOADBILLING']['_c'];
                    InsertBilling($LOADBILLING, $ID_LOG);
                }

                /*if($countSPPB > 0){
                    $SQL = "UPDATE app_log_services SET FL_USED = '1', WK_USED = NOW() WHERE ID = '" . $ID_LOG . "'";
                    $Execute = $conn->execute($SQL);

                    $SQL = "INSERT INTO app_log_services_success SELECT * FROM app_log_services WHERE ID = '" . $ID_LOG . "'";
                    $Execute = $conn->execute($SQL);

                    if($Execute){
                        $SQL = "DELETE FROM app_log_services WHERE ID = '" . $ID_LOG . "'";
                        $Execute = $conn->execute($SQL);                    
                    }
                }else{
                    $SQL = "UPDATE app_log_services SET FL_USED = '1', WK_USED = NOW() WHERE ID = '" . $ID_LOG . "'";
                    $Execute = $conn->execute($SQL);    

                    $SQL = "INSERT INTO app_log_services_failed SELECT * FROM app_log_services WHERE ID = '" . $ID_LOG . "'";
                    $Execute = $conn->execute($SQL);

                    if($Execute){
                        $SQL = "DELETE FROM app_log_services WHERE ID = '" . $ID_LOG . "'";
                        $Execute = $conn->execute($SQL);                    
                    }
                }*/
            }else{
                /*$SQL = "UPDATE app_log_services SET FL_USED = '1', WK_USED = NOW() WHERE ID = '" . $ID_LOG . "'";
                $Execute = $conn->execute($SQL);    

                $SQL = "INSERT INTO app_log_services_failed SELECT * FROM app_log_services WHERE ID = '" . $ID_LOG . "'";
                $Execute = $conn->execute($SQL);

                if($Execute){
                    $SQL = "DELETE FROM app_log_services WHERE ID = '" . $ID_LOG . "'";
                    $Execute = $conn->execute($SQL);                    
                }*/
            }
            
            // echo $SQL . '<br>';
        }
    } else {
        echo 'data tidak ada.';
    }
    //END

    $main->connect(false);
    //$main->removeFile($filename);
//} else {
  //  echo 'Scheduler sedang berjalan, harap menghapus file ' . $method . '.txt yang ada difolder CheckScheduler.';
//}

function InsertBilling($SPPB, $ID_LOG) {
    // echo "sini";	
    global $CONF, $conn;
    $header = $SPPB['HEADER']['_c'];
    $detil = $SPPB['DETIL']['_c'];
    $JENIS_BILLING = trim($header['JENIS_BILLING']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['JENIS_BILLING']['_v'])) . "'";
    // echo $JENIS_BILLING;die();
    if($JENIS_BILLING=="'1'"){//CONTAINER
        // echo "masuk";
        $TARIF_LOLOFULL = trim($detil['TARIF_LOLOFULL']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($detil['TARIF_LOLOFULL']['_v'])) . "'";
        $TARIF_MOVING1 = trim($detil['TARIF_MOVING1']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($detil['TARIF_MOVING1']['_v'])) . "'";
        $TARIF_STRIPPING = trim($detil['TARIF_STRIPPING']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($detil['TARIF_STRIPPING']['_v'])) . "'";
        $TARIF_LOLOEMPTY = trim($detil['TARIF_LOLOEMPTY']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($detil['TARIF_LOLOEMPTY']['_v'])) . "'";
        $TARIF_MOVING2 = trim($detil['TARIF_MOVING2']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($detil['TARIF_MOVING2']['_v'])) . "'";
        $TARIF_TRUCKING = trim($detil['TARIF_TRUCKING']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($detil['TARIF_TRUCKING']['_v'])) . "'";

        if($TARIF_LOLOFULL!=187500){//COMPARE TARIFF
            echo "TARIF LOLOFULL TIDAK SESUAI STANDART";die();
        }elseif($TARIF_MOVING1!=187500){//COMPARE TARIFF
            echo "TARIF MOVING1 TIDAK SESUAI STANDART";die();
        }elseif($TARIF_STRIPPING!=187500){//COMPARE TARIFF
            echo "TARIF STRIPPING TIDAK SESUAI STANDART";die();
        }elseif($TARIF_LOLOEMPTY!=187500){//COMPARE TARIFF
            echo "TARIF LOLOEMPTY TIDAK SESUAI STANDART";die();
        }elseif($TARIF_MOVING2!=187500){//COMPARE TARIFF
            echo "TARIF MOVING2 TIDAK SESUAI STANDART";die();
        }elseif($TARIF_TRUCKING!=187500){//COMPARE TARIFF
            echo "TARIF TRUCKING TIDAK SESUAI STANDART";die();
        }else{
            $NO_CONTAINER = trim($header['NO_CONTAINER']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['NO_CONTAINER']['_v'])) . "'";
            $NO_MASTER_BL = trim($header['NO_MASTER_BL']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['NO_MASTER_BL']['_v'])) . "'";
            $NAMA_PEMILIK = trim($header['NAMA_PEMILIK']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['NAMA_PEMILIK']['_v'])) . "'";
            $LOLOFULL = trim($detil['LOLOFULL']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($detil['LOLOFULL']['_v'])) . "'";
            $MOVING1 = trim($detil['MOVING1']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($detil['MOVING1']['_v'])) . "'";
            $STRIPPING = trim($detil['STRIPPING']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($detil['STRIPPING']['_v'])) . "'";
            $LOLOEMPTY = trim($detil['LOLOEMPTY']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($detil['LOLOEMPTY']['_v'])) . "'";
            $MOVING2 = trim($detil['MOVING2']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($detil['MOVING2']['_v'])) . "'";
            $TRUCKING = trim($detil['TRUCKING']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($detil['TRUCKING']['_v'])) . "'";
            $SUBTOTAL1 = trim($detil['SUBTOTAL1']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($detil['SUBTOTAL1']['_v'])) . "'";
            $PPN1 = trim($detil['PPN1']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($detil['PPN1']['_v'])) . "'";
            $TOTAL1 = trim($detil['TOTAL1']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($detil['TOTAL1']['_v'])) . "'";
            $BC11NUMBER = trim($detil['BC11NUMBER']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($detil['BC11NUMBER']['_v'])) . "'";
            $BC11DATE = trim($detil['BC11DATE']['_v']) == "" ? "NULL" : "STR_TO_DATE('" . strtoupper(trim($detil['BC11DATE']['_v'])) . "','%d%m%Y')";

            $SQL = "INSERT INTO t_billing_cfs (JENIS_BILLING, NO_CONT, NO_MASTER_BL, NAMA_PEMILIK, LOLOFULL,
                            MOVING1, STRIPPING, LOLOEMPTY, MOVING2, TRUCKING, SUBTOTAL1, PPN1, TOTAL1, BC11NUMBER, BC11DATE)
                    VALUES (" . $JENIS_BILLING . "," . $NO_CONTAINER . "," . $NO_MASTER_BL . ", " . $NAMA_PEMILIK . ", " . $LOLOFULL . ",
                            " . $MOVING1 . ", " . $STRIPPING . ", " . $LOLOEMPTY . ", " . $MOVING2 . ", " . $TRUCKING . "," . $SUBTOTAL1 . "," . $PPN1 . ",
                            " . $TOTAL1 . "," . $BC11NUMBER . "," . $BC11DATE . ")";
            // echo $SQL;die();
            // print_r($SQL);die();
            $Execute = $conn->execute($SQL);

            if($Execute!=''){
                echo "SUKSES";
            }else{
                echo "GAGAL INSERT";
            }
        }

    }elseif($JENIS_BILLING=="'2'"){//KEMASAN

        $TARIF_RDM = trim($detil['TARIF_RDM']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($detil['TARIF_RDM']['_v'])) . "'";
        $TARIF_STORAGE = trim($detil['TARIF_STORAGE']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($detil['TARIF_STORAGE']['_v'])) . "'";
        $TARIF_ADMINISTRASI = trim($detil['TARIF_ADMINISTRASI']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($detil['TARIF_ADMINISTRASI']['_v'])) . "'";
        $TARIF_SURCHAGE_DG = trim($detil['TARIF_SURCHAGE_DG']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($detil['TARIF_SURCHAGE_DG']['_v'])) . "'";
        $TARIF_SURCHAGE_WEIGHT = trim($detil['TARIF_SURCHAGE_WEIGHT']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($detil['TARIF_SURCHAGE_WEIGHT']['_v'])) . "'";
        $TARIF_SURVEYOR = trim($detil['TARIF_SURVEYOR']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($detil['TARIF_SURVEYOR']['_v'])) . "'";
        $TARIF_BEHANDLE = trim($detil['TARIF_BEHANDLE']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($detil['TARIF_BEHANDLE']['_v'])) . "'";
        $TARIF_KEBERSIHAN = trim($detil['TARIF_KEBERSIHAN']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($detil['TARIF_KEBERSIHAN']['_v'])) . "'";
        
        
        if($TARIF_RDM!=187500){//COMPARE TARIFF
            echo "TARIF RDM TIDAK SESUAI STANDART";die();
        }elseif($TARIF_STORAGE!=187500){//COMPARE TARIFF
            echo "TARIF STORAGE TIDAK SESUAI STANDART";die();
        }elseif($TARIF_ADMINISTRASI!=187500){//COMPARE TARIFF
            echo "TARIF ADMINISTRASI TIDAK SESUAI STANDART";die();
        }elseif($TARIF_SURCHAGE_DG!=187500){//COMPARE TARIFF
            echo "TARIF SURCHAGE_DG TIDAK SESUAI STANDART";die();
        }elseif($TARIF_SURCHAGE_WEIGHT!=187500){//COMPARE TARIFF
            echo "TARIF SURCHAGE_WEIGHT TIDAK SESUAI STANDART";die();
        }elseif($TARIF_SURVEYOR!=187500){//COMPARE TARIFF
            echo "TARIF SURVEYOR TIDAK SESUAI STANDART";die();
        }elseif($TARIF_BEHANDLE!=187500){//COMPARE TARIFF
            echo "TARIF BEHANDLE TIDAK SESUAI STANDART";die();
        }elseif($TARIF_KEBERSIHAN!=187500){//COMPARE TARIFF
            echo "TARIF KEBERSIHAN TIDAK SESUAI STANDART";die();
        }else{
            $NO_CONTAINER = trim($header['NO_CONTAINER']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['NO_CONTAINER']['_v'])) . "'";
            $NO_BL = trim($header['NO_BL']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['NO_BL']['_v'])) . "'";
            $NAMA_PEMILIK = trim($header['NAMA_PEMILIK']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['NAMA_PEMILIK']['_v'])) . "'";
            $TYPE = trim($detil['TYPE']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($detil['TYPE']['_v'])) . "'";
            $RDM = trim($detil['RDM']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($detil['RDM']['_v'])) . "'";
            $STORAGE = trim($detil['STORAGE']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($detil['STORAGE']['_v'])) . "'";
            $ADMINISTRASI = trim($detil['ADMINISTRASI']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($detil['ADMINISTRASI']['_v'])) . "'";
            $SURCHAGE_DG = trim($detil['SURCHAGE_DG']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($detil['SURCHAGE_DG']['_v'])) . "'";
            $SURCHAGE_WEIGHT = trim($detil['SURCHAGE_WEIGHT']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($detil['SURCHAGE_WEIGHT']['_v'])) . "'";
            $SURVEYOR = trim($detil['SURVEYOR']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($detil['SURVEYOR']['_v'])) . "'";
            $BEHANDLE = trim($detil['BEHANDLE']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($detil['BEHANDLE']['_v'])) . "'";
            $KEBERSIHAN = trim($detil['KEBERSIHAN']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($detil['KEBERSIHAN']['_v'])) . "'";
            $SUBTOTAL1 = trim($detil['SUBTOTAL1']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($detil['SUBTOTAL1']['_v'])) . "'";
            $PPN1 = trim($detil['PPN1']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($detil['PPN1']['_v'])) . "'";
            $TOTAL1 = trim($detil['TOTAL1']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($detil['TOTAL1']['_v'])) . "'";
            $BC11NUMBER = trim($detil['BC11NUMBER']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($detil['BC11NUMBER']['_v'])) . "'";
            $BC11DATE = trim($detil['BC11DATE']['_v']) == "" ? "NULL" : "STR_TO_DATE('" . strtoupper(trim($detil['BC11DATE']['_v'])) . "','%d%m%Y')";

            $SQL = "INSERT INTO t_billing_cfs (JENIS_BILLING, NO_CONT, NO_BL, NAMA_PEMILIK, TYPE,
                            RDM, STORAGE, ADMINISTRASI, SURCHAGE_DG, SURCHAGE_WEIGHT, SURVEYOR, BEHANDLE, KEBERSIHAN, SUBTOTAL1, PPN1, TOTAL1, BC11NUMBER, BC11DATE)
                    VALUES (" . $JENIS_BILLING . "," . $NO_CONTAINER . "," . $NO_BL . ", " . $NAMA_PEMILIK . ", " . $TYPE . ",
                            " . $RDM . ", " . $STORAGE . ", " . $ADMINISTRASI . ", " . $SURCHAGE_DG . ", " . $SURCHAGE_WEIGHT . ", " . $SURVEYOR . ", " . $BEHANDLE . ", 
                            " . $KEBERSIHAN . "," . $SUBTOTAL1 . "," . $PPN1 . "," . $TOTAL1 . "," . $BC11NUMBER . "," . $BC11DATE . ")";
            // echo $SQL;die();
            $Execute = $conn->execute($SQL);

            if($Execute!=''){
                echo "SUKSES";
            }else{
                echo "GAGAL INSERT";
            }
        }
    }
}


?>
