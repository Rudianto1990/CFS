<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
//require_once APPPATH."/libraries/PHPExcel.php"; 
require_once(APPPATH.'libraries/PHPExcel'.EXT);
class Newphpexcel_gambar extends PHPExcel_Worksheet_Drawing{
    public function __construct(){ 
        parent::__construct(); 
    }
}