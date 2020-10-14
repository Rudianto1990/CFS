<?php

set_time_limit(3600);
require_once("config.php");

$connection = mysqli_connect($CONF['host'], $CONF['username'], $CONF['password'], $CONF['database'], $CONF['port']);
$method = 'prod_create_xml_coco_bc_djp';
$filename = $CONF['root.dir'] . "CheckScheduler/" . $method . ".txt";
$main = new main($CONF, $conn);
$CheckFile = $main->CheckFile($filename);
if (!$CheckFile) {
    $createFile = $main->createFile($filename);
//    $main->connect();
    //BEGIN
    //DISCHARGE
    $SQL = "CALL prod_create_xml_coco_bc_djp('SENTDISCHBC');";
    $result = mysqli_query($connection, $SQL) or die("Query fail: " . mysqli_error());

    $SQL = "CALL prod_create_xml_coco_bc_djp('SENTDISCHDJP');";
    $result = mysqli_query($connection, $SQL) or die("Query fail: " . mysqli_error());

    //LOADING
    $SQL = "CALL prod_create_xml_coco_bc_djp('SENTLOADBC');";
    $result = mysqli_query($connection, $SQL) or die("Query fail: " . mysqli_error());

    $SQL = "CALL prod_create_xml_coco_bc_djp('SENTLOADDJP');";
    $result = mysqli_query($connection, $SQL) or die("Query fail: " . mysqli_error());

    //CODECO OUT
    $SQL = "CALL prod_create_xml_coco_bc_djp('SENTCODOUTBC');";
    $result = mysqli_query($connection, $SQL) or die("Query fail: " . mysqli_error());

    $SQL = "CALL prod_create_xml_coco_bc_djp('SENTCODOUTDJP');";
    $result = mysqli_query($connection, $SQL) or die("Query fail: " . mysqli_error());

    //CODECO IN
    $SQL = "CALL prod_create_xml_coco_bc_djp('SENTCODINBC');";
    $result = mysqli_query($connection, $SQL) or die("Query fail: " . mysqli_error());

    $SQL = "CALL prod_create_xml_coco_bc_djp('SENTCODINDJP');";
    $result = mysqli_query($connection, $SQL) or die("Query fail: " . mysqli_error());

    //GATE IN LINI 2 (IMPOR)
    $SQL = "CALL prod_create_xml_coco_bc_djp('SENTGATEINIMPBC');";
    $result = mysqli_query($connection, $SQL) or die("Query fail: " . mysqli_error());

    $SQL = "CALL prod_create_xml_coco_bc_djp('SENTGATEINIMPDJP');";
    $result = mysqli_query($connection, $SQL) or die("Query fail: " . mysqli_error());

    //GATE OUT LINI 2 (IMPOR)    
    $SQL = "CALL prod_create_xml_coco_bc_djp('SENTGATEOUTIMPBC');";
    $result = mysqli_query($connection, $SQL) or die("Query fail: " . mysqli_error());

    $SQL = "CALL prod_create_xml_coco_bc_djp('SENTGATEOUTIMPDJP');";
    $result = mysqli_query($connection, $SQL) or die("Query fail: " . mysqli_error());

    //GATE IN LINI 2 (EKSPOR)
    $SQL = "CALL prod_create_xml_coco_bc_djp('SENTGATEINEXPBC');";
    $result = mysqli_query($connection, $SQL) or die("Query fail: " . mysqli_error());

    $SQL = "CALL prod_create_xml_coco_bc_djp('SENTGATEINEXPDJP');";
    $result = mysqli_query($connection, $SQL) or die("Query fail: " . mysqli_error());

    //GATE OUT LINI 2 (EKSPOR)
    $SQL = "CALL prod_create_xml_coco_bc_djp('SENTGATEOUTEXPBC');";
    $result = mysqli_query($connection, $SQL) or die("Query fail: " . mysqli_error());

    $SQL = "CALL prod_create_xml_coco_bc_djp('SENTGATEOUTEXPDJP');";
    $result = mysqli_query($connection, $SQL) or die("Query fail: " . mysqli_error());

    $SQL = "CALL create_log_services('" . $CONF['url.wsdl'] . "','" . $method . "" . $SufixMethod . "','" . $xml . "','" . $response . "')";
    $result = mysqli_query($connection, $SQL) or die("Query fail: " . mysqli_error());

    //END
//    $main->connect(false);
    $main->removeFile($filename);
} else {
    echo 'Scheduler sedang berjalan, harap menghapus file ' . $method . '.txt yang ada difolder CheckScheduler.';
}
mysqli_close($connection);
?>