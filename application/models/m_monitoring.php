<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class M_monitoring extends Model{

    function M_monitoring() {
       parent::Model();
    }

	function execute($type,$act,$id){
		$func = get_instance();
        $func->load->model("m_main", "main", true);
		if($type=="get"){
			$arrid = explode("|",$id);
			$SQL = "SELECT A.*
					FROM t_cocostskms A
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
		}else if($type=="simkeu"){
			$arrchk = explode("~", $this->input->post('id'));
			$id_invo = $arrchk[1];
			$method = 'saveTransaction';
			$KdAPRF = 'SENTSIMKEU';
			$URL = 'http://103.19.80.243/cfs_dev/server.php';
			$SOAPAction = 'urn:portalintegrasiipc#pollServer';
			$ip = $this->getIP();

			$SQL = "SELECT A.ID, A.JENIS_BILLING, A.NO_ORDER,A.NO_INVOICE, C.BANK, B.CUSTOMER_NUMBER AS ID_ORGANISASI, IFNULL(B.NAMA_FORWARDER,B.CONSIGNEE) AS NAMA, IFNULL(B.ALAMAT_FORWARDER,B.ALAMAT_CONSIGNEE) AS ALAMAT, IFNULL(B.NPWP_FORWARDER,B.NPWP_CONSIGNEE) AS NPWP, A.SUBTOTAL, A.PPN, A.TOTAL, DATE_FORMAT(C.TGL_TERIMA, '%d/%m/%Y %H:%i:%s') AS TGL_TERIMA, C.APPR_CODE, C.REFF_NO, B.NM_ANGKUT,
			B.NO_VOYAGE, DATE_FORMAT(B.TGL_TIBA, '%d/%m/%Y') AS TGL_TIBA, B.NO_DO, B.NO_BL_AWB, func_name(B.KD_GUDANG_TUJUAN, 'GUDANG') AS GUDANG_TUJUAN, B.KD_GUDANG_TUJUAN, DATE_FORMAT(B.TGL_KELUAR, '%d/%m/%Y') AS TGL_KELUAR,
			A.STATUS_AR,A.STATUS_RECEIPT,A.STATUS_AP
			FROM t_billing_cfshdr A INNER JOIN t_order_hdr B ON A.NO_ORDER = B.NO_ORDER
			INNER JOIN t_edc_payment_bank C ON A.NO_INVOICE = C.NO_INVOICE
			WHERE A.NO_INVOICE=" . $this->db->escape($id_invo);

			$result = $func->main->get_result($SQL);
			if ($result) {
				$message = '<?xml version="1.0" encoding="UTF-8"?>';
				$message .= '<root>';
				$message .= '<group>';

				$Query = $SQL->row_array();
				//print_r($Query);die();
				$ID = $Query["ID"];
				$AR = $Query["STATUS_AR"];
				$R = $Query["STATUS_RECEIPT"];
				$AP = $Query["STATUS_AP"];
				$JENIS_BILLING = $Query["JENIS_BILLING"];
				$NO_INVOICE = $Query["NO_INVOICE"];
				$ID_ORGANISASI = $Query["ID_ORGANISASI"];
				$NAMA = htmlspecialchars($Query["NAMA"]);
				$ALAMAT = htmlspecialchars($Query["ALAMAT"]);
				$NPWP = $Query["NPWP"];
				$SUBTOTAL = $Query["SUBTOTAL"];
				$PPN = $Query["PPN"];
				$TOTAL = $Query["TOTAL"];
				$TGL_TERIMA = $Query["TGL_TERIMA"];
				$APPR_CODE = $Query["APPR_CODE"];
				$REFF_NO = $Query["REFF_NO"];
				$NM_ANGKUT = $Query["NM_ANGKUT"];
				$NO_VOYAGE = $Query["NO_VOYAGE"];
				$TGL_TIBA = $Query["TGL_TIBA"];
				$NO_DO = $Query["NO_DO"];
				$NO_BL_AWB = htmlspecialchars($Query["NO_BL_AWB"]);
				$KD_GUDANG_TUJUAN = $Query["KD_GUDANG_TUJUAN"];
				$GUDANG_TUJUAN = $Query["GUDANG_TUJUAN"];
				$TGL_KELUAR = $Query["TGL_KELUAR"];
				$NO_ORDER = $Query["NO_ORDER"];
				$BANK = $Query["BANK"];

				$SQLgudang = "SELECT A.KD_CUST_GUDANG, A.GUDANG_NAME FROM mst_cfsoperator_cust A WHERE A.KD_GUDANG = '". $KD_GUDANG_TUJUAN ."'";
				$func->main->get_result($SQLgudang);
				$Querygudang=$SQLgudang->row_array();
				$kd_cust_gudang = $Querygudang["KD_CUST_GUDANG"];
				$customer_name_vendor = $Querygudang["GUDANG_NAME"];

				$SQLbank = "SELECT A.BANK_ID, A.BANK_ACCOUNT FROM mst_bank_account_simkeu A WHERE A.BANK_NAME = '". $BANK ."' AND A.TYPE='P'";
				$func->main->get_result($SQLbank);
				$Querybank=$SQLbank->row_array();
				$bankID = $Querybank["BANK_ID"];
				$receiptaccount = $Querybank["BANK_ACCOUNT"];

				$message .= '<component>';
				$message .= '<transaction>';
				$message .= '<header>';
				$message .= '<transaction_number>'. $NO_INVOICE .'</transaction_number>';
				$message .= '<request_number>'.$NO_ORDER.'</request_number>';
				$message .= '<tax_number>'. $NO_INVOICE .'</tax_number>';
				$message .= '<header_context>BRG</header_context>';
				$message .= '<header_sub_context>BRG12</header_sub_context>';
				$message .= '<organization_id>83</organization_id>';
				$message .= '<transaction_date>'. $TGL_TERIMA .'</transaction_date>';
				$message .= '<transaction_type>PELAYANAN JASA LCL CARGO</transaction_type>';
				$message .= '<customer_number>'. $ID_ORGANISASI .'</customer_number>';
				$message .= '<customer_name>'. $NAMA .'</customer_name>';
				$message .= '<no_do>'. $NO_DO .'</no_do>';
				$message .= '<no_bl>'. $NO_BL_AWB .'</no_bl>';
				$message .= '<vessel_name>'. $NM_ANGKUT .'</vessel_name>';
				$message .= '<arrival_date>'. $TGL_TIBA .'</arrival_date>';
				$message .= '<location_code>'. $KD_GUDANG_TUJUAN .'</location_code>';
				$message .= '<location>'. $GUDANG_TUJUAN .'</location>';
				$message .= '<delivery_date>'. $TGL_KELUAR .'</delivery_date>';
				$message .= '<currency>IDR</currency>';
				$message .= '<currency_type></currency_type>';
				$message .= '<currency_rate></currency_rate>';
				$message .= '<currency_date></currency_date>';
				$message .= '<before_tax>'. $SUBTOTAL .'</before_tax>';
				$message .= '<tax>'. $PPN .'</tax>';
				$message .= '<total>'. $TOTAL .'</total>';
				$message .= '</header>';
				$message .= '<details>';

				$SQLDETIL = "SELECT A.KODE_BILL, C.DESKRIPSI, A.QTY, A.SATUAN, A.TARIF_DASAR, A.TOTAL, round(A.TOTAL/10) AS TAXPPN
                FROM t_billing_cfsdtl A INNER JOIN t_billing_cfshdr B ON A.ID = B.ID
                INNER JOIN reff_billing_cfs C ON A.KODE_BILL = C.KODE_BILL WHERE A.ID = ". $ID ."";
				$result = $func->main->get_result($SQLDETIL);
				if ($result) {
					$i = 0;
					foreach ($SQLDETIL->result_array() as $QueryDetil) {
						$i = $i+1;
						$KODE_BILL = $QueryDetil["KODE_BILL"];
						$DESKRIPSI = $QueryDetil["DESKRIPSI"];
						$QTY = $QueryDetil["QTY"];
						$SATUAN = $QueryDetil["SATUAN"];
						$TARIF_DASAR = $QueryDetil["TARIF_DASAR"];
						$TOTALDETIL = $QueryDetil["TOTAL"];
						$TAXPPN = $QueryDetil["TAXPPN"];
						if($KODE_BILL == 'ADM'){
							$kdservicetype = 'ADMINISTRASI';
							$ADMINISTRASI = $TOTALDETIL;
						}else{
							$kdservicetype = 'CFS CARGO PETIKEMAS';
						}

						$message .= '<item>';
						$message .= '<line_number>'. $i .'</line_number>';
						$message .= '<item_code>'. $KODE_BILL .'</item_code>';
						$message .= '<item_name>'. $DESKRIPSI .'</item_name>';
						$message .= '<service_type>'. $kdservicetype .'</service_type> ';
						$message .= '<qty>'. $QTY .'</qty>';
						$message .= '<unit>'. $SATUAN .'</unit>';
						$message .= '<tariff>'. $TARIF_DASAR .'</tariff>';
						$message .= '<amount>'. $TOTALDETIL .'</amount>';
						$message .= '<tax_flag>Y</tax_flag>';
						$message .= '<tax>'. $TAXPPN .'</tax>';
						$message .= '</item>';
					}
				}

				$message .= '</details>';
				$message .= '</transaction>';
				$message .= '<receipt>';
				$message .= '<receipt_number>'. $NO_INVOICE .'</receipt_number>';
				$message .= '<receipt_method>TPK BANK</receipt_method>';
				$message .= '<receipt_account>'. $receiptaccount .'</receipt_account>';
				$message .= '<organization_id>83</organization_id>';
				$message .= '<bank_id>'. $bankID .'</bank_id>';
				$message .= '<customer_number>'. $ID_ORGANISASI .'</customer_number>';
				$message .= '<receipt_date>'. $TGL_TERIMA .'</receipt_date>';
				$message .= '<currency>IDR</currency>';
				$message .= '<currency_type></currency_type>';
				$message .= '<currency_rate></currency_rate>';
				$message .= '<currency_date></currency_date>';
				$message .= '<amount>'. $TOTAL .'</amount>';
				$message .= '<receipt_type>BRG</receipt_type>';
				$message .= '<receipt_sub_type>BRG12</receipt_sub_type>';
				$message .= '</receipt>';

				$SQLpersentage = "SELECT SHARE_PERCENTAGE FROM mst_share_percentage WHERE KD_GUDANG = '". $KD_GUDANG_TUJUAN ."'";
				$func->main->get_result($SQLpersentage);
				$Querypercentage=$SQLpersentage->row_array();
				$share_percentage = $Querypercentage["SHARE_PERCENTAGE"];
				$amountpayable = ($SUBTOTAL-$ADMINISTRASI)*($share_percentage/100);
				$message .= '<payable>';
				$message .= '<transaction_number>'. $NO_INVOICE .'</transaction_number>';
				$message .= '<organization_id>83</organization_id>';
				$message .= '<branch_code>TPK</branch_code>';
				$message .= '<module_code>CFS</module_code>';
				$message .= '<customer_number>'. $kd_cust_gudang .'</customer_number>';
				$message .= '<customer_name>'. $customer_name_vendor .'</customer_name>';
				$message .= '<currency>IDR</currency>';
				$message .= '<currency_type></currency_type>';
				$message .= '<currency_rate></currency_rate>';
				$message .= '<currency_date></currency_date>';
				$message .= '<amount>'. $amountpayable .'</amount>';
				$message .= '<share_percentage>'. $share_percentage .'</share_percentage>';
				$message .= '</payable>';
				$message .= '</component>';
				$message .= '</group>';
				$message .= '<configuration>';
				$message .= '<source_apps>CFS</source_apps>';
				$message .= '<ip_address>'. $ip .'</ip_address>';
				$message .= '<token></token>';
				$message .= '<key></key>';
				$message .= '</configuration>';
				$message .= '</root>';
				if($AR=='F'){
					$kode="AI";
				}elseif($R=='F'){
					$kode="AR";
				}elseif($AP=='F'){
					$kode="AP";
				}

				//echo $kode;echo $message;die();
				$xml = '<soapenv:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ser="http://services.beacukai.go.id/">
								<soapenv:Header/>
									<soapenv:Body>
									   <ser:saveIntegrasi soapenv:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/">
										  <in_param xsi:type="xsd:string"><![CDATA['. $message .']]></in_param>
										  <type xsi:type="xsd:string">'.$kode.'</type>
									   </ser:saveIntegrasi>
									</soapenv:Body>
								 </soapenv:Envelope>';
				$Send = $this->SendCurl($xml, $URL, $SOAPAction);
				if ($Send['response'] != '') {
					//echo $Send['response'];die();
					$DATA = array(
						'STATUS_AR' => NULL,
						'MESSAGE_AR' => NULL,
						'STATUS_RECEIPT' => NULL,
						'MESSAGE_RECEIPT' => NULL,
						'STATUS_AP' => NULL,
						'MESSAGE_AP' => NULL
					);
					$this->db->where(array('ID' => $ID));
					$Execute = $this->db->update('t_billing_cfshdr', $DATA);
					$SQL = "INSERT INTO app_log_services (USERNAME, PASSWORD, URL, METHOD, REQUEST, RESPONSE, IP_ADDRESS, WK_REKAM)
					VALUES ('SIMKEU','SIMKEU','http://103.19.80.243/cfs_dev/server.php','RETRANSFER'," . $this->db->escape($message) . "," . $this->db->escape($Send['response']) . ",'" . $ip . "', NOW())";
					$Execute = $this->db->query($SQL);
				}
			} else {
				$error += 1;
				$message = "Data gagal diproses";
			}
			if($error == 0){
			  $func->main->get_log("resend simkeu", "simkeu");
			  echo "MSG#OK#Data berhasil diproses#".site_url()."/monitoring/simkeu";
			}else{
			  echo "MSG#ERR#".$message."#";
			}
		}
	}

	function simkeu($act,$id){
		$this->newtable->breadcrumb('Home', site_url());
		$this->newtable->breadcrumb('Monitoring', 'javascript:void(0)');
		$this->newtable->breadcrumb('Simkeu', 'javascript:void(0)');
		$judul = "Monitoring Simkeu";
		$KD_TPS = $this->newsession->userdata('KD_TPS');
		$KD_GUDANG = $this->newsession->userdata('KD_GUDANG');
		$KD_GROUP = $this->newsession->userdata('KD_GROUP');
		$ID_ORG = $this->newsession->userdata('KD_ORGANISASI');
		$SQL = "select a.ID,b.NO_INVOICE,b.TGL_TERIMA,c.CUSTOMER_NUMBER,b.NO_INVOICE as 'TRX NUMBER',
			c.CUSTOMER_NUMBER as 'ID CUSTOMER', d.BANK_ID AS 'ID BANK',
			CONCAT(DATE_FORMAT(b.TGL_TERIMA,'%d-%m-%Y %h:%i:%s'),'<br><h4><span id=\"',a.ID,'\" class=\"label label-warning\"></span></h4><script>var x = setInterval(function() { var now = new Date().getTime();
			var countDownDate = new Date(\"',b.TGL_TERIMA,'\").getTime(); var distance = now - countDownDate;
			var days = Math.floor(distance / (1000 * 60 * 60 * 24));
			var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
			var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
			var seconds = Math.floor((distance % (1000 * 60)) / 1000);
			dd = (days>0)?days + \"d \":\"\";hh = (hours<10)?\"0\"+hours:hours;mm = (minutes<10)?\"0\"+minutes:minutes;
			ss = (seconds<10)?\"0\"+seconds:seconds;document.getElementById(\"',a.ID,'\").innerHTML = dd + hh + \":\" + mm + \":\" + ss + \"s \"; }, 1000);</script>') AS 'TANGGAL TRANSAKSI',
			CONCAT( CASE a.STATUS_AR WHEN 'S' THEN '<h4><span class=\"label label-success\">SUCCESS</span></h4><br>'
			WHEN 'F' THEN '<h4><span class=\"label label-danger\">FAILED</span></h4><br>' ELSE '-' END,
			IFNULL(a.MESSAGE_AR,'')) AS 'AR INVOICE',
			CONCAT( CASE a.STATUS_RECEIPT WHEN 'S' THEN '<h4><span class=\"label label-success\">SUCCESS</span></h4><br>'
			WHEN 'F' THEN '<h4><span class=\"label label-danger\">FAILED</span></h4><br>' ELSE '-' END,
			IFNULL(a.MESSAGE_RECEIPT,'')) AS 'RECEIPT',
			CONCAT( CASE a.STATUS_AP WHEN 'S' THEN '<h4><span class=\"label label-success\">SUCCESS</span></h4><br>'
			WHEN 'F' THEN '<h4><span class=\"label label-danger\">FAILED</span></h4><br>' ELSE '-' END,
			IFNULL(a.MESSAGE_AP,'')) AS 'AP'
			from t_billing_cfshdr a
			join t_edc_payment_bank b on a.NO_INVOICE=b.NO_INVOICE
			join t_order_hdr c on a.NO_ORDER=c.NO_ORDER and a.FLAG_APPROVE='Y' and a.KD_ALASAN_BILLING='ACCEPT'
			join mst_bank_account_simkeu d on b.BANK=d.BANK_NAME and d.`TYPE`='P'
			where (a.STATUS_AR='F' or a.STATUS_RECEIPT='F' or a.STATUS_AP in ('F','X'))";
		$this->newtable->show_chk(false);
		$this->newtable->show_menu(true);
		$proses = array('Resend'  => array('GET_POST',site_url()."/monitoring/execute/simkeu", 'ALL','','icon-share-alt','','list'));
		$this->newtable->multiple_search(true);
		$this->newtable->show_search(true);
		$this->newtable->search(array(array('b.NO_INVOICE','TRX NUMBER'),array('c.CUSTOMER_NUMBER','ID CUSTOMER'),array('b.TGL_TERIMA','TGL TRANSAKSI','DATERANGE2')));
		$this->newtable->action(site_url() . "/monitoring/simkeu");
		$this->newtable->tipe_proses('button');
		$this->newtable->tipe_proses2('button');
		$this->newtable->hiddens(array("ID","NO_INVOICE","CUSTOMER_NUMBER","TGL_TERIMA"));
		$this->newtable->keys(array("ID","NO_INVOICE","CUSTOMER_NUMBER","TGL_TERIMA"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby(1);
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("tblsimkeu");
		$this->newtable->set_divid("divtblsimkeu");
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

  function cdm($act,$id){
		$this->newtable->breadcrumb('Home', site_url());
		$this->newtable->breadcrumb('Monitoring', 'javascript:void(0)');
		$this->newtable->breadcrumb('CDM', 'javascript:void(0)');
		$judul = "Monitoring CDM";
		$KD_TPS = $this->newsession->userdata('KD_TPS');
		$KD_GUDANG = $this->newsession->userdata('KD_GUDANG');
		$KD_GROUP = $this->newsession->userdata('KD_GROUP');
		$ID_ORG = $this->newsession->userdata('KD_ORGANISASI');
		$SQL = "select a.CUSTOMER_ID 'CUSTOMER ID',CONCAT('NAMA : ',a.ALT_NAME,'<BR>NPWP/PASSPORT : ',
		ifnull(a.NPWP,a.PASSPORT),'<BR>ALAMAT : ',a.ADDRESS) 'CUSTOMER',CONCAT('<h4>',FORMAT(count(b.ID),0),'</h4> ORDER')
		'JUMLAH TRANSAKSI', (CASE a.STATUS_APPROVAL
		WHEN 'A' THEN '<h4><span class=\"label label-success\">ACTIVE</span></h4>'
		WHEN 'N' THEN '<h4><span class=\"label label-danger\">FAILED SYNC</span></h4>'
		WHEN 'P' THEN '<h4><span class=\"label label-info\">SYNC PROGRESS</span></h4>'
		WHEN 'W' THEN '<h4><span class=\"label label-warning\">WAITING APPROVAL</span></h4>'
		ELSE '<h4><span class=\"label label-danger\">REJECT</span></h4>' END) 'STATUS APPROVAL',
		(CASE a.STATUS_CUSTOMER
		WHEN 'A' THEN '<h4><span class=\"label label-success\">ACTIVE</span></h4>'
		WHEN 'I' THEN '<h4><span class=\"label label-danger\">INACTIVE</span></h4>'
		WHEN 'H' THEN '<h4><span class=\"label label-warning\">HOLD/PENDING</span></h4>'
		ELSE '<h4><span class=\"label label-danger\">REJECT</span></h4>' END) 'STATUS CUSTOMER' from mst_customer a
		left join t_order_hdr b on a.CUSTOMER_ID=b.CUSTOMER_NUMBER";
		$this->newtable->show_chk(false);
		$this->newtable->show_menu(false);
		$proses = array('Resend'  => array('GET_POST',site_url()."/monitoring/execute/simkeu", 'ALL','','icon-share-alt','','list'));
		$this->newtable->multiple_search(true);
		$this->newtable->show_search(true);
		$this->newtable->search(array(array('a.CUSTOMER_ID','CUSTOMER ID'),array('a.ALT_NAME','NAMA CUSTOMER'),array('a.NPWP','NPWP'),array('a.PASSPORT','PASSPORT')));
		$this->newtable->action(site_url() . "/monitoring/cdm");
		$this->newtable->tipe_proses('button');
		//$this->newtable->tipe_proses2('button');
		//$this->newtable->hiddens(array("ID","NO_INVOICE","CUSTOMER_NUMBER","TGL_TERIMA"));
		$this->newtable->keys(array("CUSTOMER ID"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby(1);
		$this->newtable->groupby(array("a.CUSTOMER_ID"));
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("tblcdm");
		$this->newtable->set_divid("divtblcdm");
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

	function getIP($type = 0) {
		if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown"))
			$ip = getenv("HTTP_CLIENT_IP");
		else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown"))
			$ip = getenv("REMOTE_ADDR");
		else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown"))
			$ip = getenv("HTTP_X_FORWARDED_FOR");
		else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown"))
			$ip = $_SERVER['REMOTE_ADDR'];
		else {
			$ip = "unknown";
			return $ip;
		}
		if ($type == 1) {
			return md5($ip);
		}
		if ($type == 0) {
			return $ip;
		}
	}

	function SendCurl($xml, $url, $SOAPAction) {
		$header[] = 'Content-Type: text/xml';
		$header[] = 'SOAPAction: "' . $SOAPAction . '"';
		$header[] = 'Content-length: ' . strlen($xml);
		$header[] = 'Connection: close';

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

		$response = curl_exec($ch);
		if (!curl_errno($ch)) {
			$return['return'] = TRUE;
			$return['info'] = curl_getinfo($ch);
			$return['response'] = $response;
		} else {
			$return['return'] = FALSE;
			$return['info'] = curl_error($ch);
			$return['response'] = '';
		}
		return $return;
	}
}
