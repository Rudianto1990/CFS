<?php

ob_start();
// call library
require_once ('config.php' );
require_once ($CONF['root.dir'] . 'Libraries/nusoap/nusoap.php' );
require_once ($CONF['root.dir'] . 'Libraries/xml2array.php' );

// create instance
$server = new soap_server();

// initialize WSDL support
$server->configureWSDL('TPSOnline', 'urn:TPSOnlinewsdl');

// place schema at namespace with prefix tns
$server->wsdl->schemaTargetNamespace = 'urn:TPSOnlinewsdl';

// register method	
$server->register('HelloWorld', // method name
        array('string' => 'xsd:string'),
        // input parameter
        array('return' => 'xsd:string'), // output
        'urn:HelloWorldwsdl', // namespace
        'urn:TPSOnline', // soapaction
        'rpc', // style
        'encoded', // use
        'HelloWorld'// documentation
);

$server->register('sendMasterBarangKemasan', // method name
        array('string' => 'xsd:string', 'string0' => 'xsd:string', 'string1' => 'xsd:string'),
        // input parameter
        array('return' => 'xsd:string'), // output
        'urn:sendMasterBarangKemasanwsdl', // namespace
        'urn:TPSOnline', // soapaction
        'rpc', // style
        'encoded', // use
        'Pengiriman master barang kemasan impor/ekspor'// documentation
);

$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
$server->service($HTTP_RAW_POST_DATA);

function HelloWorld($string) {
    //$return = "Hello " . $string;
    $return = '<?xml version="1.0" encoding="UTF-8"?>';
    $return .= '<DOCUMENT>';
    $return .= '<LICENSE>';
    $return .= '<RESPON>DATA TIDAK ADA</RESPON>';
    $return .= '</LICENSE>';
    $return .= '</DOCUMENT>';
    return $return;
}

function sendMasterBarangKemasan($string, $string0, $string1) {
    global $CONF, $conn;
    $conn->connect();
    $userName = $string;
    $password = $string0;
    $xml = str_replace('&', ' ', $string1);

    $IDLogServices = insertLogServices($userName, $xml, '', '', 'sendMasterBarang');

    $checkUser = checkUser($userName, $password, $IDLogServices);
    if (!$checkUser['return']) {
        $conn->disconnect();
        $return = $checkUser['message'];
        return $return;
    }

    if ($xml != '') {
        $xml = xml2ary($xml);
        $DOCUMENT = $xml['DOCUMENT']['_c']['COCOKMS'];
        $countDocument = count($DOCUMENT);
        if ($countDocument > 1) {
            for ($c = 0; $c < $countDocument; $c++) {
                $DocumentCOCOKMS = InsertDocumentCOCOKMS($DOCUMENT[$c]['_c'], $IDLogServices);
                if (!$DocumentCOCOKMS['return']) {
                    $return = $DocumentCOCOKMS['message'];
                    $conn->disconnect();
                    return $return;
                }
            }
        } elseif ($countDocument == 1) {
            $DocumentCOCOKMS = InsertDocumentCOCOKMS($DOCUMENT['_c'], $IDLogServices);
            if (!$DocumentCOCOKMS['return']) {
                $return = $DocumentCOCOKMS['message'];
                $conn->disconnect();
                return $return;
            }
        }
        $return = $DocumentCOCOKMS['return'] ? 'true' : 'false';
    } else {
        $return = '<?xml version="1.0" encoding="UTF-8"?>';
        $return .= '<DOCUMENT>';
        $return .= '<RESPON>string1 BELUM TERDEFINISI</RESPON>';
        $return .= '</DOCUMENT>';
    }
    $xmlResponse = $DocumentCOCOKMS['message'] != '' ? $DocumentCOCOKMS['message'] : $return;
    updateLogServices($IDLogServices, $xmlResponse, $remarks);

    $conn->disconnect();
    return $return;
}

function InsertDocumentCOCOKMS($data, $IDLogServices) {
    global $CONF, $conn;
    //HEADER
    $HEADER = $data['HEADER']['_c'];
    $KD_DOK = checkData($HEADER['KD_DOK']['_v']);
    $KD_TPS = checkData($HEADER['KD_TPS']['_v']);
    $NM_ANGKUT = checkData($HEADER['NM_ANGKUT']['_v']);
    $NO_VOY_FLIGHT = checkData($HEADER['NO_VOY_FLIGHT']['_v']);
    $CALL_SIGN = checkData($HEADER['CALL_SIGN']['_v']);
    $TGL_TIBA = checkData($HEADER['TGL_TIBA']['_v']);
    $KD_GUDANG = checkData($HEADER['KD_GUDANG']['_v']);
    $REF_NUMBER = checkData($HEADER['REF_NUMBER']['_v']);

    switch ($KD_DOK) {
        case "'1'": // COARRI DISCHARGE
            $KD_ASAL_BRG = '1';
            break;
        case "'2'": // COARRI LOADING
            $KD_ASAL_BRG = '3';
            break;
        case "'3'": // CODECO IMPOR
            $KD_ASAL_BRG = '1';
            break;
        case "'4'": // CODECO EKSPOR
            $KD_ASAL_BRG = '3';
            break;
        case "'5'": // GATE IN LINI 2 (IMPOR)
            $KD_ASAL_BRG = '2';
            break;
        case "'6'": // GATE OUT LINI 2 (IMPOR)
            $KD_ASAL_BRG = '2';
            break;
        case "'7'": // GATE IN LINI 2 (EKSPOR)
            $KD_ASAL_BRG = '4';
            break;
        case "'8'": // GATE OUT LINI 2 (EKSPOR)
            $KD_ASAL_BRG = '4';
            break;
    }

    $SQL = "SELECT ID FROM reff_kapal WHERE NAMA = " . $NM_ANGKUT . "";
    $Query = $conn->query($SQL);
    if ($Query->size() > 0) {
        $Query->next();
        $KD_ANGKUT = checkData($Query->get("ID"));
    } else {
        $KD_ANGKUT = checkData("");
    }

    $SQL = "SELECT ID FROM t_repohdr
            WHERE KD_ASAL_BRG = '" . $KD_ASAL_BRG . "'
                  AND KD_TPS = " . $KD_TPS . "
                  AND KD_GUDANG = " . $KD_GUDANG . "
                  AND NM_ANGKUT = " . $NM_ANGKUT . " 
                  AND NO_VOY_FLIGHT = " . $NO_VOY_FLIGHT . "
                  AND TGL_TIBA = " . $TGL_TIBA . "";
    $Query = $conn->query($SQL);
    if ($Query->size() > 0) {
        $Query->next();
        $ID = $Query->get("ID");
        $parameterArr = array("ID" => "'" . $ID . "'");
        $parameter = array();
        foreach ($parameterArr as $field => $value) {
            $parameter[] = $field . " = " . $value;
        }
    } else {
        $ID = '';
        $parameterArr = array();
        $parameter = array();
    }

    $dataArr = array();
    $dataArr = array("KD_ASAL_BRG" => "'" . $KD_ASAL_BRG . "'",
        "KD_TPS" => $KD_TPS,
        "KD_GUDANG" => $KD_GUDANG,
        "NM_ANGKUT" => $NM_ANGKUT,
        "NO_VOY_FLIGHT" => $NO_VOY_FLIGHT,
        "CALL_SIGN" => $CALL_SIGN,
        "TGL_TIBA" => $TGL_TIBA,
        "WK_REKAM" => 'NOW()',
        "KD_KAPAL" => $KD_ANGKUT
    );

    $InsertTRepoHdr = InsertUpdate('t_repohdr', $dataArr, $parameter);
    if (!$InsertTRepoHdr) {
        $return['return'] = false;
        $return['message'] = '<?xml version="1.0" encoding="UTF-8"?>';
        $return['message'] .= '<DOCUMENT>';
        $return['message'] .= '<RESPON>GAGAL INSERT/UPDATE t_repohdr.</RESPON>';
        $return['message'] .= '</DOCUMENT>';
        $logServices = updateLogServices($IDLogServices, $return['message'], 'GAGAL INSERT/UPDATE t_repohdr.');
        $conn->disconnect();
        return $return;
    }

    if ($ID == "") {
        $ID = mysql_insert_id();
    }

    //DETIL
    $DETIL = $data['DETIL']['_c'];
    $KMS = $DETIL['KMS'];
    $countKemasan = count($KMS);
    if ($countKemasan > 1) {
        for ($d = 0; $d < $countKemasan; $d++) {
            $DocumentCOCOKMS = InsertCocoKms($ID, $KD_DOK, $KMS[$d]['_c'], $IDLogServices);
            if (!$DocumentCOCOKMS['return']) {
                $return = $DocumentCOCOKMS['message'];
                $conn->disconnect();
                return $return;
            }
        }
    } elseif ($countKemasan == 1) {
        $DocumentCOCOKMS = InsertCocoKms($ID, $KD_DOK, $KMS['_c'], $IDLogServices);
        if (!$DocumentCOCOKMS['return']) {
            $return = $DocumentCOCOKMS['message'];
            $conn->disconnect();
            return $return;
        }
    }
    $return = $DocumentCOCOKMS;
    return $return;
}

function InsertCocoKms($ID, $KD_DOK, $data, $IDLogServices) {
    global $CONF, $conn;
    $NO_BL_AWB = checkData($data['NO_BL_AWB']['_v']);
    $TGL_BL_AWB = checkData($data['TGL_BL_AWB']['_v'], 'date');
    $NO_MASTER_BL_AWB = checkData($data['NO_MASTER_BL_AWB']['_v']);
    $TGL_MASTER_BL_AWB = checkData($data['TGL_MASTER_BL_AWB']['_v'], 'date');
    $ID_CONSIGNEE = checkData($data['ID_CONSIGNEE']['_v']);
    $CONSIGNEE = checkData($data['CONSIGNEE']['_v']);
    $BRUTO = checkData($data['BRUTO']['_v']);
    $NO_BC11 = checkData($data['NO_BC11']['_v']);
    $TGL_BC11 = checkData($data['TGL_BC11']['_v'], 'date');
    $NO_POS_BC11 = checkData($data['NO_POS_BC11']['_v']);
    $CONT_ASAL = checkData($data['CONT_ASAL']['_v']);
    $SERI_KEMAS = checkData($data['SERI_KEMAS']['_v']);
    $KD_KEMAS = checkData($data['KD_KEMAS']['_v']);
    $JML_KEMAS = checkData($data['JML_KEMAS']['_v']);
    $KD_TIMBUN = checkData($data['KD_TIMBUN']['_v']);
    $KD_DOK_INOUT = checkData($data['KD_DOK_INOUT']['_v']);
    $NO_DOK_INOUT = checkData($data['NO_DOK_INOUT']['_v']);
    $TGL_DOK_INOUT = checkData($data['TGL_DOK_INOUT']['_v'], 'date');
    $WK_INOUT = checkData($data['WK_INOUT']['_v'], 'datetime');
    $KD_SAR_ANGKUT_INOUT = checkData($data['KD_SAR_ANGKUT_INOUT']['_v']);
    $NO_POL = checkData($data['NO_POL']['_v']);
    $PEL_MUAT = checkData($data['PEL_MUAT']['_v']);
    $PEL_TRANSIT = checkData($data['PEL_TRANSIT']['_v']);
    $PEL_BONGKAR = checkData($data['PEL_BONGKAR']['_v']);
    $GUDANG_TUJUAN = checkData($data['GUDANG_TUJUAN']['_v']);
    $KODE_KANTOR = checkData($data['KODE_KANTOR']['_v']);
    $NO_DAFTAR_PABEAN = checkData($data['NO_DAFTAR_PABEAN']['_v']);
    $TGL_DAFTAR_PABEAN = checkData($data['TGL_DAFTAR_PABEAN']['_v'], 'date');
    $NO_SEGEL_BC = checkData($data['NO_SEGEL_BC']['_v']);
    $TGL_SEGEL_BC = checkData($data['TGL_SEGEL_BC']['_v'], 'date');
    $NO_IJIN_TPS = checkData($data['NO_IJIN_TPS']['_v']);
    $TGL_IJIN_TPS = checkData($data['TGL_IJIN_TPS']['_v'], 'date');

    $SQL = "SELECT KD_KEMASAN, NO_BL_AWB, SERI
            FROM t_repokms
            WHERE KD_REPOHDR = '" . $ID . "' 
                  AND KD_KEMASAN = " . $KD_KEMAS . "
                  AND NO_BL_AWB = " . $NO_BL_AWB . "";
    $Query = $conn->query($SQL);
    if ($Query->size() > 0) {
        $Query->next();
        $SERI = $Query->get("SERI");
        $parameterArr = array("KD_REPOHDR" => "'" . $ID . "'", "KD_KEMASAN" => $KD_KEMAS, "NO_BL_AWB" => $NO_BL_AWB);
        $parameter = array();
        foreach ($parameterArr as $field => $value) {
            $parameter[] = $field . " = " . $value;
        }
    } else {
        $parameterArr = array();
        $parameter = array();
        $SQL = "SELECT MAX(SERI) + 1 AS SERI
                FROM t_repokms 
                WHERE KD_REPOHDR = '" . $ID . "'";
        $Query = $conn->query($SQL);
        $Query->next();
        $SERI = $Query->get("SERI");
    }

    $dataImportir = getData(array('ID'), 't_organisasi', 'NPWP', "=", $ID_CONSIGNEE . " AND KD_TIPE_ORGANISASI = 'CONS'");
    if ($dataImportir['SIZE_DATA'] == 0) {
        $dataImportir = getData(array('ID'), 't_organisasi', 'NAMA', "=", $CONSIGNEE . " AND KD_TIPE_ORGANISASI = 'CONS'");
        if ($dataImportir['SIZE_DATA'] == 0) {
            $SQL = "INSERT INTO t_organisasi (NPWP, NAMA, KD_TIPE_ORGANISASI)
                    VALUES (" . $ID_CONSIGNEE . ", " . $CONSIGNEE . ", 'CONS')";
            $Execute = $conn->execute($SQL);
            $KD_ORG_CONSIGNEE = mysql_insert_id();
        } else {
            $KD_ORG_CONSIGNEE = $dataImportir['ID'];
        }
    } else {
        $KD_ORG_CONSIGNEE = $dataImportir['ID'];
    }

    $dataArr = array();
    $dataArr = array("KD_REPOHDR" => "'" . $ID . "'",
        "SERI" => "'" . $SERI . "'",
        "KD_KEMASAN" => $KD_KEMAS,
        "JUMLAH" => $JML_KEMAS,
        "ID_CONT_ASAL" => 'NULL',
        "NO_CONT_ASAL" => $CONT_ASAL,
        "BRUTO" => $BRUTO,
        "NO_SEGEL" => 'NULL',
        "KONDISI_SEGEL" => 'NULL',
        "NO_BL_AWB" => $NO_BL_AWB,
        "TGL_BL_AWB" => $TGL_BL_AWB,
        "NO_MASTER_BL_AWB" => $NO_MASTER_BL_AWB,
        "TGL_MASTER_BL_AWB" => $TGL_MASTER_BL_AWB,
        "NO_POS_BC11" => $NO_POS_BC11,
        "KD_ORG_CONSIGNEE" => $KD_ORG_CONSIGNEE,
        "KD_TIMBUN_KAPAL" => 'NULL',
        "KD_TIMBUN" => $KD_TIMBUN,
        "KD_PEL_MUAT" => $PEL_MUAT,
        "KD_PEL_TRANSIT" => $PEL_TRANSIT,
        "KD_PEL_BONGKAR" => $PEL_BONGKAR,
        "WK_REKAM" => 'NOW()'
    );

    $dataArrGateIn = array();
    $dataArrGateIn = array(
        "KD_DOK_IN" => $KD_DOK_INOUT,
        "NO_DOK_IN" => $NO_DOK_INOUT,
        "TGL_DOK_IN" => $TGL_DOK_INOUT,
        "WK_IN" => $WK_INOUT,
        "KD_CONT_STATUS_IN" => 'NULL',
        "KD_SARANA_ANGKUT_IN" => $KD_SAR_ANGKUT_INOUT,
        "NO_POL_IN" => $NO_POL,);

    $dataArrGateOut = array();
    $dataArrGateOut = array(
        "KD_DOK_OUT" => $KD_DOK_INOUT,
        "NO_DOK_OUT" => $NO_DOK_INOUT,
        "TGL_DOK_OUT" => $TGL_DOK_INOUT,
        "WK_OUT" => $WK_INOUT,
        "KD_CONT_STATUS_OUT" => 'NULL',
        "KD_SARANA_ANGKUT_OUT" => $KD_SAR_ANGKUT_INOUT,
        "NO_POL_OUT" => $NO_POL,
        "KD_TPS_TUJUAN" => $TEST,
        "KD_GUDANG_TUJUAN" => $GUDANG_TUJUAN,
        "NO_DAFTAR_PABEAN" => $NO_DAFTAR_PABEAN,
        "TGL_DAFTAR_PABEAN" => $TGL_DAFTAR_PABEAN,
        "NO_SEGEL_BC" => $NO_SEGEL_BC,
        "TGL_SEGEL_BC" => $TGL_SEGEL_BC,
        "NO_IJIN_TPS" => $NO_IJIN_TPS,
        "TGL_IJIN_TPS" => $TGL_IJIN_TPS,);

    switch ($KD_DOK) {
        case "'1'": //COARRI DISCHARGE
        case "'4'": //CODECO EKSPOR
        case "'5'": //GATE IN IMPOR LINI 2
        case "'7'": //GATE IN EKSPOR LINI 2
            $dataArrMerge = array_merge($dataArr, $dataArrGateIn);
            break;
        case "'2'": //COARRI LOADING
        case "'3'": //CODECO IMPOR
        case "'6'": //GATE OUT IMPOR LINI 2
        case "'8'": //GATE OUT EKSPOR LINI 2
            $dataArrMerge = array_merge($dataArr, $dataArrGateOut);
            break;
    }

    $InsertTRepoKms = InsertUpdate('t_repokms', $dataArrMerge, $parameter);
    if (!$InsertTRepoKms) {
        $return['return'] = false;
        $return['message'] = '<?xml version="1.0" encoding="UTF-8"?>';
        $return['message'] .= '<DOCUMENT>';
        $return['message'] .= '<RESPON>GAGAL INSERT/UPDATE t_repokms.</RESPON>';
        $return['message'] .= '</DOCUMENT>';
        $logServices = updateLogServices($IDLogServices, $return['message'], 'GAGAL INSERT/UPDATE t_repokms.');
        $conn->disconnect();
        return $return;
    } else {
        $return['return'] = true;
        $return['message'] = '';
    }
    return $return;
}

function InsertUpdate($tableName, $dataArr = array(), $parameter = array()) {
    global $CONF, $conn;
    $fieldName = array();
    $ValueData = array();
    $updated = array();
    if (count($parameter) == 0) {
        foreach ($dataArr as $field => $value) {
            $fieldName[] = $field;
            $ValueData[] = $value;
        }
        $SQL = "INSERT INTO " . $tableName . "(" . implode(", ", $fieldName) . ") 
                VALUES (" . implode(", ", $ValueData) . ")";
        $Execute = $conn->execute($SQL);
        if (!$Execute) {
            echo 'error : ' . $tableName . ', SQL : ' . $SQL;
        }
    } else {
        foreach ($dataArr as $field => $value) {
            $updated[] = $field . " = " . $value;
        }
        $SQL = "UPDATE " . $tableName . " SET " . implode(", ", $updated) . "
                WHERE " . implode(" AND ", $parameter) . "";
        $Execute = $conn->execute($SQL);
        if (!$Execute) {
            echo 'error : ' . $tableName . ', SQL : ' . $SQL;
        }
    }
    /* print_r($dataArr); 
      echo $SQL;
      echo '<br><hr>'; */
    return $Execute;
}

function checkData($data, $type = "text") {
    global $CONF, $conn;
    if (trim(strtoupper($data)) == "") {
        $return = "NULL";
    } else {
        switch ($type) {
            case "text":
                $return = "'" . trim(strtoupper($data)) . "'";
                break;
            case "date":
                $return = "DATE_FORMAT('" . trim(strtoupper($data)) . "','%Y%m%d')";
                break;
            case "datetime":
                $return = "DATE_FORMAT('" . trim(strtoupper($data)) . "','%Y%m%d%H%i%s')";
                break;
        }
    }
    return $return;
}

function checkUser($user, $password, $IDLogServices) {
    global $CONF, $conn;
    $SQL = "SELECT B.KD_TIPE_ORGANISASI
            FROM app_user_ws A INNER JOIN t_organisasi B ON A.KD_ORGANISASI = B.ID
            WHERE A.USERLOGIN = '" . trim($user) . "'
                  AND A.PASSWORD = '" . trim($password) . "'";
    $Query = $conn->query($SQL);
    if ($Query->size() == 0) {
        $return['return'] = false;
        $return['message'] = '<?xml version="1.0" encoding="UTF-8"?>';
        $return['message'] .= '<DOCUMENT>';
        $return['message'] .= '<RESPON>USERNAME ATAU PASSWORD SALAH.</RESPON>';
        $return['message'] .= '</DOCUMENT>';
        $logServices = updateLogServices($IDLogServices, $return['message'], 'USERNAME ATAU PASSWORD SALAH.');
    } else {
        $return['return'] = true;
    }
    return $return;
}

function getData($fieldName, $tableName, $where = "", $operator = "", $value = "", $order = "", $sort = "ASC") {
    global $CONF, $conn;
    $field = implode(",", $fieldName);
    $SQL = "SELECT " . $field . " FROM " . $tableName . "";
    if ($where != "") {
        $SQL .= " WHERE " . $where . " " . $operator . " " . $value . "";
    }
    if ($order != "") {
        $SQL .= " ORDER BY  " . $order . " " . $sort;
    }
//echo $SQL."<br>";
    $Query = $conn->query($SQL);
    $data["SIZE_DATA"] = $Query->size();
    while ($Query->next()) {
        foreach ($fieldName as $item) {
            $data[$item] = $Query->get($item);
        }
    }
    return $data;
}

function insertLogServices($userName, $xmlRequest, $xmlResponse, $remarks, $method = '') {
    global $CONF, $conn;
    $ipAddress = getIP();
    $method = $method == '' ? 'NULL' : "'" . $method . "'";
    $userName = $userName == '' ? 'NULL' : "'" . $userName . "'";
    $xmlRequest = $xmlRequest == '' ? 'NULL' : "'" . $xmlRequest . "'";
    $xmlResponse = $xmlResponse == '' ? 'NULL' : "'" . $xmlResponse . "'";
    $remarks = $remarks == '' ? 'NULL' : "'" . $remarks . "'";
    $SQL = "INSERT INTO app_log_server (METHOD, USERNAME, XML_REQUEST, XML_RESPONSE, IPADDRESS, REMARKS, WK_REKAM)
            VALUES (" . $method . ", " . $userName . ", " . $xmlRequest . ", " . $xmlResponse . ", '" . $ipAddress . "', " . $remarks . ", NOW())";
    $Execute = $conn->execute($SQL);
    $ID = mysql_insert_id();
    return $ID;
}

function updateLogServices($ID, $xmlResponse, $remarks) {
    global $CONF, $conn;
    $xmlResponse = $xmlResponse == '' ? 'NULL' : "'" . $xmlResponse . "'";
    $remarks = $remarks == '' ? 'NULL' : "'" . $remarks . "'";
    $SQL = "UPDATE app_log_server SET XML_RESPONSE = " . $xmlResponse . ", REMARKS = " . $remarks . "
            WHERE ID = '" . $ID . "'";
    $Execute = $conn->execute($SQL);
}

function replace($text) {
    $text = str_replace("-", "", $text);
    $text = str_replace(".", "", $text);
    $text = str_replace(" ", "", $text);
    return $text;
}

function getIP($type = 0) {
    if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown"))
        $ip = getenv("HTTP_CLIENT_IP");
    else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown"))
        $ip = getenv("REMOTE_ADDR");
    else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown"))
        $ip = getenv("HTTP_X_FORWARDED_FOR");
    else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown"))
        $ip = $_SERVER['REMOTE_ADDR'];
    else {
        $ip = "unknown";
        return $ip;
    }
    if ($type == 1) {
        return md5($ip);
    }
    if ($type == 0) {
        return $ip;
    }
}
?>

