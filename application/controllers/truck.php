<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Truck extends Controller {

    var $content = "";

    function Truck() {
        parent::Controller();
    }

    function index() {
		$add_header  = '<link rel="stylesheet" href="'.base_url().'assets/vendor/sweetalert/dist/sweetalert.css">';
		$add_header .= '<link rel="stylesheet" href="'.base_url().'assets/css/app.min.css">';
		$add_header .= '<link rel="stylesheet" href="'.base_url().'assets/css/bootstrap-extend.min.css">';
		$add_header .= '<link rel="stylesheet" href="'.base_url().'assets/css/newtable.css">';
		$add_header .= '<link rel="stylesheet" href="'.base_url().'assets/vendor/themes/twitter/twitter.css">';
		$add_header .= '<link rel="stylesheet" href="'.base_url().'assets/css/jquery-ui.css">';
		$add_header .= '<link rel="stylesheet" href="'.base_url().'assets/css/alerts.css">';
		$add_header .= '<link rel="stylesheet" href="'.base_url().'assets/vendor/bootstrap-datetimepicker/bootstrap-datetimepicker.min.css">';
		$add_header .= '<script src="'.base_url().'assets/js/jquery.min.js"></script>';
		$add_header .= '<script src="'.base_url().'assets/js/jquery-ui.min.js"></script>';
		$add_header .= '<script src="'.base_url().'assets/js/newtable.js"></script>';
		$add_header .= '<script src="'.base_url().'assets/js/main.js"></script>';
		$add_header .= '<script src="'.base_url().'assets/vendor/sweetalert/dist/sweetalert.min.js"></script>';
		$add_header .= '<script src="'.base_url().'assets/vendor/noty/js/noty/packaged/jquery.noty.packaged.min.js"></script>';
		$add_header .= '<script src="'.base_url().'assets/js/helpers/noty-defaults.js"></script>';
		$add_header .= '<script src="'.base_url().'assets/js/alerts.js"></script>';
		$add_script  = '<script src="'.base_url().'assets/js/app.min.js"></script>';
		$add_script .= '<script src="'.base_url().'assets/js/jquery-ui.js"></script>';
		$add_script .= '<script src="'.base_url().'assets/js/ui/notifications.js"></script>';
		$add_script .= '<script src="'.base_url().'assets/vendor/bootstrap-datetimepicker/bootstrap-datetimepicker.min.js"></script>';
		if($this->newsession->userdata('LOGGED')){
			if($this->content==""){
				$this->content = $this->load->view('content/dashboard/index','',true);
			}
			$data = array('_add_header_'   => $add_header,
						  '_add_script_'   => $add_script,
						  '_tittle_'  	   => 'CFS CENTER',
						  '_header_'  	   => $this->load->view('content/header','',true),
						  '_breadcrumbs_'  => $this->load->view('content/breadcrumbs','',true),
						  '_menus_'   	   => $this->load->view('content/menus','',true),
						  '_content_' 	   => (grant()=="")?$this->load->view('content/error','',true):$this->content,
						  '_footer_'  	   => $this->load->view('content/footer','',true),
						  '_features_'     => $this->load->view('content/features','',true));
			$this->parser->parse('index', $data);
		}else{
			redirect(base_url('index.php'),'refresh');
		}
    }

    function execute($type="", $act="", $id="", $met="") {
        if (!$this->newsession->userdata('LOGGED')) {
            $this->index();
            return;
        } else {
            if (strtolower($_SERVER['REQUEST_METHOD']) != "post") {
                redirect(base_url());
                exit();
            } else {
                $this->load->model("m_truck");
                $this->m_truck->execute($type, $act, $id, $met);
            }
        }
    }

    function listdata($act="", $id="") {
        if (!$this->newsession->userdata('LOGGED')) {
            $this->index();
            return;
        }
        $this->load->model('m_truck');
        if ($act == "add") {
            $data['act'] = 'save';
            echo $this->load->view('content/truck/add', $data, true);
        } else if ($act == "edit") {
            $arrid = explode("~", $id);
            $data['act'] = 'update';
            $data['id'] = $id;
            $data['arrhdr'] = $this->m_truck->get_data('trucker', $id);
            echo $this->load->view('content/truck/add', $data, true);
        } else if($act=="detail"){ 
			$arrid = explode("~",$id);
			$data['title'] = 'DATA DETAIL';
			$data['arrdata'] = $this->m_truck->execute('get','t_trucker',$id);
			$data['table_truck'] = $this->table_truck($act,$id);
			echo $this->load->view('content/truck/detail',$data,true);
		}else {
            $arrdata = $this->m_truck->listdata($act, $id);
            $data = $this->load->view('content/newtable', $arrdata, true);
            if ($this->input->post("ajax") || $act == "post") {
                echo $arrdata;
            } else {
                $this->content = $data;
                $this->index();
            }
        }
    }

	function table_truck($act, $id){
		if (!$this->newsession->userdata('LOGGED')) {
			$this->index();
			return;
		}
		$id = ($id!="")?$id:$this->input->post('id');
		$this->load->model("m_truck");
		if ($act == "add") {
            $data['act'] = 'save';
            $data['ID'] = $id;
            echo $this->load->view('content/truck/truck_add', $data, true);
        } else if ($act == "edit") {
            $arrid = explode("~", $id);
            $data['act'] = 'update';
            $data['id'] = $arrid[1];
            $data['arrhdr'] = $this->m_truck->get_data('truck', $arrid[1]);
            echo $this->load->view('content/truck/truck_add', $data, true);
        } else{
			$arrdata = $this->m_truck->table_truck($act, $id);
			$data = $this->load->view('content/newtable', $arrdata, true);
			if($this->input->post("ajax")||$act=="post"){
				return $arrdata;
			}else{
				return $data;
			}
		}
	}
}
