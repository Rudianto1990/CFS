<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Autocomplete extends Controller {
    var $content = "";
    function Autocomplete() {
       parent::Controller();
    }

    function index(){
    	show_404();
    }

    function status($type,$act,$get){
    	if (!$this->newsession->userdata('LOGGED')) {
			$this->index();
			return;
		}
		$this->load->model("m_status");
		$this->m_status->autocomplete($type,$act,$get);
    }

    function ppbarang($type,$act,$get){
    	if (!$this->newsession->userdata('LOGGED')) {
			$this->index();
			return;
		}
		$this->load->model("m_order");
		$this->m_order->autocomplete($type,$act,$get);
    }

    function dokumen($type,$act,$get){
    	if (!$this->newsession->userdata('LOGGED')) {
			$this->index();
			return;
		}
		$this->load->model("m_dokumen");
		$this->m_dokumen->autocomplete($type,$act,$get);
    }

    function signup_cek($act,$get){
        $this->load->model("m_home");
        $this->m_home->autocomplete($act,$get);
    }


        function management($type,$act,$get){
        if (!$this->newsession->userdata('LOGGED')) {
            $this->index();
            return;
        }
        $this->load->model("m_management");
        $this->m_management->autocomplete($type,$act,$get);
    }


}