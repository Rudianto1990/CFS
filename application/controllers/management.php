<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Management extends Controller {

    var $content = "";

    function Management() {
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
		$add_script .= '<script src="'.base_url().'assets/js/jquery.validate.js"></script>';
		$add_script .= '<script src="'.base_url().'assets/js/jquery.maskedinput.js"></script>';
		$add_script .= '<script src="'.base_url().'assets/js/messages_id.js"></script>';
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

	public function uname(){
		$uname=array('USERLOGIN' => $this->input->post('USERLOGIN'),'KD_STATUS !=' => 'BLOCKED');
		$queryr = $this->db->get_where('app_user', $uname);
		if($queryr->num_rows() > 0){
			echo 'false';
		}else {
			echo 'true';
		}
	}
	public function umail($id=0){
		if($id!=0){$a='USERLOGIN !=';$b=$this->newsession->userdata('USERLOGIN');}
		else{$a='EMAIL';$b=$this->input->post('EMAIL');}
		$umail=array('EMAIL' => $this->input->post('EMAIL'),'KD_STATUS !=' => 'BLOCKED',$a => $b);
		$queryr = $this->db->get_where('app_user', $umail);
		if($queryr->num_rows() > 0){
			echo 'false';
		}else {
			echo 'true';
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
                $this->load->model("m_management");
                $this->m_management->execute($type, $act, $id, $met);
            }
        }
    }

    function group($act="", $id="") {
        if (!$this->newsession->userdata('LOGGED')) {
            $this->index();
            return;
        }
        $this->load->model('m_management');
        if ($act == "add") {
            $data['act'] = 'save';
            echo $this->load->view('content/management/group', $data, true);
        } else if ($act == "edit") {
            $arrid = explode("~", $id);
            $data['act'] = 'update';
            $data['id'] = $id;
            $data['arrhdr'] = $this->m_management->get_data('group', $id);
            echo $this->load->view('content/management/group', $data, true);
        } else {
            $arrdata = $this->m_management->group($act, $id);
            $data = $this->load->view('content/newtable', $arrdata, true);
            if ($this->input->post("ajax") || $act == "post") {
                echo $arrdata;
            } else {
                $this->content = $data;
                $this->index();
            }
        }
    }

    function menu($act="", $id="") {
        if (!$this->newsession->userdata('LOGGED')) {
            $this->index();
            return;
        }
        $this->load->model('m_management');
        if ($act == "add") {
            $data['act'] = 'save';
            $data['arr_parent'] = $this->m_management->get_combobox('parent');
            echo $this->load->view('content/management/menu', $data, true);
        } else if ($act == "edit") {
            $data['act'] = 'update';
            $data['ID'] = $id;
            $data['arrhdr'] = $this->m_management->get_data('menu', $id);
            $data['arr_parent'] = $this->m_management->get_combobox('parent');
            echo $this->load->view('content/management/menu', $data, true);
        } else {
            $arrdata = $this->m_management->menu($act, $id);
            $data = $this->load->view('content/newtable', $arrdata, true);
            if ($this->input->post("ajax") || $act == "post") {
                echo $arrdata;
            } else {
                $this->content = $data;
                $this->index();
            }
        }
    }

    function hak_akses($act="", $id="") {
        if (!$this->newsession->userdata('LOGGED')) {
            $this->index();
            return;
        }
        $this->load->model('m_management');
        if ($act == "add") {
            $data['act'] = 'save';
            $data['menus'] = $this->m_management->get_data('access_menu');
            echo $this->load->view('content/management/privilege', $data, true);
        } else if ($act == "edit") {
            $data['ID'] = $id;
            $data['act'] = 'update';
            $data['arrhdr'] = $this->m_management->get_data('privilege', $id);
            $data['menus'] = $this->m_management->get_data('access_menu', $id);
            echo $this->load->view('content/management/privilege', $data, true);
        } else {
            $arrdata = $this->m_management->hak_akses($act, $id);
            $data = $this->load->view('content/newtable', $arrdata, true);
            if ($this->input->post("ajax") || $act == "post") {
                echo $arrdata;
            } else {
                $this->content = $data;
                $this->index();
            }
        }
    }

    function groupmenu($act="", $id="") {
        if (!$this->newsession->userdata('LOGGED')) {
            $this->index();
            return;
        }
        $this->load->model('m_management');
        if ($act == "add") {
            $data['act'] = 'save';
            $data['menus'] = $this->m_management->get_data('access_menu');
            echo $this->load->view('content/management/groupmenu', $data, true);
        } else if ($act == "edit") {
            $data['ID'] = $id;
            $data['act'] = 'update';
            $data['arrhdr'] = $this->m_management->get_data('groupmenu', $id);
            $data['menus'] = $this->m_management->get_data('access_groupmenu', $id);
            echo $this->load->view('content/management/groupmenu', $data, true);
        } else {
            $arrdata = $this->m_management->groupmenu($act, $id);
            $data = $this->load->view('content/newtable', $arrdata, true);
            if ($this->input->post("ajax") || $act == "post") {
                echo $arrdata;
            } else {
                $this->content = $data;
                $this->index();
            }
        }
    }

    function privilege_skema($act="", $id="") {
        if (!$this->newsession->userdata('LOGGED')) {
            $this->index();
            return;
        }
        $this->load->model('m_management');
        if ($act == "add") {
            $data['act'] = 'save';
            $data['menus'] = $this->m_management->get_data('access_skema');
            echo $this->load->view('content/management/privilege_skema', $data, true);
        } else if ($act == "edit") {
            $data['ID'] = $id;
            $data['act'] = 'update';
            $data['arrhdr'] = $this->m_management->get_data('privilege_skema', $id);
            $data['menus'] = $this->m_management->get_data('access_skema', $id);
            echo $this->load->view('content/management/privilege_skema', $data, true);
        } else {
            $arrdata = $this->m_management->privilege_skema($act, $id);
            $data = $this->load->view('content/newtable', $arrdata, true);
            if ($this->input->post("ajax") || $act == "post") {
                echo $arrdata;
            } else {
                $this->content = $data;
                $this->index();
            }
        }
    }

    function user($act="", $id="") {
        if (!$this->newsession->userdata('LOGGED')) {
            $this->index();
            return;
        }/* else{
			return redirect(site_url());
		} */
        $this->load->model('m_management');
        if ($act == "add") {
            $data['act'] = 'save';
            $data['arr_group'] = $this->m_management->get_combobox('group');
            echo $this->load->view('content/management/user', $data, true);
        } else if ($act == "edit") {
            $data['ID'] = $id;
            $data['act'] = 'update';
            $data['arr_group'] = $this->m_management->get_combobox('group');
            $data['arrhdr'] = $this->m_management->get_data('user', $id);
            echo $this->load->view('content/management/user', $data, true);
        } else {
            $arrdata = $this->m_management->user($act, $id);
            $data = $this->load->view('content/newtable', $arrdata, true);
            if ($this->input->post("ajax") || $act == "post") {
                echo $arrdata;
            } else {
                $this->content = $data;
                $this->index();
            }
        }
    }

    function newuser($act="", $id="") {
        if (!$this->newsession->userdata('LOGGED')) {
            $this->index();
            return;
        }
        $this->load->model('m_management');  
        if ($act == "detail") {
            $arrid = explode("~",$id);
            $data['title'] = 'DATA DETAIL';
            $data['arrhdr'] = $this->m_management->execute('detail','user',$id);
            echo $this->load->view('content/management/detailuser',$data,true);

        }else if ($act == "reject") {
            $arrid = explode("~",$id);
            $data['title'] = 'DATA DETAIL';
            $data['ID'] = $id;
            $data['arrhdr'] = $this->m_management->execute('detail','user',$id);

            echo $this->load->view('content/management/reject',$data,true);
        }else{    
            $arrdata = $this->m_management->newuser($act, $id);
            $data = $this->load->view('content/newtable', $arrdata, true);
            if ($this->input->post("ajax") || $act == "post") {
                echo $arrdata;
            } else {
                $this->content = $data;
                $this->index();
            } 
        }       
    }

    function organisasi($act="", $id="") {
        if (!$this->newsession->userdata('LOGGED')) {
            $this->index();
            return;
        }
        $this->load->model('m_management');
        if ($act == "add") {
            $data['act'] = 'save';
            $data['arr_tipe'] = $this->m_management->get_combobox('tipe');
            echo $this->load->view('content/management/organisasi', $data, true);
        } else if ($act == "edit") {
            $arrid = explode("~", $id);
            $data['ID'] = $id;
            $data['act'] = 'update';
            $data['arr_tipe'] = $this->m_management->get_combobox('tipe');
            $data['arrhdr'] = $this->m_management->get_data('organisasi', $id);
            echo $this->load->view('content/management/organisasi', $data, true);
        } else {
            $arrdata = $this->m_management->organisasi($act, $id);
            $data = $this->load->view('content/newtable', $arrdata, true);
            if ($this->input->post("ajax") || $act == "post") {
                echo $arrdata;
            } else {
                $this->content = $data;
                $this->index();
            }
        }
    }

    function password($act, $id) {
        if (!$this->newsession->userdata('LOGGED')) {
            $this->index();
            return;
        }
        $this->newtable->breadcrumb('Home', site_url());
        $this->newtable->breadcrumb('User Management', 'javascript:void(0)');
        $this->newtable->breadcrumb('Edit Password', 'javascript:void(0)');
        $this->content = $this->load->view('content/management/password', '', true);
        $this->index();
    }

    function user_profile($act, $id) {
        if (!$this->newsession->userdata('LOGGED')) {
            $this->index();
            return;
        }
        $this->load->model('m_management');
        $ID_USR = $this->newsession->userdata('ID');
        $ID_ORG = $this->newsession->userdata('KD_ORGANISASI');
        $this->newtable->breadcrumb('Home', site_url());
        $this->newtable->breadcrumb('User Management', 'javascript:void(0)');
        $this->newtable->breadcrumb('Edit Profile', 'javascript:void(0)');
        $data['arr_org'] = $this->m_management->get_data('profile', $ID_ORG);
        $data['arr_usr'] = $this->m_management->get_data('user_profile', $ID_USR);
        $this->content = $this->load->view('content/management/user_profile', $data, true);
        $this->index();
    }

    function log_act($act="", $id="") {
        if (!$this->newsession->userdata('LOGGED')) {
            $this->index();
            return;
        }
        $this->load->model('m_management');
        $arrdata = $this->m_management->log_act($act, $id);
        $data = $this->load->view('content/newtable', $arrdata, true);
        if ($this->input->post("ajax") || $act == "post") {
            echo $arrdata;
        } else {
            $this->content = $data;
            $this->index();
        }
    }

}
