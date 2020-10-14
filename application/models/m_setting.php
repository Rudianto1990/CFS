<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class M_setting extends Model {
	
	function denah($type="", $act="") {
		$page_title = "LAPANGAN & GUDANG";
		$title = "LAPANGAN & GUDANG";
		$this->newtable->breadcrumb('Dashboard', site_url(),'icon-home');
		$this->newtable->breadcrumb('Setting', 'javascript:void(0)','');
		$this->newtable->breadcrumb('Lapangan & Gudang', 'javascript:void(0)','');
		$check = (grant()=="W")?true:false;
        	$judul = "DENAH";
        	$SQL = "SELECT KD_GUDANG_DTL AS 'KODE GUDANG', NAMA_GUDANG_LAPANGAN AS 'NAMA',
				KD_GUDANG AS TIPE, PANJANG, LEBAR
				FROM reff_gudang_dtl";
		
		$proses = array('TAMBAH'  => array('MODAL',"setting/form_denah_act/add", '0','','md-plus-circle','', 'menu'),
						'UPDATE' => array('MODAL',"setting/form_denah_act/update", '1','','md-edit','', 'list'),
						'DETAIL' => array('GET',site_url()."/setting/form_denah_act/detail", '1','','md-refresh-alt','', 'list'),
						'DELETE'  => array('DELETE',"setting/process/delete/denah", 'all','','md-close-circle','', 'menu'));
						//'UPLOAD' => array('ADD',site_url()."/coarri/discharge/upload", '','','md-attachment'));
		$this->newtable->multiple_search(true);
		$this->newtable->show_chk($check);
		$this->newtable->show_menu($check);
		$this->newtable->show_search(true);
		$this->newtable->search(array(array('KD_GUDANG_DTL','KODE GUDANG'),array('NAMA_GUDANG_LAPANGAN','NAMA DENAH')));
		$this->newtable->action(site_url() . "/setting/gudang_detail");
		//if($check) $this->newtable->detail(array('POPUP',"/setting/form_denah/detail"));
		//(array('GET',site_url()."/setting/form_denah/detail"));
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array(""));
		$this->newtable->keys(array("KODE GUDANG"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby(2);
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("tbldenah");
		$this->newtable->set_divid("divtbldenah");
		$this->newtable->rowcount(10);
		$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate($SQL);
		$arrdata = array("page_title" => $page_title, "title" => $title, "content" => $tabel);
		if($this->input->post("ajax")||$act == "post")
			return $tabel;
		else
			return $arrdata;
    }
	
	function get_data($data="", $id="", $kdlap="") {
        $func = get_instance();
        $func->load->model("m_main");
        if ($data == "nama_denah") {
            $sql = "SELECT DISTINCT LEVEL_1
					FROM t_denah_lapangan
					WHERE KD_GUDANG_DTL = " . $this->db->escape($kdlap) . "
					AND IDDATA = " . $this->db->escape($id);
            //print_r($sql);die();
            $hasil = $func->main->get_result($sql);
            if ($hasil) {
                foreach ($sql->row_array() as $row) {
                    $name = $row;
                }
                return $name;
            }
        } else if ($data == "get_denah") {
            $id = $this->input->post("id");
            $querygudang = "SELECT ID, KD_GUDANG, KD_TPS, NAMA, KD_TIPE_GUDANG, PANJANG, LEBAR
							FROM reff_gudang_dtl
							WHERE ID = " . $this->db->escape($id);
            $hasil = $func->main->get_result($querygudang);
            if ($hasil) {
                foreach ($querygudang->result_array() as $row => $value) {
                    $arrdata[] = $value;
                }
            }
            $querylapangan = "SELECT LEVEL_1, LEVEL_2, LEVEL_3, LEVEL_4, IDDATA
							  FROM t_denah_lapangan
							  WHERE KD_GUDANG_DTL = " . $this->db->escape($id);
            $hasillapangan = $func->main->get_result($querylapangan);
            if ($hasillapangan) {
                foreach ($querylapangan->result_array() as $row => $value) {
                    $arrlapangan[] = $value;
                }
            }
            for ($a = 0; $a < count($arrlapangan); $a++) {
                $arrExp = explode(",", $arrlapangan[$a]['IDDATA']);
                for ($b = 0; $b < count($arrExp); $b++) {
                    $arrTemp[] = $arrExp[$b];
                }
            }
            $defaultWidth = '10';
            $tableWidth = (intval($defaultWidth) * $arrdata[0]['LEBAR']);
            $content = '<script>
						$("#TableYard").bind("mousedown", function (e) {
							e.metaKey = true;
						}).selectable({
							filter: "td",
							create: function( event, ui ){
								$("#TableYard .ui-selected").selectable({
									disabled:true	
								});
							},
							stop: function (event, ui) {
								var s = $(this).find(".ui-selected");
								var id = "";
								$(this).find(".ui-selected").each(function (index) {
									if (!$(this).hasClass("ui-selectable")) {
										id += $(this).attr("id") + ",";
									}
								});
								if(id!=""){
									var data = "";
									data += "id="+id+"&kode=' . $arrdata["0"]["ID"] . '&nama=' . $arrdata["0"]["NAMA"] . '&panjang=' . $arrdata["0"]["PANJANG"] . '&lebar=' . $arrdata["0"]["LEBAR"] . '&tipe=' . $arrdata["0"]["KD_TIPE_GUDANG"] . '";
									popup_search("popup/popup_add/denah/add",data,"800","600");	
								}
								
							}
						});
						</script>';
            $content .= '<table id="TableYard" class="table table-bordered" style="width:' . $tableWidth . 'px;" align="center">';
            for ($c = 1; $c <= $arrdata[0]['LEBAR']; $c++) {
                $content .= '<tr>';
                for ($d = 1; $d <= $arrdata[0]['PANJANG']; $d++) {
                    if (in_array($c . '-' . $d, $arrTemp)) {
                        $addstyle = "class='ui-selectee ui-selected'";
                    } else {
                        $addstyle = "";
                    }
                    $content .= '<td id="' . $c . '-' . $d . '" ' . $addstyle . ' style="width:' . $defaultWidth . 'px;">';
                    $content .= '<span style="cursor:pointer" onclick=\'popup_search("popup/popup_add/denah/edit","id=' . $c . '-' . $d . '&kode=' . $arrdata[0]['ID'] . '","800","600")\'>' . $this->get_data("nama_denah", $c . '-' . $d, $id) . '<span>';
                    $content .= '</td>';
                }
                $content .= '</tr>';
            }
            $content .= '</table>';
            echo $content;
        } else if ($data == "denah") {
            $querygudang = "SELECT ID, KD_GUDANG, KD_TPS, NAMA, KD_TIPE_GUDANG, PANJANG, LEBAR
							FROM reff_gudang_dtl
							WHERE ID = " . $this->db->escape($id);
            $hasil = $func->main->get_result($querygudang);
            if ($hasil) {
                foreach ($querygudang->result_array() as $row => $value) {
                    $arrgudang[] = $value;
                }
            }
            $querylapangan = "SELECT ID, KD_GUDANG_DTL, LEVEL_1, LEVEL_2, LEVEL_3, LEVEL_4, KD_STATUS, TGL_STATUS
							  FROM t_denah_lapangan
							  WHERE KD_GUDANG_DTL = " . $this->db->escape($id);
            $hasillapangan = $func->main->get_result($querylapangan);
            if ($hasillapangan) {
                foreach ($querylapangan->result_array() as $row => $value) {
                    $arrlapangan[] = $value;
                }
            }

            $returnArray = array('arrgudang' => $arrgudang,
                'arrlapangan' => $arrlapangan
            );
            return $returnArray;
        } else if ($data == 'headerkodedok') {
            $SQL = "SELECT * FROM REFF_KODE_DOK_BC
					WHERE ID = " . $this->db->escape($id); //PRINT_R($SQL);DIE();
            $result = $this->db->query($SQL);
            return $result->row_array();
        } elseif ($data == 'headerstatus') {
            $SQL = "SELECT * FROM reff_status
					WHERE ID = " . $this->db->escape($id); //PRINT_R($SQL);DIE();
            $result = $this->db->query($SQL);
            return $result->row_array();
        } elseif ($data == 'headerrencana') {
            $SQL = "SELECT * FROM REFF_RENCANA_PENGGUNAAN_UUDP
					WHERE ID = " . $this->db->escape($id); //PRINT_R($SQL);DIE();
            $result = $this->db->query($SQL);
            return $result->row_array();
        } elseif ($data == 'headerjabatan') {
            $SQL = "SELECT * FROM REFF_JABATAN
					WHERE ID = " . $this->db->escape($id); //PRINT_R($SQL);DIE();
            $result = $this->db->query($SQL);
            return $result->row_array();
        } elseif ($data == 'headertipeorganisasi') {
            $SQL = "SELECT * FROM REFF_TIPE_ORGANISASI
					WHERE ID = " . $this->db->escape($id); //PRINT_R($SQL);DIE();
            $result = $this->db->query($SQL);
            return $result->row_array();
        } elseif ($data == 'headernotifikasi') {
            $SQL = "SELECT A.* , B.JUDUL_MENU FROM REFF_NOTIFIKASI A
					LEFT JOIN APP_MENU B ON B.ID = A.KD_MENU
			
					WHERE A.ID = " . $this->db->escape($id); //PRINT_R($SQL);DIE();
            $result = $this->db->query($SQL);
            return $result->row_array();
        } elseif ($data == 'headerdivisi') {
            $SQL = "SELECT * FROM REFF_DIVISI
					WHERE ID = " . $this->db->escape($id); //PRINT_R($SQL);DIE();
            $result = $this->db->query($SQL);
            return $result->row_array();
        } elseif ($data == 'headerjenispelayanan') {
            $SQL = "SELECT * FROM REFF_JENIS_PELAYANAN
					WHERE ID = " . $this->db->escape($id); //PRINT_R($SQL);DIE();
            $result = $this->db->query($SQL);
            return $result->row_array();
        } elseif ($data == 'headertarif') {
            $SQL = "SELECT A.*, B.NAMA AS 'NAMA_TIPE_ORDER' , C.NAMA AS 'NAMA_JENIS_MUAT', D.NAMA AS 'NAMA_JENIS_PELAYANAN', E.NAMA AS 'NAMA_UKURAN_CONT'
			,F.NAMA AS 'NAMA_TIPE_CONT' FROM reff_tarif A
					LEFT JOIN reff_tipe_order B ON B.ID = A.KD_TIPE_ORDER
					LEFT JOIN reff_jenis_muat C ON C.ID = A.KD_JENIS_MUAT
					LEFT JOIN reff_jenis_pelayanan D ON D.ID = A.KD_JENIS_PELAYANAN
					LEFT JOIN reff_cont_ukuran E ON E.ID = A.KD_CONT_UKURAN
					LEFT JOIN reff_cont_tipe F ON F.ID = A.KD_CONT_TIPE
					WHERE A.ID = " . $this->db->escape($id); //PRINT_R($SQL);DIE();
            $result = $this->db->query($SQL);
            return $result->row_array();
        }else if ($data == 'detail_denah') {
            $SQL = "SELECT * FROM reff_gudang_dtl WHERE KD_GUDANG_DTL = " . $this->db->escape($id); //PRINT_R($SQL);DIE();
            $result = $this->db->query($SQL);
			return $result->result_array();
        }else if ($data == 'detail_denah_iddata') {
            $SQL = "SELECT KD_GUDANG_DTL, IF(NM_BLOK IS NULL OR NM_BLOK = '', '-', NM_BLOK) AS NM_BLOK, LEVEL_1, MIN(LEVEL_2) AS LEVEL_2, LEVEL_3, LEVEL_4, IDDATA
							  FROM t_denah_lapangan
							  WHERE KD_GUDANG_DTL = ". $this->db->escape($id)."
							  GROUP BY LEVEL_1
							  ORDER BY IDDATA ASC";
			/*$SQL = "SELECT KD_GUDANG_DTL, IF(NM_BLOK IS NULL OR NM_BLOK = '', '-', NM_BLOK) AS NM_BLOK, LEVEL_1, LEVEL_2, LEVEL_3, LEVEL_4, IDDATA
							  FROM t_denah_lapangan
							  WHERE LEVEL_4 = 1 AND KD_GUDANG_DTL = ". $this->db->escape($id);*/
            $result = $this->db->query($SQL);
			return $result->result_array();
        }else if ($data == 'detail_denah_YA') {
            $SQL = "SELECT * FROM reff_gudang_dtl WHERE KD_GUDANG_DTL = 'YA'"; //. $this->db->escape($id); //PRINT_R($SQL);DIE();
            $result = $this->db->query($SQL);
			return $result->result_array();
        }else if ($data == 'detail_denah_YB') {
            $SQL = "SELECT * FROM reff_gudang_dtl WHERE KD_GUDANG_DTL = 'YB'"; //. $this->db->escape($id); //PRINT_R($SQL);DIE();
            $result = $this->db->query($SQL);
			return $result->result_array();
        }else if ($data == 'detail_denah_cic') {
            $SQL = "SELECT * FROM reff_gudang_dtl WHERE KD_GUDANG_DTL = 'CIC'"; //. $this->db->escape($id); //PRINT_R($SQL);DIE();
            $result = $this->db->query($SQL);
			return $result->result_array();
        }else if ($data == 'detail_denah_lapangan_ya') {
			$SQL = "SELECT KD_GUDANG_DTL, IF(NM_BLOK IS NULL OR NM_BLOK = '', '-', NM_BLOK) AS NM_BLOK, LEVEL_1, LEVEL_2, LEVEL_3, LEVEL_4, IDDATA, KD_STATUS
							  FROM t_denah_lapangan
							  WHERE KD_GUDANG_DTL = 'YA'  AND LEVEL_4 = 1";
            $result = $this->db->query($SQL);
			return $result->result_array();
        }else if ($data == 'detail_denah_lapangan_yb') {
			$SQL = "SELECT KD_GUDANG_DTL, IF(NM_BLOK IS NULL OR NM_BLOK = '', '-', NM_BLOK) AS NM_BLOK, LEVEL_1, LEVEL_2, LEVEL_3, LEVEL_4, IDDATA, KD_STATUS
							  FROM t_denah_lapangan
							  WHERE KD_GUDANG_DTL = 'YB'  AND LEVEL_4 = 1";
            $result = $this->db->query($SQL);
			return $result->result_array();
        }else if ($data == 'detail_denah_lapangan_cic') {
			$SQL = "SELECT KD_GUDANG_DTL, IF(NM_BLOK IS NULL OR NM_BLOK = '', '-', NM_BLOK) AS NM_BLOK, LEVEL_1, LEVEL_2, LEVEL_3, LEVEL_4, IDDATA, KD_STATUS
							  FROM t_denah_lapangan
							  WHERE KD_GUDANG_DTL = 'CIC'  AND LEVEL_4 = 1";
            $result = $this->db->query($SQL);
			return $result->result_array();
        }else if ($data == 'detail_blok') {
			//$SQL = "SELECT * FROM t_denah_lapangan WHERE LEVEL_1 = ".$this->db->escape($id);
			$SQL = "select a.*, ifnull(b.NO_CONT, '-') as NO_CONT, case b.STATUS_CONT when '450' then '<span class=\"label label-danger\">stacking</span>' when '000' then '<span class=\"label label-warning\">planning</span>' else '<span class=\"label label-success\">empty</span>' end as STAT
					from t_denah_lapangan a 
					left join t_spk_cont b on a.NM_BLOK = b.LOKASI and a.LEVEL_4 = b.TIER 
					-- and b.STATUS_CONT IN('450','460')
					where a.NM_BLOK = ".$this->db->escape($id)."
					order by a.LEVEL_4 DESC";
			//echo $SQL;
			$cek = $this->db->query($SQL)->row();
			if($cek > 0){
				$result = $this->db->query($SQL);
				return $result->result_array();
			} else {
				$SQL = "SELECT * FROM t_denah_lapangan WHERE LEVEL_1 = ".$this->db->escape($id);
				$result1 = $this->db->query($SQL);
				return $result1->result_array();
			}
        }else if ($data == 'totalCont') {
			$SQL = "select count(*) as tier, ifnull(b.total,0) as total, ifnull(b.LOKASI,".$this->db->escape($id).") as 	lokasi from (
					select a.LOKASI, count(*) as total
					from t_spk_cont a 
					where a.LOKASI = ".$this->db->escape($id)."
					and a.STATUS_CONT IN('450','460')
					group by a.LOKASI
					) b left join t_denah_lapangan c on c.LEVEL_1 = b.LOKASI";
			
			$SQL = "select a.tier, ifnull(count(*),0) as total, ifnull(b.LOKASI,'-') as lokasi from (
					select nm_blok,count(*) as tier 
					from t_denah_lapangan
					where nm_blok = ".$this->db->escape($id)."
					group by LOKASI
					) a
					left join t_spk_cont b on b.LOKASI= a.nm_blok				
					where b.LOKASI = ".$this->db->escape($id)." and b.STATUS_CONT IN('450','460')
					group by b.LOKASI,a.tier,b.LOKASI";
			
            $result = $this->db->query($SQL);
			return $result->result_array();
        }else if ($data == 'lokasi_denah') {
			$SQL = "SELECT * FROM reff_gudang_dtl";
            $result = $this->db->query($SQL);
			return $result->result_array();
        }
    }
	
	function get_data_denah($act,$id){
		$func = get_instance();
        $func->load->model("m_main", "main", true);
		$KD_TPS = $this->session->userdata('KD_TPS');
		$KD_GUDANG = $this->session->userdata('KD_GUDANG');
		//$func->main->log_prints($id, $act);
		if($act=="denah1"){
			//echo "string". $id;die();
			//print_r($id);die();
			//$arrid = explode("~",$id);
			$SQL = "SELECT KD_GUDANG_DTL, KD_GUDANG, KD_TPS, NAMA_GUDANG_LAPANGAN, KD_GUDANG, PANJANG, LEBAR
							FROM reff_gudang_dtl
							WHERE KD_GUDANG_DTL = '$id'";//.$this->db->escape($arrid[0]);
			$result = $func->main->get_result($SQL);
			//print_r($SQL);die();
			if($result){
				foreach($SQL->result_array() as $row => $value){
					$arrdata = $value;
				}
				return $arrdata;
			}else {
				redirect(site_url(), 'refresh');
			}
		}else if($act=="get_kd"){
			echo "sini";die();
			$SQL = "SELECT ID FROM reff_gudang_dtl";
			$result = $func->main->get_result($SQL);
			//print_r($SQL);die();
			if($result){
				foreach($SQL->result_array() as $row => $value){
					$arrdata = $value;
				}
				return $arrdata;
			}else {
				redirect(site_url(), 'refresh');
			}
		}else if($act=="get_kd_lapangan"){
			//echo "sini";die();
			$SQL = "SELECT * FROM t_denah_lapangan WHERE LEVEL_1 = '$id' ORDER BY LEVEL_4 DESC LIMIT 1";
			$result = $func->main->get_result($SQL);
			//print_r($SQL);die();
			if($result){
				foreach($SQL->result_array() as $row => $value){
					$arrdata = $value;
				}
				//print_r($arrdata);
				return $arrdata;
			}else {
				redirect(site_url(), 'refresh');
			}
		}
	}
	
	function get_kd1(){
		$SQL = "SELECT ID FROM reff_gudang_dtl";
		$RES = $this->db->query($SQL);
		return $RES->result();
		//print_r($RES);
	}
	
	public function inDen($data){
		$this->db->insert('t_denah_lapangan', $data);
	}
	
	public function getDataDen(){
		/*$this->db->where('id', 5);
		$SQL = $this->db->get('t_denah_lapangan');*/
		$SQL = $this->db->query("SELECT * FROM t_denah_lapangan WHERE id = '1'");
		//$SQL = $query = $this->db->get('t_denah_lapangan', 1);
		return $SQL->result();
	}
	
	function getAreaGudang(){
    	$func = get_instance();
        $func->load->model("m_main", "main", true);
		$SQL = "SELECT * FROM reff_gudang_dtl WHERE KD_GUDANG_DTL = ". $this->db->escape($this->input->post('id'));
		
        $result = $func->main->get_result($SQL);
       	$table = '<table border="1" class="myTable" style="border-collapse: collapse;width:100%;" cellpadding="8" >';
		if($result){
			foreach($SQL->result_array() as $row){

				$SQLDETIL = "SELECT KD_GUDANG_DTL, NM_BLOK, LEVEL_1, LEVEL_2, LEVEL_3, LEVEL_4, IDDATA, KD_STATUS
			  		FROM t_denah_lapangan
			  		WHERE KD_GUDANG_DTL =  '".$row['KD_GUDANG_DTL']."'  AND LEVEL_4 = 1  ORDER BY IDDATA ASC";			
			  	
			  	$resultdtl = $func->main->get_result($SQLDETIL);
				if($resultdtl){
					$arrdetil = array();
					foreach($SQLDETIL->result_array() as $dtl){
						$arrdetil[lebar][$dtl['LEVEL_3']][$dtl['LEVEL_2']]= $dtl['LEVEL_1'];
						$arrdetil[nm_blok][$dtl['LEVEL_3']][$dtl['LEVEL_2']]= $dtl['NM_BLOK'];
					  
						$SQL_TIER = "SELECT COUNT(*) AS TOTAL FROM t_denah_lapangan A WHERE A.USE = '0' AND A.LEVEL_1 = '".$dtl['LEVEL_1']."'";
						$resultTier = $this->db->query($SQL_TIER)->row();
						$arrdetil[tier][$dtl['LEVEL_3']][$dtl['LEVEL_2']]= $resultTier->TOTAL;
					}
				}		
				//print_r($arrdetil);die();
				for($a = 0;$a<$row['PANJANG'];$a++){
					$table .="<tr>";
						for($b=0;$b<$row['LEBAR'];$b++){
							$clik = 'onclick=""';
							$val = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
							$style = "background-color:#fff;color:#fff;width:100px;text-space-collapse;border:0px solid #fff";
							if($arrdetil['lebar'][$a][$b] != ""){
								$clik = 'onclick="getActDtl1(this.id)"';
								$val = $arrdetil['nm_blok'][$a][$b];
								$style = "background-color:green;color:#FFF";
								
								$getDataDenah = $this->get_data('totalCont', $val);
								if($getDataDenah != ''){
									$hitung = floatval($getDataDenah[0]['total']) / floatval($getDataDenah[0]['tier']);
									$hitungan = number_format($hitung, 2, '.', '');
									if($hitungan == 1){
										$style = "background-color:red;color:#FFF";
									} else if($hitungan > 0.5 && $hitungan < 1){
										$style = "background-color:orange;color:#FFF";
									} else if($hitungan >= 0.25 && $hitungan <= 0.5 ){
										$style = "background-color:blue;color:#FFF";
									}
								}
								
								if ($arrdetil['tier'][$a][$b] == 0) {
									$clik = 'onclick="alertMsg()"';
									$style = "background-color:#000;color:#FFF";
								}
							}

							$table .="<td ".$clik." style=".$style." class=\"star\" id=\"".$this->input->post('id')."/".$b."-".$a."-".$val."\" >".$val."</td>";				
						}
					$table .="</tr>";
				}
				
			}
			$table .="</table>";
			return $table;					
		}else {//die("sini");
			redirect(site_url(), 'refresh');
		}
    }
	
	public function getTier($id){
		//echo "sini";die();
		//print_r($this->db->escape($this->input->post('blok')));die();
		$func = get_instance();
        $func->load->model("m_main", "main", true);
		$SQL = "SELECT A.* FROM t_denah_lapangan A WHERE A.USE = 1 AND A.LEVEL_1 = ". $this->db->escape($this->input->post('blok'));
		
		$select .= "<select class=\"form-control focus\" name=\"PENUMPUKAN\" id=\"PENUMPUKAN\">";
        $result = $func->main->get_result($SQL);
        //print_r($result);die();
		if($result){
			foreach($SQL->result_array() as $row){
				$select .= '<option value="'.$row['LEVEL_4'].'" >'.$row['LEVEL_4'].'</option>';
				//echo $row['LEVEL_4'];
			}
			$select .= "</select>";
			return $select;
		}
	}
	
	public function cekBlok($blok){
		$this->db->where('NM_BLOK',$blok);
	    $query = $this->db->get('t_denah_lapangan');
	    if ($query->num_rows() > 0){
	        return true;
	    }
	    else{
	        return false;
	    }
	}
	
	public function getNmBlok($blok){
		$SQL = "SELECT IFNULL(NM_BLOK, '-') AS NM_BLOK, LEVEL_1 FROM t_denah_lapangan WHERE NM_BLOK = '".$blok."'";
		$QUERY = $this->db->query($SQL);
		return $QUERY->result();
	}
	
	public function process($type,$act,$id){
		$func = get_instance();
	        $func->load->model("m_main", "main", true);
		$KD_TPS = $this->session->userdata('KD_TPS');
		$KD_GUDANG = $this->session->userdata('KD_GUDANG');
		$KD_KPBC = $this->session->userdata('KD_KPBC');
		$error = 0;
		if($type=="save"){
			if($act=="denah"){
				//echo "add sini"; die();
				foreach($this->input->post('DATA') as $a => $b){
					if($b=="") unset($DATA[$a]);
					else $DATA[$a] = strtoupper(trim($b));
				}
				//print_r($DATA);die();
				/*$DATA['ID'] = $DATA['ID'];
				$DATA['NAMA'] = $DATA['NM_LAP'];
				$DATA['KD_TIPE_GUDANG'] = $DATA['TIPE'];
				$DATA['PANJANG'] = $DATA['P'];
				$DATA['LEBAR'] = $DATA['L'];*/
				//$DATA['WK_REKAM'] = date('Y-m-d H:i:s');
				//print_r($DATA);//die();

				$this->db->insert('reff_gudang_dtl', $DATA);

				if($error == 0){
					echo "MSG#OK#Data berhasil diproses#".site_url()."/setting/gudang_detail/post";
				}else{
					echo "MSG#ERR#".$message."#";
				}
			}
		}else if($type == "update"){
			if($act=="denah"){
				//echo "Ubah Sini ". $id;die();
				foreach($this->input->post('DATA') as $a => $b){
					if($b=="") unset($DATA[$a]);
					else $DATA[$a] = strtoupper(trim($b));
				}
				//print_r($DATA);die();
				$this->db->where(array('KD_GUDANG_DTL' => $id));
				$result = $this->db->update('reff_gudang_dtl', $DATA);

				if($error == 0){
					echo "MSG#OK#Data berhasil diproses#".site_url()."/setting/gudang_detail/post";
				}else{
					echo "MSG#ERR#".$message."#";
				}
			}
		}else if($type == "delete"){
			//echo "sini dfd". $id;die();
			//print_r("id ". $_POST);die();
			if($act=="denah"){
				//print_r($this->input->post('tb_chktbldenah'));die();
				foreach($this->input->post('tb_chktbldenah') as $chkitem){
					$arrchk = explode("~", $chkitem);
					$ID  = $arrchk[0];
					//print_r($ID);die();
					$exec = $this->db->delete('reff_gudang_dtl', array('KD_GUDANG_DTL' => $ID));
					if(!$exec){
						$error += 1;
						$message = "Data gagal diproses";
					}
				}

				if($error==0){
					//$func->main->get_log("delete","t_request_plp_hdr,t_request_plp_cont,t_request_plp_status");
					$action = '/setting/gudang_detail/post';
					echo "MSG#OK#Data berhasil dihapus#".site_url().$action;
				}else{
					echo "MSG#ERR#Data gagal dihapus#";
				}
			}
		}
	}
}