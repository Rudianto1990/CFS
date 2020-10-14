<?php

set_time_limit(3600);
require_once("Libraries/dbLite/DBManager.php");
$conn = new ORA8Access();
$conn->parseURL("db.OCI8://pronsw07:nsw07pro@NSWDB1");
?>