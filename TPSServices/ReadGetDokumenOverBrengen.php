<?php

set_time_limit(3600);
require_once("config.php");

$method = 'READGETDOKUMENOVERBRENGEN';
$KdAPRF = 'GETDOKUMENOVERBRENGEN';
$main = new main($CONF, $conn);
$main->connect();

//BEGIN
$SQL = "SELECT a.ID, a.RESPONSE FROM app_log_services a WHERE a.METHOD in ('GetDataOB')  AND a.FL_USED = '0' AND a.RESPONSE is not null order by a.WK_REKAM ASC limit 50";
$Query = $conn->query($SQL);
if ($Query->size() > 0) {
    while ($Query->next()) {
        $ID_LOG = $Query->get("ID");
        $STR_DATA = $Query->get("RESPONSE");

        $xml = xml2ary($STR_DATA);
//        echo '<pre>';
//        print_r($xml);
//        echo '</pre>';
        if (count($xml) > 0) {
            $xml = $xml['DOCUMENT']['_c'];
            $countDOKOB = 0;
            $countDOKOB = count($xml['OB']);
            if ($countDOKOB > 1) {
                for ($c = 0; $c < $countDOKOB; $c++) {
                    $DOKOB = $xml['OB'][$c]['_c'];
                    InsertDOKOB($DOKOB, $ID_LOG);
                }
            } elseif ($countDOKOB == 1) {
                $DOKOB = $xml['OB']['_c'];
                InsertDOKOB($DOKOB, $ID_LOG);
            }

            if ($countDOKOB > 0) {
                echo 'sukses';
                $SQL = "UPDATE app_log_services SET FL_USED = '1', WK_USED = NOW() WHERE ID = '" . $ID_LOG . "'";
                $Execute = $conn->execute($SQL);

                $SQL = "INSERT INTO app_log_services_success SELECT * FROM app_log_services WHERE ID = '" . $ID_LOG . "'";
                $Execute = $conn->execute($SQL);

                if ($Execute) {
                    $SQL = "DELETE FROM app_log_services WHERE ID = '" . $ID_LOG . "'";
                    $Execute = $conn->execute($SQL);
                }
            } else {
                $SQL = "UPDATE app_log_services SET FL_USED = '1', WK_USED = NOW() WHERE ID = '" . $ID_LOG . "'";
                $Execute = $conn->execute($SQL);

                $SQL = "INSERT INTO app_log_services_failed SELECT * FROM app_log_services WHERE ID = '" . $ID_LOG . "'";
                $Execute = $conn->execute($SQL);

                $SQL = "UPDATE app_log_services_failed SET KETERANGAN = 'Tidak Berhasil Parsing Data', WK_USED = NOW() WHERE ID = '" . $ID_LOG . "'";
                $Execute = $conn->execute($SQL);

                if ($Execute) {
                    $SQL = "DELETE FROM app_log_services WHERE ID = '" . $ID_LOG . "'";
                    $Execute = $conn->execute($SQL);
                }
            }
        } else {
            $SQL = "UPDATE app_log_services SET FL_USED = '1', WK_USED = NOW() WHERE ID = '" . $ID_LOG . "'";
            $Execute = $conn->execute($SQL);

            $SQL = "INSERT INTO app_log_services_failed SELECT * FROM app_log_services WHERE ID = '" . $ID_LOG . "'";
            $Execute = $conn->execute($SQL);

            $SQL = "UPDATE app_log_services_failed SET KETERANGAN = 'Tidak ada data', WK_USED = NOW() WHERE ID = '" . $ID_LOG . "'";
            $Execute = $conn->execute($SQL);

            if ($Execute) {
                $SQL = "DELETE FROM app_log_services WHERE ID = '" . $ID_LOG . "'";
                $Execute = $conn->execute($SQL);
            }
        }

        echo '<hr>';
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

function InsertDOKOB($DOKOB, $ID_LOG) {
    global $CONF, $conn;
    $REF_NUMBER = trim($DOKOB['REF_NUMBER']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($DOKOB['REF_NUMBER']['_v'])) . "'";
    $NO_SURAT_PLP = trim($DOKOB['NO_SURAT_PLP']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($DOKOB['NO_SURAT_PLP']['_v'])) . "'";
    $TGL_SURAT_PLP = trim($DOKOB['TGL_SURAT_PLP']['_v']) == "" ? "NULL" : "STR_TO_DATE('" . strtoupper(trim($DOKOB['TGL_SURAT_PLP']['_v'])) . "','%Y%m%d')";
    $KODE_KANTOR = trim($DOKOB['KODE_KANTOR']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($DOKOB['KODE_KANTOR']['_v'])) . "'";
    $KD_DOK = trim($DOKOB['KD_DOK']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($DOKOB['KD_DOK']['_v'])) . "'";
    $NO_PLP = trim($DOKOB['NO_PLP']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($DOKOB['NO_PLP']['_v'])) . "'";
    $TGL_PLP = trim($DOKOB['TGL_PLP']['_v']) == "" ? "NULL" : "STR_TO_DATE('" . strtoupper(trim($DOKOB['TGL_PLP']['_v'])) . "','%Y%m%d')";
    $KD_TPS_ASAL = trim($DOKOB['KD_TPS_ASAL']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($DOKOB['KD_TPS_ASAL']['_v'])) . "'";
    $GUDANG_TUJUAN = trim($DOKOB['GUDANG_TUJUAN']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($DOKOB['GUDANG_TUJUAN']['_v'])) . "'";
    $NM_ANGKUT = trim($DOKOB['NM_ANGKUT']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($DOKOB['NM_ANGKUT']['_v'])) . "'";
    $NO_VOY_FLIGHT = trim($DOKOB['NO_VOY_FLIGHT']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($DOKOB['NO_VOY_FLIGHT']['_v'])) . "'";
    $CALL_SIGN = trim($DOKOB['CALL_SIGN']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($DOKOB['CALL_SIGN']['_v'])) . "'";
    $TGL_TIBA = trim($DOKOB['TGL_TIBA']['_v']) == "" ? "NULL" : "STR_TO_DATE('" . strtoupper(trim($DOKOB['TGL_TIBA']['_v'])) . "','%Y%m%d')";
    $NO_BC11 = trim($DOKOB['NO_BC11']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($DOKOB['NO_BC11']['_v'])) . "'";
    $TGL_BC11 = trim($DOKOB['TGL_BC11']['_v']) == "" ? "NULL" : "STR_TO_DATE('" . strtoupper(trim($DOKOB['TGL_BC11']['_v'])) . "','%Y%m%d')";
    $NO_POS_BC11 = trim($DOKOB['NO_POS_BC11']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($DOKOB['NO_POS_BC11']['_v'])) . "'";
    $ID_CONSIGNEE = trim($DOKOB['ID_CONSIGNEE']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($DOKOB['ID_CONSIGNEE']['_v'])) . "'";
    $CONSIGNEE = trim($DOKOB['CONSIGNEE']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($DOKOB['CONSIGNEE']['_v'])) . "'";
    $NO_CONT = trim($DOKOB['NO_CONT']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($DOKOB['NO_CONT']['_v'])) . "'";
    $UK_CONT = trim($DOKOB['UK_CONT']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($DOKOB['UK_CONT']['_v'])) . "'";
    $JNS_CONT = trim($DOKOB['JNS_CONT']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($DOKOB['JNS_CONT']['_v'])) . "'";
    $NO_SEGEL = trim($DOKOB['NO_SEGEL']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($DOKOB['NO_SEGEL']['_v'])) . "'";
    $BRUTO = trim($DOKOB['BRUTO']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($DOKOB['BRUTO']['_v'])) . "'";
    $PEL_MUAT = trim($DOKOB['PEL_MUAT']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($DOKOB['PEL_MUAT']['_v'])) . "'";
    $PEL_TRANSIT = trim($DOKOB['PEL_TRANSIT']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($DOKOB['PEL_TRANSIT']['_v'])) . "'";
    $PEL_BONGKAR = trim($DOKOB['PEL_BONGKAR']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($DOKOB['PEL_BONGKAR']['_v'])) . "'";

    echo $NO_SURAT_PLP . ' - ' . $TGL_SURAT_PLP . '<br>';
    $SQL = "SELECT REF_NUMBER
            FROM t_respon_over_brengen
            WHERE NO_SURAT_PLP = " . $NO_SURAT_PLP . " 
                  AND TGL_SURAT_PLP = " . $TGL_SURAT_PLP . "
                  AND NO_PLP = " . $NO_PLP . "
                  AND TGL_PLP = " . $TGL_PLP . "
                  AND NO_POS_BC11 = " . $NO_POS_BC11 . "
                  AND NO_CONT = " . $NO_CONT . "";
    $Query = $conn->query($SQL);
    if ($Query->size() == 0) {
        $SQL = "INSERT INTO t_respon_over_brengen (REF_NUMBER, NO_SURAT_PLP, TGL_SURAT_PLP, KODE_KANTOR, KD_DOK, NO_PLP, TGL_PLP, 
                                                   KD_TPS_ASAL, GUDANG_TUJUAN, NM_ANGKUT, NO_VOY_FLIGHT, CALL_SIGN, TGL_TIBA, 
                                                   NO_BC11, TGL_BC11, NO_POS_BC11, ID_CONSIGNEE, CONSIGNEE, NO_CONT, UK_CONT, 
                                                   JNS_CONT, NO_SEGEL, BRUTO, PEL_MUAT, PEL_TRANSIT, PEL_BONGKAR, KD_STATUS, 
                                                   TGL_STATUS, ID_LOG)
                VALUES (" . $REF_NUMBER . ", " . $NO_SURAT_PLP . ", " . $TGL_SURAT_PLP . ", " . $KODE_KANTOR . ", " . $KD_DOK . ", " . $NO_PLP . ", " . $TGL_PLP . ", 
                        " . $KD_TPS_ASAL . ", " . $GUDANG_TUJUAN . ", " . $NM_ANGKUT . ", " . $NO_VOY_FLIGHT . ", " . $CALL_SIGN . ", " . $TGL_TIBA . ", 
                        " . $NO_BC11 . ", " . $TGL_BC11 . ", " . $NO_POS_BC11 . ", " . $ID_CONSIGNEE . ", " . $CONSIGNEE . ", " . $NO_CONT . ", " . $UK_CONT . ", 
                        " . $JNS_CONT . ", " . $NO_SEGEL . ", " . $BRUTO . ", " . $PEL_MUAT . ", " . $PEL_TRANSIT . ", " . $PEL_BONGKAR . ", '100', 
                        NOW(), '" . $ID_LOG . "')";
        $Execute = $conn->execute($SQL);
        echo $SQL . '<br>';
    }
}

?>
