<?php

ob_start();
// call library
require_once ('config.php' );
require_once ($CONF['root.dir'] . 'Libraries/nusoap/nusoap.php' );
require_once ($CONF['root.dir'] . 'Libraries/xml2array.php' );

// create instance sdf
$server = new soap_server(); 

// initialize WSDL support
$server->configureWSDL('TPSServices Web Service', 'http://services.beacukai.go.id/');

// place schema at namespace with prefix tns
$server->wsdl->schemaTargetNamespace = 'http://services.beacukai.go.id/';
$server->register('UploadMohonPLP', // method name
        array('fStream' => 'xsd:string', 'Username' => 'xsd:string', 'Password' => 'xsd:string'),
        // input parameter
        array('UploadMohonPLPResult' => 'xsd:string'), // output
        'http://services.beacukai.go.id/', // namespace 
        'http://services.beacukai.go.id/UploadMohonPLP', // soapaction
        'rpc', // style
        'encoded', // use
        'Fungsi untuk Upload data permohonan PLP '// documentation
);

$server->register('GetResponPLP', // method name
        array('UserName' => 'xsd:string', 'Password' => 'xsd:string', 'Kd_asp' => 'xsd:string'),
        // input parameter
        array('GetResponPLPResult' => 'xsd:string'), // output
        'http://services.beacukai.go.id/', // namespace
        'http://services.beacukai.go.id/GetResponPLP', // soapaction
        'rpc', // style
        'encoded', // use
        'Fungsi untuk mendownload data Respon PLP yang sudah diproses, filter yang digunakan adalah kode TPS'// documentation
);

$server->register('GetResponPLPTujuan', // method name
        array('UserName' => 'xsd:string', 'Password' => 'xsd:string', 'Kd_asp' => 'xsd:string'),
        // input parameter
        array('GetResponPLPTujuanResult' => 'xsd:string'), // output
        'http://services.beacukai.go.id/', // namespace
        'http://services.beacukai.go.id/GetResponPLPTujuan', // soapaction
        'rpc', // style
        'encoded', // use
        'Fungsi untuk mendownload data Respon PLP yang sudah disetujui, oleh TPS Tujuan, filter yang digunakan adalah kode TPS'// documentation
);

$server->register('UploadBatalPLP', // method name
        array('fStream' => 'xsd:string', 'Username' => 'xsd:string', 'Password' => 'xsd:string'),
        // input parameter
        array('UploadBatalPLPResult' => 'xsd:string'), // output
        'http://services.beacukai.go.id/', // namespace
        'http://services.beacukai.go.id/UploadBatalPLP', // soapaction
        'rpc', // style
        'encoded', // use
        'Fungsi untuk Upload data pembatalan PLP '// documentation
);

$server->register('receivebatalPLP', // method name
        array('string' => 'xsd:string', 'string0' => 'xsd:string', 'string1' => 'xsd:string'),
        array('return' => 'xsd:string'), // output
        'urn:receivebatalPLPwsdl', // namespace
        'urn:TPSOnline', // soapaction
        'rpc', // style
        'encoded', // use
        'Receive Batal PLP'// documentation
);

$server->register('GetResponBatalPLP', // method name
        array('UserName' => 'xsd:string', 'Password' => 'xsd:string', 'Kd_asp' => 'xsd:string'),
        // input parameter
        array('GetResponBatalPLPResult' => 'xsd:string'), // output
        'http://services.beacukai.go.id/', // namespace
        'http://services.beacukai.go.id/GetResponBatalPLP', // soapaction
        'rpc', // style
        'encoded', // use
        'Fungsi untuk mengambil data persetujuan pembatalan PLP'// documentation
);

$server->register('GetResponBatalPLPTujuan', // method name
        array('UserName' => 'xsd:string', 'Password' => 'xsd:string', 'Kd_asp' => 'xsd:string'),
        // input parameter
        array('GetResponBatalPLPTujuanResult' => 'xsd:string'), // output
        'http://services.beacukai.go.id/', // namespace
        'http://services.beacukai.go.id/GetResponBatalPLPTujuan', // soapaction
        'rpc', // style
        'encoded', // use
        'Fungsi untuk mengambil data persetujuan pembatalan PLP'// documentation
);

$server->register('CoarriCodeco_Container', // method name
        array('fStream' => 'xsd:string', 'Username' => 'xsd:string', 'Password' => 'xsd:string'),
        // input parameter
        array('CoarriCodeco_ContainerResult' => 'xsd:string'), // output
        'http://services.beacukai.go.id/', // namespace
        'http://services.beacukai.go.id/CoarriCodeco_Container', // soapaction
        'rpc', // style
        'encoded', // use
        'Fungsi untuk insert data Coarri-Codeco Container(Baru, dengan penambahan kolom pada detil container)'// documentation
);

$server->register('CoarriCodeco_Kemasan', // method name
        array('fStream' => 'xsd:string', 'Username' => 'xsd:string', 'Password' => 'xsd:string'),
        // input parameter
        array('CoarriCodeco_KemasanResult' => 'xsd:string'), // output
        'http://services.beacukai.go.id/', // namespace
        'http://services.beacukai.go.id/CoarriCodeco_Kemasan', // soapaction
        'rpc', // style
        'encoded', // use
        'Fungsi untuk insert data Coarri Kemasan (Baru, dengan penambahan kolom pada detil kemasan)'// documentation
);

$server->register('GetSPJM', // method name
        array('Username' => 'xsd:string', 'Password' => 'xsd:string', 'Kd_Tps' => 'xsd:string'),
        // input parameter
        array('GetSPJMResult' => 'xsd:string'), // output
        'http://services.beacukai.go.id/', // namespace
        'http://services.beacukai.go.id/GetSPJM', // soapaction
        'rpc', // style
        'encoded', // use
        'Fungsi untuk mendownload data barang yang terkena SPJM dengan parameter KD TPS'// documentation
);

$server->register('GetSPJM_onDemand', // method name
        array('Username' => 'xsd:string', 'Password' => 'xsd:string', 'noPib' => 'xsd:string', 'tglPib' => 'xsd:string'),
        // input parameter
        array('GetSPJM_onDemandResult' => 'xsd:string'), // output
        'http://services.beacukai.go.id/', // namespace
        'http://services.beacukai.go.id/GetSPJM_onDemand', // soapaction
        'rpc', // style
        'encoded', // use
        'Fungsi untuk mendownload data barang yang terkena SPJM dengan filter No.PIB dan Tgl. PIB format ddmmyyyy'// documentation
);

$server->register('GetImpor_Sppb', // method name
        array('Username' => 'xsd:string', 'Password' => 'xsd:string', 'No_Sppb' => 'xsd:string', 'Tgl_Sppb' => 'xsd:string', 'NPWP_Imp' => 'xsd:string'),
        // input parameter
        array('GetImpor_SppbResult' => 'xsd:string'), // output
        'http://services.beacukai.go.id/', // namespace
        'http://services.beacukai.go.id/GetImpor_Sppb', // soapaction
        'rpc', // style
        'encoded', // use
        'Fungsi untuk mendownload data SPPB, filter yang digunakan adalah tanggal SPPB, nomor SPPB dan NPWP, format tanggal #ddmmyyyy#'// documentation
);


function UploadMohonPLP($fStream, $Username, $Password) {
    global $CONF, $conn;
    $conn->connect();
    $IDLogServices = insertLogServices($UserName, $Password, $CONF['url.wsdl'], 'UploadMohonPLP', $fStream);

    $SOAPAction = 'http://services.beacukai.go.id/UploadMohonPLP';
    $xml = '<?xml version="1.0" encoding="utf-8"?>
            <soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
              <soap:Body>
                <UploadMohonPLP xmlns="http://services.beacukai.go.id/">
                  <fStream>'.htmlspecialchars($fStream).'</fStream>
                  <Username>'.$Username.'</Username>
                  <Password>'.$Password.'</Password>
                </UploadMohonPLP>
              </soap:Body>
            </soap:Envelope>';
    $Send = SendCurl($xml, $CONF['url.wsdl'], $SOAPAction);
    if ($Send['response'] != '') {
        $arr1 = 'UploadMohonPLPResponse';
        $arr2 = 'UploadMohonPLPResult';
        $response = xml2ary($Send['response']);
        $return = $response['soap:Envelope']['_c']['soap:Body']['_c'][$arr1]['_c'][$arr2]['_v'];
    } else {
        $return = '';
    }

    updateLogServices($IDLogServices, $return);
    $conn->disconnect();
    return $return;
}

function GetResponPLP($UserName, $Password, $Kd_asp) {
    global $CONF, $conn;
    $conn->connect();
    $IDLogServices = insertLogServices($UserName, $Password, $CONF['url.wsdl'], 'GetResponPLP', $Kd_asp);

    $SOAPAction = 'http://services.beacukai.go.id/GetResponPLP';
    $xml = '<?xml version="1.0" encoding="utf-8"?>
            <soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
              <soap:Body>
                <GetResponPLP xmlns="http://services.beacukai.go.id/">
                  <UserName>'.$UserName.'</UserName>
                  <Password>'.$Password.'</Password>
                  <Kd_asp>'.$Kd_asp.'</Kd_asp>
                </GetResponPLP>
              </soap:Body>
            </soap:Envelope>';
    $Send = SendCurl($xml, $CONF['url.wsdl'], $SOAPAction);
    if ($Send['response'] != '') {
        $arr1 = 'GetResponPLPResponse';
        $arr2 = 'GetResponPLPResult';
        $response = xml2ary($Send['response']);
        $return = $response['soap:Envelope']['_c']['soap:Body']['_c'][$arr1]['_c'][$arr2]['_v'];
    } else {
        $return = '';
    }
    updateLogServices($IDLogServices, $return);
    $conn->disconnect();
    return $return;
}

function GetResponPLPTujuan($UserName, $Password, $Kd_asp) {
    global $CONF, $conn;
    $conn->connect();
    $IDLogServices = insertLogServices($UserName, $Password, $CONF['url.wsdl'], 'GetResponPLPTujuan', $Kd_asp);

    $SOAPAction = 'http://services.beacukai.go.id/GetResponPLPTujuan';
    $xml = '<?xml version="1.0" encoding="utf-8"?>
            <soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
              <soap:Body>
                <GetResponPLPTujuan xmlns="http://services.beacukai.go.id/">
                  <UserName>'.$UserName.'</UserName>
                  <Password>'.$Password.'</Password>
                  <Kd_asp>'.$Kd_asp.'</Kd_asp>
                </GetResponPLPTujuan>
              </soap:Body>
            </soap:Envelope>';
    $Send = SendCurl($xml, $CONF['url.wsdl'], $SOAPAction);
    if ($Send['response'] != '') {
        $arr1 = 'GetResponPLPTujuanResponse';
        $arr2 = 'GetResponPLPTujuanResult';
        $response = xml2ary($Send['response']);
        $return = $response['soap:Envelope']['_c']['soap:Body']['_c'][$arr1]['_c'][$arr2]['_v'];
    } else {
        $return = '';
    }
    updateLogServices($IDLogServices, $return);
    $conn->disconnect();
    return $return;
}

function UploadBatalPLP($fStream, $Username, $Password) {
    global $CONF, $conn;
    $conn->connect();
    $IDLogServices = insertLogServices($UserName, $Password, $CONF['url.wsdl'], 'UploadBatalPLP', $fStream);

    $SOAPAction = 'http://services.beacukai.go.id/UploadBatalPLP';
    $xml = '<?xml version="1.0" encoding="utf-8"?>
            <soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
              <soap:Body>
                <UploadBatalPLP xmlns="http://services.beacukai.go.id/">
                  <fStream>'.htmlspecialchars($fStream).'</fStream>
                  <Username>'.$Username.'</Username>
                  <Password>'.$Password.'</Password>
                </UploadBatalPLP>
              </soap:Body>
            </soap:Envelope>';
    $Send = SendCurl($xml, $CONF['url.wsdl'], $SOAPAction);
    if ($Send['response'] != '') {
        $arr1 = 'UploadBatalPLPResponse';
        $arr2 = 'UploadBatalPLPResult';
        $response = xml2ary($Send['response']);
        $return = $response['soap:Envelope']['_c']['soap:Body']['_c'][$arr1]['_c'][$arr2]['_v'];
    } else {
        $return = '';
    }
    
    updateLogServices($IDLogServices, $return);
    $conn->disconnect();
    return $return;
}

function GetResponBatalPLP($UserName, $Password, $Kd_asp) {
    global $CONF, $conn;
    $conn->connect();
    $IDLogServices = insertLogServices($UserName, $Password, $CONF['url.wsdl'], 'GetResponBatalPLP', $Kd_asp);

    $SOAPAction = 'http://services.beacukai.go.id/GetResponBatalPLP';
    $xml = '<?xml version="1.0" encoding="utf-8"?>
            <soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
              <soap:Body>
                <GetResponBatalPLP xmlns="http://services.beacukai.go.id/">
                  <Username>'.$UserName.'</Username>
                  <Password>'.$Password.'</Password>
                  <Kd_asp>'.$Kd_asp.'</Kd_asp>
                </GetResponBatalPLP>
              </soap:Body>
            </soap:Envelope>';
    $Send = SendCurl($xml, $CONF['url.wsdl'], $SOAPAction);
    if ($Send['response'] != '') {
        $arr1 = 'GetResponBatalPLPResponse';
        $arr2 = 'GetResponBatalPLPResult';
        $response = xml2ary($Send['response']);
        $return = $response['soap:Envelope']['_c']['soap:Body']['_c'][$arr1]['_c'][$arr2]['_v'];
    } else {
        $return = '';
    }
    updateLogServices($IDLogServices, $return);
    $conn->disconnect();
    return $return;
}

function GetResponBatalPLPTujuan($UserName, $Password, $Kd_asp) {
    global $CONF, $conn;
    $conn->connect();
    $IDLogServices = insertLogServices($UserName, $Password, $CONF['url.wsdl'], 'GetResponBatalPLPTujuan', $Kd_asp);

    $SOAPAction = 'http://services.beacukai.go.id/GetResponBatalPLPTujuan';
    $xml = '<?xml version="1.0" encoding="utf-8"?>
            <soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
              <soap:Body>
                <GetResponBatalPLPTujuan xmlns="http://services.beacukai.go.id/">
                  <Username>'.$UserName.'</Username>
                  <Password>'.$Password.'</Password>
                  <Kd_asp>'.$Kd_asp.'</Kd_asp>
                </GetResponBatalPLPTujuan>
              </soap:Body>
            </soap:Envelope>';
    $Send = SendCurl($xml, $CONF['url.wsdl'], $SOAPAction);
    if ($Send['response'] != '') {
        $arr1 = 'GetResponBatalPLPTujuanResponse';
        $arr2 = 'GetResponBatalPLPTujuanResult';
        $response = xml2ary($Send['response']);
        $return = $response['soap:Envelope']['_c']['soap:Body']['_c'][$arr1]['_c'][$arr2]['_v'];
    } else {
        $return = '';
    }
    updateLogServices($IDLogServices, $return);
    $conn->disconnect();
    return $return;
}

function CoarriCodeco_Container($fStream, $Username, $Password) {
    global $CONF, $conn;
    $conn->connect();
    $IDLogServices = insertLogServices($Username, $Password, $CONF['url.wsdl'], 'CoarriCodeco_Container', $fStream);

    $SOAPAction = 'http://services.beacukai.go.id/CoarriCodeco_Container';
    $xml = '<?xml version="1.0" encoding="utf-8"?>
            <soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
                <soap:Body>
                    <CoarriCodeco_Container xmlns="http://services.beacukai.go.id/">
                        <fStream>' . htmlspecialchars($fStream) . '</fStream>
                        <Username>' . $Username . '</Username>
                        <Password>' . $Password . '</Password>
                    </CoarriCodeco_Container>
                </soap:Body>
            </soap:Envelope>';
    $Send = SendCurl($xml, $CONF['url.wsdl'], $SOAPAction);
    if ($Send['response'] != '') {
        $arr1 = 'CoarriCodeco_ContainerResponse';
        $arr2 = 'CoarriCodeco_ContainerResult';
        $response = xml2ary($Send['response']);
        $return = $response['soap:Envelope']['_c']['soap:Body']['_c'][$arr1]['_c'][$arr2]['_v'];
    } else {
        $return = '';
    }

    updateLogServices($IDLogServices, $return);
    $conn->disconnect();
    return $return;
}

function CoarriCodeco_Kemasan($fStream, $Username, $Password) {
    global $CONF, $conn;
    $conn->connect();
    $IDLogServices = insertLogServices($Username, $Password, $CONF['url.wsdl'], 'CoarriCodeco_Kemasan', $fStream);

    $SOAPAction = 'http://services.beacukai.go.id/CoarriCodeco_Kemasan';
    $xml = '<?xml version="1.0" encoding="utf-8"?>
            <soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
                <soap:Body>
                    <CoarriCodeco_Kemasan xmlns="http://services.beacukai.go.id/">
                        <fStream>' . htmlspecialchars($fStream) . '</fStream>
                        <Username>' . $Username . '</Username>
                        <Password>' . $Password . '</Password>
                    </CoarriCodeco_Kemasan>
                </soap:Body>
            </soap:Envelope>';
    $Send = SendCurl($xml, $CONF['url.wsdl'], $SOAPAction);
    if ($Send['response'] != '') {
        $arr1 = 'CoarriCodeco_KemasanResponse';
        $arr2 = 'CoarriCodeco_KemasanResult';
        $response = xml2ary($Send['response']);
        $return = $response['soap:Envelope']['_c']['soap:Body']['_c'][$arr1]['_c'][$arr2]['_v'];
    } else {
        $return = '';
    }

    updateLogServices($IDLogServices, $return);
    $conn->disconnect();
    return $return;
}

function GetSPJM($Username, $Password, $Kd_Tps) {
    global $CONF, $conn;
    $conn->connect();
    $IDLogServices = insertLogServices($Username, $Password, $CONF['url.wsdl'], 'GetSPJM', $Kd_Tps);

    $SOAPAction = 'http://services.beacukai.go.id/GetSPJM';
    $xml = '<?xml version="1.0" encoding="utf-8"?>
            <soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
            <soap:Body>
              <GetSPJM xmlns="http://services.beacukai.go.id/">
                <UserName>' . $Username . '</UserName>
                <Password>' . $Password . '</Password>
                <Kd_Tps>' . $Kd_Tps . '</Kd_Tps>
              </GetSPJM>
            </soap:Body>
          </soap:Envelope>';
    $Send = SendCurl($xml, $CONF['url.wsdl'], $SOAPAction);
    if ($Send['response'] != '') {
        $arr1 = 'GetSPJMResponse';
        $arr2 = 'GetSPJMResult';
        $response = xml2ary($Send['response']);
        $return = $response['soap:Envelope']['_c']['soap:Body']['_c'][$arr1]['_c'][$arr2]['_v'];
    } else {
        $return = '';
    }

    updateLogServices($IDLogServices, $return);
    $conn->disconnect();
    return $return;
}

function GetSPJM_onDemand($Username, $Password, $noPib, $tglPib) {
    global $CONF, $conn;
    $connDashboard->connect();
    $IDLogServices = insertLogServices($Username, $Password, $CONF['url.wsdl'], 'GetSPJM_onDemand', $noPib . "-" . $tglPib);

    $SOAPAction = 'http://services.beacukai.go.id/GetSPJM_onDemand';
    $xml = '<?xml version="1.0" encoding="utf-8"?>
            <soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
            <soap:Body>
              <GetSPJM_onDemand xmlns="http://services.beacukai.go.id/">
                <UserName>' . $Username . '</UserName>
                <Password>' . $Password . '</Password>
                <noPib>' . $noPib . '</noPib>
                <tglPib>' . $tglPib . '</tglPib>
              </GetSPJM_onDemand>
            </soap:Body>
          </soap:Envelope>';
    $Send = SendCurl($xml, $CONF['url.wsdl'], $SOAPAction);
    if ($Send['response'] != '') {
        $arr1 = 'GetSPJM_onDemandResponse';
        $arr2 = 'GetSPJM_onDemandResult';
        $response = xml2ary($Send['response']);
        $return = $response['soap:Envelope']['_c']['soap:Body']['_c'][$arr1]['_c'][$arr2]['_v'];
    } else {
        $return = '';
    }

    updateLogServices($IDLogServices, $return);
    $conn->disconnect();
    return $return;
}

function GetImpor_Sppb($Username, $Password, $No_Sppb, $Tgl_Sppb, $NPWP_Imp) {
    global $CONF, $conn;
    $conn->connect();
    $IDLogServices = insertLogServices($Username, $Password, $CONF['url.wsdl'], 'GetImpor_Sppb', $No_Sppb . "-" . $Tgl_Sppb . "-" . $NPWP_Imp);

    $SOAPAction = 'http://services.beacukai.go.id/GetImpor_Sppb';
    $xml = '<?xml version="1.0" encoding="utf-8"?>
            <soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
              <soap:Body>
                <GetImpor_Sppb xmlns="http://services.beacukai.go.id/">
                  <UserName>' . $Username . '</UserName>
                  <Password>' . $Password . '</Password>
                  <No_Sppb>' . $No_Sppb . '</No_Sppb>
                  <Tgl_Sppb>' . $Tgl_Sppb . '</Tgl_Sppb>
                  <NPWP_Imp>' . $NPWP_Imp . '</NPWP_Imp>
                </GetImpor_Sppb>
              </soap:Body>
            </soap:Envelope>';
    $Send = SendCurl($xml, $CONF['url.wsdl'], $SOAPAction);
    if ($Send['response'] != '') {
        $arr1 = 'GetImpor_SppbResponse';
        $arr2 = 'GetImpor_SppbResult';
        $response = xml2ary($Send['response']);
        $return = $response['soap:Envelope']['_c']['soap:Body']['_c'][$arr1]['_c'][$arr2]['_v'];
    } else {
        $return = '';
    }

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
    $xmlResponse = $xmlResponse == '' ? 'NULL' : "'" . $xmlResponse . "'";
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

function SendCurl($xml, $url, $SOAPAction, $proxy = "", $port = "443") {
    $header[] = 'Content-Type: text/xml';
    $header[] = 'SOAPAction: "' . $SOAPAction . '"';
    $header[] = 'Content-length: ' . strlen($xml);
    $header[] = 'Connection: close';

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    //        curl_setopt($ch, CURLOPT_PORT, $port);
    //        curl_setopt($ch, CURLOPT_PROXY, $proxy);
    curl_setopt($ch, CURLOPT_VERBOSE, 0);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_SSLVERSION, 3);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

    $response = curl_exec($ch);
    if (!curl_errno($ch)) {
        $return['return'] = TRUE;
        $return['info'] = curl_getinfo($ch);
        $return['response'] = $response;
    } else {
        $return['return'] = FALSE;
        $return['info'] = curl_error($ch);
        $return['response'] = '';
    }
    return $return;
}

function checkUser($user, $password, $IDLogServices) {
    global $CONF, $conn;
    $SQL = "SELECT B.KD_TIPE_ORGANISASI,B.ID
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
    	$Query->next();        
        $return['return'] = true;
        $return['kdorganisasi'] = $Query->get("ID");
    }
    return $return;
}

$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
$server->service($HTTP_RAW_POST_DATA);
?>