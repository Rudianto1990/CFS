<?php
/*+---------------------------------------------------------------------------------------------------+
  | $Web Service Template$                                                         					  |
  | Author                  : -                                                         			  |
  | Template Created Date	: 22-Des-2014                                                             |
  | Template Version        : 1.0                                                                     |
  |---------------------------------------------------------------------------------------------------|
  | $Template Modification History$                                                                   |
  |---------------------------------------------------------------------------------------------------|
  | Modification                                Date                                  Modification By | 
  |---------------------------------------------------------------------------------------------------|
  */

//======= DB Collection ========//
function oriDb($connection_group_name="") 
{
	//setup oracle db connection
	/*++++ DEVELOPMENT ++++++*/
	switch($connection_group_name)
	{
		case "BILLING_IDJKT_L2I":
			$conn['billing'] = oci_connect('BILLING_OBX', 'billing_OBX', '192.168.23.26:1521/DBDEV');
		break;
		case "CONTAINER_IDJKT_L2I":
			$conn['container'] = oci_connect('LINEOS', 'ligneOS', '192.168.23.26:1521/DBDEV');
		break;		
		case "BILLING_IDJKT_L2D":
			$conn['billing'] = oci_connect('BILLING_OBX', 'billing_OBX', '192.168.23.26:1521/DBDEV');
		break;
		case "CONTAINER_IDJKT_L2D":
			$conn['container'] = oci_connect('LINEOS', 'ligneOS', '192.168.23.26:1521/DBDEV');
		break;		
		case "BILLING_IDJKT_T3I":
			$conn['billing'] = oci_connect('BILLING', 'billingdesember2014', '10.10.12.214:1521/tosdbqa');
		break;
		case "CONTAINER_IDJKT_T3I":
			$conn['container'] = oci_connect('OPUS_REPO', 'opus_repo', '10.10.12.214:1521/tosdbqa');
		break;
		case "BILLING_IDJKT_T3D":
			$conn['billing'] = oci_connect('ITOS_BILLING', 'itos_BILLING', '192.168.23.26:1521/DBDEV');
		break;
		case "CONTAINER_IDJKT_T3D":
			$conn['container'] = oci_connect('ITOS_REPO', 'itos_REPO', '192.168.23.26:1521/DBDEV');
		break;
		case "BILLING_IDJKT_T2D":
			$conn['billing'] = oci_connect('ITOS_BILLING', 'itos_BILLING', '192.168.23.26:1521/DBDEV');
		break;
		case "CONTAINER_IDJKT_T2D":
			$conn['container'] = oci_connect('ITOS_REPO', 'itos_REPO', '192.168.23.26:1521/DBDEV');
		break;
		case "BILLING_IDJKT_T1D":
			$conn['billing'] = oci_connect('ITOS_BILLING', 'itos_BILLING', '192.168.23.26:1521/DBDEV');
		break;
		case "CONTAINER_IDJKT_T1D":
			$conn['container'] = oci_connect('ITOS_REPO', 'itos_REPO', '192.168.23.26:1521/DBDEV');
		break;
		case "BILLING_IDPNK_T3I":
			$conn['billing'] = oci_connect('BILLING', 'billing', '192.168.29.88:1521/PNKDBT');
		break;
		case "CONTAINER_IDPNK_T3I":
			$conn['container'] = oci_connect('OPUS_REPO', 'opus_repo', '192.168.29.88:1521/PNKDBT');
		break;
		case "CONTAINER_IDJKT_T009D":
			$conn['container'] = oci_connect('OPUS_REPO', 'opus_repo', '192.168.29.88:1521/MTDBT');
		break;
		case "BILLING_IDJKT_T009D":
			$conn['billing'] = oci_connect('BILLING', 'billingptpdom', '192.168.29.88:1521/MTDBT');
		break;
		case "BILLING_IDPNJ_PNJD":
			$conn['billing'] = oci_connect('billing', 'billing', '10.10.12.214/PJGDBT');
		break;
		case "CONTAINER_IDPNJ_PNJD":
			$conn['container'] = oci_connect('OPUS_REPO', 'opus_repo', '10.10.12.214/PJGDBT');
		break;	
		case "BILLING_IDPNJ_PNJI":
			$conn['billing'] = oci_connect('billing', 'billing', '10.10.12.214/PJGDBT');
		break;
		case "CONTAINER_IDPNJ_PNJI":
			$conn['container'] = oci_connect('OPUS_REPO', 'opus_repo', '10.10.12.214/PJGDBT');
		break;		
		case "BILLING_IDPNJ_PNJI":
			$conn['billing'] = oci_connect('billing', 'billing', '10.10.12.214/PJGDBT');
		break;
		case "CONTAINER_IDPNJ_PNJI":
			$conn['container'] = oci_connect('OPUS_REPO', 'opus_repo', '10.10.12.214/PJGDBT');
		break;		
		case "CONTAINER_91_201":
			$conn['container'] = oci_connect('NPK_TOS_REPO', 'npkt0s_Rep0', '10.10.12.214:1521/PELDB');
		break;
		case "BILLING":
			$conn['billing_idjkt_t3i'] = oci_connect('BILLING', 'billingdesember2014', '10.10.12.214:1521/tosdbqa');
			$conn['billing_idjkt_t3d'] = oci_connect('ITOS_BILLING', 'itos_BILLING', '192.168.23.26:1521/DBDEV');
			$conn['billing_idjkt_t2d'] = oci_connect('ITOS_BILLING', 'itos_BILLING', '192.168.23.26:1521/DBDEV');
			$conn['billing_idjkt_t1d'] = oci_connect('ITOS_BILLING', 'itos_BILLING', '192.168.23.26:1521/DBDEV');
			$conn['billing_idjkt_t009d'] = oci_connect('BILLING', 'billingptpdom', '192.168.29.88:1521/MTDBT');		
			$conn['billing_idpnj_pnjd'] = oci_connect('billing', 'billing', '10.10.12.214/PJGDBT');
			$conn['billing_idpnj_pnji'] = oci_connect('billing', 'billing', '10.10.12.214/PJGDBT');
		break;
		case "CONTAINER":
			$conn['container_idjkt_t3i'] = oci_connect('OPUS_REPO', 'opus_repo', '192.168.29.88:1521/TOSDBTEST'); 
			$conn['container_idjkt_t3d'] = oci_connect('ITOS_REPO', 'itos_REPO', '192.168.23.26:1521/DBDEV');
			$conn['container_idjkt_t2d'] = oci_connect('ITOS_REPO', 'itos_REPO', '192.168.23.26:1521/DBDEV');
			$conn['container_idjkt_t1d'] = oci_connect('ITOS_REPO', 'itos_REPO', '192.168.23.26:1521/DBDEV');
			$conn['container_idpnk_t3i'] = oci_connect('OPUS_REPO', 'opus_repo', '192.168.29.88:1521/PNKDBT');
			$conn['container_idpnj_pnjd'] = oci_connect('OPUS_REPO', 'opus_repo', '10.10.12.214/PJGDBT');
			$conn['container_idpnj_pnji'] = oci_connect('OPUS_REPO', 'opus_repo', '10.10.12.214/PJGDBT');
			$conn['container_idjkt_l2'] = oci_connect('LINEOS', 'ligneOS', '192.168.23.26:1521/DBDEV');
		break;		
		case "IBIS":
			$conn['ibis'] = oci_connect('IBIS', 'ibis123', '10.10.32.85:1521/ESERVICEDB');
		break;	
		default :
			$conn['container_idjkt_t3i'] = oci_connect('OPUS_REPO', 'opus_repo', '192.168.29.88:1521/TOSDBTEST');
			$conn['container_idjkt_t3d'] = oci_connect('ITOS_REPO', 'itos_REPO', '192.168.23.26:1521/DBDEV');
			$conn['container_idjkt_t2d'] = oci_connect('ITOS_REPO', 'itos_REPO', '192.168.23.26:1521/DBDEV');
			$conn['container_idjkt_t1d'] = oci_connect('ITOS_REPO', 'itos_REPO', '192.168.23.26:1521/DBDEV');
			$conn['container_idpnk_t3i'] = oci_connect('OPUS_REPO', 'opus_repo', '192.168.29.88:1521/PNKDBT');
			$conn['container_idpnj_pnjd'] = oci_connect('OPUS_REPO', 'opus_repo', '10.10.12.214/PJGDBT');
			$conn['container_idpnj_pnji'] = oci_connect('OPUS_REPO', 'opus_repo', '10.10.12.214/PJGDBT');
			$conn['container_idjkt_l2'] = oci_connect('LINEOS', 'ligneOS', '192.168.23.26:1521/DBDEV');
			$conn['billing_idjkt_t3i'] = oci_connect('BILLING', 'billing', '192.168.29.88:1521/TOSDBTEST');
			$conn['billing_idjkt_t3d'] = oci_connect('ITOS_BILLING', 'itos_BILLING', '192.168.23.26:1521/DBDEV');
			$conn['billing_idjkt_t2d'] = oci_connect('ITOS_BILLING', 'itos_BILLING', '192.168.23.26:1521/DBDEV');
			$conn['billing_idjkt_t1d'] = oci_connect('ITOS_BILLING', 'itos_BILLING', '192.168.23.26:1521/DBDEV');
			$conn['billing_idpnk_t3i'] = oci_connect('BILLING', 'billing', '192.168.29.88:1521/PNKDBT');
			$conn['ibis'] = oci_connect('IBIS', 'ibis123', '10.10.32.85:1521/ESERVICEDB');
			$conn['container_idjkt_t009d'] = oci_connect('OPUS_REPO', 'opus_repo', '192.168.29.88:1521/MTDBT');
			$conn['billing_idjkt_t009d'] = oci_connect('BILLING', 'billingptpdom', '192.168.29.88:1521/MTDBT');
			$conn['billing_idpnj_pnjd'] = oci_connect('billing', 'billing', '10.10.12.214/PJGDBT');
			$conn['billing_idpnj_pnji'] = oci_connect('billing', 'billing', '10.10.12.214/PJGDBT');
		break;
	}

	return $conn;
}

function oriDb2() 
{
	//setup oracle db connection
	$conn['kapal'] = oci_connect('KAPAL_PROD', 'KAPAL_PROD', '10.10.12.218:1521/PELDB');
	
	return $conn;
}

function mysqlDb()
{
	//setup mysql db connection
	return $conn;
}

//======= Close Database Connection Collection ========// 
function closeOriDb($conn)
{
	foreach ($conn as $key => $value) 
		oci_close($conn[$key]);
	
	return true;
}

//======= Check Database Connection Collection ========// 
function checkOriDb($conn,&$err)
{

	foreach ($conn as $key => $value) 
	{
		if (!$conn[$key]) 
			$err .= "connection to $key failed;";
	}
	
	if($err!="")
		return false;
	
	return true;
}

//======= Check Database Connection Collection ========// 
function checkOriSQL($conn,$sql,&$query,&$err,&$bind_param=array())
{
	$query = oci_parse($conn, $sql);

	foreach ($bind_param as $key => $value) {
		oci_bind_by_name($query, $key, &$bind_param[$key],1000);
	}
	
	if (!oci_execute($query,OCI_DEFAULT))
	{
		$e = oci_error($query);
		
		if(!getDebugMode2())
			$sql = "";
			
		$err = "Database problem;".$e['message'].";$sql";
		
		return false;
	}

	if(getDebugMode())
		$message .= $sql.";<br><br>\n\n";

	return true;
}

//======= Check Database Connection Collection , AUTOCOMMIT ON========// 
function checkOriSQLAutoCommit($conn,$sql,&$query,&$err,&$bind_param=array())
{
	$query = oci_parse($conn, $sql);

	foreach ($bind_param as $key => $value) {
		oci_bind_by_name($query, $key, &$bind_param[$key],1000);
	}
	
	if (!oci_execute($query))
	{
		$e = oci_error($query);
		
		if(!getDebugMode2())
			$sql = "";
			
		$err = "Database problem;".$e['message'].";$sql";
		
		return false;
	}

	if(getDebugMode())
		$message .= $sql.";<br><br>\n\n";
	
	return true;
}

function rollbackOriDb($conn)
{
	foreach ($conn as $key => $value) 
	{
		oci_rollback($conn[$key]);
	}
}

function commitOriDb($conn)
{
	foreach ($conn as $key => $value) 
	{
		oci_commit($conn[$key]);
	}
}
?>