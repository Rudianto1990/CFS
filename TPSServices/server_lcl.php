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
$server->register('GetUbahStatus', // method name
      array('string' => 'xsd:string', 'string0' => 'xsd:string'),
              // input parameter
        array('return' => 'xsd:string'), // output
        'urn:GetUbahStatuswsdl', // namespace
        'urn:TPSOnline', // soapaction
        'rpc', // style
        'encoded', // use
        'GetUbahStatus'// documentation
);

$server->register('GetBilling', // method name
      array('string' => 'xsd:string', 'string0' => 'xsd:string'),
              // input parameter
        array('return' => 'xsd:string'), // output
        'urn:GetBillingwsdl', // namespace
        'urn:TPSOnline', // soapaction
        'rpc', // style
        'encoded', // use
        'GetBilling'// documentation
);

$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
$server->service($HTTP_RAW_POST_DATA);


function GetUbahStatus($string, $string0) {
    
global $CONF, $conn;
$conn->connect();
$username = $string;
$password = $string0;


	$IDLogServices = insertLogServices($username, '', '', '', 'SENDPERUBAHANLCL');

$SQLUSER = "SELECT B.KD_TPS, B.KD_GUDANG
            FROM app_user_ws A INNER JOIN t_organisasi B ON A.KD_ORGANISASI = B.ID
            WHERE A.USERLOGIN = '" . $username . "'
                  AND A.PASSWORD = '" . $password . "'";
$QueryUser = $conn->query($SQLUSER);
	
    if ($QueryUser->size() == 0) {
        $message = '<?xml version="1.0" encoding="UTF-8"?>';
        $message .= '<DOCUMENT>';
        $message .= '<RESPON>salah oi</RESPON>';
        $message .= '</DOCUMENT>';
        $return = $message;
        $logServices = updateLogServices($IDLogServices, $message, 'USERNAME ATAU PASSWORD SALAH.');
    } 
	else 
	{
		$QueryUser->next();
        $KD_GUDANG = $QueryUser->get("KD_GUDANG");

$SQLHEADER = "SELECT A.NO_PERMOHONAN_CFS, A.KD_TPS_ASAL, A.KD_TPS_TUJUAN, A.KD_GUDANG_ASAL, A.KD_GUDANG_TUJUAN,
        B.NM_LENGKAP,B.KD_ORGANISASI,C.NAMA,C.ALAMAT,C.EMAIL,C.NPWP,C.NOTELP,
        C.NOFAX,A.NAMA_KAPAL,A.CALL_SIGN,A.NO_VOY_FLIGHT,A.TGL_TIBA,A.NO_BC11,
        A.TGL_BC11, A.TGL_PERMOHONAN_CFS 
        FROM t_ubah_status A INNER JOIN app_user B ON A.ID_USER=B.ID INNER JOIN t_organisasi C ON B.KD_ORGANISASI=C.ID
        WHERE A.KD_STATUS='200' AND A.KD_GUDANG_TUJUAN='".$KD_GUDANG."'";
$QueryHeader = $conn->query($SQLHEADER);
 if ($QueryHeader->size() > 0) {


	while ($QueryHeader->next()) {
$message = '<?xml version="1.0" encoding="UTF-8"?>';
$message .= '<DOCUMENT>';
$message .= '<LOADPERMOHONANCFS>';
$message .= '<HEADER>';
$message .= '<NO_PERMOHONAN_CFS>'.$QueryHeader->get("NO_PERMOHONAN_CFS").'</NO_PERMOHONAN_CFS>';
$message .= '<TGL_PERMOHONAN_CFS>'.$QueryHeader->get("TGL_PERMOHONAN_CFS").'</TGL_PERMOHONAN_CFS>';
$message .= '<KD_TPS_ASAL>'.$QueryHeader->get("KD_TPS_ASAL").'</KD_TPS_ASAL>';
$message .= '<KD_TPS_TUJUAN>'.$QueryHeader->get("KD_TPS_TUJUAN").'</KD_TPS_TUJUAN>';
$message .= '<KD_GUDANG_ASAL>'.$QueryHeader->get("KD_GUDANG_ASAL").'</KD_GUDANG_ASAL>';
$message .= '<KD_GUDANG_TUJUAN>'.$QueryHeader->get("KD_GUDANG_TUJUAN").'</KD_GUDANG_TUJUAN>';
$message .= '<NM_LENGKAP>'.$QueryHeader->get("NM_LENGKAP").'</NM_LENGKAP>';
$message .= '<NAMA_ORGANISASI>'.$QueryHeader->get("NAMA_ORGANISASI").'</NAMA_ORGANISASI>';
$message .= '<EMAIL>'.$QueryHeader->get("EMAIL").'</EMAIL>';
$message .= '<NPWP>'.$QueryHeader->get("NPWP").'</NPWP>';
$message .= '<NOTELP>'.$QueryHeader->get("NOTELP").'</NOTELP>';
$message .= '<NOFAX>'.$QueryHeader->get("NOFAX").'</NOFAX>';
$message .= '<NAMA_KAPAL>'.$QueryHeader->get("NAMA_KAPAL").'</NAMA_KAPAL>';
$message .= '<CALL_SIGN>'.$QueryHeader->get("CALL_SIGN").'</CALL_SIGN>';
$message .= '<NO_VOY_FLIGHT>'.$QueryHeader->get("NO_VOY_FLIGHT").'</NO_VOY_FLIGHT>';
$message .= '<TGL_TIBA>'.$QueryHeader->get("TGL_TIBA").'</TGL_TIBA>';
$message .= '<NO_BC11>'.$QueryHeader->get("NO_BC11").'</NO_BC11>';
$message .= '<TGL_BC11>'.$QueryHeader->get("TGL_BC11").'</TGL_BC11>';
$message .= '</HEADER>';
$message .= '<DETAIL>';

$SQLKONTAINER = "SELECT NO_CONT,KD_CONT_UKURAN,WK_REKAM FROM t_no_kontainer WHERE NO_UBAH_STATUS='".$QueryHeader->get("NO_UBAH_STATUS")."'";
$QueryKontainer = $conn->query($SQLKONTAINER);
while ($QueryKontainer->next()) {
$message .= '<KONTAINER>';	
$message .= '<NO_CONT>'.$QueryKontainer->get("NO_CONT").'</NO_CONT>';	
$message .= '<KD_CONT_UKURAN>'.$QueryKontainer->get("KD_CONT_UKURAN").'</KD_CONT_UKURAN>';	
$message .= '<WK_REKAM>'.$QueryKontainer->get("WK_REKAM").'</WK_REKAM>';	
$message .= '</KONTAINER>';	
}
$message .= '</DETAIL>';
$message .= '</LOADPERMOHONANCFS>';
$message .= '</DOCUMENT>';
	}		

$return = $message;
 }
else
{
		$message = '<?xml version="1.0" encoding="UTF-8"?>';
        $message .= '<DOCUMENT>';
        $message .= '<LOADPERMOHONANCFS>DATA TIDAK ADA.</LOADPERMOHONANCFS>';
        $message .= '</DOCUMENT>';
		$return = $message;
        $logServices = updateLogServices($IDLogServices, $message, 'DATA TIDAK ADA.');
}		
		}

    $xmlRequest = $message != '' ? $message : $return;
	$remarks	= 'DATA BERHASIL DIKIRIM';
    updateLogServices($IDLogServices, $xmlRequest, $remarks);

    $conn->disconnect();
    return $string;
	
}

function GetBilling($string, $string0) {
    
	global $CONF, $conn;
	$conn->connect();
	$username = $string;
	$password = $string0;

	$IDLogServices = insertLogServices($username, '', '', '', 'SENDPERUBAHANLCL');

	$SQLUSER = "SELECT B.KD_TPS FROM app_user_ws A INNER JOIN t_organisasi B ON A.KD_ORGANISASI = B.ID WHERE A.USERLOGIN = '" . $username . "' AND A.PASSWORD = '" . $password . "'";
	$QueryUser = $conn->query($SQLUSER);
	
    if ($QueryUser->size() == 0) {
        $message = '<?xml version="1.0" encoding="UTF-8"?>';
        $message .= '<DOCUMENT>';
        $message .= '<RESPON>USERNAME ATAU PASSWORD SALAH.</RESPON>';
        $message .= '</DOCUMENT>';
        $return = $message;
        $logServices = updateLogServices($IDLogServices, $message, 'USERNAME ATAU PASSWORD SALAH.');
    } 
	else 
	{
		$QueryUser->next();
        $KD_TPS = $QueryUser->get("KD_TPS");

		$SQLHEADER = "SELECT A.NO_UBAH_STATUS, A.KD_GUDANG_ASAL, A.KD_GUDANG_TUJUAN,
			B.NM_LENGKAP,B.KD_ORGANISASI,C.NAMA,C.ALAMAT,C.EMAIL,C.NPWP,C.NOTELP,
			C.NOFAX,A.NAMA_KAPAL,A.CALL_SIGN,A.NO_VOY_FLIGHT,A.TGL_TIBA,A.NO_BC11,
			A.TGL_BC11, A.TGL_UBAH_STATUS 
			FROM t_ubah_status A INNER JOIN app_user B ON A.ID_USER=B.ID INNER JOIN t_organisasi C ON B.KD_ORGANISASI=C.ID
			INNER JOIN reff_gudang E ON A.KD_GUDANG_ASAL=E.KD_GUDANG
			WHERE A.KD_STATUS='200' AND E.KD_TPS='".$KD_TPS."'";
		$QueryHeader = $conn->query($SQLHEADER);
		if ($QueryHeader->size() > 0) {
			while ($QueryHeader->next()) {
				$message = '<?xml version="1.0" encoding="UTF-8"?>';
				$message .= '<DOCUMENT>';
				$message .= '<BILLING>';
				$message .= '<HEADER>';
				$message .= '<NO_UBAH_STATUS>'.$QueryHeader->get("NO_UBAH_STATUS").'</NO_UBAH_STATUS>';
				$message .= '</HEADER>';
				$message .= '<DETAIL>';
				
				$SQLKONTAINER = "SELECT NO_CONT,KD_CONT_UKURAN,WK_REKAM FROM t_no_kontainer WHERE NO_UBAH_STATUS='".$QueryHeader->get("NO_UBAH_STATUS")."'";
				$QueryKontainer = $conn->query($SQLKONTAINER);
				while ($QueryKontainer->next()) {
					$message .= '<KONTAINER>';	
					$message .= '<NO_CONT>'.$QueryKontainer->get("NO_CONT").'</NO_CONT>';	
					$message .= '<KD_CONT_UKURAN>'.$QueryKontainer->get("KD_CONT_UKURAN").'</KD_CONT_UKURAN>';	
					$message .= '<WK_REKAM>'.$QueryKontainer->get("WK_REKAM").'</WK_REKAM>';	
					$message .= '</KONTAINER>';	
				}
				$message .= '</DETAIL>';
				$message .= '</BILLING>';
				$message .= '</DOCUMENT>';
			}		
			$return = $message;
		}
		else
		{
			$message = '<?xml version="1.0" encoding="UTF-8"?>';
			$message .= '<DOCUMENT>';
			$message .= '<BILLING>DATA TIDAK ADA.</BILLING>';
			$message .= '</DOCUMENT>';
			$return = $message;
			$logServices = updateLogServices($IDLogServices, $message, 'DATA TIDAK ADA.');
		}		
	}
    $xmlRequest = $message != '' ? $message : $return;
	$remarks	= 'DATA BERHASIL DIKIRIM';
    updateLogServices($IDLogServices, $xmlRequest, $remarks);

    $conn->disconnect();
    return $return;
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

function updateLogServices($ID, $xmlRequest, $remarks) {
    global $CONF, $conn;
    $xmlRequest = $xmlRequest == '' ? 'NULL' : "'" . $xmlRequest . "'";
    $remarks = $remarks == '' ? 'NULL' : "'" . $remarks . "'";
    $SQL = "UPDATE app_log_server SET XML_REQUEST = " . $xmlRequest . ", REMARKS = " . $remarks . "
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

