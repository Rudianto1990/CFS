<?php
/**
 * author gusto(watonist@telkom.net)
 */

require_once("org/pvt/db/DBManager.php");

error_reporting(E_ALL);

/**
  Short course

  first you must initialize new database connection handler,
  you can do it commonly via DBManager like this below

  $db = new DBManager($DB_MANAGER->DB_ORACLE);

   or you can use specific database connection handler like this

  $db = $db = new ORAAccess();

  then you must set the environments needed for the connection,
  here it does

  $db->setUser("flexim");
  $db->setPassword("flexim");
  $db->setSID("flexim"); // for oracle
  $db->setHost("192.168.1.11:5432");
  $db->setDBName("flextor"); // for postgres and mysql

  and so on. it wasn't documented well yet, i wish i can do it soon.

  to connect to database, you can call

  $db->connect();

  for now you can execute SQL command with this

  $result = $db->execute("INSERT INTO bla... bla....");

    or

  $resultset = $db->query("SELECT * from bla.. bla.. bla..");

  there are few differences between execute and query method.
  execute method just return TRUE/FALSE to indicate that the
  execution success or not, but query return null on unsuccessfull
  execution and return a ResultSet on a successfull execution.
  what is ResultSet ?
   ResultSet is an object for handling database query result.
  how i can do this ?
   these are some example

     $rowSize = $resultsets->size();
     $columnSize = $resultsets->columnSize();

   or

    $counter = 0;
    while($resultsets->next()){
      $counter++;
      echo $resultsets->get(0)." ";
      echo $resultsets->get(1)." ";
      echo $resultsets->get("name")."<br>";
    }

   or

    for($i=0;$i<$resultsets->size();$i++){
      echo $resultsets->get($i, 0)." ";
      echo $resultsets->get($i, 1)." ";
      echo $resultsets->get($i, "name")."<br>";
    }

  and so on.

  after all, you can disconnect the database connection by yourself,
  or let the system do it automatically when script terminated.

  thats all =)
*/

/**
 CONNECTING TO DATABASE
 choose one of these connection method below
*/
/*
$db = new DBManager($DB_MANAGER->DB_ORACLE);
$db->setUser("flexim");
$db->setPassword("flexim");
$db->setSID("flexim");
$db->connect();
$SQLCmd = "select cdr_id, mdn, start_time from t_cdr";
*/
/*
$db = new ORAAccess();
$db->setUser("flexim");
$db->setPassword("flexim");
$db->setSID("flexim");
$db->connect();
$SQLCmd = "select cdr_id, mdn, start_time from t_cdr";
*/
/*
$db = new DBManager($DB_MANAGER->DB_ORACLE8);
$db->setUser("flexim");
$db->setPassword("flexim");
$db->setSID("flexim");
$db->connect();
$SQLCmd = "select cdr_id, mdn, start_time from t_cdr";
*/
/*
$db = new ORA8Access();
$db->setUser("flexim");
$db->setPassword("flexim");
$db->setSID("flexim");
$db->connect();
$SQLCmd = "select cdr_id, mdn, start_time from t_cdr";
*/
/*
$db = new DBManager($DB_MANAGER->DB_POSTGRES);
$db->setHost("192.168.1.11:5432");
$db->setUser("inms_md");
$db->setPassword("rahasia");
$db->setDBName("flextor");
$db->connect();
$SQLCmd = "select id, name, value from xmlconf";
*/
/*
$db = new PGAccess();
$db->setHost("192.168.1.11");
$db->setPort(5432);
$db->setUser("inms_md");
$db->setPassword("rahasia");
$db->setDBName("flextor");
$db->connect();
$SQLCmd = "select id, name, value from xmlconf";
*/
/*
$db = new DBManager($DB_MANAGER->DB_MYSQL);
$db->setHost("192.168.1.11");
$db->setUser("admin");
$db->setPassword("admin");
$db->setDBName("mambo");
$db->connect();
$SQLCmd = "select  id, menutype, name from mos_menu";
*/
/*
$db = new MySQLAccess();
$db->setHost("192.168.1.11");
$db->setUser("admin");
$db->setPassword("admin");
$db->setDBName("mambo");
$db->connect();
$SQLCmd = "select  id, menutype, name from mos_menu";
*/
$db = new DBManager($DB_MANAGER->DB_ORACLE8);
$db->parseURL("db.oci8://reward:reward2005@flexim");
$db->connect();
$SQLCmd = "select * from watch";

if(!$db->isConnect){
  echo "not connected<br>";
}

/* Querying Database */
$resultsets = $db->query($SQLCmd);

echo "Result Count = ".$resultsets->size()." column = ".$resultsets->columnSize()."<br>";

$counter = 0;
while($resultsets->next()){
  $counter++;
  echo $counter." ";
  echo $resultsets->get(0)." ";
  echo $resultsets->get(1)." ";
  echo $resultsets->get(2)."<br>";
}

/* DISCONNECT */
$db->disconnect();
?>