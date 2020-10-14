<?php

set_time_limit(3600);
require_once("config.php");
$dir = $CONF['root.dir'] . "Data/BUP/";
$mvdir = $CONF['root.dir'] . "Data/MASTER_INSERTED/";
$errdir = $CONF['root.dir'] . "Data/MASTER_ERR/";
#get file
if (is_dir($dir)) {
    if ($dh = opendir($dir)) {
        while (($file = readdir($dh)) !== false) {
            if ($file != "." && $file != "..")
                $file_name = $file;
        }
        if (empty($file_name))
            exit();
    }
    closedir($dh);
}
#read file
$file_bup = $dir . $file_name;
if (file_exists($file_bup)) {
    $accdb = odbc_connect('DRIVER={Microsoft Access Driver (*.mdb)}; DBQ=' . $file_bup, '', '', SQL_CUR_USE_ODBC);
    if ($accdb) {
        $idx_err = 0;
		$next_process = true;
        $SQL_HDR = "SELECT CAR, AngkutNama AS NM_ANGKUT, AngkutNo AS NO_VOY_FLIGHT, TgTiba AS TGL_TIBA, DokTupNo AS NO_BC11, 
                    DokTupTg AS TGL_BC11, PosNo as NO_POS_BC11, Bruto, ImpNpwp AS NPWP_CONSIGNEE, ImpNama AS CONSIGNEE, 
                    ImpAlmt AS ALAMAT_CONSIGNEE, Pasoknama AS SHIPPER, PasokAlmt AS ALAMAT_SHIPPER, PelMuat AS KD_PEL_MUAT, PelTransit AS KD_PEL_TRANSIT, PelBkr AS KD_PEL_BONGKAR
                    FROM tblPibHdr WHERE DokTupKd = '1'";
# AND Status = '010'
        $res = odbc_exec($accdb, $SQL_HDR);
        while ($row = odbc_fetch_array($res)) {
            $arrheader[] = $row;
        }
        odbc_close($accdb);
        if (!empty($arrheader)) {
			foreach ($arrheader as $rowdata) {
                foreach ($rowdata as $a => $b) {
                    if ($b == "") {
                        $DATA[$a] = NULL;
                    } else {
                        $DATA[$a] = strtoupper($b);
                    }
                }
                $CAR = $DATA['CAR'];
                $NO_POS_BC11 = $DATA['NO_POS_BC11'];
                $BRUTO = $DATA['Bruto'];
                $NPWP_CONSIGNEE = checkData($DATA['NPWP_CONSIGNEE']);
                $CONSIGNEE = checkData($DATA['CONSIGNEE']);
                $ALAMAT_CONSIGNEE = $DATA['ALAMAT_CONSIGNEE'];
				$SHIPPER = checkData($DATA['SHIPPER']); 
				$ALAMAT_SHIPPER = checkData($DATA['ALAMAT_SHIPPER']); 
                $NM_ANGKUT = $DATA['NM_ANGKUT'];
                $SQL = "SELECT ID FROM reff_kapal WHERE NAMA = " . checkData($NM_ANGKUT) . "";
                $conn->connect();
                $Query = $conn->query($SQL);
                if ($Query->size() > 0) {
                    $Query->next();
                    $KD_KAPAL = $Query->get("ID");
                } else {
                    $KD_KAPAL = "";
                }
                $datahdr = array(
                    'KD_ASAL_BRG' => checkData('2'),
                    'KD_TPS' => checkData('SDVL'),
                    'KD_GUDANG' => checkData('TE11'),
                    'KD_KAPAL' => checkData($KD_KAPAL),
                    'NM_ANGKUT' => checkData($NM_ANGKUT),
                    'NO_VOY_FLIGHT' => checkData($DATA['NO_VOY_FLIGHT']),
                    'TGL_TIBA' => checkData($DATA['TGL_TIBA']),
                    'NO_BC11' => checkData($DATA['NO_BC11']),
                    'TGL_BC11' => checkData($DATA['TGL_BC11']),
                    'KD_PEL_MUAT' => checkData($DATA['KD_PEL_MUAT']),
                    'KD_PEL_TRANSIT' => checkData($DATA['KD_PEL_TRANSIT']),
                    'KD_PEL_BONGKAR' => checkData($DATA['KD_PEL_BONGKAR']),
                    'WK_REKAM' => "NOW()");
				$datahbl = get_data_access(array('DokNo', 'DokTg'), 'tblPibDok', checkData($CAR), $file_bup, "DokKd IN ('705','740')");
                $NO_BL_AWB = $datahbl['DokNo'];
                $TGL_BL_AWB = $datahbl['DokTg'];
                $SQLHDR = "SELECT A.ID FROM t_repohdr A
						   INNER JOIN t_repokms B ON B.KD_REPOHDR=A.ID
                    	   WHERE A.KD_ASAL_BRG = " . $datahdr['KD_ASAL_BRG'] . "
                           AND A.KD_TPS = " . $datahdr['KD_TPS'] . "
                           AND A.KD_GUDANG = " . $datahdr['KD_GUDANG'] . "
                           AND A.NM_ANGKUT = " . $datahdr['NM_ANGKUT'] . " 
                           AND A.NO_VOY_FLIGHT = " . $datahdr['NO_VOY_FLIGHT'] . "
                           AND A.TGL_TIBA = " . $datahdr['TGL_TIBA'] . "
						   AND B.NO_BL_AWB = " .$NO_BL_AWB. "
						   AND B.TGL_BL_AWB = " .$TGL_BL_AWB. "";
                $Query = $conn->query($SQLHDR);
                if ($Query->size() > 0) {
                    $next_process = false;
                }
            }
			
			if($next_process){
					foreach ($arrheader as $rowdata) {
					foreach ($rowdata as $a => $b) {
						if ($b == "") {
							$DATA[$a] = NULL;
						} else {
							$DATA[$a] = strtoupper($b);
						}
					}
					$CAR = $DATA['CAR'];
					$NO_POS_BC11 = $DATA['NO_POS_BC11'];
					$BRUTO = $DATA['Bruto'];
					$NPWP_CONSIGNEE = checkData($DATA['NPWP_CONSIGNEE']);
					$CONSIGNEE = checkData($DATA['CONSIGNEE']);
					$ALAMAT_CONSIGNEE = $DATA['ALAMAT_CONSIGNEE'];
					$SHIPPER = checkData($DATA['SHIPPER']); 
					$ALAMAT_SHIPPER = checkData($DATA['ALAMAT_SHIPPER']); 
					$NM_ANGKUT = $DATA['NM_ANGKUT'];
					$SQL = "SELECT ID FROM reff_kapal WHERE NAMA = " . checkData($NM_ANGKUT) . "";
					$conn->connect();
					$Query = $conn->query($SQL);
					if ($Query->size() > 0) {
						$Query->next();
						$KD_KAPAL = $Query->get("ID");
					} else {
						$KD_KAPAL = "";
					}
					$datahdr = array(
						'KD_ASAL_BRG' => checkData('2'),
						'KD_TPS' => checkData('SDVL'),
						'KD_GUDANG' => checkData('TE11'),
						'KD_KAPAL' => checkData($KD_KAPAL),
						'NM_ANGKUT' => checkData($NM_ANGKUT),
						'NO_VOY_FLIGHT' => checkData($DATA['NO_VOY_FLIGHT']),
						'TGL_TIBA' => checkData($DATA['TGL_TIBA']),
						'NO_BC11' => checkData($DATA['NO_BC11']),
						'TGL_BC11' => checkData($DATA['TGL_BC11']),
						'KD_PEL_MUAT' => checkData($DATA['KD_PEL_MUAT']),
						'KD_PEL_TRANSIT' => checkData($DATA['KD_PEL_TRANSIT']),
						'KD_PEL_BONGKAR' => checkData($DATA['KD_PEL_BONGKAR']),
						'WK_REKAM' => "NOW()");
					$SQLHDR = "SELECT ID FROM t_repohdr
						WHERE KD_ASAL_BRG = " . $datahdr['KD_ASAL_BRG'] . "
							  AND KD_TPS = " . $datahdr['KD_TPS'] . "
							  AND KD_GUDANG = " . $datahdr['KD_GUDANG'] . "
							  AND NM_ANGKUT = " . $datahdr['NM_ANGKUT'] . " 
							  AND NO_VOY_FLIGHT = " . $datahdr['NO_VOY_FLIGHT'] . "
							  AND TGL_TIBA = " . $datahdr['TGL_TIBA'] . "";
					$Query = $conn->query($SQLHDR);
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
					if ($ID == "") {
						$ID = mysql_insert_id();
					}
					if (!$InsertTRepoHdr) {
						$idx_err++;
						$message[] = 'gagal insert header CAR: ' . $CAR;
					} else {
	#data repo kms                    
						$datahbl = get_data_access(array('DokNo', 'DokTg'), 'tblPibDok', checkData($CAR), $file_bup, "DokKd IN ('705','740')");
						$NO_BL_AWB = $datahbl['DokNo'];
						$TGL_BL_AWB = $datahbl['DokTg'];
						$datambl = get_data_access(array('DokNo', 'DokTg'), 'tblPibDok', checkData($CAR), $file_bup, "DokKd IN ('704','741')");
						$NO_MASTER_BL_AWB = $datambl['DokNo'];
						$TGL_MASTER_BL_AWB = $datambl['DokTg'];
						$datakemasan = get_data_access(array('JnKemas', 'JmKemas'), 'tblPibKms', checkData($CAR), $file_bup);
						$KD_KEMAS = $datakemasan['JnKemas'];
						$JUMLAH = $datakemasan['JmKemas'];
	#validasi data
						$SQL = "SELECT KD_KEMASAN, NO_BL_AWB, SERI
							FROM t_repokms
							WHERE KD_REPOHDR = '" . $ID . "' 
								  AND KD_KEMASAN = '" . $KD_KEMAS . "'
								  AND NO_BL_AWB = '" . $NO_BL_AWB . "'
								  AND TGL_BL_AWB = '" . $TGL_BL_AWB . "'";
						$Query = $conn->query($SQL);
						if ($Query->size() > 0) {
							$Query->next();
							$SERI = $Query->get("SERI");
							$parameterArr = array("KD_REPOHDR" => "'" . $ID . "'", "SERI" => "'" . $SERI . "'", "KD_KEMASAN" => "'" . $KD_KEMAS . "'", "NO_BL_AWB" => "'" . $NO_BL_AWB . "'");
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
						$dataImportir = getData(array('ID'), 't_organisasi', 'NAMA', "=", $CONSIGNEE . " AND KD_TIPE_ORGANISASI = 'CONS'");
						if ($dataImportir['SIZE_DATA'] == 0) {
							$SQL = "INSERT INTO t_organisasi (NPWP, NAMA, KD_TIPE_ORGANISASI)
								VALUES (" . $NPWP_CONSIGNEE . ", " . $CONSIGNEE . ", 'CONS')";
							$Execute = $conn->execute($SQL);
							$KD_ORG_CONSIGNEE = mysql_insert_id();
						} else {
							$KD_ORG_CONSIGNEE = $dataImportir['ID'];
						}
						
						$dataShipper = getData(array('ID'), 't_organisasi', 'NAMA', "=", $SHIPPER . " AND KD_TIPE_ORGANISASI = 'CONS'");
						if ($dataShipper['SIZE_DATA'] == 0) {
							$SQL = "INSERT INTO t_organisasi (NPWP, NAMA, KD_TIPE_ORGANISASI)
								VALUES ('00000000', " . $SHIPPER . ", 'CONS')";
							$Execute = $conn->execute($SQL);
							$KD_ORG_SHIPPER = mysql_insert_id();
						} else {
							$KD_ORG_SHIPPER = $dataShipper['ID'];
						}
	#array data kemasan
						$datarepokms = array(
							"KD_REPOHDR" => checkData($ID),
							"SERI" => checkData($SERI),
							"KD_KEMASAN" => checkData($KD_KEMAS),
							"JUMLAH" => checkData($JUMLAH),
							"ID_CONT_ASAL" => 'NULL',
							"NO_CONT_ASAL" => 'NULL',
							"BRUTO" => checkData($BRUTO),
							"NO_SEGEL" => 'NULL',
							"KONDISI_SEGEL" => 'NULL',
							"NO_BL_AWB" => checkData($NO_BL_AWB),
							"TGL_BL_AWB" => checkData($TGL_BL_AWB, 'date'),
							"NO_MASTER_BL_AWB" => checkData($NO_MASTER_BL_AWB),
							"TGL_MASTER_BL_AWB" => checkData($TGL_MASTER_BL_AWB, 'date'),
							"NO_POS_BC11" => checkData($NO_POS_BC11),
							"KD_ORG_CONSIGNEE" => checkData($KD_ORG_CONSIGNEE),
							"KD_ORG_SHIPPER" => checkData($KD_ORG_SHIPPER),
							"KD_TIMBUN_KAPAL" => 'NULL',
							"KD_TIMBUN" => checkData('TE11'),
							"KD_PEL_MUAT" => $datahdr['KD_PEL_MUAT'],
							"KD_PEL_TRANSIT" => $datahdr['KD_PEL_TRANSIT'],
							"KD_PEL_BONGKAR" => $datahdr['KD_PEL_BONGKAR'],
							"WK_REKAM" => 'NOW()');
						$InsertTRepoKms = InsertUpdate('t_repokms', $datarepokms, $parameter);
						if (!$InsertTRepoKms) {
							$idx_err++;
							$message[] = ' gagal insert kemasan CAR: ' . $CAR;
						}
					}
				}
			}
        }
    }
    odbc_close($accdb);
    odbc_close_all();
} else {
    exit();
}
if ($idx_err > 0) {
    $url_target = $errdir . $file_name;
    $response = implode(",", $message);
} else {
    $url_target = $mvdir . $file_name;
    $response = 'berhasil';
}
/*
if (copy($file_bup, $url_target)) {
    unlink($file_bup);
    echo "unlink- " . $file_bup;
} */

$arrlog = array(
    'URL' => checkData($url_target),
    'METHOD' => checkData('ReadFileBUP'),
    'REQUEST' => checkData($file_bup),
    'RESPONSE' => checkData($response),
    'WK_REKAM' => 'NOW()');
$conn->connect();
$log = InsertUpdate('app_log_services', $arrlog);
$conn->disconnect();
if ($log) {
    echo $response;
    exit();
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
function get_data_access($fieldName, $tableName, $car, $file_bup, $addwhere = "") {
    $accdbfc = odbc_connect('DRIVER={Microsoft Access Driver (*.mdb)}; DBQ=' . $file_bup, '', '', SQL_CUR_USE_ODBC);
	if ($accdbfc) {
        $field = implode(",", $fieldName);
        $SQL = "SELECT " . $field . " FROM " . $tableName . " WHERE CAR = " . $car;
        if ($addwhere != "") {
            $SQL .= " AND " . $addwhere;
        }
        $res = odbc_exec($accdbfc, $SQL);
        $row = odbc_fetch_array($res);
        if (!empty($row)) {
            foreach ($row as $a => $b) {
                if ($b == "") {
                    $DATA[$a] = NULL;
                } else {
                    $DATA[$a] = $b;
                }
            }
        }
    }
    odbc_close($accdbfc);
    return $DATA;
}
?>