<?php

ob_start();
//ini_set('post_max_size', '200M');
//ini_set('upload_max_filesize', '200M');
//echo ini_get('post_max_size');
//echo '----' . ini_get('upload_max_filesize');
//echo '----' . ini_get('memory_limit');
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


$server->register('HelloWorld', // method name
        array(),
        // input parameter
        array('HelloWorldResult' => 'xsd:string'), // output
        'http://services.beacukai.go.id/', // namespace 
        'http://services.beacukai.go.id/HelloWorld', // soapaction
        'document', // style
        'literal', // use
        'HelloWorld'// documentation
);

$server->register('UploadMohonPLP', // method name
        array('fStream' => 'xsd:string', 'Username' => 'xsd:string', 'Password' => 'xsd:string'),
        // input parameter
        array('UploadMohonPLPResult' => 'xsd:string'), // output
        'http://services.beacukai.go.id/', // namespace 
        'http://services.beacukai.go.id/UploadMohonPLP', // soapaction
        'document', // style
        'literal', // use
        'Fungsi untuk Upload data permohonan PLP '// documentation
);

$server->register('GetResponPLP', // method name
        array('UserName' => 'xsd:string', 'Password' => 'xsd:string', 'Kd_asp' => 'xsd:string'),
        // input parameter
        array('GetResponPLPResult' => 'xsd:string'), // output
        'http://services.beacukai.go.id/', // namespace
        'http://services.beacukai.go.id/GetResponPLP', // soapaction
        'document', // style
        'literal', // use
        'Fungsi untuk mendownload data Respon PLP yang sudah diproses, filter yang digunakan adalah kode TPS'// documentation
);

$server->register('GetResponPLPTujuan', // method name
        array('UserName' => 'xsd:string', 'Password' => 'xsd:string', 'Kd_asp' => 'xsd:string'),
        // input parameter
        array('GetResponPLPTujuanResult' => 'xsd:string'), // output
        'http://services.beacukai.go.id/', // namespace
        'http://services.beacukai.go.id/GetResponPLPTujuan', // soapaction
        'document', // style
        'literal', // use
        'Fungsi untuk mendownload data Respon PLP yang sudah disetujui, oleh TPS Tujuan, filter yang digunakan adalah kode TPS'// documentation
);

$server->register('UploadBatalPLP', // method name
        array('fStream' => 'xsd:string', 'Username' => 'xsd:string', 'Password' => 'xsd:string'),
        // input parameter
        array('UploadBatalPLPResult' => 'xsd:string'), // output
        'http://services.beacukai.go.id/', // namespace
        'http://services.beacukai.go.id/UploadBatalPLP', // soapaction
        'document', // style
        'literal', // use
        'Fungsi untuk Upload data pembatalan PLP '// documentation
);

/* $server->register('receivebatalPLP', // method name
  array('string' => 'xsd:string', 'string0' => 'xsd:string', 'string1' => 'xsd:string'),
  array('return' => 'xsd:string'), // output
  'urn:receivebatalPLPwsdl', // namespace
  'urn:TPSOnline', // soapaction
  'document', // style
  'literal', // use
  'Receive Batal PLP'// documentation
  );
 */
$server->register('GetResponBatalPLP', // method name
        array('UserName' => 'xsd:string', 'Password' => 'xsd:string', 'Kd_asp' => 'xsd:string'),
        // input parameter
        array('GetResponBatalPLPResult' => 'xsd:string'), // output
        'http://services.beacukai.go.id/', // namespace
        'http://services.beacukai.go.id/GetResponBatalPLP', // soapaction
        'document', // style
        'literal', // use
        'Fungsi untuk mengambil data persetujuan pembatalan PLP'// documentation
);

$server->register('GetResponBatalPLPTujuan', // method name
        array('UserName' => 'xsd:string', 'Password' => 'xsd:string', 'Kd_asp' => 'xsd:string'),
        // input parameter
        array('GetResponBatalPLPTujuanResult' => 'xsd:string'), // output
        'http://services.beacukai.go.id/', // namespace
        'http://services.beacukai.go.id/GetResponBatalPLPTujuan', // soapaction
        'document', // style
        'literal', // use
        'Fungsi untuk mengambil data persetujuan pembatalan PLP'// documentation
);

$server->register('CoarriCodeco_Container', // method name
        array('fStream' => 'xsd:string', 'Username' => 'xsd:string', 'Password' => 'xsd:string'),
        // input parameter
        array('CoarriCodeco_ContainerResult' => 'xsd:string'), // output
        'http://services.beacukai.go.id/', // namespace
        'http://services.beacukai.go.id/CoarriCodeco_Container', // soapaction
        'document', // style
        'literal', // use
        'Fungsi untuk insert data Coarri-Codeco Container(Baru, dengan penambahan kolom pada detil container)'// documentation
);

$server->register('CoarriCodeco_Kemasan', // method name
        array('fStream' => 'xsd:string', 'Username' => 'xsd:string', 'Password' => 'xsd:string'),
        // input parameter
        array('CoarriCodeco_KemasanResult' => 'xsd:string'), // output
        'http://services.beacukai.go.id/', // namespace
        'http://services.beacukai.go.id/CoarriCodeco_Kemasan', // soapaction
        'document', // style
        'literal', // use
        'Fungsi untuk insert data Coarri Kemasan (Baru, dengan penambahan kolom pada detil kemasan)'// documentation
);

$server->register('GetSubTotal_Billing', // method name
        array('fStream' => 'xsd:string', 'Username' => 'xsd:string', 'Password' => 'xsd:string'),
        // input parameter
        array('GetSubTotal_BillingResult' => 'xsd:string'), // output
        'urn:GetSubTotal_Billingwsdl', // namespace
        'urn:TPSServices', // soapaction
        'document', // style
        'literal', // use
        'Fungsi untuk get data billing from TPS'// documentation
);

$server->register('GetImpor_Sppb', // method name
        array('Username' => 'xsd:string', 'Password' => 'xsd:string', 'No_Sppb' => 'xsd:string', 'Tgl_Sppb' => 'xsd:string', 'NPWP_Imp' => 'xsd:string'),
        // input parameter
        array('GetImpor_SppbResult' => 'xsd:string'), // output
        'http://services.beacukai.go.id/', // namespace
        'http://services.beacukai.go.id/GetImpor_Sppb', // soapaction
        'document', // style
        'literal', // use
        'Fungsi untuk mendownload data SPPB, filter yang digunakan adalah tanggal SPPB, nomor SPPB dan NPWP, format tanggal #ddmmyyyy#'// documentation
);

$server->register('GetImporPermit', // method name
        array('Username' => 'xsd:string', 'Password' => 'xsd:string', 'Kd_Gudang' => 'xsd:string'),
        // input parameter
        array('GetImporPermitResult' => 'xsd:string'), // output
        'http://services.beacukai.go.id/', // namespace
        'http://services.beacukai.go.id/GetImporPermit', // soapaction
        'document', // style
        'literal', // use
        'Fungsi untuk mendownload data SPPB, filter yang digunakan adalah kode Gudang'// documentation
);

$server->register('GetImporPermit_FASP', // method name
        array('Username' => 'xsd:string', 'Password' => 'xsd:string', 'Kd_ASP' => 'xsd:string'),
        // input parameter
        array('GetImporPermit_FASPResult' => 'xsd:string'), // output
        'http://services.beacukai.go.id/', // namespace
        'http://services.beacukai.go.id/GetImporPermit_FASP', // soapaction
        'document', // style
        'literal', // use
        'Fungsi untuk mendownload data SPPB, filter yang digunakan adalah kode ASP'// documentation
);

$server->register('GetSppb_Bc23', // method name
        array('Username' => 'xsd:string', 'Password' => 'xsd:string', 'No_Sppb' => 'xsd:string', 'Tgl_Sppb' => 'xsd:string', 'NPWP_Imp' => 'xsd:string'),
        // input parameter
        array('GetSppb_Bc23Result' => 'xsd:string'), // output
        'http://services.beacukai.go.id/', // namespace
        'http://services.beacukai.go.id/GetSppb_Bc23', // soapaction
        'document', // style
        'literal', // use
        'Fungsi untuk mendownload data SPPB BC23, filter yang digunakan adalah tanggal SPPB, nomor SPPB dan NPWP, format tanggal #ddmmyyyy#'// documentation
);

$server->register('GetBC23Permit', // method name
        array('Username' => 'xsd:string', 'Password' => 'xsd:string', 'Kd_Gudang' => 'xsd:string'),
        // input parameter
        array('GetBC23PermitResult' => 'xsd:string'), // output
        'http://services.beacukai.go.id/', // namespace
        'http://services.beacukai.go.id/GetBC23Permit', // soapaction
        'document', // style
        'literal', // use
        'Fungsi untuk mendownload data SPPB, filter yang digunakan adalah kode Gudang'// documentation
);

$server->register('GetBC23Permit_FASP', // method name
        array('Username' => 'xsd:string', 'Password' => 'xsd:string', 'Kd_ASP' => 'xsd:string'),
        // input parameter
        array('GetBC23Permit_FASPResult' => 'xsd:string'), // output
        'http://services.beacukai.go.id/', // namespace
        'http://services.beacukai.go.id/GetBC23Permit_FASP', // soapaction
        'document', // style
        'literal', // use
        'Fungsi untuk mendownload data SPPB, filter yang digunakan adalah kode ASP'// documentation
);

$server->register('GetSPJM', // method name
        array('Username' => 'xsd:string', 'Password' => 'xsd:string', 'Kd_Tps' => 'xsd:string'),
        // input parameter
        array('GetSPJMResult' => 'xsd:string'), // output
        'http://services.beacukai.go.id/', // namespace
        'http://services.beacukai.go.id/GetSPJM', // soapaction
        'document', // style
        'literal', // use
        'Fungsi untuk mendownload data barang yang terkena SPJM dengan parameter KD TPS'// documentation
);

$server->register('GetSPJM_onDemand', // method name
        array('Username' => 'xsd:string', 'Password' => 'xsd:string', 'noPib' => 'xsd:string', 'tglPib' => 'xsd:string'),
        // input parameter
        array('GetSPJM_onDemandResult' => 'xsd:string'), // output
        'http://services.beacukai.go.id/', // namespace
        'http://services.beacukai.go.id/GetSPJM_onDemand', // soapaction
        'document', // style
        'literal', // use
        'Fungsi untuk mendownload data barang yang terkena SPJM dengan filter No.PIB dan Tgl. PIB format ddmmyyyy'// documentation
);

$server->register('GetBilling', // method name
        array('fStream' => 'xsd:string', 'Username' => 'xsd:string', 'Password' => 'xsd:string'),
        // input parameter
        array('GetBillingResult' => 'xsd:string'), // output
        'urn:GetBillingwsdl', // namespace
        'urn:TPSServices', // soapaction
        'document', // style
        'literal', // use
        'Fungsi untuk get data billing from TPS'// documentation
);

$server->register('OrderPengeluaranBarang', // method name
        array('fStream' => 'xsd:string', 'Username' => 'xsd:string', 'Password' => 'xsd:string'),
        // input parameter
        array('OrderPengeluaranBarangResult' => 'xsd:string'), // output
        'urn:OrderPengeluaranBarangwsdl', // namespace
        'urn:TPSServices', // soapaction
        'document', // style
        'literal', // use
        'Fungsi untuk Order Pengeluaran Barang from TPS'// documentation
);

$server->register('GetDataBilling', // method name
        array('fStream' => 'xsd:string', 'Username' => 'xsd:string', 'Password' => 'xsd:string'),
        // input parameter
        array('GetDataBillingResult' => 'xsd:string'), // output
        'urn:GetDataBillingwsdl', // namespace
        'urn:TPSServices', // soapaction
        'document', // style
        'literal', // use
        'Fungsi untuk get data billing untuk digenerate portal CFS'// documentation
);

$server->register('ConfirmTagihanPenimbunan', // method name
        array('fStream' => 'xsd:string', 'Username' => 'xsd:string', 'Password' => 'xsd:string'),
        // input parameter
        array('ConfirmTagihanPenimbunanResult' => 'xsd:string'), // output
        'urn:ConfirmTagihanPenimbunanwsdl', // namespace
        'urn:TPSServices', // soapaction
        'document', // style
        'literal', // use
        'Fungsi untuk Confirm Tagihan Penimbunan from TPS'// documentation
);

$server->register('ConfirmTagihanPLP', // method name
        array('fStream' => 'xsd:string', 'Username' => 'xsd:string', 'Password' => 'xsd:string'),
        // input parameter
        array('ConfirmTagihanPLPResult' => 'xsd:string'), // output
        'urn:ConfirmTagihanPLPwsdl', // namespace
        'urn:TPSServices', // soapaction
        'document', // style
        'literal', // use
        'Fungsi untuk Confirm Tagihan PLP from TPS'// documentation
);

$server->register('ValidasiTagihanPenimbunan', // method name
        array('fStream' => 'xsd:string', 'Username' => 'xsd:string', 'Password' => 'xsd:string'),
        // input parameter
        array('ValidasiTagihanPenimbunanResult' => 'xsd:string'), // output
        'urn:ValidasiTagihanPenimbunanwsdl', // namespace
        'urn:TPSServices', // soapaction
        'document', // style
        'literal', // use
        'Fungsi untuk Validasi Tagihan Penimbunan from TPS'// documentation
);

$server->register('ValidasiTagihanPLP', // method name
        array('fStream' => 'xsd:string', 'Username' => 'xsd:string', 'Password' => 'xsd:string'),
        // input parameter
        array('ValidasimTagihanPLPResult' => 'xsd:string'), // output
        'urn:ValidasiTagihanPLPwsdl', // namespace
        'urn:TPSServices', // soapaction
        'document', // style
        'literal', // use
        'Fungsi untuk Validasi Tagihan PLP from TPS'// documentation
);

$server->register('ValidasiEDC', // method name
        array('fStream' => 'xsd:string', 'Username' => 'xsd:string', 'Password' => 'xsd:string'),
        // input parameter
        array('ValidasiEDCPLPResult' => 'xsd:string'), // output
        'urn:ValidasiEDCwsdl', // namespace
        'urn:TPSServices', // soapaction
        'document', // style
        'literal', // use
        'Fungsi untuk Validasi Pembayaran dari engine EDC from TPS'// documentation
);

$server->register('GetPermohonanCFS', // method name
        array('username' => 'xsd:string', 'password' => 'xsd:string'),
        // input parameter
        array('return' => 'xsd:string'), // output
        'urn:GetPermohonanCFSwsdl', // namespace
        'urn:TPSOnline', // soapaction
        'document', // style
        'literal', // use
        'GetPermohonanCFS'// documentation
);

function HelloWorld() {
    return "Hello Rizki ganteng";
}

function UploadMohonPLP($fStream, $Username, $Password) {
    global $CONF, $conn;
    $conn->connect();
    $IDLogServices = insertLogServicesTest($Username, $Password, $CONF['url.wsdl'], 'UploadMohonPLP', $fStream);

    $SOAPAction = 'http://services.beacukai.go.id/UploadMohonPLP';
    $xml = '<?xml version="1.0" encoding="utf-8"?>
            <soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
              <soap:Body>
                <UploadMohonPLP xmlns="http://services.beacukai.go.id/">
                  <fStream>' . htmlspecialchars($fStream) . '</fStream>
                  <Username>' . $Username . '</Username>
                  <Password>' . $Password . '</Password>
                </UploadMohonPLP>
              </soap:Body>
            </soap:Envelope>';
    $cek = cek_go_live($Username);
    if ($cek == "T") {
        $return = "Proses Berhasil Tersimpan di Portal CFS, Data tidak diteruskan ke BC.";
        updateLogServicesTest($IDLogServices, $return);
        $conn->disconnect();
        return $return;
        die();
    } else {
        $Send = SendCurl($xml, $CONF['url.wsdl'], $SOAPAction);
    }

    if ($Send['response'] != '') {
        $arr1 = 'UploadMohonPLPResponse';
        $arr2 = 'UploadMohonPLPResult';
        $response = xml2ary($Send['response']);
        $return = $response['soap:Envelope']['_c']['soap:Body']['_c'][$arr1]['_c'][$arr2]['_v'];
    } else {
        $return = '<?xml version="1.0" encoding="UTF-8"?>
					  <UploadMohonPLP>
							<status>failed</status>							
					  </UploadMohonPLP>';
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
                  <UserName>' . $UserName . '</UserName>
                  <Password>' . $Password . '</Password>
                  <Kd_asp>' . $Kd_asp . '</Kd_asp>
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
        $return = '<?xml version="1.0" encoding="UTF-8"?>
					  <GetResponPLP>
							<status>failed</status>							
					  </GetResponPLP>';
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
                  <UserName>' . $UserName . '</UserName>
                  <Password>' . $Password . '</Password>
                  <Kd_asp>' . $Kd_asp . '</Kd_asp>
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
        $return = '<?xml version="1.0" encoding="UTF-8"?>
					  <GetResponPLPTujuan>
							<status>failed</status>							
					  </GetResponPLPTujuan>';
    }
    updateLogServices($IDLogServices, $return);
    $conn->disconnect();
    return $return;
}

function UploadBatalPLP($fStream, $Username, $Password) {
    global $CONF, $conn;
    $conn->connect();
    $IDLogServices = insertLogServices($Username, $Password, $CONF['url.wsdl'], 'UploadBatalPLP', $fStream);

    $SOAPAction = 'http://services.beacukai.go.id/UploadBatalPLP';
    $xml = '<?xml version="1.0" encoding="utf-8"?>
            <soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
              <soap:Body>
                <UploadBatalPLP xmlns="http://services.beacukai.go.id/">
                  <fStream>' . htmlspecialchars($fStream) . '</fStream>
                  <Username>' . $Username . '</Username>
                  <Password>' . $Password . '</Password>
                </UploadBatalPLP>
              </soap:Body>
            </soap:Envelope>';
    $cek = cek_go_live($Username);
    if ($cek == "T") {
        $return = "Proses Berhasil Tersimpan di Portal CFS, Data tidak diteruskan ke BC.";
        updateLogServices($IDLogServices, $return);
        $conn->disconnect();
        return $return;
        die();
    } else {
        $Send = SendCurl($xml, $CONF['url.wsdl'], $SOAPAction);
    }

    if ($Send['response'] != '') {
        $arr1 = 'UploadBatalPLPResponse';
        $arr2 = 'UploadBatalPLPResult';
        $response = xml2ary($Send['response']);
        $return = $response['soap:Envelope']['_c']['soap:Body']['_c'][$arr1]['_c'][$arr2]['_v'];
    } else {
        $return = '<?xml version="1.0" encoding="UTF-8"?>
					  <UploadBatalPLP>
							<status>failed</status>							
					  </UploadBatalPLP>';
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
                  <Username>' . $UserName . '</Username>
                  <Password>' . $Password . '</Password>
                  <Kd_asp>' . $Kd_asp . '</Kd_asp>
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
        $return = '<?xml version="1.0" encoding="UTF-8"?>
					  <GetResponBatalPLP>
							<status>failed</status>							
					  </GetResponBatalPLP>';
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
                  <Username>' . $UserName . '</Username>
                  <Password>' . $Password . '</Password>
                  <Kd_asp>' . $Kd_asp . '</Kd_asp>
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
        $return = '<?xml version="1.0" encoding="UTF-8"?>
					  <GetResponBatalPLPTujuan>
							<status>failed</status>							
					  </GetResponBatalPLPTujuan>';
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
    $cek = cek_go_live($Username);
    if ($cek == "T") {
        $return = "Proses Berhasil Tersimpan di Portal CFS, Data tidak diteruskan ke BC.";
        updateLogServices($IDLogServices, $return);
        $conn->disconnect();
        return $return;
        die();
    } else {
        $Send = SendCurl($xml, $CONF['url.wsdl'], $SOAPAction);
    }

    if ($Send['response'] != '') {
        $arr1 = 'CoarriCodeco_ContainerResponse';
        $arr2 = 'CoarriCodeco_ContainerResult';
        $response = xml2ary($Send['response']);
        $return = $response['soap:Envelope']['_c']['soap:Body']['_c'][$arr1]['_c'][$arr2]['_v'];
    } else {
        $return = '<?xml version="1.0" encoding="UTF-8"?>
                    <CoarriCodeco_Container>
                        <status>failed</status>							
                    </CoarriCodeco_Container>';
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

    $cek = cek_go_live($Username);
    if ($cek == "T") {
        $return = "Proses Berhasil Tersimpan di Portal CFS, Data tidak diteruskan ke BC.";
        updateLogServices($IDLogServices, $return);
        $conn->disconnect();
        return $return;
        die();
    } else {
        $Send = SendCurl($xml, $CONF['url.wsdl'], $SOAPAction);
    }

    if ($Send['response'] != '') {
        $arr1 = 'CoarriCodeco_KemasanResponse';
        $arr2 = 'CoarriCodeco_KemasanResult';
        $response = xml2ary($Send['response']);
        $return = $response['soap:Envelope']['_c']['soap:Body']['_c'][$arr1]['_c'][$arr2]['_v'];
    } else {
        $return = '<?xml version="1.0" encoding="UTF-8"?>
					  <CoarriCodeco_Kemasan>
							<status>failed</status>							
					  </CoarriCodeco_Kemasan>';
    }

    updateLogServices($IDLogServices, $return);
    $conn->disconnect();
    return $return;
}

function GetSubTotal_Billing($fStream, $Username, $Password) {
    global $CONF, $conn;
    $conn->connect();
    $WSDLSOAP = 'http://103.29.187.215/cfs-center/TPSServices/sever_plp.php?wsdl';
    $IDLogServices = insertLogServices($Username, $Password, $WSDLSOAP, 'GetSubTotal_Billing', $fStream);

    $SOAPAction = 'http://103.29.187.215/cfs-center/TPSServices/sever_plp.php';
    $xml = '<?xml version="1.0" encoding="utf-8"?>
            <soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
                <soap:Body>
                    <GetSubTotal_Billing xmlns="http://103.29.187.215/cfs-center/TPSServices/">
                        <fStream>' . htmlspecialchars($fStream) . '</fStream>
                        <Username>' . $Username . '</Username>
                        <Password>' . $Password . '</Password>
                    </GetSubTotal_Billing>
                </soap:Body>
            </soap:Envelope>';



    /* $cek = cek_go_live($Username);  
      if($cek == "T"){
      $Send = SendCurl($xml, $WSDLSOAP, $SOAPAction);
      }else{

      $return = "Proses Berhasil Tersimpan di Portal CFS";
      updateLogServices($IDLogServices, $return);
      $conn->disconnect();
      return $return;
      die();
      }

      if ($Send['response'] != '') {
      $arr1 = 'GetSubTotal_BillingResponse';
      $arr2 = 'GetSubTotal_BillingResult';
      $response = xml2ary($Send['response']);
      $return = $response['soap:Envelope']['_c']['soap:Body']['_c'][$arr1]['_c'][$arr2]['_v'];
      } else {
      $return = '<?xml version="1.0" encoding="UTF-8"?>
      <GetSubTotal_Billing>
      <status>failed</status>
      </GetSubTotal_Billing>';
      } */

    $return = "Proses Berhasil Tersimpan di Portal CFS";
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
        $return = '<?xml version="1.0" encoding="UTF-8"?>
					  <GetImpor_Sppb>
							<status>failed</status>							
					  </GetImpor_Sppb>';
    }

    updateLogServices($IDLogServices, $return);
    $conn->disconnect();
    return $return;
}

function GetImporPermit($Username, $Password, $kd_gudang) {
    global $CONF, $conn;
    $conn->connect();
    $IDLogServices = insertLogServices($Username, $Password, $CONF['url.wsdl'], 'GetImporPermit', $kd_gudang);

    $SOAPAction = 'http://services.beacukai.go.id/GetImporPermit';
    $xml = '<?xml version="1.0" encoding="utf-8"?>
            <soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
              <soap:Body>
                <GetImporPermit xmlns="http://services.beacukai.go.id/">
                  <UserName>' . $Username . '</UserName>
                  <Password>' . $Password . '</Password>
                  <Kd_Gudang>' . $kd_gudang . '</Kd_Gudang>                  
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
        $return = '<?xml version="1.0" encoding="UTF-8"?>
					  <GetImporPermit>
							<status>failed</status>							
					  </GetImporPermit>';
    }

    updateLogServices($IDLogServices, $return);
    $conn->disconnect();
    return $return;
}

function GetImporPermit_FASP($Username, $Password, $Kd_ASP) {
    global $CONF, $conn;
    $conn->connect();
    $IDLogServices = insertLogServices($Username, $Password, $CONF['url.wsdl'], 'GetImporPermit_FASP', $Kd_ASP);

    $SOAPAction = 'http://services.beacukai.go.id/GetImporPermit_FASP';
    $xml = '<?xml version="1.0" encoding="utf-8"?>
            <soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
              <soap:Body>
                <GetImporPermit_FASP xmlns="http://services.beacukai.go.id/">
                  <UserName>' . $Username . '</UserName>
                  <Password>' . $Password . '</Password>
                  <Kd_ASP>' . $Kd_ASP . '</Kd_ASP>                  
                </GetImporPermit_FASP>
              </soap:Body>
            </soap:Envelope>';
    $Send = SendCurl($xml, $CONF['url.wsdl'], $SOAPAction);
    if ($Send['response'] != '') {
        $arr1 = 'GetImporPermit_FASPResponse';
        $arr2 = 'GetImporPermit_FASPResult';
        $response = xml2ary($Send['response']);
        $return = $response['soap:Envelope']['_c']['soap:Body']['_c'][$arr1]['_c'][$arr2]['_v'];
    } else {
        $return = '<?xml version="1.0" encoding="UTF-8"?>
					  <GetImporPermit_FASP>
							<status>failed</status>							
					  </GetImporPermit_FASP>';
    }

    updateLogServices($IDLogServices, $return);
    $conn->disconnect();
    return $return;
}

function GetSppb_Bc23($Username, $Password, $No_Sppb, $Tgl_Sppb, $NPWP_Imp) {
    global $CONF, $conn;
    $conn->connect();
    $IDLogServices = insertLogServices($Username, $Password, $CONF['url.wsdl'], 'GetSppb_Bc23', $No_Sppb . "-" . $Tgl_Sppb . "-" . $NPWP_Imp);

    $SOAPAction = 'http://services.beacukai.go.id/GetSppb_Bc23';
    $xml = '<?xml version="1.0" encoding="utf-8"?>
            <soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
              <soap:Body>
                <GetSppb_Bc23 xmlns="http://services.beacukai.go.id/">
                  <UserName>' . $Username . '</UserName>
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
        $return = '<?xml version="1.0" encoding="UTF-8"?>
					  <GetSppb_Bc23>
							<status>failed</status>							
					  </GetSppb_Bc23>';
    }

    updateLogServices($IDLogServices, $return);
    $conn->disconnect();
    return $return;
}

function GetBC23Permit($Username, $Password, $kd_gudang) {
    global $CONF, $conn;
    $conn->connect();
    $IDLogServices = insertLogServices($Username, $Password, $CONF['url.wsdl'], 'GetBC23Permit', $kd_gudang);

    $SOAPAction = 'http://services.beacukai.go.id/GetBC23Permit';
    $xml = '<?xml version="1.0" encoding="utf-8"?>
            <soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
              <soap:Body>
                <GetBC23Permit xmlns="http://services.beacukai.go.id/">
                  <UserName>' . $Username . '</UserName>
                  <Password>' . $Password . '</Password>
                  <Kd_Gudang>' . $kd_gudang . '</Kd_Gudang>                  
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
        $return = '<?xml version="1.0" encoding="UTF-8"?>
					  <GetBC23Permit>
							<status>failed</status>							
					  </GetBC23Permit>';
    }

    updateLogServices($IDLogServices, $return);
    $conn->disconnect();
    return $return;
}

function GetBC23Permit_FASP($Username, $Password, $Kd_ASP) {
    global $CONF, $conn;
    $conn->connect();
    $IDLogServices = insertLogServices($Username, $Password, $CONF['url.wsdl'], 'GetBC23Permit_FASP', $Kd_ASP);

    $SOAPAction = 'http://services.beacukai.go.id/GetBC23Permit_FASP';
    $xml = '<?xml version="1.0" encoding="utf-8"?>
            <soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
              <soap:Body>
                <GetBC23Permit_FASP xmlns="http://services.beacukai.go.id/">
                  <UserName>' . $Username . '</UserName>
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
        $return = '<?xml version="1.0" encoding="UTF-8"?>
					  <GetBC23Permit_FASP>
							<status>failed</status>							
					  </GetBC23Permit_FASP>';
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
        $return = '<?xml version="1.0" encoding="UTF-8"?>
					  <GetSPJM>
							<status>failed</status>							
					  </GetSPJM>';
    }

    updateLogServices($IDLogServices, $return);
    $conn->disconnect();
    return $return;
}

function GetSPJM_onDemand($Username, $Password, $noPib, $tglPib) {
    global $CONF, $conn;
    $conn->connect();
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
        $return = '<?xml version="1.0" encoding="UTF-8"?>
					  <GetSPJM_onDemand>
							<status>failed</status>							
					  </GetSPJM_onDemand>';
    }

    updateLogServices($IDLogServices, $return);
    $conn->disconnect();
    return $return;
}

function GetBilling($fStream, $Username, $Password) {
    global $CONF, $conn;
    $conn->connect();
    $WSDLSOAP = 'http://103.29.187.215/cfs-center/TPSServices/sever_plp.php?wsdl';
    $IDLogServices = insertLogServices($Username, $Password, $WSDLSOAP, 'GetBilling', $fStream);
    $xml = str_replace('&', '', $fStream);
    // echo $xml;die();
    $SQLlogin = "SELECT ID FROM t_organisasi WHERE USERNAME_TPSONLINE_BC = '" . $Username . "'";
    // echo $SQLlogin;die();
    $Query = $conn->query($SQLlogin);
    if ($Query->size() > 0) {
        $Query->next();
        $KD_ORG_SENDER = $Query->get("ID");
    } else {
        $KD_ORG_SENDER = "";
    }
    $STR_DATA = $fStream;


    $SQL = "INSERT INTO mailbox (SNRF, KD_APRF, KD_ORG_SENDER, KD_ORG_RECEIVER,
                        STR_DATA, KD_STATUS, TGL_STATUS)
                VALUES (NULL,'GETBILLING', '" . $KD_ORG_SENDER . "', '1',
                        '" . $STR_DATA . "','100', NOW())";
    // echo $SQL;die();
    // print_r($SQL);die();
    $Execute = $conn->execute($SQL);
    if ($Execute != '') {
        //BEGIN
        $SQL = "SELECT a.ID, a.STR_DATA FROM mailbox a WHERE a.KD_APRF = 'GETBILLING' AND a.KD_STATUS = '100' order by a.TGL_STATUS ASC limit 5";
        // echo $SQL;die();
        $Query = $conn->query($SQL);
        if ($Query->size() > 0) {
            while ($Query->next()) {
                $ID_LOG = $Query->get("ID");
                $STR_DATA = $Query->get("STR_DATA");
                $xml = xml2ary($STR_DATA);
                if (count($xml) > 0) {
                    $xml = $xml['DOCUMENT']['_c'];
                    $countLoadBilling = 0;
                    $countLoadBilling = count($xml['LOADBILLING']);
                    if ($countLoadBilling > 1) {
                        for ($c = 0; $c < $countLoadBilling; $c++) {
                            $LOADBILLING = $xml['LOADBILLING'][$c]['_c'];
                            $header = $LOADBILLING['HEADER']['_c'];
                            $detil = $LOADBILLING['DETIL']['_c'];
                            $countTarif = 0;
                            $countTarif = count($LOADBILLING['DETIL']['_c']['TARIF']);
                            $NO_ORDER = trim($header['NO_ORDER']['_v']) == "" ? "NULL" : "" . strtoupper(trim($header['NO_ORDER']['_v'])) . "";
                            $NO_BL = trim($header['NO_BL']['_v']) == "" ? "NULL" : "" . strtoupper(trim($header['NO_BL']['_v'])) . "";
                            $message = '<?xml version="1.0" encoding="UTF-8"?>';
                            $message .= '<DOCUMENT>';
                            $message .= '<LOADBILLING>';
                            $message .= '<HEADER>';
                            $message .= '<NO_BL>' . $NO_BL . '</NO_BL>';
                            $message .= '<NO_ORDER>' . $NO_ORDER . '</NO_ORDER>';
                            if ($countTarif > 1) {
                                $chektarif = '';
                                for ($i = 0; $i < $countTarif; $i++) {
                                    $TARIF_DASAR = trim($detil['TARIF'][$i]['_c']['TARIF_DASAR']['_v']) == "" ? "NULL" : "" . strtoupper(trim($detil['TARIF'][$i]['_c']['TARIF_DASAR']['_v'])) . "";
                                    $KODE = trim($detil['TARIF'][$i]['_c']['KODE']['_v']) == "" ? "NULL" : "" . strtoupper(trim($detil['TARIF'][$i]['_c']['KODE']['_v'])) . "";
                                    $SQLKode = "SELECT a.TARIF_DASAR FROM reff_billing_cfs a WHERE a.KODE_BILL = '" . $KODE . "'";
                                    $QueryKode = $conn->query($SQLKode);
                                    $QueryKode->next();
                                    $TARIF_DASAR_CFS = $QueryKode->get("TARIF_DASAR");
                                    if ($TARIF_DASAR != $TARIF_DASAR_CFS) {
                                        $chektarif .= 'not';
                                    } else {
                                        $chektarif .= 'sama';
                                    }
                                }
                                if (strpos($chektarif, 'not') != true) {
                                    $RES = 'ACCEPT';
                                    $message .= '<RES>' . $RES . '</RESP>';
                                } else {
                                    $RES = 'REJECT';
                                    $message .= '<RES>' . $RES . '</RESP>';
                                }
                            } elseif ($countTarif == 1) {
                                $TARIF_DASAR = trim($detil['TARIF']['TARIF_DASAR']['_v']) == "" ? "NULL" : "" . strtoupper(trim($detil['TARIF']['_c']['TARIF_DASAR']['_v'])) . "";
                                $KODE = trim($detil['TARIF']['KODE']['_v']) == "" ? "NULL" : "" . strtoupper(trim($detil['TARIF']['_c']['KODE']['_v'])) . "";
                                $SQLKode = "SELECT a.TARIF_DASAR FROM reff_billing_cfs a WHERE a.KODE_BILL = '" . $KODE . "'";
                                $QueryKode = $conn->query($SQLKode);
                                $QueryKode->next();
                                $TARIF_DASAR_CFS = $QueryKode->get("TARIF_DASAR");
                                if ($TARIF_DASAR != $TARIF_DASAR_CFS) {
                                    $RES = 'REJECT';
                                    $message .= '<RES>' . $RES . '</RESP>';
                                } else {
                                    $RES = 'ACCEPT';
                                    $message .= '<RES>' . $RES . '</RESP>';
                                }
                            }
                            $message .= '</HEADER>';
                            $message .= '<DETIL>';
                            if ($countTarif > 1) {

                                for ($i = 0; $i < $countTarif + 1; $i++) {
                                    $TARIF_DASAR = trim($detil['TARIF'][$i]['TARIF_DASAR']['_v']) == "" ? "NULL" : "" . strtoupper(trim($detil['TARIF'][$i]['TARIF_DASAR']['_v'])) . "";
                                    $KODE = trim($detil['TARIF'][$i]['KODE']['_v']) == "" ? "NULL" : "" . strtoupper(trim($detil['TARIF'][$i]['KODE']['_v'])) . "";
                                    $SQLKode = "SELECT a.TARIF_DASAR FROM reff_billing_cfs a WHERE a.KODE_BILL = '" . $KODE . "'";
                                    $QueryKode = $conn->query($SQLKode);
                                    $QueryKode->next();
                                    $TARIF_DASAR_CFS = $QueryKode->get("TARIF_DASAR");
                                    if ($TARIF_DASAR != $TARIF_DASAR_CFS) {
                                        $message .= '<KD_TARIF>' . $KODE . '</KD_TARIF>';
                                    }
                                }
                            } elseif ($countTarif == 1) {
                                $TARIF_DASAR = trim($detil['TARIF']['TARIF_DASAR']['_v']) == "" ? "NULL" : "" . strtoupper(trim($detil['TARIF']['TARIF_DASAR']['_v'])) . "";
                                $KODE = trim($detil['TARIF']['KODE']['_v']) == "" ? "NULL" : "" . strtoupper(trim($detil['TARIF']['KODE']['_v'])) . "";
                                $SQLKode = "SELECT a.TARIF_DASAR FROM reff_billing_cfs a WHERE a.KODE_BILL = '" . $KODE . "'";
                                $QueryKode = $conn->query($SQLKode);
                                $QueryKode->next();
                                $TARIF_DASAR_CFS = $QueryKode->get("TARIF_DASAR");
                                if ($TARIF_DASAR != $TARIF_DASAR_CFS) {
                                    $message .= '<KD_TARIF>' . $KODE . '</KD_TARIF>';
                                }
                            }
                            $message .= '</DETIL>';
                            $message .= '</LOADBILLING>';
                            $message .= '</DOCUMENT>';
                            InsertBilling($LOADBILLING, $countTarif, $RES);
                        }
                    } elseif ($countLoadBilling == 1) {
                        $LOADBILLING = $xml['LOADBILLING']['_c'];
                        $header = $LOADBILLING['HEADER']['_c'];
                        $detil = $LOADBILLING['DETIL']['_c'];
                        $countTarif = 0;
                        $countTarif = count($LOADBILLING['DETIL']['_c']['TARIF']);
                        $NO_ORDER = trim($header['NO_ORDER']['_v']) == "" ? "NULL" : "" . strtoupper(trim($header['NO_ORDER']['_v'])) . "";
                        $NO_BL = trim($header['NO_BL']['_v']) == "" ? "NULL" : "" . strtoupper(trim($header['NO_BL']['_v'])) . "";

                        $message = '<?xml version="1.0" encoding="UTF-8"?>';
                        $message .= '<DOCUMENT>';
                        $message .= '<LOADBILLING>';
                        $message .= '<HEADER>';
                        $message .= '<NO_BL>' . $NO_BL . '</NO_BL>';
                        $message .= '<NO_ORDER>' . $NO_ORDER . '</NO_ORDER>';
                        if ($countTarif > 1) {
                            $chektarif = '';
                            for ($i = 0; $i < $countTarif; $i++) {
                                $TARIF_DASAR = trim($detil['TARIF'][$i]['_c']['TARIF_DASAR']['_v']) == "" ? "NULL" : "" . strtoupper(trim($detil['TARIF'][$i]['_c']['TARIF_DASAR']['_v'])) . "";
                                $KODE = trim($detil['TARIF'][$i]['_c']['KODE']['_v']) == "" ? "NULL" : "" . strtoupper(trim($detil['TARIF'][$i]['_c']['KODE']['_v'])) . "";
                                // print_r($KODE);die();
                                $SQLKode = "SELECT a.TARIF_DASAR FROM reff_billing_cfs a WHERE a.KODE_BILL = '" . $KODE . "'";
                                $QueryKode = $conn->query($SQLKode);
                                $QueryKode->next();
                                $TARIF_DASAR_CFS = $QueryKode->get("TARIF_DASAR");
                                // print_r($TARIF_DASAR_CFS);die();
                                if ($TARIF_DASAR != $TARIF_DASAR_CFS) {
                                    $chektarif .= 'not';
                                } else {
                                    $chektarif .= 'sama';
                                }
                            }
                            if (strpos($chektarif, 'not') != true) {
                                $RES = 'ACCEPT';
                                $message .= '<RES>' . $RES . '</RESP>';
                            } else {
                                $RES = 'REJECT';
                                $message .= '<RES>' . $RES . '</RESP>';
                            }
                        } elseif ($countTarif == 1) {
                            $TARIF_DASAR = trim($detil['TARIF']['TARIF_DASAR']['_v']) == "" ? "NULL" : "" . strtoupper(trim($detil['TARIF']['_c']['TARIF_DASAR']['_v'])) . "";
                            $KODE = trim($detil['TARIF']['KODE']['_v']) == "" ? "NULL" : "" . strtoupper(trim($detil['TARIF']['_c']['KODE']['_v'])) . "";
                            $SQLKode = "SELECT a.TARIF_DASAR FROM reff_billing_cfs a WHERE a.KODE_BILL = '" . $KODE . "'";
                            $QueryKode = $conn->query($SQLKode);
                            $QueryKode->next();
                            $TARIF_DASAR_CFS = $QueryKode->get("TARIF_DASAR");
                            if ($TARIF_DASAR != $TARIF_DASAR_CFS) {
                                $RES = 'REJECT';
                                $message .= '<RES>' . $RES . '</RESP>';
                            } else {
                                $RES = 'ACCEPT';
                                $message .= '<RES>' . $RES . '</RESP>';
                            }
                        }

                        $message .= '</HEADER>';
                        $message .= '<DETIL>';
                        if ($countTarif > 1) {
                            for ($i = 0; $i < $countTarif; $i++) {
                                $TARIF_DASAR = trim($detil['TARIF'][$i]['_c']['TARIF_DASAR']['_v']) == "" ? "NULL" : "" . strtoupper(trim($detil['TARIF'][$i]['_c']['TARIF_DASAR']['_v'])) . "";
                                $KODE = trim($detil['TARIF'][$i]['_c']['KODE']['_v']) == "" ? "NULL" : "" . strtoupper(trim($detil['TARIF'][$i]['_c']['KODE']['_v'])) . "";
                                $SQLKode = "SELECT a.TARIF_DASAR FROM reff_billing_cfs a WHERE a.KODE_BILL = '" . $KODE . "'";
                                $QueryKode = $conn->query($SQLKode);
                                $QueryKode->next();
                                $TARIF_DASAR_CFS = $QueryKode->get("TARIF_DASAR");
                                if ($TARIF_DASAR != $TARIF_DASAR_CFS) {
                                    $message .= '<KD_TARIF>' . $KODE . '</KD_TARIF>';
                                }
                            }
                        } elseif ($countTarif == 1) {
                            $TARIF_DASAR = trim($detil['TARIF']['TARIF_DASAR']['_v']) == "" ? "NULL" : "" . strtoupper(trim($detil['TARIF']['_c']['TARIF_DASAR']['_v'])) . "";
                            $KODE = trim($detil['TARIF']['KODE']['_v']) == "" ? "NULL" : "" . strtoupper(trim($detil['TARIF']['_c']['KODE']['_v'])) . "";
                            $SQLKode = "SELECT a.TARIF_DASAR FROM reff_billing_cfs a WHERE a.KODE_BILL = '" . $KODE . "'";
                            $QueryKode = $conn->query($SQLKode);
                            $QueryKode->next();
                            $TARIF_DASAR_CFS = $QueryKode->get("TARIF_DASAR");
                            if ($TARIF_DASAR != $TARIF_DASAR_CFS) {
                                $message .= '<KD_TARIF>' . $KODE . '</KD_TARIF>';
                            }
                        }
                        $message .= '</DETIL>';
                        $message .= '</LOADBILLING>';
                        $message .= '</DOCUMENT>';
                        // print_r($RES);die();
                        InsertBilling($LOADBILLING, $countTarif, $RES);
                    }

                    /* if($countLoadBilling > 0){
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
                      } */
                } else {
                    /* $SQL = "UPDATE app_log_services SET FL_USED = '1', WK_USED = NOW() WHERE ID = '" . $ID_LOG . "'";
                      $Execute = $conn->execute($SQL);

                      $SQL = "INSERT INTO app_log_services_failed SELECT * FROM app_log_services WHERE ID = '" . $ID_LOG . "'";
                      $Execute = $conn->execute($SQL);

                      if($Execute){
                      $SQL = "DELETE FROM app_log_services WHERE ID = '" . $ID_LOG . "'";
                      $Execute = $conn->execute($SQL);
                      } */
                }

                // echo $SQL . '<br>';
            }
        } else {
            echo 'data tidak ada.';
        }
        // $return = "Proses Berhasil Tersimpan di Portal CFS";
    } else {
        $return = "Proses GAGAL Tersimpan di Portal CFS";
    }
    $return = $message;
    updateLogServices($IDLogServices, $return);
    $conn->disconnect();
    return $return;
}

function OrderPengeluaranBarang($fStream, $Username, $Password) {
    global $CONF, $conn;
    $conn->connect();
    $WSDLSOAP = 'http://103.29.187.215/cfs-center/TPSServices/sever_plp.php?wsdl';
    $IDLogServices = insertLogServices($Username, $Password, $WSDLSOAP, 'OrderPengeluaranBarang', $fStream);
    $xml = str_replace('&', '', $fStream);
    // echo $xml;die();
    $SQLlogin = "SELECT ID FROM t_organisasi WHERE USERNAME_TPSONLINE_BC = '" . $Username . "'";
    // echo $SQLlogin;die();
    $Query = $conn->query($SQLlogin);
    if ($Query->size() > 0) {
        $Query->next();
        $KD_ORG_SENDER = $Query->get("ID");
    } else {
        $KD_ORG_SENDER = "";
    }
    $STR_DATA = $fStream;
    $xml = xml2ary($STR_DATA);
    // print_r($xml);die();

    if (count($xml) > 0) {
        $xml = $xml['DOCUMENT']['_c'];
        // print_r($xml);die();
        $OrderPB = $xml['ORDERPENGELUARANBARANG']['_c'];
        // print_r($OrderPB);die();
        $KD_GUDANG = trim($OrderPB['KD_GUDANG']['_v']) == "" ? "NULL" : "" . strtoupper(trim($OrderPB['KD_GUDANG']['_v'])) . "";
        // print_r($KD_GUDANG);die();
        $SQLHeader = "SELECT A.ID, A.NO_ORDER, A.JENIS_BILLING, DATE_FORMAT(A.TGL_KELUAR,'%Y%m%d') AS TGL_KELUAR, A.NO_MASTER_BL_AWB, 
    	DATE_FORMAT(A.TGL_MASTER_BL_AWB,'%Y%m%d') AS TGL_MASTER_BL_AWB, A.NO_BL_AWB, DATE_FORMAT(A.TGL_BL_AWB,'%Y%m%d') AS TGL_BL_AWB, A.NO_DO, 
    	DATE_FORMAT(A.TGL_DO,'%Y%m%d') AS TGL_DO, DATE_FORMAT(A.TGL_EXPIRED_DO,'%Y%m%d') AS TGL_EXPIRED_DO, A.NAMA_FORWARDER, A.NPWP_FORWARDER, 
    	A.NO_PERMOHONAN_CFS, A.KD_TPS_ASAL, A.KD_TPS_TUJUAN, A.KD_GUDANG_ASAL, A.KD_GUDANG_TUJUAN, A.NO_BC11, DATE_FORMAT(A.TGL_BC11,'%Y%m%d') AS TGL_BC11, A.NO_CONT_ASAL, 
    	A.KD_DOK_INOUT, A.NO_DOK, DATE_FORMAT(A.TGL_DOK,'%Y%m%d') AS TGL_DOK, A.CONSIGNEE, A.NPWP_CONSIGNEE, A.NM_ANGKUT, A.NO_VOYAGE, 
    	DATE_FORMAT(A.TGL_TIBA,'%Y%m%d') AS TGL_TIBA, A.KD_GUDANG
    	FROM t_order_hdr A WHERE A.KD_GUDANG = '" . $KD_GUDANG . "' AND A.`STATUS` = 'DRAFT'";

        $QueryHeader = $conn->query($SQLHeader);
        if ($QueryHeader->size() > 1) {
            while ($QueryHeader->next()) {
                $QueryHeader->next();
                $ID = $QueryHeader->get("ID");
                $NO_ORDER = $QueryHeader->get("NO_ORDER");
                $JENIS_BILLING = $QueryHeader->get("JENIS_BILLING");
                $TGL_KELUAR = $QueryHeader->get("TGL_KELUAR");
                $NO_MASTER_BL_AWB = $QueryHeader->get("NO_MASTER_BL_AWB");
                $TGL_MASTER_BL_AWB = $QueryHeader->get("TGL_MASTER_BL_AWB");
                $NO_BL_AWB = $QueryHeader->get("NO_BL_AWB");
                $TGL_BL_AWB = $QueryHeader->get("TGL_BL_AWB");
                $NO_DO = $QueryHeader->get("NO_DO");
                $TGL_DO = $QueryHeader->get("TGL_DO");
                $TGL_EXPIRED_DO = $QueryHeader->get("TGL_EXPIRED_DO");
                $NAMA_FORWARDER = $QueryHeader->get("NAMA_FORWARDER");
                $NPWP_FORWARDER = $QueryHeader->get("NPWP_FORWARDER");
                $NO_PERMOHONAN_CFS = $QueryHeader->get("NO_PERMOHONAN_CFS");
                $KD_TPS_ASAL = $QueryHeader->get("KD_TPS_ASAL");
                $KD_TPS_TUJUAN = $QueryHeader->get("KD_TPS_TUJUAN");
                $KD_GUDANG_ASAL = $QueryHeader->get("KD_GUDANG_ASAL");
                $KD_GUDANG_TUJUAN = $QueryHeader->get("KD_GUDANG_TUJUAN");
                $NO_BC11 = $QueryHeader->get("NO_BC11");
                $TGL_BC11 = $QueryHeader->get("TGL_BC11");
                $NO_CONT_ASAL = $QueryHeader->get("NO_CONT_ASAL");
                $KD_DOK_INOUT = $QueryHeader->get("KD_DOK_INOUT");
                $NO_DOK = $QueryHeader->get("NO_DOK");
                $TGL_DOK = $QueryHeader->get("TGL_DOK");
                $CONSIGNEE = $QueryHeader->get("CONSIGNEE");
                $NPWP_CONSIGNEE = $QueryHeader->get("NPWP_CONSIGNEE");
                $NO_VOYAGE = $QueryHeader->get("NO_VOYAGE");
                $TGL_TIBA = $QueryHeader->get("TGL_TIBA");
                $KD_GUDANG = $QueryHeader->get("KD_GUDANG");

                //create xml
                $message = '<?xml version="1.0" encoding="UTF-8"?>';
                $message .= '<DOCUMENT>';
                $message .= '<ORDERPENGELUARANBARANG>';
                $message .= '<HEADER>';
                $message .= '<NO_ORDER>' . $NO_ORDER . '</NO_ORDER>';
                $message .= '<JENIS_BILLING>' . $JENIS_BILLING . '</JENIS_BILLING>';
                $message .= '<TGL_KELUAR>' . $TGL_KELUAR . '</TGL_KELUAR>';
                $message .= '<NO_MASTER_BL_AWB>' . $NO_MASTER_BL_AWB . '</NO_MASTER_BL_AWB>';
                $message .= '<TGL_MASTER_BL_AWB>' . $TGL_MASTER_BL_AWB . '</TGL_MASTER_BL_AWB>';
                $message .= '<NO_BL_AWB>' . $NO_BL_AWB . '</NO_BL_AWB>';
                $message .= '<TGL_BL_AWB>' . $TGL_BL_AWB . '</TGL_BL_AWB>';
                $message .= '<NO_DO>' . $NO_DO . '</NO_DO>';
                $message .= '<TGL_DO>' . $TGL_DO . '</TGL_DO>';
                $message .= '<TGL_EXPIRED_DO>' . $TGL_EXPIRED_DO . '</TGL_EXPIRED_DO>';
                $message .= '<NAMA_FORWARDER>' . $NAMA_FORWARDER . '</NAMA_FORWARDER>';
                $message .= '<NPWP_FORWARDER>' . $NPWP_FORWARDER . '</NPWP_FORWARDER>';
                $message .= '<NO_PERMOHONAN_CFS>' . $NO_PERMOHONAN_CFS . '</NO_PERMOHONAN_CFS>';
                $message .= '<KD_TPS_ASAL>' . $NKD_TPS_ASALO_ORDER . '</KD_TPS_ASAL>';
                $message .= '<KD_TPS_TUJUAN>' . $KD_TPS_TUJUAN . '</KD_TPS_TUJUAN>';
                $message .= '<KD_GUDANG_ASAL>' . $KD_GUDANG_ASAL . '</KD_GUDANG_ASAL>';
                $message .= '<KD_GUDANG_TUJUAN>' . $KD_GUDANG_TUJUAN . '</KD_GUDANG_TUJUAN>';
                $message .= '<NO_BC11>' . $NO_BC11 . '</NO_BC11>';
                $message .= '<TGL_BC11>' . $TGL_BC11 . '</TGL_BC11>';
                $message .= '<NO_CONT_ASAL>' . $NO_CONT_ASAL . '</NO_CONT_ASAL>';
                $message .= '<KD_DOK_INOUT>' . $KD_DOK_INOUT . '</KD_DOK_INOUT>';
                $message .= '<NO_DOK>' . $NO_DOK . '</NO_DOK>';
                $message .= '<TGL_DOK>' . $TGL_DOK . '</TGL_DOK>';
                $message .= '<CONSIGNEE>' . $CONSIGNEE . '</CONSIGNEE>';
                $message .= '<NPWP_CONSIGNEE>' . $NPWP_CONSIGNEE . '</NPWP_CONSIGNEE>';
                $message .= '<NO_VOYAGE>' . $NO_VOYAGE . '</NO_VOYAGE>';
                $message .= '<TGL_TIBA>' . $TGL_TIBA . '</TGL_TIBA>';
                $message .= '<KD_GUDANG>' . $KD_GUDANG . '</KD_GUDANG>';
                $message .= '</HEADER>';

                $SQLDetilCont = "SELECT A.NO_CONT, A.KD_UK_CONT, A.KD_CONT_JENIS FROM t_order_cont WHERE A.ID = '" . $ID . "'";
                $QueryDetilCont = $conn->query($SQLDetilCont);
                if ($QueryDetilCont->size() > 0) {
                    if ($QueryDetilCont->size() > 1) {
                        while ($QueryDetilCont->next()) {
                            $NO_CONT = $QueryDetilCont->get("NO_CONT");
                            $KD_UK_CONT = $QueryDetilCont->get("KD_UK_CONT");
                            $message .= '<DETIL_CONT>';
                            $message .= '<CONTAINER>';
                            $message .= '<NO_CONT>' . $NO_CONT . '</NO_CONT>';
                            $message .= '<KD_CONT_UKURAN>' . $KD_UK_CONT . '</KD_CONT_UKURAN>';
                            $message .= '</CONTAINER>';
                            $message .= '</DETIL_CONT>';
                        }
                    } elseif ($QueryDetilCont->size() == 1) {
                        $QueryDetilCont->next();
                        $NO_CONT = $QueryDetilCont->get("NO_CONT");
                        $KD_UK_CONT = $QueryDetilCont->get("KD_UK_CONT");
                        $message .= '<DETIL_CONT>';
                        $message .= '<CONTAINER>';
                        $message .= '<NO_CONT>' . $NO_CONT . '</NO_CONT>';
                        $message .= '<KD_CONT_UKURAN>' . $KD_UK_CONT . '</KD_CONT_UKURAN>';
                        $message .= '</CONTAINER>';
                        $message .= '</DETIL_CONT>';
                    }
                } else {
                    $message .= '<DETIL_CONT>';
                    $message .= '<CONTAINER>';
                    $message .= '<NO_CONT></NO_CONT>';
                    $message .= '<KD_CONT_UKURAN></KD_CONT_UKURAN>';
                    $message .= '</CONTAINER>';
                    $message .= '</DETIL_CONT>';
                }

                $SQLDetilKms = "SELECT A.JNS_KMS, A.MERK_KMS, A.JML_KMS FROM t_order_kms WHERE A.ID = '" . $ID . "'";
                $QueryDetilKms = $conn->query($SQLDetilKms);
                if ($QueryDetilKms->size() > 0) {
                    if ($QueryDetilKms->size() > 1) {
                        while ($QueryDetilKms->next()) {
                            $JNS_KMS = $QueryDetilKms->get("JNS_KMS");
                            $MERK_KMS = $QueryDetilKms->get("MERK_KMS");
                            $JML_KMS = $QueryDetilKms->get("JML_KMS");
                            $message .= '<DETIL_KMS>';
                            $message .= '<KEMASAN>';
                            $message .= '<JNS_KMS>' . $JNS_KMS . '</JNS_KMS>';
                            $message .= '<MERK_KMS>' . $MERK_KMS . '</MERK_KMS>';
                            $message .= '<JML_KMS>' . $JML_KMS . '</JML_KMS>';
                            $message .= '</KEMASAN>';
                            $message .= '</DETIL_KMS>';
                        }
                    } elseif ($QueryDetilKms->size() == 1) {
                        $QueryDetilKms->next();
                        $JNS_KMS = $QueryDetilKms->get("JNS_KMS");
                        $MERK_KMS = $QueryDetilKms->get("MERK_KMS");
                        $JML_KMS = $QueryDetilKms->get("JML_KMS");
                        $message .= '<DETIL_KMS>';
                        $message .= '<KEMASAN>';
                        $message .= '<JNS_KMS>' . $JNS_KMS . '</JNS_KMS>';
                        $message .= '<MERK_KMS>' . $MERK_KMS . '</MERK_KMS>';
                        $message .= '<JML_KMS>' . $JML_KMS . '</JML_KMS>';
                        $message .= '</KEMASAN>';
                        $message .= '</DETIL_KMS>';
                    }
                } else {
                    $message .= '<DETIL_KMS>';
                    $message .= '<KEMASAN>';
                    $message .= '<NO_CONT></NO_CONT>';
                    $message .= '<KD_CONT_UKURAN></KD_CONT_UKURAN>';
                    $message .= '</KEMASAN>';
                    $message .= '</DETIL_KMS>';
                }

                $message .= '</ORDERPENGELUARANBARANG>';
                $message .= '</DOCUMENT>';
            }
        } elseif ($QueryHeader->size() == 1) {
            $QueryHeader->next();
            $ID = $QueryHeader->get("ID");
            $NO_ORDER = $QueryHeader->get("NO_ORDER");
            $JENIS_BILLING = $QueryHeader->get("JENIS_BILLING");
            $TGL_KELUAR = $QueryHeader->get("TGL_KELUAR");
            $NO_MASTER_BL_AWB = $QueryHeader->get("NO_MASTER_BL_AWB");
            $TGL_MASTER_BL_AWB = $QueryHeader->get("TGL_MASTER_BL_AWB");
            $NO_BL_AWB = $QueryHeader->get("NO_BL_AWB");
            $TGL_BL_AWB = $QueryHeader->get("TGL_BL_AWB");
            $NO_DO = $QueryHeader->get("NO_DO");
            $TGL_DO = $QueryHeader->get("TGL_DO");
            $TGL_EXPIRED_DO = $QueryHeader->get("TGL_EXPIRED_DO");
            $NAMA_FORWARDER = $QueryHeader->get("NAMA_FORWARDER");
            $NPWP_FORWARDER = $QueryHeader->get("NPWP_FORWARDER");
            $NO_PERMOHONAN_CFS = $QueryHeader->get("NO_PERMOHONAN_CFS");
            $KD_TPS_ASAL = $QueryHeader->get("KD_TPS_ASAL");
            $KD_TPS_TUJUAN = $QueryHeader->get("KD_TPS_TUJUAN");
            $KD_GUDANG_ASAL = $QueryHeader->get("KD_GUDANG_ASAL");
            $KD_GUDANG_TUJUAN = $QueryHeader->get("KD_GUDANG_TUJUAN");
            $NO_BC11 = $QueryHeader->get("NO_BC11");
            $TGL_BC11 = $QueryHeader->get("TGL_BC11");
            $NO_CONT_ASAL = $QueryHeader->get("NO_CONT_ASAL");
            $KD_DOK_INOUT = $QueryHeader->get("KD_DOK_INOUT");
            $NO_DOK = $QueryHeader->get("NO_DOK");
            $TGL_DOK = $QueryHeader->get("TGL_DOK");
            $CONSIGNEE = $QueryHeader->get("CONSIGNEE");
            $NPWP_CONSIGNEE = $QueryHeader->get("NPWP_CONSIGNEE");
            $NO_VOYAGE = $QueryHeader->get("NO_VOYAGE");
            $TGL_TIBA = $QueryHeader->get("TGL_TIBA");
            $KD_GUDANG = $QueryHeader->get("KD_GUDANG");
            // print_r($NO_MASTER_BL_AWB);die();
            //create xml
            $message = '<?xml version="1.0" encoding="UTF-8"?>';
            $message .= '<DOCUMENT>';
            $message .= '<ORDERPENGELUARANBARANG>';
            $message .= '<HEADER>';
            $message .= '<NO_ORDER>' . $NO_ORDER . '</NO_ORDER>';
            $message .= '<JENIS_BILLING>' . $JENIS_BILLING . '</JENIS_BILLING>';
            $message .= '<TGL_KELUAR>' . $TGL_KELUAR . '</TGL_KELUAR>';
            $message .= '<NO_MASTER_BL_AWB>' . $NO_MASTER_BL_AWB . '</NO_MASTER_BL_AWB>';
            $message .= '<TGL_MASTER_BL_AWB>' . $TGL_MASTER_BL_AWB . '</TGL_MASTER_BL_AWB>';
            $message .= '<NO_BL_AWB>' . $NO_BL_AWB . '</NO_BL_AWB>';
            $message .= '<TGL_BL_AWB>' . $TGL_BL_AWB . '</TGL_BL_AWB>';
            $message .= '<NO_DO>' . $NO_DO . '</NO_DO>';
            $message .= '<TGL_DO>' . $TGL_DO . '</TGL_DO>';
            $message .= '<TGL_EXPIRED_DO>' . $TGL_EXPIRED_DO . '</TGL_EXPIRED_DO>';
            $message .= '<NAMA_FORWARDER>' . $NAMA_FORWARDER . '</NAMA_FORWARDER>';
            $message .= '<NPWP_FORWARDER>' . $NPWP_FORWARDER . '</NPWP_FORWARDER>';
            $message .= '<NO_PERMOHONAN_CFS>' . $NO_PERMOHONAN_CFS . '</NO_PERMOHONAN_CFS>';
            $message .= '<KD_TPS_ASAL>' . $NKD_TPS_ASALO_ORDER . '</KD_TPS_ASAL>';
            $message .= '<KD_TPS_TUJUAN>' . $KD_TPS_TUJUAN . '</KD_TPS_TUJUAN>';
            $message .= '<KD_GUDANG_ASAL>' . $KD_GUDANG_ASAL . '</KD_GUDANG_ASAL>';
            $message .= '<KD_GUDANG_TUJUAN>' . $KD_GUDANG_TUJUAN . '</KD_GUDANG_TUJUAN>';
            $message .= '<NO_BC11>' . $NO_BC11 . '</NO_BC11>';
            $message .= '<TGL_BC11>' . $TGL_BC11 . '</TGL_BC11>';
            $message .= '<NO_CONT_ASAL>' . $NO_CONT_ASAL . '</NO_CONT_ASAL>';
            $message .= '<KD_DOK_INOUT>' . $KD_DOK_INOUT . '</KD_DOK_INOUT>';
            $message .= '<NO_DOK>' . $NO_DOK . '</NO_DOK>';
            $message .= '<TGL_DOK>' . $TGL_DOK . '</TGL_DOK>';
            $message .= '<CONSIGNEE>' . $CONSIGNEE . '</CONSIGNEE>';
            $message .= '<NPWP_CONSIGNEE>' . $NPWP_CONSIGNEE . '</NPWP_CONSIGNEE>';
            $message .= '<NO_VOYAGE>' . $NO_VOYAGE . '</NO_VOYAGE>';
            $message .= '<TGL_TIBA>' . $TGL_TIBA . '</TGL_TIBA>';
            $message .= '<KD_GUDANG>' . $KD_GUDANG . '</KD_GUDANG>';
            $message .= '</HEADER>';

            $SQLDetilCont = "SELECT A.NO_CONT, A.KD_UK_CONT, A.KD_CONT_JENIS FROM t_order_cont WHERE A.ID = '" . $ID . "'";
            $QueryDetilCont = $conn->query($SQLDetilCont);
            if ($QueryDetilCont->size() > 0) {
                if ($QueryDetilCont->size() > 1) {
                    while ($QueryDetilCont->next()) {
                        $NO_CONT = $QueryDetilCont->get("NO_CONT");
                        $KD_UK_CONT = $QueryDetilCont->get("KD_UK_CONT");
                        $message .= '<DETIL_CONT>';
                        $message .= '<CONTAINER>';
                        $message .= '<NO_CONT>' . $NO_CONT . '</NO_CONT>';
                        $message .= '<KD_CONT_UKURAN>' . $KD_UK_CONT . '</KD_CONT_UKURAN>';
                        $message .= '</CONTAINER>';
                        $message .= '</DETIL_CONT>';
                    }
                } elseif ($QueryDetilCont->size() == 1) {
                    $QueryDetilCont->next();
                    $NO_CONT = $QueryDetilCont->get("NO_CONT");
                    $KD_UK_CONT = $QueryDetilCont->get("KD_UK_CONT");
                    $message .= '<DETIL_CONT>';
                    $message .= '<CONTAINER>';
                    $message .= '<NO_CONT>' . $NO_CONT . '</NO_CONT>';
                    $message .= '<KD_CONT_UKURAN>' . $KD_UK_CONT . '</KD_CONT_UKURAN>';
                    $message .= '</CONTAINER>';
                    $message .= '</DETIL_CONT>';
                }
            } else {
                $message .= '<DETIL_CONT>';
                $message .= '<CONTAINER>';
                $message .= '<NO_CONT></NO_CONT>';
                $message .= '<KD_CONT_UKURAN></KD_CONT_UKURAN>';
                $message .= '</CONTAINER>';
                $message .= '</DETIL_CONT>';
            }

            $SQLDetilKms = "SELECT A.JNS_KMS, A.MERK_KMS, A.JML_KMS FROM t_order_kms WHERE A.ID = '" . $ID . "'";
            $QueryDetilKms = $conn->query($SQLDetilKms);
            if ($QueryDetilKms->size() > 0) {
                if ($QueryDetilKms->size() > 1) {
                    while ($QueryDetilKms->next()) {
                        $JNS_KMS = $QueryDetilKms->get("JNS_KMS");
                        $MERK_KMS = $QueryDetilKms->get("MERK_KMS");
                        $JML_KMS = $QueryDetilKms->get("JML_KMS");
                        $message .= '<DETIL_KMS>';
                        $message .= '<KEMASAN>';
                        $message .= '<JNS_KMS>' . $JNS_KMS . '</JNS_KMS>';
                        $message .= '<MERK_KMS>' . $MERK_KMS . '</MERK_KMS>';
                        $message .= '<JML_KMS>' . $JML_KMS . '</JML_KMS>';
                        $message .= '</KEMASAN>';
                        $message .= '</DETIL_KMS>';
                    }
                } elseif ($QueryDetilKms->size() == 1) {
                    $QueryDetilKms->next();
                    $JNS_KMS = $QueryDetilKms->get("JNS_KMS");
                    $MERK_KMS = $QueryDetilKms->get("MERK_KMS");
                    $JML_KMS = $QueryDetilKms->get("JML_KMS");
                    $message .= '<DETIL_KMS>';
                    $message .= '<KEMASAN>';
                    $message .= '<JNS_KMS>' . $JNS_KMS . '</JNS_KMS>';
                    $message .= '<MERK_KMS>' . $MERK_KMS . '</MERK_KMS>';
                    $message .= '<JML_KMS>' . $JML_KMS . '</JML_KMS>';
                    $message .= '</KEMASAN>';
                    $message .= '</DETIL_KMS>';
                }
            } else {
                $message .= '<DETIL_KMS>';
                $message .= '<KEMASAN>';
                $message .= '<NO_CONT></NO_CONT>';
                $message .= '<KD_CONT_UKURAN></KD_CONT_UKURAN>';
                $message .= '</KEMASAN>';
                $message .= '</DETIL_KMS>';
            }

            $message .= '</ORDERPENGELUARANBARANG>';
            $message .= '</DOCUMENT>';
        }
    }


    $return = $message;
    updateLogServices($IDLogServices, $return);
    $conn->disconnect();
    return $return;
}

function ConfirmTagihanPenimbunan($fStream, $Username, $Password) {
    global $CONF, $conn;
    $conn->connect();
    $WSDLSOAP = 'http://103.29.187.215/cfs-center/TPSServices/sever_plp.php?wsdl';
    $IDLogServices = insertLogServices($Username, $Password, $WSDLSOAP, 'ConfirmTagihanPenimbunan', $fStream);

    $xml = str_replace('&', '', $fStream);
    // echo $xml;die();
    $SQLlogin = "SELECT ID FROM t_organisasi WHERE USERNAME_TPSONLINE_BC = '" . $Username . "'";
    // echo $SQLlogin;die();
    $Query = $conn->query($SQLlogin);
    if ($Query->size() > 0) {
        $Query->next();
        $KD_ORG_SENDER = $Query->get("ID");
    } else {
        $KD_ORG_SENDER = "";
    }
    $STR_DATA = $fStream;


    $SQL = "INSERT INTO mailbox (SNRF, KD_APRF, KD_ORG_SENDER, KD_ORG_RECEIVER,
                        STR_DATA, KD_STATUS, TGL_STATUS)
                VALUES (NULL,'ConfirmTagihanPenimbunan', '" . $KD_ORG_SENDER . "', '1',
                        '" . $STR_DATA . "','100', NOW())";
    // echo $SQL;die();
    // print_r($SQL);die();
    $Execute = $conn->execute($SQL);
    if ($Execute != '') {
        $return = "Proses Berhasil Tersimpan di Portal CFS";
    } else {
        $return = "Proses GAGAL Tersimpan di Portal CFS";
    }
    updateLogServices($IDLogServices, $return);
    $conn->disconnect();
    return $return;
}

function ConfirmTagihanPLP($fStream, $Username, $Password) {
    global $CONF, $conn;
    $conn->connect();
    $WSDLSOAP = 'http://103.29.187.215/cfs-center/TPSServices/sever_plp.php?wsdl';
    $IDLogServices = insertLogServices($Username, $Password, $WSDLSOAP, 'ConfirmTagihanPLP', $fStream);

    $xml = str_replace('&', '', $fStream);
    // echo $xml;die();
    $SQLlogin = "SELECT ID FROM t_organisasi WHERE USERNAME_TPSONLINE_BC = '" . $Username . "'";
    // echo $SQLlogin;die();
    $Query = $conn->query($SQLlogin);
    if ($Query->size() > 0) {
        $Query->next();
        $KD_ORG_SENDER = $Query->get("ID");
    } else {
        $KD_ORG_SENDER = "";
    }
    $STR_DATA = $fStream;


    $SQL = "INSERT INTO mailbox (SNRF, KD_APRF, KD_ORG_SENDER, KD_ORG_RECEIVER,
                        STR_DATA, KD_STATUS, TGL_STATUS)
                VALUES (NULL,'ConfirmTagihanPLP', '" . $KD_ORG_SENDER . "', '1',
                        '" . $STR_DATA . "','100', NOW())";
    // echo $SQL;die();
    // print_r($SQL);die();
    $Execute = $conn->execute($SQL);
    if ($Execute != '') {
        $return = "Proses Berhasil Tersimpan di Portal CFS";
    } else {
        $return = "Proses GAGAL Tersimpan di Portal CFS";
    }
    updateLogServices($IDLogServices, $return);
    $conn->disconnect();
    return $return;
}

function ValidasiTagihanPenimbunan($fStream, $Username, $Password) {
    global $CONF, $conn;
    $conn->connect();
    $WSDLSOAP = 'http://103.29.187.215/cfs-center/TPSServices/sever_plp.php?wsdl';
    $IDLogServices = insertLogServices($Username, $Password, $WSDLSOAP, 'ValidasiTagihanPenimbunan', $fStream);

    $xml = str_replace('&', '', $fStream);
    // echo $xml;die();
    $SQLlogin = "SELECT ID FROM t_organisasi WHERE USERNAME_TPSONLINE_BC = '" . $Username . "'";
    // echo $SQLlogin;die();
    $Query = $conn->query($SQLlogin);
    if ($Query->size() > 0) {
        $Query->next();
        $KD_ORG_SENDER = $Query->get("ID");
    } else {
        $KD_ORG_SENDER = "";
    }
    $STR_DATA = $fStream;


    $SQL = "INSERT INTO mailbox (SNRF, KD_APRF, KD_ORG_SENDER, KD_ORG_RECEIVER,
                        STR_DATA, KD_STATUS, TGL_STATUS)
                VALUES (NULL,'ValidasiTagihanPenimbunan', '" . $KD_ORG_SENDER . "', '1',
                        '" . $STR_DATA . "','100', NOW())";
    // echo $SQL;die();
    // print_r($SQL);die();
    $Execute = $conn->execute($SQL);
    if ($Execute != '') {
        $return = "Proses Berhasil Tersimpan di Portal CFS";
    } else {
        $return = "Proses GAGAL Tersimpan di Portal CFS";
    }
    updateLogServices($IDLogServices, $return);
    $conn->disconnect();
    return $return;
}

function ValidasiTagihanPLP($fStream, $Username, $Password) {
    global $CONF, $conn;
    $conn->connect();
    $WSDLSOAP = 'http://103.29.187.215/cfs-center/TPSServices/sever_plp.php?wsdl';
    $IDLogServices = insertLogServices($Username, $Password, $WSDLSOAP, 'ValidasiTagihanPLP', $fStream);

    $xml = str_replace('&', '', $fStream);
    // echo $xml;die();
    $SQLlogin = "SELECT ID FROM t_organisasi WHERE USERNAME_TPSONLINE_BC = '" . $Username . "'";
    // echo $SQLlogin;die();
    $Query = $conn->query($SQLlogin);
    if ($Query->size() > 0) {
        $Query->next();
        $KD_ORG_SENDER = $Query->get("ID");
    } else {
        $KD_ORG_SENDER = "";
    }
    $STR_DATA = $fStream;


    $SQL = "INSERT INTO mailbox (SNRF, KD_APRF, KD_ORG_SENDER, KD_ORG_RECEIVER,
                        STR_DATA, KD_STATUS, TGL_STATUS)
                VALUES (NULL,'ValidasiTagihanPLP', '" . $KD_ORG_SENDER . "', '1',
                        '" . $STR_DATA . "','100', NOW())";
    // echo $SQL;die();
    // print_r($SQL);die();
    $Execute = $conn->execute($SQL);
    if ($Execute != '') {
        $return = "Proses Berhasil Tersimpan di Portal CFS";
    } else {
        $return = "Proses GAGAL Tersimpan di Portal CFS";
    }
    updateLogServices($IDLogServices, $return);
    $conn->disconnect();
    return $return;
}

function ValidasiEDC($fStream, $Username, $Password) {
    global $CONF, $conn;
    $conn->connect();
    $WSDLSOAP = 'http://103.29.187.215/cfs-center/TPSServices/sever_plp.php?wsdl';
    $IDLogServices = insertLogServices($Username, $Password, $WSDLSOAP, 'ValidasiEDC', $fStream);

    $xml = str_replace('&', '', $fStream);
    // echo $xml;die();
    $SQLlogin = "SELECT ID FROM t_organisasi WHERE USERNAME_TPSONLINE_BC = '" . $Username . "'";
    // echo $SQLlogin;die();
    $Query = $conn->query($SQLlogin);
    if ($Query->size() > 0) {
        $Query->next();
        $KD_ORG_SENDER = $Query->get("ID");
    } else {
        $KD_ORG_SENDER = "";
    }
    $STR_DATA = $fStream;


    $SQL = "INSERT INTO mailbox (SNRF, KD_APRF, KD_ORG_SENDER, KD_ORG_RECEIVER,
                        STR_DATA, KD_STATUS, TGL_STATUS)
                VALUES (NULL,'ValidasiEDC', '" . $KD_ORG_SENDER . "', '1',
                        '" . $STR_DATA . "','100', NOW())";
    // echo $SQL;die();
    // print_r($SQL);die();
    $Execute = $conn->execute($SQL);
    if ($Execute != '') {
        $return = "Proses Berhasil Tersimpan di Portal CFS";
    } else {
        $return = "Proses GAGAL Tersimpan di Portal CFS";
    }
    updateLogServices($IDLogServices, $return);
    $conn->disconnect();
    return $return;
}

function GetDataBilling($fStream, $Username, $Password) {
    global $CONF, $conn;
    $conn->connect();
    $WSDLSOAP = 'http://103.29.187.215/cfs-center/TPSServices/sever_plp.php?wsdl';
    $IDLogServices = insertLogServices($Username, $Password, $WSDLSOAP, 'GetDataBilling', $fStream);

    $SOAPAction = 'http://103.29.187.215/cfs-center/TPSServices/sever_plp.php';
    $xml = '<?xml version="1.0" encoding="utf-8"?>
            <soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
                <soap:Body>
                    <GetDataBilling xmlns="http://103.29.187.215/cfs-center/TPSServices/">
                        <fStream>' . htmlspecialchars($fStream) . '</fStream>
                        <Username>' . $Username . '</Username>
                        <Password>' . $Password . '</Password>
                    </GetDataBilling>
                </soap:Body>
            </soap:Envelope>';

    /* $cek = cek_go_live($Username);  
      if($cek == "T"){
      $Send = SendCurl($xml, $WSDLSOAP, $SOAPAction);
      }else{

      $return = "Proses Berhasil Tersimpan di Portal CFS";
      updateLogServices($IDLogServices, $return);
      $conn->disconnect();
      return $return;
      die();
      }

      if ($Send['response'] != '') {
      $arr1 = 'GetSubTotal_BillingResponse';
      $arr2 = 'GetSubTotal_BillingResult';
      $response = xml2ary($Send['response']);
      $return = $response['soap:Envelope']['_c']['soap:Body']['_c'][$arr1]['_c'][$arr2]['_v'];
      } else {
      $return = '<?xml version="1.0" encoding="UTF-8"?>
      <GetSubTotal_Billing>
      <status>failed</status>
      </GetSubTotal_Billing>';
      } */

    $return = "Proses Berhasil Tersimpan! di Portal CFS";
    updateLogServices($IDLogServices, $return);
    $conn->disconnect();
    return $return;
}

function GetPermohonanCFS($string, $string0) {

    global $CONF, $conn;
    $conn->connect();
    $username = $string;
    $password = $string0;
    $WSDLSOAP = 'http://103.29.187.215/cfs-center/TPSServices/sever_plp.php';
    $IDLogServices = insertLogServices($username, $password, $WSDLSOAP, 'GetPermohonanCFS', 'XML');

    $SQLUSER = "SELECT B.KD_TPS, B.KD_GUDANG
				FROM app_user_ws A INNER JOIN t_organisasi B ON A.KD_ORGANISASI = B.ID
				WHERE A.USERLOGIN = '" . $username . "'
					  AND A.PASSWORD = '" . $password . "'";
    $QueryUser = $conn->query($SQLUSER);

    if ($QueryUser->size() == 0) {
        $message = '<?xml version="1.0" encoding="UTF-8"?>';
        $message .= '<DOCUMENT>';
        $message .= '<RESPON>USERNAME ATAU PASSWORD SALAH.</RESPON>';
        $message .= '</DOCUMENT>';
        $return = $message;

        $logServices = updateLogServices($IDLogServices, $return);
    } else {
        $QueryUser->next();
        $KD_GUDANG = $QueryUser->get("KD_GUDANG");

        $SQLHEADER = "SELECT A.NO_PERMOHONAN_CFS, A.KD_TPS_ASAL, A.KD_TPS_TUJUAN, A.KD_GUDANG_ASAL, A.KD_GUDANG_TUJUAN,
			B.NM_LENGKAP,B.KD_ORGANISASI,C.NAMA,C.ALAMAT,C.EMAIL,C.NPWP,C.NOTELP,
			C.NOFAX,A.NAMA_KAPAL,A.CALL_SIGN,A.NO_VOY_FLIGHT,A.TGL_TIBA,A.NO_BC11,
			A.TGL_BC11, A.TGL_PERMOHONAN_CFS 
			FROM t_permohonan_cfs A INNER JOIN app_user B ON A.ID_USER=B.ID INNER JOIN t_organisasi C ON B.KD_ORGANISASI=C.ID
			WHERE A.KD_STATUS='200' AND A.KD_GUDANG_TUJUAN='" . $KD_GUDANG . "'";
        $QueryHeader = $conn->query($SQLHEADER);
        if ($QueryHeader->size() > 0) {
            while ($QueryHeader->next()) {
                $message = '<?xml version="1.0" encoding="UTF-8"?>';
                $message .= '<DOCUMENT>';
                $message .= '<LOADPERMOHONANCFS>';
                $message .= '<HEADER>';
                $message .= '<NO_PERMOHONAN_CFS>' . $QueryHeader->get("NO_PERMOHONAN_CFS") . '</NO_PERMOHONAN_CFS>';
                $message .= '<TGL_PERMOHONAN_CFS>' . $QueryHeader->get("TGL_PERMOHONAN_CFS") . '</TGL_PERMOHONAN_CFS>';
                $message .= '<KD_TPS_ASAL>' . $QueryHeader->get("KD_TPS_ASAL") . '</KD_TPS_ASAL>';
                $message .= '<KD_TPS_TUJUAN>' . $QueryHeader->get("KD_TPS_TUJUAN") . '</KD_TPS_TUJUAN>';
                $message .= '<KD_GUDANG_ASAL>' . $QueryHeader->get("KD_GUDANG_ASAL") . '</KD_GUDANG_ASAL>';
                $message .= '<KD_GUDANG_TUJUAN>' . $QueryHeader->get("KD_GUDANG_TUJUAN") . '</KD_GUDANG_TUJUAN>';
                $message .= '<NM_LENGKAP>' . $QueryHeader->get("NM_LENGKAP") . '</NM_LENGKAP>';
                $message .= '<NAMA_ORGANISASI>' . $QueryHeader->get("NAMA_ORGANISASI") . '</NAMA_ORGANISASI>';
                $message .= '<EMAIL>' . $QueryHeader->get("EMAIL") . '</EMAIL>';
                $message .= '<NPWP>' . $QueryHeader->get("NPWP") . '</NPWP>';
                $message .= '<NOTELP>' . $QueryHeader->get("NOTELP") . '</NOTELP>';
                $message .= '<NOFAX>' . $QueryHeader->get("NOFAX") . '</NOFAX>';
                $message .= '<NAMA_KAPAL>' . $QueryHeader->get("NAMA_KAPAL") . '</NAMA_KAPAL>';
                $message .= '<CALL_SIGN>' . $QueryHeader->get("CALL_SIGN") . '</CALL_SIGN>';
                $message .= '<NO_VOY_FLIGHT>' . $QueryHeader->get("NO_VOY_FLIGHT") . '</NO_VOY_FLIGHT>';
                $message .= '<TGL_TIBA>' . $QueryHeader->get("TGL_TIBA") . '</TGL_TIBA>';
                $message .= '<NO_BC11>' . $QueryHeader->get("NO_BC11") . '</NO_BC11>';
                $message .= '<TGL_BC11>' . $QueryHeader->get("TGL_BC11") . '</TGL_BC11>';
                $message .= '</HEADER>';
                $message .= '<DETAIL>';

                $SQLKONTAINER = "SELECT NO_CONT,KD_CONT_UKURAN,WK_REKAM FROM t_no_kontainer WHERE NO_PERMOHONAN_CFS='" . $QueryHeader->get("NO_PERMOHONAN_CFS") . "'";
                $QueryKontainer = $conn->query($SQLKONTAINER);
                while ($QueryKontainer->next()) {
                    $message .= '<KONTAINER>';
                    $message .= '<NO_CONT>' . $QueryKontainer->get("NO_CONT") . '</NO_CONT>';
                    $message .= '<KD_CONT_UKURAN>' . $QueryKontainer->get("KD_CONT_UKURAN") . '</KD_CONT_UKURAN>';
                    $message .= '<WK_REKAM>' . $QueryKontainer->get("WK_REKAM") . '</WK_REKAM>';
                    $message .= '</KONTAINER>';
                }
                $message .= '</DETAIL>';
                $message .= '</LOADPERMOHONANCFS>';
                $message .= '</DOCUMENT>';
                $SQL = "UPDATE t_permohonan_cfs SET KD_STATUS = '300', WK_REKAM = NOW() WHERE NO_PERMOHONAN_CFS = '" . $QueryHeader->get("NO_PERMOHONAN_CFS") . "'";
                $Execute = $conn->execute($SQL);
            }
            $return = $message;
        } else {
            $message = '<?xml version="1.0" encoding="UTF-8"?>';
            $message .= '<DOCUMENT>';
            $message .= '<LOADPERMOHONANCFS>DATA TIDAK ADA.</LOADPERMOHONANCFS>';
            $message .= '</DOCUMENT>';
            $return = $message;
            $logServices = updateLogServices($IDLogServices, $return);
        }
    }

    $xmlRequest = $message != '' ? $message : $return;
    $remarks = 'DATA BERHASIL DIKIRIM';
    updateLogServices($IDLogServices, $return);

    $conn->disconnect();
    return $return;
}

function cek_go_live($user) {
    global $CONF, $conn;
    $SQL = "SELECT a.GO_LIVE FROM t_organisasi a WHERE a.USERNAME_TPSONLINE_BC = '" . trim($user) . "' ";
    $Query = $conn->query($SQL);
    if ($Query->size() > 0) {
        $Query->next();
        if ($Query->get("GO_LIVE") == 'N') {
            return "T";
        } else {
            return "Y";
        }
    } else {
        return "T";
    }
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
    //echo $SQL . '<hr>';
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

function insertLogServicesTest($userName, $Password, $url, $method, $xmlRequest = '', $xmlResponse = '') {
    global $CONF, $conn;
    $ipAddress = getIP();
    $userName = $userName == '' ? 'NULL' : "'" . $userName . "'";
    $Password = $Password == '' ? 'NULL' : "'" . $Password . "'";
    $url = $url == '' ? 'NULL' : "'" . $url . "'";
    $method = $method == '' ? 'NULL' : "'" . $method . "'";
    $xmlRequest = $xmlRequest == '' ? 'NULL' : "'" . $xmlRequest . "'";
    $xmlResponse = $xmlResponse == '' ? 'NULL' : "'" . $xmlResponse . "'";
    $SQL = "INSERT INTO app_log_services_test_cfs (USERNAME, PASSWORD, URL, METHOD, REQUEST, RESPONSE, IP_ADDRESS, WK_REKAM)
            VALUES (" . $userName . ", " . $Password . ", " . $url . ", " . $method . ", " . $xmlRequest . ", " . $xmlResponse . ", '" . $ipAddress . "', NOW())";
    $Execute = $conn->execute($SQL);
    $ID = mysql_insert_id();
    return $ID;
}

function updateLogServicesTest($ID, $xmlResponse = '') {
    global $CONF, $conn;
    $xmlResponse = $xmlResponse == '' ? 'NULL' : "'" . $xmlResponse . "'";
    $SQL = "UPDATE app_log_services_test_cfs SET RESPONSE = " . $xmlResponse . "
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

function InsertBilling($LOADBILLING, $countTarif, $RES) {
    // echo "sini";die();
    global $CONF, $conn;
    $conn->connect();
    $header = $LOADBILLING['HEADER']['_c'];
    $detil = $LOADBILLING['DETIL']['_c'];

    //header
    $JENIS_BILLING = trim($header['JENIS_BILLING']['_v']) == "" ? "NULL" : "" . strtoupper(trim($header['JENIS_BILLING']['_v'])) . "";
    $NO_ORDER = trim($header['NO_ORDER']['_v']) == "" ? "NULL" : "" . strtoupper(trim($header['NO_ORDER']['_v'])) . "";
    $WEIGHT = trim($header['WEIGHT']['_v']) == "" ? "NULL" : "" . strtoupper(trim($header['WEIGHT']['_v'])) . "";
    $MEASURE = trim($header['MEASURE']['_v']) == "" ? "NULL" : "" . strtoupper(trim($header['MEASURE']['_v'])) . "";
    $SUBTOTAL = trim($header['SUBTOTAL']['_v']) == "" ? "NULL" : "" . strtoupper(trim($header['SUBTOTAL']['_v'])) . "";
    $PPN = trim($header['PPN']['_v']) == "" ? "NULL" : "" . strtoupper(trim($header['PPN']['_v'])) . "";
    $TOTAL = trim($header['TOTAL']['_v']) == "" ? "NULL" : "" . strtoupper(trim($header['TOTAL']['_v'])) . "";
    //insert t_billing_cfshdr
    $SQLHeader = "INSERT INTO t_billing_cfshdr(JENIS_BILLING,NO_ORDER,SUBTOTAL,PPN,TOTAL,FLAG_APPROVE,KD_ALASAN_BILLING,WEIGHT,MEASURE) VALUES('" . $JENIS_BILLING . "','" . $NO_ORDER . "',
    	'" . $SUBTOTAL . "','" . $PPN . "','" . $TOTAL . "','Y','" . $RES . "','" . $WEIGHT . "','" . $MEASURE . "')";
    // print_r($SQLHeader);die();
    $Execute = $conn->execute($SQLHeader);

    //detail
    $IDHeader = mysql_insert_id();
    if ($countTarif > 1) {
        for ($i = 0; $i < $countTarif; $i++) {
            $KODE = trim($detil['TARIF'][$i]['_c']['KODE']['_v']) == "" ? "NULL" : "" . strtoupper(trim($detil['TARIF'][$i]['_c']['KODE']['_v'])) . "";
            $QTY = trim($detil['TARIF'][$i]['_c']['QTY']['_v']) == "" ? "NULL" : "" . strtoupper(trim($detil['TARIF'][$i]['_c']['QTY']['_v'])) . "";
            $SATUAN = trim($detil['TARIF'][$i]['_c']['SATUAN']['_v']) == "" ? "NULL" : "" . strtoupper(trim($detil['TARIF'][$i]['_c']['SATUAN']['_v'])) . "";
            $TARIF_DASAR = trim($detil['TARIF'][$i]['_c']['TARIF_DASAR']['_v']) == "" ? "NULL" : "" . strtoupper(trim($detil['TARIF'][$i]['_c']['TARIF_DASAR']['_v'])) . "";
            $NILAI = trim($detil['TARIF'][$i]['_c']['NILAI']['_v']) == "" ? "NULL" : "" . strtoupper(trim($detil['TARIF'][$i]['_c']['NILAI']['_v'])) . "";
            //insert t_billing_cfsdtl
            $SQLDetil = "INSERT INTO t_billing_cfsdtl(ID,KODE_BILL,TARIF_DASAR,TOTAL,QTY,SATUAN) VALUES('" . $IDHeader . "','" . $KODE . "',
            	'" . $TARIF_DASAR . "','" . $NILAI . "','" . $QTY . "','" . $SATUAN . "')";
            // print_r($SQLDetil);die();
            $Execute = $conn->execute($SQLDetil);
        }
    } elseif ($countTarif == 1) {
        $KODE = trim($detil['TARIF']['KODE']['_v']) == "" ? "NULL" : "" . strtoupper(trim($detil['TARIF']['_c']['KODE']['_v'])) . "";
        $QTY = trim($detil['TARIF']['QTY']['_v']) == "" ? "NULL" : "" . strtoupper(trim($detil['TARIF']['_c']['QTY']['_v'])) . "";
        $SATUAN = trim($detil['TARIF']['SATUAN']['_v']) == "" ? "NULL" : "" . strtoupper(trim($detil['TARIF']['_c']['SATUAN']['_v'])) . "";
        $TARIF_DASAR = trim($detil['TARIF']['TARIF_DASAR']['_v']) == "" ? "NULL" : "" . strtoupper(trim($detil['TARIF']['_c']['TARIF_DASAR']['_v'])) . "";
        $NILAI = trim($detil['TARIF']['NILAI']['_v']) == "" ? "NULL" : "" . strtoupper(trim($detil['TARIF']['_c']['NILAI']['_v'])) . "";
        //insert t_billing_cfsdtl
        $SQLDetil = "INSERT INTO t_billing_cfsdtl(ID,KODE_BILL,TARIF_DASAR,TOTAL,QTY,SATUAN) VALUES('" . $IDHeader . "','" . $KODE . "',
            	'" . $TARIF_DASAR . "','" . $NILAI . "','" . $QTY . "','" . $SATUAN . "')";

        $Execute = $conn->execute($SQLDetil);
    }
}

$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
$server->service($HTTP_RAW_POST_DATA);
?>