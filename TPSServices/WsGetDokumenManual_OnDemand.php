<?php

set_time_limit(3600);
require_once("config.php");

$method = 'GetDokumenManual_OnDemand';
$KdAPRF = 'GETDOKMANUALBC';
$filename = $CONF['root.dir'] . "CheckScheduler/" . $method . ".txt";
$main = new main($CONF, $conn);
$CheckFile = $main->CheckFile($filename);
if (!$CheckFile) {
    $createFile = $main->createFile($filename);
    $main->connect();

    //BEGIN
    $SOAPAction = 'http://services.beacukai.go.id/' . $method;
    $SQL = "SELECT DISTINCT B.KD_TPS, C.KD_GUDANG, B.USERNAME_TPSONLINE_BC, B.PASSWORD_TPSONLINE_BC, 
                   A.KD_ORG_SENDER, A.KD_ORG_RECEIVER
            FROM app_setting A INNER JOIN t_organisasi B ON A.KD_ORG_RECEIVER = B.ID
                               INNER JOIN app_user C ON B.ID = C.KD_ORGANISASI
            WHERE A.KD_APRF = '" . $KdAPRF . "'
                  AND A.KD_STATUS = 'Y'
                  AND B.KD_TIPE_ORGANISASI IN ('TPS','TPS1','TPS2')";
    $Query = $conn->query($SQL);
    if ($Query->size() > 0) {
        while ($Query->next()) {
            $KD_TPS = $Query->get("KD_TPS");
            $KD_GUDANG = $Query->get("KD_GUDANG");
            $USERNAME_TPSONLINE_BC = $Query->get("USERNAME_TPSONLINE_BC");
            $PASSWORD_TPSONLINE_BC = $Query->get("PASSWORD_TPSONLINE_BC");
            $KD_ORG_SENDER = $Query->get("KD_ORG_SENDER");
            $KD_ORG_RECEIVER = $Query->get("KD_ORG_RECEIVER");

            $SQL = "SELECT A.KD_DOK_INOUT, A.NO_DOK_INOUT, DATE_FORMAT(A.TGL_DOK_INOUT,'%d%m%Y') AS TGL_DOK_INOUT, A.ID
                    FROM t_request_custimp_hdr A 
                    WHERE A.NO_DOK_INOUT IS NOT NULL
                          AND A.TGL_DOK_INOUT IS NOT NULL
                          AND A.KD_DOK_INOUT NOT IN ('1','19')
                          AND A.KD_STATUS = '200'
                          AND A.KD_TPS = '" . $KD_TPS . "'
                          AND A.KD_GUDANG = '" . $KD_GUDANG . "'
                    ORDER BY A.TGL_STATUS ASC";
            $QueryRequest = $conn->query($SQL);
            if ($QueryRequest->size() > 0) {
                while ($QueryRequest->next()) {
                    $KD_DOK_INOUT = $QueryRequest->get("KD_DOK_INOUT");
                    $NO_DOK_INOUT = $QueryRequest->get("NO_DOK_INOUT");
                    $TGL_DOK_INOUT = $QueryRequest->get("TGL_DOK_INOUT");
                    $ID = $QueryRequest->get("ID");

                    $xml = '<?xml version="1.0" encoding="utf-8"?>
                            <soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
                              <soap:Body>
                                <GetDokumenManual_OnDemand xmlns="http://services.beacukai.go.id/">
                                  <UserName>' . $USERNAME_TPSONLINE_BC . '</UserName>
                                  <Password>' . $PASSWORD_TPSONLINE_BC . '</Password>
                                  <KdDok>' . $KD_DOK_INOUT . '</KdDok>
                                  <NoDok>' . $NO_DOK_INOUT . '</NoDok>
                                  <TglDok>' . $TGL_DOK_INOUT . '</TglDok>
                                </GetDokumenManual_OnDemand>
                              </soap:Body>
                            </soap:Envelope>';
                    $Send = $main->SendCurl($xml, $CONF['url.wsdl'], $SOAPAction, $CONF['proxyhost'] . ":" . $CONF['proxyport']);
                    echo '<pre>';
                    print_r($Send);
                    echo '</pre>';
                    if ($Send['response'] != '') {
                        $arr1 = 'GetDokumenManual_OnDemandResponse';
                        $arr2 = 'GetDokumenManual_OnDemandResult';
                        $response = xml2ary($Send['response']);
                        $response = $response['soap:Envelope']['_c']['soap:Body']['_c'][$arr1]['_c'][$arr2]['_v'];
                        
                        $SQL = "INSERT INTO mailbox (SNRF, KD_APRF, KD_ORG_SENDER, KD_ORG_RECEIVER, STR_DATA, KD_STATUS, TGL_STATUS)
                                VALUES (NULL, '" . $KdAPRF . "','" . $KD_ORG_SENDER . "','" . $KD_ORG_RECEIVER . "','" . $response . "','100',NOW())";
                        $Execute = $conn->execute($SQL);

                        $SQL = "UPDATE t_request_custimp_hdr SET KD_STATUS = '400', TGL_STATUS = NOW() WHERE ID = '" . $ID . "'";
                        $Execute = $conn->execute($SQL);
                    } else {
                        $response = '';
                    }
                }
            } else {
                $response = 'Data request tidak ada.';
            }

            $SQL = "CALL create_log_services('" . $CONF['url.wsdl'] . "','" . $method . "','" . $xml . "','" . $response . "')";
            $Execute = $conn->execute($SQL);
        }
    } else {
        echo 'Data user TPS tidak ada.';
    }
    //END

    $main->connect(false);
    $main->removeFile($filename);
} else {
    echo 'Scheduler sedang berjalan, harap menghapus file ' . $method . '.txt yang ada difolder CheckScheduler.';
}
?>