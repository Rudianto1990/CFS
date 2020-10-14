<?php

ob_start();
// call library
require_once ('config.php' );

$connDashboard = new DBManager($DB_MANAGER->DB_MYSQL);
$connDashboard->parseURL("db.MYSQL://" . $CONF['username'] . ":" . $CONF['password'] . "@" . $CONF['host']);
$connDashboard->setDBName('dashboard_tpsonline');

require_once ($CONF['root.dir'] . 'Libraries/nusoap/nusoap.php' );
require_once ($CONF['root.dir'] . 'Libraries/xml2array.php' );

// create instance
$server = new soap_server();

// initialize WSDL support
$server->configureWSDL('TPSServices Web Service', 'http://services.beacukai.go.id/');

// place schema at namespace with prefix tns
$server->wsdl->schemaTargetNamespace = 'http://services.beacukai.go.id/';

// register method
$server->register('CheckConnection', // method name
        array('Username' => 'xsd:string', 'Password' => 'xsd:string'),
        // input parameter
        array('CheckConnectionResult' => 'xsd:string'), // output
        'http://services.beacukai.go.id/', // namespace
        'http://services.beacukai.go.id/CheckConnection', // soapaction
        'rpc', // style
        'encoded', // use
        'Fungsi untuk pengecekan koneksi webservice'// documentation
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

$server->register('GetImporPermit', // method name
        array('Username' => 'xsd:string', 'Password' => 'xsd:string', 'Kd_Gudang' => 'xsd:string'),
        // input parameter
        array('GetImporPermitResult' => 'xsd:string'), // output
        'http://services.beacukai.go.id/', // namespace
        'http://services.beacukai.go.id/GetImporPermit', // soapaction
        'rpc', // style
        'encoded', // use
        'Fungsi untuk mendownload data SPPB, filter yang digunakan adalah kode Gudang'// documentation
);

$server->register('GetImpor_Bc11', // method name
        array('Username' => 'xsd:string', 'Password' => 'xsd:string', 'No_Bc11' => 'xsd:string', 'Tgl_Bc11' => 'xsd:string'),
        // input parameter
        array('GetImpor_Bc11Result' => 'xsd:string'), // output
        'http://services.beacukai.go.id/', // namespace
        'http://services.beacukai.go.id/GetImpor_Bc11', // soapaction
        'rpc', // style
        'encoded', // use
        'Fungsi untuk mendownload data SPPB, filter yang digunakan adalah nomor BC11 dan tanggal BC11 format tanggal #ddmmyyyy#'// documentation
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

$server->register('GetDokumenManual', // method name
        array('Username' => 'xsd:string', 'Password' => 'xsd:string', 'Kd_Tps' => 'xsd:string'),
        // input parameter
        array('GetDokumenManualResult' => 'xsd:string'), // output
        'http://services.beacukai.go.id/', // namespace
        'http://services.beacukai.go.id/GetDokumenManual', // soapaction
        'rpc', // style
        'encoded', // use
        'Fungsi untuk mendownload data dokumen manual'// documentation
);

$server->register('GetDokumenManual_OnDemand', // method name
        array('Username' => 'xsd:string', 'Password' => 'xsd:string', 'KdDok' => 'xsd:string', 'NoDok' => 'xsd:string', 'TglDok' => 'xsd:string'),
        // input parameter
        array('GetDokumenManual_OnDemandResult' => 'xsd:string'), // output
        'http://services.beacukai.go.id/', // namespace
        'http://services.beacukai.go.id/GetDokumenManual_OnDemand', // soapaction
        'rpc', // style
        'encoded', // use
        'Fungsi untuk mendownload data dokumen manual on demand, parameter Kode Dokumen, Nomor Dokumen dan Tanggal Dokumen (ddMMyyyy)'// documentation
);

$server->register('GetBC23Permit', // method name
        array('UserName' => 'xsd:string', 'Password' => 'xsd:string', 'Kd_Gudang' => 'xsd:string'),
        // input parameter
        array('GetBC23PermitResult' => 'xsd:string'), // output
        'http://services.beacukai.go.id/', // namespace
        'http://services.beacukai.go.id/GetBC23Permit', // soapaction
        'rpc', // style
        'encoded', // use
        'Fungsi untuk mendownload data SPPB, filter yang digunakan adalah kode Gudang'// documentation
);

$server->register('GetBC23Permit_FASP', // method name
        array('UserName' => 'xsd:string', 'Password' => 'xsd:string', 'Kd_ASP' => 'xsd:string'),
        // input parameter
        array('GetBC23Permit_FASPResult' => 'xsd:string'), // output
        'http://services.beacukai.go.id/', // namespace
        'http://services.beacukai.go.id/GetBC23Permit_FASP', // soapaction
        'rpc', // style
        'encoded', // use
        'Fungsi untuk mendownload data SPPB, filter yang digunakan adalah kode ASP'// documentation
);

$server->register('GetSppb_Bc23', // method name
        array('UserName' => 'xsd:string', 'Password' => 'xsd:string', 'No_Sppb' => 'xsd:string', 'Tgl_Sppb' => 'xsd:string', 'NPWP_Imp' => 'xsd:string'),
        // input parameter
        array('GetSppb_Bc23Result' => 'xsd:string'), // output
        'http://services.beacukai.go.id/', // namespace
        'http://services.beacukai.go.id/GetSppb_Bc23', // soapaction
        'rpc', // style
        'encoded', // use
        'Fungsi untuk mendownload data SPPB BC23, filter yang digunakan adalah tanggal SPPB, nomor SPPB dan NPWP, format tanggal #ddmmyyyy#'// documentation
);

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

$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
$server->service($HTTP_RAW_POST_DATA);

function CheckConnection($Username, $Password) {
    global $CONF, $connDashboard;
    $connDashboard->connect();
    $IDLogServices = insertLogServices($Username, $Password, $CONF['url.wsdl'], 'CheckConnection', $fStream);

    $return = "Hello " . $Username;

    updateLogServices($IDLogServices, $return);
    $connDashboard->disconnect();
    return $return;
}

function GetResponBatalPLP($UserName, $Password, $Kd_asp) {
    global $CONF, $connDashboard;
    $connDashboard->connect();
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
    $connDashboard->disconnect();
    return $return;
}

function GetResponPLP($UserName, $Password, $Kd_asp) {
    global $CONF, $connDashboard;
    $connDashboard->connect();
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
    $connDashboard->disconnect();
    return $return;
}

function UploadBatalPLP($fStream, $Username, $Password) {
    global $CONF, $connDashboard;
    $connDashboard->connect();
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
    $connDashboard->disconnect();
    return $return;
}

function UploadMohonPLP($fStream, $Username, $Password) {
    global $CONF, $connDashboard;
    $connDashboard->connect();
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
    $connDashboard->disconnect();
    return $return;
}

function GetSppb_Bc23($UserName, $Password, $No_Sppb, $Tgl_Sppb, $NPWP_Imp) {
    global $CONF, $connDashboard;
    $connDashboard->connect();
    $IDLogServices = insertLogServices($UserName, $Password, $CONF['url.wsdl'], 'GetSppb_Bc23', $Kd_ASP);

    $SOAPAction = 'http://services.beacukai.go.id/GetSppb_Bc23';
    $xml = '<?xml version="1.0" encoding="utf-8"?>
            <soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
              <soap:Body>
                <GetSppb_Bc23 xmlns="http://services.beacukai.go.id/">
                  <UserName>' . $UserName . '</UserName>
                  <Password>' . $Password . '</Password>
                  <No_Sppb>' . $No_Sppb . '</No_Sppb>
                  <Tgl_Sppb>' . $Tgl_Sppb . '</Tgl_Sppb>
                  <NPWP_Imp>' . $NPWP_Imp . '</NPWP_Imp>
                </GetSppb_Bc23>
              </soap:Body>
            </soap:Envelope>';
    $Send = SendCurl($xml, $CONF['url.wsdl'], $SOAPAction);
    if ($Send['response'] != '') {
        $arr1 = 'GetSppb_Bc23Response';
        $arr2 = 'GetSppb_Bc23Result';
        $response = xml2ary($Send['response']);
        $return = $response['soap:Envelope']['_c']['soap:Body']['_c'][$arr1]['_c'][$arr2]['_v'];
    } else {
        $return = '';
    }

    updateLogServices($IDLogServices, $return);
    $connDashboard->disconnect();
    return $return;
}

function GetBC23Permit_FASP($UserName, $Password, $Kd_ASP) {
    global $CONF, $connDashboard;
    $connDashboard->connect();
    $IDLogServices = insertLogServices($UserName, $Password, $CONF['url.wsdl'], 'GetBC23Permit_FASP', $Kd_ASP);

    $SOAPAction = 'http://services.beacukai.go.id/GetBC23Permit_FASP';
    $xml = '<?xml version="1.0" encoding="utf-8"?>
            <soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
              <soap:Body>
                <GetBC23Permit_FASP xmlns="http://services.beacukai.go.id/">
                  <UserName>' . $UserName . '</UserName>
                  <Password>' . $Password . '</Password>
                  <Kd_ASP>' . $Kd_ASP . '</Kd_ASP>
                </GetBC23Permit_FASP>
              </soap:Body>
            </soap:Envelope>';
    $Send = SendCurl($xml, $CONF['url.wsdl'], $SOAPAction);
    if ($Send['response'] != '') {
        $arr1 = 'GetBC23Permit_FASPResponse';
        $arr2 = 'GetBC23Permit_FASPResult';
        $response = xml2ary($Send['response']);
        $return = $response['soap:Envelope']['_c']['soap:Body']['_c'][$arr1]['_c'][$arr2]['_v'];
    } else {
        $return = '';
    }

    updateLogServices($IDLogServices, $return);
    $connDashboard->disconnect();
    return $return;
}

function GetBC23Permit($UserName, $Password, $Kd_Gudang) {
    global $CONF, $connDashboard;
    $connDashboard->connect();
    $IDLogServices = insertLogServices($UserName, $Password, $CONF['url.wsdl'], 'GetBC23Permit', $Kd_Gudang);

    $SOAPAction = 'http://services.beacukai.go.id/GetBC23Permit';
    $xml = '<?xml version="1.0" encoding="utf-8"?>
            <soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
              <soap:Body>
                <GetBC23Permit xmlns="http://services.beacukai.go.id/">
                  <UserName>' . $UserName . '</UserName>
                  <Password>' . $Password . '</Password>
                  <Kd_Gudang>' . $Kd_Gudang . '</Kd_Gudang>
                </GetBC23Permit>
              </soap:Body>
            </soap:Envelope>';
    $Send = SendCurl($xml, $CONF['url.wsdl'], $SOAPAction);
    if ($Send['response'] != '') {
        $arr1 = 'GetBC23PermitResponse';
        $arr2 = 'GetBC23PermitResult';
        $response = xml2ary($Send['response']);
        $return = $response['soap:Envelope']['_c']['soap:Body']['_c'][$arr1]['_c'][$arr2]['_v'];
    } else {
        $return = '';
    }

    updateLogServices($IDLogServices, $return);
    $connDashboard->disconnect();
    return $return;
}

function GetDokumenManual_OnDemand($Username, $Password, $KdDok, $NoDok, $TglDok) {
    global $CONF, $connDashboard;
    $connDashboard->connect();
    $IDLogServices = insertLogServices($Username, $Password, $CONF['url.wsdl'], 'GetDokumenManual_OnDemand', $KdDok . "-" . $NoDok . "-" . $TglDok);

    $SOAPAction = 'http://services.beacukai.go.id/GetDokumenManual_OnDemand';
    $xml = '<?xml version="1.0" encoding="utf-8"?>
            <soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
              <soap:Body>
                <GetDokumenManual_OnDemand xmlns="http://services.beacukai.go.id/">
                  <UserName>' . $Username . '</UserName>
                  <Password>' . $Password . '</Password>
                  <KdDok>' . $KdDok . '</KdDok>
                  <NoDok>' . $NoDok . '</NoDok>
                  <TglDok>' . $TglDok . '</TglDok>
                </GetDokumenManual_OnDemand>
              </soap:Body>
            </soap:Envelope>';
    $Send = SendCurl($xml, $CONF['url.wsdl'], $SOAPAction);
    if ($Send['response'] != '') {
        $arr1 = 'GetDokumenManual_OnDemandResponse';
        $arr2 = 'GetDokumenManual_OnDemandResult';
        $response = xml2ary($Send['response']);
        $return = $response['soap:Envelope']['_c']['soap:Body']['_c'][$arr1]['_c'][$arr2]['_v'];
    } else {
        $return = '';
    }

    updateLogServices($IDLogServices, $return);
    $connDashboard->disconnect();
    return $return;
}

function GetDokumenManual($Username, $Password, $Kd_Tps) {
    global $CONF, $connDashboard;
    $connDashboard->connect();
    $IDLogServices = insertLogServices($Username, $Password, $CONF['url.wsdl'], 'GetDokumenManual', $Kd_Tps);

    $SOAPAction = 'http://services.beacukai.go.id/GetDokumenManual';
    $xml = '<?xml version="1.0" encoding="utf-8"?>
            <soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
              <soap:Body>
                <GetDokumenManual xmlns="http://services.beacukai.go.id/">
                  <UserName>' . $Username . '</UserName>
                  <Password>' . $Password . '</Password>
                  <Kd_Tps>' . $Kd_Tps . '</Kd_Tps>
                </GetDokumenManual>
              </soap:Body>
            </soap:Envelope>';
    $Send = SendCurl($xml, $CONF['url.wsdl'], $SOAPAction);
    if ($Send['response'] != '') {
        $arr1 = 'GetDokumenManualResponse';
        $arr2 = 'GetDokumenManualResult';
        $response = xml2ary($Send['response']);
        $return = $response['soap:Envelope']['_c']['soap:Body']['_c'][$arr1]['_c'][$arr2]['_v'];
    } else {
        $return = '';
    }

    updateLogServices($IDLogServices, $return);
    $connDashboard->disconnect();
    return $return;
}

function GetSPJM_onDemand($Username, $Password, $noPib, $tglPib) {
    global $CONF, $connDashboard;
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
    $connDashboard->disconnect();
    return $return;
}

function GetSPJM($Username, $Password, $Kd_Tps) {
    global $CONF, $connDashboard;
    $connDashboard->connect();
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
    $connDashboard->disconnect();
    return $return;
}

function GetImpor_Sppb($Username, $Password, $No_Sppb, $Tgl_Sppb, $NPWP_Imp) {
    global $CONF, $connDashboard;
    $connDashboard->connect();
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
    $connDashboard->disconnect();
    return $return;
}

function GetImpor_Bc11($Username, $Password, $No_Bc11, $Tgl_Bc11) {
    global $CONF, $connDashboard;
    $connDashboard->connect();
    $IDLogServices = insertLogServices($Username, $Password, $CONF['url.wsdl'], 'GetImpor_Bc11', $No_Bc11 . "-" . $Tgl_Bc11);

    $SOAPAction = 'http://services.beacukai.go.id/GetImporPermit';
    $xml = '<?xml version="1.0" encoding="utf-8"?>
            <soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
              <soap:Body>
                <GetImpor_Bc11 xmlns="http://services.beacukai.go.id/">
                  <UserName>' . $Username . '</UserName>
                  <Password>' . $Password . '</Password>
                  <No_Bc11>' . $No_Bc11 . '</No_Bc11>
                  <Tgl_Bc11>' . $Tgl_Bc11 . '</Tgl_Bc11>
                </GetImpor_Bc11>
              </soap:Body>
            </soap:Envelope>';
    $Send = SendCurl($xml, $CONF['url.wsdl'], $SOAPAction);
    if ($Send['response'] != '') {
        $arr1 = 'GetImpor_Bc11Response';
        $arr2 = 'GetImpor_Bc11Result';
        $response = xml2ary($Send['response']);
        $return = $response['soap:Envelope']['_c']['soap:Body']['_c'][$arr1]['_c'][$arr2]['_v'];
    } else {
        $return = '';
    }

    updateLogServices($IDLogServices, $return);
    $connDashboard->disconnect();
    return $return;
}

function GetImporPermit($Username, $Password, $Kd_Gudang) {
    global $CONF, $connDashboard;
    $connDashboard->connect();
    $IDLogServices = insertLogServices($Username, $Password, $CONF['url.wsdl'], 'GetImporPermit', $Kd_Gudang);

    $SOAPAction = 'http://services.beacukai.go.id/GetImporPermit';
    $xml = '<?xml version="1.0" encoding="utf-8"?>
            <soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
              <soap:Body>
                <GetImporPermit xmlns="http://services.beacukai.go.id/">
                  <UserName>' . $Username . '</UserName>
                  <Password>' . $Password . '</Password>
                  <Kd_Gudang>' . $Kd_Gudang . '</Kd_Gudang>
                </GetImporPermit>
              </soap:Body>
            </soap:Envelope>';
    $Send = SendCurl($xml, $CONF['url.wsdl'], $SOAPAction);
    if ($Send['response'] != '') {
        $arr1 = 'GetImporPermitResponse';
        $arr2 = 'GetImporPermitResult';
        $response = xml2ary($Send['response']);
        $return = $response['soap:Envelope']['_c']['soap:Body']['_c'][$arr1]['_c'][$arr2]['_v'];
    } else {
        $return = '';
    }

    updateLogServices($IDLogServices, $return);
    $connDashboard->disconnect();
    return $return;
}

function CoarriCodeco_Kemasan($fStream, $Username, $Password) {
    global $CONF, $connDashboard;
    $connDashboard->connect();
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
    $connDashboard->disconnect();
    return $return;
}

function insertLogServices($userName, $Password, $url, $method, $xmlRequest = '', $xmlResponse = '') {
    global $CONF, $connDashboard;
    $ipAddress = getIP();
    $userName = $userName == '' ? 'NULL' : "'" . $userName . "'";
    $Password = $Password == '' ? 'NULL' : "'" . $Password . "'";
    $url = $url == '' ? 'NULL' : "'" . $url . "'";
    $method = $method == '' ? 'NULL' : "'" . $method . "'";
    $xmlRequest = $xmlRequest == '' ? 'NULL' : "'" . $xmlRequest . "'";
    $xmlResponse = $xmlResponse == '' ? 'NULL' : "'" . $xmlResponse . "'";
    $SQL = "INSERT INTO app_log_services (USERNAME, PASSWORD, URL, METHOD, REQUEST, RESPONSE, IP_ADDRESS, WK_REKAM)
            VALUES (" . $userName . ", " . $Password . ", " . $url . ", " . $method . ", " . $xmlRequest . ", " . $xmlResponse . ", '" . $ipAddress . "', NOW())";
    $Execute = $connDashboard->execute($SQL);
    $ID = mysql_insert_id();
    return $ID;
}

function updateLogServices($ID, $xmlResponse = '') {
    global $CONF, $connDashboard;
    $xmlResponse = $xmlResponse == '' ? 'NULL' : "'" . $xmlResponse . "'";
    $SQL = "UPDATE app_log_services SET RESPONSE = " . $xmlResponse . "
            WHERE ID = '" . $ID . "'";
    $Execute = $connDashboard->execute($SQL);
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

