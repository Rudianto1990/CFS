<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS");
header("Access-Control-Max-Age: 604800");
header("Access-Control-Allow-Headers: x-requested-with, Content-Type, origin, authorization, accept, soapaction"); 
ob_start();
// call library
require_once ('config.php' );
//require_once ($CONF['root.dir'].'Libraries/soaplib/nusoap.php');
require_once ($CONF['root.dir'] . 'Libraries/nusoap-lokal/lib/nusoap.php');
require_once ($CONF['root.dir'] . 'Libraries/xml2array.php' );

$wsdlglobal = 'CFSServices';

// create instance
$server = new soap_server();

// initialize WSDL support
$server->configureWSDL('CFSwsdl', 'urn:CFSwsdl');

// place schema at namespace with prefix tns
$server->wsdl->schemaTargetNamespace = 'urn:CFSwsdl';

// register method
$server->register('APP_GetLogin', // method name
        array('Username' => 'xsd:string', 'Password' => 'xsd:string', 'fStream' => 'xsd:string'), //input parameter
        array('return' => 'xsd:string'), // output
        'urn:APP_GetLoginwsdl', // namespace
        'urn:' . $wsdlglobal, // soapaction
        'rpc', // style
        'encoded', // use
        'APP_GetLogin -> json USERNAME,PASSWORD'// documentation
);

$server->register('APP_GetCustomer', // method name
        array('Username' => 'xsd:string', 'Password' => 'xsd:string', 'fStream' => 'xsd:string'), //input parameter
        array('return' => 'xsd:string'), // output
        'urn:APP_GetCustomerwsdl', // namespace
        'urn:' . $wsdlglobal, // soapaction
        'rpc', // style
        'encoded', // use
        'APP_GetCustomer -> json NPWP'// documentation
);

$server->register('APP_Register', // method name
        array('Username' => 'xsd:string', 'Password' => 'xsd:string', 'fStream' => 'xsd:string'), //input parameter
        array('return' => 'xsd:string'), // output
        'urn:APP_Registerwsdl', // namespace
        'urn:' . $wsdlglobal, // soapaction
        'rpc', // style
        'encoded', // use
        'APP_Register -> json NPWP,ID_ORGANISASI,NAMA,ALAMAT,NOTELP,NOFAX,EMAILORG,JENIS_ORGANISASI,USERLOGIN,PASSWORD,NM_LENGKAP,
        HANDPHONE,EMAIL,ROLE'// documentation
);

$server->register('MAIN_GetBL', // method name
        array('Username' => 'xsd:string', 'Password' => 'xsd:string', 'fStream' => 'xsd:string'), //input parameter
        array('return' => 'xsd:string'), // output
        'urn:MAIN_GetBLwsdl', // namespace
        'urn:' . $wsdlglobal, // soapaction
        'rpc', // style
        'encoded', // use
        'MAIN_GetBL -> json NO_BL'// documentation
);

$server->register('MAIN_GetOrganisasi', // method name
        array('Username' => 'xsd:string', 'Password' => 'xsd:string', 'fStream' => 'xsd:string'), //input parameter
        array('return' => 'xsd:string'), // output
        'urn:MAIN_GetOrganisasiwsdl', // namespace
        'urn:' . $wsdlglobal, // soapaction
        'rpc', // style
        'encoded', // use
        'MAIN_GetOrganisasi -> json ALT_NAME'// documentation
);

function APP_GetLogin($Username, $Password, $fStream) {
    global $CONF, $conn;
    $conn->connect();
    $json = json_decode($fStream);
    // print_r($json);die();
    $WSDLSOAP = 'http://ipccfscenter.com/TPSServices/server_ion.php';
    $IDLogServices = insertLogServices($Username, $Password, $WSDLSOAP, 'APP_GetLogin', $fStream);
    if($Username <> NULL && $Password <> NULL){
        $USERNAME = $json->{'USERNAME'};
        $PASSWORD = $json->{'PASSWORD'};
        $sql = "SELECT A.ID AS USERID, A.USERLOGIN, A.PASSWORD, A.NM_LENGKAP, A.HANDPHONE, A.KD_ORGANISASI, A.KD_GROUP, B.KD_TPS, B.KD_GUDANG,
        A.KD_STATUS, B.NPWP, B.NAMA AS NM_PERSH, B.ALAMAT AS ALAMAT_PERSH, B.NOTELP, B.NOFAX, B.EMAIL,
        B.KD_TIPE_ORGANISASI,A.EMAIL AS EMAIL_USER,
        C.NAMA AS NM_GROUP,F.NAMA AS NM_TIPE_GROUP, D.NAMA_GUDANG AS NM_GUDANG, E.NAMA_TPS, E.KD_KPBC, A.LAST_LOGIN, A.WK_REKAM,
        ADDDATE(A.WK_REKAM, INTERVAL 3 MONTH) AS NEXT_3_MONTH, NOW() AS WK_NOW
        FROM app_user A
        INNER JOIN t_organisasi B ON A.KD_ORGANISASI = B.ID
          INNER JOIN reff_tipe_organisasi F ON B.KD_TIPE_ORGANISASI = F.ID
        INNER JOIN app_group C ON A.KD_GROUP = C.ID
        LEFT JOIN reff_gudang D ON A.KD_GUDANG = D.KD_GUDANG
        LEFT JOIN reff_tps E ON E.KD_TPS=A.KD_TPS
        WHERE (A.USERLOGIN = '". $USERNAME ."' OR A.EMAIL = '') AND A.PASSWORD = '". $PASSWORD ."' ORDER BY A.ID DESC LIMIT 1";
        // print_r($sql);die();
        $query = $conn->query($sql);
        if($query->size() == 1){
            $query->next();
            $data['STATUS'] = 'SUCCESS';
            for ($i = 0; $i < $query->columnSize(); $i++) {
                $data[$query->fieldName($i)] = $query->get($query->fieldName($i));
            }  
        }else{
            $data['STATUS'] = 'FALSE';
            $data['MESSAGE'] = 'USERNAME ATAU PASSWORD ANDA SALAH ATAU TIDAK DITEMUKAN';
            $data['FUNCTION'] = __FUNCTION__;
            $data['SQL'] = $sql;
        }
    }
    $return = json_encode($data);
    updateLogServices($IDLogServices, $return);
    $conn->disconnect();
    return $return;
}

function APP_GetCustomer($Username, $Password, $fStream) {
    global $CONF, $conn;
    $conn->connect();
    $json = json_decode($fStream);
    // print_r($json);die();
    $WSDLSOAP = 'http://ipccfscenter.com/TPSServices/server_ion.php';
    $IDLogServices = insertLogServices($Username, $Password, $WSDLSOAP, 'APP_GetCustomer', $fStream);
    if($Username <> NULL && $Password <> NULL){
        $NPWP = $json->{'NPWP'};
        $sql = "SELECT A.CUSTOMER_ID, A.ALT_NAME AS NAME, A.ADDRESS, A.NPWP, A.EMAIL, A.WEBSITE, A.PHONE, A.COMPANY_TYPE , A.FAX
        FROM mst_customer A 
        WHERE A.NPWP = '". $NPWP ."' AND A.STATUS_APPROVAL = 'A' AND A.STATUS_CUSTOMER = 'A'";
        // print_r($sql);die();
        $query = $conn->query($sql);
        if($query->size() == 1){
            $query->next();
            $data['STATUS'] = 'SUCCESS';
            for ($i = 0; $i < $query->columnSize(); $i++) {
                $data[$query->fieldName($i)] = $query->get($query->fieldName($i));
            }  
        }else{
            $data['STATUS'] = 'FALSE';
            $data['MESSAGE'] = 'HUBUNNGI ADMINISTRATOR APLIKASI';
            $data['FUNCTION'] = __FUNCTION__;
            $data['SQL'] = $sql;
        }
    }
    $return = json_encode($data);
    updateLogServices($IDLogServices, $return);
    $conn->disconnect();
    return $return;
}

function APP_Register($Username, $Password, $fStream) {
    global $CONF, $conn;
    $conn->connect();
    $json = json_decode($fStream);
    // print_r($json);die();
    $WSDLSOAP = 'http://ipccfscenter.com/TPSServices/server_ion.php';
    $IDLogServices = insertLogServices($Username, $Password, $WSDLSOAP, 'APP_Register', $fStream);
    // print_r($IDLogServices);die();
    if($Username <> NULL && $Password <> NULL){
        // deklarasi organisasi
        $NPWP = $json->{'NPWP'};
        $ID_ORGANISASI = $json->{'ID_ORGANISASI'};
        $NAMA = $json->{'NAMA'};
        $ALAMAT = $json->{'ALAMAT'};
        $NOTELP = $json->{'NOTELP'};
        $NOFAX = $json->{'NOFAX'};
        $EMAILORG = $json->{'EMAILORG'};
        $JENIS_ORGANISASI = $json->{'JENIS_ORGANISASI'};

        // deklarasi app user
        $USERLOGIN = $json->{'USERLOGIN'};
        $PASSWORD = $json->{'PASSWORD'};
        $NM_LENGKAP = $json->{'NM_LENGKAP'};
        $HANDPHONE = $json->{'HANDPHONE'};
        $EMAIL = $json->{'EMAIL'};
        $ROLE = $json->{'ROLE'};

        // insert to t_organisasi
        $sqlcek = "SELECT A.ID FROM app_user A WHERE A.USERLOGIN = '". $USERLOGIN ."'";
        $querycek = $conn->query($sqlcek);
        if($querycek->size() == 0){
            $sql = "SELECT A.ID FROM t_organisasi A WHERE A.NPWP = '". $NPWP ."'";
            $query = $conn->query($sql);
            if($query->size() == 1){
                $query->next();
                $KD_ORGANISASI = $query->get('ID');
                $sqluser = "INSERT INTO app_user(KD_ORGANISASI, USERLOGIN, PASSWORD, NM_LENGKAP, HANDPHONE, EMAIL, KD_GROUP, WK_REKAM) 
                    VALUES ('". $KD_ORGANISASI ."', '". $USERLOGIN ."', '". $PASSWORD ."', '". $NM_LENGKAP ."', '". $HANDPHONE ."', '". $EMAIL ."',
                        'USR', NOW())";
                $Execute = $conn->execute($sqluser);
                if($Execute){
                    $data['STATUS'] = 'TRUE';
                    $data['MESSAGE'] = 'REGISTER BERHASIL, SILAHKAN LOGIN KEMBALI';
                    $data['USERLOGIN'] = $USERLOGIN;
                    $data['PASSWORD'] = $PASSWORD;
                }else{
                    $data['STATUS'] = 'FALSE';
                    $data['MESSAGE'] = 'GAGAL INSERT TO APP_USER';
                    $data['FUNCTION'] = __FUNCTION__;
                    $data['SQL'] = $sqluser;
                }
            }else{
                $sqlorg = "INSERT INTO t_organisasi(ID_ORGANISASI, NPWP, NAMA, ALAMAT, NOTELP, NOFAX, EMAIL,JENIS_ORGANISASI, KD_TIPE_ORGANISASI)
                    VALUES ('". $ID_ORGANISASI ."', '". $NPWP ."', '". $NAMA ."', '". $ALAMAT ."', '". $NOTELP ."', '". $NOFAX ."', '". $EMAILORG ."',
                    '". $JENIS_ORGANISASI ."','". $ROLE ."')";
                $Executeorg = $conn->execute($sqlorg);
                $KD_ORGANISASI = mysql_insert_id();
                if($Executeorg){
                    // insert to app_user
                    $sqluser = "INSERT INTO app_user(KD_ORGANISASI, USERLOGIN, PASSWORD, NM_LENGKAP, HANDPHONE, EMAIL, KD_GROUP, WK_REKAM) 
                        VALUES ('". $KD_ORGANISASI ."', '". $USERLOGIN ."', '". $PASSWORD ."', '". $NM_LENGKAP ."', '". $HANDPHONE ."', '". $EMAIL ."',
                         'USR', NOW())";
                    $Execute = $conn->execute($sqluser);
                    if($Execute){
                        $data['STATUS'] = 'TRUE';
                        $data['MESSAGE'] = 'REGISTER BERHASIL, SILAHKAN LOGIN KEMBALI';
                        $data['USERLOGIN'] = $USERLOGIN;
                        $data['PASSWORD'] = $PASSWORD;
                    }else{
                        $data['STATUS'] = 'FALSE';
                        $data['MESSAGE'] = 'GAGAL INSERT TO APP_USER';
                        $data['FUNCTION'] = __FUNCTION__;
                        $data['SQL'] = $sqluser;
                    }
                }else{
                    $data['STATUS'] = 'FALSE';
                    $data['MESSAGE'] = 'GAGAL INSERT TO T_ORGANISASI';
                    $data['FUNCTION'] = __FUNCTION__;
                    $data['SQL'] = $sqlorg;
                }
            }
        }else{
            $data['STATUS'] = 'FALSE';
            $data['MESSAGE'] = 'USERNAME SUDAH ADA';
            $data['FUNCTION'] = __FUNCTION__;
            $data['SQL'] = $sqlcek;
        }
        
         
    }
    $return = json_encode($data);
    updateLogServices($IDLogServices, $return);
    $conn->disconnect();
    return $return;
}

function MAIN_GetBL($Username, $Password, $fStream) {
    global $CONF, $conn;
    $conn->connect();
    $json = json_decode($fStream);
    // print_r($json);die();
    $WSDLSOAP = 'http://ipccfscenter.com/TPSServices/server_ion.php';
    $IDLogServices = insertLogServices($Username, $Password, $WSDLSOAP, 'MAIN_GetBL', $fStream);
    if($Username <> NULL && $Password <> NULL){
        $NO_BL = $json->{'NO_BL'};
        $sql = "SELECT A.NO_MASTER_BL_AWB, A.TGL_MASTER_BL_AWB, A.NO_BL_AWB, A.TGL_BL_AWB, K.NO_CONT_ASAL,
                IFNULL(A.KD_GUDANG,K.KD_GUDANG_TUJUAN) AS KD_GUDANG_TUJUAN,
                func_name(IFNULL(A.KD_GUDANG,K.KD_GUDANG_TUJUAN),'GUDANG') AS NM_GUDANG,
                A.NO_BC11, A.TGL_BC11, A.CONSIGNEE, func_npwp(A.ID_CONSIGNEE) AS NPWP_CONSIGNEE, A.ALAMAT_CONSIGNEE,
                A.NM_ANGKUT,A.NO_VOY_FLIGHT,DATE_FORMAT(C.TGL_TIBA,'%d-%m-%Y') AS TGL_TIBA,DATE_FORMAT(K.WK_IN,'%d-%m-%Y') AS WK_IN,
                A.ID,A.CAR,A.KD_KANTOR,func_name(IFNULL(A.KD_KANTOR,'-'),'KPBC') AS NM_KANTOR,
                A.KD_DOK_INOUT AS KD_DOK,func_name(IFNULL(A.KD_DOK_INOUT,'-'),'DOK_BC') AS NM_DOK,
                A.NO_DOK_INOUT AS NO_SPPB,DATE_FORMAT(A.TGL_DOK_INOUT,'%d-%m-%Y') AS TGL_SPPB, O.NO_BL_AWB AS BL
                FROM t_permit_hdr A 
                JOIN t_cocostskms K ON K.NO_BL_AWB=A.NO_BL_AWB AND K.TGL_BL_AWB=A.TGL_BL_AWB JOIN t_cocostshdr C ON C.ID=K.ID left 
                JOIN (SELECT b.NO_BL_AWB,b.TGL_BL_AWB,b.TGL_KELUAR FROM t_order_hdr b JOIN t_billing_cfshdr a ON a.NO_ORDER=b.NO_ORDER WHERE b.KD_STATUS = '700' 
                AND a.IS_VOID IS NULL GROUP BY b.NO_BL_AWB,b.TGL_BL_AWB) O ON O.NO_BL_AWB=A.NO_BL_AWB AND O.TGL_BL_AWB=A.TGL_BL_AWB
                WHERE (A.KD_GUDANG = 'BAND' OR K.KD_GUDANG_TUJUAN = 'BAND') AND K.WK_OUT IS NULL AND A.NO_BL_AWB LIKE '". $NO_BL ."%' LIMIT 5";
        // print_r($sql);die();
        $query = $conn->query($sql);
        if($query->size() > 0){
            $data['STATUS'] = 'SUCCESS';
            while($query->next()){
                for ($i = 0; $i < $query->columnSize(); $i++) {
                    $data[$query->fieldName($i)][] = $query->get($query->fieldName($i));
                }
                $sqlcekorder = "SELECT DATE_FORMAT(A.TGL_KELUAR, '%d-%m-%Y') AS TGL_KELUAR, A.NO_ORDER, DATE_FORMAT(A.WK_REKAM, '%d-%m-%Y') AS TGL_ORDER 
                                FROM t_order_hdr A 
                                WHERE A.NO_BL_AWB = '". $query->get('NO_BL_AWB') ."' OR A.NO_MASTER_BL_AWB = '". $query->get('NO_BL_AWB') ."' ORDER BY A.WK_REKAM DESC LIMIT 1";
                // print_r($sqlcekorder);die();
                $querycekorder = $conn->query($sqlcekorder);
                $querycekorder->next();
                // print_r($querycekorder->size());die();
                if($querycekorder->size() == 0){
                    $data['STATUS_ORDER'][] = 'BARU';
                    $data['TGL_KELUAR_LAMA'][] = $querycekorder->get('TGL_KELUAR');
                    $data['NO_ORDER'][] = $querycekorder->get('NO_ORDER');
                    $data['TGL_ORDER'][] = $querycekorder->get('TGL_ORDER');
                }else{
                    $data['STATUS_ORDER'][] = 'PERPANJANGAN';
                    $data['TGL_KELUAR_LAMA'][] = $querycekorder->get('TGL_KELUAR');
                    $data['NO_ORDER'][] = $querycekorder->get('NO_ORDER');
                    $data['TGL_ORDER'][] = $querycekorder->get('TGL_ORDER');
                }
            }  
        }else{
            $data['STATUS'] = 'FALSE';
            $data['MESSAGE'] = 'HUBUNNGI ADMINISTRATOR APLIKASI';
            $data['FUNCTION'] = __FUNCTION__;
            $data['SQL'] = $sql;
        }
    }
    $return = json_encode($data);
    updateLogServices($IDLogServices, $return);
    $conn->disconnect();
    return $return;
}

function MAIN_GetOrganisasi($Username, $Password, $fStream) {
    global $CONF, $conn;
    $conn->connect();
    $json = json_decode($fStream);
    // print_r($json);die();
    $WSDLSOAP = 'http://ipccfscenter.com/TPSServices/server_ion.php';
    $IDLogServices = insertLogServices($Username, $Password, $WSDLSOAP, 'MAIN_GetOrganisasi', $fStream);
    if($Username <> NULL && $Password <> NULL){
        $ALT_NAME = $json->{'ALT_NAME'};
        $sql = "SELECT A.ALT_NAME, A.NPWP, A.ADDRESS, A.CUSTOMER_ID FROM mst_customer A
            WHERE A.ALT_NAME LIKE '%".$ALT_NAME."%' AND A.STATUS_CUSTOMER='A' AND A.STATUS_APPROVAL='A' LIMIT 5";
        // print_r($sql);die();
        $query = $conn->query($sql);
        if($query->size() > 0){
            $data['STATUS'] = 'SUCCESS';
            while($query->next()){
                for ($i = 0; $i < $query->columnSize(); $i++) {
                    $data[$query->fieldName($i)][] = $query->get($query->fieldName($i));
                }
            }  
        }else{
            $data['STATUS'] = 'FALSE';
            $data['MESSAGE'] = 'HUBUNNGI ADMINISTRATOR APLIKASI';
            $data['FUNCTION'] = __FUNCTION__;
            $data['SQL'] = $sql;
        }
    }
    $return = json_encode($data);
    updateLogServices($IDLogServices, $return);
    $conn->disconnect();
    return $return;
}

function insertLogServices($userName, $Password, $url, $method, $xmlRequest = '', $xmlResponse = '') {
    global $CONF, $conn;
    $ipAddress = getIP();
    $userName = $userName == '' ? 'NULL' : "'" . $userName . "'";
    $Password = $Password == '' ? 'NULL' : "'" . $Password . "'";
    $url = $url == '' ? 'NULL' : "'" . $url . "'";
    $method = $method == '' ? 'NULL' : "'" . $method . "'";
    $xmlRequest = $xmlRequest == '' ? 'NULL' : "'" . $xmlRequest . "'";
    $xmlResponse = $xmlResponse == '' ? 'NULL' : "'" . $xmlResponse . "'";
    $SQL = "INSERT INTO app_log_services (USERNAME, PASSWORD, URL, METHOD, REQUEST, RESPONSE, IP_ADDRESS, WK_REKAM)
            VALUES (" . $userName . ", " . $Password . ", " . $url . ", " . $method . ", " . $xmlRequest . ", " . $xmlResponse . ", '" . $ipAddress . "', NOW())";

    $Execute = $conn->execute($SQL);
    $ID = mysql_insert_id();
    return $ID;
}

function updateLogServices($ID, $xmlResponse = '') {
    global $CONF, $conn;
    $xmlResponse = $xmlResponse == '' ? 'NULL' : "'" . mysql_real_escape_string($xmlResponse) . "'";
    $SQL = "UPDATE app_log_services SET RESPONSE = " . $xmlResponse . "
            WHERE ID = '" . $ID . "'";
    $Execute = $conn->execute($SQL);
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

$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';

$server->service($HTTP_RAW_POST_DATA);
?>
