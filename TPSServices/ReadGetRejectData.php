<?php

set_time_limit(3600);
require_once("config.php");

$method = 'READGETREJECTDATA';
$KdAPRF = 'GETREJECTDATA';
$main = new main($CONF, $conn);
$main->connect();

//BEGIN
$SQL = "SELECT a.ID, a.RESPONSE FROM app_log_services a WHERE a.METHOD in ('GetRejectData')  AND a.FL_USED = '0' AND a.RESPONSE is not null order by a.WK_REKAM ASC limit 500";
$Query = $conn->query($SQL);
if ($Query->size() > 0) {
    while ($Query->next()) {
        $ID_LOG = $Query->get("ID");
        $STR_DATA = $Query->get("RESPONSE");

        $xml = xml2ary($STR_DATA);
        if (count($xml) > 0) {
            $xml = $xml['DOCUMENT']['_c'];
            $countREJECT = 0;
            $countREJECT = count($xml['REJECT']);
            if ($countREJECT > 1) {
                for ($c = 0; $c < $countREJECT; $c++) {
                    $REJECT = $xml['REJECT'][$c]['_c'];
                    InsertREJECT($REJECT, $ID_LOG);
                }
            } elseif ($countREJECT == 1) {
                $REJECT = $xml['REJECT']['_c'];
                InsertREJECT($REJECT, $ID_LOG);
            }

            if ($countREJECT > 0) {
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

function InsertREJECT($REJECT, $ID_LOG) {
    global $CONF, $conn;
    $REF_NUMBER = trim($REJECT['REF_NUMBER']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($REJECT['REF_NUMBER']['_v'])) . "'";
    $NO_CONT = trim($REJECT['NO_CONT']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($REJECT['NO_CONT']['_v'])) . "'";
    $UR_REJECT = trim($REJECT['UR_REJECT']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($REJECT['UR_REJECT']['_v'])) . "'";
    $TGL_REJECT = trim($REJECT['TGL_REJECT']['_v']) == "" ? "NULL" : "STR_TO_DATE('" . strtoupper(trim($REJECT['TGL_REJECT']['_v'])) . "','%Y%m%d')";

    $SQL = "INSERT INTO t_reject (REF_NUMBER, NO_CONT, UR_REJECT, TGL_REJECT, TGL_STATUS, ID_LOG)
            VALUES (" . $REF_NUMBER . "," . $NO_CONT . ", " . $UR_REJECT . ", " . $TGL_REJECT . ", NOW(), '" . $ID_LOG . "')";
    echo $SQL . '<hr>';
    $Execute = $conn->execute($SQL);
}

?>
