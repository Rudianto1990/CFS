<?php
/*+---------------------------------------------------------------------------------------------------+
  | $Web Service Template$Modul Integrasi$                                                         	  |
  | Author                  : Endang Fiansyah				                                          |
  | Owner                   : IPC				                                                      |
  | Template Created Date	: 22-Des-2a014                                                             |
  | Template Version        : 1.0                                                                     |
  | Library					: nusoap																  |
  | Template File           : index.php register_service.php sql_collection.php db_collection.php     |
  |							  data_collection.php f_testService.php exmp_testService.php			  |
  |---------------------------------------------------------------------------------------------------|
  | $Template Modification History$                                                                   |
  |---------------------------------------------------------------------------------------------------|
  | Modification                                Date                                  Modification By | 
  |---------------------------------------------------------------------------------------------------|

  +---------------------------------------------------------------------------------------------------+
  | Program Unit Name        : request receiving container                                            |
  | Description              : Service pack for tracking container                    			      |
  | Author                   : -                                                        			  |
  | Created Date             : 03-Feb-2015                                                            |
  | Last Update Date         :                                                                        |
  | Version                  : 1.0                                                                    |
  |---------------------------------------------------------------------------------------------------|
  | $Modification History$                                                                            |
  |---------------------------------------------------------------------------------------------------|
  | Modification                                Date                                  Modification By |
  +---------------------------------------------------------------------------------------------------+
  */
error_reporting(0);
//======= LIST OF SERVICE ===============//
//sample basic service
include "f_testService.php";

//======= nusoap library ========//
require_once "lib/nusoap.php";
//======= SQL Collection ========//
require_once "sql_collection.php";
//======= Data Collection ========//
require_once "data_collection.php";
//======= Database Collection ========//
//require_once "db_collection.php";
//echo "1234";
//======= Register Service ========//
require_once "register_service.php";
