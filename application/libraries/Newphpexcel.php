<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
//require_once APPPATH."/libraries/PHPExcel.php"; 
require_once(APPPATH.'libraries/PHPExcel'.EXT);
class Newphpexcel extends PHPExcel{
    public function __construct(){ 
        parent::__construct(); 
    }
	
	function set_font($fonts,$size){
		PHPExcel::getDefaultStyle()->getFont()->setName($fonts)->setSize($size);
	}
	
	function headers(){
		return array('font' 		=> 	array('bold' 		=> true),
					 'borders' 		=> 	array('top' 		=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
										      'right' 		=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
										      'left'		=> array('style' => PHPExcel_Style_Border::BORDER_THIN)),
					 'fill' 		=> 	array('type'		=> (PHPExcel_Style_Fill::FILL_SOLID),
										  	  'color'		=> array('rgb' => 'C0C0C0')),
					 'alignment'	=> 	array('vertical' 	=> PHPExcel_Style_Alignment::VERTICAL_TOP));
	}	
	
	function left(){
		return array('alignment'	=> 	array('vertical' 	=> PHPExcel_Style_Alignment::VERTICAL_TOP),
											  'borders' 	=> array('top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
											  'right' 		=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
											  'left'		=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
											  'bottom'		=> array('style' => PHPExcel_Style_Border::BORDER_THIN)));
	}
	
	function right(){
		return array('alignment' 	=> 	array('vertical'	=> PHPExcel_Style_Alignment::VERTICAL_TOP),
											  'borders' 	=> array('top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
											  'right' 		=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
											  'left' 		=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
											  'bottom' 		=> array('style' => PHPExcel_Style_Border::BORDER_THIN)));
	}
	
	function headings($heading = NULL){
		foreach($heading as $head){
			PHPExcel::getActiveSheet()->getStyle($head)->applyFromArray($this->headers());
		}
		return;
	}
	
	function set_detilstyle($detils = NULL){
		foreach($detils as $detil){
			PHPExcel::getActiveSheet()->getStyle($detil)->applyFromArray($this->left());
		}
		return;
	}
	
	function set_detilnull($index = "",$detil = NULL, $text = ""){
		$this->mergecell($detil, TRUE)->getStyle($detil)->applyFromArray($this->left());
		PHPExcel::setActiveSheetIndex($index)->setCellValue($detil[0], $text);
	}
	
	function width($width = NULL){
		foreach($width as $c => $w){
			PHPExcel::getActiveSheet()->getColumnDimension($w[0])->setWidth($w[1]);
		}
		return;
	}
	
	function mergecell($merge = NULL, $center=TRUE){
		foreach($merge as $start => $end){
			PHPExcel::getActiveSheet()->mergeCells($end[0].':'.$end[1]);
			if($center) PHPExcel::getActiveSheet()->getStyle($end[0].':'.$end[1])->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		}
		return;
	}
	
	function set_bold($cols = NULL){
		foreach($cols as $col){
			PHPExcel::getActiveSheet()->getStyle($col)->applyFromArray(array('font' => array('bold' => true)));
		}
		return;
	}
	
	function set_wrap($colwraps = NULL){
		foreach($colwraps as $colw){
			PHPExcel::getActiveSheet()->getStyle($colw)->getAlignment()->setWrapText(true);
		}
		return;
	}
	
	function set_title($title){
		PHPExcel::getActiveSheet()->setTitle($title);
	}
	
	function set_number($columns = NULL){
		foreach($columns as $col){
			PHPExcel::getActiveSheet()->getStyle($col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
		}
		return;
	}
	
	function set_percent($columns = NULL){
		foreach($columns as $col){
			PHPExcel::getActiveSheet()->getStyle($col)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE);
		}
		return;
	}
}