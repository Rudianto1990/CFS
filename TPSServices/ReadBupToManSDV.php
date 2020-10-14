<?php 
set_time_limit(3600);
require_once("config.php");
$dir = "C:/xampp/htdocs/file_bup/";
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
    $idx_err = 0;
    $message = array();
    $accdb = odbc_connect('DRIVER={Microsoft Access Driver (*.mdb)}; DBQ=' . $file_bup, '', '', SQL_CUR_USE_ODBC);
    if ($accdb) {
        $SQL_HDR = "SELECT CAR, KdKpbc, AngkutNama AS NM_ANGKUT, AngkutNo AS NO_VOY_FLIGHT, TgTiba AS TGL_TIBA, DokTupNo AS NO_BC11, 
                    DokTupTg AS TGL_BC11, PosNo as NO_POS_BC11, Bruto, ImpNpwp AS NPWP_CONSIGNEE, ImpNama AS CONSIGNEE, 
                    ImpAlmt AS ALAMAT_CONSIGNEE, Pasoknama AS SHIPPER, PasokAlmt AS ALAMAT_SHIPPER, PelMuat AS KD_PEL_MUAT, PelTransit AS KD_PEL_TRANSIT, PelBkr AS KD_PEL_BONGKAR
                    FROM tblPibHdr WHERE DokTupKd = '1'";
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
                  $datahbl = get_data_access(array('DokNo', 'DokTg'), 'tblPibDok', checkData($CAR), $file_bup, "DokKd IN ('705','740')");
                  $NO_BL_AWB = $datahbl['DokNo'];
                  $TGL_BL_AWB = $datahbl['DokTg'];
                  $datambl = get_data_access(array('DokNo', 'DokTg'), 'tblPibDok', checkData($CAR), $file_bup, "DokKd IN ('704','741')");
                  $NO_MASTER_BL_AWB = $datambl['DokNo'];
                  $TGL_MASTER_BL_AWB = $datambl['DokTg'];
                  $datakemasan = get_data_access(array('JnKemas', 'JmKemas'), 'tblPibKms', checkData($CAR), $file_bup);
                  $KD_KEMAS = $datakemasan['JnKemas'];
                  $JUMLAH = $datakemasan['JmKemas'];
                  #manif header
                  $file_db = 'D:/ModulEntry/ManifestEntry.mdb';
                  $accdbfc = odbc_connect('DRIVER={Microsoft Access Driver (*.mdb)}; DBQ=' . $file_db, '', 'admin', SQL_CUR_USE_ODBC);
                  if ($accdbfc) {
                    $SQLCEK_MANIF = "SELECT nodaftar FROM tblheader WHERE voyage = '".$DATA['NO_VOY_FLIGHT']."' AND arrivingdate = ".checkData($DATA['TGL_TIBA'],'dateaccess')." AND no_master = '".$NO_MASTER_BL_AWB."' AND tgl_master = ".checkData($TGL_MASTER_BL_AWB,'dateaccess')."";
                    $rescek = odbc_exec($accdbfc, $SQLCEK_MANIF);
                    $rowcek = odbc_fetch_array($rescek);
                    if($rowcek!=''){
                        foreach($rowcek as $rowdatacek){
                            $NODAFTAR = $rowdatacek;
                        }
                        $datains = true;
                    } else {
                        $NODAFTAR = get_nodaftar();
                        $DATAHEADER = array("nodaftar" =>  checkData($NODAFTAR),
                                            "jnsmanifest" => checkData("Inward"),
                                            "vessel" => checkData($DATA['NM_ANGKUT']),
                                            "voyage" => checkData($DATA['NO_VOY_FLIGHT']),
                                            "kdgrup" => checkData("01I"),
                                            "arrivingdate" => checkData($DATA['TGL_TIBA'],'dateaccess'),
                                            "arrivingtime" => checkData("00:00"),
                                            "status" => checkData("N"),
                                            "no_master" =>  checkData($NO_MASTER_BL_AWB),
                                            "tgl_master"  =>  checkData($TGL_MASTER_BL_AWB));
                        $datains = InsertDataAccess('tblheader', $DATAHEADER, $parameter);
                    }                    
                  }
                  odbc_close($accdbfc);                  
                  if($datains){
                    #manif detail
                    $DATADETAIL = array("nodaftar"  =>  checkData($NODAFTAR),
                                        "nopos" =>  checkData($DATA['NO_POS_BC11']),
                                        "mot_vessel"  =>  "''",
                                        "nobl"  =>  checkData($NO_BL_AWB),
                                        "tglbl" =>  checkData($TGL_BL_AWB,'dateaccess'),
                                        "pasalcd" =>  checkData($DATA['KD_PEL_MUAT']),
                                        "pmuatcd" => checkData($DATA['KD_PEL_MUAT']),
                                        "pbongkarcd"  =>  checkData($DATA['KD_PEL_BONGKAR']),
                                        "pakhircd"  =>  checkData($DATA['KD_PEL_BONGKAR']),
                                        "snm" =>  checkData($DATA['SHIPPER']),
                                        "sna" =>  checkData($DATA['ALAMAT_SHIPPER']),
                                        "cnm" =>  checkData($DATA['CONSIGNEE']),
                                        "cna" =>  checkData($DATA['ALAMAT_CONSIGNEE']),
                                        "nnm" => "''",
                                        "nna" =>  "''",
                                        "mark"  => "''",
                                        "bruto" =>  $DATA['Bruto'],
                                        "volume"  =>  "0",
                                        "jmlkemasan"  =>  $JUMLAH,
                                        "satuankemasan" =>  checkData($KD_KEMAS),
                                        "flagconsolidate" =>  "''",
                                        "flagpartial" =>  "''",
                                        "grandcontainer"  =>  "0",
                                        "grandpackage"  =>  "0",
                                        "kpbc"  =>  checkData($DATA['KdKpbc']),
                                        "pebno" =>  "''",
                                        "pebtgl"  =>  "Null");
                    $datadtlins = InsertDataAccess('tbldetail', $DATADETAIL, $parameter);
                    #$datadtlins = TRUE;
                    if($datadtlins){
                      #get data HS
                      /*$accdb = odbc_connect('DRIVER={Microsoft Access Driver (*.mdb)}; DBQ=' . $file_bup, '', '', SQL_CUR_USE_ODBC);
                      $SQLHS = "SELECT Serial, NoHs, BrgUrai FROM tblPibDtl WHERE CAR = '$CAR'";
                      $reshs = odbc_exec($accdb, $SQLHS);
                      while ($rowhs = odbc_fetch_array($reshs)) {
                          $arrhs[] = $rowhs;
                      }
                      odbc_close($accdb);
                      if (!empty($arrhs)) {
                            foreach ($arrhs as $rowdatahs) {
                              $noseq = str_pad($rowdatahs['Serial'], 4, "0", STR_PAD_LEFT);
                              $DATAHS = array("nodaftar"=> checkData($NODAFTAR),
                                              "nopos" => checkData($DATA['NO_POS_BC11']),
                                              "noseq"   =>  checkData($noseq),
                                              "hs"      =>  checkData($rowdatahs['NoHs']),
                                              "uraian"  =>  checkData($rowdatahs['BrgUrai']));
                              $datahsins = InsertDataAccess('tblhs', $DATAHS, $parameter);
                              if(!$datahsins){ 
                                $idx_err++;
                                $message[] = "gagal insert tblhs";
                              }
                            }
                      } else { 
                          $idx_err++;
                          $message[] = "gagal insert tblhs";
                      }*/
                    } else { 
                        $idx_err++;
                        $message[] = "gagal insert tbldetail";
                    } 
                  } else {
                      $idx_err++;
                      $message[] = "gagal insert tblheader";
                  }
            }
        } else { 
            $idx_err++;
            $message[] = "data tidak ditemukan";
        }
    } else { 
        $idx_err++;
        $message[] = "gagal koneksi file BUP";
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
if (copy($file_bup, $url_target)) {
    unlink($file_bup);
}
$arrlog = array(
    'URL' => checkData($url_target),
    'METHOD' => checkData('BUPTOMANIFEST'),
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

function get_nodaftar(){
  $file_db = 'D:/ModulEntry/ManifestEntry.mdb';
  $accdbfc = odbc_connect('DRIVER={Microsoft Access Driver (*.mdb)}; DBQ=' . $file_db, '', 'admin', SQL_CUR_USE_ODBC);
  if ($accdbfc) {
    $SQL = "SELECT nodaftarauto FROM tblsetting WHERE nama = 'MASAGUNG'";
    $res = odbc_exec($accdbfc, $SQL);
    $row = odbc_fetch_array($res);
    foreach($row as $rowdata){
      $lastnum = $rowdata;
    }
  }
  if (!empty($lastnum)){
    #$seq = substr($lastnum,8,6);
    $urut = intval($lastnum)+1;
  }
  $digit = str_pad($urut, 6, "0", STR_PAD_LEFT);
  $nomor = date('Ymd').$digit;
  $SQLUPDATE = "UPDATE tblsetting SET nodaftarauto ='".$digit."' WHERE nama = 'MASAGUNG'";
  $res = odbc_exec($accdbfc, $SQLUPDATE);
  odbc_close($accdbfc);
  return $nomor;
}

function checkData($data, $type = "text") {
    global $CONF, $conn;
    if (trim(strtoupper($data)) == "") {
        $return = "NULL";
    } else {
        switch ($type) {
            case "text":
                $return = "'" . trim($data) . "'";
                break;
            case "date":
                $return = "DATE_FORMAT('" . trim(strtoupper($data)) . "','%Y%m%d')";
                break;
            case "datetime":
                $return = "DATE_FORMAT('" . trim(strtoupper($data)) . "','%Y%m%d%H%i%s')";
                break;
            case "dateaccess":
                $return = "#" . trim(strtoupper($data)) . "#";
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
function InsertDataAccess($tableName, $dataArr = array(), $parameter = array()) {
    $ret = false;
    $file_db = 'D:/ModulEntry/ManifestEntry.mdb';
    $accdbfc = odbc_connect('DRIVER={Microsoft Access Driver (*.mdb)}; DBQ=' . $file_db, '', 'admin', SQL_CUR_USE_ODBC);
    if ($accdbfc) {
            foreach ($dataArr as $field => $value) {
        $fieldName[] = $field;
        $ValueData[] = $value;
    }
            $SQL = "INSERT INTO " . $tableName . "(" . implode(", ", $fieldName) . ") 
            VALUES (" . implode(", ", $ValueData) . ")";
            $res = odbc_exec($accdbfc, $SQL);
            if($res){
                    $ret = true;
            }
    }
    odbc_close($accdbfc);
    return $ret;
}
?>