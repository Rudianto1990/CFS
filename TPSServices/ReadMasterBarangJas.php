<?php
set_time_limit(3600);
require_once("config.php");
error_reporting(0);
$folder_path = date("Ymd");
$dir = "D:/COSYS-TPS/COSYS-TPS-OUT/";
$mvdir = "D:/COSYS-TPS/COSYS-TPS-OUT-BAK/".$folder_path;
if (!is_dir($mvdir))
	mkdir($mvdir);
$mvdir .= "/";
$errdir =  "D:/COSYS-TPS/COSYS-TPS-OUT-ERROR/";
#check error dir
/*$file_err = $errdir."err.txt";
$main = new main($CONF, $conn);
$CheckFile = $main->CheckFile($file_err);
if($CheckFile){
	echo 'Scheduler sedang berjalan, harap menghapus file err.txt yang ada difolder Data/MASTER_ERR.'; exit();
}*/
#get file
if(is_dir($dir)){
  if($dh = opendir($dir)){
    while (($file = readdir($dh)) !== false){
      if($file!="." && $file!="..") $file_name = $file;
	}
	if(empty($file_name)) {
		exit();
	} else {
		$ext = pathinfo($file_name, PATHINFO_EXTENSION);
		if ($ext != 'IMP_IN') {
			echo "format tidak sesuai";
			exit();
		}
	}
  }
  closedir($dh);
}
#read file
$txt_file = file_get_contents($dir.$file_name); 
$rows = explode("\n", $txt_file);
$n = count($rows);
$idx_err = 0;
if(empty($txt_file)) $n=0;
if($n>0){
    for($x=0;$x<$n;$x++){
		if($rows[$x]!=''){
			$row_data[] = explode(';', $rows[$x]);
			if($x==0){
				$KD_DOK = checkData($row_data[$x][0]);
				$arrhdr = array('KD_TPS'		=> checkData($row_data[$x][1]),
								'KD_GUDANG'		=> checkData($row_data[$x][6]),
								'KD_KAPAL'		=> checkData($row_data[$x][4]),
								'NM_ANGKUT'		=> checkData($row_data[$x][2]),
								'NO_VOY_FLIGHT'	=> checkData($row_data[$x][4].$row_data[$x][3]),
								'TGL_TIBA'		=> checkData($row_data[$x][5],'date')
								/*,'REFF_NUMBER'	=> checkData($row_data[$x][7])*/);
			}else{
				$NO_BC11 = checkData($row_data[$x][11]);
				$TGL_BC11 = checkData($row_data[$x][12],'date');
				$arrkms[] = array('NO_BL_AWB' 		 	=> $row_data[$x][4],
								  'TGL_BL_AWB'		 	=> $row_data[$x][5],
								  'NO_MASTER_BL_AWB' 	=> $row_data[$x][6],
								  'TGL_MASTER_BL_AWB'	=> $row_data[$x][7],
								  'ID_CONSIGNEE' 		=> $row_data[$x][8],
								  'CONSIGNEE'		 	=> $row_data[$x][9],
								  'BRUTO'			 	=> $row_data[$x][10],
								  'NO_BC11'		 		=> $row_data[$x][11],
								  'TGL_BC11'		 	=> $row_data[$x][12],
								  'NO_POS_BC11'		 	=> $row_data[$x][13],
								  'KD_KEMAS'		 	=> $row_data[$x][16],
								  'JUMLAH'			 	=> $row_data[$x][17],
								  'KD_TIMBUN'		 	=> $row_data[$x][18],
								  'WK_INOUT'			=> $row_data[$x][22],
								  'KD_SARANA_ANGKUT_IN' => $row_data[$x][23],
								  'KD_PEL_MUAT'		 	=> $row_data[$x][27],
								  'KD_PEL_TRANSIT'	 	=> $row_data[$x][28],
								  'KD_PEL_BONGKAR'	 	=> $row_data[$x][29],
								  'KD_KANTOR'	 		=> $row_data[$x][31],
								  'TGL_IJIN_TPS'	 	=> $row_data[$x][37]);
			}
		}
	}
	#header
	$datahdr = $arrhdr;
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
	$datahdr['KD_ASAL_BRG']	= $KD_ASAL_BRG;
	$datahdr['NO_BC11']	 = $NO_BC11;
	$datahdr['TGL_BC11'] = $TGL_BC11;
	$datahdr['KD_PEL_MUAT'] = "NULL";
	$datahdr['KD_PEL_TRANSIT'] = "NULL";
	$datahdr['KD_PEL_BONGKAR'] = "NULL";
	$datahdr['WK_REKAM'] = "NOW()";
	$SQL = "SELECT ID FROM reff_kapal WHERE NAMA = " . trim($datahdr['NM_ANGKUT']). "";
    $conn->connect();
	$Query = $conn->query($SQL);
	#print_r($datahdr);
    if ($Query->size() > 0) {
        $Query->next();
        $datahdr['KD_KAPAL'] = checkData($Query->get("ID"));
    } else {
		$SQLCHECK = "SELECT ID FROM reff_kapal WHERE ID = " . trim($datahdr['KD_KAPAL']). "";
		$Exec = $conn->query($SQLCHECK);
		 if ($Exec->size() > 0) {
			$Exec->next();
			$datahdr['KD_KAPAL'] = checkData($Query->get("ID"));
		 }else{
			 $SQL = "INSERT INTO reff_kapal (ID, NAMA)
					 VALUES (" . trim($datahdr['KD_KAPAL']). ", " . trim($datahdr['NM_ANGKUT']) . ")"; 
			$Exec = $conn->execute($SQL);
			$KD_KAPAL = mysql_insert_id();
		 }
		$datahdr['KD_KAPAL'] = $KD_KAPAL;
    }
	$SQL = "SELECT ID FROM t_repohdr
            WHERE KD_ASAL_BRG = '" . $datahdr['KD_ASAL_BRG'] . "'
                  AND KD_TPS = " . $datahdr['KD_TPS'] . "
                  AND KD_GUDANG = " . $datahdr['KD_GUDANG'] . "
                  AND NM_ANGKUT = " . $datahdr['NM_ANGKUT'] . " 
                  AND NO_VOY_FLIGHT = " . $datahdr['NO_VOY_FLIGHT'] . "
                  AND TGL_TIBA = " . $datahdr['TGL_TIBA'] . "";
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
	$InsertTRepoHdr = InsertUpdate('t_repohdr', $datahdr, $parameter);
	if(!$InsertTRepoHdr){
		$idx_err++;
	}else{
		if($ID=="") {
			$ID = mysql_insert_id();
		}
		if($ID!=0){
			$jml_kms = count($arrkms);
			if($jml_kms>0){
				for($dt=0;$dt<$jml_kms;$dt++){
					 $DocumentCOCOKMS = InsertCocoKms($ID, $KD_DOK, $arrkms[$dt]);
					 if (!$DocumentCOCOKMS['return']) {
						$return = $DocumentCOCOKMS['message'];
						$idx_err++;
					}
				}
			}
		}
	}
	#detil kemasan
	if($idx_err > 0){
		if(copy($dir.$file_name,$errdir.$file_name)){
			unlink($dir.$file_name);
			$response = 'gagal parsing: '.$return;
		}
	}else{
		if(copy($dir.$file_name,$mvdir.$file_name)){
			unlink($dir.$file_name);
			$response = 'berhasil parsing';
		}
	}			
}else{
	if(copy($dir.$file_name,$mvdir.$file_name)){
		unlink($dir.$file_name);
		$response = 'no data';
	}
	$txt_file = $file_name;
}
$arrlog = array('URL' => checkData($mvdir.$file_name),
				'METHOD' => checkData('ReadMasterBarang'),
				'REQUEST' => checkData($txt_file),
				'RESPONSE' => checkData($response),
				'WK_REKAM' => 'NOW()');
$conn->connect();
$log = InsertUpdate('app_log_services', $arrlog);
$conn->disconnect();
if($log){
	echo $response;
	exit();	
}

function InsertCocoKms($ID, $KD_DOK, $data) {
    global $CONF, $conn;
    $NO_BL_AWB = checkData($data['NO_BL_AWB']);
    $TGL_BL_AWB = checkData($data['TGL_BL_AWB'], 'date');
    $NO_MASTER_BL_AWB = checkData($data['NO_MASTER_BL_AWB']);
    $TGL_MASTER_BL_AWB = checkData($data['TGL_MASTER_BL_AWB'], 'date');
    $ID_CONSIGNEE = checkData($data['ID_CONSIGNEE']);
    $CONSIGNEE = checkData($data['CONSIGNEE']);
    $BRUTO = checkData($data['BRUTO']);
    $NO_BC11 = checkData($data['NO_BC11']);
    $TGL_BC11 = checkData($data['TGL_BC11'], 'date');
    $NO_POS_BC11 = checkData($data['NO_POS_BC11']);
    $CONT_ASAL = checkData($data['CONT_ASAL']);
    $SERI_KEMAS = checkData($data['SERI_KEMAS']);
    $KD_KEMAS = checkData($data['KD_KEMAS']);
    $JML_KEMAS = checkData($data['JUMLAH']);
    $KD_TIMBUN = checkData($data['KD_TIMBUN']);
    $KD_DOK_INOUT = checkData($data['KD_DOK_INOUT']);
    $NO_DOK_INOUT = checkData($data['NO_DOK_INOUT']);
    $TGL_DOK_INOUT = checkData($data['TGL_DOK_INOUT'], 'date');
    $datetime = strlen($data['WK_INOUT']);
    if ($datetime == 12)
        $wkinout = $data['WK_INOUT'] . date('s');
	else if ($datetime == 13)
        $wkinout = $data['WK_INOUT']."0";
    else
        $wkinout = $data['WK_INOUT'];
	$WK_INOUT = checkData($wkinout, 'datetime');
    $KD_SAR_ANGKUT_INOUT = checkData($data['KD_SAR_ANGKUT_INOUT']);
    $NO_POL = checkData($data['NO_POL']);
    $PEL_MUAT = checkData($data['KD_PEL_MUAT']);
    $PEL_TRANSIT = checkData($data['KD_PEL_TRANSIT']);
    $PEL_BONGKAR = checkData($data['KD_PEL_BONGKAR']);
    $GUDANG_TUJUAN = checkData($data['GUDANG_TUJUAN']);
    $KODE_KANTOR = checkData($data['KODE_KANTOR']);
    $NO_DAFTAR_PABEAN = checkData($data['NO_DAFTAR_PABEAN']);
    $TGL_DAFTAR_PABEAN = checkData($data['TGL_DAFTAR_PABEAN'], 'date');
    $NO_SEGEL_BC = checkData($data['NO_SEGEL_BC']);
    $TGL_SEGEL_BC = checkData($data['TGL_SEGEL_BC'], 'date');
    $NO_IJIN_TPS = checkData($data['NO_IJIN_TPS']);
    $TGL_IJIN_TPS = checkData($data['TGL_IJIN_TPS'], 'date');

    $SQL = "SELECT KD_KEMASAN, NO_BL_AWB, SERI
            FROM t_repokms
            WHERE KD_REPOHDR = '" . $ID . "' 
                  AND KD_KEMASAN = " . $KD_KEMAS . "
                  AND NO_BL_AWB = " . $NO_BL_AWB . "
				  AND TGL_BL_AWB = " . $TGL_BL_AWB . "";
	$Query = $conn->query($SQL);
    if ($Query->size() > 0) {
        $Query->next();
        $SERI = $Query->get("SERI");
        $parameterArr = array("KD_REPOHDR" => "'" . $ID . "'", "SERI" => "'" . $SERI . "'", "KD_KEMASAN" => $KD_KEMAS, "NO_BL_AWB" => $NO_BL_AWB);
        $parameter = array();
        foreach ($parameterArr as $field => $value) {
            $parameter[] = $field . " = " . $value;
        }
    } else {
        $parameterArr = array();
        $parameter = array();
        $SQL = "SELECT IFNULL(MAX(SERI)+1,1) AS SERI
                FROM t_repokms 
                WHERE KD_REPOHDR = '" . $ID . "'";
        $Query = $conn->query($SQL);
        $Query->next();
        $SERI = $Query->get("SERI");
        if ($SERI == '') {
            $SERI = 1;
        }
    }

  
	$dataImportir = getData(array('ID'), 't_organisasi', 'NAMA', "=", trim($CONSIGNEE) . " AND KD_TIPE_ORGANISASI = 'CONS'");
	if ($dataImportir['SIZE_DATA'] == 0) {
		$SQL = "INSERT INTO t_organisasi (NPWP, NAMA, KD_TIPE_ORGANISASI)
				VALUES (" . $ID_CONSIGNEE . ", " . $CONSIGNEE . ", 'CONS')";
		$Execute = $conn->execute($SQL);
		$KD_ORG_CONSIGNEE = mysql_insert_id();
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
        "NO_POL_IN" => $NO_POL);

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
        "TGL_IJIN_TPS" => $TGL_IJIN_TPS);

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
        $return['message'] = 'gagal insert kemasan';
        return $return;
    } else {
        $return['return'] = true;
        $return['message'] = '';
    }
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
    return $Execute;
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
    $Query = $conn->query($SQL);
    $data["SIZE_DATA"] = $Query->size();
    while ($Query->next()) {
        foreach ($fieldName as $item) {
            $data[$item] = $Query->get($item);
        }
    }
    return $data;
}
?>