<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class M_tracking extends Model{
	
    function M_tracking() {
       parent::Model();
    }

	public function execute($type,$act,$id)
	{
		$func = get_instance();
		$func->load->model("m_main", "main", true);
		$success = 0;
		$error = 0;
		$KD_TPS = $this->newsession->userdata('KD_TPS');
		$KD_GUDANG = $this->newsession->userdata('KD_GUDANG');
		$KD_KPBC = $this->newsession->userdata('KD_KPBC');
    
		if($type == 'get'){
			if ($act == "t_cocostskms") {//print_r($id);die();
				//$arrid = explode("~", $id);//print_r($arrid);die();
				$SQL = "SELECT A.NO_BL_AWB AS 'NO BL',A.JUMLAH AS 'JUMLAH KEMASAN',B.NAMA AS 'JENIS KEMASAN',
				A.NO_CONT_ASAL AS 'KONTAINER ASAL',C.NM_ANGKUT AS 'NAMA KAPAL',C.NO_VOY_FLIGHT AS 'NO VOYAGE/FLIGHT',
				CONCAT('GATE OUT : ',DATE_FORMAT(IFNULL(A.WK_OUT,'-'),'%d-%m-%Y %H:%i:%s')) AS 'GATE OUT',
				CONCAT('GATE IN : ',DATE_FORMAT(IFNULL(A.WK_IN,'-'),'%d-%m-%Y %H:%i:%s'),'<BR>TGL TIBA : ',DATE_FORMAT(IFNULL(C.TGL_TIBA,'-'),'%d-%m-%Y')) AS 'GATE IN',A.WK_IN,A.WK_OUT
				FROM t_cocostskms A LEFT JOIN reff_kemasan B ON A.KD_KEMASAN=B.ID LEFT JOIN t_cocostshdr C ON A.ID=C.ID
				WHERE A.NO_BL_AWB = " . $this->db->escape($id);//print_r($SQL);die();
				$result = $func->main->get_result($SQL);

				if ($result) { 
					/*foreach ($SQL->result_array() as $row => $value) {
						$arrdata = $value;
					}*/
					return $SQL->result_array();
				} else {
					echo "MSG#ERR#NO BL/AWB Yang Anda Masukan Tidak Terdaftar#";
					// return false;
				}
			}
		}
	}
}