<?php
require_once("DBAccess.php");

/**
 * author gusto(watonist@telkom.net)
 *
 * db connection URL : db://user:password@OCI8/
 */
class ORA8Access extends DBAccess{
  var $_sid = "";
  var $_autoCommit = false;

  function ORA8Access(){
  }

  function parseURL($url){
    parent::parseURL($url);
    $this->_sid = parent::getHost();
  }

  function setSID($sid){
    $this->_sid = $sid;
  }

  function getSID(){
    return $this->_sid;
  }

  function connect(){
    if(strtoupper($this->dbType) != "OCI8") return false;
    if($this->isConnect) return true;
    if($this->_sid == ""){
      $this->connection = ocilogon(parent::getUser(), parent::getPassword());
    }else{
      $this->connection = ocilogon(parent::getUser(), parent::getPassword(), $this->getSID());
    }

    if(!$this->connection){
      $this->isConnect = false;
    }else{
      $this->isConnect = true;
    }

    return $this->isConnect;
  }

  function disconnect(){
    if(!$this->isConnect) return true;

    ocilogoff($this->connection);
    $this->isConnect = false;
    return true;
  }

  function execute($SQLCmd){
    if(!$this->isConnect) return false;

    $stmt = ociparse($this->connection, $SQLCmd);
    $stat = ociexecute($stmt, OCI_DEFAULT);

    if($this->_autoCommit){
      $this->commit();
    }

    return $stat;
  }

  function query($SQLCmd){
    if(!$this->isConnect) return;

    $stmt = ociparse($this->connection, $SQLCmd);
    $stat = ociexecute($stmt, OCI_DEFAULT);

    $results = array();
    $nrows = oci_fetch_all($stmt, $results, 0, -1, OCI_FETCHSTATEMENT_BY_COLUMN);
    $rs = new ResultSet();
    $rs->setHolder($results);

    oci_free_statement($stmt);

    return $rs;
  }

  function autoCommit(){
    if(!$this->isConnect) return false;
    $this->_autoCommit = true;
    return true;
  }

  function noAutoCommit(){
    if(!$this->isConnect) return false;
    $this->_autoCommit = false;
    return true;
  }

  function commit(){
    if(!$this->isConnect) return false;
    return ocicommit($this->connection);
  }

  function rollback(){
    if(!$this->isConnect) return false;
    return ocirollback($this->connection);
  }

}

?>