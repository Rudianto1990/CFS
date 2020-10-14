<?php

ob_start();
// call library
require_once ('config.php' );
//require_once ($CONF['root.dir'].'Libraries/soaplib/nusoap.php');
require_once ($CONF['root.dir'] . 'Libraries/nusoap-lokal/lib/nusoap.php');
require_once ($CONF['root.dir'] . 'Libraries/xml2array.php' );

// create instance
$server = new soap_server();

// initialize WSDL support
$server->configureWSDL('CFSwsdl', 'urn:CFSwsdl');

// place schema at namespace with prefix tns
$server->wsdl->schemaTargetNamespace = 'urn:sendCFSwsdl';

// register method
$server->register('SendSpjm', // method name
        array('String0' => 'xsd:string', 'String1' => 'xsd:string', 'String2' => 'xsd:string', 'String3' => 'xsd:string'), //input parameter
        array('return' => 'xsd:string'), // output
        'urn:SendSpjmwsdl', // namespace
        'urn:SendSpjmwsdl#SendSpjm', // soapaction
        'rpc', // style
        'encoded', // use
        'SendSpjm'// documentation
);
$server->register('getSppud', // method name
        array('String0' => 'xsd:string', 'String1' => 'xsd:string', 'String2' => 'xsd:string'), //input parameter
        array('return' => 'xsd:string'), // output
        'urn:getSppudwsdl', // namespace
        'urn:getSppudwsdl#getSppud', // soapaction
        'rpc', // style
        'encoded', // use
        'getSppud'// documentation
);
$server->register('getSP3UDK', // method name
        array('String0' => 'xsd:string', 'String1' => 'xsd:string', 'String2' => 'xsd:string'), //input parameter
        array('return' => 'xsd:string'), // output
        'urn:getSP3UDKwsdl', // namespace
        'urn:getSP3UDKwsdl#getSP3UDK', // soapaction
        'rpc', // style
        'encoded', // use
        'getSP3UDK'// documentation
);
$server->register('getPostClearanceKarantina', // method name
        array('String0' => 'xsd:string', 'String1' => 'xsd:string', 'String2' => 'xsd:string'), //input parameter
        array('return' => 'xsd:string'), // output
        'urn:getPostClearanceKarantinawsdl', // namespace
        'urn:getPostClearanceKarantinawsdl#getPostClearanceKarantina', // soapaction
        'rpc', // style
        'encoded', // use
        'getPostClearanceKarantina'// documentation
);
$server->register('sendCodeco', // method name
        array('String0' => 'xsd:string', 'String1' => 'xsd:string', 'String2' => 'xsd:string', 'String3' => 'xsd:string'), //input parameter
        array('return' => 'xsd:string'), // output
        'urn:sendCodecowsdl', // namespace
        'urn:sendCodecowsdl#sendCodeco', // soapaction
        'rpc', // style
        'encoded', // use
        'sendCodeco'// documentation
);
$server->register('getCodeco', // method name
        array('String0' => 'xsd:string', 'String1' => 'xsd:string', 'String2' => 'xsd:string'), //input parameter
        array('return' => 'xsd:string'), // output
        'urn:sendCodecowsdl', // namespace
        'urn:sendCodecowsdl#sendCodeco', // soapaction
        'rpc', // style
        'encoded', // use
        'sendCodeco'// documentation
);
$server->register('CheckContainerKarantina', // method name
        array('String0' => 'xsd:string', 'String1' => 'xsd:string', 'String2' => 'xsd:string', 'String3' => 'xsd:string', 'String4' => 'xsd:string'), // input parameter
        array('return' => 'xsd:string'), // output
        'urnCheckContainerKarantinawsdl', // namespace
        'urn:CheckContainerKarantinawsdl#CheckContainerKarantina', // soapaction
        'rpc', // style
        'encoded', // use
        'CheckContainerKarantina'// documentation
);
$server->register('SendSpjmJICT', // method name
        array('String0' => 'xsd:string', 'String1' => 'xsd:string', 'String2' => 'xsd:string', 'String3' => 'xsd:string'), //input parameter
        array('return' => 'xsd:string'), // output
        'urn:SendSpjmJICTwsdl', // namespace
        'urn:SendSpjmJICTwsdl#SendSpjmJICT', // soapaction
        'rpc', // style
        'encoded', // use
        'SendSpjmJICT'// documentation
);
$server->register('SendSPPBKarantina', // method name
        array('String0' => 'xsd:string', 'String1' => 'xsd:string', 'String2' => 'xsd:string', 'String3' => 'xsd:string'), //input parameter
        array('return' => 'xsd:string'), // output
        'urn:SendSPPBKarantinawsdl', // namespace
        'urn:SendSPPBKarantinawsdl#SendSPPBKarantina', // soapaction
        'rpc', // style
        'encoded', // use
        'SendSPPBKarantina'// documentation
);
$server->register('SendSpjmKOJA', // method name
        array('String0' => 'xsd:string', 'String1' => 'xsd:string', 'String2' => 'xsd:string', 'String3' => 'xsd:string'), //input parameter
        array('return' => 'xsd:string'), // output
        'urn:SendSpjmKOJAwsdl', // namespace
        'urn:SendSpjmKOJAwsdl#SendSpjmKOJA', // soapaction
        'rpc', // style
        'encoded', // use
        'SendSpjmKOJA'// documentation
);
$server->register('CheckConnection', // method name
        array('String0' => 'xsd:string'), //input parameter
        array('return' => 'xsd:string'), // output
        'urn:CheckConnectionwsdl', // namespace
        'urn:CheckConnectionwsdl#CheckConnection', // soapaction
        'rpc', // style
        'encoded', // use
        'CheckConnection'// documentation
);

function CheckConnection($String0) {
    $return = '<?xml version="1.0"?>
				   <DOCUMENT>	
						<SPJM>		
							<RESULT>TRUE</RESULT>
							<MESSAGES>Connection Success. Parameter : ' . $String0 . '</MESSAGES>
						</SPJM>	
				   </DOCUMENT>';
    $return = "test";
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

function SendSpjmKOJA($String0, $String1, $String2, $String3) {
    global $conn, $CONF, $connSMS;
    $vUsername = array("WSKOJA");
    $vPassword = array("12112013");
    $username = $String0;
    $password = $String1;
    $KodeTPS = $String2;
    $xml = str_replace('&', '&amp;', $String3);
    $timestamps = date("Y-m-d H:i:s");
    $KDORG_TPFT = 9;

    $conn->connect();
    if ((in_array($username, $vUsername)) && (in_array($password, $vPassword))) {
        if ($xml == '') {
            $return = '<?xml version="1.0"?><DOCUMENT><SPJM><RESULT>FALSE</RESULT><MESSAGES>XML not defined.</MESSAGES></SPJM></DOCUMENT>';
            $SQL = "INSERT INTO req_xml (XML_REQUEST,XML_RESPONSE,DATE_CREATED,USERNAME,IP_ADDRESS)
						VALUES ('" . str_replace("'", "\'", $xml) . "','" . str_replace("'", "\'", $return) . "','" . date('Y-m-d H:i:s') . "',
								'" . $username . "','" . getIP() . "')";
            $Execute = $conn->execute($SQL);
            $conn->disconnect();
            return $return;
        }

        $SQL = "INSERT INTO req_xml (XML_REQUEST,DATE_CREATED,USERNAME,IP_ADDRESS)
					VALUES ('" . str_replace("'", "\'", $xml) . "','" . date('Y-m-d H:i:s') . "','" . $username . "','" . getIP() . "')";
        $Execute = $conn->execute($SQL);
        $ID_REQ_XML = mysql_insert_id();

        $xml = xml2ary($xml);
        $link = & $xml['DOCUMENT']['_c'];
        $CountSPJM = count($link['SPJM']);
        for ($c = 0; $c < $CountSPJM; $c++) {
            //HEADER 
            if ($CountSPJM == 1) {
                $header = $link['SPJM']['_c']['HEADER']['_c'];
            } else {
                $header = $link['SPJM'][$c]['_c']['HEADER']['_c'];
            }

            $CAR = replaceCar($header['CAR']['_v']) == "" ? "NULL" : "'" . replaceCar($header['CAR']['_v']) . "'";
            $KD_KANTOR = $header['KD_KANTOR']['_v'] == "" ? "'040300'" : "'" . $header['KD_KANTOR']['_v'] . "'";
            $NO_PIB = $header['NO_PIB']['_v'] == "" ? "NULL" : "'" . $header['NO_PIB']['_v'] . "'";
            $TGL_PIB = changeFormatDate($header['TGL_PIB']['_v']) == "" ? "NULL" : "'" . changeFormatDate($header['TGL_PIB']['_v']) . "'";
            $NPWP_IMP = replaceNPWP($header['NPWP_IMP']['_v']) == "" ? "NULL" : "'" . replaceNPWP($header['NPWP_IMP']['_v']) . "'";
            $NAMA_IMP = $header['NAMA_IMP']['_v'] == "" ? "NULL" : "'" . $header['NAMA_IMP']['_v'] . "'";
            $NPWP_PPJK = replaceNPWP($header['NPWP_PPJK']['_v']) == "" ? "NULL" : "'" . replaceNPWP($header['NPWP_PPJK']['_v']) . "'";
            $NAMA_PPJK = $header['NAMA_PPJK']['_v'] == "" ? "NULL" : "'" . $header['NAMA_PPJK']['_v'] . "'";
            $GUDANG = strtoupper($header['GUDANG']['_v']) == "" ? "NULL" : "'" . strtoupper($header['GUDANG']['_v']) . "'";
            $JML_CONT = $header['JML_CONT']['_v'] == "" ? "NULL" : "'" . $header['JML_CONT']['_v'] . "'";
            $NO_BC11 = $header['NO_BC11']['_v'] == "" ? "NULL" : "'" . $header['NO_BC11']['_v'] . "'";
            $TGL_BC11 = changeFormatDate($header['TGL_BC11']['_v']) == "" ? "NULL" : "'" . changeFormatDate($header['TGL_BC11']['_v']) . "'";
            $NO_POS_BC11 = $header['NO_POS_BC11']['_v'] == "" ? "NULL" : "'" . $header['NO_POS_BC11']['_v'] . "'";
            $FL_KARANTINA = $header['FL_KARANTINA']['_v'] == "" ? "'N'" : "'" . $header['FL_KARANTINA']['_v'] . "'";
            $TGL_BONGKAR = changeFormatDate($header['TGL_BONGKAR']['_v']) == "" ? "NULL" : "'" . changeFormatDate($header['TGL_BONGKAR']['_v']) . "'";

            $SQL = "SELECT CAR FROM spjm WHERE CAR = " . $CAR . "";
            $Query = $conn->query($SQL);
            if ($Query->size() > 0) {
                $return = '<?xml version="1.0"?><DOCUMENT><SPJM><RESULT>FALSE</RESULT><MESSAGES>CAR already exist.</MESSAGES></SPJM></DOCUMENT>';
                $SQL = "UPDATE req_xml SET XML_RESPONSE = '" . str_replace("'", "\'", $return) . "' 
							WHERE ID = '" . $ID_REQ_XML . "'";
                $Execute = $conn->execute($SQL);
                $conn->disconnect();
                return $return;
            }

            //SQL HEADER 
            $SQL = "INSERT INTO spjm (CAR, KDKPBC, NOPIB, TGPIB, IMPNPWP, IMPNAMA, PPJKNPWP, PPJKNAMA, 
											  KDGUDANG, JMLKONT, NOBC11, TGBC11, NOPOSBC11, FLKARANTINA, SENT_VIA, 
											  DATE_CREATED, KDORG_TPFT)
						VALUES(" . $CAR . ", " . $KD_KANTOR . ", " . $NO_PIB . ", " . $TGL_PIB . ", " . $NPWP_IMP . ", " . $NAMA_IMP . ", 
							   " . $NPWP_PPJK . ", " . $NAMA_PPJK . ", " . $GUDANG . ", " . $JML_CONT . ", " . $NO_BC11 . ", " . $TGL_BC11 . ", 
							   " . $NO_POS_BC11 . ", " . $FL_KARANTINA . ",'WS TPS','" . $timestamps . "','" . $KDORG_TPFT . "')";
            $Execute = $conn->execute($SQL);
            if (!$Execute) {
                $return = '<?xml version="1.0"?><DOCUMENT><SPJM><RESULT>FALSE</RESULT><MESSAGES>Cannot execute query [header].' . $SQL . '</MESSAGES></SPJM></DOCUMENT>';
                $SQL = "UPDATE req_xml SET XML_RESPONSE = '" . str_replace("'", "\'", $return) . "' 
							WHERE ID = '" . $ID_REQ_XML . "'";
                $Execute = $conn->execute($SQL);
                $conn->disconnect();
                return $return;
            }
            $ID_TPFT = mysql_insert_id();


            if ($NO_PIB != '') {
                $SQL = "INSERT INTO spjmdok (KDSPJM, KDDOK, NODOK, TGDOK, TIPEDOK)
							VALUES (" . $ID_TPFT . ", '100', " . $NO_PIB . ", " . $TGL_PIB . ", '001')";
                $ExecuteInsertNoSPJM = $conn->execute($SQL);
            }

            //DETAIL CONTAINER
            $ID_CONT = array();
            if ($CountSPJM == 1) {
                $CountContainer = count($link['SPJM']['_c']['DETIL']['_c']['CONT']);
                $SPJM = $link['SPJM']['_c'];
            } else {
                $CountContainer = count($link['SPJM'][$c]['_c']['DETIL']['_c']['CONT']);
                $SPJM = $link['SPJM'][$c]['_c'];
            }
            for ($d = 0; $d < $CountContainer; $d++) {
                if ($CountContainer == 1) {
                    $detailContainer = $SPJM['DETIL']['_c']['CONT']['_c'];
                } else {
                    $detailContainer = $SPJM['DETIL']['_c']['CONT'][$d]['_c'];
                }

                $CAR_DETAIL_CONTAINER = $detailContainer['CAR']['_v'] == "" ? "NULL" : "'" . $detailContainer['CAR']['_v'] . "'";
                $NO_CONT = $detailContainer['NO_CONT']['_v'] == "" ? "NULL" : "'" . $detailContainer['NO_CONT']['_v'] . "'";
                $SIZE = $detailContainer['SIZE']['_v'] == "" ? "NULL" : "'" . $detailContainer['SIZE']['_v'] . "'";
                $BARCODE = Barcode();
                $STATUS_DATE = date("Y-m-d H:i:s");

                $REFER_FLAG = $detailContainer['REFER_FLAG']['_v'] == "" ? "NULL" : "'" . $detailContainer['REFER_FLAG']['_v'] . "'";
                $DG_CODE = $detailContainer['DG_CODE']['_v'] == "" ? "NULL" : "'" . $detailContainer['DG_CODE']['_v'] . "'";
                $OD_FLAG = $detailContainer['OD_FLAG']['_v'] == "" ? "NULL" : "'" . $detailContainer['OD_FLAG']['_v'] . "'";
                $START_PLUG = changeFormatDateTime($detailContainer['START_PLUG']['_v']) == "" ? "NULL" : "'" . changeFormatDateTime($detailContainer['START_PLUG']['_v']) . "'";
                $SETTING_TEMP = $detailContainer['SETTING_TEMP']['_v'] == "" ? "NULL" : "'" . $detailContainer['SETTING_TEMP']['_v'] . "'";
                $TEMP_SATUAN = $detailContainer['TEMP_SATUAN']['_v'] == "" ? "NULL" : "'" . $detailContainer['TEMP_SATUAN']['_v'] . "'";

                //SQL CONTAINER 
                $SQL = "INSERT INTO spjmkont (KDSPJM, BARCODE, NOKONT, UKURAN, KDSTATUS, TGSTATUS,
												  REFER_FLAG, DG_CODE, OD_FLAG, START_PLUG, SETTING_TEMP, TEMP_SATUAN, 
												  TGBONGKAR, FL_CETAK)
							VALUES (" . $ID_TPFT . ", '" . $BARCODE . "', " . $NO_CONT . ", " . $SIZE . ", '10', '" . $timestamps . "', 
									" . $REFER_FLAG . ", " . $DG_CODE . ", " . $OD_FLAG . ", " . $START_PLUG . ", " . $SETTING_TEMP . ", 
									" . $TEMP_SATUAN . ", " . $TGL_BONGKAR . ", 'Y')";
                $Execute = $conn->execute($SQL);
                if (!$Execute) {
                    $SQL = "DELETE FROM spjmkont WHERE KDSPJM = '" . $ID_TPFT . "'";
                    $ExecuteDelete = $conn->execute($SQL);
                    $SQL = "DELETE FROM spjm WHERE KDSPJM = '" . $ID_TPFT . "'";
                    $ExecuteDelete = $conn->execute($SQL);
                    $return = '<?xml version="1.0"?><DOCUMENT><SPJM><RESULT>FALSE</RESULT><MESSAGES>Cannot execute query [container].</MESSAGES></SPJM></DOCUMENT>';
                    $SQL = "UPDATE req_xml SET XML_RESPONSE = '" . str_replace("'", "\'", $return) . "' 
								WHERE ID = '" . $ID_REQ_XML . "'";
                    $Execute = $conn->execute($SQL);
                    $conn->disconnect();
                    return $return;
                }

                $SQL = "INSERT INTO spjmkontstatushis (KDSPJM,NOKONT,KDSTATUS,TGSTATUS)
							VALUES (" . $ID_TPFT . "," . $NO_CONT . ",'10','" . $timestamps . "')";
                $Execute = $conn->execute($SQL);
            }

            //DETAIL DOCUMENT				
            if ($CountSPJM == 1) {
                $CountDocument = count($link['SPJM']['_c']['DETIL']['_c']['DOK']);
                $SPJM = $link['SPJM']['_c'];
            } else {
                $CountDocument = count($link['SPJM'][$c]['_c']['DETIL']['_c']['DOK']);
                $SPJM = $link['SPJM'][$c]['_c'];
            }
            for ($d = 0; $d < $CountDocument; $d++) {
                if ($CountDocument == 1) {
                    $detailDocument = $SPJM['DETIL']['_c']['DOK']['_c'];
                } else {
                    $detailDocument = $SPJM['DETIL']['_c']['DOK'][$d]['_c'];
                }

                $CAR_DETAIL_DOCUMENT = $detailDocument['CAR']['_v'] == "" ? "NULL" : "'" . $detailDocument['CAR']['_v'] . "'";
                $JNS_DOK = $detailDocument['JNS_DOK']['_v'] == "" ? "NULL" : "'" . $detailDocument['JNS_DOK']['_v'] . "'";
                $NO_DOK = $detailDocument['NO_DOK']['_v'] == "" ? "NULL" : "'" . $detailDocument['NO_DOK']['_v'] . "'";
                $TGL_DOK = changeFormatDate($detailDocument['TGL_DOK']['_v']) == "" ? "NULL" : "'" . changeFormatDate($detailDocument['TGL_DOK']['_v']) . "'";

                $SQL = "SELECT KODEDOK, KDGA
							FROM kodedokumen 
							WHERE KODEDOK = " . $JNS_DOK . "";
                $Query = $conn->query($SQL);
                $Query->next();
                $KODEDOK = $Query->get(0);
                $KDGA = $Query->get(1) == "" ? "07" : $Query->get(1);

                if ($detailDocument['JNS_DOK']['_v'] == "705") { // NOBL
                    if (($NO_DOK != '') && ($TGL_DOK != '')) {
                        $SQL = "UPDATE spjm SET NOBL = " . $NO_DOK . ", TGBL = " . $TGL_DOK . " WHERE KDSPJM = " . $ID_TPFT . "";
                        $ExecuteUpdateBL = $conn->execute($SQL);
                    }
                } else {
                    $SQL = "SELECT KDSPJM, KDDOK, TIPEDOK FROM spjmdok 
								WHERE KDSPJM = " . $ID_TPFT . " AND KDDOK = " . $JNS_DOK . " AND TIPEDOK = '001'";
                    $QueryCheckSPJM = $conn->query($SQL);
                    if ($QueryCheckSPJM->size() == 0) {
                        $SQL = "INSERT INTO spjmdok (KDSPJM, KDDOK, NODOK, TGDOK, TIPEDOK)
									VALUES (" . $ID_TPFT . ", " . $JNS_DOK . ", " . $NO_DOK . ", " . $TGL_DOK . ", '001')";
                        $ExecuteInsertSPJM = $conn->execute($SQL);
                    }
                }

                switch ($KDGA) {
                    case "02"://KARANTINA IKAN
                        $FIELD_FLAG_KARANTINA = 'FLKI';
                        break;
                    case "03"://KARANTINA HEWAN
                        $FIELD_FLAG_KARANTINA = 'FLKH';
                        break;
                    case "04"://KARANTINA TUMBUHAN	
                        $FIELD_FLAG_KARANTINA = 'FLKT';
                        break;
                    case "07"://BEA CUKAI
                        $FIELD_FLAG_KARANTINA = 'FLBC';
                        break;
                }
                if ($FIELD_FLAG_KARANTINA != '') {
                    $SQL = "UPDATE spjm SET " . $FIELD_FLAG_KARANTINA . " = 'Y' WHERE KDSPJM = " . $ID_TPFT;
                    $ExecuteUpdateFlagInstansi = $conn->execute($SQL);
                }
            }
        }
        if ($Execute) {
            $return = '<?xml version="1.0"?><DOCUMENT><SPJM><RESULT>TRUE</RESULT><MESSAGES>Send SPJM has been successfully.</MESSAGES></SPJM></DOCUMENT>';
        }
        $SQL = "UPDATE req_xml SET XML_RESPONSE = '" . str_replace("'", "\'", $return) . "' 
					WHERE ID = '" . $ID_REQ_XML . "'";
        $Execute2 = $conn->execute($SQL);
        if ($Execute) {
            $CAR = $header['CAR']['_v'];
            $NO_PIB = $header['NO_PIB']['_v'];
            $TGL_PIB = $header['TGL_PIB']['_v'];
            $JmlKontainer = $CountContainer;
            $textSMS = "Anda mendapatkan data SPJM dengan No. PIB : " . $NO_PIB . ", Tgl. PIB : " . $TGL_PIB . ", Jumlah Kontainer : " . $JmlKontainer;
            $textSMSIMPPPJK = "data SPJM sudah masuk ke TPFT dengan No. PIB : " . $NO_PIB . ", Tgl. PIB : " . $TGL_PIB . ", Jumlah Kontainer : " . $JmlKontainer;
            sendSMStoTPFT($KDORG_TPFT, 'MERAH', $textSMS, $ID_TPFT, $textSMSIMPPPJK);
        }
    } else {
        $return = '<?xml version="1.0"?><DOCUMENT><SPJM><RESULT>FALSE</RESULT><MESSAGES>String0 or String1 wrong. Please check your data.</MESSAGES></SPJM></DOCUMENT>';
        $SQL = "UPDATE req_xml SET XML_RESPONSE = '" . str_replace("'", "\'", $return) . "' 
					WHERE ID = '" . $ID_REQ_XML . "'";
        $Execute = $conn->execute($SQL);
    }
    $conn->disconnect();

    return $return;
}

function SendSPPBKarantina($String0, $String1, $String2, $String3) {
    global $conn, $CONF, $connSMS;
    $vUsername = array("TPFT", "WSMAL", "WSJICT", "WSNSW", "WSPLDC");
    $vPassword = array("19911402", "19912407", "19912405", "20131104", "20140606");
    $username = $String0;
    $password = $String1;
    $KodeTPS = $String2;
    $xml = str_replace('&', '&amp;', $String3);
    $timestamps = date("Y-m-d H:i:s");
    $KDORG_TPFT = 9;

    $conn->connect();
    if ((in_array($username, $vUsername)) && (in_array($password, $vPassword))) {
        if ($xml == '') {
            $return = '<?xml version="1.0"?>
						   <SPPB>	
								<SPPB_KARANTINA>		
									<RESULT>FALSE</RESULT>
									<MESSAGES>XML not defined.</MESSAGES>
								</SPPB_KARANTINA>	
						   </SPPB>';
            $SQL = "INSERT INTO req_xml (XML_REQUEST,XML_RESPONSE,DATE_CREATED,USERNAME,IP_ADDRESS)
						VALUES ('" . str_replace("'", "\'", $xml) . "','" . str_replace("'", "\'", $return) . "','" . date('Y-m-d H:i:s') . "',
								'" . $username . "','" . getIP() . "')";
            $Execute = $conn->execute($SQL);
            $conn->disconnect();
            return $return;
        }

        $SQL = "INSERT INTO req_xml (XML_REQUEST,DATE_CREATED,USERNAME,IP_ADDRESS)
					VALUES ('" . str_replace("'", "\'", $xml) . "','" . date('Y-m-d H:i:s') . "','" . $username . "','" . getIP() . "')";
        $Execute = $conn->execute($SQL);
        $ID_REQ_XML = mysql_insert_id();

        $xml = xml2ary($xml);
        $link = & $xml['SPPB']['_c'];
        $CountSPPB = count($link['SPPB_KARANTINA']);
        for ($c = 0; $c < $CountSPPB; $c++) {
            //HEADER 				
            if ($CountSPPB == 1) {
                $header = $link['SPPB_KARANTINA']['_c']['HEADER']['_c'];
            } else {
                $header = $link['SPPB_KARANTINA'][$c]['_c']['HEADER']['_c'];
            }

            $CAR = replaceCar($header['CAR']['_v']) == "" ? "NULL" : "'" . replaceCar($header['CAR']['_v']) . "'";
            $KDKPBC = $header['KDKPBC']['_v'] == "" ? "'040300'" : "'" . $header['KDKPBC']['_v'] . "'";
            $IMPNPWP = replaceNPWP($header['IMPNPWP']['_v']) == "" ? "NULL" : "'" . replaceNPWP($header['IMPNPWP']['_v']) . "'";
            $IMPNAMA = $header['IMPNAMA']['_v'] == "" ? "NULL" : "'" . $header['IMPNAMA']['_v'] . "'";
            $PPJKNPWP = replaceNPWP($header['PPJKNPWP']['_v']) == "" ? "NULL" : "'" . replaceNPWP($header['PPJKNPWP']['_v']) . "'";
            $PPJKNAMA = $header['PPJKNAMA']['_v'] == "" ? "NULL" : "'" . $header['PPJKNAMA']['_v'] . "'";
            $VESSEL = $header['VESSEL']['_v'] == "" ? "NULL" : "'" . $header['VESSEL']['_v'] . "'";
            $VOY = $header['VOY']['_v'] == "" ? "NULL" : "'" . $header['VOY']['_v'] . "'";
            $LOADING_PORT = $header['LOADING_PORT']['_v'] == "" ? "NULL" : "'" . $header['LOADING_PORT']['_v'] . "'";
            $DISCHARGE_PORT = $header['DISCHARGE_PORT']['_v'] == "" ? "NULL" : "'" . $header['DISCHARGE_PORT']['_v'] . "'";
            $TGLTIBA = $header['TGLTIBA']['_v'] == "" ? "NULL" : "'" . $header['TGLTIBA']['_v'] . "'";
            $PIBNO = $header['PIBNO']['_v'] == "" ? "NULL" : "'" . $header['PIBNO']['_v'] . "'";
            $PIBTGL = $header['PIBTGL']['_v'] == "" ? "NULL" : "'" . $header['PIBTGL']['_v'] . "'";
            $BLNO = $header['BLNO']['_v'] == "" ? "NULL" : "'" . $header['BLNO']['_v'] . "'";
            $BLTGL = $header['BLTGL']['_v'] == "" ? "NULL" : "'" . $header['BLTGL']['_v'] . "'";
            $KD_GUDANG = $header['KD_GUDANG']['_v'] == "" ? "NULL" : "'" . $header['KD_GUDANG']['_v'] . "'";
            $PASOK_NEG = $header['PASOK_NEG']['_v'] == "" ? "NULL" : "'" . $header['PASOK_NEG']['_v'] . "'";
            $BRUTO = $header['BRUTO']['_v'] == "" ? "NULL" : "'" . $header['BRUTO']['_v'] . "'";
            $NETTO = $header['NETTO']['_v'] == "" ? "NULL" : "'" . $header['NETTO']['_v'] . "'";

            $SQL = "SELECT CAR FROM spjm WHERE CAR = " . $CAR . "";
            $Query = $conn->query($SQL);
            if ($Query->size() > 0) {
                $return = '<?xml version="1.0"?>
							   <SPPB>	
									<SPPB_KARANTINA>		
										<RESULT>FALSE</RESULT>
										<MESSAGES>CAR already exist.</MESSAGES>
									</SPPB_KARANTINA>	
							   </SPPB>';
                $SQL = "UPDATE req_xml SET XML_RESPONSE = '" . str_replace("'", "\'", $return) . "' 
							WHERE ID = '" . $ID_REQ_XML . "'";
                $Execute = $conn->execute($SQL);
                $conn->disconnect();
                return $return;
            }

            //SQL HEADER 
            $SQL = "INSERT INTO spjm (CAR, KDKPBC, IMPNPWP, IMPNAMA, PPJKNPWP, PPJKNAMA, VESSEL, VOY, PELMUAT, PELBKR, 
										  TGTIBA, NOPIB, TGPIB, KDGUDANG, KDORG_TPFT, NOBL, TGBL, SENT_VIA, DATE_CREATED, 
										  PASOKNEG, BRUTO, NETTO)
						VALUES (" . $CAR . ", " . $KDKPBC . ", " . $IMPNPWP . ", " . $IMPNAMA . ", " . $PPJKNPWP . ", " . $PPJKNAMA . ", 
									" . $VESSEL . ", 
								" . $VOY . ", " . $LOADING_PORT . ", " . $DISCHARGE_PORT . ", " . $TGLTIBA . ", " . $PIBNO . ", " . $PIBTGL . ", 
								" . $KD_GUDANG . "," . $KDORG_TPFT . "," . $BLNO . "," . $BLTGL . ",'WS','" . $timestamps . "',
								" . $PASOK_NEG . "," . $BRUTO . "," . $NETTO . ")";
            $SQLHEADER = $SQL;
            $Execute = $conn->execute($SQL);
            if (!$Execute) {
                $return = '<?xml version="1.0"?>
							   <SPPB>	
									<SPPB_KARANTINA>		
										<RESULT>FALSE</RESULT>
										<MESSAGES>Cannot execute query [header].</MESSAGES>
									</SPPB_KARANTINA>	
							   </SPPB>';
                $SQL = "UPDATE req_xml SET XML_RESPONSE = '" . str_replace("'", "\'", $return) . "' 
							WHERE ID = '" . $ID_REQ_XML . "'";
                $Execute = $conn->execute($SQL);
                $conn->disconnect();
                return $return;
            }
            $ID_TPFT = mysql_insert_id();

            //DETAIL CONTAINER
            $ID_CONT = array();
            if ($CountSPPB == 1) {
                $CountContainer = count($link['SPPB_KARANTINA']['_c']['CONTAINERS']['_c']['CONTAINER']);
                $SPPB_KARANTINA = $link['SPPB_KARANTINA']['_c'];
            } else {
                $CountContainer = count($link['SPPB_KARANTINA'][$c]['_c']['CONTAINERS']['_c']['CONTAINER']);
                $SPPB_KARANTINA = $link['SPPB_KARANTINA'][$c]['_c'];
            }

            $SQL = "UPDATE spjm SET JMLKONT = '" . $CountContainer . "' WHERE KDSPJM = " . $ID_TPFT;
            $ExecuteJumlahKontainer = $conn->execute($SQL);

            $SQLKONTAINER = array();
            for ($d = 0; $d < $CountContainer; $d++) {
                if ($CountContainer == 1) {
                    $detailContainer = $SPPB_KARANTINA['CONTAINERS']['_c']['CONTAINER']['_c'];
                } else {
                    $detailContainer = $SPPB_KARANTINA['CONTAINERS']['_c']['CONTAINER'][$d]['_c'];
                }

                $NO_CONT = $detailContainer['CONTNO']['_v'] == "" ? "NULL" : "'" . $detailContainer['CONTNO']['_v'] . "'";
                $SIZE = $detailContainer['CONTUKUR']['_v'] == "" ? "NULL" : "'" . $detailContainer['CONTUKUR']['_v'] . "'";
                $CONTTIPE = $detailContainer['CONTTIPE']['_v'] == "" ? "NULL" : "'" . $detailContainer['CONTTIPE']['_v'] . "'";
                $BARCODE = Barcode();

                //SQL CONTAINER 
                $SQL = "INSERT INTO spjmkont (KDSPJM, BARCODE, NOKONT, UKURAN, KDSTATUS, TGSTATUS)
							VALUES (" . $ID_TPFT . ", '" . $BARCODE . "', " . $NO_CONT . ", " . $SIZE . ", '10', '" . $timestamps . "')";
                $Execute = $conn->execute($SQL);
                $SQLKONTAINER[] = $SQL;
                if (!$Execute) {
                    $SQL = "DELETE FROM spjmkont WHERE KDSPJM = '" . $ID_TPFT . "'";
                    $ExecuteDelete = $conn->execute($SQL);
                    $SQL = "DELETE FROM spjm WHERE KDSPJM = '" . $ID_TPFT . "'";
                    $ExecuteDelete = $conn->execute($SQL);
                    $return = '<?xml version="1.0"?>
								   <SPPB>	
										<SPPB_KARANTINA>		
											<RESULT>FALSE</RESULT>
											<MESSAGES>Cannot execute query [container].</MESSAGES>
										</SPPB_KARANTINA>	
								   </SPPB>';
                    $SQL = "UPDATE req_xml SET XML_RESPONSE = '" . str_replace("'", "\'", $return) . "' 
								WHERE ID = '" . $ID_REQ_XML . "'";
                    $Execute = $conn->execute($SQL);
                    $conn->disconnect();
                    return $return;
                }

                $SQL = "INSERT INTO spjmkontstatushis (KDSPJM,NOKONT,KDSTATUS,TGSTATUS)
							VALUES (" . $ID_TPFT . "," . $NO_CONT . ",'10','" . $timestamps . "')";
                $Execute = $conn->execute($SQL);
            }

            //DETAIL DOCUMENT				
            $RETURN_FL_KARANTINA = array();
            if ($CountSPPB == 1) {
                $CountDocument = count($link['SPPB_KARANTINA']['_c']['DOCUMENTS']['_c']['DOCUMENT']);
                $SPPB_KARANTINA = $link['SPPB_KARANTINA']['_c'];
            } else {
                $CountDocument = count($link['SPPB_KARANTINA'][$c]['_c']['DOCUMENTS']['_c']['DOCUMENT']);
                $SPPB_KARANTINA = $link['SPPB_KARANTINA'][$c]['_c'];
            }

            $SQLDOCUMENT = array();
            $SPPBNO = "NULL";
            $SPPBTGL = "NULL";
            $FL_CETAK = "N";
            $SPPBARR = array("300", "420", "310");
            for ($d = 0; $d < $CountDocument; $d++) {
                if ($CountDocument == 1) {
                    $detailDocument = $SPPB_KARANTINA['DOCUMENTS']['_c']['DOCUMENT']['_c'];
                } else {
                    $detailDocument = $SPPB_KARANTINA['DOCUMENTS']['_c']['DOCUMENT'][$d]['_c'];
                }

                $DOCUMENT_GA = $detailDocument['GA']['_v'] == "" ? "NULL" : "'" . $detailDocument['GA']['_v'] . "'";
                $JNS_DOK = $detailDocument['DOKKD']['_v'] == "" ? "NULL" : "'" . $detailDocument['DOKKD']['_v'] . "'";
                $NO_DOK = $detailDocument['DOKNO']['_v'] == "" ? "NULL" : "'" . $detailDocument['DOKNO']['_v'] . "'";
                $TGL_DOK = $detailDocument['DOKTG']['_v'] == "" ? "NULL" : "'" . $detailDocument['DOKTG']['_v'] . "'";

                $SQL = "SELECT KODEDOK, KDGA
							FROM kodedokumen 
							WHERE KODEDOK = " . $JNS_DOK . "";
                $Query = $conn->query($SQL);
                $Query->next();
                $KODEDOK = $Query->get(0);
                $KDGA = $Query->get(1);

                if ($detailDocument['JNS_DOK']['_v'] == "705") { // NOBL
                    if (($NO_DOK != '') && ($TGL_DOK != '')) {
                        $BLNO = $NO_DOK;
                        $BLTGL = $TGL_DOK;
                        $SQL = "UPDATE spjm SET NOBL = " . $NO_DOK . ", TGBL = " . $TGL_DOK . " WHERE KDSPJM = " . $ID_TPFT . "";
                        $ExecuteUpdateBL = $conn->execute($SQL);
                    }
                } else {
                    $SQL = "SELECT KDSPJM, KDDOK, TIPEDOK FROM spjmdok 
								WHERE KDSPJM = " . $ID_TPFT . " AND KDDOK = " . $JNS_DOK . " AND TIPEDOK = '001'";
                    $QueryCheckSPJM = $conn->query($SQL);
                    if ($QueryCheckSPJM->size() == 0) {
                        if (in_array($detailDocument['DOKKD']['_v'], $SPPBARR)) {
                            $SPPBNO = $NO_DOK;
                            $SPPBTGL = $TGL_DOK;
                        }

                        $SQL = "INSERT INTO spjmdok (KDSPJM, KDDOK, NODOK, TGDOK, TIPEDOK)
									VALUES (" . $ID_TPFT . ", " . $JNS_DOK . ", " . $NO_DOK . ", " . $TGL_DOK . ", '001')";
                        $ExecuteInsertSPJM = $conn->execute($SQL);
                        $SQLDOCUMENT[] = $SQL;
                        $SQL = "SELECT A.RISK, A.FL_CETAK
									FROM spjmdoksubmit A
									WHERE A.KDDOK = " . $JNS_DOK . "
										  AND A.NODOK = " . $NO_DOK . "
										  AND A.TGDOK = " . $TGL_DOK . "
										  AND A.FL_USED = '0'";
                        $QueryCheckSubmitTPFT = $conn->query($SQL);
                        if ($QueryCheckSubmitTPFT->size() > 0) {
                            $QueryCheckSubmitTPFT->next();
                            $RISK = $QueryCheckSubmitTPFT->get(0);
                            $FL_CETAK = $QueryCheckSubmitTPFT->get(1);
                            if ($RISK != '') {
                                $SQL = "UPDATE spjm SET RISK_LEVEL = '" . $RISK . "' WHERE KDSPJM = " . $ID_TPFT . "";
                                $ExecuteUpdateSubmitTPFT = $conn->execute($SQL);
                            }
                            if ($FL_CETAK != '') {
                                $SQL = "UPDATE spjmkont SET FL_CETAK = '" . $FL_CETAK . "', TGPERINTAHCETAK = '" . $timestamps . "'
											WHERE KDSPJM = " . $ID_TPFT . "";
                                $ExecuteUpdateSubmitTPFT = $conn->execute($SQL);
                            }
                            if ($ID_TPFT != '') {
                                $SQL = "UPDATE spjmdoksubmit SET FL_USED = '1', KDSPJM = " . $ID_TPFT . ", DATE_REALISASI = '" . $timestamps . "'
											WHERE KDDOK = " . $JNS_DOK . "
												  AND NODOK = " . $NO_DOK . "
												  AND TGDOK = " . $TGL_DOK . "";
                                $ExecuteUpdateSubmitTPFT = $conn->execute($SQL);
                            }
                        }
                    }
                }
                $SPPBARR = array("300", "420", "310");
                if (!in_array($detailDocument['DOKKD']['_v'], $SPPBARR)) {
                    switch ($KDGA) {
                        case "02"://KARANTINA IKAN
                            $FIELD_FLAG_KARANTINA = 'FLKI';
                            $RETURN_FL_KARANTINA[] = "TRUE";
                            $ADDTEXTSMS = 'Ikan';
                            break;
                        case "03"://KARANTINA HEWAN
                            $FIELD_FLAG_KARANTINA = 'FLKH';
                            $RETURN_FL_KARANTINA[] = "TRUE";
                            $ADDTEXTSMS = 'Hewan';
                            break;
                        case "04"://KARANTINA TUMBUHAN	
                            $FIELD_FLAG_KARANTINA = 'FLKT';
                            $RETURN_FL_KARANTINA[] = "TRUE";
                            $ADDTEXTSMS = 'Tumbuhan';
                            break;
                        case "07"://BEA CUKAI
                            $FIELD_FLAG_KARANTINA = 'FLBC';
                            $RETURN_FL_KARANTINA[] = "FALSE";
                            $ADDTEXTSMS = 'Bea Cukai';
                            break;
                    }
                }
                if ($FIELD_FLAG_KARANTINA != '') {
                    $SQL = "UPDATE spjm SET " . $FIELD_FLAG_KARANTINA . " = 'Y' WHERE KDSPJM = " . $ID_TPFT;
                    $ExecuteUpdateFlagInstansi = $conn->execute($SQL);
                }
            }

            if (in_array("TRUE", $RETURN_FL_KARANTINA)) {
                $SQL = "UPDATE spjm SET FLKARANTINA = 'Y' WHERE KDSPJM = " . $ID_TPFT;
                $ExecuteUpdateFlagKarantina = $conn->execute($SQL);
            }

            //DETAIL KOMODITI
            if ($CountSPPB == 1) {
                $CountKomoditi = count($link['SPPB_KARANTINA']['_c']['KOMODITI']['_c']['BARANG']);
                $SPPB_KARANTINA = $link['SPPB_KARANTINA']['_c'];
            } else {
                $CountKomoditi = count($link['SPPB_KARANTINA'][$c]['_c']['KOMODITI']['_c']['BARANG']);
                $SPPB_KARANTINA = $link['SPPB_KARANTINA'][$c]['_c'];
            }
            for ($d = 0; $d < $CountKomoditi; $d++) {
                if ($CountKomoditi == 1) {
                    $detailKomoditi = $SPPB_KARANTINA['KOMODITI']['_c']['BARANG']['_c'];
                } else {
                    $detailKomoditi = $SPPB_KARANTINA['KOMODITI']['_c']['BARANG'][$d]['_c'];
                }

                $SERIAL = $detailKomoditi['SERIAL']['_v'] == "" ? "NULL" : "'" . $detailKomoditi['SERIAL']['_v'] . "'";
                $NOHS = $detailKomoditi['NOHS']['_v'] == "" ? "NULL" : "'" . $detailKomoditi['NOHS']['_v'] . "'";
                $SERITRP = $detailKomoditi['SERITRP']['_v'] == "" ? "NULL" : "'" . $detailKomoditi['SERITRP']['_v'] . "'";
                $BRGURAI = $detailKomoditi['BRGURAI']['_v'] == "" ? "NULL" : "'" . $detailKomoditi['BRGURAI']['_v'] . "'";
                $MERK = $detailKomoditi['MERK']['_v'] == "" ? "NULL" : "'" . $detailKomoditi['MERK']['_v'] . "'";
                $TIPE = $detailKomoditi['TIPE']['_v'] == "" ? "NULL" : "'" . $detailKomoditi['TIPE']['_v'] . "'";
                $SPFLAIN = $detailKomoditi['SPFLAIN']['_v'] == "" ? "NULL" : "'" . $detailKomoditi['SPFLAIN']['_v'] . "'";
                $BRGASAL = $detailKomoditi['BRGASAL']['_v'] == "" ? "NULL" : "'" . $detailKomoditi['BRGASAL']['_v'] . "'";
                $DNILINV = $detailKomoditi['DNILINV']['_v'] == "" ? "NULL" : "'" . $detailKomoditi['DNILINV']['_v'] . "'";
                $DCIF = $detailKomoditi['DCIF']['_v'] == "" ? "NULL" : "'" . $detailKomoditi['DCIF']['_v'] . "'";
                $KDSAT = $detailKomoditi['KDSAT']['_v'] == "" ? "NULL" : "'" . $detailKomoditi['KDSAT']['_v'] . "'";
                $JMLSAT = $detailKomoditi['JMLSAT']['_v'] == "" ? "NULL" : "'" . $detailKomoditi['JMLSAT']['_v'] . "'";
                $KEMASJN = $detailKomoditi['KEMASJN']['_v'] == "" ? "NULL" : "'" . $detailKomoditi['KEMASJN']['_v'] . "'";
                $KEMASJM = $detailKomoditi['KEMASJM']['_v'] == "" ? "NULL" : "'" . $detailKomoditi['KEMASJM']['_v'] . "'";
                $SATBMJM = $detailKomoditi['SATBMJM']['_v'] == "" ? "NULL" : "'" . $detailKomoditi['SATBMJM']['_v'] . "'";
                $SATCUKJM = $detailKomoditi['SATCUKJM']['_v'] == "" ? "NULL" : "'" . $detailKomoditi['SATCUKJM']['_v'] . "'";
                $NETTODTL = $detailKomoditi['NETTODTL']['_v'] == "" ? "NULL" : "'" . $detailKomoditi['NETTODTL']['_v'] . "'";
                $KDFASDTL = $detailKomoditi['KDFASDTL']['_v'] == "" ? "NULL" : "'" . $detailKomoditi['KDFASDTL']['_v'] . "'";
                $DTLOK = $detailKomoditi['DTLOK']['_v'] == "" ? "NULL" : "'" . $detailKomoditi['DTLOK']['_v'] . "'";

                $SQL = "INSERT INTO spjmkomoditi (KDSPJM, SERIAL, NOHS, SERITRP, BRGURAI, MERK, TIPE, SPFLAIN, BRGASAL, DNILINV, 
													  DCIF, JMLSATUAN, KDSATUAN, JMLKEMASAN, KDKEMASAN, SATBMJM, SATCUKJM, NETTODTL, 
													  KDFASDTL, DTLOK)
							VALUES (" . $ID_TPFT . ", " . $SERIAL . ", " . $NOHS . ", " . $SERITRP . ", " . $BRGURAI . ", " . $MERK . ", " . $TIPE . ", 
										" . $SPFLAIN . ", " . $BRGASAL . ", " . $DNILINV . ", 
									" . $DCIF . ", " . $JMLSAT . ", " . $KDSAT . ", " . $KEMASJM . ", " . $KEMASJN . ", " . $SATBMJM . ", " . $SATCUKJM . ", 
										" . $NETTODTL . ", " . $KDFASDTL . ", " . $DTLOK . ")";
                $ExecuteKomoditi = $conn->execute($SQL);
            }

            //KIRIM KE TPS ASAL				
            $SQL = "SELECT A.KDSPJM
						FROM spjm A INNER JOIN spjmdok B ON A.KDSPJM = B.KDSPJM
									INNER JOIN kodedokumen C ON C.KODEDOK = B.KDDOK AND C.KDGA IN ('04')
						WHERE DATE(B.TGDOK) >= DATE('2014-06-09')
							  AND A.CAR = " . $CAR . "";
            $QueryCheckDokKarantina = $conn->query($SQL);
            if ($QueryCheckDokKarantina->size() > 0) {
                $SQL = "INSERT INTO kirimsp3udk (CAR, PIB_NO, PIB_DATE, SPPB_NO, SPPB_DATE, BL_NO, BL_DATE, 
													 VESSEL, VOY, ARRIVE, NPWP_CONSIGNEE, CONSIGNEE, 
													 KD_GUDANG_ASAL, FL_CETAK, DATE_CREATED)
							VALUES (" . $CAR . ", " . $PIBNO . ", " . $PIBTGL . ", " . $SPPBNO . ", " . $SPPBTGL . ", " . $BLNO . ", " . $BLTGL . ", 
									" . $VESSEL . ", " . $VOY . ", " . $TGLTIBA . ", " . $IMPNPWP . ", " . $IMPNAMA . ", 
									" . $KD_GUDANG . ", '" . $FL_CETAK . "', NOW())";
                $ExecuteFlagCetak = $conn->execute($SQL);
            }
        }
        if ($Execute) {
            $return = '<?xml version="1.0"?>
						   <SPPB>	
								<SPPB_KARANTINA>		
									<RESULT>TRUE</RESULT>
									<MESSAGES>Send SPPB Karantina has been successfully.</MESSAGES>
								</SPPB_KARANTINA>	
						   </SPPB>';
        }
        $SQL = "UPDATE req_xml SET XML_RESPONSE = '" . str_replace("'", "\'", $return) . "' 
					WHERE ID = '" . $ID_REQ_XML . "'";
        $Execute2 = $conn->execute($SQL);
        if ($Execute) {
            //$FL_CETAK="Y";
            if ($FL_CETAK == 'Y') {
                $CAR = $header['CAR']['_v'];
                $NO_PIB = $header['PIBNO']['_v'];
                $TGL_PIB = changeFormatDate3($header['PIBTGL']['_v']);
                $JmlKontainer = $CountContainer;
                $textSMS = "Anda mendapatkan data SPPB Wajib Karantina " . $ADDTEXTSMS . " dengan No. PIB : " . $NO_PIB . ", Tgl. PIB : " . $TGL_PIB . ", Jumlah Kontainer : " . $JmlKontainer;
                $textSMSIMPPPJK = "Data SPPB Wajib Karantina " . $ADDTEXTSMS . " sudah masuk ke TPFT dengan No. PIB : " . $NO_PIB . ", Tgl. PIB : " . $TGL_PIB . ", Jumlah Kontainer : " . $JmlKontainer;
                sendSMStoTPFT($KDORG_TPFT, 'HIJAU', $textSMS, $ID_TPFT, $textSMSIMPPPJK);
            }
        }
    } else {
        $return = '<?xml version="1.0"?>
					   <SPPB>	
							<SPPB_KARANTINA>		
								<RESULT>FALSE</RESULT>
								<MESSAGES>String0 or String1 wrong. Please check your data.</MESSAGES>
							</SPPB_KARANTINA>	
					   </SPPB>';
        $SQL = "UPDATE req_xml SET XML_RESPONSE = '" . str_replace("'", "\'", $return) . "' 
					WHERE ID = '" . $ID_REQ_XML . "'";
        $Execute = $conn->execute($SQL);
    }
    $conn->disconnect();
    return $return;
}

function sendSMStoTPFT($KDORG_TPFT, $TIPEUSER, $text, $KDSPJM, $textIMPPPJK) {
    global $conn, $CONF, $connSMS;
    $SQL = "SELECT DISTINCT HANDPHONE FROM user
				WHERE KDORG = '" . $KDORG_TPFT . "'	AND TIPEUSER IN ('" . $TIPEUSER . "','BOTH')";
    $QuerySMS = $conn->query($SQL);
    if ($QuerySMS->size() > 0) {
        //$SMS = new main($CONF,$connSMS);
        //$SMS->connect();
        while ($QuerySMS->next()) {
            $phone_number = $QuerySMS->get(0);
            //$SMS->sendSMS($phone_number,$text);
            if ($CONF['send.sms']) {
                $connSMS->connect();
                if ($connSMS->isConnect) {
                    $SQL = "INSERT INTO tbl_outbox(TBL_APP_ID_APP, PHONE_NUMBER, TEXT) 
								VALUES('2','" . $phone_number . "','" . $text . "')";
                    $Execute = $connSMS->execute($SQL);
                    $SQL = "INSERT INTO a_sms (PHONE_NUMBER,TEXT)
								VALUES ('" . $phone_number . "','" . $text . "')";
                    $Execute = $conn->execute($SQL);
                }
                $connSMS->disconnect();
            }
        }
        $SQL = "SELECT DISTINCT A.HANDPHONE
					FROM user A INNER JOIN organisasi B ON A.KDORG = B.KDORG
					WHERE (B.NPWP IN (select impnpwp from spjm where kdspjm = '" . $KDSPJM . "') 
							OR B.NPWP IN (select ppjknpwp from spjm where kdspjm = '" . $KDSPJM . "'))";
        $QuerySMS = $conn->query($SQL);
        if ($QuerySMS->size() > 0) {
            while ($QuerySMS->next()) {
                $phone_number = $QuerySMS->get(0);
                //$SMS->sendSMS($phone_number,$textIMPPPJK);
                if ($CONF['send.sms']) {
                    $connSMS->connect();
                    if ($connSMS->isConnect) {
                        $SQL = "INSERT INTO tbl_outbox(TBL_APP_ID_APP, PHONE_NUMBER, TEXT) 
									VALUES('2','" . $phone_number . "','" . $textIMPPPJK . "')";
                        $Execute = $connSMS->execute($SQL);
                        $SQL = "INSERT INTO a_sms (PHONE_NUMBER,TEXT)
									VALUES ('" . $phone_number . "','" . $text . "')";
                        $Execute = $conn->execute($SQL);
                    }
                    $connSMS->disconnect();
                }
            }
        }
        /* $SMS->connect(false); */
    }
}

function SendSpjm($String0, $String1, $String2, $String3) {
    global $conn, $CONF, $connSMS;
    $vUsername = array("TPFT", "WSMAL", "WSJICT", "WSPLDC");
    $vPassword = array("19911402", "19912407", "19912405", "20140606");
    $username = $String0;
    $password = $String1;
    $KodeTPS = $String2;
    $xml = str_replace('&', '&amp;', $String3);
    $timestamps = date("Y-m-d H:i:s");
    $KDORG_TPFT = 9;

    $conn->connect();
    if ((in_array($username, $vUsername)) && (in_array($password, $vPassword))) {
        if ($xml == '') {
            $return = '<?xml version="1.0"?><DOCUMENT><SPJM><RESULT>FALSE</RESULT><MESSAGES>XML not defined.</MESSAGES></SPJM></DOCUMENT>';
            $SQL = "INSERT INTO req_xml (XML_REQUEST,XML_RESPONSE,DATE_CREATED,USERNAME,IP_ADDRESS)
						VALUES ('" . str_replace("'", "\'", $xml) . "','" . str_replace("'", "\'", $return) . "','" . date('Y-m-d H:i:s') . "',
								'" . $username . "','" . getIP() . "')";
            $Execute = $conn->execute($SQL);
            $conn->disconnect();
            return $return;
        }

        $SQL = "INSERT INTO req_xml (XML_REQUEST,DATE_CREATED,USERNAME,IP_ADDRESS)
					VALUES ('" . str_replace("'", "\'", $xml) . "','" . date('Y-m-d H:i:s') . "','" . $username . "','" . getIP() . "')";
        $Execute = $conn->execute($SQL);
        $ID_REQ_XML = mysql_insert_id();

        $xml = xml2ary($xml);
        $link = & $xml['DOCUMENT']['_c'];
        $CountSPJM = count($link['SPJM']);
        for ($c = 0; $c < $CountSPJM; $c++) {
            //HEADER 
            if ($CountSPJM == 1) {
                $header = $link['SPJM']['_c']['HEADER']['_c'];
            } else {
                $header = $link['SPJM'][$c]['_c']['HEADER']['_c'];
            }

            $CAR = replaceCar($header['CAR']['_v']) == "" ? "NULL" : "'" . replaceCar($header['CAR']['_v']) . "'";
            $KD_KANTOR = $header['KD_KANTOR']['_v'] == "" ? "'040300'" : "'" . $header['KD_KANTOR']['_v'] . "'";
            $NO_PIB = $header['NO_PIB']['_v'] == "" ? "NULL" : "'" . $header['NO_PIB']['_v'] . "'";
            $TGL_PIB = changeFormatDate($header['TGL_PIB']['_v']) == "" ? "NULL" : "'" . changeFormatDate($header['TGL_PIB']['_v']) . "'";
            $NPWP_IMP = replaceNPWP($header['NPWP_IMP']['_v']) == "" ? "NULL" : "'" . replaceNPWP($header['NPWP_IMP']['_v']) . "'";
            $NAMA_IMP = $header['NAMA_IMP']['_v'] == "" ? "NULL" : "'" . $header['NAMA_IMP']['_v'] . "'";
            $NPWP_PPJK = replaceNPWP($header['NPWP_PPJK']['_v']) == "" ? "NULL" : "'" . replaceNPWP($header['NPWP_PPJK']['_v']) . "'";
            $NAMA_PPJK = $header['NAMA_PPJK']['_v'] == "" ? "NULL" : "'" . $header['NAMA_PPJK']['_v'] . "'";
            $GUDANG = strtoupper($header['GUDANG']['_v']) == "" ? "NULL" : "'" . strtoupper($header['GUDANG']['_v']) . "'";
            $JML_CONT = $header['JML_CONT']['_v'] == "" ? "NULL" : "'" . $header['JML_CONT']['_v'] . "'";
            $NO_BC11 = $header['NO_BC11']['_v'] == "" ? "NULL" : "'" . $header['NO_BC11']['_v'] . "'";
            $TGL_BC11 = changeFormatDate($header['TGL_BC11']['_v']) == "" ? "NULL" : "'" . changeFormatDate($header['TGL_BC11']['_v']) . "'";
            $NO_POS_BC11 = $header['NO_POS_BC11']['_v'] == "" ? "NULL" : "'" . $header['NO_POS_BC11']['_v'] . "'";
            $FL_KARANTINA = $header['FL_KARANTINA']['_v'] == "" ? "NULL" : "'" . $header['FL_KARANTINA']['_v'] . "'";
            $TGL_BONGKAR = changeFormatDate($header['TGL_BONGKAR']['_v']) == "" ? "NULL" : "'" . changeFormatDate($header['TGL_BONGKAR']['_v']) . "'";

            $SQL = "SELECT CAR FROM spjm WHERE CAR = " . $CAR . "";
            $Query = $conn->query($SQL);
            if ($Query->size() > 0) {
                $return = '<?xml version="1.0"?><DOCUMENT><SPJM><RESULT>FALSE</RESULT><MESSAGES>CAR already exist.</MESSAGES></SPJM></DOCUMENT>';
                $SQL = "UPDATE req_xml SET XML_RESPONSE = '" . str_replace("'", "\'", $return) . "' 
							WHERE ID = '" . $ID_REQ_XML . "'";
                $Execute = $conn->execute($SQL);
                $conn->disconnect();
                return $return;
            }

            //SQL HEADER 
            $SQL = "INSERT INTO spjm (CAR, KDKPBC, NOPIB, TGPIB, IMPNPWP, IMPNAMA, PPJKNPWP, PPJKNAMA, 
											  KDGUDANG, JMLKONT, NOBC11, TGBC11, NOPOSBC11, FLKARANTINA, SENT_VIA, 
											  DATE_CREATED, KDORG_TPFT)
						VALUES(" . $CAR . ", " . $KD_KANTOR . ", " . $NO_PIB . ", " . $TGL_PIB . ", " . $NPWP_IMP . ", " . $NAMA_IMP . ", 
							   " . $NPWP_PPJK . ", " . $NAMA_PPJK . ", " . $GUDANG . ", " . $JML_CONT . ", " . $NO_BC11 . ", " . $TGL_BC11 . ", 
							   " . $NO_POS_BC11 . ", " . $FL_KARANTINA . ",'WS TPS','" . $timestamps . "','" . $KDORG_TPFT . "')";
            $Execute = $conn->execute($SQL);
            if (!$Execute) {
                $return = '<?xml version="1.0"?><DOCUMENT><SPJM><RESULT>FALSE</RESULT><MESSAGES>Cannot execute query [header].</MESSAGES></SPJM></DOCUMENT>';
                $SQL = "UPDATE req_xml SET XML_RESPONSE = '" . str_replace("'", "\'", $return) . "' 
							WHERE ID = '" . $ID_REQ_XML . "'";
                $Execute = $conn->execute($SQL);
                $conn->disconnect();
                return $return;
            }
            $ID_TPFT = mysql_insert_id();


            if ($NO_PIB != '') {
                $SQL = "INSERT INTO spjmdok (KDSPJM, KDDOK, NODOK, TGDOK, TIPEDOK)
							VALUES (" . $ID_TPFT . ", '100', " . $NO_PIB . ", " . $TGL_PIB . ", '001')";
                $ExecuteInsertNoSPJM = $conn->execute($SQL);
            }

            //DETAIL CONTAINER
            $ID_CONT = array();
            if ($CountSPJM == 1) {
                $CountContainer = count($link['SPJM']['_c']['DETIL']['_c']['CONT']);
                $SPJM = $link['SPJM']['_c'];
            } else {
                $CountContainer = count($link['SPJM'][$c]['_c']['DETIL']['_c']['CONT']);
                $SPJM = $link['SPJM'][$c]['_c'];
            }
            for ($d = 0; $d < $CountContainer; $d++) {
                if ($CountContainer == 1) {
                    $detailContainer = $SPJM['DETIL']['_c']['CONT']['_c'];
                } else {
                    $detailContainer = $SPJM['DETIL']['_c']['CONT'][$d]['_c'];
                }

                $CAR_DETAIL_CONTAINER = $detailContainer['CAR']['_v'] == "" ? "NULL" : "'" . $detailContainer['CAR']['_v'] . "'";
                $NO_CONT = $detailContainer['NO_CONT']['_v'] == "" ? "NULL" : "'" . $detailContainer['NO_CONT']['_v'] . "'";
                $SIZE = $detailContainer['SIZE']['_v'] == "" ? "NULL" : "'" . $detailContainer['SIZE']['_v'] . "'";
                $BARCODE = Barcode();
                $STATUS_DATE = date("Y-m-d H:i:s");

                $REFER_FLAG = $detailContainer['REFER_FLAG']['_v'] == "" ? "NULL" : "'" . $detailContainer['REFER_FLAG']['_v'] . "'";
                $DG_CODE = $detailContainer['DG_CODE']['_v'] == "" ? "NULL" : "'" . $detailContainer['DG_CODE']['_v'] . "'";
                $OD_FLAG = $detailContainer['OD_FLAG']['_v'] == "" ? "NULL" : "'" . $detailContainer['OD_FLAG']['_v'] . "'";
                $START_PLUG = changeFormatDateTime($detailContainer['START_PLUG']['_v']) == "" ? "NULL" : "'" . changeFormatDateTime($detailContainer['START_PLUG']['_v']) . "'";
                $SETTING_TEMP = $detailContainer['SETTING_TEMP']['_v'] == "" ? "NULL" : "'" . $detailContainer['SETTING_TEMP']['_v'] . "'";
                $TEMP_SATUAN = $detailContainer['TEMP_SATUAN']['_v'] == "" ? "NULL" : "'" . $detailContainer['TEMP_SATUAN']['_v'] . "'";

                //SQL CONTAINER 
                $SQL = "INSERT INTO spjmkont (KDSPJM, BARCODE, NOKONT, UKURAN, KDSTATUS, TGSTATUS,
												  REFER_FLAG, DG_CODE, OD_FLAG, START_PLUG, SETTING_TEMP, TEMP_SATUAN, 
												  TGBONGKAR, FL_CETAK)
							VALUES (" . $ID_TPFT . ", '" . $BARCODE . "', " . $NO_CONT . ", " . $SIZE . ", '10', '" . $timestamps . "', 
									" . $REFER_FLAG . ", " . $DG_CODE . ", " . $OD_FLAG . ", " . $START_PLUG . ", " . $SETTING_TEMP . ", 
									" . $TEMP_SATUAN . ", " . $TGL_BONGKAR . ", 'Y')";
                $Execute = $conn->execute($SQL);
                if (!$Execute) {
                    $SQL = "DELETE FROM spjmkont WHERE KDSPJM = '" . $ID_TPFT . "'";
                    $ExecuteDelete = $conn->execute($SQL);
                    $SQL = "DELETE FROM spjm WHERE KDSPJM = '" . $ID_TPFT . "'";
                    $ExecuteDelete = $conn->execute($SQL);
                    $return = '<?xml version="1.0"?><DOCUMENT><SPJM><RESULT>FALSE</RESULT><MESSAGES>Cannot execute query [container].</MESSAGES></SPJM></DOCUMENT>';
                    $SQL = "UPDATE req_xml SET XML_RESPONSE = '" . str_replace("'", "\'", $return) . "' 
								WHERE ID = '" . $ID_REQ_XML . "'";
                    $Execute = $conn->execute($SQL);
                    $conn->disconnect();
                    return $return;
                }

                $SQL = "INSERT INTO spjmkontstatushis (KDSPJM,NOKONT,KDSTATUS,TGSTATUS)
							VALUES (" . $ID_TPFT . "," . $NO_CONT . ",'10','" . $timestamps . "')";
                $Execute = $conn->execute($SQL);
            }

            //DETAIL DOCUMENT				
            if ($CountSPJM == 1) {
                $CountDocument = count($link['SPJM']['_c']['DETIL']['_c']['DOK']);
                $SPJM = $link['SPJM']['_c'];
            } else {
                $CountDocument = count($link['SPJM'][$c]['_c']['DETIL']['_c']['DOK']);
                $SPJM = $link['SPJM'][$c]['_c'];
            }
            for ($d = 0; $d < $CountDocument; $d++) {
                if ($CountDocument == 1) {
                    $detailDocument = $SPJM['DETIL']['_c']['DOK']['_c'];
                } else {
                    $detailDocument = $SPJM['DETIL']['_c']['DOK'][$d]['_c'];
                }

                $CAR_DETAIL_DOCUMENT = $detailDocument['CAR']['_v'] == "" ? "NULL" : "'" . $detailDocument['CAR']['_v'] . "'";
                $JNS_DOK = $detailDocument['JNS_DOK']['_v'] == "" ? "NULL" : "'" . $detailDocument['JNS_DOK']['_v'] . "'";
                $NO_DOK = $detailDocument['NO_DOK']['_v'] == "" ? "NULL" : "'" . $detailDocument['NO_DOK']['_v'] . "'";
                $TGL_DOK = changeFormatDate($detailDocument['TGL_DOK']['_v']) == "" ? "NULL" : "'" . changeFormatDate($detailDocument['TGL_DOK']['_v']) . "'";

                $SQL = "SELECT KODEDOK, KDGA
							FROM kodedokumen 
							WHERE KODEDOK = " . $JNS_DOK . "";
                $Query = $conn->query($SQL);
                $Query->next();
                $KODEDOK = $Query->get(0);
                $KDGA = $Query->get(1);

                if ($detailDocument['JNS_DOK']['_v'] == "705") { // NOBL
                    if (($NO_DOK != '') && ($TGL_DOK != '')) {
                        $SQL = "UPDATE spjm SET NOBL = " . $NO_DOK . ", TGBL = " . $TGL_DOK . " WHERE KDSPJM = " . $ID_TPFT . "";
                        $ExecuteUpdateBL = $conn->execute($SQL);
                    }
                } else {
                    $SQL = "SELECT KDSPJM, KDDOK, TIPEDOK FROM spjmdok 
								WHERE KDSPJM = " . $ID_TPFT . " AND KDDOK = " . $JNS_DOK . " AND TIPEDOK = '001'";
                    $QueryCheckSPJM = $conn->query($SQL);
                    if ($QueryCheckSPJM->size() == 0) {
                        $SQL = "INSERT INTO spjmdok (KDSPJM, KDDOK, NODOK, TGDOK, TIPEDOK)
									VALUES (" . $ID_TPFT . ", " . $JNS_DOK . ", " . $NO_DOK . ", " . $TGL_DOK . ", '001')";
                        $ExecuteInsertSPJM = $conn->execute($SQL);
                    }
                }

                switch ($KDGA) {
                    case "02"://KARANTINA IKAN
                        $FIELD_FLAG_KARANTINA = 'FLKI';
                        break;
                    case "03"://KARANTINA HEWAN
                        $FIELD_FLAG_KARANTINA = 'FLKH';
                        break;
                    case "04"://KARANTINA TUMBUHAN	
                        $FIELD_FLAG_KARANTINA = 'FLKT';
                        break;
                    case "07"://BEA CUKAI
                        $FIELD_FLAG_KARANTINA = 'FLBC';
                        break;
                }
                if ($FIELD_FLAG_KARANTINA != '') {
                    $SQL = "UPDATE spjm SET " . $FIELD_FLAG_KARANTINA . " = 'Y' WHERE KDSPJM = " . $ID_TPFT;
                    $ExecuteUpdateFlagInstansi = $conn->execute($SQL);
                }
            }

            if ($CountDocument == 0) {
                $SQL = "UPDATE spjm SET FLBC = 'Y' WHERE KDSPJM = " . $ID_TPFT;
                $ExecuteUpdateFlagInstansi = $conn->execute($SQL);
            }
        }
        if ($Execute) {
            $return = '<?xml version="1.0"?><DOCUMENT><SPJM><RESULT>TRUE</RESULT><MESSAGES>Send SPJM has been successfully.</MESSAGES></SPJM></DOCUMENT>';
        }
        $SQL = "UPDATE req_xml SET XML_RESPONSE = '" . str_replace("'", "\'", $return) . "' 
					WHERE ID = '" . $ID_REQ_XML . "'";
        $Execute2 = $conn->execute($SQL);
        if ($Execute) {
            $CAR = $header['CAR']['_v'];
            $NO_PIB = $header['NO_PIB']['_v'];
            $TGL_PIB = $header['TGL_PIB']['_v'];
            $JmlKontainer = $CountContainer;
            $textSMS = "Anda mendapatkan data SPJM dengan No. PIB : " . $NO_PIB . ", Tgl. PIB : " . $TGL_PIB . ", Jumlah Kontainer : " . $JmlKontainer;
            $textSMSIMPPPJK = "data SPJM sudah masuk ke TPFT dengan No. PIB : " . $NO_PIB . ", Tgl. PIB : " . $TGL_PIB . ", Jumlah Kontainer : " . $JmlKontainer;
            sendSMStoTPFT($KDORG_TPFT, 'MERAH', $textSMS, $ID_TPFT, $textSMSIMPPPJK);
        }
    } else {
        $return = '<?xml version="1.0"?><DOCUMENT><SPJM><RESULT>FALSE</RESULT><MESSAGES>String0 or String1 wrong. Please check your data.</MESSAGES></SPJM></DOCUMENT>';
        $SQL = "UPDATE req_xml SET XML_RESPONSE = '" . str_replace("'", "\'", $return) . "' 
					WHERE ID = '" . $ID_REQ_XML . "'";
        $Execute = $conn->execute($SQL);
    }
    $conn->disconnect();

    return $return;
}

function SendSpjmJICT($String0, $String1, $String2, $String3) {
    global $conn, $CONF, $connSMS;
    $vUsername = array("TPFT", "WSMAL", "WSJICT", "WSPLDC");
    $vPassword = array("19911402", "19912407", "19912405", "20140606");
    $username = $String0;
    $password = $String1;
    $KodeTPS = $String2;
    $xml = str_replace('&', '&amp;', $String3);
    $timestamps = date("Y-m-d H:i:s");
    $KDORG_TPFT = 9;

    $conn->connect();
    if ((in_array($username, $vUsername)) && (in_array($password, $vPassword))) {
        if ($xml == '') {
            $return = '<?xml version="1.0"?><DOCUMENT><SPJM><RESULT>FALSE</RESULT><MESSAGES>XML not defined.</MESSAGES></SPJM></DOCUMENT>';
            $SQL = "INSERT INTO req_xml (XML_REQUEST,XML_RESPONSE,DATE_CREATED,USERNAME,IP_ADDRESS)
						VALUES ('" . str_replace("'", "\'", $xml) . "','" . str_replace("'", "\'", $return) . "','" . date('Y-m-d H:i:s') . "',
								'" . $username . "','" . getIP() . "')";
            $Execute = $conn->execute($SQL);
            $conn->disconnect();
            return $return;
        }

        $SQL = "INSERT INTO req_xml (XML_REQUEST,DATE_CREATED,USERNAME,IP_ADDRESS)
					VALUES ('" . str_replace("'", "\'", $xml) . "','" . date('Y-m-d H:i:s') . "','" . $username . "','" . getIP() . "')";
        $Execute = $conn->execute($SQL);
        $ID_REQ_XML = mysql_insert_id();

        $xml = xml2ary($xml);
        $link = & $xml['DOCUMENT']['_c'];
        $CountSPJM = count($link['SPJM']);
        for ($c = 0; $c < $CountSPJM; $c++) {
            //HEADER 
            if ($CountSPJM == 1) {
                $header = $link['SPJM']['_c']['HEADER']['_c'];
            } else {
                $header = $link['SPJM'][$c]['_c']['HEADER']['_c'];
            }

            $CAR = replaceCar($header['CAR']['_v']) == "" ? "NULL" : "'" . replaceCar($header['CAR']['_v']) . "'";
            $KD_KANTOR = $header['KD_KANTOR']['_v'] == "" ? "'040300'" : "'" . $header['KD_KANTOR']['_v'] . "'";
            $NO_PIB = $header['NO_PIB']['_v'] == "" ? "NULL" : "'" . $header['NO_PIB']['_v'] . "'";
            $TGL_PIB = changeFormatDate($header['TGL_PIB']['_v']) == "" ? "NULL" : "'" . changeFormatDate($header['TGL_PIB']['_v']) . "'";
            $NPWP_IMP = replaceNPWP($header['NPWP_IMP']['_v']) == "" ? "NULL" : "'" . replaceNPWP($header['NPWP_IMP']['_v']) . "'";
            $NAMA_IMP = $header['NAMA_IMP']['_v'] == "" ? "NULL" : "'" . $header['NAMA_IMP']['_v'] . "'";
            $NPWP_PPJK = replaceNPWP($header['NPWP_PPJK']['_v']) == "" ? "NULL" : "'" . replaceNPWP($header['NPWP_PPJK']['_v']) . "'";
            $NAMA_PPJK = $header['NAMA_PPJK']['_v'] == "" ? "NULL" : "'" . $header['NAMA_PPJK']['_v'] . "'";
            $GUDANG = strtoupper($header['GUDANG']['_v']) == "" ? "NULL" : "'" . strtoupper($header['GUDANG']['_v']) . "'";
            $JML_CONT = $header['JML_CONT']['_v'] == "" ? "NULL" : "'" . $header['JML_CONT']['_v'] . "'";
            $NO_BC11 = $header['NO_BC11']['_v'] == "" ? "NULL" : "'" . $header['NO_BC11']['_v'] . "'";
            $TGL_BC11 = changeFormatDate($header['TGL_BC11']['_v']) == "" ? "NULL" : "'" . changeFormatDate($header['TGL_BC11']['_v']) . "'";
            $NO_POS_BC11 = $header['NO_POS_BC11']['_v'] == "" ? "NULL" : "'" . $header['NO_POS_BC11']['_v'] . "'";
            $FL_KARANTINA = $header['FL_KARANTINA']['_v'] == "" ? "'N'" : "'" . $header['FL_KARANTINA']['_v'] . "'";
            $TGL_BONGKAR = changeFormatDate($header['TGL_BONGKAR']['_v']) == "" ? "NULL" : "'" . changeFormatDate($header['TGL_BONGKAR']['_v']) . "'";

            $SQL = "SELECT CAR FROM spjm WHERE CAR = " . $CAR . "";
            $Query = $conn->query($SQL);
            if ($Query->size() > 0) {
                $return = '<?xml version="1.0"?><DOCUMENT><SPJM><RESULT>FALSE</RESULT><MESSAGES>CAR already exist.</MESSAGES></SPJM></DOCUMENT>';
                $SQL = "UPDATE req_xml SET XML_RESPONSE = '" . str_replace("'", "\'", $return) . "' 
							WHERE ID = '" . $ID_REQ_XML . "'";
                $Execute = $conn->execute($SQL);
                $conn->disconnect();
                return $return;
            }

            //SQL HEADER 
            $SQL = "INSERT INTO spjm (CAR, KDKPBC, NOPIB, TGPIB, IMPNPWP, IMPNAMA, PPJKNPWP, PPJKNAMA, 
											  KDGUDANG, JMLKONT, NOBC11, TGBC11, NOPOSBC11, FLKARANTINA, SENT_VIA, 
											  DATE_CREATED, KDORG_TPFT)
						VALUES(" . $CAR . ", " . $KD_KANTOR . ", " . $NO_PIB . ", " . $TGL_PIB . ", " . $NPWP_IMP . ", " . $NAMA_IMP . ", 
							   " . $NPWP_PPJK . ", " . $NAMA_PPJK . ", " . $GUDANG . ", " . $JML_CONT . ", " . $NO_BC11 . ", " . $TGL_BC11 . ", 
							   " . $NO_POS_BC11 . ", " . $FL_KARANTINA . ",'WS TPS','" . $timestamps . "','" . $KDORG_TPFT . "')";
            $Execute = $conn->execute($SQL);
            if (!$Execute) {
                $return = '<?xml version="1.0"?><DOCUMENT><SPJM><RESULT>FALSE</RESULT><MESSAGES>Cannot execute query [header].' . $SQL . '</MESSAGES></SPJM></DOCUMENT>';
                $SQL = "UPDATE req_xml SET XML_RESPONSE = '" . str_replace("'", "\'", $return) . "' 
							WHERE ID = '" . $ID_REQ_XML . "'";
                $Execute = $conn->execute($SQL);
                $conn->disconnect();
                return $return;
            }
            $ID_TPFT = mysql_insert_id();


            if ($NO_PIB != '') {
                $SQL = "INSERT INTO spjmdok (KDSPJM, KDDOK, NODOK, TGDOK, TIPEDOK)
							VALUES (" . $ID_TPFT . ", '100', " . $NO_PIB . ", " . $TGL_PIB . ", '001')";
                $ExecuteInsertNoSPJM = $conn->execute($SQL);
            }

            //DETAIL CONTAINER
            $ID_CONT = array();
            if ($CountSPJM == 1) {
                $CountContainer = count($link['SPJM']['_c']['DETIL']['_c']['CONT']);
                $SPJM = $link['SPJM']['_c'];
            } else {
                $CountContainer = count($link['SPJM'][$c]['_c']['DETIL']['_c']['CONT']);
                $SPJM = $link['SPJM'][$c]['_c'];
            }
            for ($d = 0; $d < $CountContainer; $d++) {
                if ($CountContainer == 1) {
                    $detailContainer = $SPJM['DETIL']['_c']['CONT']['_c'];
                } else {
                    $detailContainer = $SPJM['DETIL']['_c']['CONT'][$d]['_c'];
                }

                $CAR_DETAIL_CONTAINER = $detailContainer['CAR']['_v'] == "" ? "NULL" : "'" . $detailContainer['CAR']['_v'] . "'";
                $NO_CONT = $detailContainer['NO_CONT']['_v'] == "" ? "NULL" : "'" . $detailContainer['NO_CONT']['_v'] . "'";
                $SIZE = $detailContainer['SIZE']['_v'] == "" ? "NULL" : "'" . $detailContainer['SIZE']['_v'] . "'";
                $BARCODE = Barcode();
                $STATUS_DATE = date("Y-m-d H:i:s");

                $REFER_FLAG = $detailContainer['REFER_FLAG']['_v'] == "" ? "NULL" : "'" . $detailContainer['REFER_FLAG']['_v'] . "'";
                $DG_CODE = $detailContainer['DG_CODE']['_v'] == "" ? "NULL" : "'" . $detailContainer['DG_CODE']['_v'] . "'";
                $OD_FLAG = $detailContainer['OD_FLAG']['_v'] == "" ? "NULL" : "'" . $detailContainer['OD_FLAG']['_v'] . "'";
                $START_PLUG = changeFormatDateTime($detailContainer['START_PLUG']['_v']) == "" ? "NULL" : "'" . changeFormatDateTime($detailContainer['START_PLUG']['_v']) . "'";
                $SETTING_TEMP = $detailContainer['SETTING_TEMP']['_v'] == "" ? "NULL" : "'" . $detailContainer['SETTING_TEMP']['_v'] . "'";
                $TEMP_SATUAN = $detailContainer['TEMP_SATUAN']['_v'] == "" ? "NULL" : "'" . $detailContainer['TEMP_SATUAN']['_v'] . "'";

                //SQL CONTAINER 
                $SQL = "INSERT INTO spjmkont (KDSPJM, BARCODE, NOKONT, UKURAN, KDSTATUS, TGSTATUS,
												  REFER_FLAG, DG_CODE, OD_FLAG, START_PLUG, SETTING_TEMP, TEMP_SATUAN, 
												  TGBONGKAR, FL_CETAK)
							VALUES (" . $ID_TPFT . ", '" . $BARCODE . "', " . $NO_CONT . ", " . $SIZE . ", '10', '" . $timestamps . "', 
									" . $REFER_FLAG . ", " . $DG_CODE . ", " . $OD_FLAG . ", " . $START_PLUG . ", " . $SETTING_TEMP . ", 
									" . $TEMP_SATUAN . ", " . $TGL_BONGKAR . ", 'Y')";
                $Execute = $conn->execute($SQL);
                if (!$Execute) {
                    $SQL = "DELETE FROM spjmkont WHERE KDSPJM = '" . $ID_TPFT . "'";
                    $ExecuteDelete = $conn->execute($SQL);
                    $SQL = "DELETE FROM spjm WHERE KDSPJM = '" . $ID_TPFT . "'";
                    $ExecuteDelete = $conn->execute($SQL);
                    $return = '<?xml version="1.0"?><DOCUMENT><SPJM><RESULT>FALSE</RESULT><MESSAGES>Cannot execute query [container].</MESSAGES></SPJM></DOCUMENT>';
                    $SQL = "UPDATE req_xml SET XML_RESPONSE = '" . str_replace("'", "\'", $return) . "' 
								WHERE ID = '" . $ID_REQ_XML . "'";
                    $Execute = $conn->execute($SQL);
                    $conn->disconnect();
                    return $return;
                }

                $SQL = "INSERT INTO spjmkontstatushis (KDSPJM,NOKONT,KDSTATUS,TGSTATUS)
							VALUES (" . $ID_TPFT . "," . $NO_CONT . ",'10','" . $timestamps . "')";
                $Execute = $conn->execute($SQL);
            }

            //DETAIL DOCUMENT				
            if ($CountSPJM == 1) {
                $CountDocument = count($link['SPJM']['_c']['DETIL']['_c']['DOK']);
                $SPJM = $link['SPJM']['_c'];
            } else {
                $CountDocument = count($link['SPJM'][$c]['_c']['DETIL']['_c']['DOK']);
                $SPJM = $link['SPJM'][$c]['_c'];
            }
            for ($d = 0; $d < $CountDocument; $d++) {
                if ($CountDocument == 1) {
                    $detailDocument = $SPJM['DETIL']['_c']['DOK']['_c'];
                } else {
                    $detailDocument = $SPJM['DETIL']['_c']['DOK'][$d]['_c'];
                }

                $CAR_DETAIL_DOCUMENT = $detailDocument['CAR']['_v'] == "" ? "NULL" : "'" . $detailDocument['CAR']['_v'] . "'";
                $JNS_DOK = $detailDocument['JNS_DOK']['_v'] == "" ? "NULL" : "'" . $detailDocument['JNS_DOK']['_v'] . "'";
                $NO_DOK = $detailDocument['NO_DOK']['_v'] == "" ? "NULL" : "'" . $detailDocument['NO_DOK']['_v'] . "'";
                $TGL_DOK = changeFormatDate($detailDocument['TGL_DOK']['_v']) == "" ? "NULL" : "'" . changeFormatDate($detailDocument['TGL_DOK']['_v']) . "'";

                $SQL = "SELECT KODEDOK, KDGA
							FROM kodedokumen 
							WHERE KODEDOK = " . $JNS_DOK . "";
                $Query = $conn->query($SQL);
                $Query->next();
                $KODEDOK = $Query->get(0);
                $KDGA = $Query->get(1) == "" ? "07" : $Query->get(1);

                if ($detailDocument['JNS_DOK']['_v'] == "705") { // NOBL
                    if (($NO_DOK != '') && ($TGL_DOK != '')) {
                        $SQL = "UPDATE spjm SET NOBL = " . $NO_DOK . ", TGBL = " . $TGL_DOK . " WHERE KDSPJM = " . $ID_TPFT . "";
                        $ExecuteUpdateBL = $conn->execute($SQL);
                    }
                } else {
                    $SQL = "SELECT KDSPJM, KDDOK, TIPEDOK FROM spjmdok 
								WHERE KDSPJM = " . $ID_TPFT . " AND KDDOK = " . $JNS_DOK . " AND TIPEDOK = '001'";
                    $QueryCheckSPJM = $conn->query($SQL);
                    if ($QueryCheckSPJM->size() == 0) {
                        $SQL = "INSERT INTO spjmdok (KDSPJM, KDDOK, NODOK, TGDOK, TIPEDOK)
									VALUES (" . $ID_TPFT . ", " . $JNS_DOK . ", " . $NO_DOK . ", " . $TGL_DOK . ", '001')";
                        $ExecuteInsertSPJM = $conn->execute($SQL);
                    }
                }

                switch ($KDGA) {
                    case "02"://KARANTINA IKAN
                        $FIELD_FLAG_KARANTINA = 'FLKI';
                        break;
                    case "03"://KARANTINA HEWAN
                        $FIELD_FLAG_KARANTINA = 'FLKH';
                        break;
                    case "04"://KARANTINA TUMBUHAN	
                        $FIELD_FLAG_KARANTINA = 'FLKT';
                        break;
                    case "07"://BEA CUKAI
                        $FIELD_FLAG_KARANTINA = 'FLBC';
                        break;
                }
                if ($FIELD_FLAG_KARANTINA != '') {
                    $SQL = "UPDATE spjm SET " . $FIELD_FLAG_KARANTINA . " = 'Y' WHERE KDSPJM = " . $ID_TPFT;
                    $ExecuteUpdateFlagInstansi = $conn->execute($SQL);
                }
            }
        }
        if ($Execute) {
            $return = '<?xml version="1.0"?><DOCUMENT><SPJM><RESULT>TRUE</RESULT><MESSAGES>Send SPJM has been successfully.</MESSAGES></SPJM></DOCUMENT>';
        }
        $SQL = "UPDATE req_xml SET XML_RESPONSE = '" . str_replace("'", "\'", $return) . "' 
					WHERE ID = '" . $ID_REQ_XML . "'";
        $Execute2 = $conn->execute($SQL);
        if ($Execute) {
            $CAR = $header['CAR']['_v'];
            $NO_PIB = $header['NO_PIB']['_v'];
            $TGL_PIB = $header['TGL_PIB']['_v'];
            $JmlKontainer = $CountContainer;
            $textSMS = "Anda mendapatkan data SPJM dengan No. PIB : " . $NO_PIB . ", Tgl. PIB : " . $TGL_PIB . ", Jumlah Kontainer : " . $JmlKontainer;
            $textSMSIMPPPJK = "data SPJM sudah masuk ke TPFT dengan No. PIB : " . $NO_PIB . ", Tgl. PIB : " . $TGL_PIB . ", Jumlah Kontainer : " . $JmlKontainer;
            sendSMStoTPFT($KDORG_TPFT, 'MERAH', $textSMS, $ID_TPFT, $textSMSIMPPPJK);
        }
    } else {
        $return = '<?xml version="1.0"?><DOCUMENT><SPJM><RESULT>FALSE</RESULT><MESSAGES>String0 or String1 wrong. Please check your data.</MESSAGES></SPJM></DOCUMENT>';
        $SQL = "UPDATE req_xml SET XML_RESPONSE = '" . str_replace("'", "\'", $return) . "' 
					WHERE ID = '" . $ID_REQ_XML . "'";
        $Execute = $conn->execute($SQL);
    }
    $conn->disconnect();

    return $return;
}

function CheckContainerKarantina($String0, $String1, $String2, $String3, $String4) {
    global $conn, $CONF, $connSMS;
    $vUsername = array("WSMTI", "WSMAL", "WSPLDC");
    $vPassword = array("pass123abc", "password", "Bismill4h", "20140606");
    $username = $String0;
    $password = $String1;
    $ContNo = $String2;
    $SppbNo = $String3;
    $SppbDate = $String4;

    if ((in_array($username, $vUsername)) && (in_array($password, $vPassword))) {
        /* $SQL = "SELECT DISTINCT C.ID_GA, D.URAIAN AS GA_DESC
          FROM tbl_tpft A INNER JOIN tbl_tpft_cont B ON A.ID_TPFT = B.ID_TPFT
          INNER JOIN tbl_tpft_cont_dok C ON C.ID_CONT = B.ID_CONT
          INNER JOIN tbl_ref D ON C.ID_GA = D.KODE AND D.JENIS = 'INSTANSI'
          WHERE 1=1
          AND A.NO_SPPB = '".$SppbNo."'
          AND DATE_FORMAT(A.TG_SPPB,'%Y%m%d') = '".$SppbDate."'
          AND B.CONT_NO = '".$ContNo."'
          AND (B.FL_KT = 'Y' OR B.FL_KH = 'Y' OR B.FL_KI = 'Y')
          AND B.FL_BC = 'N'";
          $conn->connect();
          $Query = $conn->query($SQL);
          if($Query->size()>0){
          $Query->next();
          $ID_GA = $Query->get(0);
          $GA_DESC = $Query->get(1);
          $returnQuery = "TRUE";
          $addReturn = "<MSG>DOKUMEN WAJIB ".$GA_DESC."</MSG>";
          }
          else{
          $returnQuery = "FALSE";
          $addReturn = "<MSG>DOKUMEN BUKAN WAJIB KARANTINA</MSG>";
          }
          $conn->disconnect(); */
        $returnQuery = "TRUE";
        $addReturn = "<MSG>DOKUMEN WAJIB " . $GA_DESC . "</MSG>";
        $return = '<?xml version="1.0"?>
					   <TPFT>
							<RESULT>' . $returnQuery . '</RESULT>
							<MESSAGES>' . $addReturn . '</MESSAGES>
					   </TPFT>';
    } else {
        $return = '<?xml version="1.0"?>
					   <TPFT>
							<RESULT>FALSE</RESULT>
							<MESSAGES>String0 or String1 wrong. Please check your data.</MESSAGES>
					   </TPFT>';
    }
    return $return;
}

function getCodeco($String0, $String1, $String2) {
    global $conn, $CONF, $connSMS;
    $vUsername = 'TPFT';
    $vPassword = '19911402';
    $vUsernameMal = 'WSMAL';
    $vPasswordMal = '19912407';
    $username = $String0;
    $password = $String1;
    $KodeTPS = $String2;
    if ((($username == $vUsername) && ($password == $vPassword)) || (($username == $vUsernameMal) && ($password == $vPasswordMal))) {
        $SQL = "SELECT A.KD_DOK, A.KD_TPS, A.NM_ANGKUT, A.NO_VOY_FLIGHT, A.CALL_SIGN, 
						   DATE_FORMAT(A.TGL_TIBA,'%Y%m%d') AS TGL_TIBA, A.KD_GUDANG, A.REF_NUMBER, A.ID_COCOCONT
					FROM tbl_cococont_hdr A
					WHERE A.KD_GUDANG = '" . $KodeTPS . "' AND A.FL_SEND = '0'
					LIMIT 0,10"; //return $SQL;
        $conn->connect();
        $Query = $conn->query($SQL);
        if ($Query->size() > 0) {
            $return = '<?xml version="1.0"?>
						   <DOCUMENT xmlns="cococont.xsd">';
            while ($Query->next()) {
                $KD_DOK = $Query->get(0);
                $KD_TPS = $Query->get(1);
                $NM_ANGKUT = $Query->get(2);
                $NO_VOY_FLIGHT = $Query->get(3);
                $CALL_SIGN = $Query->get(4);
                $TGL_TIBA = $Query->get(5);
                $KD_GUDANG = $Query->get(6);
                $REF_NUMBER = $Query->get(7);
                $ID_COCOCONT = $Query->get(8);
                $arrayIDCOCOCONT[] = $ID_COCOCONT;
                $return .= '<COCOCONT>	
									<HEADER>
										<KD_DOK>' . $KD_DOK . '</KD_DOK>
										<KD_TPS>' . $KD_TPS . '</KD_TPS>
										<NM_ANGKUT>' . $NM_ANGKUT . '</NM_ANGKUT>
										<NO_VOY_FLIGHT>' . $NO_VOY_FLIGHT . '</NO_VOY_FLIGHT>
										<CALL_SIGN>' . $CALL_SIGN . '</CALL_SIGN>
										<TGL_TIBA>' . $TGL_TIBA . '</TGL_TIBA>
										<KD_GUDANG>' . $KD_GUDANG . '</KD_GUDANG>
										<REF_NUMBER>' . $REF_NUMBER . '</REF_NUMBER>
									</HEADER>';

                $SQL = "SELECT B.NO_CONT, B.UK_CONT, B.NO_SEGEL, B.JNS_CONT, B.NO_BL_AWB, 
								   DATE_FORMAT(B.TGL_BL_AWB,'%Y%m%d') AS TGL_BL_AWB, B.NO_MASTER_BL_AWB, 
								   DATE_FORMAT(B.TGL_MASTER_BL_AWB,'%Y%m%d') AS TGL_MASTER_BL_AWB, B.ID_CONSIGNEE, 
								   B.CONSIGNEE, B.BRUTO, B.NO_BC11, DATE_FORMAT(B.TGL_BC11,'%Y%m%d') AS TGL_BC11, 
								   B.NO_POS_BC11, B.KD_TIMBUN, B.KD_DOK_INOUT, 
								   B.NO_DOK_INOUT, DATE_FORMAT(B.TGL_DOK_INOUT,'%Y%m%d') AS TGL_DOK_INOUT, 
								   DATE_FORMAT(B.WK_INOUT,'%Y%m%d%H%i%s') AS WK_INOUT, B.KD_SAR_ANGKUT_INOUT, B.NO_POL, 
								   B.FL_CONT_KOSONG, B.ISO_CODE, B.PEL_MUAT, B.PEL_TRANSIT, B.PEL_BONGKAR, B.GUDANG_TUJUAN, 
								   B.KODE_KANTOR, B.NO_DAFTAR_PABEAN, DATE_FORMAT(B.TGL_DAFTAR_PABEAN,'%Y%m%d') AS TGL_DAFTAR_PABEAN, 
								   B.NO_SEGEL_BC, DATE_FORMAT(B.TGL_SEGEL_BC,'%Y%m%d') AS TGL_SEGEL_BC, B.NO_IJIN_TPS, 
								   DATE_FORMAT(B.TGL_IJIN_TPS,'%Y%m%d') AS TGL_IJIN_TPS
							FROM tbl_cococont_dtl B 
							WHERE B.ID_COCOCONT_HDR = '" . $ID_COCOCONT . "'";
                $Query2 = $conn->query($SQL);
                if ($Query2->size() > 0) {
                    $return .= '<DETIL>';
                    while ($Query2->next()) {
                        $NO_CONT = $Query2->get(0);
                        $UK_CONT = $Query2->get(1);
                        $NO_SEGEL = $Query2->get(2);
                        $JNS_CONT = $Query2->get(3);
                        $NO_BL_AWB = $Query2->get(4);
                        $TGL_BL_AWB = $Query2->get(5);
                        $NO_MASTER_BL_AWB = $Query2->get(6);
                        $TGL_MASTER_BL_AWB = $Query2->get(7);
                        $ID_CONSIGNEE = $Query2->get(8);
                        $CONSIGNEE = $Query2->get(9);
                        $BRUTO = $Query2->get(10);
                        $NO_BC11 = $Query2->get(11);
                        $TGL_BC11 = $Query2->get(12);
                        $NO_POS_BC11 = $Query2->get(13);
                        $KD_TIMBUN = $Query2->get(14);
                        $KD_DOK_INOUT = $Query2->get(15);
                        $NO_DOK_INOUT = $Query2->get(16);
                        $TGL_DOK_INOUT = $Query2->get(17);
                        $WK_INOUT = $Query2->get(18);
                        $KD_SAR_ANGKUT_INOUT = $Query2->get(19);
                        $NO_POL = $Query2->get(20);
                        $FL_CONT_KOSONG = $Query2->get(21);
                        $ISO_CODE = $Query2->get(22);
                        $PEL_MUAT = $Query2->get(23);
                        $PEL_TRANSIT = $Query2->get(24);
                        $PEL_BONGKAR = $Query2->get(25);
                        $GUDANG_TUJUAN = $Query2->get(26);
                        $KODE_KANTOR = $Query2->get(27);
                        $NO_DAFTAR_PABEAN = $Query2->get(28);
                        $TGL_DAFTAR_PABEAN = $Query2->get(29);
                        $NO_SEGEL_BC = $Query2->get(30);
                        $TGL_SEGEL_BC = $Query2->get(31);
                        $NO_IJIN_TPS = $Query2->get(32);
                        $TGL_IJIN_TPS = $Query2->get(33);
                        $return .= '<CONT>
											<NO_CONT>' . $NO_CONT . '</NO_CONT>
											<UK_CONT>' . $UK_CONT . '</UK_CONT>
											<NO_SEGEL>' . $NO_SEGEL . '</NO_SEGEL>
											<JNS_CONT>' . $JNS_CONT . '</JNS_CONT>
											<NO_BL_AWB>' . $NO_BL_AWB . '</NO_BL_AWB>
											<TGL_BL_AWB>' . $TGL_BL_AWB . '</TGL_BL_AWB>
											<NO_MASTER_BL_AWB>' . $NO_MASTER_BL_AWB . '</NO_MASTER_BL_AWB>
											<TGL_MASTER_BL_AWB>' . $TGL_MASTER_BL_AWB . '</TGL_MASTER_BL_AWB>
											<ID_CONSIGNEE>' . $ID_CONSIGNEE . '</ID_CONSIGNEE>
											<CONSIGNEE>' . $CONSIGNEE . '</CONSIGNEE>
											<BRUTO>' . $BRUTO . '</BRUTO>
											<NO_BC11>' . $NO_BC11 . '</NO_BC11>
											<TGL_BC11>' . $TGL_BC11 . '</TGL_BC11>
											<NO_POS_BC11>' . $NO_POS_BC11 . '</NO_POS_BC11>
											<KD_TIMBUN>' . $KD_TIMBUN . '</KD_TIMBUN>
											<KD_DOK_INOUT>' . $KD_DOK_INOUT . '</KD_DOK_INOUT>
											<NO_DOK_INOUT>' . $NO_DOK_INOUT . '</NO_DOK_INOUT>
											<TGL_DOK_INOUT>' . $TGL_DOK_INOUT . '</TGL_DOK_INOUT>
											<WK_INOUT>' . $WK_INOUT . '</WK_INOUT>
											<KD_SAR_ANGKUT_INOUT>' . $KD_SAR_ANGKUT_INOUT . '</KD_SAR_ANGKUT_INOUT>
											<NO_POL>' . $NO_POL . '</NO_POL>
											<FL_CONT_KOSONG>' . $FL_CONT_KOSONG . '</FL_CONT_KOSONG>
											<ISO_CODE>' . $ISO_CODE . '</ISO_CODE>
											<PEL_MUAT>' . $PEL_MUAT . '</PEL_MUAT>
											<PEL_TRANSIT>' . $PEL_TRANSIT . '</PEL_TRANSIT>
											<PEL_BONGKAR>' . $PEL_BONGKAR . '</PEL_BONGKAR>
											<GUDANG_TUJUAN>' . $GUDANG_TUJUAN . '</GUDANG_TUJUAN>
										</CONT>';
                    }
                    $return .= '</DETIL>';
                }
                $return .= '</COCOCONT>';
            }
            $return .= '</DOCUMENT>';

            //UPDATE SENT	
            $SQL = "UPDATE tbl_cococont_hdr SET FL_SEND = '1' WHERE ID_COCOCONT IN ('" . implode("','", $arrayIDCOCOCONT) . "')";
            //return $SQL;
            $Execute = $conn->execute($SQL);
        } else {
            $return = '<?xml version="1.0"?>
						   <DOCUMENT xmlns="cococont.xsd">
								<COCOCONT>	
									<RESULT>FALSE</RESULT>
									<MESSAGES>No record found.</MESSAGES>
								</COCOCONT>	
						   </DOCUMENT>';
        }
        $conn->disconnect();
    } else {
        $return = '<?xml version="1.0"?>
					   <DOCUMENT xmlns="cococont.xsd">
							<COCOCONT>	
								<RESULT>FALSE</RESULT>
								<MESSAGES>String0 or String1 wrong. Please check your data.</MESSAGES>
							</COCOCONT>	
					   </DOCUMENT>';
    }
    return $return;
}

function sendCodeco($String0, $String1, $String2, $String3) {
    global $conn, $CONF, $connSMS;
    $vUsername = 'TPFT';
    $vPassword = '19911402';
    $vUsernameMal = 'WSMAL';
    $vPasswordMal = '19912407';
    $username = $String0;
    $password = $String1;
    $KodeTPS = $String2;
    $xml = $String3;
    if ((($username == $vUsername) && ($password == $vPassword)) || (($username == $vUsernameMal) && ($password == $vPasswordMal))) {
        $conn->connect();
        $xml = xml2ary($xml);
        $link = & $xml['DOCUMENT']['_c'];
        $COCOCONT = $link['COCOCONT'];
        $countCOCOCONT = count($COCOCONT);
        for ($c = 0; $c < $countCOCOCONT; $c++) {
            if ($countCOCOCONT == 1) {
                $COCOCONT = $link['COCOCONT']['_c'];
            } else {
                $COCOCONT = $link['COCOCONT'][$c]['_c'];
            }

            //HEADER 
            $HEADER = $COCOCONT['HEADER']['_c'];
            $KD_DOK = $HEADER['KD_DOK']['_v'];
            $KD_TPS = $HEADER['KD_TPS']['_v'];
            $NM_ANGKUT = $HEADER['NM_ANGKUT']['_v'];
            $NO_VOY_FLIGHT = $HEADER['NO_VOY_FLIGHT']['_v'];
            $CALL_SIGN = $HEADER['CALL_SIGN']['_v'];
            $TGL_TIBA = changeFormatDate2($HEADER['TGL_TIBA']['_v']);
            $KD_GUDANG = $HEADER['KD_GUDANG']['_v'];
            $REF_NUMBER = $HEADER['REF_NUMBER']['_v'];

            $SQL = "INSERT INTO tbl_cococont_hdr (KD_DOK, KD_TPS, NM_ANGKUT, NO_VOY_FLIGHT, CALL_SIGN, TGL_TIBA, 
													  KD_GUDANG, REF_NUMBER)
						VALUES ('" . $KD_DOK . "','" . $KD_TPS . "','" . $NM_ANGKUT . "','" . $NO_VOY_FLIGHT . "','" . $CALL_SIGN . "','" . $TGL_TIBA . "',
								'" . $KD_GUDANG . "','" . $REF_NUMBER . "')"; //echo $SQL."<br><br>";
            $Execute = $conn->execute($SQL);
            if (!$Execute) {
                $conn->disconnect();
                $return = '<?xml version="1.0"?>
							   <DOCUMENT xmlns="cococont.xsd">
									<COCOCONT>	
										<RESULT>FALSE</RESULT>
										<MESSAGES>Cannot execute query [header].</MESSAGES>
									</COCOCONT>	
							   </DOCUMENT>';
                return $return;
            }
            $ID_COCOCONT_HDR = mysql_insert_id();

            //DETIL
            $DETIL = $COCOCONT['DETIL']['_c']; //echo '<pre>';print_r($DETIL);echo '</pre>';
            $CONT = $DETIL['CONT'];
            $countCONT = count($CONT);
            for ($d = 0; $d < $countCONT; $d++) {
                if ($countCONT == 1) {
                    $CONT = $DETIL['CONT']['_c'];
                } else {
                    $CONT = $DETIL['CONT'][$c]['_c'];
                }
                $NO_CONT = $CONT['NO_CONT']['_v'];
                $UK_CONT = $CONT['UK_CONT']['_v'];
                $NO_SEGEL = $CONT['NO_SEGEL']['_v'];
                $JNS_CONT = $CONT['JNS_CONT']['_v'];
                $NO_BL_AWB = $CONT['NO_BL_AWB']['_v'];
                $TGL_BL_AWB = changeFormatDate2($CONT['TGL_BL_AWB']['_v']);
                $NO_MASTER_BL_AWB = $CONT['NO_MASTER_BL_AWB']['_v'];
                $TGL_MASTER_BL_AWB = changeFormatDate2($CONT['TGL_MASTER_BL_AWB']['_v']);
                $ID_CONSIGNEE = $CONT['ID_CONSIGNEE']['_v'];
                $CONSIGNEE = $CONT['CONSIGNEE']['_v'];
                $BRUTO = $CONT['BRUTO']['_v'];
                $NO_BC11 = $CONT['NO_BC11']['_v'];
                $TGL_BC11 = changeFormatDate2($CONT['TGL_BC11']['_v']);
                $NO_POS_BC11 = $CONT['NO_POS_BC11']['_v'];
                $KD_TIMBUN = $CONT['KD_TIMBUN']['_v'];
                $KD_DOK_INOUT = $CONT['KD_DOK_INOUT']['_v'];
                $NO_DOK_INOUT = $CONT['NO_DOK_INOUT']['_v'];
                $TGL_DOK_INOUT = changeFormatDate2($CONT['TGL_DOK_INOUT']['_v']);
                $WK_INOUT = changeFormatDateTime($CONT['WK_INOUT']['_v']);
                $KD_SAR_ANGKUT_INOUT = $CONT['KD_SAR_ANGKUT_INOUT']['_v'];
                $NO_POL = $CONT['NO_POL']['_v'];
                $FL_CONT_KOSONG = $CONT['FL_CONT_KOSONG']['_v'];
                $ISO_CODE = $CONT['ISO_CODE']['_v'];
                $PEL_MUAT = $CONT['PEL_MUAT']['_v'];
                $PEL_TRANSIT = $CONT['PEL_TRANSIT']['_v'];
                $PEL_BONGKAR = $CONT['PEL_BONGKAR']['_v'];
                $GUDANG_TUJUAN = $CONT['GUDANG_TUJUAN']['_v'];
                $KODE_KANTOR = $CONT['KODE_KANTOR']['_v'];
                $NO_DAFTAR_PABEAN = $CONT['NO_DAFTAR_PABEAN']['_v'];
                $TGL_DAFTAR_PABEAN = changeFormatDate2($CONT['TGL_DAFTAR_PABEAN']['_v']);
                $NO_SEGEL_BC = $CONT['NO_SEGEL_BC']['_v'];
                $TGL_SEGEL_BC = changeFormatDate2($CONT['TGL_SEGEL_BC']['_v']);
                $NO_IJIN_TPS = $CONT['NO_IJIN_TPS']['_v'];
                $TGL_IJIN_TPS = changeFormatDate2($CONT['TGL_IJIN_TPS']['_v']);

                $SQL = "INSERT INTO tbl_cococont_dtl (ID_COCOCONT_HDR, NO_CONT, UK_CONT, NO_SEGEL, JNS_CONT, NO_BL_AWB, 
										   TGL_BL_AWB, NO_MASTER_BL_AWB, TGL_MASTER_BL_AWB, ID_CONSIGNEE, 
										   CONSIGNEE, BRUTO, NO_BC11, TGL_BC11, NO_POS_BC11, KD_TIMBUN, KD_DOK_INOUT, 
										   NO_DOK_INOUT, TGL_DOK_INOUT, WK_INOUT, KD_SAR_ANGKUT_INOUT, NO_POL, 
										   FL_CONT_KOSONG, ISO_CODE, PEL_MUAT, PEL_TRANSIT, PEL_BONGKAR, GUDANG_TUJUAN, 
										   KODE_KANTOR, NO_DAFTAR_PABEAN, TGL_DAFTAR_PABEAN, NO_SEGEL_BC, 
										   TGL_SEGEL_BC, NO_IJIN_TPS, TGL_IJIN_TPS)
							VALUES ('" . $ID_COCOCONT_HDR . "','" . $NO_CONT . "','" . $UK_CONT . "','" . $NO_SEGEL . "','" . $JNS_CONT . "',
									'" . $NO_BL_AWB . "','" . $TGL_BL_AWB . "','" . $NO_MASTER_BL_AWB . "','" . $TGL_MASTER_BL_AWB . "',
									'" . $ID_CONSIGNEE . "','" . $CONSIGNEE . "','" . $BRUTO . "','" . $NO_BC11 . "','" . $TGL_BC11 . "',
									'" . $NO_POS_BC11 . "','" . $KD_TIMBUN . "','" . $KD_DOK_INOUT . "','" . $NO_DOK_INOUT . "','" . $TGL_DOK_INOUT . "',
									'" . $WK_INOUT . "','" . $KD_SAR_ANGKUT_INOUT . "','" . $NO_POL . "','" . $FL_CONT_KOSONG . "','" . $ISO_CODE . "',
									'" . $PEL_MUAT . "','" . $PEL_TRANSIT . "','" . $PEL_BONGKAR . "','" . $GUDANG_TUJUAN . "', 
								    '" . $KODE_KANTOR . "','" . $NO_DAFTAR_PABEAN . "','" . $TGL_DAFTAR_PABEAN . "','" . $NO_SEGEL_BC . "', 
								    '" . $TGL_SEGEL_BC . "','" . $NO_IJIN_TPS . "','" . $TGL_IJIN_TPS . "')"; //echo $SQL."<br><br>";		
                $Execute = $conn->execute($SQL);
                if (!$Execute) {
                    $SQL = "DELETE FROM tbl_cococont_dtl WHERE ID_COCOCONT_HDR = '" . $ID_COCOCONT_HDR . "'";
                    $ExecuteDelete = $conn->execute($SQL);
                    $SQL = "DELETE FROM tbl_cococont_hdr WHERE ID_COCOCONT = '" . $ID_COCOCONT_HDR . "'";
                    $ExecuteDelete = $conn->execute($SQL);
                    $conn->disconnect();
                    $return = '<?xml version="1.0"?>
								   <DOCUMENT xmlns="cococont.xsd">
										<COCOCONT>	
											<RESULT>FALSE</RESULT>
											<MESSAGES>Cannot execute query [container].</MESSAGES>
										</COCOCONT>	
								   </DOCUMENT>';
                    return $return;
                }
            }
        }
        if ($Execute) {
            $return = '<?xml version="1.0"?>
					   <DOCUMENT xmlns="cococont.xsd">
							<COCOCONT>	
								<RESULT>FALSE</RESULT>
								<MESSAGES>Send Codeco has been successfully.</MESSAGES>
							</COCOCONT>	
					   </DOCUMENT>';
        }
        $conn->disconnect();
    } else {
        $return = '<?xml version="1.0"?>
					   <DOCUMENT xmlns="cococont.xsd">
							<COCOCONT>	
								<RESULT>FALSE</RESULT>
								<MESSAGES>String0 or String1 wrong. Please check your data.</MESSAGES>
							</COCOCONT>	
					   </DOCUMENT>';
    }
    return $return;
}

function getPostClearanceKarantina($String0, $String1, $String2) {
    global $conn, $CONF, $connSMS;
    $vUsername = array("TPFT", "WSMAL", "WSJICT");
    $vPassword = array("19911402", "19912407", "19912405");
    $username = $String0;
    $password = $String1;
    $KodeTPS = $String2;
    if ((in_array($username, $vUsername)) && (in_array($password, $vPassword))) {
        $SQL = "SELECT B.IMPNPWP, B.IMPNAMA, B.NOPIB, DATE_FORMAT(B.TGPIB,'%Y%m%d') AS TGPIB, B.NOBL, 
						   DATE_FORMAT(B.TGBL,'%Y%m%d') AS TGBL, A.KDDOK, A.NODOK, 
						   DATE_FORMAT(A.TGDOK,'%Y%m%d') AS TGDOK, D.DESKRIPSI, D.KDGA, A.KDSPJM
					FROM spjmdok A INNER JOIN spjm B ON A.KDSPJM = B.KDSPJM
										INNER JOIN kodedokumen D ON A.KDDOK = D.KODEDOK
					WHERE A.TIPEDOK = 'PENYELESAIAN'
							AND B.FLBC = 'N'
							AND B.KDGUDANG = '" . $KodeTPS . "'
							AND A.KDDOK <> '300'
							AND A.FL_SEND = '0'";
        $conn->connect();
        $Query = $conn->query($SQL);
        if ($Query->size() > 0) {
            $return = '<?xml version="1.0"?>';
            while ($Query->next()) {
                $IMPNPWP = $Query->get(0);
                $IMPNAMA = $Query->get(1);
                $NOPIB = $Query->get(2);
                $TGPIB = $Query->get(3);
                $NOBL = $Query->get(4);
                $TGBL = $Query->get(5);
                $KDDOK = $Query->get(6);
                $NODOK = $Query->get(7);
                $TGDOK = $Query->get(8);
                $DESKRIPSI = $Query->get(9);
                $KDGA = $Query->get(10);
                $KDSPJM = $Query->get(11);

                $addReturn = '';
                $SQL = "SELECT A.NOKONT, A.BARCODE, A.UKURAN, DATE_FORMAT(A.TGSPPUD,'%Y%m%d%H%i%s') AS TGSPPUD
							FROM spjmkont A
							WHERE A.KDSPJM = '" . $KDSPJM . "'";
                $QueryContainer = $conn->query($SQL);
                if ($QueryContainer->size() > 0) {
                    $addReturn = '<CONTAINERS>';
                    while ($QueryContainer->next()) {
                        $NOKONT = $QueryContainer->get(0);
                        $BARCODE = $QueryContainer->get(1);
                        $UKURAN = $QueryContainer->get(2);
                        $TGSPPUD = $QueryContainer->get(3);
                        $addReturn .= '<CONTAINER>
												<CONT_NO>' . $NOKONT . '</CONT_NO>
												<CONT_SIZE>' . $UKURAN . '</CONT_SIZE>
												<CONT_TYPE></CONT_TYPE>
												<CONT_LOAD></CONT_LOAD> 
												<CONT_WEIGHT></CONT_WEIGHT>
												<SP3UDK_DATE>' . $TGSPPUD . '</SP3UDK_DATE>
											</CONTAINER>';
                    }
                    $addReturn .= '</CONTAINERS>';
                }

                $return .= '<POST_CLEARANCE>
									<NPWP_CONSIGNEE>' . $IMPNPWP . '</NPWP_CONSIGNEE>
									<CONSIGNEE>' . $IMPNAMA . '</CONSIGNEE>
									<BL_NO>' . $NOBL . '</BL_NO>
									<BL_DATE>' . $TGBL . '</BL_DATE> 
									<PIB_NO>' . $NOPIB . '</PIB_NO>
									<PIB_DATE>' . $TGPIB . '</PIB_DATE>
									<KDGA>' . $KDGA . '</KDGA>
									<DESKRIPSI>' . $DESKRIPSI . '</DESKRIPSI>
									<KDDOK>' . $KDDOK . '</KDDOK>
									<NODOK>' . $NODOK . '</NODOK> 
									<TGDOK>' . $TGDOK . '</TGDOK> 
									' . $addReturn . '
								</POST_CLEARANCE>';
                $SQL = "UPDATE spjmdok SET FL_SEND = '1' 
							WHERE FL_SEND = '0' AND KDSPJM = '" . $KDSPJM . "'";
                $Execute = $conn->execute($SQL);
            }
        } else {
            $return = '<?xml version="1.0"?>
						   <DOCUMENT>	
								<POST_CLEARANCE>		
									<RESULT>FALSE</RESULT>
									<MESSAGES>No record found.</MESSAGES>
								</POST_CLEARANCE>	
						   </DOCUMENT>';
        }
        $conn->disconnect();
    } else {
        $return = '<?xml version="1.0"?>
					   <DOCUMENT>	
							<POST_CLEARANCE>		
								<RESULT>FALSE</RESULT>
								<MESSAGES>String0 or String1 wrong. Please check your data.</MESSAGES>
							</POST_CLEARANCE>	
					   </DOCUMENT>';
    }

    return $return;
}

function getSP3UDK($String0, $String1, $String2) {
    global $conn, $CONF, $connSMS;
    $vUsername = array("TPFT", "WSMAL", "WSJICT");
    $vPassword = array("19911402", "19912407", "19912405");
    $username = $String0;
    $password = $String1;
    $KodeTPS = strtoupper($String2);
    if ((in_array($username, $vUsername)) && (in_array($password, $vPassword))) {
        /* $SQL = "SELECT A.ID, A.PIB_NO, DATE_FORMAT(A.PIB_DATE,'%Y%m%d') AS PIB_DATE, A.SPPB_NO, 
          DATE_FORMAT(A.SPPB_DATE,'%Y%m%d') AS SPPB_DATE, A.BL_NO, DATE_FORMAT(A.BL_DATE,'%Y%m%d') AS BL_DATE,
          A.VESSEL, A.VOY, DATE_FORMAT(A.ARRIVE,'%Y%m%d') AS ARRIVE,
          A.NPWP_CONSIGNEE, A.CONSIGNEE, A.KD_GUDANG_ASAL, A.KD_GUDANG_TPFT, A.FL_CETAK, A.CAR
          FROM kirimsp3udk A
          WHERE A.FL_KIRIM = '0'
          AND UPPER(A.KD_GUDANG_ASAL) = '".$KodeTPS."'
          AND A.FL_CETAK = 'Y'
          ORDER BY A.DATE_CREATED ASC
          LIMIT 0,10"; */
        $SQL = "SELECT A.ID, A.PIB_NO, DATE_FORMAT(A.PIB_DATE,'%Y%m%d') AS PIB_DATE, A.SPPB_NO, 
						   DATE_FORMAT(A.SPPB_DATE,'%Y%m%d') AS SPPB_DATE, A.BL_NO, DATE_FORMAT(A.BL_DATE,'%Y%m%d') AS BL_DATE, 
						   A.VESSEL, A.VOY, DATE_FORMAT(A.ARRIVE,'%Y%m%d') AS ARRIVE, 
						   A.NPWP_CONSIGNEE, A.CONSIGNEE, A.KD_GUDANG_ASAL, A.KD_GUDANG_TPFT, A.FL_CETAK, A.CAR
					FROM kirimsp3udk A INNER JOIN spjm B ON A.CAR = B.CAR 
									   INNER JOIN spjmdok C ON B.KDSPJM = C.KDSPJM
									   INNER JOIN kodedokumen D ON D.KODEDOK = C.KDDOK AND D.KDGA IN ('04')
					WHERE A.FL_KIRIM = '0' 
						  AND UPPER(A.KD_GUDANG_ASAL) = '" . $KodeTPS . "'
						  AND A.FL_CETAK = 'Y'
						  AND DATE(C.TGDOK) >= DATE('2014-06-09')
					ORDER BY A.DATE_CREATED ASC
					LIMIT 0,10";
        $conn->connect();
        $Query = $conn->query($SQL);
        if ($Query->size() > 0) {
            $return = '<?xml version="1.0"?>
						   <DOCUMENT>';
            while ($Query->next()) {
                $ID = $Query->get(0);
                $PIB_NO = $Query->get(1);
                $PIB_DATE = $Query->get(2);
                $SPPB_NO = $Query->get(3);
                $SPPB_DATE = $Query->get(4);
                $BL_NO = $Query->get(5);
                $BL_DATE = $Query->get(6);
                $VESSEL = $Query->get(7);
                $VOY = $Query->get(8);
                $ARRIVE = $Query->get(9);
                $NPWP_CONSIGNEE = $Query->get(10);
                $CONSIGNEE = str_replace('&', '&amp;', $Query->get(11));
                $KD_GUDANG_ASAL = $Query->get(12);
                $KD_GUDANG_TPFT = $Query->get(13);
                $FL_CETAK = $Query->get(14);
                $CAR = $Query->get(15);

                $return .= '<SP3UDK>
									<CAR>' . $CAR . '</CAR>
									<PIB_NO>' . $PIB_NO . '</PIB_NO>
									<PIB_DATE>' . $PIB_DATE . '</PIB_DATE> 
									<SPPB_NO>' . $SPPB_NO . '</SPPB_NO>
									<SPPB_DATE>' . $SPPB_DATE . '</SPPB_DATE>
									<BL_NO>' . $BL_NO . '</BL_NO>
									<BL_DATE>' . $BL_DATE . '</BL_DATE>
									<VESSEL>' . $VESSEL . '</VESSEL>
									<VOY>' . $VOY . '</VOY>
									<ARRIVE>' . $ARRIVE . '</ARRIVE> 
									<NPWP_CONSIGNEE>' . $NPWP_CONSIGNEE . '</NPWP_CONSIGNEE>
									<CONSIGNEE>' . $CONSIGNEE . '</CONSIGNEE>
									<KD_GUDANG_ASAL>' . $KD_GUDANG_ASAL . '</KD_GUDANG_ASAL>
									<KD_GUDANG_TPFT>' . $KD_GUDANG_TPFT . '</KD_GUDANG_TPFT>
									<FL_CETAK>' . $FL_CETAK . '</FL_CETAK> 
								</SP3UDK>';
                $SQL = "UPDATE kirimsp3udk SET FL_KIRIM = '1', DATE_KIRIM = now() 
							WHERE ID = '" . $ID . "'";
                $Execute = $conn->execute($SQL);
            }
            $return .= '</DOCUMENT>';
        } else {
            $return = '<?xml version="1.0"?>
						   <DOCUMENT>	
								<SP3UDK>		
									<RESULT>FALSE</RESULT>
									<MESSAGES>No record found.</MESSAGES>
								</SP3UDK>	
						   </DOCUMENT>';
        }
        $conn->disconnect();
    } else {
        $return = '<?xml version="1.0"?>
					   <DOCUMENT>	
							<SP3UDK>		
								<RESULT>FALSE</RESULT>
								<MESSAGES>String0 or String1 wrong. Please check your data.</MESSAGES>
							</SP3UDK>	
					   </DOCUMENT>';
    }

    return $return;
}

function getSP3UDK2($String0, $String1, $String2) {
    global $conn, $CONF, $connSMS;
    $vUsername = array("TPFT", "WSMAL", "WSJICT");
    $vPassword = array("19911402", "19912407", "19912405");
    $username = $String0;
    $password = $String1;
    $KodeTPS = $String2;
    if ((in_array($username, $vUsername)) && (in_array($password, $vPassword))) {
        $SQL = "SELECT A.BARCODE, A.NOKONT, A.UKURAN, '' AS CONT_STATUS, '' AS CONT_TYPE, '' AS CONT_WEIGHT,
						   B.VESSEL, B.VOY, B.KDGUDANG, C.DESKRIPSI, B.IMPNAMA, H.ORGNAMA, B.NOBL, 
						   DATE_FORMAT(B.TGBL,'%Y%m%d') AS TGBL, B.NOPIB, DATE_FORMAT(B.TGPIB,'%Y%m%d') AS TGPIB,
						   DATE_FORMAT(A.TGBONGKAR,'%Y%m%d') AS TGBONGKAR, DATE_FORMAT(B.TGTIBA,'%Y%m%d') AS TGTIBA,
						   B.IMPNPWP, I.NODOK AS NOSPPB, DATE_FORMAT(I.TGDOK,'%Y%m%d') AS TGSPPB, A.KDSPJM		 
					FROM spjmkont A INNER JOIN spjm B ON A.KDSPJM = B.KDSPJM
									LEFT JOIN gudang C ON B.KDGUDANG = C.KDGUDANG
									INNER JOIN statuskontainer D ON A.KDSTATUS = D.KDSTATUS
									LEFT JOIN pelln E ON B.PELMUAT = E.KDPEL
									LEFT JOIN peldn F ON B.PELBKR = F.KDPEL
									LEFT JOIN kpbc G ON B.KDKPBC = G.KDKPBC
									LEFT JOIN organisasi H ON B.KDORG_TPFT = H.KDORG
									LEFT JOIN spjmdok I ON B.KDSPJM = I.KDSPJM AND I.KDDOK = '300'
					WHERE A.TGSPPUD IS NOT NULL
						  AND B.FLBC = 'N'
						  AND A.FL_SEND = '0'
						  AND B.KDGUDANG = '" . $KodeTPS . "'";
        $conn->connect();
        $Query = $conn->query($SQL);
        if ($Query->size() > 0) {
            $return = '<?xml version="1.0"?>';
            while ($Query->next()) {
                $BARCODE = $Query->get(0);
                $NOKONT = $Query->get(1);
                $UKURAN = $Query->get(2);
                $CONT_STATUS = $Query->get(3);
                $CONT_TYPE = $Query->get(4);
                $CONT_WEIGHT = $Query->get(5);
                $VESSEL = $Query->get(6);
                $VOY = $Query->get(7);
                $KDGUDANG = $Query->get(8);
                $DESKRIPSI = $Query->get(9);
                $IMPNAMA = $Query->get(10);
                $ORGNAMA = $Query->get(11);
                $NOBL = $Query->get(12);
                $TGBL = $Query->get(13);
                $NOPIB = $Query->get(14);
                $TGPIB = $Query->get(15);
                $TGBONGKAR = $Query->get(16);
                $TGTIBA = $Query->get(17);
                $IMPNPWP = $Query->get(18);
                $NOSPPB = $Query->get(19);
                $TGSPPB = $Query->get(20);
                $KDSPJM = $Query->get(21);

                $return .= '<SP3UDK>
									<BARCODE>' . $BARCODE . '</BARCODE>
									<CONT_NO>' . $NOKONT . '</CONT_NO>
									<CONT_SIZE>' . $UKURAN . '</CONT_SIZE>
									<CONT_TYPE></CONT_TYPE>
									<CONT_LOAD>' . $CONT_LOAD . '</CONT_LOAD> 
									<CONT_WEIGHT>' . $CONT_WEIGHT . '</CONT_WEIGHT>
									<VESSEL>' . $VESSEL . '</VESSEL>
									<VOY>' . $VOY . '</VOY>
									<ARRIVE>' . $TGTIBA . '</ARRIVE> 
									<KD_GUDANG_ASAL>' . $KDGUDANG . '</KD_GUDANG_ASAL>
									<SHIPPING_AGENT></SHIPPING_AGENT>
									<NPWP_CONSIGNEE>' . $IMPNPWP . '</NPWP_CONSIGNEE>
									<CONSIGNEE>' . $IMPNAMA . '</CONSIGNEE>
									<KD_GUDANG_TPFT>BAND</KD_GUDANG_TPFT>
									<BL_NO>' . $NOBL . '</BL_NO>
									<BL_DATE>' . $TGBL . '</BL_DATE> 
									<PIB_NO>' . $NOPIB . '</PIB_NO>
									<PIB_DATE>' . $TGPIB . '</PIB_DATE> 
									<SPPB_NO>' . $NOSPPB . '</SPPB_NO>
									<SPPB_DATE>' . $TGSPPB . '</SPPB_DATE> 
								</SP3UDK>';
                $SQL = "UPDATE spjmkont SET FL_SEND = '1' 
							WHERE FL_SEND = '0' AND KDSPJM = '" . $KDSPJM . "' AND NOKONT = '" . $NOKONT . "'";
                $Execute = $conn->execute($SQL);
            }
        } else {
            $return = '<?xml version="1.0"?>
						   <DOCUMENT>	
								<SP3UDK>		
									<RESULT>FALSE</RESULT>
									<MESSAGES>No record found.</MESSAGES>
								</SP3UDK>	
						   </DOCUMENT>';
        }
        $conn->disconnect();
    } else {
        $return = '<?xml version="1.0"?>
					   <DOCUMENT>	
							<SP3UDK>		
								<RESULT>FALSE</RESULT>
								<MESSAGES>String0 or String1 wrong. Please check your data.</MESSAGES>
							</SP3UDK>	
					   </DOCUMENT>';
    }

    return $return;
}

function getSppud($String0, $String1, $String2) {
    global $conn, $CONF, $connSMS;
    $vUsername = array("TPFT", "WSMAL", "WSJICT", "WSPLDC");
    $vPassword = array("19911402", "19912407", "19912405", "20140606");
    $username = $String0;
    $password = $String1;
    $KodeTPS = $String2;
    if ((in_array($username, $vUsername)) && (in_array($password, $vPassword))) {
        $SQL = "SELECT A.BARCODE, A.NOKONT, A.UKURAN, '' AS CONT_STATUS, '' AS CONT_TYPE, '' AS CONT_WEIGHT,
						   B.VESSEL, B.VOY, B.KDGUDANG, C.DESKRIPSI, B.IMPNAMA, H.ORGNAMA, B.NOBL, 
						   DATE_FORMAT(B.TGBL,'%Y%m%d') AS TGBL, B.NOPIB, DATE_FORMAT(B.TGPIB,'%Y%m%d') AS TGPIB,
						   DATE_FORMAT(A.TGBONGKAR,'%Y%m%d') AS TGBONGKAR, DATE_FORMAT(B.TGTIBA,'%Y%m%d') AS TGTIBA,
						   B.IMPNPWP, A.KDSPJM, H.KDTPS		 
					FROM spjmkont A INNER JOIN spjm B ON A.KDSPJM = B.KDSPJM
									LEFT JOIN gudang C ON B.KDGUDANG = C.KDGUDANG
									INNER JOIN statuskontainer D ON A.KDSTATUS = D.KDSTATUS
									LEFT JOIN pelln E ON B.PELMUAT = E.KDPEL
									LEFT JOIN peldn F ON B.PELBKR = F.KDPEL
									LEFT JOIN kpbc G ON B.KDKPBC = G.KDKPBC
									LEFT JOIN organisasi H ON B.KDORG_TPFT = H.KDORG
					WHERE A.TGSPPUD IS NOT NULL
						  AND B.FLBC = 'Y'
						  AND A.FL_SEND = '0'
						  AND B.KDGUDANG IN (SELECT KDGUDANG FROM gudang WHERE KDTPS = '" . $KodeTPS . "') ";
        //AND B.KDGUDANG = '".$KodeTPS."'";
        $conn->connect();
        $Query = $conn->query($SQL);
        if ($Query->size() > 0) {
            $return = '<?xml version="1.0"?>';
            $return .= '<DOCUMENT>';
            while ($Query->next()) {
                $BARCODE = $Query->get(0);
                $NOKONT = $Query->get(1);
                $UKURAN = $Query->get(2);
                $CONT_STATUS = $Query->get(3);
                $CONT_TYPE = $Query->get(4);
                $CONT_WEIGHT = $Query->get(5);
                $VESSEL = $Query->get(6);
                $VOY = $Query->get(7);
                $KDGUDANG = $Query->get(8);
                $DESKRIPSI = $Query->get(9);
                $IMPNAMA = $Query->get(10);
                $ORGNAMA = $Query->get(11);
                $NOBL = $Query->get(12);
                $TGBL = $Query->get(13);
                $NOPIB = $Query->get(14);
                $TGPIB = $Query->get(15);
                $TGBONGKAR = $Query->get(16);
                $TGTIBA = $Query->get(17);
                $IMPNPWP = $Query->get(18);
                $KDSPJM = $Query->get(19);
                $KDTPS = $Query->get(20);

                $return .= '<SPPUD><BARCODE>' . $BARCODE . '</BARCODE><CONT_NO>' . $NOKONT . '</CONT_NO><CONT_SIZE>' . $UKURAN . '</CONT_SIZE><CONT_TYPE></CONT_TYPE><CONT_LOAD>' . $CONT_LOAD . '</CONT_LOAD><CONT_WEIGHT>' . $CONT_WEIGHT . '</CONT_WEIGHT><VESSEL>' . $VESSEL . '</VESSEL><VOY>' . $VOY . '</VOY><ARRIVE>' . $TGTIBA . '</ARRIVE><KD_GUDANG_ASAL>' . $KDGUDANG . '</KD_GUDANG_ASAL><SHIPPING_AGENT></SHIPPING_AGENT><NPWP_CONSIGNEE>' . $IMPNPWP . '</NPWP_CONSIGNEE><CONSIGNEE>' . $IMPNAMA . '</CONSIGNEE><KD_GUDANG_TPFT>' . $KDTPS . '</KD_GUDANG_TPFT><BL_NO>' . $NOBL . '</BL_NO><BL_DATE>' . $TGBL . '</BL_DATE><PIB_NO>' . $NOPIB . '</PIB_NO><PIB_DATE>' . $TGPIB . '</PIB_DATE></SPPUD>';
                $SQL = "UPDATE spjmkont SET FL_SEND = '1' 
							WHERE FL_SEND = '0' AND KDSPJM = '" . $KDSPJM . "' AND NOKONT = '" . $NOKONT . "'";
                $Execute = $conn->execute($SQL);
            }
            $return .= '</DOCUMENT>';
        } else {
            $return = '<?xml version="1.0"?><DOCUMENT><SPPUD><RESULT>FALSE</RESULT><MESSAGES>No record found.</MESSAGES></SPPUD></DOCUMENT>';
        }
        $conn->disconnect();
    } else {
        $return = '<?xml version="1.0"?><DOCUMENT><SPPUD><RESULT>FALSE</RESULT><MESSAGES>String0 or String1 wrong. Please check your data.</MESSAGES></SPPUD></DOCUMENT>';
    }

    return $return;
}

function replaceCar($text) {
    return str_replace("-", "", $text);
}

function replaceNPWP($text) {
    $text = str_replace("-", "", $text);
    $text = str_replace(".", "", $text);
    return $text;
}

function changeFormatDate($text) {
    if ($text != '') {
        $expl = explode("/", $text);
        $text = $expl[2] . "-" . $expl[1] . "-" . $expl[0];
    }
    return $text;
}

function changeFormatDate2($text) {//echo $text."<br>";
    if ($text != '') {
        $text = substr($text, 0, 4) . "-" . substr($text, 4, 2) . "-" . substr($text, 6, 2);
    }
    return $text;
}

function changeFormatDate3($text) {
    if ($text != '') {
        $expl = explode("-", $text);
        $text = $expl[2] . "/" . $expl[1] . "/" . $expl[0];
    }
    return $text;
}

function changeFormatDateTime($text) {//echo $text."<br>";
    if ($text != '') {
        $text = substr($text, 0, 4) . "-" . substr($text, 4, 2) . "-" . substr($text, 6, 2) . " " . substr($text, 8, 2) . ":" . substr($text, 10, 2) . ":" . substr($text, 12, 2);
    }
    return $text;
}

function Barcode() {
    global $conn, $CONF, $connSMS;
    $pool = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $str = '';
    for ($i = 0; $i < 10; $i++) {
        $str .= substr($pool, mt_rand(0, strlen($pool) - 1), 1);
    }
    $word = $str;

    $SQL = "INSERT INTO barcode (barcodeno, timestamps) VALUES ('" . $word . "',NOW())";
    if ($conn->isConnect) {
        $Execute = $conn->execute($SQL);
    }
    /* $SQL = "SELECT BARCODE FROM spjmkont WHERE BARCODE = '".$word."'";
      if($conn->isConnect){
      $Query = $conn->query($SQL);
      if($Query->size()>0){
      $word = Barcode();
      }
      } */
    return $word;
}

$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';

$server->service($HTTP_RAW_POST_DATA);
?>
