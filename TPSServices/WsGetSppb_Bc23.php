<?php

set_time_limit(3600);
require_once("config.php");
$CONF['url.wsdl'] = 'http://103.29.187.109/TPSServices/services.php';
$method = 'GetSppb_Bc23';
$KdAPRF = 'GETBC23PERMIT';
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

            $SQL = "SELECT A.NO_DOK_INOUT, DATE_FORMAT(A.TGL_DOK_INOUT,'%d%m%Y') AS TGL_DOK_INOUT, A.NPWP_CONSIGNEE, A.ID
                    FROM t_request_custimp_hdr A 
                    WHERE A.NO_DOK_INOUT IS NOT NULL
                          AND A.TGL_DOK_INOUT IS NOT NULL
                          AND A.NPWP_CONSIGNEE IS NOT NULL
                          AND A.KD_DOK_INOUT = '2'
                          AND A.KD_STATUS = '200'
                          AND A.KD_TPS = '" . $KD_TPS . "'
                          AND A.KD_GUDANG = '" . $KD_GUDANG . "'
                    ORDER BY A.TGL_STATUS ASC";
            $QueryRequest = $conn->query($SQL);
            if ($QueryRequest->size() > 0) {
                while ($QueryRequest->next()) {
                    $NO_DOK_INOUT = $QueryRequest->get("NO_DOK_INOUT");
                    $TGL_DOK_INOUT = $QueryRequest->get("TGL_DOK_INOUT");
                    $NPWP_CONSIGNEE = $QueryRequest->get("NPWP_CONSIGNEE");
                    $ID = $QueryRequest->get("ID");

                    /*$xml = '<?xml version="1.0" encoding="utf-8"?>
                            <soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
                              <soap:Body>
                                <GetSppb_Bc23 xmlns="http://services.beacukai.go.id/">
                                  <UserName>' . $USERNAME_TPSONLINE_BC . '</UserName>
                                  <Password>' . $PASSWORD_TPSONLINE_BC . '</Password>
                                  <No_Sppb>' . $NO_DOK_INOUT . '</No_Sppb>
                                  <Tgl_Sppb>' . $TGL_DOK_INOUT . '</Tgl_Sppb>
                                  <NPWP_Imp>' . $NPWP_CONSIGNEE . '</NPWP_Imp>
                                </GetSppb_Bc23>
                              </soap:Body>
                            </soap:Envelope>';*/
					$xml = '<?xml version="1.0" encoding="utf-8"?>
							<soapenv:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ser="http://services.beacukai.go.id/">
						   <soapenv:Header/>
						   <soapenv:Body>
							  <ser:GetSppb_Bc23 soapenv:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/">
								 <UserName xsi:type="xsd:string">' . $USERNAME_TPSONLINE_BC . '</UserName>
								 <Password xsi:type="xsd:string">' . $PASSWORD_TPSONLINE_BC . '</Password>
								 <No_Sppb xsi:type="xsd:string">' . $NO_DOK_INOUT . '</No_Sppb>
								 <Tgl_Sppb xsi:type="xsd:string">' . $TGL_DOK_INOUT . '</Tgl_Sppb>
								 <NPWP_Imp xsi:type="xsd:string">' . $NPWP_CONSIGNEE . '</NPWP_Imp>
							  </ser:GetSppb_Bc23>
						   </soapenv:Body>
						</soapenv:Envelope>';
                    $Send = $main->SendCurl($xml, $CONF['url.wsdl'], $SOAPAction, $CONF['proxyhost'] . ":" . $CONF['proxyport']);
                    echo '<pre>';
                    print_r($Send);
                    echo '</pre>';
                    if ($Send['response'] != '') {
                        //$arr1 = 'GetSppb_Bc23Response';
						$arr1 = 'ns1:GetSppb_Bc23Response';
                        $arr2 = 'GetSppb_Bc23Result';
                        $response = xml2ary($Send['response']);
                        //$response = $response['soap:Envelope']['_c']['soap:Body']['_c'][$arr1]['_c'][$arr2]['_v'];
						$response = $response['SOAP-ENV:Envelope']['_c']['SOAP-ENV:Body']['_c'][$arr1]['_c'][$arr2]['_v'];
                        echo '<br>';
                        echo '<pre>';
                        print_r($response);
                        echo '</pre>';

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
            $SQL = "CALL create_log_services('" . $CONF['url.wsdl'] . "','" . $method . "','" . str_replace("'", "''", $xml) . "','" . str_replace("'", "''", $response) . "')";
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