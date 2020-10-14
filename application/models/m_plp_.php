<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class M_plp extends Model{
	
    function M_plp() {
       parent::Model();
    }
	
	function autocomplete($act,$get){
		$post = $this->input->post('term');
		if($act=="res_plp"){
			if (!$post) return;
			$SQL = "SELECT A.ID, A.KD_KPBC, A.KD_TPS_ASAL, A.KD_TPS_TUJUAN, A.KD_GUDANG_TUJUAN, A.NO_PLP, A.NO_SURAT, A.TGL_SURAT, A.NM_ANGKUT, 
					DATE_FORMAT(A.TGL_PLP,'%d-%m-%Y') AS TGL_PLP, A.NO_VOY_FLIGHT, A.CALL_SIGN, A.TGL_TIBA, A.NO_BC11, A.TGL_BC11
					FROM t_respon_plp_tujuan_v2_hdr A
					WHERE A.NO_PLP LIKE '%".$post."%' LIMIT 5";
			$result = $this->db->query($SQL);
			$banyakData = $result->num_rows();
			$arrayDataTemp = array();
			if($banyakData > 0){
				foreach($result->result() as $row){
					$PLP = strtoupper($row->NO_PLP);
					$TGL_PLP = $row->TGL_PLP;
					$arrayDataTemp[] = array("value"=>$PLP,"TGL_PLP"=>$TGL_PLP);
				}
			}
			echo json_encode($arrayDataTemp);	
		}else if($act=="mst_kapal"){
			if (!$post) return;
			$SQL = "SELECT ID, NAMA, CALL_SIGN FROM reff_kapal WHERE NAMA LIKE '%".$post."%' LIMIT 5";
			$result = $this->db->query($SQL);
			$banyakData = $result->num_rows();
			$arrayDataTemp = array();
			if($banyakData > 0){
				foreach($result->result() as $row){
					$KODE = strtoupper($row->ID);
					$NAMA = strtoupper($row->NAMA);
					$arrayDataTemp[] = array("value"=>$NAMA,"KD_KAPAL"=>$KODE);
				}
			}
			echo json_encode($arrayDataTemp);
		}else if($act=="mst_port"){
			if($get=="kode"){
				if (!$post) return;
				$SQL = "SELECT ID, CONCAT(ID,' - ',NAMA) AS NAMA 
						FROM reff_pelabuhan WHERE ID LIKE '%".$post."%' OR NAMA LIKE '%".$post."%' LIMIT 5";
				$result = $this->db->query($SQL);
				$banyakData = $result->num_rows();
				$arrayDataTemp = array();
				if($banyakData > 0){
					foreach($result->result() as $row){
						$KODE = strtoupper($row->ID);
						$NAMA = strtoupper($row->NAMA);
						$arrayDataTemp[] = array("value"=>$KODE,"label"=>$NAMA,"NAMA"=>$NAMA);
					}
				}	
			}else if($get=="nama"){
				if (!$post) return;
				$SQL = "SELECT ID, CONCAT(ID,' - ',NAMA) AS NAMA
						FROM reff_pelabuhan WHERE NAMA LIKE '%".$post."%' OR NAMA LIKE '%".$post."%' LIMIT 5";
				$result = $this->db->query($SQL);
				$banyakData = $result->num_rows();
				$arrayDataTemp = array();
				if($banyakData > 0){
					foreach($result->result() as $row){
						$KODE = strtoupper($row->ID);
						$NAMA = strtoupper($row->NAMA);
						$arrayDataTemp[] = array("value"=>$NAMA,"label"=>$NAMA,"KODE"=>$KODE);
					}
				}
			}
			echo json_encode($arrayDataTemp);
		}else if($act=="mst_kemasan"){
			if (!$post) return;
			$SQL = "SELECT ID, NAMA FROM reff_kemasan WHERE NAMA LIKE '%".$post."%' LIMIT 5";
			$result = $this->db->query($SQL);
			$banyakData = $result->num_rows();
			$arrayDataTemp = array();
			if($banyakData > 0){
				foreach($result->result() as $row){
					$KODE = strtoupper($row->ID);
					$NAMA = strtoupper($row->NAMA);
					$arrayDataTemp[] = array("value"=>$NAMA,"KODE"=>$KODE);
				}
			}
			echo json_encode($arrayDataTemp);
		}else if($act=="mst_dok_bc"){
			if (!$post) return;
			$SQL = "SELECT ID, NAMA FROM reff_kode_dok_bc 
					WHERE KD_PERMIT = ".$this->db->escape($get)."
					AND NAMA LIKE '%".$post."%' LIMIT 5";
			$result = $this->db->query($SQL);
			$banyakData = $result->num_rows();
			$arrayDataTemp = array();
			if($banyakData > 0){
				foreach($result->result() as $row){
					$KODE = strtoupper($row->ID);
					$NAMA = strtoupper($row->NAMA);
					$arrayDataTemp[] = array("value"=>$NAMA,"KODE"=>$KODE);
				}
			}
			echo json_encode($arrayDataTemp);
		}else if($act=="mst_organisasi"){
			if (!$post) return;
			$SQL = "SELECT ID, NAMA FROM t_organisasi 
					WHERE KD_TIPE_ORGANISASI = ".$this->db->escape($get)."
					AND NAMA LIKE '%".$post."%' LIMIT 5";
			$result = $this->db->query($SQL);
			$banyakData = $result->num_rows();
			$arrayDataTemp = array();
			if($banyakData > 0){
				foreach($result->result() as $row){
					$KODE = strtoupper($row->ID);
					$NAMA = strtoupper($row->NAMA);
					$arrayDataTemp[] = array("value"=>$NAMA,"KODE"=>$KODE);
				}
			}
			echo json_encode($arrayDataTemp);
		}else if($act=="mst_gudang"){
			if($get=="kode"){
				if (!$post) return;
				$SQL = "SELECT KD_TPS, KD_GUDANG, NAMA_GUDANG FROM reff_gudang 
						WHERE KD_GUDANG LIKE '%".$post."%' OR NAMA_GUDANG LIKE '%".$post."%' LIMIT 5";
				$result = $this->db->query($SQL);
				$banyakData = $result->num_rows();
				$arrayDataTemp = array();
				if($banyakData > 0){
					foreach($result->result() as $row){
						$KODETPS = strtoupper($row->KD_TPS);
						$KODEGUDANG = strtoupper($row->KD_GUDANG);
						$NAMA = strtoupper($row->NAMA_GUDANG);
						$arrayDataTemp[] = array("value"=>$KODEGUDANG,"KODETPS"=>$KODETPS,"KODEGUDANG"=>$KODEGUDANG,"NAMAGUDANG"=>$NAMA);
					}
				}	
			}else if($get=="nama"){
				if (!$post) return;
				$SQL = "SELECT KD_TPS, KD_GUDANG, NAMA_GUDANG FROM reff_gudang 
						WHERE KD_GUDANG LIKE '%".$post."%' OR NAMA_GUDANG LIKE '%".$post."%' LIMIT 5";
				$result = $this->db->query($SQL);
				$banyakData = $result->num_rows();
				$arrayDataTemp = array();
				if($banyakData > 0){
					foreach($result->result() as $row){
						$KODETPS = strtoupper($row->KD_TPS);
						$KODEGUDANG = strtoupper($row->KD_GUDANG);
						$NAMA = strtoupper($row->NAMA_GUDANG);
						$arrayDataTemp[] = array("value"=>$NAMA,"KODETPS"=>$KODETPS,"KODEGUDANG"=>$KODEGUDANG,"NAMAGUDANG"=>$NAMA);
					}
				}	
			}
			echo json_encode($arrayDataTemp);
		}else if($act=="mst_alasan_plp"){
			if (!$post) return;
			$SQL = "SELECT ID, NAMA FROM reff_alasan_plp 
					WHERE NAMA LIKE '%".$post."%' LIMIT 5";
			$result = $this->db->query($SQL);
			$banyakData = $result->num_rows();
			$arrayDataTemp = array();
			if($banyakData > 0){
				foreach($result->result() as $row){
					$KODE = strtoupper($row->ID);
					$NAMA = strtoupper($row->NAMA);
					$arrayDataTemp[] = array("value"=>$NAMA,"KODE"=>$KODE);
				}
			}
			echo json_encode($arrayDataTemp);
		}
	}
	
	function get_combobox($act){
        $func = get_instance();
        $func->load->model("m_main", "main", true);
		$id = $this->input->post('id');
		$name = $this->input->post('name');
		if($act == "port"){
            $sql = "SELECT ID, NAMA FROM reff_pelabuhan";
            $arrdata = $func->main->get_combobox($sql, "ID", "NAMA", TRUE);
			return $arrdata;
		}else if ($act == "negara") {
            $sql = "SELECT ID, UPPER(NAMA) AS NAMA FROM reff_negara ORDER BY NAMA";
            $arrdata = $func->main->get_combobox($sql, "ID", "NAMA", TRUE);
			return $arrdata;
		}else if ($act == "status_container") {
            $sql = "SELECT ID, UPPER(NAMA) AS NAMA FROM reff_cont_status ORDER BY NAMA";
            $arrdata = $func->main->get_combobox($sql, "ID", "NAMA", TRUE);
			return $arrdata;
		}else if ($act == "sarana_angkut") {
            $sql = "SELECT ID, UPPER(NAMA) AS NAMA FROM reff_sarana_angkut ORDER BY NAMA";
            $arrdata = $func->main->get_combobox($sql, "ID", "NAMA", TRUE);
			return $arrdata;
		}
    }
	
	function execute($type, $act, $id){
		$func = get_instance();
        $func->load->model("m_main", "main", true);
		$success = 0;
		$error = 0;
		$KD_TPS = $this->newsession->userdata('KD_TPS');
		$KD_GUDANG = $this->newsession->userdata('KD_GUDANG');
		$KD_KPBC = $this->newsession->userdata('KD_KPBC');
		if($type=="save"){
			if($act=="pengajuan"){
				foreach($this->input->post('DATA') as $a => $b){
					if($b=="") $DATA[$a] = NULL;
					else $DATA[$a] = strtoupper($b);
				}
				$DATA['KD_COCOSTSHDR'] = $id;
				$DATA['KD_TPS_ASAL'] = $KD_TPS;
				$DATA['KD_GUDANG_ASAL'] = $KD_GUDANG;
				$DATA['KD_KPBC'] = $KD_KPBC;
				$DATA['TGL_SURAT'] = date_input($DATA['TGL_SURAT']);
				$DATA['TGL_TIBA'] = date_input($DATA['TGL_TIBA']);
				$DATA['TGL_BC11'] = date_input($DATA['TGL_BC11']);
				$DATA['KD_STATUS'] = '100';
				$DATA['TGL_STATUS'] = date('Y-m-d H:i:s');
				$SQL = "SELECT ID FROM t_request_plp_hdr
						WHERE NO_SURAT = ".$this->db->escape(trim($DATA['NO_SURAT']))."
						AND TGL_SURAT = ".$this->db->escape(trim($DATA['TGL_SURAT']));
				$result = $func->main->get_result($SQL);
				if($result){
					$error += 1;
					$message = "Data gagal diproses, periksa No. Surat dan Tgl. Surat";
				}else{
					$id_kms = $this->input->post('tmpchktblkemasan');
					$arr_kms = explode("*",$id_kms);
					$insertKemasan = true;
					for($a=0; $a<count($arr_kms); $a++){
						$kms = explode("~",$arr_kms[$a]);
						$SQL_KMS = "SELECT KD_KEMASAN, JUMLAH, NO_BL_AWB, TGL_BL_AWB
									FROM t_cocostskms
									WHERE ID = ".$this->db->escape($kms[0])."
									AND SERI = ".$this->db->escape($kms[1]);
						$result_kms = $func->main->get_result($SQL_KMS);
						if($result_kms){
							foreach($SQL_KMS->result_array() as $row => $value){
								$arrkms = $value;
							}
							$PLP_KMS = "SELECT A.ID FROM t_request_plp_kms A
										INNER JOIN t_request_plp_hdr B ON B.ID=A.ID
										WHERE B.KD_STATUS = '100'
										AND B.NO_SURAT = ".$this->db->escape(trim($DATA['NO_SURAT']))."
										AND B.TGL_SURAT = ".$this->db->escape(trim($DATA['TGL_SURAT']))."
										AND B.KD_COCOSTSHDR = ".$this->db->escape($id)."
										AND A.KD_KEMASAN = ".$this->db->escape($arrkms['KD_KEMASAN'])."
										AND A.NO_BL_AWB = ".$this->db->escape($arrkms['NO_BL_AWB'])."
										AND A.TGL_BL_AWB = ".$this->db->escape($arrkms['TGL_BL_AWB']);
							$result_plp = $func->main->get_result($PLP_KMS);
							if($result_plp){
								$insertKemasan = false;
							}
						}
					}
					if($insertKemasan){
						$this->db->insert('t_request_plp_hdr',$DATA);
						$ID_PLP = $this->db->insert_id();
						for($a=0; $a<count($arr_kms); $a++){
							$kms = explode("~",$arr_kms[$a]);
							$SQL_KMS = "SELECT KD_KEMASAN, JUMLAH, NO_BL_AWB, TGL_BL_AWB
										FROM t_cocostskms
										WHERE ID = ".$this->db->escape($kms[0])."
										AND SERI = ".$this->db->escape($kms[1]);
							$result_kms = $func->main->get_result($SQL_KMS);
							if($result_kms){
								foreach($SQL_KMS->result_array() as $row => $value){
									$arrkms = $value;
								}
								$arrkms['ID'] = $ID_PLP;
								$arrkms['JML_KMS'] = $arrkms['JUMLAH'];
								unset($arrkms['JUMLAH']);
								$this->db->insert('t_request_plp_kms',$arrkms);
							}
						}
					}else{
						$error += 1;
						$message = "Data gagal diproses, periksa No. BL/AWB dan Tgl. BL/AWB";
					}
				}
				if($error == 0){
					$func->main->get_log("add","t_request_plp_hdr,t_request_plp_kms");
					echo "MSG#OK#Data berhasil diproses#".site_url()."/plp/pengajuan";
				}else{
					echo "MSG#ERR#".$message."#";
				}
			}else if($act=="pembatalan"){
				foreach($this->input->post('DATA') as $a => $b){
					if($b=="") $DATA[$a] = NULL;
					else $DATA[$a] = strtoupper($b);
				}
				$DATA['KD_RESPON_PLP_ASAL'] = $id;
				$DATA['KD_KPBC'] = $KD_KPBC;
				$DATA['KD_TPS'] = $KD_TPS;
				$DATA['KD_GUDANG'] = $KD_GUDANG;
				$DATA['TGL_SURAT'] = date_input($DATA['TGL_SURAT']);	
				$DATA['KD_STATUS'] = '100';
				$DATA['TGL_STATUS'] = date('Y-m-d H:i:s');
				$SQL = "SELECT A.ID
						FROM t_request_batal_plp_hdr A
						WHERE A.NO_SURAT = ".$this->db->escape(trim($DATA['NO_SURAT']))."
						AND A.TGL_SURAT = ".$this->db->escape(trim($DATA['TGL_SURAT']));
				$result = $func->main->get_result($SQL);
				if($result){
					$error += 1;
					$message .= "Data gagal diproses, periksa No. Surat dan Tgl. Surat";
				}else{
					$id_kms = $this->input->post('tmpchktblkemasanplp');
					$arr_kms = explode("*",$id_kms);
					$insertKemasan = true;
					for($a=0; $a<count($arr_kms)-1; $a++){
						$kms = explode("~",$arr_kms[$a]);
						$PLP_KMS = "SELECT ID
									FROM t_request_batal_plp_kms 
									WHERE KD_KEMASAN = ".$this->db->escape(trim($kms[1]))."
									AND NO_BL_AWB = ".$this->db->escape(trim($kms[2]))."
									AND TGL_BL_AWB = ".$this->db->escape(trim($kms[3]));
						$result_kms = $func->main->get_result($PLP_KMS);
						if($result_kms){
							$insertKemasan = false;
						}
					}
					if($insertKemasan){
						$this->db->insert('t_request_batal_plp_hdr',$DATA);
						$ID_PLP = $this->db->insert_id();
						for($a=0; $a<count($arr_kms)-1; $a++){
							$kms = explode("~",$arr_kms[$a]);
							$KMS['ID'] = $ID_PLP;
							$KMS['KD_KEMASAN'] = $kms[1];
							$KMS['NO_BL_AWB'] = $kms[2];
							$KMS['TGL_BL_AWB'] = $kms[3];
							$KMS['JML_KMS'] = $kms[4];
							$this->db->insert('t_request_batal_plp_kms',$KMS);
						}
					}else{
						$error += 1;
						$message .= "Data gagal diproses, periksa No. BL/AWB dan Tgl. BL/AWB";
					}
				}
				if($error == 0){
					$func->main->get_log("add","t_request_batal_plp_hdr,t_request_batal_plp_kms");
					echo "MSG#OK#Data berhasil diproses#".site_url()."/plp/pembatalan";
				}else{
					echo "MSG#ERR#".$message."#";
				}
			}
		}else if($type=="update"){
			if($act=="pengajuan"){
				$arrid = explode("~",$id);
				foreach($this->input->post('DATA') as $a => $b){
					if($b=="") $DATA[$a] = NULL;
					else $DATA[$a] = strtoupper($b);
				}
				$DATA['KD_TPS_ASAL'] = $KD_TPS;
				$DATA['KD_GUDANG_ASAL'] = $KD_GUDANG;
				$DATA['KD_KPBC'] = $KD_KPBC;
				$DATA['TGL_SURAT'] = date_input($DATA['TGL_SURAT']);
				$DATA['TGL_TIBA'] = date_input($DATA['TGL_TIBA']);
				$DATA['TGL_BC11'] = date_input($DATA['TGL_BC11']);
				$DATA['TGL_STATUS'] = date('Y-m-d H:i:s');
				$SQL = "SELECT ID FROM t_request_plp_hdr
						WHERE NO_BC11 = ".$this->db->escape(trim($DATA['NO_BC11']))."
						AND TGL_BC11 = ".$this->db->escape(trim($DATA['TGL_BC11']));
				$result = $func->main->get_result($SQL);
				if($result){
					foreach($SQL->result_array() as $row => $value){
						$arrdata = $value;
					}
					$ID_PLP = $arrdata['ID'];
				}
				if($ID_PLP==$arrid[0]){
					$this->db->where(array('ID' => $arrid[0]));
					$exec = $this->db->update('t_request_plp_hdr', $DATA);
					if($exec){
						$this->db->delete('t_request_plp_kms',array('ID'=>$arrid[0]));
						$id_kms = $this->input->post('tmpchktblkemasan');
						$arr_kms = explode("*",$id_kms);
						$insertKemasan = true;
						for($a=0; $a<count($arr_kms); $a++){
							$kms = explode("~",$arr_kms[$a]);
							$SQL_KMS = "SELECT KD_KEMASAN, JUMLAH, NO_BL_AWB, TGL_BL_AWB
										FROM t_cocostskms
										WHERE ID = ".$this->db->escape($kms[0])."
										AND SERI = ".$this->db->escape($kms[1]);
							$result_kms = $func->main->get_result($SQL_KMS);
							if($result_kms){
								foreach($SQL_KMS->result_array() as $row => $value){
									$arrkms = $value;
								}
								$PLP_KMS = "SELECT ID FROM t_request_plp_kms 
											WHERE KD_KEMASAN = ".$this->db->escape($arrkms['KD_KEMASAN'])."
											AND NO_BL_AWB = ".$this->db->escape($arrkms['NO_BL_AWB'])."
											AND TGL_BL_AWB = ".$this->db->escape($arrkms['TGL_BL_AWB']);
								$result_plp = $func->main->get_result($PLP_KMS);
								if($result_plp){
									$insertKemasan = false;
								}
							}
						}
						if($insertKemasan){
							for($a=0; $a<count($arr_kms); $a++){
								$kms = explode("~",$arr_kms[$a]);
								$SQL_KMS = "SELECT KD_KEMASAN, JUMLAH, NO_BL_AWB, TGL_BL_AWB
											FROM t_cocostskms
											WHERE ID = ".$this->db->escape($kms[0])."
											AND SERI = ".$this->db->escape($kms[1]);
								$result_kms = $func->main->get_result($SQL_KMS);
								if($result_kms){
									foreach($SQL_KMS->result_array() as $row => $value){
										$arrkms = $value;
									}
									$arrkms['ID'] = $ID_PLP;
									$arrkms['JML_KMS'] = $arrkms['JUMLAH'];
									unset($arrkms['JUMLAH']);
									$this->db->insert('t_request_plp_kms',$arrkms);
								}
							}
						}else{
							$error += 1;
							$message = "Data gagal diproses, periksa No. BL/AWB dan Tgl. BL/AWB";
						}	
					}
				}else{
					$error += 1;
					$message = "Data gagal diproses, periksa data kembali";
				}
				if($error == 0){
					$func->main->get_log("add","t_request_plp_hdr,t_request_plp_kms");
					echo "MSG#OK#Data berhasil diproses#".site_url()."/plp/pengajuan";
				}else{
					echo "MSG#ERR#".$message."#";
				}
			}else if($act=="send_pengajuan"){
				$sendData = true;
				foreach($this->input->post('tb_chktblplp') as $chkitem){
					$arrchk = explode("~", $chkitem);
					$status = $arrchk[2];
					if($status!="100"){
						$sendData = false;
					}
				}
				if($sendData){
					foreach($this->input->post('tb_chktblplp') as $chkitem){
						$arrchk = explode("~", $chkitem);
						$id_plp = $arrchk[0];
						$this->db->where(array('ID'=>$id_plp));
						$this->db->update('t_request_plp_hdr',array('KD_STATUS'=>'200'));
					}	
				}else{
					$error += 1;
					$message = "Data gagal diproses";
				}
				if($error == 0){
					$func->main->get_log("update","t_request_plp_hdr");
					echo "MSG#OK#Data berhasil diproses#".site_url()."/plp/pengajuan/post";
				}else{
					echo "MSG#ERR#".$message."#";
				}
			}else if($act=="pembatalan"){
				$arrid = explode("~",$id);
				foreach($this->input->post('DATA') as $a => $b){
					if($b=="") $DATA[$a] = NULL;
					else $DATA[$a] = strtoupper($b);
				}
				$DATA['TGL_SURAT'] = date_input($DATA['TGL_SURAT']);
				$DATA['KD_STATUS'] = '100';
				$DATA['TGL_STATUS'] = date('Y-m-d H:i:s');
				$SQL = "SELECT A.ID
						FROM t_request_batal_plp_hdr A
						WHERE A.NO_SURAT = ".$this->db->escape(trim($DATA['NO_SURAT']))."
						AND A.TGL_SURAT = ".$this->db->escape(trim($DATA['TGL_SURAT']));
				$result = $func->main->get_result($SQL);
				if($result){
					foreach($SQL->result_array() as $row => $value){
						$arrdata = $value;
					}
					$ID_PLP = $arrdata['ID'];
				}
				if($ID_PLP==$arrid[0]){
					$this->db->where(array('ID' => $arrid[0]));
					$exec = $this->db->update('t_request_batal_plp_hdr', $DATA);
					if($exec){
						$this->db->delete('t_request_batal_plp_kms',array('ID'=>$arrid[0]));	
						$id_kms = $this->input->post('tmpchktblkemasanplp');
						$arr_kms = explode("*",$id_kms);
						$insertKemasan = true;
						for($a=0; $a<count($arr_kms)-1; $a++){
							$kms = explode("~",$arr_kms[$a]);
							$PLP_KMS = "SELECT ID
										FROM t_request_batal_plp_kms 
										WHERE KD_KEMASAN = ".$this->db->escape(trim($kms[1]))."
										AND NO_BL_AWB = ".$this->db->escape(trim($kms[2]))."
										AND TGL_BL_AWB = ".$this->db->escape(trim($kms[3]));
							$result_kms = $func->main->get_result($PLP_KMS);
							if($result_kms){
								$insertKemasan = false;
							}
						}
						if($insertKemasan){
							for($a=0; $a<count($arr_kms)-1; $a++){
								$kms = explode("~",$arr_kms[$a]);
								$KMS['ID'] = $ID_PLP;
								$KMS['KD_KEMASAN'] = $kms[1];
								$KMS['NO_BL_AWB'] = $kms[2];
								$KMS['TGL_BL_AWB'] = $kms[3];
								$KMS['JML_KMS'] = $kms[4];
								$this->db->insert('t_request_batal_plp_kms',$KMS);
							}
						}else{
							$error += 1;
							$message .= "Data gagal diproses, periksa No. BL/AWB dan Tgl. BL/AWB";
						}
					}
				}else{
					$error += 1;
					$message = "Data gagal diproses, periksa data kembali";
				}
				if($error == 0){
					$func->main->get_log("update","t_request_batal_plp_hdr,t_request_batal_plp_kms");
					echo "MSG#OK#Data berhasil diproses#".site_url()."/plp/pembatalan";
				}else{
					echo "MSG#ERR#".$message."#";
				}
			}else if($act=="send_pembatalan"){
				$sendData = true;
				foreach($this->input->post('tb_chktblplp') as $chkitem){
					$arrchk = explode("~", $chkitem);
					$status = $arrchk[2];
					if($status!="100"){
						$sendData = false;
					}
				}
				if($sendData){
					foreach($this->input->post('tb_chktblplp') as $chkitem){
						$arrchk = explode("~", $chkitem);
						$id_plp = $arrchk[0];
						$this->db->where(array('ID'=>$id_plp));
						$this->db->update('t_request_batal_plp_hdr',array('KD_STATUS'=>'200'));
					}	
				}else{
					$error += 1;
					$message = "Data gagal diproses";
				}
				if($error == 0){
					$func->main->get_log("update","t_request_batal_plp_hdr");
					echo "MSG#OK#Data berhasil diproses#".site_url()."/plp/pembatalan/post";
				}else{
					echo "MSG#ERR#".$message."#";
				}
			
			}
		}else if($type=="delete"){
			if($act=="pengajuan"){
				$deleteData = true;
				foreach($this->input->post('tb_chktblplp') as $chkitem){
					$arrchk = explode("~", $chkitem);
					$id_plp = $arrchk[0];
					$id_hdr = $arrchk[1];
					$status = $arrchk[2];
					if($status!="100"){
						$deleteData = false;
					}
				}
				if($deleteData){
					foreach($this->input->post('tb_chktblplp') as $chkitem){
						$arrchk = explode("~", $chkitem);
						$id_plp = $arrchk[0];
						$this->db->delete('t_request_plp_status',array('ID'=>$id_plp));
						$this->db->delete('t_request_plp_kms',array('ID'=>$id_plp));
						$this->db->delete('t_request_plp_hdr',array('ID'=>$id_plp));
					}	
				}else{
					$error += 1;
					$message = "Data gagal diproses";
				}
				if($error == 0){
					$func->main->get_log("delete","t_request_plp_hdr,t_request_plp_kms,t_request_plp_status");
					echo "MSG#OK#Data berhasil diproses#".site_url()."/plp/pengajuan/post";
				}else{
					echo "MSG#ERR#".$message."#";
				}
			}else if($act=="pembatalan"){
				$deleteData = true;
				foreach($this->input->post('tb_chktblplp') as $chkitem){
					$arrchk = explode("~", $chkitem);
					$id_plp = $arrchk[0];
					$id_respon = $arrchk[1];
					$status = $arrchk[2];
					if($status!="100"){
						$deleteData = false;
					}
				}
				if($deleteData){
					foreach($this->input->post('tb_chktblplp') as $chkitem){
						$arrchk = explode("~", $chkitem);
						$id_plp = $arrchk[0];
						$this->db->delete('t_request_batal_plp_status',array('ID'=>$id_plp));
						$this->db->delete('t_request_batal_plp_kms',array('ID'=>$id_plp));
						$this->db->delete('t_request_batal_plp_hdr',array('ID'=>$id_plp));
					}	
				}else{
					$error += 1;
					$message = "Data gagal diproses";
				}
				if($error == 0){
					$func->main->get_log("delete","t_request_batal_plp_hdr,t_request_batal_plp_kms,t_request_batal_plp_status");
					echo "MSG#OK#Data berhasil diproses#".site_url()."/plp/pembatalan/post";
				}else{
					echo "MSG#ERR#".$message."#";
				}
			}
		}else if($type=="get"){
			if($act=="respon_plp"){
				$arrid = explode("|",$id);
				$SQL = "SELECT A.ID, A.KD_KPBC, A.KD_TPS_ASAL, A.KD_TPS_TUJUAN, A.KD_GUDANG_TUJUAN, A.NO_PLP, A.TGL_PLP, A.NO_SURAT, 
						A.TGL_SURAT, A.NM_ANGKUT, A.NO_VOY_FLIGHT, A.CALL_SIGN, DATE_FORMAT(A.TGL_TIBA,'%d-%m-%Y') AS TGL_TIBA, A.NO_BC11, 
						DATE_FORMAT(A.TGL_BC11,'%d-%m-%Y') TGL_BC11
						FROM t_respon_plp_tujuan_v2_hdr A
						WHERE A.NO_PLP = ".$this->db->escape(trim($arrid[0]))."
						AND DATE_FORMAT(A.TGL_PLP,'%d-%m-%Y')=".$this->db->escape($arrid[1]);
				$result = $func->main->get_result($SQL);
				if($result){
					foreach($SQL->result_array() as $row => $value){
						$arrdata = $value;
					}
				}else {
					$arrdata = array('ID' => '');
				}
				echo json_encode($arrdata);
			}else if($act=="cocostshdr"){
				$arrid = explode("~",$id);
				$SQL = "SELECT A.*, B.NAMA AS NAMA_KAPAL, B.CALL_SIGN, func_name(A.KD_ASAL_BRG,'ASAL_BARANG') AS ASAL_BARANG,
						func_name(A.KD_ASAL_BRG,'ASAL_BARANG') AS ASAL_BARANG, func_name(A.KD_GUDANG,'GUDANG') AS GUDANG,
						func_name(A.KD_KAPAL,'KAPAL') AS NAMA_KAPAL, DATE_FORMAT(A.TGL_TIBA,'%d-%m-%Y') AS TGL_TIBA, 
						func_name(A.KD_PEL_MUAT,'PORT') AS PEL_MUAT, func_name(A.KD_PEL_TRANSIT,'PORT') AS PEL_TRANSIT,
						func_name(A.KD_PEL_BONGKAR,'port') AS PEL_BONGKAR, DATE_FORMAT(A.TGL_BC11,'%d-%m-%Y') AS TGL_BC11, 
						DATE_FORMAT(A.WK_REKAM,'%d-%m-%Y %H:%i:%s') AS TGL_REKAM, func_name(A.KD_TPS,'TPS') AS TPS,
						DATE_FORMAT(A.TGL_PLP,'%d-%m-%Y') TGL_PLP
						FROM t_cocostshdr A
						INNER JOIN reff_kapal B ON B.ID=A.KD_KAPAL
						WHERE A.ID = ".$this->db->escape($arrid[0]);
				$result = $func->main->get_result($SQL);
				if($result){
					foreach($SQL->result_array() as $row => $value){
						$arrdata = $value;
					}
					return $arrdata;
				}else {
					redirect(site_url(), 'refresh');
				}
			}else if($act=="cocostskms"){
				$arrid = explode("~",$id);
				if($arrid[0]!=""){
					$addsql .= " AND A.ID = ".$this->db->escape($arrid[0]);
				}
				if($arrid[1]!=""){
					$addsql .= " AND A.SERI = ".$this->db->escape($arrid[1]);
				}
				$SQL = "SELECT A.*, func_name(A.KD_KEMASAN,'KEMASAN') AS KEMASAN, func_name(A.KD_DOK_IN,'DOK_BC') AS NAMA_DOK_IN,
						func_name(A.KD_PEL_MUAT,'PORT') AS PEL_MUAT, func_name(A.KD_PEL_TRANSIT,'PORT') AS PEL_TRANSIT, 
						func_name(A.KD_PEL_BONGKAR,'PORT') AS PEL_BONGKAR, B.NAMA AS CONSIGNEE, 
						DATE_FORMAT(A.WK_IN,'%d-%m-%Y %H:%i:%s') AS WK_IN,
						DATE_FORMAT(A.WK_OUT,'%d-%m-%Y %H:%i:%s') AS WK_OUT, func_name(A.KD_DOK_OUT,'DOK_BC') AS NAMA_DOK_OUT
						FROM t_cocostskms A
						LEFT JOIN t_organisasi B ON B.ID=A.KD_ORG_CONSIGNEE
						WHERE 1=1".$addsql;
				$result = $func->main->get_result($SQL);
				if($result){
					foreach($SQL->result_array() as $row => $value){
						$arrdata = $value;
					}
					return $arrdata;
				}else {
					redirect(site_url(), 'refresh');
				}
			}else if($act=="plp_hdr"){
				$arrid = explode("~",$id);
				if($arrid[0]!=""){
					$addsql .= " AND A.ID = ".$this->db->escape($arrid[0]);
				}
				if($arrid[1]!=""){
					$addsql .= " AND A.KD_COCOSTSHDR = ".$this->db->escape($arrid[1]);
				}
				$SQL = "SELECT A.*, DATE_FORMAT(A.TGL_SURAT,'%d-%m-%Y') AS TGL_SURAT, func_name(A.KD_TPS_TUJUAN,'TPS') AS TPS_TUJUAN,
						func_name(A.KD_GUDANG_TUJUAN,'GUDANG') AS GUDANG_TUJUAN, B.NAMA AS NM_KAPAL, B.CALL_SIGN, C.NAMA AS ALASAN_PLP
						FROM t_request_plp_hdr A
						LEFT JOIN reff_kapal B ON B.ID=A.KD_KAPAL
						LEFT JOIN reff_alasan_plp C ON C.ID=A.KD_ALASAN_PLP
						WHERE 1=1".$addsql;
				$result = $func->main->get_result($SQL);
				if($result){
					foreach($SQL->result_array() as $row => $value){
						$arrdata = $value;
					}
					return $arrdata;
				}else {
					redirect(site_url(), 'refresh');
				}
			}else if($act=="respon_plp_asal_hdr"){
				$arrid = explode("~",$id);
				if($arrid[0]!=""){
					$addsql .= " AND A.ID = ".$this->db->escape($arrid[0]);
				}
				$SQL = "SELECT A.*, func_name(A.KD_TPS,'TPS') AS TPS
						FROM t_respon_plp_asal_hdr A
						WHERE 1=1".$addsql;
				$result = $func->main->get_result($SQL);
				if($result){
					foreach($SQL->result_array() as $row => $value){
						$arrdata = $value;
					}
					return $arrdata;
				}else {
					redirect(site_url(), 'refresh');
				}
			}else if($act=="request_batal_plp_hdr"){
				$arrid = explode("~",$id);
				if($arrid[0]!=""){
					$addsql .= " AND A.ID = ".$this->db->escape($arrid[0]);
				}
				$SQL = "SELECT *, func_name(A.KD_TPS,'TPS') AS TPS, func_name(A.KD_GUDANG,'GUDANG') AS GUDANG
						FROM t_request_batal_plp_hdr A
						INNER JOIN t_respon_plp_asal_hdr B ON B.ID=A.KD_RESPON_PLP_ASAL
						WHERE 1=1".$addsql;
				$result = $func->main->get_result($SQL);
				if($result){
					foreach($SQL->result_array() as $row => $value){
						$arrdata = $value;
					}
					return $arrdata;
				}else {
					redirect(site_url(), 'refresh');
				}
			}else if($act=="request_batal_plp_kms"){
				$arrid = explode("~",$id);
				if($arrid[0]!=""){
					$addsql .= " AND A.ID = ".$this->db->escape($arrid[0]);
				}
				$SQL = "SELECT A.*, func_name(A.KD_KEMASAN,'KEMASAN') AS KEMASAN
						FROM t_request_batal_plp_kms A
						WHERE 1=1".$addsql;
				$result = $func->main->get_result($SQL);
				if($result){
					foreach($SQL->result_array() as $row => $value){
						$arrdata = $value;
					}
					return $arrdata;
				}else {
					redirect(site_url(), 'refresh');
				}
			}else if($act=="respon_plp_tujuan_hdr"){
				$arrid = explode("~",$id);
				if($arrid[0]!=""){
					$addsql .= " AND A.ID = ".$this->db->escape($arrid[0]);
				}
				$SQL = "SELECT A.*, func_name(A.KD_TPS_ASAL,'TPS') AS TPS_ASAL, func_name(A.KD_TPS_TUJUAN,'TPS') AS TPS_TUJUAN,
						func_name(A.KD_GUDANG_TUJUAN,'GUDANG') AS GUDANG_TUJUAN
						FROM t_respon_plp_tujuan_v2_hdr A
						WHERE 1=1".$addsql;
				$result = $func->main->get_result($SQL);
				if($result){
					foreach($SQL->result_array() as $row => $value){
						$arrdata = $value;
					}
					return $arrdata;
				}else {
					redirect(site_url(), 'refresh');
				}
			}else if($act=="respon_batal_plp_asal_hdr"){
				$arrid = explode("~",$id);
				if($arrid[0]!=""){
					$addsql .= " AND A.ID = ".$this->db->escape($arrid[0]);
				}
				$SQL = "SELECT *, func_name(A.KD_TPS,'TPS') AS TPS
						FROM t_respon_batal_plp_asal_hdr A
						WHERE 1=1".$addsql;
				$result = $func->main->get_result($SQL);
				if($result){
					foreach($SQL->result_array() as $row => $value){
						$arrdata = $value;
					}
					return $arrdata;
				}else {
					redirect(site_url(), 'refresh');
				}
			}else if($act=="respon_batal_plp_tujuan_hdr"){
				$arrid = explode("~",$id);
				if($arrid[0]!=""){
					$addsql .= " AND A.ID = ".$this->db->escape($arrid[0]);
				}
				$SQL = "SELECT *, func_name(A.KD_TPS,'TPS') AS TPS, func_name(A.KD_TPS_ASAL,'TPS') AS TPS_ASAL
						FROM t_respon_batal_plp_tujuan_hdr A
						WHERE 1=1".$addsql;
				$result = $func->main->get_result($SQL);
				if($result){
					foreach($SQL->result_array() as $row => $value){
						$arrdata = $value;
					}
					return $arrdata;
				}else {
					redirect(site_url(), 'refresh');
				}
			}
		}
	}
	
	function set_seri($table,$id){
		$func = get_instance();
        $func->load->model("m_main", "main", true);
		$SQL = "SELECT IFNULL(MAX(SERI)+1,1) AS SERI 
				FROM $table 
				WHERE ID = ".$this->db->escape($id);
		$result = $func->main->get_result($SQL);
		if($result){
			$seri = $SQL->row()->SERI;
		}	
		return $seri;
	}
	
	function pengajuan($act, $id){
		$this->newtable->breadcrumb('Home', site_url());
		$this->newtable->breadcrumb('PLP', site_url());
		$this->newtable->breadcrumb('Pengajuan PLP', 'javascript:void(0)');
		$judul = "PENGAJUAN PLP";
		$check = (grant()=="W")?true:false;
		$this->newtable->show_chk($check);
		$KD_TPS = $this->newsession->userdata('KD_TPS');
		$KD_GUDANG = $this->newsession->userdata('KD_GUDANG');
		$KD_GROUP = $this->newsession->userdata('KD_GROUP');
		if($KD_GROUP!="SPA"){
			$addsql .= " AND A.KD_TPS_ASAL = ".$this->db->escape($KD_TPS)." AND A.KD_GUDANG_ASAL = ".$this->db->escape($KD_GUDANG);
		}
		$SQL = "SELECT CONCAT('NO. ',A.NO_SURAT,'<BR>TGL. ',A.TGL_SURAT) AS 'SURAT PENGAJUAN',
				CONCAT('TPS : ',func_name(A.KD_TPS_TUJUAN,'TPS'),' [',A.KD_TPS_TUJUAN,']
				<BR>GUDANG : ',func_name(A.KD_GUDANG_TUJUAN,'GUDANG'),' [',A.KD_GUDANG_TUJUAN,']') AS 'TPS/GUDANG TUJUAN',
				CONCAT(B.NAMA,' [',A.KD_KAPAL,']') AS 'SARANA ANGKUT', A.NO_VOY_FLIGHT AS 'NO. VOYAGE/FLIGHT', 
				DATE_FORMAT(A.TGL_TIBA,'%d-%m-%Y') AS 'TGL. TIBA', 
				CONCAT('NO. ',A.NO_BC11,'<BR>TGL. ',DATE_FORMAT(A.TGL_BC11,'%d-%m-%Y')) AS BC11,
				CONCAT(C.NAMA,'<BR>',DATE_FORMAT(A.TGL_STATUS,'%d-%m-%Y %H:%i:%s')) AS STATUS, A.ID, A.KD_COCOSTSHDR, A.KD_STATUS, A.TGL_STATUS
				FROM t_request_plp_hdr A
				LEFT JOIN reff_kapal B ON B.ID=A.KD_KAPAL
				LEFT JOIN reff_status C ON C.ID=A.KD_STATUS AND C.KD_TIPE_STATUS = 'PLPAJU'
				WHERE 1=1".$addsql;


		$proses = array('ENTRY'  => array('ADD_MODAL',"plp/stacking", '0','','icon-plus','80'),
						'UPDATE' => array('GET',site_url()."/plp/pengajuan/update", '1','100','icon-reload'),
						'HAPUS' => array('POST',site_url()."/plp/execute/delete/pengajuan", 'ALL','100','icon-trash'),
						'KIRIM' => array('POST',site_url()."/plp/execute/update/send_pengajuan", 'ALL','100','icon-share-alt'));
		
    $this->newtable->multiple_search(true);
		$this->newtable->show_search(true);
		$this->newtable->search(array(array('A.NM_ANGKUT','NAMA ANGKUT'),array('A.NO_VOY_FLIGHT','NO. VOYAGE/FLIGHT','TEXT')));
		$this->newtable->action(site_url() . "/plp/pengajuan");
		$this->newtable->detail(array('POPUP',"plp/pengajuan/detail"));
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID","KD_COCOSTSHDR","KD_STATUS","TGL_STATUS"));
		$this->newtable->keys(array("ID","KD_COCOSTSHDR","KD_STATUS","TGL_STATUS"));
		$this->newtable->validasi(array("KD_STATUS"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby(11);
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("tblplp");
		$this->newtable->set_divid("divtblplp");
		$this->newtable->rowcount(10);
		$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate($SQL);
		$arrdata = array("title" => $judul, "content" => $tabel);
		if($this->input->post("ajax") || $act == "post")
			echo $tabel;
		else
			return $arrdata;
	}
	
	function stacking($act,$id){
		$judul = "DATA BONGKAR";
		$KD_TPS = $this->newsession->userdata('KD_TPS');
		$KD_GUDANG = $this->newsession->userdata('KD_GUDANG');
		$KD_GROUP = $this->newsession->userdata('KD_GROUP');
		if($KD_GROUP!="SPA"){
			$addsql .= " AND A.KD_TPS = ".$this->db->escape($KD_TPS)." AND A.KD_GUDANG = ".$this->db->escape($KD_GUDANG);
		}
		$SQL = "SELECT B.NAMA_GUDANG AS GUDANG, CONCAT(C.NAMA,'<BR>[',A.NM_ANGKUT,']') AS 'NAMA ANGKUT', C.CALL_SIGN AS 'CALL SIGN', 
				A.NO_VOY_FLIGHT AS 'NO. VOY FLIGHT', 
				DATE_FORMAT(A.TGL_TIBA,'%d-%m-%Y') AS 'TGL. TIBA', A.NO_BC11 AS 'NO. BC11',
				DATE_FORMAT(A.TGL_BC11,'%d-%m-%Y') AS 'TGL. BC11', A.ID
				FROM t_cocostshdr A 
				LEFT JOIN reff_gudang B ON A.KD_TPS = B.KD_TPS AND A.KD_GUDANG = B.KD_GUDANG 
				LEFT JOIN reff_kapal C ON A.KD_KAPAL = C.ID
				WHERE A.KD_ASAL_BRG = '1'".$addsql;
		$proses = array('SELECT'  => array('GET',site_url()."/plp/pengajuan/add", '1','','icon-check','','1'));
		$this->newtable->show_chk(true);
		$this->newtable->multiple_search(true);
		$this->newtable->show_search(true);
		$this->newtable->search(array(array('A.NO_BC11','NO. BC11'),array('C.NAMA','NAMA ANGKUT')));
		$this->newtable->action(site_url() . "/plp/stacking");
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID"));
		$this->newtable->keys(array("ID"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby(8);
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("tblstacking");
		$this->newtable->set_divid("divtblstacking");
		$this->newtable->rowcount(10);
		$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate($SQL);
		$arrdata = array("title" => $judul, "content" => $tabel);
		if($this->input->post("ajax") || $act == "post")
			return $tabel;
		else
			return $arrdata;	
	}
	
	function table_kemasan($act,$id){
		$judul = "DATA KEMASAN";
		$KD_TPS = $this->newsession->userdata('KD_TPS');
		$KD_GUDANG = $this->newsession->userdata('KD_GUDANG');
		$KD_GROUP = $this->newsession->userdata('KD_GROUP');
		if($KD_GROUP!="SPA"){
			$addsql .= " AND B.KD_TPS = ".$this->db->escape($KD_TPS)." AND B.KD_GUDANG = ".$this->db->escape($KD_GUDANG);
		}
		$SQL = "SELECT A.KD_KEMASAN AS KEMASAN, A.JUMLAH, A.NO_BL_AWB AS 'NO. BL/AWB', DATE_FORMAT(A.TGL_BL_AWB,'%d-%m-%Y') AS 'TGL. BL/AWB',
				A.BRUTO, C.NAMA AS CONISGNEE, A.WK_IN AS 'DISCHARGE', A.ID, A.SERI
				FROM t_cocostskms A
				LEFT JOIN t_cocostshdr B ON B.ID=A.ID
				LEFT JOIN t_organisasi C ON C.ID=A.KD_ORG_CONSIGNEE
				WHERE A.WK_IN IS NOT NULL AND A.WK_IN <> ''
				AND A.ID = ".$this->db->escape($id).$addsql;
		$this->newtable->show_chk(true);
		$this->newtable->multiple_search(false);
		$this->newtable->show_search(true);
		$this->newtable->search(array(array('A.KD_KEMASAN', 'KODE KEMASAN'),array('A.NO_BL_AWB', 'NO. BL/AWB')));
		$this->newtable->action(site_url() . "/plp/table_kemasan/".$act."/".$id);
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID","SERI"));
		$this->newtable->keys(array("ID","SERI"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby(1);
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("tblkemasan");
		$this->newtable->set_divid("divtblkemasan");
		$this->newtable->rowcount(10);
		$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate($SQL);
		$arrdata = array("title" => $judul, "content" => $tabel);
		if($this->input->post("ajax")||$act=="post")
			echo $tabel;
		else
			return $arrdata;	
	}
	
	function table_kemasan_plp($act,$id){
		$arrid = explode("~",$id);
		$judul = "DATA KEMASAN PLP";
		$SQL = "SELECT CONCAT(func_name(A.KD_KEMASAN,'KEMASAN'),' [',A.KD_KEMASAN,']') AS KEMASAN, 
				A.JML_KMS AS JUMLAH, A.NO_BL_AWB AS 'NO. BL/AWB', DATE_FORMAT(A.TGL_BL_AWB,'%d-%m-%Y') AS 'TGL. BL/AWB'
				FROM t_request_plp_kms A
				WHERE A.ID = ".$this->db->escape($arrid[0]);
		$this->newtable->show_chk(false);
		$this->newtable->multiple_search(false);
		$this->newtable->show_search(true);
		$this->newtable->search(array(array('A.KD_KEMASAN', 'KODE KEMASAN'),array('A.NO_BL_AWB', 'NO. BL/AWB')));
		$this->newtable->action(site_url() . "/plp/table_kemasan_plp/".$act."/".$id);
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID","SERI"));
		$this->newtable->keys(array("ID","SERI"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby(1);
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("tblkemasanplp");
		$this->newtable->set_divid("divtblkemasanplp");
		$this->newtable->rowcount(10);
		$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate($SQL);
		$arrdata = array("title" => $judul, "content" => $tabel);
		if($this->input->post("ajax")||$act=="post")
			echo $tabel;
		else
			return $arrdata;	
	}
	
	function pembatalan($act, $id){
		$this->newtable->breadcrumb('Home', site_url());
		$this->newtable->breadcrumb('PLP', site_url());
		$this->newtable->breadcrumb('Pembatalan PLP', 'javascript:void(0)');
		$judul = "DATA PENGAJUAN PLP";
		$KD_TPS = $this->newsession->userdata('KD_TPS');
		$KD_GUDANG = $this->newsession->userdata('KD_GUDANG');
		$KD_GROUP = $this->newsession->userdata('KD_GROUP');
		if($KD_GROUP!="SPA"){
			$addsql = " AND A.KD_TPS = ".$this->db->escape($KD_TPS)." AND A.KD_GUDANG = ".$this->db->escape($KD_GUDANG);
		}
		$SQL = "SELECT CONCAT('NO. : ',IFNULL(A.NO_SURAT,'-'),'<BR>TGL. : ',IFNULL(DATE_FORMAT(A.TGL_SURAT,'%d-%m-%Y'),'-')) AS 'SURAT PLP',
        CONCAT('NO. : ',IFNULL(B.NO_PLP,'-'),'<BR>TGL. : ',IFNULL(DATE_FORMAT(B.TGL_PLP,'%d-%m-%Y'),'-')) AS 'RESPON PLP',
        A.NM_PEMOHON AS 'NAMA PEMOHON', A.ALASAN,
        CONCAT(C.NAMA,'<BR>',DATE_FORMAT(A.TGL_STATUS,'%d-%m-%Y %H:%i:%s')) AS STATUS, 
        A.TGL_STATUS, A.KD_STATUS, A.KD_RESPON_PLP_ASAL, A.ID
        FROM t_request_batal_plp_hdr A
        INNER JOIN t_respon_plp_asal_hdr B ON B.ID=A.KD_RESPON_PLP_ASAL
        LEFT JOIN reff_status C ON C.ID=A.KD_STATUS AND C.KD_TIPE_STATUS='BTLPLP'
        WHERE 1=1".$addsql;
	
    $proses = array('ENTRY'  => array('ADD_MODAL',"plp/respon_plp_asal", '0','','icon-plus','70'),
						'UPDATE' => array('GET',site_url()."/plp/pembatalan/update", '1','100','icon-reload'),
						'HAPUS' => array('POST',site_url()."/plp/execute/delete/pembatalan", 'ALL','100','icon-trash'),
						'KIRIM' => array('POST',site_url()."/plp/execute/update/send_pembatalan", 'ALL','100','icon-share-alt'));
	

    $check = (grant()=="W")?true:false;
		$this->newtable->show_chk($check);
		$this->newtable->multiple_search(true);
		$this->newtable->show_search(true);
		$this->newtable->search(array(array('A.NO_SURAT','NO. PLP')));
		$this->newtable->action(site_url() . "/plp/pembatalan");
		$this->newtable->detail(array('POPUP',"plp/pembatalan/detail"));
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID","KD_RESPON_PLP_ASAL","KD_STATUS"));
		$this->newtable->keys(array("ID","KD_RESPON_PLP_ASAL","KD_STATUS"));
		$this->newtable->validasi(array("KD_STATUS"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby(4);
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("tblplp");
		$this->newtable->set_divid("divtblplp");
		$this->newtable->rowcount(10);
		$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate($SQL);
		$arrdata = array("title" => $judul, "content" => $tabel);
		if($this->input->post("ajax") || $act == "post")
			echo $tabel;
		else
			return $arrdata;
	}
	
	function respon_plp_asal($act,$id){
		$judul = "DATA RESPON PLP ASAL";
		$KD_TPS = $this->newsession->userdata('KD_TPS');
		$KD_GUDANG = $this->newsession->userdata('KD_GUDANG');
		$KD_GROUP = $this->newsession->userdata('KD_GROUP');
		$this->newtable->show_chk(true);
		if($KD_GROUP != "SPA"){
			$addsql = " AND A.KD_TPS = ".$this->db->escape($KD_TPS);
		}
		$SQL = "SELECT CONCAT(B.NAMA_TPS,' [',A.KD_TPS,']') AS TPS, 
				CONCAT('NO. ',A.NO_PLP,'<BR>TGL. ',A.TGL_PLP) AS PLP, A.ALASAN_REJECT AS 'ALASAN BATAL', 
				CONCAT(C.NAMA,'<BR>',DATE_FORMAT(A.TGL_STATUS,'%d-%m-%Y %H:%i:%s')) AS STATUS, A.ID
				FROM t_respon_plp_asal_hdr A 
				INNER JOIN reff_tps B ON A.KD_TPS = B.KD_TPS
				INNER JOIN reff_status C ON A.KD_STATUS = C.ID AND C.KD_TIPE_STATUS = 'PLPRES'
				WHERE 1=1".$addsql;
		$proses = array('SELECT'  => array('GET',site_url()."/plp/pembatalan/add", '1','','icon-check','','1'));
		$this->newtable->multiple_search(true);
		$this->newtable->show_search(true);
		$this->newtable->search(array(array('A.NO_PLP','NO. PLP'),array('A.TGL_PLP','TGL. PLP','DATERANGE')));
		$this->newtable->action(site_url() . "/plp/respon_plp_asal");
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID"));
		$this->newtable->keys(array("ID"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby(5);
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("tblresponplp");
		$this->newtable->set_divid("divtblresponplp");
		$this->newtable->rowcount(10);
		$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate($SQL);
		$arrdata = array("title" => $judul, "content" => $tabel);
		if($this->input->post("ajax") || $act == "post")
			return $tabel;
		else
			return $arrdata;	
	}
	
	function table_res_plp_asalkms($act,$id){
		$arrid = explode("~",$id);
		$judul = "DATA RESPON PLP KEMASAN";
		$SQL = "SELECT CONCAT(func_name(A.KD_KEMASAN,'KEMASAN'),' [',A.KD_KEMASAN,']') AS KEMASAN, 
				A.JML_KMS AS JUMLAH, A.NO_BL_AWB AS 'NO. BL/AWB', DATE_FORMAT(A.TGL_BL_AWB,'%d-%m-%Y') AS 'TGL. BL/AWB', 
				A.ID, A.KD_KEMASAN, A.NO_BL_AWB, A.TGL_BL_AWB, A.JML_KMS
				FROM t_respon_plp_asal_kms A
				WHERE A.ID = ".$this->db->escape($arrid[0]);
		$this->newtable->show_chk(true);
		$this->newtable->multiple_search(false);
		$this->newtable->show_search(true);
		$this->newtable->search(array(array('A.KD_KEMASAN', 'KODE KEMASAN'),array('A.NO_BL_AWB', 'NO. BL/AWB')));
		$this->newtable->action(site_url() . "/plp/table_res_plp_asalkms/".$act."/".$id);
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID","KD_KEMASAN","NO_BL_AWB","TGL_BL_AWB","JML_KMS"));
		$this->newtable->keys(array("ID","KD_KEMASAN","NO_BL_AWB","TGL_BL_AWB","JML_KMS"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby(1);
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("tblkemasanplp");
		$this->newtable->set_divid("divtblkemasanplp");
		$this->newtable->rowcount(10);
		$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate($SQL);
		$arrdata = array("title" => $judul, "content" => $tabel);
		if($this->input->post("ajax")||$act=="post")
			echo $tabel;
		else
			return $arrdata;	
	}
	
	function table_reqbtl_plp_kms($act,$id){
		$arrid = explode("~",$id);
		$judul = "DATA REQUEST PEMBATALAN PLP KEMASAN";
		$SQL = "SELECT CONCAT(func_name(A.KD_KEMASAN,'KEMASAN'),' [',A.KD_KEMASAN,']') AS KEMASAN, 
				A.JML_KMS AS JUMLAH, A.NO_BL_AWB AS 'NO. BL/AWB', DATE_FORMAT(A.TGL_BL_AWB,'%d-%m-%Y') AS 'TGL. BL/AWB', A.ID
				FROM t_request_batal_plp_kms A
				WHERE A.ID = ".$this->db->escape($arrid[0]);
		$this->newtable->show_chk(false);
		$this->newtable->multiple_search(false);
		$this->newtable->show_search(true);
		$this->newtable->search(array(array('A.KD_KEMASAN', 'KODE KEMASAN'),array('A.NO_BL_AWB', 'NO. BL/AWB')));
		$this->newtable->action(site_url() . "/plp/table_reqbtl_plp_kms/".$act."/".$id);
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID"));
		$this->newtable->keys(array("ID"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby(1);
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("tblkemasanplp");
		$this->newtable->set_divid("divtblkemasanplp");
		$this->newtable->rowcount(10);
		$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate($SQL);
		$arrdata = array("title" => $judul, "content" => $tabel);
		if($this->input->post("ajax")||$act=="post")
			echo $tabel;
		else
			return $arrdata;	
	}
	
	function res_plp_asal($act,$id){
		$this->newtable->breadcrumb('Home', site_url());
		$this->newtable->breadcrumb('PLP', 'javascript:void(0)');
		$this->newtable->breadcrumb('Respon PLP Asal', site_url('plp/res_plp_asal'));
		$judul = "DATA RESPON PLP ASAL";
		$KD_TPS = $this->newsession->userdata('KD_TPS');
		$KD_GUDANG = $this->newsession->userdata('KD_GUDANG');
		$KD_GROUP = $this->newsession->userdata('KD_GROUP');
		if($KD_GROUP!="SPA"){
			$addsql .= " AND A.KD_TPS = ".$this->db->escape($KD_TPS);
		}
		$SQL = "SELECT CONCAT(func_name(A.KD_TPS,'TPS'),' [',A.KD_TPS,']') AS TPS, A.NO_PLP AS 'NO. PLP',
				DATE_FORMAT(A.TGL_PLP,'%d-%m-%Y') AS 'TGL. PLP', A.ALASAN_REJECT AS ALASAN, B.NAMA AS STATUS, 
				DATE_FORMAT(A.TGL_STATUS,'%d-%m-%Y %H:%i:%s') AS 'TGL. STATUS', A.ID
				FROM t_respon_plp_asal_hdr A
				LEFT JOIN reff_status B ON B.ID=A.KD_STATUS AND B.KD_TIPE_STATUS='PLPRES'
				WHERE 1=1".$addsql;
		$proses = array('SELECT'  => array('GET',site_url()."/plp/pengajuan/add", '1','','icon-check','','1'));
		$this->newtable->show_chk(false);
		$this->newtable->multiple_search(true);
		$this->newtable->show_search(true);
		$this->newtable->search(array(array('A.NO_PLP','NO. PLP'),array('A.TGL_PLP','TGL. PLP','DATERANGE')));
		$this->newtable->action(site_url()."/plp/res_plp_asal");
		$this->newtable->detail(array('POPUP',"plp/res_plp_asal/detail"));
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID"));
		$this->newtable->keys(array("ID"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby(6);
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("tblplp");
		$this->newtable->set_divid("divtblplp");
		$this->newtable->rowcount(10);
		$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate($SQL);
		$arrdata = array("title" => $judul, "content" => $tabel);
		if($this->input->post("ajax") || $act == "post")
			return $tabel;
		else
			return $arrdata;	
	}
	
	function v_res_plp_asal_kms($act,$id){
		$arrid = explode("~",$id);
		$judul = "DATA RESPON PLP KEMASAN";
		$SQL = "SELECT CONCAT(func_name(A.KD_KEMASAN,'KEMASAN'),' [',A.KD_KEMASAN,']') AS KEMASAN, 
				A.JML_KMS AS JUMLAH, A.NO_BL_AWB AS 'NO. BL/AWB', DATE_FORMAT(A.TGL_BL_AWB,'%d-%m-%Y') AS 'TGL. BL/AWB', 
				A.ID, A.KD_KEMASAN, A.NO_BL_AWB, A.TGL_BL_AWB, A.JML_KMS
				FROM t_respon_plp_asal_kms A
				WHERE A.ID = ".$this->db->escape($arrid[0]);
		$this->newtable->show_chk(false);
		$this->newtable->multiple_search(false);
		$this->newtable->show_search(true);
		$this->newtable->search(array(array('A.KD_KEMASAN', 'KODE KEMASAN'),array('A.NO_BL_AWB', 'NO. BL/AWB')));
		$this->newtable->action(site_url() . "/plp/v_res_plp_asal_kms/".$act."/".$id);
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID","KD_KEMASAN","NO_BL_AWB","TGL_BL_AWB","JML_KMS"));
		$this->newtable->keys(array("ID","KD_KEMASAN","NO_BL_AWB","TGL_BL_AWB","JML_KMS"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby(1);
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("tblkemasanplp");
		$this->newtable->set_divid("divtblkemasanplp");
		$this->newtable->rowcount(10);
		$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate($SQL);
		$arrdata = array("title" => $judul, "content" => $tabel);
		if($this->input->post("ajax")||$act=="post")
			echo $tabel;
		else
			return $arrdata;	
	}
	
	function res_plp_tujuan($act,$id){
		$this->newtable->breadcrumb('Home', site_url());
		$this->newtable->breadcrumb('PLP', 'javascript:void(0)');
		$this->newtable->breadcrumb('Respon PLP Tujuan', site_url('plp/res_plp_asal'));
		$judul = "DATA RESPON PLP TUJUAN";
		$KD_TPS = $this->newsession->userdata('KD_TPS');
		$KD_GUDANG = $this->newsession->userdata('KD_GUDANG');
		$KD_GROUP = $this->newsession->userdata('KD_GROUP');
		if($KD_GROUP!="SPA"){
			$addsql .= " AND A.KD_TPS_TUJUAN = ".$this->db->escape($KD_TPS);
		}
		$SQL = "SELECT CONCAT(func_name(A.KD_TPS_ASAL,'TPS'),' [',A.KD_TPS_ASAL,']') AS 'TPS ASAL', 
				CONCAT('TPS : ',func_name(A.KD_TPS_TUJUAN,'TPS'),' [',A.KD_TPS_TUJUAN,']
				<BR>GUDANG : ',func_name(A.KD_GUDANG_TUJUAN,'GUDANG'),' [',A.KD_GUDANG_TUJUAN,']') AS 'TPS/GUDANG TUJUAN', 
				CONCAT('NO. ',A.NO_PLP,'<BR>TGL. ',DATE_FORMAT(A.TGL_PLP,'%d-%m-%Y')) AS PLP, 
				CONCAT('NAMA ANGKUT : ',A.NM_ANGKUT,'<BR>NO. VOYAGE : ',A.NO_VOY_FLIGHT,'<BR>CALL SIGN : ',A.CALL_SIGN,'
				<BR>TGL. TIBA : ',DATE_FORMAT(A.TGL_TIBA,'%d-%m-%Y')) AS 'DATA ANGKUT',
				B.NAMA AS STATUS, DATE_FORMAT(A.TGL_STATUS,'%d-%m-%Y %H:%i:%s') AS 'TGL. STATUS', A.ID
				FROM t_respon_plp_tujuan_v2_hdr A 
				LEFT JOIN reff_status B ON B.ID=A.KD_STATUS AND B.KD_TIPE_STATUS='PLPTUJ'
				WHERE 1=1".$addsql;
		$proses = array('SELECT'  => array('GET',site_url()."/plp/pengajuan/add", '1','','icon-check','','1'));
		$this->newtable->show_chk(false);
		$this->newtable->multiple_search(true);
		$this->newtable->show_search(true);
		$this->newtable->search(array(array('A.NO_PLP','NO. PLP'),array('A.TGL_PLP','TGL. PLP','DATERANGE')));
		$this->newtable->action(site_url() . "/plp/res_plp_tujuan");
		$this->newtable->detail(array('POPUP',"plp/res_plp_tujuan/detail"));
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID"));
		$this->newtable->keys(array("ID"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby(6);
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("tblplp");
		$this->newtable->set_divid("divtblplp");
		$this->newtable->rowcount(10);
		$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate($SQL);
		$arrdata = array("title" => $judul, "content" => $tabel);
		if($this->input->post("ajax") || $act == "post")
			return $tabel;
		else
			return $arrdata;	
	}
	
	function v_res_plp_tujuan_kms($act,$id){
		$arrid = explode("~",$id);
		$judul = "DATA RESPON PLP KEMASAN";
		$SQL = "SELECT CONCAT(func_name(A.KD_KEMASAN,'KEMASAN'),' [',A.KD_KEMASAN,']') AS KEMASAN, 
				A.JML_KMS AS JUMLAH, A.NO_BL_AWB AS 'NO. BL/AWB', DATE_FORMAT(A.TGL_BL_AWB,'%d-%m-%Y') AS 'TGL. BL/AWB', 
				A.ID, A.KD_KEMASAN, A.NO_BL_AWB, A.TGL_BL_AWB, A.JML_KMS
				FROM t_respon_plp_tujuan_v2_kms A
				WHERE A.ID = ".$this->db->escape($arrid[0]);
		$this->newtable->show_chk(false);
		$this->newtable->multiple_search(false);
		$this->newtable->show_search(true);
		$this->newtable->search(array(array('A.KD_KEMASAN', 'KODE KEMASAN'),array('A.NO_BL_AWB', 'NO. BL/AWB')));
		$this->newtable->action(site_url() . "/plp/v_res_plp_tujuan_kms/".$act."/".$id);
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID","KD_KEMASAN","NO_BL_AWB","TGL_BL_AWB","JML_KMS"));
		$this->newtable->keys(array("ID","KD_KEMASAN","NO_BL_AWB","TGL_BL_AWB","JML_KMS"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby(1);
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("tblkemasanplp");
		$this->newtable->set_divid("divtblkemasanplp");
		$this->newtable->rowcount(10);
		$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate($SQL);
		$arrdata = array("title" => $judul, "content" => $tabel);
		if($this->input->post("ajax")||$act=="post")
			echo $tabel;
		else
			return $arrdata;	
	}
	
	function res_batal_plp_asal($act,$id){
		$this->newtable->breadcrumb('Home', site_url());
		$this->newtable->breadcrumb('PLP', 'javascript:void(0)');
		$this->newtable->breadcrumb('Respon Batal PLP Asal', site_url('plp/res_plp_asal'));
		$judul = "DATA RESPON BATAL PLP ASAL";
		$KD_TPS = $this->newsession->userdata('KD_TPS');
		$KD_GUDANG = $this->newsession->userdata('KD_GUDANG');
		$KD_GROUP = $this->newsession->userdata('KD_GROUP');
		if($KD_GROUP!="SPA"){
			$addsql .= " AND A.KD_TPS = ".$this->db->escape($KD_TPS);
		}
		$SQL = "SELECT CONCAT(func_name(A.KD_TPS,'TPS'),' [',A.KD_TPS,']') AS TPS, 
				CONCAT('NO. ',A.NO_BATAL_PLP,'<BR>TGL. ',DATE_FORMAT(A.TGL_BATAL_PLP,'%d-%m-%Y')) AS PLP,
				B.NAMA AS STATUS, DATE_FORMAT(A.TGL_STATUS,'%d-%m-%Y %H:%i:%s') AS 'TGL. STATUS', A.ID
				FROM t_respon_batal_plp_asal_hdr A 
				LEFT JOIN reff_status B ON B.ID=A.KD_STATUS AND B.KD_TIPE_STATUS='BTLRES'
				WHERE 1=1".$addsql;
		$proses = array('SELECT'  => array('GET',site_url()."/plp/pengajuan/add", '1','','icon-check','','1'));
		$this->newtable->show_chk(false);
		$this->newtable->multiple_search(true);
		$this->newtable->show_search(true);
		$this->newtable->search(array(array('A.NO_BATAL_PLP','NO. PLP'),array('A.TGL_BATAL_PLP','TGL. PLP','DATERANGE')));
		$this->newtable->action(site_url() . "/plp/res_batal_plp_asal");
		$this->newtable->detail(array('POPUP',"plp/res_batal_plp_asal/detail"));
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID"));
		$this->newtable->keys(array("ID"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby(4);
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("tblplp");
		$this->newtable->set_divid("divtblplp");
		$this->newtable->rowcount(10);
		$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate($SQL);
		$arrdata = array("title" => $judul, "content" => $tabel);
		if($this->input->post("ajax") || $act == "post")
			return $tabel;
		else
			return $arrdata;
	}
	
	function v_res_batal_plp_asal_kms($act, $id){
		$arrid = explode("~",$id);
		$judul = "DATA RESPON PLP KEMASAN";
		$SQL = "SELECT CONCAT(func_name(A.KD_KEMASAN,'KEMASAN'),' [',A.KD_KEMASAN,']') AS KEMASAN, 
				A.JML_KMS AS JUMLAH, A.NO_BL_AWB AS 'NO. BL/AWB', DATE_FORMAT(A.TGL_BL_AWB,'%d-%m-%Y') AS 'TGL. BL/AWB', 
				A.ID, A.KD_KEMASAN, A.NO_BL_AWB, A.TGL_BL_AWB, A.JML_KMS
				FROM t_respon_batal_plp_asal_kms A
				WHERE A.ID = ".$this->db->escape($arrid[0]);
		$this->newtable->show_chk(false);
		$this->newtable->multiple_search(false);
		$this->newtable->show_search(true);
		$this->newtable->search(array(array('A.KD_KEMASAN', 'KODE KEMASAN'),array('A.NO_BL_AWB', 'NO. BL/AWB')));
		$this->newtable->action(site_url() . "/plp/v_res_batal_plp_asal_kms/".$act."/".$id);
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID","KD_KEMASAN","NO_BL_AWB","TGL_BL_AWB","JML_KMS"));
		$this->newtable->keys(array("ID","KD_KEMASAN","NO_BL_AWB","TGL_BL_AWB","JML_KMS"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby(1);
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("tblkemasanplp");
		$this->newtable->set_divid("divtblkemasanplp");
		$this->newtable->rowcount(10);
		$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate($SQL);
		$arrdata = array("title" => $judul, "content" => $tabel);
		if($this->input->post("ajax")||$act=="post")
			echo $tabel;
		else
			return $arrdata;
	}
	
	function res_batal_plp_tujuan($act,$id){
		$this->newtable->breadcrumb('Home', site_url());
		$this->newtable->breadcrumb('PLP', 'javascript:void(0)');
		$this->newtable->breadcrumb('Respon Batal PLP Tujuan', site_url('plp/res_plp_asal'));
		$judul = "DATA RESPON BATAL PLP TUJUAN";
		$KD_TPS = $this->newsession->userdata('KD_TPS');
		$KD_GUDANG = $this->newsession->userdata('KD_GUDANG');
		$KD_GROUP = $this->newsession->userdata('KD_GROUP');
		if($KD_GROUP!="SPA"){
			$addsql .= " AND A.KD_TPS = ".$this->db->escape($KD_TPS);
		}
		$SQL = "SELECT CONCAT(func_name(A.KD_TPS,'TPS'),' [',A.KD_TPS,']') AS 'TPS TUJUAN', 
				CONCAT(func_name(A.KD_TPS_ASAL,'TPS'),' [',A.KD_TPS_ASAL,']') AS 'TPS ASAL', 
				CONCAT('NO. ',A.NO_PLP,'<BR>TGL. ',DATE_FORMAT(A.TGL_PLP,'%d-%m-%Y')) AS PLP,
				CONCAT('NO. ',A.NO_BATAL_PLP,'<BR>TGL. ',DATE_FORMAT(A.TGL_BATAL_PLP,'%d-%m-%Y')) AS 'PLP BATAL',
				B.NAMA AS STATUS, DATE_FORMAT(A.TGL_STATUS,'%d-%m-%Y %H:%i:%s') AS 'TGL. STATUS', A.ID
				FROM t_respon_batal_plp_tujuan_hdr A 
				LEFT JOIN reff_status B ON B.ID=A.KD_STATUS AND B.KD_TIPE_STATUS='BTLTUJ'
				WHERE 1=1".$addsql;
		$proses = array('SELECT'  => array('GET',site_url()."/plp/pengajuan/add", '1','','icon-check','','1'));
		$this->newtable->show_chk(false);
		$this->newtable->multiple_search(true);
		$this->newtable->show_search(true);
		$this->newtable->search(array(array('A.NO_BATAL_PLP','NO. PLP'),array('A.TGL_BATAL_PLP','TGL. PLP','DATERANGE')));
		$this->newtable->action(site_url() . "/plp/res_batal_plp_tujuan");
		$this->newtable->detail(array('POPUP',"plp/res_batal_plp_tujuan/detail"));
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID"));
		$this->newtable->keys(array("ID"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby(4);
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("tblplp");
		$this->newtable->set_divid("divtblplp");
		$this->newtable->rowcount(10);
		$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate($SQL);
		$arrdata = array("title" => $judul, "content" => $tabel);
		if($this->input->post("ajax") || $act == "post")
			return $tabel;
		else
			return $arrdata;
	}
	
	function v_res_batal_plp_tujuan_kms($act, $id){
		$arrid = explode("~",$id);
		$judul = "DATA RESPON PLP KEMASAN";
		$SQL = "SELECT CONCAT(func_name(A.KD_KEMASAN,'KEMASAN'),' [',A.KD_KEMASAN,']') AS KEMASAN, 
				A.JML_KMS AS JUMLAH, A.NO_BL_AWB AS 'NO. BL/AWB', DATE_FORMAT(A.TGL_BL_AWB,'%d-%m-%Y') AS 'TGL. BL/AWB', 
				A.ID, A.KD_KEMASAN, A.NO_BL_AWB, A.TGL_BL_AWB, A.JML_KMS
				FROM t_respon_batal_plp_tujuan_kms A
				WHERE A.ID = ".$this->db->escape($arrid[0]);
		$this->newtable->show_chk(false);
		$this->newtable->multiple_search(false);
		$this->newtable->show_search(true);
		$this->newtable->search(array(array('A.KD_KEMASAN', 'KODE KEMASAN'),array('A.NO_BL_AWB', 'NO. BL/AWB')));
		$this->newtable->action(site_url() . "/plp/v_res_batal_plp_tujuan_kms/".$act."/".$id);
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID","KD_KEMASAN","NO_BL_AWB","TGL_BL_AWB","JML_KMS"));
		$this->newtable->keys(array("ID","KD_KEMASAN","NO_BL_AWB","TGL_BL_AWB","JML_KMS"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby(1);
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("tblkemasanplp");
		$this->newtable->set_divid("divtblkemasanplp");
		$this->newtable->rowcount(10);
		$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate($SQL);
		$arrdata = array("title" => $judul, "content" => $tabel);
		if($this->input->post("ajax")||$act=="post")
			echo $tabel;
		else
			return $arrdata;
	}
}