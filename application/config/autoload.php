<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//$autoload['libraries'] = array('database', 'session', 'parser', 'pagination');
ob_start();
$autoload['libraries'] = array('database', 'session', 'newsession', 'parser', 'pagination', 'fungsi','newtable');
$autoload['helper'] = array('url', 'array', 'form', 'cookie','function','menus','file');
$autoload['plugin'] = array();
$autoload['config'] = array();
$autoload['language'] = array();
$autoload['model'] = array();