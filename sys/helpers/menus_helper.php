<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if ( ! function_exists('menu_content')){
	function menu_content(){
		$content = "";
		$data = array();
		$ci =& get_instance();
		$ci->load->database();
		$segs = substr($ci->uri->slash_segment(1).$ci->uri->slash_segment(2),0,-1);

		if(($ci->newsession->userdata('TIPE_ORGANISASI')=="SPA")&&($ci->newsession->userdata('KD_GROUP')=="SPA")){
			$SQL = "SELECT B.ID, B.ID_PARENT, B.JUDUL_MENU, B.URL, B.URL_CI, B.URUTAN, B.TIPE, B.TARGET,
					B.ACTION, B.CLS_ICON AS ICON
					FROM app_menu B WHERE B.URUTAN != 0
					ORDER BY B.ID_PARENT, B.URUTAN ASC";
		}else{
			$SQL = "SELECT * FROM (
						SELECT B.ID, B.ID_PARENT, B.JUDUL_MENU, B.URL, B.URL_CI, B.URUTAN, B.TIPE, B.TARGET, B.ACTION, B.CLS_ICON AS ICON
						FROM app_group_menu A
						INNER JOIN app_menu B ON A.KD_MENU = B.ID
						WHERE B.URUTAN != 0 AND A.KD_GROUP= '".$ci->newsession->userdata('KD_GROUP')."' AND A.KD_TIPE_ORGANISASI= '".$ci->newsession->userdata('TIPE_ORGANISASI')."'
						UNION
						SELECT BU.ID, BU.ID_PARENT, BU.JUDUL_MENU, BU.URL, BU.URL_CI, BU.URUTAN, BU.TIPE, BU.TARGET, BU.ACTION, BU.CLS_ICON AS ICON
						FROM app_user_menu AU
						INNER JOIN app_menu BU ON AU.KD_MENU = BU.ID
						WHERE BU.URUTAN != 0 AND AU.KD_USER = '" .$_SESSION['ID']. "'
					)X
					ORDER BY X.ID_PARENT, X.URUTAN ASC;";
					//echo $SQL;die();

			/*$SQL = "SELECT B.ID, B.ID_PARENT, B.JUDUL_MENU, B.URL, B.URL_CI, B.URUTAN, B.TIPE, B.TARGET,
					B.ACTION, B.CLS_ICON AS ICON
					FROM app_user_menu A
					INNER JOIN app_menu B ON A.KD_MENU = B.ID
					WHERE A.KD_USER = '" .$_SESSION['ID']. "'
					ORDER BY B.ID_PARENT, B.URUTAN ASC"; 	*/
		}

		$result = $ci->db->query($SQL);
		if($result->num_rows() > 0){
			foreach($result->result_array() as $row){
				if($row['ID_PARENT'] == "")
					$parent_id = 0;
				else
					$parent_id = $row['ID_PARENT'];
				$data[$parent_id][] = array("ID" => $row['ID'],
											"ID_PARENT"	 => $row['ID_PARENT'],
											"JUDUL_MENU" => $row['JUDUL_MENU'],
											"URL"	 	 => $row['URL'],
											"URL_CI"	 => $row['URL_CI'],
											"URUTAN" 	 => $row['URUTAN'],
											"TIPE"	 	 => $row['TIPE'],
											"TARGET"	 => $row['TARGET'],
											"ACTION"	 => $row['ACTION'],
											"ICON"	 	 => $row['ICON']
											);
			}
			$content .= get_menu($data,$segs);
		}
		return $content;
	}
}

if(!function_exists('get_menu')){
	function get_menu($data=array(),$segs,&$parent=0){
		$html = "";
		$child = "";
		if($data[$parent]){
			for($c=0; $c<count($data[$parent]); $c++){
				$child = get_menu($data, $segs, $data[$parent][$c]['ID']);
				if($data[$parent][$c]["TYPE"]=="F"){
					$href = "javascript:void(0)";
				}else{
					if($data[$parent][$c]["TARGET"]=="_BLANK"){
						$href = $data[$parent][$c]["URL"];
					}else{
						$href = base_url().$data[$parent][$c]["URL"];
					}
					$pos_uri = strpos($data[$parent][$c]["URL_CI"],$segs);
					//if(($pos_uri!==false)&&($segs!="/")){
					if($segs==$data[$parent][$c]["URL_CI"]){
						$active = "class='active'";
						$arract = get_active($data[$parent][$c]['ID']);
						for($act=0; $act<count($arract); $act++){
							$html .="<script>$('#menu_".$arract[$act]."').addClass('open');</script>";
						}
					}else{
						$active="class=''";
					}
				}
				if($data[$parent][$c]["TARGET"]=="_BLANK"){
					$target = "target='".$data[$parent][$c]["TARGET"]."'";
				}else{
					$target = "";
				}
				$html .= "<li ".$active." id='menu_".$data[$parent][$c]['ID']."'>";
				$html .= '<a href="'.$href.'" '.$target.'>'.$data[$parent][$c]["JUDUL_MENU"].'</a>';
				if($child){
					$html .= '<ul class="sub-menu">'.$child.'</ul>';
				}
				$html .= '</li>';
			}
			return $html;
		} else {
			$html = "";
			return false;
		}

	}
}

if(!function_exists('get_active')){
	function get_active(&$ID=0){
		$ci =& get_instance();
		$ci->load->database();
		$arrdata = array();
		$SQL = "SELECT func_active('".$ID."') AS ACTIVE";
		$result = $ci->db->query($SQL);
		if($result->num_rows() > 0){
			$rows = $result->row();
			if($rows->ACTIVE!="") $arrdata = explode(',',$rows->ACTIVE);
		}
		return $arrdata;
	}
}
