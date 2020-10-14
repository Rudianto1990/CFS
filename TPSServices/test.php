<?php
ob_start();
require_once ('config.php');
require_once ($CONF['root.dir'] . 'Libraries/nusoap-lokal/lib/nusoap.php');
require_once ($CONF['root.dir'] . 'Libraries/xml2array.php' );

$server = new soap_server();
$server->configureWSDL('CFSwsdl', 'http://dev.edi-indonesia.co.id/cfs-center/');
$server->wsdl->schemaTargetNamespace = 'http://dev.edi-indonesia.co.id/cfs-center/';

$server->register('TesSoap', // method name
	array('fStream' => 'xsd:string', 'Username' => 'xsd:string', 'Password' => 'xsd:string'), // input parameter
	array('TesSoapResult' => 'xsd:string'), // output
	'urn:TesSoapwsdl', // namespace
	'urn:TesSoapwsdl#TesSoap', // soapaction
	'rpc', // style
	'encoded', // use
	'Fungsi untuk melakukan uji coba TesSoap'// documentation
);

function TesSoap($fStream,$Username,$Password) {
    global $CONF, $conn;
    $conn->connect();
    $IDLogServices = insertLogServices($Username, $Password, $CONF['url.wsdl'], 'CoarriCodeco_Container', $fStream);
	/* if ($Username != "TES" || $Password != "TES") {
        return $fStream;
    } */
	$cek = checkUser($Username,$Password);
	if (!$cek['return']) {
        return $cek['message'];
    }

    //$STR_DATA = htmlspecialchars($fStream,ENT_XML1);
	$STR_DATA = $fStream;//str_replace('&', '&amp;', $fStream);

	libxml_use_internal_errors(true);

	$doc = simplexml_load_string($STR_DATA); // array object
	$xml = explode("\n", $STR_DATA);
	$return=$STR_DATA;//"";

	if (!$doc) {
		$errors = libxml_get_errors();
		foreach ($errors as $error) {
			$return .= display_xml_error($error, $xml);
		}

		libxml_clear_errors();
	}else{
        // $xml = xml2ary($STR_DATA);
        // if (count($xml) > 0) {
            // $xml = $xml['DOCUMENT']['_c'];
            // $countSPPB = 0;
            // $countSPPB = count($xml['COCOCONT']);
            // if ($countSPPB > 1) {
                // for ($c = 0; $c < $countSPPB; $c++) {
                    // $cocostscont = $xml['COCOCONT'][$c]['_c'];
                    // Insertcocostscont($KodeDokBC, $cocostscont, $IDLogServices);
                // }
            // } elseif ($countSPPB == 1) {
                // $cocostscont = $xml['COCOCONT']['_c'];
                // Insertcocostscont($KodeDokBC, $cocostscont, $IDLogServices);
            // } else {
				// updateLogServicesToFailed($IDLogServices);
            // }
        // } else {
            // updateLogServicesToFailed($IDLogServices);
        // }
		// foreach($doc as $key => $val){
			// $return.=$key;
			// if(!isset($key) || empty($key))
				// $return.="Failed";
			// else
				// $return.=$val;
		// } 
		// if(!isset($doc->RESPON) || empty($doc->RESPON))
			// $return="Failed";
		// else
			// $return=$doc->RESPON;
		// $return=print_r($doc);
		// $return=$doc->RESPON;
	}
    //$return = $fStream." - ".$Username." - ".$Password;
	updateLogServices($IDLogServices,$return);
	
    return $return;
}

function Insertcocostscont($KodeDokBC, $cocostscont, $ID_LOG) {
    global $CONF, $conn;
    $sqlerror = '';
    $header = $cocostscont['HEADER']['_c'];
    $KD_DOK = trim($header['KD_DOK']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['KD_DOK']['_v'])) . "'";
    $KD_TPS = trim($header['KD_TPS']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['KD_TPS']['_v'])) . "'";
    $NM_ANGKUT = trim($header['NM_ANGKUT']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['NM_ANGKUT']['_v'])) . "'";
    $NO_VOY_FLIGHT = trim($header['NO_VOY_FLIGHT']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['NO_VOY_FLIGHT']['_v'])) . "'";
    $CALL_SIGN = trim($header['CALL_SIGN']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['CALL_SIGN']['_v'])) . "'";
    $TGL_TIBA = trim($header['TGL_TIBA']['_v']) == "" ? "NULL" : "STR_TO_DATE('" . strtoupper(trim($header['TGL_TIBA']['_v'])) . "','%Y%m%d')";
    $KD_GUDANG = trim($header['KD_GUDANG']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['KD_GUDANG']['_v'])) . "'";
    $REF_NUMBER = trim($header['REF_NUMBER']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['REF_NUMBER']['_v'])) . "'";

    $CONT = $cocostscont['DETIL']['_c']['CONT']['_c'];
    $NO_BC11 = trim($CONT['NO_BC11']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CONT['NO_BC11']['_v'])) . "'";
    $TGL_BC11 = trim($CONT['TGL_BC11']['_v']) == "" ? "NULL" : "STR_TO_DATE('" . strtoupper(trim($CONT['TGL_BC11']['_v'])) . "','%Y%m%d')";

    switch ($header['KD_DOK']['_v']) {
        case "1": $KD_ASAL_BRG = '1'; break;
        case "2": $KD_ASAL_BRG = '3'; break;
        case "3": $KD_ASAL_BRG = '1'; break;
        case "4": $KD_ASAL_BRG = '3'; break;
        case "5": $KD_ASAL_BRG = '2'; break;
        case "6": $KD_ASAL_BRG = '2'; break;
        case "7": $KD_ASAL_BRG = '4'; break;
        case "8": $KD_ASAL_BRG = '4'; break;
    }
    //echo $REF_NUMBER . '<br>';
    $SQL = "SELECT A.ID
            FROM t_cocostshdr A
            WHERE A.KD_GUDANG = " . $KD_GUDANG . "
				  AND A.KD_ASAL_BRG = '" . $KD_ASAL_BRG . "'
                  AND A.NM_ANGKUT = " . $NM_ANGKUT . "
                  AND A.NO_VOY_FLIGHT = " . $NO_VOY_FLIGHT . "
                  AND A.TGL_TIBA = " . $TGL_TIBA . "";
    $Query = $conn->query($SQL);
    if ($Query->size() == 0) {
        $SQL = "INSERT INTO t_cocostshdr (KD_ASAL_BRG, KD_TPS, KD_GUDANG, NM_ANGKUT,
                                          CALL_SIGN, NO_VOY_FLIGHT, TGL_TIBA, NO_BC11, TGL_BC11, WK_REKAM)
                VALUES (" . $KD_ASAL_BRG . "," . $KD_TPS . ", " . $KD_GUDANG . ", " . $NM_ANGKUT . ",
                        " . $CALL_SIGN . ", " . $NO_VOY_FLIGHT . ", " . $TGL_TIBA . ", " . $NO_BC11 . ", " . $TGL_BC11 . ",
                        NOW());";
        $Execute = $conn->execute($SQL);
        if ($Execute) {
            $ID = mysql_insert_id();
        } else {
            $sqlerror = mysql_errno() . ": " . mysql_error().'; '.'Query Error: Cannot Insert t_cocostshdr; ' . $SQL;
			echo $sqlerror.'<hr>';
            updateLogServicesToFailed($IDLogServices);
            $SQL = "UPDATE app_log_services SET FL_USED = '1', WK_USED = NOW() WHERE ID = '" . $ID_LOG . "'";
            $Execute = $conn->execute($SQL);

            $SQL = "INSERT INTO app_log_services_failed SELECT * FROM app_log_services WHERE ID = '" . $ID_LOG . "'";
            $Execute = $conn->execute($SQL);

            $SQL = 'UPDATE app_log_services_failed SET KETERANGAN = "' . $sqlerror . '" WHERE ID = "' . $ID_LOG . '"';
            $Execute = $conn->execute($SQL);
			
			if($Execute){
			  $SQL = "DELETE FROM app_log_services WHERE ID = '" . $ID_LOG . "'";
			  $Execute = $conn->execute($SQL);
			}			
        }
    } else {
        $Query->next();
        $ID = $Query->get("ID");
    }
	$SQL = "select A.ID from t_permohonan_cfshdr A WHERE A.NAMA_KAPAL=".$NM_ANGKUT." AND A.NO_VOY_FLIGHT=".$NO_VOY_FLIGHT."
			AND A.TGL_TIBA=".$TGL_TIBA." AND A.NO_BC11=".$NO_BC11." AND A.TGL_BC11=".$TGL_BC11;
	$Query = $conn->query($SQL);
	if ($Query->size() != 0) {
		while ($Query->next()) {
			$ID_CFS = $Query->get("ID");
		}
	}else{
		$ID_CFS = '';
	}
    //echo $ID . '<br>';


    if ($ID != '') {
        $detil = $cocostscont['DETIL']['_c'];

        $countCONT = count($detil['CONT']);
        //echo $countCONT . '<br>';
        if ($countCONT > 1) {
            for ($d = 0; $d < $countCONT; $d++) {
                $CONT = $detil['CONT'][$d]['_c'];
                $return = InsertKontainer($ID, $CONT, $header['KD_DOK']['_v'], $ID_CFS);
                if ($return != 'true') {
                    $return = explode('|', $return);
                    $sqlerror .= $return[1];
                }
            }
        } elseif ($countCONT == 1) {
            $CONT = $detil['CONT']['_c'];
            $return = InsertKontainer($ID, $CONT, $header['KD_DOK']['_v'], $ID_CFS);
            if ($return != 'true') {
                $return = explode('|', $return);
                $sqlerror .= $return[1];
            }
        } else {
            $sqlerror = 'Data kontainer kosong;';
        }
        if ($sqlerror == '') {
            $SQL = "UPDATE app_log_services SET FL_USED = '1', WK_USED = NOW() WHERE ID = '" . $ID_LOG . "'";
            $Execute = $conn->execute($SQL);

            $SQL = "INSERT INTO app_log_services_success SELECT * FROM app_log_services WHERE ID = '" . $ID_LOG . "'";
            $Execute = $conn->execute($SQL);
			if($Execute){
			  $SQL = "DELETE FROM app_log_services WHERE ID = '" . $ID_LOG . "'";
			  $Execute = $conn->execute($SQL);
			}			
			echo 'OK';
        } else {
            $responseerror = 'Query Error: Cannot Insert t_cocostscont; ' . $sqlerror;
			echo $responseerror;
            $SQL = "UPDATE app_log_services SET FL_USED = '1', WK_USED = NOW() WHERE ID = '" . $ID_LOG . "'";
            $Execute = $conn->execute($SQL);

            $SQL = "INSERT INTO app_log_services_failed SELECT * FROM app_log_services WHERE ID = '" . $ID_LOG . "'";
            $Execute = $conn->execute($SQL);

            $SQL = 'UPDATE app_log_services_failed SET KETERANGAN = "' . $responseerror . '" WHERE ID = "' . $ID_LOG . '"';
            $Execute = $conn->execute($SQL);
			if($Execute){
			  $SQL = "DELETE FROM app_log_services WHERE ID = '" . $ID_LOG . "'";
			  $Execute = $conn->execute($SQL);
			}			
        }
    }
}

function InsertPelabuhan($PEL="") {
    global $CONF, $conn;
	if($PEL!=""){
		$SQL = "SELECT A.ID FROM reff_pelabuhan A WHERE A.ID = " . $PEL . "";
		$Query = $conn->query($SQL);
		if ($Query->size() == 0) {
			$SQL = "INSERT INTO reff_pelabuhan (ID) VALUES (" . $PEL . ");";
			$Execute = $conn->execute($SQL);
		}
	}
}

function InsertKontainer($ID, $CONT, $KD_DOK, $CFS="") {
    global $CONF, $conn;
    $NO_CONT = trim($CONT['NO_CONT']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CONT['NO_CONT']['_v'])) . "'";
    $UK_CONT = trim($CONT['UK_CONT']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CONT['UK_CONT']['_v'])) . "'";
    $NO_SEGEL = trim($CONT['NO_SEGEL']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CONT['NO_SEGEL']['_v'])) . "'";
    $JNS_CONT = trim($CONT['JNS_CONT']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CONT['JNS_CONT']['_v'])) . "'";
    $NO_BL_AWB = trim($CONT['NO_BL_AWB']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CONT['NO_BL_AWB']['_v'])) . "'";
    $TGL_BL_AWB = trim($CONT['TGL_BL_AWB']['_v']) == "" ? "NULL" : "STR_TO_DATE('" . strtoupper(trim($CONT['TGL_BL_AWB']['_v'])) . "','%Y%m%d')";
    $NO_MASTER_BL_AWB = trim($CONT['NO_MASTER_BL_AWB']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CONT['NO_MASTER_BL_AWB']['_v'])) . "'";
    $TGL_MASTER_BL_AWB = trim($CONT['TGL_MASTER_BL_AWB']['_v']) == "" ? "NULL" : "STR_TO_DATE('" . strtoupper(trim($CONT['TGL_MASTER_BL_AWB']['_v'])) . "','%Y%m%d')";
    $ID_CONSIGNEE = trim($CONT['ID_CONSIGNEE']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CONT['ID_CONSIGNEE']['_v'])) . "'";
    $CONSIGNEE = trim($CONT['CONSIGNEE']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CONT['CONSIGNEE']['_v'])) . "'";
    $BRUTO = trim($CONT['BRUTO']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CONT['BRUTO']['_v'])) . "'";
    $NO_BC11 = trim($CONT['NO_BC11']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CONT['NO_BC11']['_v'])) . "'";
    $TGL_BC11 = trim($CONT['TGL_BC11']['_v']) == "" ? "NULL" : "STR_TO_DATE('" . strtoupper(trim($CONT['TGL_BC11']['_v'])) . "','%Y%m%d')";
    $NO_POS_BC11 = trim($CONT['NO_POS_BC11']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CONT['NO_POS_BC11']['_v'])) . "'";
    $KD_TIMBUN = trim($CONT['KD_TIMBUN']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CONT['KD_TIMBUN']['_v'])) . "'";
    $KD_DOK_INOUT = trim($CONT['KD_DOK_INOUT']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CONT['KD_DOK_INOUT']['_v'])) . "'";
    $NO_DOK_INOUT = trim($CONT['NO_DOK_INOUT']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CONT['NO_DOK_INOUT']['_v'])) . "'";
    $TGL_DOK_INOUT = trim($CONT['TGL_DOK_INOUT']['_v']) == "" ? "NULL" : "STR_TO_DATE('" . strtoupper(trim($CONT['TGL_DOK_INOUT']['_v'])) . "','%Y%m%d')";
    $WK_INOUT = trim($CONT['WK_INOUT']['_v']) == "" ? "NULL" : "STR_TO_DATE('" . strtoupper(trim($CONT['WK_INOUT']['_v'])) . "','%Y%m%d%H%i%s')";
    $KD_SAR_ANGKUT_INOUT = trim($CONT['KD_SAR_ANGKUT_INOUT']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CONT['KD_SAR_ANGKUT_INOUT']['_v'])) . "'";
    $NO_POL = trim($CONT['NO_POL']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CONT['NO_POL']['_v'])) . "'";
    $FL_CONT_KOSONG = trim($CONT['FL_CONT_KOSONG']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CONT['FL_CONT_KOSONG']['_v'])) . "'";
    $ISO_CODE = trim($CONT['ISO_CODE']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CONT['ISO_CODE']['_v'])) . "'";
    /* $PEL_MUAT = (trim($CONT['PEL_MUAT']['_v']) == "") ? "NULL" : "'" . strtoupper(trim($CONT['PEL_MUAT']['_v'])) . "'";
      $PEL_TRANSIT = (trim($CONT['PEL_TRANSIT']['_v']) == "") ? "NULL" : "'" . strtoupper(trim($CONT['PEL_TRANSIT']['_v'])) . "'";
      $PEL_BONGKAR = (trim($CONT['PEL_BONGKAR']['_v']) == "") ? "NULL" : "'" . strtoupper(trim($CONT['PEL_BONGKAR']['_v'])) . "'";
     */
	$PEL_MUAT = (trim($CONT['PEL_MUAT']['_v']) == "" || !ctype_upper(trim($CONT['PEL_MUAT']['_v']))) ? "NULL" : "'" . strtoupper(trim($CONT['PEL_MUAT']['_v'])) . "'";
	InsertPelabuhan($PEL_MUAT);
    $PEL_TRANSIT = (trim($CONT['PEL_TRANSIT']['_v']) == "" || !ctype_upper(trim($CONT['PEL_TRANSIT']['_v']))) ? "NULL" : "'" . strtoupper(trim($CONT['PEL_TRANSIT']['_v'])) . "'";
	InsertPelabuhan($PEL_TRANSIT);
    $PEL_BONGKAR = (trim($CONT['PEL_BONGKAR']['_v']) == "" || !ctype_upper(trim($CONT['PEL_BONGKAR']['_v']))) ? "NULL" : "'" . strtoupper(trim($CONT['PEL_BONGKAR']['_v'])) . "'";
	InsertPelabuhan($PEL_BONGKAR);
    $GUDANG_TUJUAN = trim($CONT['GUDANG_TUJUAN']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CONT['GUDANG_TUJUAN']['_v'])) . "'";
    $KODE_KANTOR = trim($CONT['KODE_KANTOR']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CONT['KODE_KANTOR']['_v'])) . "'";
    $NO_DAFTAR_PABEAN = trim($CONT['NO_DAFTAR_PABEAN']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CONT['NO_DAFTAR_PABEAN']['_v'])) . "'";
    $TGL_DAFTAR_PABEAN = trim($CONT['TGL_DAFTAR_PABEAN']['_v']) == "" ? "NULL" : "STR_TO_DATE('" . strtoupper(trim($CONT['TGL_DAFTAR_PABEAN']['_v'])) . "','%Y%m%d')";
    $NO_SEGEL_BC = trim($CONT['NO_SEGEL_BC']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CONT['NO_SEGEL_BC']['_v'])) . "'";
    $TGL_SEGEL_BC = trim($CONT['TGL_SEGEL_BC']['_v']) == "" ? "NULL" : "STR_TO_DATE('" . strtoupper(trim($CONT['TGL_SEGEL_BC']['_v'])) . "','%Y%m%d')";
    $NO_IJIN_TPS = trim($CONT['NO_IJIN_TPS']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($CONT['NO_IJIN_TPS']['_v'])) . "'";
    $TGL_IJIN_TPS = trim($CONT['TGL_IJIN_TPS']['_v']) == "" ? "NULL" : "STR_TO_DATE('" . strtoupper(trim($CONT['TGL_IJIN_TPS']['_v'])) . "','%Y%m%d')";
    //echo $NO_CONT . '<br>';


    $SQL = "SELECT A.ID 
            FROM t_cocostscont A
            WHERE A.ID = '" . $ID . "'
                  AND A.NO_CONT = " . $NO_CONT . "";
    $Query = $conn->query($SQL);
    if ($Query->size() > 0) {
        if ($KD_DOK == '1') { // Discharge 
            $SQL = "UPDATE t_cocostscont SET KD_DOK_IN = " . $KD_DOK_INOUT . ", NO_DOK_IN = " . $NO_DOK_INOUT . ", TGL_DOK_IN = " . $TGL_DOK_INOUT . ", WK_IN = " . $WK_INOUT . ", KD_CONT_STATUS_IN = NULL, KD_SARANA_ANGKUT_IN = " . $KD_SAR_ANGKUT_INOUT . ", NO_POL_IN = " . $NO_POL . "
                    WHERE ID = '" . $ID . "'
                          AND NO_CONT = " . $NO_CONT . "";
        } elseif ($KD_DOK == '2') { // Loading
            $SQL = "UPDATE t_cocostscont SET KD_DOK_OUT = " . $KD_DOK_INOUT . ", NO_DOK_OUT = " . $NO_DOK_INOUT . ", TGL_DOK_OUT = " . $TGL_DOK_INOUT . ", WK_OUT = " . $WK_INOUT . ", KD_CONT_STATUS_OUT = NULL, KD_SARANA_ANGKUT_OUT = " . $KD_SAR_ANGKUT_INOUT . ", NO_POL_OUT = " . $NO_POL . "
                    WHERE ID = '" . $ID . "'
                          AND NO_CONT = " . $NO_CONT . "";
        } elseif ($KD_DOK == '3') { // Gate Out Lini 1
            $SQL = "UPDATE t_cocostscont SET KD_DOK_OUT = " . $KD_DOK_INOUT . ", NO_DOK_OUT = " . $NO_DOK_INOUT . ", TGL_DOK_OUT = " . $TGL_DOK_INOUT . ", WK_OUT = " . $WK_INOUT . ", KD_CONT_STATUS_OUT = NULL, KD_SARANA_ANGKUT_OUT = " . $KD_SAR_ANGKUT_INOUT . ", NO_POL_OUT = " . $NO_POL . "
                    WHERE ID = '" . $ID . "'
                          AND NO_CONT = " . $NO_CONT . "";
			if ($CFS != ""){
				$sqlupdateCont="update t_permohonan_cfsdtl set KD_STATUS='600', WK_REKAM = NOW() WHERE ID = '".$CFS."' AND NO_CONT=" . $NO_CONT;
			}
        } elseif ($KD_DOK == '4') { // CODECO EKSPOR
            $SQL = "UPDATE t_cocostscont SET KD_DOK_IN = " . $KD_DOK_INOUT . ", NO_DOK_IN = " . $NO_DOK_INOUT . ", TGL_DOK_IN = " . $TGL_DOK_INOUT . ", WK_IN = " . $WK_INOUT . ", KD_CONT_STATUS_IN = NULL, KD_SARANA_ANGKUT_IN = " . $KD_SAR_ANGKUT_INOUT . ", NO_POL_IN = " . $NO_POL . "
                    WHERE ID = '" . $ID . "'
                          AND NO_CONT = " . $NO_CONT . "";
        } elseif ($KD_DOK == '5') { // Gate In Lini 2
            $SQL = "UPDATE t_cocostscont SET KD_DOK_IN = " . $KD_DOK_INOUT . ", NO_DOK_IN = " . $NO_DOK_INOUT . ", TGL_DOK_IN = " . $TGL_DOK_INOUT . ", WK_IN = " . $WK_INOUT . ", KD_CONT_STATUS_IN = NULL, KD_SARANA_ANGKUT_IN = " . $KD_SAR_ANGKUT_INOUT . ", NO_POL_IN = " . $NO_POL . "
                    WHERE ID = '" . $ID . "'
                          AND NO_CONT = " . $NO_CONT . "";
			if ($CFS != ""){
				$sqlupdateCont="update t_permohonan_cfsdtl set KD_STATUS='700', WK_REKAM = NOW() WHERE ID = '".$CFS."' AND NO_CONT=" . $NO_CONT;
			}
        } elseif ($KD_DOK == '6') { // Gate Out Lini 2
            $SQL = "UPDATE t_cocostscont SET KD_DOK_OUT = " . $KD_DOK_INOUT . ", NO_DOK_OUT = " . $NO_DOK_INOUT . ", TGL_DOK_OUT = " . $TGL_DOK_INOUT . ", WK_OUT = " . $WK_INOUT . ", KD_CONT_STATUS_OUT = NULL, KD_SARANA_ANGKUT_OUT = " . $KD_SAR_ANGKUT_INOUT . ", NO_POL_OUT = " . $NO_POL . "
                    WHERE ID = '" . $ID . "'
                          AND NO_CONT = " . $NO_CONT . "";
			if ($CFS != ""){
				$sqlupdateCont="update t_permohonan_cfsdtl set KD_STATUS='800', WK_REKAM = NOW() WHERE ID = '".$CFS."' AND NO_CONT=" . $NO_CONT;
			}
        }
        echo $SQL . '<hr>';
    } else { 
        if ($KD_DOK == '1') { // Discharge 
            $SQL = "INSERT INTO t_cocostscont (ID, NO_CONT, KD_CONT_UKURAN, KD_CONT_JENIS, KD_ISO_CODE, BRUTO,
                                               NO_SEGEL, NO_BL_AWB, TGL_BL_AWB, NO_MASTER_BL_AWB, TGL_MASTER_BL_AWB, NO_POS_BC11, KD_ORG_CONSIGNEE, CONSIGNEE,
                                               KD_TIMBUN, KD_PEL_MUAT, KD_PEL_TRANSIT, KD_PEL_BONGKAR, KD_DOK_IN, NO_DOK_IN, TGL_DOK_IN, WK_IN,
                                               KD_SARANA_ANGKUT_IN, NO_POL_IN, KD_GUDANG_TUJUAN, KD_KANTOR_PABEAN, NO_DAFTAR_PABEAN, TGL_DAFTAR_PABEAN,
                                               NO_SEGEL_BC, TGL_SEGEL_BC, NO_IJIN_TPS, TGL_IJIN_TPS, FL_CONT_KOSONG, WK_REKAM)
                    VALUES (" . $ID . ", " . $NO_CONT . ", " . $UK_CONT . ", " . $JNS_CONT . ", " . $ISO_CODE . ", " . $BRUTO . ", " . $NO_SEGEL . "
                    , " . $NO_BL_AWB . ", " . $TGL_BL_AWB . ", " . $NO_MASTER_BL_AWB . ", " . $TGL_MASTER_BL_AWB . ", " . $NO_POS_BC11 . ", " . $ID_CONSIGNEE . ", " . $CONSIGNEE . "
                    , " . $KD_TIMBUN . ", " . $PEL_MUAT . ", " . $PEL_TRANSIT . ", " . $PEL_BONGKAR . ", " . $KD_DOK_INOUT . ", " . $NO_DOK_INOUT . ", " . $TGL_DOK_INOUT . "
                    , " . $WK_INOUT . ", " . $KD_SAR_ANGKUT_INOUT . ", " . $NO_POL . ", " . $GUDANG_TUJUAN . ", " . $KODE_KANTOR . ", " . $NO_DAFTAR_PABEAN . "
                    , " . $TGL_DAFTAR_PABEAN . ", " . $NO_SEGEL_BC . ", " . $TGL_SEGEL_BC . ", " . $NO_IJIN_TPS . ", " . $TGL_IJIN_TPS . ", " . $FL_CONT_KOSONG . ", now())";
        } elseif ($KD_DOK == '2') { // Loading
            $SQL = "INSERT INTO t_cocostscont (ID, NO_CONT, KD_CONT_UKURAN, KD_CONT_JENIS, KD_ISO_CODE, BRUTO,
				NO_SEGEL, NO_BL_AWB, TGL_BL_AWB, NO_MASTER_BL_AWB, TGL_MASTER_BL_AWB, NO_POS_BC11, KD_ORG_CONSIGNEE, CONSIGNEE,
				KD_TIMBUN, KD_PEL_MUAT, KD_PEL_TRANSIT, KD_PEL_BONGKAR, KD_DOK_OUT, NO_DOK_OUT, TGL_DOK_OUT, WK_OUT,
				KD_SARANA_ANGKUT_OUT, NO_POL_OUT, KD_GUDANG_TUJUAN, KD_KANTOR_PABEAN, NO_DAFTAR_PABEAN, TGL_DAFTAR_PABEAN,
				NO_SEGEL_BC, TGL_SEGEL_BC, NO_IJIN_TPS, TGL_IJIN_TPS, FL_CONT_KOSONG, WK_REKAM)
                    VALUES (" . $ID . ", " . $NO_CONT . ", " . $UK_CONT . ", " . $JNS_CONT . ", " . $ISO_CODE . ", " . $BRUTO . ", " . $NO_SEGEL . "
                    , " . $NO_BL_AWB . ", " . $TGL_BL_AWB . ", " . $NO_MASTER_BL_AWB . ", " . $TGL_MASTER_BL_AWB . ", " . $NO_POS_BC11 . ", " . $ID_CONSIGNEE . ", " . $CONSIGNEE . "
                    , " . $KD_TIMBUN . ", " . $PEL_MUAT . ", " . $PEL_TRANSIT . ", " . $PEL_BONGKAR . ", " . $KD_DOK_INOUT . ", " . $NO_DOK_INOUT . ", " . $TGL_DOK_INOUT . "
                    , " . $WK_INOUT . ", " . $KD_SAR_ANGKUT_INOUT . ", " . $NO_POL . ", " . $GUDANG_TUJUAN . ", " . $KODE_KANTOR . ", " . $NO_DAFTAR_PABEAN . "
                    , " . $TGL_DAFTAR_PABEAN . ", " . $NO_SEGEL_BC . ", " . $TGL_SEGEL_BC . ", " . $NO_IJIN_TPS . ", " . $TGL_IJIN_TPS . ", " . $FL_CONT_KOSONG . ", now())";
        } elseif ($KD_DOK == '3') { // Gate Out Lini 1
            $SQL = "INSERT INTO t_cocostscont (ID, NO_CONT, KD_CONT_UKURAN, KD_CONT_JENIS, KD_ISO_CODE, BRUTO,
				NO_SEGEL, NO_BL_AWB, TGL_BL_AWB, NO_MASTER_BL_AWB, TGL_MASTER_BL_AWB, NO_POS_BC11, KD_ORG_CONSIGNEE, CONSIGNEE,
				KD_TIMBUN, KD_PEL_MUAT, KD_PEL_TRANSIT, KD_PEL_BONGKAR, KD_DOK_OUT, NO_DOK_OUT, TGL_DOK_OUT, WK_OUT,
				KD_SARANA_ANGKUT_OUT, NO_POL_OUT, KD_GUDANG_TUJUAN, KD_KANTOR_PABEAN, NO_DAFTAR_PABEAN, TGL_DAFTAR_PABEAN,
				NO_SEGEL_BC, TGL_SEGEL_BC, NO_IJIN_TPS, TGL_IJIN_TPS, FL_CONT_KOSONG, WK_REKAM)
                    VALUES (" . $ID . ", " . $NO_CONT . ", " . $UK_CONT . ", " . $JNS_CONT . ", " . $ISO_CODE . ", " . $BRUTO . ", " . $NO_SEGEL . "
                    , " . $NO_BL_AWB . ", " . $TGL_BL_AWB . ", " . $NO_MASTER_BL_AWB . ", " . $TGL_MASTER_BL_AWB . ", " . $NO_POS_BC11 . ", " . $ID_CONSIGNEE . ", " . $CONSIGNEE . "
                    , " . $KD_TIMBUN . ", " . $PEL_MUAT . ", " . $PEL_TRANSIT . ", " . $PEL_BONGKAR . ", " . $KD_DOK_INOUT . ", " . $NO_DOK_INOUT . ", " . $TGL_DOK_INOUT . "
                    , " . $WK_INOUT . ", " . $KD_SAR_ANGKUT_INOUT . ", " . $NO_POL . ", " . $GUDANG_TUJUAN . ", " . $KODE_KANTOR . ", " . $NO_DAFTAR_PABEAN . "
                    , " . $TGL_DAFTAR_PABEAN . ", " . $NO_SEGEL_BC . ", " . $TGL_SEGEL_BC . ", " . $NO_IJIN_TPS . ", " . $TGL_IJIN_TPS . ", " . $FL_CONT_KOSONG . ", now())";
			if ($CFS != ""){
				$sqlupdateCont="update t_permohonan_cfsdtl set KD_STATUS='600', WK_REKAM = NOW() WHERE ID = '".$CFS."' AND NO_CONT=" . $NO_CONT;
			}
        } elseif ($KD_DOK == '4') { // CODECO EKSPOR
            $SQL = "INSERT INTO t_cocostscont (ID, NO_CONT, KD_CONT_UKURAN, KD_CONT_JENIS, KD_ISO_CODE, BRUTO,
				NO_SEGEL, NO_BL_AWB, TGL_BL_AWB, NO_MASTER_BL_AWB, TGL_MASTER_BL_AWB, NO_POS_BC11, KD_ORG_CONSIGNEE, CONSIGNEE,
				KD_TIMBUN, KD_PEL_MUAT, KD_PEL_TRANSIT, KD_PEL_BONGKAR, KD_DOK_IN, NO_DOK_IN, TGL_DOK_IN, WK_IN,
				KD_SARANA_ANGKUT_IN, NO_POL_IN, KD_GUDANG_TUJUAN, KD_KANTOR_PABEAN, NO_DAFTAR_PABEAN, TGL_DAFTAR_PABEAN,
				NO_SEGEL_BC, TGL_SEGEL_BC, NO_IJIN_TPS, TGL_IJIN_TPS, FL_CONT_KOSONG, WK_REKAM)
                    VALUES (" . $ID . ", " . $NO_CONT . ", " . $UK_CONT . ", " . $JNS_CONT . ", " . $ISO_CODE . ", " . $BRUTO . ", " . $NO_SEGEL . "
                    , " . $NO_BL_AWB . ", " . $TGL_BL_AWB . ", " . $NO_MASTER_BL_AWB . ", " . $TGL_MASTER_BL_AWB . ", " . $NO_POS_BC11 . ", " . $ID_CONSIGNEE . ", " . $CONSIGNEE . "
                    , " . $KD_TIMBUN . ", " . $PEL_MUAT . ", " . $PEL_TRANSIT . ", " . $PEL_BONGKAR . ", " . $KD_DOK_INOUT . ", " . $NO_DOK_INOUT . ", " . $TGL_DOK_INOUT . "
                    , " . $WK_INOUT . ", " . $KD_SAR_ANGKUT_INOUT . ", " . $NO_POL . ", " . $GUDANG_TUJUAN . ", " . $KODE_KANTOR . ", " . $NO_DAFTAR_PABEAN . "
                    , " . $TGL_DAFTAR_PABEAN . ", " . $NO_SEGEL_BC . ", " . $TGL_SEGEL_BC . ", " . $NO_IJIN_TPS . ", " . $TGL_IJIN_TPS . ", " . $FL_CONT_KOSONG . ", now())";
        } elseif ($KD_DOK == '5') { // Gate In Lini 2
            $SQL = "INSERT INTO t_cocostscont (ID, NO_CONT, KD_CONT_UKURAN, KD_CONT_JENIS, KD_ISO_CODE, BRUTO,
				NO_SEGEL, NO_BL_AWB, TGL_BL_AWB, NO_MASTER_BL_AWB, TGL_MASTER_BL_AWB, NO_POS_BC11, KD_ORG_CONSIGNEE, CONSIGNEE,
				KD_TIMBUN, KD_PEL_MUAT, KD_PEL_TRANSIT, KD_PEL_BONGKAR, KD_DOK_IN, NO_DOK_IN, TGL_DOK_IN, WK_IN,
				KD_SARANA_ANGKUT_IN, NO_POL_IN, KD_GUDANG_TUJUAN, KD_KANTOR_PABEAN, NO_DAFTAR_PABEAN, TGL_DAFTAR_PABEAN,
				NO_SEGEL_BC, TGL_SEGEL_BC, NO_IJIN_TPS, TGL_IJIN_TPS, FL_CONT_KOSONG, WK_REKAM)
                    VALUES (" . $ID . ", " . $NO_CONT . ", " . $UK_CONT . ", " . $JNS_CONT . ", " . $ISO_CODE . ", " . $BRUTO . ", " . $NO_SEGEL . "
                    , " . $NO_BL_AWB . ", " . $TGL_BL_AWB . ", " . $NO_MASTER_BL_AWB . ", " . $TGL_MASTER_BL_AWB . ", " . $NO_POS_BC11 . ", " . $ID_CONSIGNEE . ", " . $CONSIGNEE . "
                    , " . $KD_TIMBUN . ", " . $PEL_MUAT . ", " . $PEL_TRANSIT . ", " . $PEL_BONGKAR . ", " . $KD_DOK_INOUT . ", " . $NO_DOK_INOUT . ", " . $TGL_DOK_INOUT . "
                    , " . $WK_INOUT . ", " . $KD_SAR_ANGKUT_INOUT . ", " . $NO_POL . ", " . $GUDANG_TUJUAN . ", " . $KODE_KANTOR . ", " . $NO_DAFTAR_PABEAN . "
                    , " . $TGL_DAFTAR_PABEAN . ", " . $NO_SEGEL_BC . ", " . $TGL_SEGEL_BC . ", " . $NO_IJIN_TPS . ", " . $TGL_IJIN_TPS . ", " . $FL_CONT_KOSONG . ", now())";
			if ($CFS != ""){
				$sqlupdateCont="update t_permohonan_cfsdtl set KD_STATUS='700', WK_REKAM = NOW() WHERE ID = '".$CFS."' AND NO_CONT=" . $NO_CONT;
			}
        } elseif ($KD_DOK == '6') { // Gate Out Lini 2
            $SQL = "INSERT INTO t_cocostscont (ID, NO_CONT, KD_CONT_UKURAN, KD_CONT_JENIS, KD_ISO_CODE, BRUTO,
				NO_SEGEL, NO_BL_AWB, TGL_BL_AWB, NO_MASTER_BL_AWB, TGL_MASTER_BL_AWB, NO_POS_BC11, KD_ORG_CONSIGNEE, CONSIGNEE,
				KD_TIMBUN, KD_PEL_MUAT, KD_PEL_TRANSIT, KD_PEL_BONGKAR, KD_DOK_OUT, NO_DOK_OUT, TGL_DOK_OUT, WK_OUT,
				KD_SARANA_ANGKUT_OUT, NO_POL_OUT, KD_GUDANG_TUJUAN, KD_KANTOR_PABEAN, NO_DAFTAR_PABEAN, TGL_DAFTAR_PABEAN,
				NO_SEGEL_BC, TGL_SEGEL_BC, NO_IJIN_TPS, TGL_IJIN_TPS, FL_CONT_KOSONG, WK_REKAM)
                    VALUES (" . $ID . ", " . $NO_CONT . ", " . $UK_CONT . ", " . $JNS_CONT . ", " . $ISO_CODE . ", " . $BRUTO . ", " . $NO_SEGEL . "
                    , " . $NO_BL_AWB . ", " . $TGL_BL_AWB . ", " . $NO_MASTER_BL_AWB . ", " . $TGL_MASTER_BL_AWB . ", " . $NO_POS_BC11 . ", " . $ID_CONSIGNEE . ", " . $CONSIGNEE . "
                    , " . $KD_TIMBUN . ", " . $PEL_MUAT . ", " . $PEL_TRANSIT . ", " . $PEL_BONGKAR . ", " . $KD_DOK_INOUT . ", " . $NO_DOK_INOUT . ", " . $TGL_DOK_INOUT . "
                    , " . $WK_INOUT . ", " . $KD_SAR_ANGKUT_INOUT . ", " . $NO_POL . ", " . $GUDANG_TUJUAN . ", " . $KODE_KANTOR . ", " . $NO_DAFTAR_PABEAN . "
                    , " . $TGL_DAFTAR_PABEAN . ", " . $NO_SEGEL_BC . ", " . $TGL_SEGEL_BC . ", " . $NO_IJIN_TPS . ", " . $TGL_IJIN_TPS . ", " . $FL_CONT_KOSONG . ", now())";
			if ($CFS != ""){
				$sqlupdateCont="update t_permohonan_cfsdtl set KD_STATUS='800', WK_REKAM = NOW() WHERE ID = '".$CFS."' AND NO_CONT=" . $NO_CONT;
			}
        }
    }

    if ($SQL != '') {
        $Execute = $conn->execute($SQL);
        if (!$Execute) {
			$SQL=mysql_errno() . ": " . mysql_error(). '; '. $SQL;
            echo 'Cannot execute query t_cocostscont. ' . $SQL . '<hr>';
        }else{
			if ($CFS != ""){
				$Execute = $conn->execute($sqlupdateCont);
			}
		}
    }
    return ($Execute != '') ? 'true' : 'false|' . $SQL;
}


/* REFERENCES BEGIN */

function insertLogServices($userName, $Password, $url, $method, $xmlRequest = '', $xmlResponse = '') {
    global $CONF, $conn;
    $ipAddress = getIP();
    $userName = $userName == '' ? 'NULL' : "'" . mysql_real_escape_string($userName) . "'";
    $Password = $Password == '' ? 'NULL' : "'" . mysql_real_escape_string($Password) . "'";
    $url = $url == '' ? 'NULL' : "'" . mysql_real_escape_string($url) . "'";
    $method = $method == '' ? 'NULL' : "'" . mysql_real_escape_string($method) . "'";
    $xmlRequest = $xmlRequest == '' ? 'NULL' : "'" . mysql_real_escape_string($xmlRequest) . "'";
    $xmlResponse = $xmlResponse == '' ? 'NULL' : "'" . mysql_real_escape_string($xmlResponse) . "'";
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

function updateLogServicesToFailed($ID,$error = '') {
    global $CONF, $conn;
    $error = $error == '' ? 'NULL' : "'" . mysql_real_escape_string($error) . "'";
	$SQL = "UPDATE app_log_services SET FL_USED = '1', WK_USED = NOW() WHERE ID = '" . $ID . "'";
	$Execute = $conn->execute($SQL);

 	$SQL = "INSERT INTO app_log_services_failed SELECT * FROM app_log_services WHERE ID = '" . $ID . "'";
	$Execute = $conn->execute($SQL);

	$SQL = "UPDATE app_log_services_failed SET KETERANGAN = " . $error . " WHERE ID = '" . $ID . "'";
	$Execute = $conn->execute($SQL);

	if($Execute){
		$SQL = "DELETE FROM app_log_services WHERE ID = '" . $ID . "'";
		$Execute = $conn->execute($SQL);
	}
}

function deleteLogServices($ID) {
    global $CONF, $conn;
	$SQL = "DELETE FROM app_log_services WHERE ID = '" . $ID . "'";
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

function checkUser($user, $password) {
    global $CONF, $conn;
    $SQL = "SELECT B.KD_TIPE_ORGANISASI,B.ID
            FROM app_user_ws A INNER JOIN t_organisasi B ON A.KD_ORGANISASI = B.ID
            WHERE A.USERLOGIN = '" . trim($user) . "'
                  AND A.PASSWORD = '" . trim($password) . "'";
    $Query = $conn->query($SQL);
	$Query->next();
    if ($Query->size() == 0) {
        $return['return'] = false;
        $return['message'] = '<?xml version="1.0" encoding="UTF-8"?>';
        $return['message'] .= '<DOCUMENT>';
        $return['message'] .= '<RESPON>USERNAME ATAU PASSWORD SALAH.</RESPON>';
        $return['message'] .= '</DOCUMENT>';
        //$logServices = updateLogServices($IDLogServices, $return['message'], 'USERNAME ATAU PASSWORD SALAH.');
    } else {
        $return['return'] = true;
        $return['kdorganisasi'] = $Query->get("ID");
    }
    return $return;
}

function display_xml_error($error, $xml) {
    $return  = "";//$xml[$error->line - 1] . "\n";
    //$return .= str_repeat('-', $error->column) . "^\n";

    switch ($error->level) {
        case LIBXML_ERR_WARNING:
            $return .= "Warning $error->code: ";
            break;
        case LIBXML_ERR_ERROR:
            $return .= "Error $error->code: ";
            break;
        case LIBXML_ERR_FATAL:
            $return .= "Fatal Error $error->code: ";
            break;
    }

    $return .= trim($error->message) .
               "\n  Line: $error->line" .
               "\n  Column: $error->column";

    if ($error->file) {
        $return .= "\n  File: $error->file";
    }

    return "$return; \n";
}

/* REFERENCES END */

$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';

$server->service($HTTP_RAW_POST_DATA);



/* set_time_limit(3600);
require_once("config.php");
$main = new main($CONF, $conn);
$main->connect();

$STR_DATA='<SOAP-ENV:Envelope SOAP-ENV:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:SOAP-ENC="http://schemas.xmlsoap.org/soap/encoding/">
   <SOAP-ENV:Body>
      <ns1:GetImpor_SppbResponse xmlns:ns1="http://services.beacukai.go.id/">
         <GetImpor_SppbResult xsi:type="xsd:string"><![CDATA[<?xml version="1.0"?><!--BC-Doc.SPPB--><DOCUMENT><SPPB><HEADER><CAR>00000010650120171125005916</CAR><NO_SPPB>557401/KPU.01/2017</NO_SPPB><TGL_SPPB>12/4/2017</TGL_SPPB><KD_KPBC>040300</KD_KPBC><NO_PIB>559303</NO_PIB><TGL_PIB>12/4/2017</TGL_PIB><NPWP_IMP>010717775055000</NPWP_IMP><NAMA_IMP>PT. MITSUBISHI JAYA ELEVATOR AND ESCALATOR</NAMA_IMP><ALAMAT_IMP>GD. JAYA LT.11, JL. MH.THAMRIN NO.12,KEBON SIRIH, MENTENG, JAKARTA PUS</ALAMAT_IMP><NPWP_PPJK></NPWP_PPJK><NAMA_PPJK></NAMA_PPJK><ALAMAT_PPJK></ALAMAT_PPJK><NM_ANGKUT>NYK ISABEL</NM_ANGKUT><NO_VOY_FLIGHT>V.421S</NO_VOY_FLIGHT><BRUTO>442</BRUTO><NETTO>382</NETTO><GUDANG>BAND</GUDANG><STATUS_JALUR>H</STATUS_JALUR><JML_CONT></JML_CONT><NO_BC11>005142</NO_BC11><TGL_BC11>11/24/2017</TGL_BC11><NO_POS_BC11>0344</NO_POS_BC11><NO_BL_AWB>JKT020200117</NO_BL_AWB><TG_BL_AWB>11/20/2017</TG_BL_AWB><NO_MASTER_BL_AWB></NO_MASTER_BL_AWB><TG_MASTER_BL_AWB></TG_MASTER_BL_AWB></HEADER><DETIL><KMS><CAR>00000010650120171125005916</CAR><JNS_KMS>PK</JNS_KMS><MERK_KMS>SESUAI INVOICE &amp; P\'LIST</MERK_KMS><JML_KMS>2</JML_KMS></KMS></DETIL></SPPB></DOCUMENT>]]></GetImpor_SppbResult>
      </ns1:GetImpor_SppbResponse>
   </SOAP-ENV:Body>
</SOAP-ENV:Envelope>';
$arr1 = 'ns1:GetImpor_SppbResponse';
$arr2 = 'GetImpor_SppbResult';
$xml = xml2ary($STR_DATA);
$return = $xml['SOAP-ENV:Envelope']['_c']['SOAP-ENV:Body']['_c'][$arr1]['_c'][$arr2]['_v'];
echo '<pre>';print_r(mysql_real_escape_string($return));echo '</pre>';

$main->connect(false); */

?>
