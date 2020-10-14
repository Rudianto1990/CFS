<?php
require_once("DBAccess.php");
require_once("ORAAccess.php");
require_once("ORA8Access.php");
require_once("PGAccess.php");
require_once("MySQLAccess.php");

/**
 * author gusto(watonist@telkom.net)
 */
class DBManager extends DBAccess{
  var $DB_UNKNOWN = 0;
  var $DB_ORACLE = 1;
  var $DB_ORACLE8 = 2;
  var $DB_POSTGRES = 3;
  var $DB_MYSQL = 4;

  var $_mode = 0;
  var $_tmpConn;

  function DBManager(){
    $nArgs = func_num_args();

    if($nArgs <= 0){
    }else if($nArgs == 1){
      $this->_mode = func_get_arg(0);
    }

    $this->init();
  }

  function setMode($mode){
    $this->_mode = func_get_arg(0);
  }

  function init(){
    if($this->_mode == $this->DB_UNKNOWN){
      $this->_tmpConn = new DBAccess();
    }else if($this->_mode == $this->DB_ORACLE){
      $this->_tmpConn = new ORAAccess();
    }else if($this->_mode == $this->DB_ORACLE8){
      $this->_tmpConn = new ORA8Access();
    }else if($this->_mode == $this->DB_POSTGRES){
      $this->_tmpConn = new PGAccess();
    }else if($this->_mode == $this->DB_MYSQL){
      $this->_tmpConn = new MySQLAccess();
    }
  }

  /**
   * ORACLE Connection only
   */
  function setSID($sid){
    if($this->_mode == $this->DB_ORACLE){
      return $this->_tmpConn->setSID($sid);
    }else if($this->_mode == $this->DB_ORACLE8){
      return $this->_tmpConn->setSID($sid);
    }
  }

  /**
   * PostgreSQL & MySQL connection only
   */
  function setDBName($name){
    if($this->_mode == $this->DB_POSTGRES){
      return $this->_tmpConn->setDBName($name);
    }else if($this->_mode == $this->DB_MYSQL){
      return $this->_tmpConn->setDBName($name);
    }
  }

  // common
  function parseURL($url){
    $this->_tmpConn->parseURL($url);
  }

  function connect(){
    $this->_tmpConn->connect();
    $this->isConnect = $this->_tmpConn->isConnect;
	if(!$this->isConnect){print($this->page_error_connection());die();}
    return $this->isConnect;
  }
  
  function page_error_connection($center=false){
  	global $CONF;
	$class = "border:1px dashed #BBB;padding:5px 10px;font-weight:bold;";
	$class .= "background: #EEE; color: #000;";
	if($center){$style="margin-top:210px;";}
	
	$content = "<head><title>".$CONF['title_header']."</title></head>";
	$content.="<body>";
	$content.="<div align=\"center\" style=\"".$style."\">";
	$content.="<div style=\"width:300px;text-align:center;".$class."\">";
	$content.="<h3>Error : Koneksi terputus.</h3><h3>Silahkan coba kembali.</h3>";
	$content.="</div>";
	$content.="</div>";
	$content.="</body>";
	return $content;
  }

  function disconnect(){
    $this->_tmpConn->disconnect();
    $this->isConnect = $this->_tmpConn->isConnect;
  }

  function execute($SQLCmd){
    return $this->_tmpConn->execute($SQLCmd);
  }

  function query($SQLCmd){
    return $this->_tmpConn->query($SQLCmd);
  }

  function autoCommit(){
    return $this->_tmpConn->autoCommit();
  }

  function noAutoCommit(){
    return $this->_tmpConn->disconnect();
  }

  function commit(){
    return $this->_tmpConn->commit();
  }

  function rollback(){
    return $this->_tmpConn->rollback();
  }

}

$DB_MANAGER = new DBManager();
?>