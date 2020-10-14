<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Execute extends Controller {
	public function __construct() {
        parent::__construct();
    }
	
	function process($type="",$act="", $id=""){
		if (!$this->newsession->userdata('LOGGED')) {
			$this->index();
			return;
		}else{
			if (strtolower($_SERVER['REQUEST_METHOD']) != "post") {
				echo 'access is forbidden'; exit();
			}else{
				$this->load->model("m_execute");
				$this->m_execute->process($type,$act,$id);
			}
		}
	}
	
}