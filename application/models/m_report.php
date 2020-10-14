<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class M_report extends Model{

    function M_report() {
       parent::Model();
    }

	function execute($type,$act,$id){
		$func = get_instance();
    $func->load->model("m_main", "main", true);
		if($type=="dwt"){
			$frm = $this->input->post('form');//print_r($frm);die();
			$N_OR = $frm[0][0];
			$N_BL = $frm[1][0];
			$nama='';$addsql='';
			$TIPE_ORGANISASI = $this->newsession->userdata('TIPE_ORGANISASI');
			$KD_GUDANG = $this->newsession->userdata('KD_GUDANG');
			//print_r($_POST);die();
			if($act=='cargo'){
				$addsql.=" AND A.NO_ORDER like 'KMS%'";
			}elseif($act=='petikemas'){
				$addsql.=" AND A.NO_ORDER like 'CONT%'";
			}
			if($TIPE_ORGANISASI=='TPS2'){
				$TGL_AWAL = validate(date_input($frm[2][0]));
				$TGL_AKHIR = validate(date_input($frm[2][1]));
				$SQL = "SELECT A.NAMA_GUDANG FROM reff_gudang A WHERE A.KD_GUDANG ='".$KD_GUDANG."'";
				$result = $func->main->get_result($SQL);
				$gud=$SQL->row_array();
				$nama=$gud['NAMA_GUDANG'];
				$addsql.=" AND A.KD_GUDANG_TUJUAN='".$KD_GUDANG."'";
			}else{
				$GUDANG= $frm[2][0];
				$TGL_AWAL = validate(date_input($frm[3][0]));
				$TGL_AKHIR = validate(date_input($frm[3][1]));
				if($GUDANG!=''){
					$SQL = "SELECT A.NAMA_GUDANG FROM reff_gudang A WHERE A.KD_GUDANG ='".$GUDANG."'";
					$result = $func->main->get_result($SQL);
					$gud=$SQL->row_array();
					$nama=$gud['NAMA_GUDANG'];
					$addsql.=" AND A.KD_GUDANG_TUJUAN='".$GUDANG."'";
				}
			}
			if($N_OR!=''){
				$addsrc .= " AND A.NO_ORDER LIKE '%$N_OR%'";
			}
			if($N_BL!=''){
				$addsrc .= " AND A.NO_BL_AWB LIKE '%$N_BL%'";
			}
			if(($TGL_AWAL!="")&&($TGL_AKHIR!="")){
				$addsrc .= " AND DATE_FORMAT(A.TGL_KELUAR,'%Y-%m-%d') BETWEEN '$TGL_AWAL' AND '$TGL_AKHIR'";
				$tgl=' '.$this->indo_date($TGL_AWAL).' - '.$this->indo_date($TGL_AKHIR);
			}else if($TGL_AWAL!=""){
				$addsrc .= " AND DATE_FORMAT(A.TGL_KELUAR,'%Y-%m-%d') >= '$TGL_AWAL'";
				$tgl=' '.$this->indo_date($TGL_AWAL).' s/d hari ini';
			}else if($TGL_AKHIR!=""){
				$addsrc .= " AND DATE_FORMAT(A.TGL_KELUAR,'%Y-%m-%d') <= '$TGL_AKHIR'";
				$tgl=' s/d '.$this->indo_date($TGL_AKHIR);
			}else{
				$tgl=' s/d '.$this->indo_date(date('d-m-Y'));
			}
			$SQL = "SELECT B.ID, A.NO_BL_AWB,A.NO_CONT_ASAL,C.WEIGHT,C.MEASURE,C.JML_KMS,A.CONSIGNEE,A.NAMA_FORWARDER,
      E.NAMA_GUDANG,A.TGL_STRIPPING,A.TGL_KELUAR,DATEDIFF(A.TGL_KELUAR,A.TGL_STRIPPING)+1 HARI FROM t_order_hdr A
      JOIN t_billing_cfshdr B ON A.NO_ORDER=B.NO_ORDER JOIN t_billing_cfsdtl C ON B.ID=C.ID
      JOIN reff_gudang E ON A.KD_GUDANG_TUJUAN=E.KD_GUDANG
      WHERE B.FLAG_APPROVE='Y' AND B.KD_ALASAN_BILLING='ACCEPT' AND B.STATUS_BAYAR='SETTLED'
      AND B.NO_INVOICE IS NOT NULL AND B.IS_VOID IS NULL".$addsql.$addsrc." GROUP BY A.NO_ORDER ORDER BY B.NO_INVOICE";	//print_r($SQL);die();
			$result = $func->main->get_result($SQL);
			$this->load->library('newphpexcel');
      $this->load->library('newphpexcel_gambar');
			$this->newphpexcel->getDefaultStyle()->getFont()->setName('Calibri')->setSize(12);
			$style = array(
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER ,
				)
			);
			$styler = array(
				'alignment' => array(
					'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER ,
				)
			);
			$this->newphpexcel->setActiveSheetIndex(0);
			$this->newphpexcel->getActiveSheet()->getStyle("A1:A4")->applyFromArray($style);
			$this->newphpexcel->mergecell(array(array('A1','L1'),array('A2','L2'),array('A3','L3'),array('A4','L4')), FALSE);
			$this->newphpexcel->width(array(array('A',5),array('B',20),array('C',20),array('D',10),array('E',10),array('F',10),array('G',35),
      array('H',35),array('I',25),array('J',15),array('K',15),array('L',10)));
			$this->newphpexcel->set_bold(array('A2'));
			$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A2', 'LAPORAN GATE OUT');
			$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A3', $tgl);
			$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A5','NO')->setCellValue('B5','NO HOUSE B/L')->setCellValue('C5','EX CONTAINER')
      ->setCellValue('D5','WEIGHT')->setCellValue('E5','MEASURE')->setCellValue('F5','JML KEMASAN')->setCellValue('G5','CONSIGNEE')
      ->setCellValue('H5','PBM')->setCellValue('I5','GUDANG')->setCellValue('J5','TGL STRIPPING')->setCellValue('K5','TGL GATE OUT')
      ->setCellValue('L5','JML HARI');
			$this->newphpexcel->headings(array('A5','B5','C5','D5','E5','F5','G5','H5','I5','J5','K5','L5'));
      $this->newphpexcel->getActiveSheet()->getStyle('F5')->getAlignment()->setWrapText(true);
			$this->newphpexcel->getActiveSheet()->getStyle("A5:L5")->applyFromArray($style);
			$this->newphpexcel->set_wrap(array('F','G','H'));
			$no=1;
			$rec = 6;
			if($result){
				foreach($SQL->result_array() as $row){
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A'.$rec,$no)
					->setCellValue('B'.$rec,$row["NO_BL_AWB"])
					->setCellValue('C'.$rec,$row["NO_CONT_ASAL"])
					->setCellValue('D'.$rec,$row["WEIGHT"])
					->setCellValue('E'.$rec,$row["MEASURE"])
					->setCellValue('F'.$rec,$row["JML_KMS"])
					->setCellValue('G'.$rec,$row["CONSIGNEE"])
					->setCellValue('H'.$rec,$row["NAMA_FORWARDER"])
					->setCellValue('I'.$rec,$row["NAMA_GUDANG"])
          ->setCellValue('J'.$rec,date_input($row["TGL_STRIPPING"]))
          ->setCellValue('K'.$rec,date_input($row["TGL_KELUAR"]))
          ->setCellValue('L'.$rec,$row["HARI"]);
					$this->newphpexcel->set_detilstyle(array('A'.$rec,'B'.$rec,'C'.$rec,'D'.$rec,'E'.$rec,'F'.$rec,'G'.$rec,'H'.$rec,'I'.$rec,'J'.$rec,'K'.$rec,'L'.$rec));
					$no++;$rec++;
				}
				$this->newphpexcel->getActiveSheet()->getStyle("A6:L".$rec)->applyFromArray($style);
				$gdImage = imagecreatefromjpeg('var/www/html/dev/cfs-center/assets/images/logoipc.png');
				$this->newphpexcel_gambar->setName('Sample image');
				$this->newphpexcel_gambar->setDescription('Sample image');
				$this->newphpexcel_gambar->setPath(FCPATH.'assets/images/logoipc.png');
				/* $this->newphpexcel_gambar->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_JPEG);
				$this->newphpexcel_gambar->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT); */
				$this->newphpexcel_gambar->setOffsetX(60);
				$this->newphpexcel_gambar->setOffsetY(5);
				$this->newphpexcel_gambar->setHeight(55);
				$this->newphpexcel_gambar->setCoordinates('K1');
				$this->newphpexcel_gambar->setWorksheet($this->newphpexcel->getActiveSheet());
			}else{
				$this->newphpexcel->getActiveSheet()->mergeCells('A6:L6');
				$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A6','Data Tidak Ditemukan');
				$this->newphpexcel->set_detilstyle(array('A6'));
			}//die();
			ob_clean();
			$file = "LAPORAN_GATE_OUT_".$tgl.".xls";
			header("Content-type: application/x-msdownload");
			header("Content-Disposition: attachment;filename=".$file);
			header("Cache-Control: max-age=0");
			header("Pragma: no-cache");
			header("Expires: 0");
			$objWriter = PHPExcel_IOFactory::createWriter($this->newphpexcel, 'Excel5');
			$objWriter->save('php://output');
			exit();
		}elseif($type=="transaksi"){
			$frm = $this->input->post('form');//print_r($frm);die();
			$this->benchmark->mark('code_start');
			$N_OR = $frm[0][0];
			$N_PR = $frm[1][0];
			$N_IN = $frm[2][0];
			$nama='';$addsql='';
			$TIPE_ORGANISASI = $this->newsession->userdata('TIPE_ORGANISASI');
			$KD_GUDANG = $this->newsession->userdata('KD_GUDANG');
			//print_r($_POST);die();
			if($TIPE_ORGANISASI=='TPS2'){
				$TGL_AWAL = validate(date_input($frm[3][0]));
				$TGL_AKHIR = validate(date_input($frm[3][1]));
				$SQL = "SELECT A.NAMA_GUDANG FROM reff_gudang A WHERE A.KD_GUDANG ='".$KD_GUDANG."'";
				$result = $func->main->get_result($SQL);
				$gud=$SQL->row_array();
				$nama=$gud['NAMA_GUDANG'];
				$addsql.=" AND A.KD_GUDANG_TUJUAN='".$KD_GUDANG."'";
			}else{
				$GUDANG= $frm[3][0];
				$TGL_AWAL = validate(date_input($frm[4][0]));
				$TGL_AKHIR = validate(date_input($frm[4][1]));
				if($GUDANG!=''){
					$SQL = "SELECT A.NAMA_GUDANG FROM reff_gudang A WHERE A.KD_GUDANG ='".$GUDANG."'";
					$result = $func->main->get_result($SQL);
					$gud=$SQL->row_array();
					$nama=$gud['NAMA_GUDANG'];
					$addsql.=" AND A.KD_GUDANG_TUJUAN='".$GUDANG."'";
				}
			}
			//print_r($frm);die();
			//echo $GUDANG." - ".$TGL_AWAL." - ".$TGL_AKHIR." - ".$nama." - ".$addsql;die();
			if($N_OR!=''){
				$addsrc .= " AND A.NO_ORDER LIKE '%$N_OR%'";
			}
			if($N_PR!=''){
				$addsrc .= " AND B.NO_PROFORMA_INVOICE LIKE '%$N_PR%'";
			}
			if($N_IN!=''){
				$addsrc .= " AND B.NO_INVOICE LIKE '%$N_IN%'";
			}
			if(($TGL_AWAL!="")&&($TGL_AKHIR!="")){
				$addsrc .= " AND DATE_FORMAT(D.TGL_TERIMA,'%Y-%m-%d') BETWEEN '$TGL_AWAL' AND '$TGL_AKHIR'";
				$tgl=' '.$this->indo_date($TGL_AWAL).' - '.$this->indo_date($TGL_AKHIR);
			}else if($TGL_AWAL!=""){
				$addsrc .= " AND DATE_FORMAT(D.TGL_TERIMA,'%Y-%m-%d') >= '$TGL_AWAL'";
				$tgl=' '.$this->indo_date($TGL_AWAL).' s/d hari ini';
			}else if($TGL_AKHIR!=""){
				$addsrc .= " AND DATE_FORMAT(D.TGL_TERIMA,'%Y-%m-%d') <= '$TGL_AKHIR'";
				$tgl=' s/d '.$this->indo_date($TGL_AKHIR);
			}else{
				$tgl=' s/d '.$this->indo_date(date('d-m-Y'));
			}
			$SQL = "SELECT B.ID as IDbil,DATE_FORMAT(D.TGL_TERIMA, '%d/%m/%Y') AS TGL,B.NO_ORDER,B.NO_PROFORMA_INVOICE,
			B.NO_INVOICE,A.EX_NOTA,D.TRACE_NO,A.NO_BL_AWB,A.CONSIGNEE,CONCAT(C.JML_KMS,' ',C.JNS_KMS) AS JUMLAH,C.WEIGHT,
			C.MEASURE,(case when C.WEIGHT > C.MEASURE then case when ceil(C.WEIGHT)<2 then 2 else ceil(C.WEIGHT) end
			else case when ceil(C.MEASURE)<2 then 2 else ceil(C.MEASURE) end end) as QTY,
			DATE_FORMAT(A.TGL_STRIPPING, '%d/%m/%Y') AS TGL_STRIPPING,DATE_FORMAT(A.TGL_KELUAR, '%d/%m/%Y') AS TGL_KELUAR,
			B.SUBTOTAL,B.PPN,B.TOTAL,CONCAT(A.NO_CONT_ASAL,' / ',ifnull(x.KD_CONT_UKURAN,'')) AS CONTAINER,
			CONCAT(A.NM_ANGKUT,' / ',A.NO_VOYAGE) AS VESSEL,IFNULL(A.NAMA_FORWARDER,A.CONSIGNEE) AS PBM,
			func_name(A.KD_GUDANG_TUJUAN,'GUDANG') as OPERATOR from t_order_hdr A
			JOIN (select bb.ID,bb.NO_ORDER,bb.NO_PROFORMA_INVOICE,bb.NO_INVOICE,bb.SUBTOTAL,bb.PPN,bb.TOTAL,bb.IS_VOID
			from t_billing_cfshdr bb JOIN (select max(ID) as IDB from t_billing_cfshdr group by NO_ORDER) bc on bb.ID=bc.IDB
			where bb.FLAG_APPROVE='Y' and bb.KD_ALASAN_BILLING='ACCEPT' and bb.NO_INVOICE is not null and bb.IS_VOID is null
			and bb.STATUS_BAYAR='SETTLED') B on A.NO_ORDER=B.NO_ORDER join t_billing_cfsdtl C on B.ID=C.ID
			join t_edc_payment_bank D on D.NO_INVOICE=B.NO_INVOICE AND D.IS_VOID IS NULL
			left join (select NO_CONT, KD_CONT_UKURAN from t_cocostscont where KD_GUDANG_TUJUAN in ('BAND','RAYA')
			and date_format(WK_REKAM,'%y%m%d') >='171120' group by NO_CONT) x on A.NO_CONT_ASAL=x.NO_CONT
			where 1=1".$addsql.$addsrc." group by A.NO_ORDER order by D.TGL_TERIMA ASC";//print_r($SQL);die();
			$result = $func->main->get_result($SQL);
			$this->load->library('newphpexcel');
			$this->newphpexcel->getDefaultStyle()->getFont()->setName('Calibri')->setSize(12);
			$style = array(
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER ,
				)
			);
			$styler = array(
				'alignment' => array(
					'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER ,
				)
			);
			$this->newphpexcel->setActiveSheetIndex(0);
			$this->newphpexcel->getActiveSheet()->getStyle("A1")->applyFromArray($style);
			$this->newphpexcel->getActiveSheet()->getStyle("A2")->applyFromArray($style);
			$this->newphpexcel->getActiveSheet()->getStyle("A3")->applyFromArray($style);
			$this->newphpexcel->getActiveSheet()->getStyle("A4")->applyFromArray($style);
			$this->newphpexcel->mergecell(array(array('A1','AE1')), FALSE);
			$this->newphpexcel->mergecell(array(array('A2','AE2')), FALSE);
			$this->newphpexcel->mergecell(array(array('A3','AE3')), FALSE);
			$this->newphpexcel->mergecell(array(array('A4','AE4')), FALSE);
			$this->newphpexcel->mergecell(array(array('A5','AE5')), FALSE);
			$this->newphpexcel->mergecell(array(array('A6','A7')), FALSE);
			$this->newphpexcel->mergecell(array(array('B6','B7')), FALSE);
			$this->newphpexcel->mergecell(array(array('C6','C7')), FALSE);
			$this->newphpexcel->mergecell(array(array('D6','D7')), FALSE);
			$this->newphpexcel->mergecell(array(array('E6','E7')), FALSE);
			$this->newphpexcel->mergecell(array(array('F6','F7')), FALSE);
			$this->newphpexcel->mergecell(array(array('G6','G7')), FALSE);
			$this->newphpexcel->mergecell(array(array('H6','H7')), FALSE);
			$this->newphpexcel->mergecell(array(array('I6','I7')), FALSE);
			$this->newphpexcel->mergecell(array(array('J6','J7')), FALSE);
			$this->newphpexcel->mergecell(array(array('K6','K7')), FALSE);
			$this->newphpexcel->mergecell(array(array('L6','L7')), FALSE);
			$this->newphpexcel->mergecell(array(array('M6','M7')), FALSE);
			$this->newphpexcel->mergecell(array(array('N6','N7')), FALSE);
			$this->newphpexcel->mergecell(array(array('O6','O7')), FALSE);
			$this->newphpexcel->mergecell(array(array('P6','AA6')), FALSE);
			$this->newphpexcel->mergecell(array(array('AB6','AB7')), FALSE);
			$this->newphpexcel->mergecell(array(array('AC6','AC7')), FALSE);
			$this->newphpexcel->mergecell(array(array('AD6','AD7')), FALSE);
			$this->newphpexcel->mergecell(array(array('AE6','AE7')), FALSE);
      $this->newphpexcel->mergecell(array(array('AF6','AF7')), FALSE);
			$this->newphpexcel->width(array(array('A',5),array('B',15),array('C',20),array('D',20),array('E',20),array('F',20),array('G',10),array('H',20),
      array('I',35),array('J',10),array('K',10),array('L',10),array('M',10),array('N',15),array('O',15),array('P',15),array('Q',20),array('R',20),
      array('S',20),array('T',15),array('U',15),array('V',15),array('W',20),array('X',15),array('Y',15),array('Z',15),array('AA',20),array('AB',20),
      array('AC',35),array('AD',35),array('AE',25),array('AF',10)));
			$this->newphpexcel->set_bold(array('A1','A2','A3'));
			$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A1', 'LAPORAN PRODUKSI & TRANSAKSI');
			$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A2', 'BILLING IPC CFS CENTER');
			$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A3', 'CABANG PELABUHAN TANJUNG PRIOK');
			$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A4', 'periode : '.$tgl);
			$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A5', '');
			$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A6','NO')->setCellValue('B6','TANGGAL')->setCellValue('C6','NO ORDER')
      ->setCellValue('D6','NO PROFORMA')->setCellValue('E6','NO INVOICE')->setCellValue('F6','EX INVOICE')->setCellValue('G6','TRACE NO')
      ->setCellValue('H6','NO B/L')->setCellValue('I6','CONSIGNEE')->setCellValue('J6','JUMLAH KEMASAN')->setCellValue('K6','WEIGHT')
      ->setCellValue('L6','MEASURE')->setCellValue('M6','TOTAL M3/TON')->setCellValue('N6','TGL STRIPPING')->setCellValue('O6','TGL DELIVERY')
      ->setCellValue('P6','RINCIAN')->setCellValue('P7','RDM')->setCellValue('Q7','STORAGE MASA 1.1')->setCellValue('R7','STORAGE MASA 1.2')
      ->setCellValue('S7','STORAGE MASA 2')->setCellValue('T7','SURVEYOR')->setCellValue('U7','BEHANDLE')->setCellValue('V7','SURCHARGE DG')
      ->setCellValue('W7','SURCHARGE WEIGHT')->setCellValue('X7','ADMINISTRASI')->setCellValue('Y7','SUBTOTAL')->setCellValue('Z7','PPN (10%)')
      ->setCellValue('AA7','TOTAL TAGIHAN')->setCellValue('AB6','CONTAINER / SIZE')->setCellValue('AC6','VESSEL / VOY')->setCellValue('AD6','PBM')
      ->setCellValue('AE6','CFS OPERATOR')->setCellValue('AF6','KET');
			$this->newphpexcel->headings(array('A6:A7','B6:B7','C6:C7','D6:D7','E6:E7','F6:F7','G6:G7','H6:H7','I6:I7','J6:J7','K6:K7','L6:L7','M6:M7',
      'N6:N7','O6:O7','P6:AA6','P7','Q7','R7','S7','T7','U7','V7','W7','X7','Y7','Z7','AA7','AB6:AB7','AC6:AC7','AD6:AD7','AE6:AE7','AF6:AF7'));
			$this->newphpexcel->set_wrap(array('H','I','K','L','AB','AC','AD'));
			$this->newphpexcel->getActiveSheet()->getStyle('J6:J7')->getAlignment()->setWrapText(true);
			$this->newphpexcel->getActiveSheet()->getStyle('M6:M7')->getAlignment()->setWrapText(true);
			$this->newphpexcel->getActiveSheet()->getStyle("A6:AF7")->applyFromArray($style);
			$no=1;
			$rec = 8;
			$sum_subtotal=0;$sum_ppn=0;$sum_total=0;$sum_rdm=0;$sum_str11=0;$sum_str12=0;
			$sum_str2=0;$sum_svy=0;$sum_bhd=0;$sum_scdg=0;$sum_scw=0;$sum_adm=0;
			if($result){ echo '<pre>';print_r($SQL->result_array());echo '<pre><br>';
				foreach($SQL->result_array() as $row){
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A'.$rec,$no)
					->setCellValue('B'.$rec,$row["TGL"])
					->setCellValueExplicit('C'.$rec,$row["NO_ORDER"],PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValueExplicit('D'.$rec,$row["NO_PROFORMA_INVOICE"],PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValueExplicit('E'.$rec,$row["NO_INVOICE"],PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValueExplicit('F'.$rec,$row["EX_NOTA"],PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValueExplicit('G'.$rec,$row["TRACE_NO"],PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValueExplicit('H'.$rec,$row["NO_BL_AWB"],PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValue('I'.$rec,$row["CONSIGNEE"])
					->setCellValue('J'.$rec,$row["JUMLAH"])
					->setCellValue('K'.$rec,$row["WEIGHT"])
					->setCellValue('L'.$rec,$row["MEASURE"])
					->setCellValue('M'.$rec,$row["QTY"])
					->setCellValue('N'.$rec,$row["TGL_STRIPPING"])
					->setCellValue('O'.$rec,$row["TGL_KELUAR"])
					->setCellValue('Y'.$rec,$row["SUBTOTAL"])
					->setCellValue('Z'.$rec,$row["PPN"])
					->setCellValue('AA'.$rec,$row["TOTAL"])
					->setCellValue('AB'.$rec,$row["CONTAINER"])
					->setCellValue('AC'.$rec,$row["VESSEL"])
					->setCellValue('AD'.$rec,$row["PBM"])
					->setCellValue('AE'.$rec,$row["OPERATOR"]);
					$sum_subtotal+=$row["SUBTOTAL"];$sum_ppn+=$row["PPN"];$sum_total+=$row["TOTAL"];
					$SQL1 = "SELECT A.KODE_BILL,A.TOTAL FROM t_billing_cfsdtl A WHERE A.ID='".$row["IDbil"]."' order by A.KODE_BILL";
					$result1 = $func->main->get_result($SQL1);
					if($result1){echo '<pre>';print_r($SQL1->result_array());echo '<pre>';
						foreach($SQL1->result_array() as $row1){
							switch ($row1["KODE_BILL"]) {
								// RDM
								case "RDM": $cel='P';$sum_rdm+=$row1["TOTAL"]; break;
								case "RDML": $cel='P';$sum_rdm+=$row1["TOTAL"]; break;
								case "RDMDGNL": $cel='P';$sum_rdm+=$row1["TOTAL"]; break;
								// MASA 1.1
								case "SCM11DG": $cel='Q';$sum_str11+=$row1["TOTAL"]; break;
								case "SCM11NL": $cel='Q';$sum_str11+=$row1["TOTAL"]; break;
								case "SNM11": $cel='Q';$sum_str11+=$row1["TOTAL"]; break;
								// MASA 1.2
								case "SCM12DG": $cel='R';$sum_str12+=$row1["TOTAL"]; break;
								case "SCM12NL": $cel='R';$sum_str12+=$row1["TOTAL"]; break;
								case "SNM12": $cel='R';$sum_str12+=$row1["TOTAL"]; break;
								// MASA 2
								case "SCM2DG": $cel='S';$sum_str2+=$row1["TOTAL"]; break;
								case "SCM2NL": $cel='S';$sum_str2+=$row1["TOTAL"]; break;
								case "SNM2": $cel='S';$sum_str2+=$row1["TOTAL"]; break;
								// SURVEYOR
								case "SVY": $cel='T';$sum_svy+=$row1["TOTAL"]; break;
								// BEHANDLE
								case "BHD": $cel='U';$sum_bhd+=$row1["TOTAL"]; break;
								// SURCHARGE DG
								case "SCDG": $cel='V';$sum_scdg+=$row1["TOTAL"]; break;
                // SURCHARGE WEIGHT
								case "SCW": $cel='W';$sum_scw+=$row1["TOTAL"]; break;
								// ADMINISTRASI
								case "ADM": $cel='X';$sum_adm+=$row1["TOTAL"]; break;
							}
							$this->newphpexcel->setActiveSheetIndex(0)->setCellValue($cel.$rec,$row1["TOTAL"]);
						}
					}
					$this->newphpexcel->set_detilstyle(array('A'.$rec,'B'.$rec,'C'.$rec,'D'.$rec,'E'.$rec,'F'.$rec,'G'.$rec,'H'.$rec,'I'.$rec,
          'J'.$rec,'K'.$rec,'L'.$rec,'M'.$rec,'N'.$rec,'O'.$rec,'P'.$rec,'Q'.$rec,'R'.$rec,'S'.$rec,'T'.$rec,'U'.$rec,'V'.$rec,
          'W'.$rec,'X'.$rec,'Y'.$rec,'Z'.$rec,'AA'.$rec,'AB'.$rec,'AC'.$rec,'AD'.$rec,'AE'.$rec,'AF'.$rec));
					$this->newphpexcel->getActiveSheet()->getStyle('A'.$rec.':O'.$rec)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					$this->newphpexcel->getActiveSheet()->getStyle('AB'.$rec.':AF'.$rec)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					$no++;$rec++;
				}
				$this->newphpexcel->setActiveSheetIndex(0)
				->setCellValue('P'.$rec,$sum_rdm)->setCellValue('Q'.$rec,$sum_str11)
				->setCellValue('R'.$rec,$sum_str12)->setCellValue('S'.$rec,$sum_str2)
				->setCellValue('T'.$rec,$sum_svy)->setCellValue('U'.$rec,$sum_bhd)
				->setCellValue('V'.$rec,$sum_scdg)->setCellValue('W'.$rec,$sum_scw)
				->setCellValue('X'.$rec,$sum_adm)->setCellValue('Y'.$rec,$sum_subtotal)
				->setCellValue('Z'.$rec,$sum_ppn)->setCellValue('AA'.$rec,$sum_total);
				$this->newphpexcel->set_detilstyle(array('P'.$rec,'Q'.$rec,'R'.$rec,'S'.$rec,'T'.$rec,'U'.$rec,'V'.$rec,'W'.$rec,'X'.$rec,'Y'.$rec,'Z'.$rec,'AA'.$rec));
				$this->newphpexcel->set_bold(array('P'.$rec,'Q'.$rec,'R'.$rec,'S'.$rec,'T'.$rec,'U'.$rec,'V'.$rec,'W'.$rec,'X'.$rec,'Y'.$rec,'Z'.$rec,'AA'.$rec));
				$this->newphpexcel->getActiveSheet()->getStyle("P8:AA".$rec)->getNumberFormat()->setFormatCode('_(Rp* #,##0_);_(Rp* \(#,##0\);_(Rp* \"-\"??_);_(@_)');
				$this->newphpexcel->getActiveSheet()->getStyle("A8:AF".$rec)->applyFromArray($style);
			}else{
				$this->newphpexcel->getActiveSheet()->mergeCells('A8:AF8');
				$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A8','Data Tidak Ditemukan');
				$this->newphpexcel->set_detilstyle(array('A8'));
			}//die();
			$this->benchmark->mark('code_end');$rec=$rec+2;
			$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A'.$rec,'elapsed time : '.$this->benchmark->elapsed_time('code_start', 'code_end').' detik');$rec++;
			$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A'.$rec,'memory usage : '.number_format(memory_get_usage()).' byte');
			ob_clean();
			$file = "LAPORAN_TRANSAKSI_".date("YmdHis").".xls";
			header("Content-type: application/x-msdownload");
			header("Content-Disposition: attachment;filename=".$file);
			header("Cache-Control: max-age=0");
			header("Pragma: no-cache");
			header("Expires: 0");
			$objWriter = PHPExcel_IOFactory::createWriter($this->newphpexcel, 'Excel5');
			$objWriter->save('php://output');
			exit();
		}elseif($type=="keu"){
			$frm = $this->input->post('form');//print_r($frm);die();
			$this->benchmark->mark('code_start');
			$N_OR = $frm[0][0];
			$N_PR = $frm[1][0];
			$N_IN = $frm[2][0];
			$nama='';$addsql='';
			$TIPE_ORGANISASI = $this->newsession->userdata('TIPE_ORGANISASI');
			$KD_GUDANG = $this->newsession->userdata('KD_GUDANG');
			//print_r($_POST);die();
			if($TIPE_ORGANISASI=='TPS2'){
				$TGL_AWAL = validate(date_input($frm[3][0]));
				$TGL_AKHIR = validate(date_input($frm[3][1]));
				$SQL = "SELECT A.NAMA_GUDANG FROM reff_gudang A WHERE A.KD_GUDANG ='".$KD_GUDANG."'";
				$result = $func->main->get_result($SQL);
				$gud=$SQL->row_array();
				$nama=$gud['NAMA_GUDANG'];
				$addsql.=" AND A.KD_GUDANG_TUJUAN='".$KD_GUDANG."'";
			}else{
				$GUDANG= $frm[3][0];
				$TGL_AWAL = validate(date_input($frm[4][0]));
				$TGL_AKHIR = validate(date_input($frm[4][1]));
				if($GUDANG!=''){
					$SQL = "SELECT A.NAMA_GUDANG FROM reff_gudang A WHERE A.KD_GUDANG ='".$GUDANG."'";
					$result = $func->main->get_result($SQL);
					$gud=$SQL->row_array();
					$nama=$gud['NAMA_GUDANG'];
					$addsql.=" AND A.KD_GUDANG_TUJUAN='".$GUDANG."'";
				}
			}
			//print_r($frm);die();
			//echo $GUDANG." - ".$TGL_AWAL." - ".$TGL_AKHIR." - ".$nama." - ".$addsql;die();
			if($N_OR!=''){
				$addsrc .= " AND A.NO_ORDER LIKE '%$N_OR%'";
			}
			if($N_PR!=''){
				$addsrc .= " AND B.NO_PROFORMA_INVOICE LIKE '%$N_PR%'";
			}
			if($N_IN!=''){
				$addsrc .= " AND B.NO_INVOICE LIKE '%$N_IN%'";
			}
			if(($TGL_AWAL!="")&&($TGL_AKHIR!="")){
				$addsrc .= " AND DATE_FORMAT(D.TGL_TERIMA,'%Y-%m-%d') BETWEEN '$TGL_AWAL' AND '$TGL_AKHIR'";
				$tgl=' '.$this->indo_date($TGL_AWAL).' - '.$this->indo_date($TGL_AKHIR);
			}else if($TGL_AWAL!=""){
				$addsrc .= " AND DATE_FORMAT(D.TGL_TERIMA,'%Y-%m-%d') >= '$TGL_AWAL'";
				$tgl=' '.$this->indo_date($TGL_AWAL).' s/d hari ini';
			}else if($TGL_AKHIR!=""){
				$addsrc .= " AND DATE_FORMAT(D.TGL_TERIMA,'%Y-%m-%d') <= '$TGL_AKHIR'";
				$tgl=' s/d '.$this->indo_date($TGL_AKHIR);
			}else{
				$tgl=' s/d '.$this->indo_date(date('d-m-Y'));
			}
			$SQL = "select B.ID as IDbil,DATE_FORMAT(D.TGL_TERIMA, '%d/%m/%Y') AS TGL,B.NO_ORDER,B.NO_PROFORMA_INVOICE,
			B.NO_INVOICE,A.EX_NOTA,D.TRACE_NO,A.NO_BL_AWB,A.CONSIGNEE,A.NPWP_CONSIGNEE,CONCAT(C.JML_KMS,' ',C.JNS_KMS) AS JUMLAH,
			C.WEIGHT,C.MEASURE,(case when C.WEIGHT > C.MEASURE then case when ceil(C.WEIGHT)<2 then 2 else ceil(C.WEIGHT) end
			else case when ceil(C.MEASURE)<2 then 2 else ceil(C.MEASURE) end end) as QTY,
			DATE_FORMAT(A.TGL_STRIPPING, '%d/%m/%Y') AS TGL_STRIPPING,DATE_FORMAT(A.TGL_KELUAR, '%d/%m/%Y') AS TGL_KELUAR,
			B.SUBTOTAL,B.PPN,B.TOTAL,CONCAT(A.NO_CONT_ASAL,' / ',ifnull(x.KD_CONT_UKURAN,'')) AS CONTAINER,
			CONCAT(A.NM_ANGKUT,' / ',A.NO_VOYAGE) AS VESSEL,IFNULL(A.NAMA_FORWARDER,A.CONSIGNEE) AS CUSTOMER,
			IFNULL(A.NPWP_FORWARDER,A.NPWP_CONSIGNEE) AS 'NPWP_CUSTOMER',func_name(A.KD_GUDANG_TUJUAN,'GUDANG') as OPERATOR
			from t_order_hdr A JOIN (select bb.ID,bb.NO_ORDER,bb.NO_PROFORMA_INVOICE,bb.NO_INVOICE,bb.SUBTOTAL,bb.PPN,bb.TOTAL,
			bb.IS_VOID from t_billing_cfshdr bb JOIN (select max(ID) as IDB from t_billing_cfshdr group by NO_ORDER) bc
			on bb.ID=bc.IDB where bb.FLAG_APPROVE='Y' and bb.KD_ALASAN_BILLING='ACCEPT' and bb.NO_INVOICE is not null
			and bb.IS_VOID is null and bb.STATUS_BAYAR='SETTLED' and bb.STATUS_AR='S') B on A.NO_ORDER=B.NO_ORDER
			join t_billing_cfsdtl C on B.ID=C.ID join t_edc_payment_bank D on D.NO_INVOICE=B.NO_INVOICE AND D.IS_VOID IS NULL
			left join (select distinct NO_CONT, KD_CONT_UKURAN from t_cocostscont where KD_GUDANG_TUJUAN in ('BAND','RAYA')
			and date_format(WK_REKAM,'%y%m%d') >='171120') x on A.NO_CONT_ASAL=x.NO_CONT
			where 1=1".$addsql.$addsrc." group by A.NO_ORDER order by D.TGL_TERIMA ASC";//print_r($SQL);die();
			//select NO_CONT, KD_CONT_UKURAN from t_cocostscont where KD_GUDANG_TUJUAN in ('BAND','RAYA')
			//and date_format(WK_REKAM,'%y%m%d') >='171120' group by NO_CONT
			$result = $func->main->get_result($SQL);
			$this->load->library('newphpexcel');
			$this->newphpexcel->getDefaultStyle()->getFont()->setName('Calibri')->setSize(12);
			$style = array(
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER ,
				)
			);
			$styler = array(
				'alignment' => array(
					'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER ,
				)
			);
			$this->newphpexcel->setActiveSheetIndex(0);
			$this->newphpexcel->getActiveSheet()->getStyle("A1:A4")->applyFromArray($style);
			$this->newphpexcel->mergecell(array(array('A1','AG1'),array('A2','AG2'),array('A3','AG3'),array('A4','AG4'),array('A5','AG5'),array('A6','A7'),array('B6','B7'),array('C6','C7'),array('D6','D7'),array('E6','E7'),array('F6','F7'),array('G6','G7'),array('H6','H7'),array('I6','I7'),array('J6','J7'),array('K6','K7'),array('L6','L7'),array('M6','M7'),array('N6','N7'),array('O6','O7'),array('P6','P7'),array('Q6','AA6'),array('AB6','AB7'),array('AC6','AC7'),array('AD6','AD7'),array('AE6','AE7'),array('AF6','AF7'),array('AG6','AG7')), FALSE);
			$this->newphpexcel->width(array(array('A',5),array('B',15),array('C',20),array('D',20),array('E',20),array('F',20),array('G',10),array('H',20),array('I',35),array('J',20),array('K',10),array('L',10),array('M',10),array('N',10),array('O',15),array('P',15),array('Q',15),array('R',20),array('S',20),array('T',20),array('U',15),array('V',15),array('W',15),array('X',15),array('Y',15),array('Z',15),array('AA',20),array('AB',20),array('AC',35),array('AD',35),array('AE',20),array('AF',25),array('AG',10)));
			$this->newphpexcel->set_bold(array('A1','A2','A3'));
			$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A1', 'LAPORAN KEUANGAN');
			$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A2', 'BILLING IPC CFS CENTER');
			$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A3', 'CABANG PELABUHAN TANJUNG PRIOK');
			$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A4', 'periode : '.$tgl);
			$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A5', '');
			$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A6','NO')->setCellValue('B6','TANGGAL')->setCellValue('C6','NO ORDER')->setCellValue('D6','NO PROFORMA')->setCellValue('E6','NO INVOICE')->setCellValue('F6','EX INVOICE')->setCellValue('G6','TRACE NO')->setCellValue('H6','NO B/L')->setCellValue('I6','CONSIGNEE')->setCellValue('J6','NPWP CONSIGNEE')->setCellValue('K6','JUMLAH KEMASAN')->setCellValue('L6','WEIGHT')->setCellValue('M6','MEASURE')->setCellValue('N6','TOTAL M3/TON')->setCellValue('O6','TGL STRIPPING')->setCellValue('P6','TGL DELIVERY')->setCellValue('Q6','RINCIAN')->setCellValue('Q7','RDM')->setCellValue('R7','STORAGE MASA 1.1')->setCellValue('S7','STORAGE MASA 1.2')->setCellValue('T7','STORAGE MASA 2')->setCellValue('U7','SURVEYOR')->setCellValue('V7','BEHANDLE')->setCellValue('W7','SURCHARGE')->setCellValue('X7','ADMINISTRASI')->setCellValue('Y7','SUBTOTAL')->setCellValue('Z7','PPN (10%)')->setCellValue('AA7','TOTAL TAGIHAN')->setCellValue('AB6','CONTAINER / SIZE')->setCellValue('AC6','VESSEL / VOY')->setCellValue('AD6','CUSTOMER')->setCellValue('AE6','NPWP CUSTOMER')->setCellValue('AF6','CFS OPERATOR')->setCellValue('AG6','KET');
			$this->newphpexcel->headings(array('A6:A7','B6:B7','C6:C7','D6:D7','E6:E7','F6:F7','G6:G7','H6:H7','I6:I7','J6:J7','K6:K7','L6:L7','M6:M7','N6:N7','O6:O7','P6:P7','Q6:AA6','Q7','R7','S7','T7','U7','V7','W7','X7','Y7','Z7','AA7','AB6:AB7','AC6:AC7','AD6:AD7','AE6:AE7','AF6:AF7','AG6:AG7'));
			$this->newphpexcel->set_wrap(array('H','I','L','M','AB','AC','AD'));
			$this->newphpexcel->getActiveSheet()->getStyle('K6:K7')->getAlignment()->setWrapText(true);
			$this->newphpexcel->getActiveSheet()->getStyle('N6:N7')->getAlignment()->setWrapText(true);
			$this->newphpexcel->getActiveSheet()->getStyle("A6:AG7")->applyFromArray($style);
			$no=1;
			$rec = 8;
			$sum_subtotal=0;$sum_ppn=0;$sum_total=0;$sum_rdm=0;$sum_str11=0;$sum_str12=0;
			$sum_str2=0;$sum_svy=0;$sum_bhd=0;$sum_scw=0;$sum_adm=0;$scw=0;
			if($result){ echo '<pre>';print_r($SQL->result_array());echo '<pre><br>';
				foreach($SQL->result_array() as $row){
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A'.$rec,$no)
					->setCellValue('B'.$rec,$row["TGL"])
					->setCellValueExplicit('C'.$rec,$row["NO_ORDER"],PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValueExplicit('D'.$rec,$row["NO_PROFORMA_INVOICE"],PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValueExplicit('E'.$rec,$row["NO_INVOICE"],PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValueExplicit('F'.$rec,$row["EX_NOTA"],PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValueExplicit('G'.$rec,$row["TRACE_NO"],PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValueExplicit('H'.$rec,$row["NO_BL_AWB"],PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValue('I'.$rec,$row["CONSIGNEE"])
					->setCellValue('J'.$rec,$row["NPWP_CONSIGNEE"])
					->setCellValue('K'.$rec,$row["JUMLAH"])
					->setCellValue('L'.$rec,$row["WEIGHT"])
					->setCellValue('M'.$rec,$row["MEASURE"])
					->setCellValue('N'.$rec,$row["QTY"])
					->setCellValue('O'.$rec,$row["TGL_STRIPPING"])
					->setCellValue('P'.$rec,$row["TGL_KELUAR"])
					->setCellValue('Y'.$rec,$row["SUBTOTAL"])
					->setCellValue('Z'.$rec,$row["PPN"])
					->setCellValue('AA'.$rec,$row["TOTAL"])
					->setCellValue('AB'.$rec,$row["CONTAINER"])
					->setCellValue('AC'.$rec,$row["VESSEL"])
					->setCellValue('AD'.$rec,$row["CUSTOMER"])
					->setCellValue('AE'.$rec,$row["NPWP_CUSTOMER"])
					->setCellValue('AF'.$rec,$row["OPERATOR"]);
					$sum_subtotal+=$row["SUBTOTAL"];$sum_ppn+=$row["PPN"];$sum_total+=$row["TOTAL"];
					$SQL1 = "SELECT A.KODE_BILL,A.TOTAL FROM t_billing_cfsdtl A WHERE A.ID='".$row["IDbil"]."' order by A.KODE_BILL";
					$result1 = $func->main->get_result($SQL1);
					if($result1){echo '<pre>';print_r($SQL1->result_array());echo '<pre>';
						foreach($SQL1->result_array() as $row1){
							switch ($row1["KODE_BILL"]) {
								// RDM
								case "RDM": $cel='Q';$sum_rdm+=$row1["TOTAL"];$detval=""; break;
								case "RDML": $cel='Q';$sum_rdm+=$row1["TOTAL"];$detval=""; break;
								case "RDMDGNL": $cel='Q';$sum_rdm+=$row1["TOTAL"];$detval=""; break;
								// MASA 1.1
								case "SCM11DG": $cel='R';$sum_str11+=$row1["TOTAL"];$detval=""; break;
								case "SCM11NL": $cel='R';$sum_str11+=$row1["TOTAL"];$detval=""; break;
								case "SNM11": $cel='R';$sum_str11+=$row1["TOTAL"];$detval=""; break;
								// MASA 1.2
								case "SCM12DG": $cel='S';$sum_str12+=$row1["TOTAL"];$detval=""; break;
								case "SCM12NL": $cel='S';$sum_str12+=$row1["TOTAL"];$detval=""; break;
								case "SNM12": $cel='S';$sum_str12+=$row1["TOTAL"];$detval=""; break;
								// MASA 2
								case "SCM2DG": $cel='T';$sum_str2+=$row1["TOTAL"];$detval=""; break;
								case "SCM2NL": $cel='T';$sum_str2+=$row1["TOTAL"];$detval=""; break;
								case "SNM2": $cel='T';$sum_str2+=$row1["TOTAL"];$detval=""; break;
								// SURVEYOR
								case "SVY": $cel='U';$sum_svy+=$row1["TOTAL"];$detval=""; break;
								// BEHANDLE
								case "BHD": $cel='V';$sum_bhd+=$row1["TOTAL"];$detval=""; break;
								// SURCHARGE
								case "SCDG": $cel='W';$sum_scw+=$row1["TOTAL"];$scw+=$row1["TOTAL"];$detval="sc"; break;
								case "SCW": $cel='W';$sum_scw+=$row1["TOTAL"];$scw+=$row1["TOTAL"];$detval="sc"; break;
								// ADMINISTRASI
								case "ADM": $cel='X';$sum_adm+=$row1["TOTAL"];$detval=""; break;
							}
              $detval = ($detval=="sc") ? $scw : $row1["TOTAL"];
							$this->newphpexcel->setActiveSheetIndex(0)->setCellValue($cel.$rec,$detval);
						}
					}$scw=0;
					$this->newphpexcel->set_detilstyle(array('A'.$rec,'B'.$rec,'C'.$rec,'D'.$rec,'E'.$rec,'F'.$rec,'G'.$rec,'H'.$rec,'I'.$rec,'J'.$rec,'K'.$rec,'L'.$rec,'M'.$rec,'N'.$rec,'O'.$rec,'P'.$rec,'Q'.$rec,'R'.$rec,'S'.$rec,'T'.$rec,'U'.$rec,'V'.$rec,'W'.$rec,'X'.$rec,'Y'.$rec,'Z'.$rec,'AA'.$rec,'AB'.$rec,'AC'.$rec,'AD'.$rec,'AE'.$rec,'AF'.$rec,'AG'.$rec));
					$this->newphpexcel->getActiveSheet()->getStyle('A'.$rec.':P'.$rec)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					$this->newphpexcel->getActiveSheet()->getStyle('AB'.$rec.':AG'.$rec)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					$no++;$rec++;
				}
				$this->newphpexcel->setActiveSheetIndex(0)
				->setCellValue('Q'.$rec,$sum_rdm)->setCellValue('R'.$rec,$sum_str11)
				->setCellValue('S'.$rec,$sum_str12)->setCellValue('T'.$rec,$sum_str2)
				->setCellValue('U'.$rec,$sum_svy)->setCellValue('V'.$rec,$sum_bhd)
				->setCellValue('W'.$rec,$sum_scw)->setCellValue('X'.$rec,$sum_adm)
				->setCellValue('Y'.$rec,$sum_subtotal)->setCellValue('Z'.$rec,$sum_ppn)
				->setCellValue('AA'.$rec,$sum_total);
				$this->newphpexcel->set_detilstyle(array('Q'.$rec,'R'.$rec,'S'.$rec,'T'.$rec,'U'.$rec,'V'.$rec,'W'.$rec,'X'.$rec,'Y'.$rec,'Z'.$rec,'AA'.$rec));
				$this->newphpexcel->set_bold(array('Q'.$rec,'R'.$rec,'S'.$rec,'T'.$rec,'U'.$rec,'V'.$rec,'W'.$rec,'X'.$rec,'Y'.$rec,'Z'.$rec,'AA'.$rec));
				$this->newphpexcel->getActiveSheet()->getStyle("Q8:AA".$rec)->getNumberFormat()->setFormatCode('_(Rp* #,##0_);_(Rp* \(#,##0\);_(Rp* \"-\"??_);_(@_)');
				$this->newphpexcel->getActiveSheet()->getStyle("A8:AG".$rec)->applyFromArray($style);
			}else{
				$this->newphpexcel->getActiveSheet()->mergeCells('A8:AG8');
				$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A8','Data Tidak Ditemukan');
				$this->newphpexcel->set_detilstyle(array('A8'));
			}//die();
			$this->benchmark->mark('code_end');$rec=$rec+2;
			$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A'.$rec,'elapsed time : '.$this->benchmark->elapsed_time('code_start', 'code_end').' detik');$rec++;
			$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A'.$rec,'memory usage : '.number_format(memory_get_usage()).' byte');
			ob_clean();
			$file = "LAPORAN_KEUANGAN_".date("YmdHis").".xls";
			header("Content-type: application/x-msdownload");
			header("Content-Disposition: attachment;filename=".$file);
			header("Cache-Control: max-age=0");
			header("Pragma: no-cache");
			header("Expires: 0");
			$objWriter = PHPExcel_IOFactory::createWriter($this->newphpexcel, 'Excel5');
			$objWriter->save('php://output');
			exit();
		}elseif($type=="laporanAP"){
			$arrid = explode("~",$act);//echo dirname(__FILE__);die();
			$SQLhdr = "SELECT C.GUDANG_NAME,DATE_FORMAT(TGL_KEGIATAN,'%d %M %Y') TGL,A.INVOICE_NUMBER,A.TGL_KEGIATAN,
			A.JML_NOTA,A.KSMU,DATE_FORMAT(B.INVOICE_DATE,'%d-%m-%Y') TGL_AP,DATE_FORMAT(B.GL_DATE_INVOICE,'%d-%m-%Y') TGL_GL,
			B.PAYMENT_NUMBER,DATE_FORMAT(B.PAYMENT_DATE,'%d-%m-%Y') TGL_JKK,B.AMOUNT_PAID,C.SUPPLIER_ID,C.INISIAL
			FROM xpi2_ap_payment_priok_h A LEFT JOIN xpi2_ap_payment_priok_v B ON A.INVOICE_NUMBER=B.INVOICE_NUMBER
			LEFT JOIN mst_cfsoperator_cust C ON A.SUPPLIER_ID=C.KD_CUST_GUDANG WHERE A.INVOICE_NUMBER=".$this->db->escape($arrid[2]);
			$resulthdr = $func->main->get_result($SQLhdr);
			$hdr = $SQLhdr->row_array();
			$SQL = "SELECT C.NO_INVOICE,date_format(C.TGL_TERIMA,'%d-%m-%Y') 'TGL_NOTA',E.CUSTOMER_ID,A.EX_NOTA, E.ALT_NAME,
			B.SUBTOTAL,D.TOTAL,(B.SUBTOTAL-D.TOTAL) AS KSMU FROM t_order_hdr A JOIN t_billing_cfshdr B ON A.NO_ORDER=B.NO_ORDER
			JOIN t_edc_payment_bank C ON C.NO_INVOICE=B.NO_INVOICE JOIN t_billing_cfsdtl D ON B.ID=D.ID
			JOIN mst_customer E ON E.CUSTOMER_ID=A.CUSTOMER_NUMBER WHERE B.STATUS_BAYAR='SETTLED' AND B.IS_VOID IS NULL
			AND C.IS_VOID IS NULL AND D.KODE_BILL='ADM' AND A.KD_GUDANG_TUJUAN=".$this->db->escape($arrid[0])."
			AND DATE_FORMAT(C.TGL_TERIMA,'%Y-%m-%d')=".$this->db->escape($arrid[1]);
			$result = $func->main->get_result($SQL);
			$this->load->library('newphpexcel');
			$this->load->library('newphpexcel_gambar');
			$this->newphpexcel->getDefaultStyle()->getFont()->setName('Calibri')->setSize(12);
			$style = array(
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER ,
				)
			);
			$styler = array(
				'alignment' => array(
					'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER ,
				)
			);
			$this->newphpexcel->setActiveSheetIndex(0);
			$this->newphpexcel->getActiveSheet()->getStyle("A1:A4")->applyFromArray($style);
			$this->newphpexcel->mergecell(array(array('A1','I1'),array('A2','I2'),array('A3','I3'),array('A4','I4')), FALSE);
			$this->newphpexcel->width(array(array('A',5),array('B',20),array('C',20),array('D',20),array('E',35),array('F',20),array('G',20),array('H',20),array('I',20)));
			$this->newphpexcel->set_bold(array('A2'));
			$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A2', 'LAPORAN KSMU BILLING IPC CFS CENTER');
			$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A3', 'CABANG PELABUHAN TANJUNG PRIOK');
			$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A4', 'Kegiatan Invoice AR : '.$hdr["TGL"]);
			$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('B5','NO INVOICE AP')->setCellValue('C5',': '.$hdr["INVOICE_NUMBER"]);
			$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('B6','SUPPLIER ID')->setCellValue('C6',': '.$hdr["SUPPLIER_ID"]);
			$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('B7','NAMA SUPPLIER')->setCellValue('C7',': '.$hdr["GUDANG_NAME"]);
			$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('B8','JUMLAH NOTA')->setCellValue('C8',': '.$hdr["JML_NOTA"]);
			$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('B9','TOTAL KSMU')->setCellValue('C9',': Rp '.number_format($hdr["KSMU"]));
			$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('G5','TGL INVOICE AP')->setCellValue('H5',': '.$hdr["TGL_AP"]);
			$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('G6','TGL JKK (BAYAR)')->setCellValue('H6',': '.$hdr["TGL_JKK"]);
			$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('G7','PAYMENT DOCUMENT')->setCellValue('H7',': '.$hdr["PAYMENT_NUMBER"]);
			$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('G8','AMOUNT PAID')->setCellValue('H8',': '.$hdr["AMOUNT_PAID"]);
			$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A11','NO')->setCellValue('B11','NO NOTA AR')->setCellValue('C11','TGL NOTA AR')->setCellValue('D11','CUSTOMER NUMBER')->setCellValue('E11','CUSTOMER')->setCellValue('F11','EX NOTA AR')->setCellValue('G11','PENDAPATAN')->setCellValue('H11','ADMINISTRASI')->setCellValue('I11','KSMU');
			$this->newphpexcel->headings(array('A11','B11','C11','D11','E11','F11','G11','H11','I11'));
			$this->newphpexcel->getActiveSheet()->getStyle("A11:I11")->applyFromArray($style);
			$this->newphpexcel->set_wrap(array('E'));
			$no=1;
			$rec = 12;
			if($result){ $sum_dpp=0;$sum_adm=0;$sum_ksmu=0;
				foreach($SQL->result_array() as $row){
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A'.$rec,$no)
					->setCellValueExplicit('B'.$rec,$row["NO_INVOICE"],PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValue('C'.$rec,$row["TGL_NOTA"])
					->setCellValueExplicit('D'.$rec,$row["CUSTOMER_ID"],PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValue('E'.$rec,$row["ALT_NAME"])
					->setCellValueExplicit('F'.$rec,$row["EX_NOTA"],PHPExcel_Cell_DataType::TYPE_STRING)
					->setCellValue('G'.$rec,$row["SUBTOTAL"])
					->setCellValue('H'.$rec,$row["TOTAL"])
					->setCellValue('I'.$rec,$row["KSMU"]);
					$sum_dpp+=$row["SUBTOTAL"];$sum_adm+=$row["TOTAL"];$sum_ksmu+=$row["KSMU"];
					$this->newphpexcel->set_detilstyle(array('A'.$rec,'B'.$rec,'C'.$rec,'D'.$rec,'E'.$rec,'F'.$rec,'G'.$rec,'H'.$rec,'I'.$rec));
					$no++;$rec++;
				}
				$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('G'.$rec,$sum_dpp)->setCellValue('H'.$rec,$sum_adm)->setCellValue('I'.$rec,$sum_ksmu);
				$this->newphpexcel->getActiveSheet()->getStyle("G12:I".$rec)->getNumberFormat()->setFormatCode('_(Rp* #,##0_);_(Rp* \(#,##0\);_(Rp* \"-\"??_);_(@_)');
				$this->newphpexcel->getActiveSheet()->getStyle("A12:I".$rec)->applyFromArray($style);
				$gdImage = imagecreatefromjpeg('var/www/html/dev/cfs-center/assets/images/logoipc.png');
				$this->newphpexcel_gambar->setName('Sample image');
				$this->newphpexcel_gambar->setDescription('Sample image');
				$this->newphpexcel_gambar->setPath(FCPATH.'assets/images/logoipc.png');
				/* $this->newphpexcel_gambar->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_JPEG);
				$this->newphpexcel_gambar->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT); */
				$this->newphpexcel_gambar->setOffsetX(20);
				$this->newphpexcel_gambar->setOffsetY(5);
				$this->newphpexcel_gambar->setHeight(55);
				$this->newphpexcel_gambar->setCoordinates('I1');
				$this->newphpexcel_gambar->setWorksheet($this->newphpexcel->getActiveSheet());
			}else{
				$this->newphpexcel->getActiveSheet()->mergeCells('A12:I12');
				$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A12','Data Tidak Ditemukan');
				$this->newphpexcel->set_detilstyle(array('A12'));
			}//die();
			ob_clean();
			$file = "LAPORAN_AP_KSMU_".$hdr["INISIAL"]."_".$hdr["TGL_KEGIATAN"].".xls";
 			header("Content-type: application/x-msdownload");
			header("Content-Disposition: attachment;filename=".$file);
			header("Cache-Control: max-age=0");
			header("Pragma: no-cache");
			header("Expires: 0");
			$objWriter = PHPExcel_IOFactory::createWriter($this->newphpexcel, 'Excel5');
			$objWriter->save('php://output');
			exit();
		}elseif($type=="laporanAP_sum"){
			$frm = $this->input->post('form');//print_r($frm);die();
			$N_INVAP = $frm[0][0];
			$GUDANG = $frm[1][0];
			$TGL_AWAL = validate(date_input($frm[2][0]));
			$TGL_AKHIR = validate(date_input($frm[2][1]));
			$nama='';$addsql='';
			$TIPE_ORGANISASI = $this->newsession->userdata('TIPE_ORGANISASI');
			$KD_GUDANG = $this->newsession->userdata('KD_GUDANG');
			if($GUDANG!=''){
				$SQL = "SELECT A.KD_CUST_GUDANG,A.INISIAL FROM mst_cfsoperator_cust A WHERE A.INISIAL ='".$GUDANG."'";
				$result = $func->main->get_result($SQL);
				$gud=$SQL->row_array();
				$addsql.=" AND A.SUPPLIER_ID='".$gud['KD_CUST_GUDANG']."'";
			}
			//print_r($frm);die();
			//echo $GUDANG." - ".$TGL_AWAL." - ".$TGL_AKHIR." - ".$nama." - ".$addsql;die();
			if($N_INVAP!=''){
				$addsrc .= " AND A.INVOICE_NUMBER LIKE '%$N_INVAP%'";
			}
			if(($TGL_AWAL!="")&&($TGL_AKHIR!="")){
				$addsrc .= " AND DATE_FORMAT(A.TGL_KEGIATAN,'%Y-%m-%d') BETWEEN '$TGL_AWAL' AND '$TGL_AKHIR'";
				$tgl=' '.$this->indo_date($TGL_AWAL).' - '.$this->indo_date($TGL_AKHIR);
			}else if($TGL_AWAL!=""){
				$addsrc .= " AND DATE_FORMAT(A.TGL_KEGIATAN,'%Y-%m-%d') >= '$TGL_AWAL'";
				$tgl=' '.$this->indo_date($TGL_AWAL).' s/d hari ini';
			}else if($TGL_AKHIR!=""){
				$addsrc .= " AND DATE_FORMAT(A.TGL_KEGIATAN,'%Y-%m-%d') <= '$TGL_AKHIR'";
				$tgl=' s/d '.$this->indo_date($TGL_AKHIR);
			}else{
				$tgl=' s/d '.$this->indo_date(date('d-m-Y'));
			}
			$SQL = "SELECT A.INVOICE_NUMBER,A.JML_NOTA,A.TGL_KEGIATAN,DATE_FORMAT(B.INVOICE_DATE,'%d-%m-%Y') TGL_AP,
			(CASE WHEN A.INVOICE_NUMBER=B.INVOICE_NUMBER THEN 'PAID' ELSE '' END) 'STATUS',A.KSMU,A.KSMU_PPN,
			CONCAT(C.SUPPLIER_ID,' - ',C.GUDANG_NAME) SUPPLIER,C.INISIAL
			FROM xpi2_ap_payment_priok_h A LEFT JOIN xpi2_ap_payment_priok_v B ON A.INVOICE_NUMBER=B.INVOICE_NUMBER
			LEFT JOIN mst_cfsoperator_cust C ON A.SUPPLIER_ID=C.KD_CUST_GUDANG WHERE 1=1".$addsql.$addsrc;
			//print_r($SQL);die();
			$result = $func->main->get_result($SQL);
			$this->load->library('newphpexcel');
			$this->load->library('newphpexcel_gambar');
			$this->newphpexcel->getDefaultStyle()->getFont()->setName('Calibri')->setSize(12);
			$style = array(
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER ,
				)
			);
			$styler = array(
				'alignment' => array(
					'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER ,
				)
			);
			$styled = array(
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT ,
				)
			);
			$this->newphpexcel->setActiveSheetIndex(0);
			$this->newphpexcel->getActiveSheet()->getStyle("A1:I1")->applyFromArray($style);
			$this->newphpexcel->width(array(array('A',5),array('B',20),array('C',15),array('D',10),array('E',10),array('F',15),array('G',15),array('H',15),array('I',35)));
			$this->newphpexcel->set_bold(array('A1','B1','C1','D1','E1','F1','G1','H1','I1'));
			$this->newphpexcel->set_detilstyle(array('A1','B1','C1','D1','E1','F1','G1','H1','I1'));
			$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A1','NO')->setCellValue('B1','INVOICE AP')->setCellValue('C1','TGL INVOICE AP')->setCellValue('D1','STATUS')->setCellValue('E1','QTY NOTA')->setCellValue('F1','TGL KEGIATAN')->setCellValue('G1','TOTAL KSMU')->setCellValue('H1','KSMU + PPN')->setCellValue('I1','SUPPLIER');
			//$this->newphpexcel->headings(array('A11','B11','C11','D11','E11','F11','G11','H11'));
			$no=1;
			$rec = 2;
			if($result){$sum_ksmu=0;
				foreach($SQL->result_array() as $row){
					$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A'.$rec,$no)
					->setCellValue('B'.$rec,$row["INVOICE_NUMBER"])
					->setCellValue('C'.$rec,$row["TGL_AP"])
					->setCellValue('D'.$rec,$row["STATUS"])
					->setCellValue('E'.$rec,$row["JML_NOTA"])
					->setCellValue('F'.$rec,date_input($row["TGL_KEGIATAN"]))
					->setCellValue('G'.$rec,$row["KSMU"])
					->setCellValue('H'.$rec,$row["KSMU_PPN"])
					->setCellValue('I'.$rec,$row["SUPPLIER"]);
					$sum_ksmu+=$row["KSMU"];
					$this->newphpexcel->set_detilstyle(array('A'.$rec,'B'.$rec,'C'.$rec,'D'.$rec,'E'.$rec,'F'.$rec,'G'.$rec,'H'.$rec,'I'.$rec));
					$no++;$rec++;
				}$rec_last=$rec-1;
				$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('F'.$rec,'Dasar Pemotongan Pajak')->setCellValue('G'.$rec,'=SUM(G2:G'.$rec_last.')');$rec_dpp=$rec;$rec++;
				$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('F'.$rec,'PPN 10% (PPN NONWAPU)')->setCellValue('G'.$rec,'=G'.$rec_dpp.'*10%');$rec_ppn=$rec;$rec++;
				$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('F'.$rec,'PPh Pasal 23 2 %')->setCellValue('G'.$rec,'=G'.$rec_dpp.'*2%');$rec_pph=$rec;$rec++;$rec++;
				$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('F'.$rec,'Total dibayarkan (DPP+PPN - PPh)')->setCellValue('G'.$rec,'=G'.$rec_dpp.'+G'.$rec_ppn.'-G'.$rec_pph);
				$this->newphpexcel->getActiveSheet()->getStyle("G2:H".$rec)->getNumberFormat()->setFormatCode('#,##0');
				$this->newphpexcel->getActiveSheet()->getStyle("A2:I".$rec)->applyFromArray($style);
				$this->newphpexcel->getActiveSheet()->getStyle("E2:H".$rec)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				$this->newphpexcel->set_bold(array("G".$rec));
			}else{
				$this->newphpexcel->getActiveSheet()->mergeCells('A2:I2');
				$this->newphpexcel->setActiveSheetIndex(0)->setCellValue('A2','Data Tidak Ditemukan');
				$this->newphpexcel->set_detilstyle(array('A2'));
			}//die();
			ob_clean();
			$file = "LAPORAN_AP_SUMMARY_KSMU_".$gud["INISIAL"]."_".$tgl.".xls";
 			header("Content-type: application/x-msdownload");
			header("Content-Disposition: attachment;filename=".$file);
			header("Cache-Control: max-age=0");
			header("Pragma: no-cache");
			header("Expires: 0");
			$objWriter = PHPExcel_IOFactory::createWriter($this->newphpexcel, 'Excel5');
			$objWriter->save('php://output');
			exit();
    }elseif($type=="laporanSales"){
			$arrid = explode("~",$act);//echo dirname(__FILE__);die();
      $this->load->library('newphpexcel');
			$this->load->library('newphpexcel_gambar');
      $this->newphpexcel->getDefaultStyle()->getFont()->setName('Calibri')->setSize(12);
			$style = array(
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER ,
				)
			);
			$styler = array(
				'alignment' => array(
					'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER ,
				)
			);
			$SQLhdr = "SELECT DATE_FORMAT(c.TGL_TERIMA,'%Y-%m') AS'BULAN',COUNT(*) JML,
      CONCAT(e.INISIAL,' ',DATE_FORMAT(c.TGL_TERIMA,'%b %Y')) TITLE,
      DATE_FORMAT(c.TGL_TERIMA,'%M %Y') 'HEAD', SUM(CASE WHEN d.WEIGHT > d.MEASURE
      	THEN CASE WHEN CEIL(d.WEIGHT)<2 THEN 2 ELSE CEIL(d.WEIGHT) END
      	ELSE CASE WHEN CEIL(d.MEASURE)<2 THEN 2 ELSE CEIL(d.MEASURE) END
      END) AS CBM, SUM(c.AMOUNT) TOTAL, a.KD_GUDANG_TUJUAN,
      CONCAT(e.GUDANG_NAME,' (',e.INISIAL,')') 'NAMA_GUDANG' FROM t_order_hdr a
      JOIN t_billing_cfshdr b ON a.NO_ORDER=b.NO_ORDER AND b.STATUS_BAYAR='SETTLED' AND b.IS_VOID IS NULL
      JOIN t_edc_payment_bank c ON b.NO_INVOICE=c.NO_INVOICE AND c.IS_VOID IS NULL
      JOIN (SELECT dtl.* FROM t_billing_cfsdtl dtl JOIN t_billing_cfshdr hdr ON hdr.ID=dtl.ID GROUP BY hdr.ID) d ON d.ID=b.ID
      JOIN mst_cfsoperator_cust e ON a.KD_GUDANG_TUJUAN=e.KD_GUDANG
      WHERE DATE_FORMAT(c.TGL_TERIMA,'%y%m') = ".$this->db->escape($arrid[0])."
      GROUP BY a.KD_GUDANG_TUJUAN, BULAN ORDER BY a.KD_GUDANG_TUJUAN, BULAN";
			$resulthdr = $func->main->get_result($SQLhdr);
      if($resulthdr){$sheet = 0;
        foreach ($SQLhdr->result_array() as $row => $value) {
          $SQL = "SELECT c.NO_INVOICE,DATE_FORMAT(c.TGL_TERIMA,'%d-%m-%Y') AS 'TGL_INVOICE',
          DATE_FORMAT(c.TGL_TERIMA,'%H:%i:%s') AS 'JAM_TERBIT',a.EX_NOTA,
          IFNULL(a.NAMA_FORWARDER,a.CONSIGNEE) AS CUSTOMER, c.BANK,
          (CASE c.FL_EDC WHEN 'Y' THEN 'POS EDC' ELSE 'MANUAL' END) AS EDC,
          (CASE WHEN d.WEIGHT > d.MEASURE
          	THEN CASE WHEN CEIL(d.WEIGHT)<2 THEN 2 ELSE CEIL(d.WEIGHT) END
          	ELSE CASE WHEN CEIL(d.MEASURE)<2 THEN 2 ELSE CEIL(d.MEASURE) END
          END) AS CBM, (c.AMOUNT/1.1) DPP, ((c.AMOUNT/1.1)*10/100) PPN,
          c.AMOUNT, d.TOTAL ADMIN,(d.TOTAL*10/100) 'PPN_ADMIN',
          (c.AMOUNT-d.TOTAL-(d.TOTAL*10/100)) KSMU FROM t_order_hdr a
          JOIN t_billing_cfshdr b ON a.NO_ORDER=b.NO_ORDER AND b.STATUS_BAYAR='SETTLED' AND b.IS_VOID IS NULL
          JOIN t_edc_payment_bank c ON b.NO_INVOICE=c.NO_INVOICE AND c.IS_VOID IS NULL
          JOIN (SELECT dtl.* FROM t_billing_cfsdtl dtl JOIN t_billing_cfshdr hdr ON hdr.ID=dtl.ID
          WHERE dtl.KODE_BILL='ADM' GROUP BY hdr.ID) d ON d.ID=b.ID
          JOIN mst_cfsoperator_cust m ON m.KD_GUDANG=a.KD_GUDANG_TUJUAN
          WHERE DATE_FORMAT(c.TGL_TERIMA,'%Y-%m') = '".$value['BULAN']."'
          AND a.KD_GUDANG_TUJUAN='".$value['KD_GUDANG_TUJUAN']."' ORDER BY c.TGL_TERIMA";
    			$result = $func->main->get_result($SQL);
          if($row > 0) $this->newphpexcel->createSheet();
          $this->newphpexcel->setActiveSheetIndex($row);
          $this->newphpexcel->setActiveSheetIndex($row)->setTitle($value['TITLE']);
    			//$this->newphpexcel->getActiveSheet()->getStyle("A1:A4")->applyFromArray($style);
    			//$this->newphpexcel->mergecell(array(array('A1','I1'),array('A2','I2'),array('A3','I3'),array('A4','I4')), FALSE);
    			$this->newphpexcel->width(array(array('A',5),array('B',20),array('C',15),array('D',15),array('E',35),array('F',10),array('G',10),
          array('H',10),array('I',15),array('J',15),array('K',20),array('L',15),array('M',15),array('N',20)));
    			$this->newphpexcel->set_bold(array('A1','C6'));
    			$this->newphpexcel->setActiveSheetIndex($row)->setCellValue('A1', 'LAPORAN TRANSAKSI BULAN '.$value['HEAD']);
    			$this->newphpexcel->setActiveSheetIndex($row)->setCellValue('B3','GUDANG')->setCellValue('C3',': '.$value["NAMA_GUDANG"]);
    			$this->newphpexcel->setActiveSheetIndex($row)->setCellValue('B4','JUMLAH NOTA')->setCellValue('C4',': '.$value["JML"].' NOTA');
    			$this->newphpexcel->setActiveSheetIndex($row)->setCellValue('B5','VOLUME BARANG')->setCellValue('C5',': '.$value["CBM"].' CBM');
    			$this->newphpexcel->setActiveSheetIndex($row)->setCellValue('B6','TOTAL TRANSAKSI')->setCellValue('C6',': Rp '.number_format($value["TOTAL"]));
    			$this->newphpexcel->setActiveSheetIndex($row)->setCellValue('A8','NO')->setCellValue('B8','NO INVOICE')->setCellValue('C8','TGL INVOICE')
          ->setCellValue('D8','JAM TERBIT')->setCellValue('E8','CUSTOMER')->setCellValue('F8','BANK')->setCellValue('G8','EDC')
          ->setCellValue('H8','CBM')->setCellValue('I8','DPP')->setCellValue('J8','PPN')->setCellValue('K8','TOTAL TAGIHAN')
          ->setCellValue('L8','ADMIN')->setCellValue('M8','PPN ADMIN')->setCellValue('N8','KSMU');
    			$this->newphpexcel->headings(array('A8','B8','C8','D8','E8','F8','G8','H8','I8','J8','K8','L8','M8','N8'));
    			$this->newphpexcel->getActiveSheet()->getStyle("A8:N8")->applyFromArray($style);
    			//$this->newphpexcel->set_wrap(array('E'));
    			$no=1;
    			$rec = 9;
    			if($result){ $sum_cbm=0;$sum_dpp=0;$sum_ppn=0;$sum_tot=0;$sum_adm=0;$sum_ppna=0;$sum_ksmu=0;
    				foreach($SQL->result_array() as $row1){
    					$this->newphpexcel->setActiveSheetIndex($row)->setCellValue('A'.$rec,$no)
    					->setCellValue('B'.$rec,$row1["NO_INVOICE"])
    					->setCellValue('C'.$rec,$row1["TGL_INVOICE"])
    					->setCellValue('D'.$rec,$row1["JAM_TERBIT"])
    					->setCellValue('E'.$rec,$row1["CUSTOMER"])
    					->setCellValue('F'.$rec,$row1["BANK"])
    					->setCellValue('G'.$rec,$row1["EDC"])
    					->setCellValue('H'.$rec,$row1["CBM"])
              ->setCellValue('I'.$rec,$row1["DPP"])
              ->setCellValue('J'.$rec,$row1["PPN"])
              ->setCellValue('K'.$rec,$row1["AMOUNT"])
              ->setCellValue('L'.$rec,$row1["ADMIN"])
              ->setCellValue('M'.$rec,$row1["PPN_ADMIN"])
    					->setCellValue('N'.$rec,$row1["KSMU"]);
    					$sum_cbm+=$row1["CBM"];$sum_dpp+=$row1["DPP"];$sum_ppn+=$row1["PPN"];$sum_tot+=$row1["AMOUNT"];
              $sum_adm+=$row1["ADMIN"];$sum_ppna+=$row1["PPN_ADMIN"];$sum_ksmu+=$row1["KSMU"];
    					$this->newphpexcel->set_detilstyle(array('A'.$rec,'B'.$rec,'C'.$rec,'D'.$rec,'E'.$rec,'F'.$rec,'G'.$rec,'H'.$rec,'I'.$rec,'J'.$rec,'K'.$rec,'L'.$rec,'M'.$rec,'N'.$rec));
    					$no++;$rec++;
    				}
    				//$this->newphpexcel->setActiveSheetIndex($row)->setCellValue('H'.$rec,$sum_cbm)->setCellValue('I'.$rec,$sum_dpp)
            //->setCellValue('J'.$rec,$sum_ppn)->setCellValue('K'.$rec,$sum_tot)->setCellValue('L'.$rec,$sum_adm)
            //->setCellValue('M'.$rec,$sum_ppna)->setCellValue('N'.$rec,$sum_ksmu);
            $rec_last=$rec-1;
            $this->newphpexcel->setActiveSheetIndex($row)->setCellValue('H'.$rec,"=SUM(H9:H".$rec_last.")")
            ->setCellValue('I'.$rec,"=SUM(I9:I".$rec_last.")")->setCellValue('J'.$rec,"=SUM(J9:J".$rec_last.")")
            ->setCellValue('K'.$rec,"=SUM(K9:K".$rec_last.")")->setCellValue('L'.$rec,"=SUM(L9:L".$rec_last.")")
            ->setCellValue('M'.$rec,"=SUM(M9:M".$rec_last.")")->setCellValue('N'.$rec,"=SUM(N9:N".$rec_last.")");
    				$this->newphpexcel->getActiveSheet()->getStyle("H9:N".$rec)->getNumberFormat()->setFormatCode('#,##0');
    				$this->newphpexcel->getActiveSheet()->getStyle("A9:N".$rec)->applyFromArray($style);
    			}else{
    				$this->newphpexcel->getActiveSheet()->mergeCells('A9:N9');
    				$this->newphpexcel->setActiveSheetIndex($row)->setCellValue('A9','Data Tidak Ditemukan');
    				$this->newphpexcel->set_detilstyle(array('A9'));
    			}//die();
        }
      }else{
        echo "Empty Result!";die();
      }
			ob_clean();
			$file = "LAPORAN_SUMMARY_INVOICE_CFS.xls";
 			header("Content-type: application/x-msdownload");
			header("Content-Disposition: attachment;filename=".$file);
			header("Cache-Control: max-age=0");
			header("Pragma: no-cache");
			header("Expires: 0");
			$objWriter = PHPExcel_IOFactory::createWriter($this->newphpexcel, 'Excel5');
			$objWriter->save('php://output');
			exit();
		}
	}

	function get_comboboxnamagudang($find){
        $func = get_instance();
        $func->load->model("m_main", "main", true);
        if($find=="GUDANG"){
          $sql = "SELECT KD_GUDANG,CONCAT(KD_GUDANG,' - ',NAMA_GUDANG) AS NAMA_GUDANG FROM reff_gudang WHERE TIPE = '2' and KD_GUDANG in ('BAND','RAYA','PSKA') ORDER BY KD_GUDANG ASC";
          $arrdata = $func->main->get_combobox($sql, "KD_GUDANG", "NAMA_GUDANG", TRUE);
        }elseif($find=="GUDANG_PT"){
          $sql = "SELECT INISIAL,CONCAT(INISIAL,' - ',GUDANG_NAME) AS NAMA_GUDANG FROM mst_cfsoperator_cust ORDER BY INISIAL ASC";
          $arrdata = $func->main->get_combobox($sql, "INISIAL", "NAMA_GUDANG", TRUE);
		}
		return $arrdata;
	}

	function indo_date($tgl){
		$date_format = preg_replace ("/S/", "", "d F Y");
		$pattern = array (
			'/Mon[^day]/','/Tue[^sday]/','/Wed[^nesday]/','/Thu[^rsday]/','/Fri[^day]/','/Sat[^urday]/','/Sun[^day]/','/Monday/','/Tuesday/',
			'/Wednesday/','/Thursday/','/Friday/','/Saturday/','/Sunday/','/Jan[^uary]/','/Feb[^ruary]/','/Mar[^ch]/','/Apr[^il]/','/May/',
			'/Jun[^e]/','/Jul[^y]/','/Aug[^ust]/','/Sep[^tember]/','/Oct[^ober]/','/Nov[^ember]/','/Dec[^ember]/','/January/','/February/','/March/',
			'/April/','/June/','/July/','/August/','/September/','/October/','/November/','/December/',
		);
		$replace = array (
			'Sen','Sel','Rab','Kam','Jum','Sab','Min','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu','Jan','Feb','Mar','Apr','Mei','Jun','Jul',
			'Ags','Sep','Okt','Nov','Des','Januari','Februari','Maret','April','Juni','Juli','Agustus','September','Oktober','November','Desember',
		);
		$date = date ($date_format, strtotime($tgl));
		$date = preg_replace ($pattern, $replace, $date);
		return $date;
	}

	public function cargo($act, $id){
		$this->newtable->breadcrumb('Home', site_url());
		$this->newtable->breadcrumb('LAPORAN', 'javascript:void(0)');
		$this->newtable->breadcrumb('LCL CARGO', 'javascript:void(0)');
		$data['title'] = 'LAPORAN LCL CARGO';
		$judul = "DATA LAPORAN LCL CARGO";
		$title = "LAPORAN LCL CARGO";
		$KD_TPS = $this->newsession->userdata('KD_TPS');
		$KD_GUDANG = $this->newsession->userdata('KD_GUDANG');
		$KD_GROUP = $this->newsession->userdata('KD_GROUP');
		$TIPE_ORGANISASI = $this->newsession->userdata('TIPE_ORGANISASI');
		$check = (grant()=="W")?true:false;
		if ($KD_GROUP == "ADM" && $TIPE_ORGANISASI == "TPS2") {
		  $addsql .= " AND B.KD_GUDANG_TUJUAN = " . $this->db->escape($KD_GUDANG);
		}
		$SQL = "SELECT A.NO_ORDER AS 'NO ORDER',func_name(B.KD_GUDANG_TUJUAN,'GUDANG') AS GUDANG,
		DATE_FORMAT(A.TGL_UPDATE, '%d-%m-%Y') AS TANGGAL,IFNULL(A.NO_INVOICE,'-') AS 'NO INVOICE',A.TOTAL AS 'TOTAL TAGIHAN',
		(CASE WHEN B.JENIS_BAYAR='A' THEN 'CASH' ELSE 'KREDIT' END) AS 'METODE PEMBAYARAN',
		DATE_FORMAT(A.TGL_UPDATE, '%d-%m-%Y %h:%i:%s') AS 'JAM TERBIT INVOICE', C.NO_POLISI_TRUCK as 'NO POLISI TRUCK',
		A.NO_ORDER, A.NO_INVOICE,A.NO_PROFORMA_INVOICE,B.KD_GUDANG_TUJUAN FROM t_billing_cfshdr A
		join t_order_hdr B on A.NO_ORDER=B.NO_ORDER join t_order_kms C on B.ID=C.ID where A.NO_ORDER like 'KMS%' AND A.NO_INVOICE IS NOT NULL".$addsql;
		//var_dump($SQL);die();
		$this->newtable->multiple_search(true);
		$this->newtable->show_chk(false);
		$this->newtable->show_search(true);
		$arrnamaGudang = $this->get_comboboxnamagudang("GUDANG");
		$proses = array('Export Excel'  => array('EXCEL', site_url()."/report/execute/LCL/cargo", '0','','icon-pencil','','menu'));
    	if($TIPE_ORGANISASI=="SPA"){
			$this->newtable->search(array(array('A.NO_ORDER','NO ORDER'),array('A.NO_PROFORMA_INVOICE','NO PROFORMA'),array('B.NO_INVOICE','NO INVOICE'),array('B.KD_GUDANG_TUJUAN', 'GUDANG', 'OPTION', $arrnamaGudang),array('A.TGL_UPDATE','TANGGAL','DATERANGE2')));
		}else{
			$this->newtable->search(array(array('A.NO_ORDER','NO ORDER'),array('A.NO_PROFORMA_INVOICE','NO PROFORMA'),array('B.NO_INVOICE','NO INVOICE'),array('A.TGL_UPDATE','TANGGAL','DATERANGE2')));
    	}
		//$this->newtable->action(site_url() . "/plp/laporan_transaksi/".$act."/".$id);
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("NO_ORDER","NO_PROFORMA_INVOICE","NO_INVOICE","TGL_UPDATE","KD_GUDANG_TUJUAN"));
		$this->newtable->numberformat(array("TOTAL TAGIHAN"));
		$this->newtable->keys(array("NO_ORDER","KD_GUDANG_TUJUAN"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby(1);
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("tbllaporan_lclcargo");
		$this->newtable->set_divid("divtbllaporan_lclcargo");
		$this->newtable->rowcount(10);
		$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate($SQL);
		$arrdata = array("page_title" => $page_title, "title" => $title, "content" => $tabel);
		if($this->input->post("ajax")||$act == "post")
			echo $tabel;
		else
			return $arrdata;
	}

	public function petikemas($act, $id){
		$this->newtable->breadcrumb('Home', site_url());
		$this->newtable->breadcrumb('LAPORAN', 'javascript:void(0)');
		$this->newtable->breadcrumb('LCL PETIKEMAS', 'javascript:void(0)');
		$data['title'] = 'LAPORAN LCL PETIKEMAS';
		$judul = "DATA LAPORAN LCL PETIKEMAS";
		$title = "LAPORAN LCL PETIKEMAS";
		$KD_TPS = $this->newsession->userdata('KD_TPS');
		$KD_GUDANG = $this->newsession->userdata('KD_GUDANG');
		$KD_GROUP = $this->newsession->userdata('KD_GROUP');
		$TIPE_ORGANISASI = $this->newsession->userdata('TIPE_ORGANISASI');
		$check = (grant()=="W")?true:false;
		if ($KD_GROUP == "ADM" && $TIPE_ORGANISASI == "TPS2") {
		  $addsql .= " AND B.KD_GUDANG_TUJUAN = " . $this->db->escape($KD_GUDANG);
		}
		$SQL = "SELECT A.NO_ORDER AS 'NO ORDER',func_name(B.KD_GUDANG_TUJUAN,'GUDANG') AS GUDANG,
		DATE_FORMAT(A.TGL_UPDATE, '%d-%m-%Y') AS TANGGAL,IFNULL(A.NO_INVOICE,'-') AS 'NO INVOICE',A.TOTAL AS 'TOTAL TAGIHAN',
		(CASE WHEN B.JENIS_BAYAR='A' THEN 'CASH' ELSE 'KREDIT' END) AS 'METODE PEMBAYARAN',B.NO_BL_AWB AS 'NO BL',
		DATE_FORMAT(A.TGL_UPDATE, '%d-%m-%Y %h:%i:%s') AS 'JAM TERBIT INVOICE', A.NO_SP2 AS 'NO SP2',
		CONCAT(C.NO_CONT,' / ',func_name(C.KD_CONT_UKURAN,'CONT_UKURAN')) AS 'NO CONTAINER', C.NO_POLISI_TRUCK AS 'NO POLISI TRUCK',
		A.NO_ORDER, A.NO_INVOICE,A.NO_PROFORMA_INVOICE,B.KD_GUDANG_TUJUAN FROM t_billing_cfshdr A
		JOIN t_order_hdr B ON A.NO_ORDER=B.NO_ORDER JOIN t_order_cont C ON B.ID=C.ID WHERE A.NO_ORDER LIKE 'CONT%' AND A.NO_INVOICE IS NOT NULL".$addsql;
		$this->newtable->multiple_search(true);
		$this->newtable->show_chk(false);
		$this->newtable->show_search(true);
		$arrnamaGudang = $this->get_comboboxnamagudang("GUDANG");
		$proses = array('Export Excel'  => array('EXCEL', site_url()."/report/execute/LCL/petikemas", '0','','icon-pencil','','menu'));
    	if($TIPE_ORGANISASI=="SPA"){
			$this->newtable->search(array(array('A.NO_ORDER','NO ORDER'),array('A.NO_PROFORMA_INVOICE','NO PROFORMA'),array('B.NO_INVOICE','NO INVOICE'),array('B.KD_GUDANG_TUJUAN', 'GUDANG', 'OPTION', $arrnamaGudang),array('A.TGL_UPDATE','TANGGAL','DATERANGE2')));
		}else{
			$this->newtable->search(array(array('A.NO_ORDER','NO ORDER'),array('A.NO_PROFORMA_INVOICE','NO PROFORMA'),array('B.NO_INVOICE','NO INVOICE'),array('A.TGL_UPDATE','TANGGAL','DATERANGE2')));
    	}
		//$this->newtable->action(site_url() . "/plp/laporan_transaksi/".$act."/".$id);
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("NO_ORDER","NO_PROFORMA_INVOICE","NO_INVOICE","TGL_UPDATE","KD_GUDANG_TUJUAN"));
		$this->newtable->numberformat(array("TOTAL TAGIHAN"));
		$this->newtable->keys(array("NO_ORDER","KD_GUDANG_TUJUAN"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby(1);
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("tbllaporan_petikemas");
		$this->newtable->set_divid("divtbllaporan_petikemas");
		$this->newtable->rowcount(10);
		$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate($SQL);
		$arrdata = array("page_title" => $page_title, "title" => $title, "content" => $tabel);
		if($this->input->post("ajax")||$act == "post")
			echo $tabel;
		else
			return $arrdata;
	}

	public function dwt($act, $id){
		$this->newtable->breadcrumb('Home', site_url());
		$this->newtable->breadcrumb('LAPORAN', 'javascript:void(0)');
		$this->newtable->breadcrumb('GATE OUT', 'javascript:void(0)');
		$data['title'] = 'LAPORAN GATE OUT';
		$judul = "DATA LAPORAN GATE OUT";
		$title = "LAPORAN GATE OUT";
		$KD_TPS = $this->newsession->userdata('KD_TPS');
		$KD_GUDANG = $this->newsession->userdata('KD_GUDANG');
		$KD_GROUP = $this->newsession->userdata('KD_GROUP');
		$TIPE_ORGANISASI = $this->newsession->userdata('TIPE_ORGANISASI');
		$check = (grant()=="W")?true:false;
		if ($KD_GROUP == "ADM" && $TIPE_ORGANISASI == "TPS2") {
		  //$addsql .= " AND B.KD_GUDANG_TUJUAN = " . $this->db->escape($KD_GUDANG);
		}
		$SQL = "SELECT A.ID,A.NO_ORDER AS 'NO ORDER',A.NO_BL_AWB AS 'NO HOUSE B/L', A.CONSIGNEE, A.NAMA_FORWARDER AS 'PBM', DATE_FORMAT(A.TGL_STRIPPING,'%d-%m-%Y') AS 'TGL STRIPPING', DATE_FORMAT(A.TGL_KELUAR,'%d-%m-%Y') AS 'TGL GATE OUT', func_name(A.KD_GUDANG_TUJUAN,'GUDANG') AS 'GUDANG' FROM t_order_hdr A WHERE A.KD_STATUS='700'";
		$this->newtable->multiple_search(true);
		$this->newtable->show_chk(false);
		$this->newtable->show_search(true);
		$arrnamaGudang = $this->get_comboboxnamagudang("GUDANG");
		$proses = array('Export Excel'  => array('EXCEL', site_url()."/report/execute/dwt", '0','','icon-pencil','','menu'));
    	//if($TIPE_ORGANISASI=="SPA"){
			$this->newtable->search(array(array('A.NO_ORDER','NO ORDER'),array('A.NO_BL_AWB','NO HOUSE B/L'),array('A.KD_GUDANG_TUJUAN', 'GUDANG', 'OPTION', $arrnamaGudang),array('A.TGL_KELUAR','TANGGAL GATE OUT','DATERANGE2')));
		/* }else{
			$this->newtable->search(array(array('A.NO_ORDER','NO ORDER'),array('A.NO_PROFORMA_INVOICE','NO PROFORMA'),array('B.NO_INVOICE','NO INVOICE'),array('A.TGL_UPDATE','TANGGAL','DATERANGE2')));
    	} */
		//$this->newtable->action(site_url() . "/plp/laporan_transaksi/".$act."/".$id);
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID"));
		$this->newtable->keys(array("ID"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby(1);
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("tbllaporan_dwt");
		$this->newtable->set_divid("divtbllaporan_dwt");
		$this->newtable->rowcount(10);
		$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate($SQL);
		$arrdata = array("page_title" => $page_title, "title" => $title, "content" => $tabel);
		if($this->input->post("ajax")||$act == "post")
			echo $tabel;
		else
			return $arrdata;
	}

	public function transaksi($act, $id){
		$this->newtable->breadcrumb('Home', site_url());
		$this->newtable->breadcrumb('LAPORAN', 'javascript:void(0)');
		$this->newtable->breadcrumb('PRODUKSI & TRANSAKSI', 'javascript:void(0)');
		$data['title'] = 'LAPORAN PRODUKSI & TRANSAKSI';
		$judul = "DATA LAPORAN PRODUKSI & TRANSAKSI";
		$title = "LAPORAN PRODUKSI & TRANSAKSI";
		$KD_TPS = $this->newsession->userdata('KD_TPS');
		$KD_GUDANG = $this->newsession->userdata('KD_GUDANG');
		$KD_GROUP = $this->newsession->userdata('KD_GROUP');
		$TIPE_ORGANISASI = $this->newsession->userdata('TIPE_ORGANISASI');
		$check = (grant()=="W")?true:false;
		if ($TIPE_ORGANISASI == "TPS2") {
		  $addsql .= " AND A.KD_GUDANG_TUJUAN = " . $this->db->escape($KD_GUDANG);
		}
		if(!$this->input->post('ajax')){
			$addsql .= " AND D.TGL_TERIMA >= DATE_ADD(CURDATE(), INTERVAL -7 DAY)";
		}
		$SQL = "select B.ID,D.TGL_TERIMA,DATE_FORMAT(D.TGL_TERIMA, '%d/%m/%Y') AS TANGGAL,A.NO_ORDER AS 'NO ORDER',
			B.NO_PROFORMA_INVOICE AS 'NO PROFORMA',B.NO_INVOICE AS 'NO INVOICE',A.NO_BL_AWB AS 'NO B/L',
			CONCAT(B.TOTAL) AS 'TAGIHAN (Rp)',ifnull(A.NAMA_FORWARDER,A.CONSIGNEE) AS CUSTOMER,
			func_name(A.KD_GUDANG_TUJUAN,'GUDANG') as 'CFS OPERATOR' from t_order_hdr A
			join t_billing_cfshdr B on A.NO_ORDER=B.NO_ORDER
			join t_edc_payment_bank D on D.NO_INVOICE=B.NO_INVOICE
			where B.FLAG_APPROVE='Y' and B.KD_ALASAN_BILLING='ACCEPT' and B.IS_VOID is null and D.IS_VOID is null".$addsql;
			//print_r($SQL);exit();
		$this->newtable->multiple_search(true);
		$this->newtable->show_chk(false);
		$this->newtable->show_search(true);
		$arrnamaGudang = $this->get_comboboxnamagudang("GUDANG");
		$proses = array('Export Excel'  => array('EXCEL', site_url()."/report/execute/transaksi", '0','','icon-pencil','','menu'));
    	if($TIPE_ORGANISASI=="TPS2"){
			$this->newtable->search(array(array('A.NO_ORDER','NO ORDER'),array('A.NO_PROFORMA_INVOICE','NO PROFORMA'),array('A.NO_INVOICE','NO INVOICE'),array('D.TGL_TERIMA','TANGGAL','DATERANGE2')));
		}else{
			$this->newtable->search(array(array('A.NO_ORDER','NO ORDER'),array('B.NO_PROFORMA_INVOICE','NO PROFORMA'),array('B.NO_INVOICE','NO INVOICE'),array('A.KD_GUDANG_TUJUAN', 'GUDANG', 'OPTION', $arrnamaGudang),array('D.TGL_TERIMA','TANGGAL','DATERANGE2')));
    	}
		//$this->newtable->action(site_url() . "/plp/laporan_transaksi/".$act."/".$id);
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID","TGL_TERIMA"));
		$this->newtable->numberformat(array("TAGIHAN (Rp)"));
		$this->newtable->keys(array("ID"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby(1);
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("tbllaporan_transaksi");
		$this->newtable->set_divid("divtbllaporan_transaksi");
		$this->newtable->rowcount(10);
		$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate($SQL);
		$arrdata = array("page_title" => $page_title, "title" => $title, "content" => $tabel);
		if($this->input->post("ajax")||$act == "post")
			echo $tabel;
		else
			return $arrdata;
	}

	public function keu($act, $id){
		$this->newtable->breadcrumb('Home', site_url());
		$this->newtable->breadcrumb('LAPORAN', 'javascript:void(0)');
		$this->newtable->breadcrumb('KEUANGAN', 'javascript:void(0)');
		$data['title'] = 'KEUANGAN';
		$judul = "DATA LAPORAN KEUANGAN";
		$title = "LAPORAN KEUANGAN";
		$KD_TPS = $this->newsession->userdata('KD_TPS');
		$KD_GUDANG = $this->newsession->userdata('KD_GUDANG');
		$KD_GROUP = $this->newsession->userdata('KD_GROUP');
		$TIPE_ORGANISASI = $this->newsession->userdata('TIPE_ORGANISASI');
		$check = (grant()=="W")?true:false;
		if ($TIPE_ORGANISASI == "TPS2") {
		  $addsql .= " AND A.KD_GUDANG_TUJUAN = " . $this->db->escape($KD_GUDANG);
		}
		if(!$this->input->post('ajax')){
			$addsql .= " AND D.TGL_TERIMA >= DATE_ADD(CURDATE(), INTERVAL -7 DAY)";
		}
		$SQL = "select B.ID,D.TGL_TERIMA,DATE_FORMAT(D.TGL_TERIMA, '%d/%m/%Y') AS TANGGAL,A.NO_ORDER AS 'NO ORDER',
			B.NO_PROFORMA_INVOICE AS 'NO PROFORMA',B.NO_INVOICE AS 'NO INVOICE',A.NO_BL_AWB AS 'NO B/L',
			CONCAT(B.TOTAL) AS 'TAGIHAN (Rp)',ifnull(A.NAMA_FORWARDER,A.CONSIGNEE) AS CUSTOMER,
			func_name(A.KD_GUDANG_TUJUAN,'GUDANG') as 'CFS OPERATOR' from t_order_hdr A
			join t_billing_cfshdr B on A.NO_ORDER=B.NO_ORDER
			join t_edc_payment_bank D on D.NO_INVOICE=B.NO_INVOICE
			where B.FLAG_APPROVE='Y' and B.KD_ALASAN_BILLING='ACCEPT' and B.IS_VOID is null and D.IS_VOID is null and B.STATUS_AR='S'".$addsql;
		$this->newtable->multiple_search(true);
		$this->newtable->show_chk(false);
		$this->newtable->show_search(true);
		$arrnamaGudang = $this->get_comboboxnamagudang("GUDANG");
		$proses = array('Export Excel'  => array('EXCEL', site_url()."/report/execute/keu", '0','','icon-pencil','','menu'));
    	if($TIPE_ORGANISASI=="TPS2"){
			$this->newtable->search(array(array('A.NO_ORDER','NO ORDER'),array('A.NO_PROFORMA_INVOICE','NO PROFORMA'),array('A.NO_INVOICE','NO INVOICE'),array('D.TGL_TERIMA','TANGGAL','DATERANGE2')));
		}else{
			$this->newtable->search(array(array('A.NO_ORDER','NO ORDER'),array('B.NO_PROFORMA_INVOICE','NO PROFORMA'),array('B.NO_INVOICE','NO INVOICE'),array('A.KD_GUDANG_TUJUAN', 'GUDANG', 'OPTION', $arrnamaGudang),array('D.TGL_TERIMA','TANGGAL','DATERANGE2')));
    	}
		//$this->newtable->action(site_url() . "/plp/laporan_transaksi/".$act."/".$id);
		$this->newtable->tipe_proses('button');
		$this->newtable->hiddens(array("ID","TGL_TERIMA"));
		$this->newtable->numberformat(array("TAGIHAN (Rp)"));
		$this->newtable->keys(array("ID"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby(1);
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("tbllaporan_keu");
		$this->newtable->set_divid("divtbllaporan_keu");
		$this->newtable->rowcount(10);
		$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate($SQL);
		$arrdata = array("page_title" => $page_title, "title" => $title, "content" => $tabel);
		if($this->input->post("ajax")||$act == "post")
			echo $tabel;
		else
			return $arrdata;
	}

	public function laporanAP($act, $id){
		$this->newtable->breadcrumb('Home', site_url());
		$this->newtable->breadcrumb('LAPORAN', 'javascript:void(0)');
		$this->newtable->breadcrumb('ACCOUNT PAYABLE', 'javascript:void(0)');
		$data['title'] = 'ACCOUNT PAYABLE';
		$judul = "DATA LAPORAN ACCOUNT PAYABLE";
		$title = "LAPORAN ACCOUNT PAYABLE";
		$KD_TPS = $this->newsession->userdata('KD_TPS');
		$KD_GUDANG = $this->newsession->userdata('KD_GUDANG');
		$KD_GROUP = $this->newsession->userdata('KD_GROUP');
		$TIPE_ORGANISASI = $this->newsession->userdata('TIPE_ORGANISASI');
		$check = (grant()=="W")?true:false;
		$SQL = "SELECT A.TGL_KEGIATAN, A.INVOICE_NUMBER, C.KD_GUDANG, A.INVOICE_NUMBER 'INVOICE AP',
		DATE_FORMAT(B.INVOICE_DATE,'%d-%m-%Y') 'TGL INVOICE AP',
		(case when A.INVOICE_NUMBER=B.INVOICE_NUMBER then '<h4><span class=\"label label-success\">PAID</span></h4>'
		else '<h4><span class=\"label label-danger\">NOT PAID</span></h4>' end) 'STATUS', A.JML_NOTA 'QTY NOTA',
		DATE_FORMAT(A.TGL_KEGIATAN,'%d-%m-%Y') 'TGL KEGIATAN', A.KSMU 'TOTAL KSMU',
		CONCAT(C.SUPPLIER_ID,' - ',C.GUDANG_NAME) 'SUPPLIER' from xpi2_ap_payment_priok_h A
		LEFT JOIN xpi2_ap_payment_priok_v B ON A.INVOICE_NUMBER=B.INVOICE_NUMBER
		LEFT JOIN mst_cfsoperator_cust C ON A.SUPPLIER_ID=C.KD_CUST_GUDANG
		JOIN t_edc_payment_bank D ON A.TGL_KEGIATAN=DATE_FORMAT(D.TGL_TERIMA,'%Y-%m-%d') AND D.IS_VOID IS NULL
		JOIN t_order_hdr E ON D.NO_ORDER=E.NO_ORDER AND E.KD_GUDANG_TUJUAN=C.KD_GUDANG";
		$this->newtable->multiple_search(true);
		$this->newtable->show_chk(false);
		$this->newtable->show_search(true);
		$arrnamaGudang = $this->get_comboboxnamagudang("GUDANG_PT");
		$proses = array(
			'UPDATE DATA'  => array('GET_WS', base_url()."TPSServices/GetAP.php", '0','','icon-refresh','','menu'),
			'PRINT'  => array('EXCEL', site_url()."/report/execute/laporanAP_sum", '0','','icon-printer','','menu'),
			'VIEW'  => array('MODALDTL', "report/laporanAP/detail", '1','','icon-magnifier-add','','list'),
			'CETAK'  => array('EXCELDIR', site_url()."/report/execute/laporanAP", '1','','icon-printer','','list')
		);
		$this->newtable->search(array(array('C.INISIAL', 'GUDANG', 'OPTION', $arrnamaGudang),array('A.INVOICE_NUMBER','INVOICE AP'),array('A.TGL_KEGIATAN','TGL KEGIATAN','DATERANGE2')));
		$this->newtable->tipe_proses('button');
		$this->newtable->tipe_proses2('button');
		$this->newtable->hiddens(array("KD_GUDANG","TGL_KEGIATAN","INVOICE_NUMBER"));
		$this->newtable->numberformat(array("QTY NOTA","TOTAL KSMU"));
		$this->newtable->keys(array("KD_GUDANG","TGL_KEGIATAN","INVOICE_NUMBER"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby(1);
		$this->newtable->groupby(array("C.KD_GUDANG","A.TGL_KEGIATAN"));
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("tbllaporanAP");
		$this->newtable->set_divid("divtbllaporanAP");
		$this->newtable->rowcount(10);
		$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate($SQL);
		$arrdata = array("page_title" => $page_title, "title" => $title, "content" => $tabel);
		if($this->input->post("ajax")||$act == "post")
			echo $tabel;
		else
			return $arrdata;
	}

	public function laporanAP_detil($act, $id){
		$KD_TPS = $this->newsession->userdata('KD_TPS');
		$KD_GUDANG = $this->newsession->userdata('KD_GUDANG');
		$KD_GROUP = $this->newsession->userdata('KD_GROUP');
		$arrid = explode("~",$id);
		$title = "DAFTAR NOTA KSMU";
		$SQL = "SELECT C.NO_INVOICE 'NO NOTA AR',date_format(C.TGL_TERIMA,'%d-%m-%Y') 'TGL NOTA AR',
		A.CUSTOMER_NUMBER 'CUSTOMER ID', IFNULL(A.NAMA_FORWARDER,A.CONSIGNEE) 'CUSTOMER', A.EX_NOTA 'EX NOTA AR',
		B.SUBTOTAL 'PENDAPATAN', D.TOTAL 'ADMINISTRASI', (B.SUBTOTAL-D.TOTAL) AS KSMU,A.NO_ORDER,A.ID,B.ID IDB
		FROM t_order_hdr A JOIN t_billing_cfshdr B ON A.NO_ORDER=B.NO_ORDER AND B.STATUS_BAYAR='SETTLED' AND B.IS_VOID IS NULL
		JOIN t_edc_payment_bank C ON C.NO_INVOICE=B.NO_INVOICE AND C.IS_VOID IS NULL
		JOIN t_billing_cfsdtl D ON B.ID=D.ID and D.KODE_BILL='ADM' JOIN mst_customer E ON E.CUSTOMER_ID=A.CUSTOMER_NUMBER
		where A.KD_GUDANG_TUJUAN=".$this->db->escape($arrid[0])." and date_format(C.TGL_TERIMA,'%Y-%m-%d')=".$this->db->escape($arrid[1]);
		$check1 = $this->db->query("SELECT C.GUDANG_NAME,DATE_FORMAT(TGL_KEGIATAN,'%d %M %Y') TGL,A.INVOICE_NUMBER,
		A.JML_NOTA,A.KSMU,DATE_FORMAT(B.INVOICE_DATE,'%d-%m-%Y') TGL_AP,DATE_FORMAT(B.GL_DATE_INVOICE,'%d-%m-%Y') TGL_GL,
		B.PAYMENT_NUMBER,DATE_FORMAT(B.PAYMENT_DATE,'%d-%m-%Y') TGL_JKK,B.AMOUNT_PAID,C.SUPPLIER_ID
		FROM xpi2_ap_payment_priok_h A LEFT JOIN xpi2_ap_payment_priok_v B ON A.INVOICE_NUMBER=B.INVOICE_NUMBER
		LEFT JOIN mst_cfsoperator_cust C ON A.SUPPLIER_ID=C.KD_CUST_GUDANG
		WHERE A.INVOICE_NUMBER = ".$this->db->escape($arrid[2]));
		$resulte1 = $check1->row_array();
		$info = '<div class="table-responsive"><table class="table m-b-0"><tbody>
				<tr><th colspan=4 style="text-align:center">Kegiatan Invoice AR: '.$resulte1['TGL'].'</th></tr>
				<tr><th width="20%">Invoice AP</th><td width="40%">'.$resulte1['INVOICE_NUMBER'].'</td><th width="20%">Tgl Invoice AP</th><td width="40%">'.$resulte1['TGL_AP'].'</td></tr>
				<tr><th>Supplier ID</th><td>'.$resulte1['SUPPLIER_ID'].'</td><th>Tgl JKK (Bayar)</th><td>'.$resulte1['TGL_JKK'].'</td></tr>
				<tr><th>Nama Supplier</th><td>'.$resulte1['GUDANG_NAME'].'</td><th>Payment Document</th><td>'.$resulte1['PAYMENT_NUMBER'].'</td></tr>
				<tr><th>Jumlah Nota</th><td>'.$resulte1['JML_NOTA'].'</td><th>Amount Paid</th><td>Rp '.number_format($resulte1['AMOUNT_PAID'],'0',',','.').',-</td></tr>
				<tr><th>Total KSMU</th><td>Rp '.number_format($resulte1['KSMU'],'0',',','.').',-</td><th></th><td></td></tr>
			  </tbody></table></div>';
		$proses = array(
			'PRINT'  => array('PRINTDIR', site_url()."/order/proses_print/order/invoice", '1','','icon-printer','','list')
		);
		$this->newtable->search(array(array('C.NO_INVOICE','NO NOTA AR'),array('A.CUSTOMER_NUMBER','CUSTOMER ID'),array('E.ALT_NAME', 'NAMA CUSTOMER')));
		$this->newtable->action(site_url() . "/report/laporanAP/".$act."/".$id);
		$this->newtable->multiple_search(false);
		$this->newtable->show_chk(false);
		$this->newtable->show_search(true);
		$this->newtable->tipe_proses('button');
		$this->newtable->tipe_proses2('button');
		$this->newtable->hiddens(array("NO_ORDER","ID","IDB"));
		$this->newtable->keys(array("NO_ORDER","ID","IDB"));
		$this->newtable->numberformat(array("PENDAPATAN","ADMINISTRASI","KSMU"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby(1);
		$this->newtable->sortby("ASC");
		$this->newtable->set_formid("tbllaporanAP_detil");
		$this->newtable->set_divid("divtbllaporanAP_detil");
		$this->newtable->rowcount(10);
		$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate($SQL);
		$arrdata = array("page_title" => $page_title, "title" => "<div class='text-center'><strong>".$title."</strong></div>", "info" => $info,"content" => $tabel);
		if($this->input->post("ajax")||$act == "post")
			echo $tabel;
		else
			return $arrdata;
	}

  public function laporanSales($act, $id){
		$this->newtable->breadcrumb('Home', site_url());
		$this->newtable->breadcrumb('LAPORAN', 'javascript:void(0)');
		$this->newtable->breadcrumb('SALES', 'javascript:void(0)');
		$data['title'] = 'LAPORAN SALES';
		$judul = "DATA LAPORAN SALES";
		$title = "LAPORAN SALES";
		$KD_TPS = $this->newsession->userdata('KD_TPS');
		$KD_GUDANG = $this->newsession->userdata('KD_GUDANG');
		$KD_GROUP = $this->newsession->userdata('KD_GROUP');
		$TIPE_ORGANISASI = $this->newsession->userdata('TIPE_ORGANISASI');
		$check = (grant()=="W")?true:false;
		$SQL = "SELECT DATE_FORMAT(c.TGL_TERIMA, '%y%m') TGL, DATE_FORMAT(c.TGL_TERIMA, '%M %Y') BULAN,
    CONCAT('Jumlah Nota : ', MTI.JML, '<br>Total Nominal : ', FORMAT(MTI.TOTAL, 0)) 'MTI',
    CONCAT('Jumlah Nota : ', APW.JML, '<br>Total Nominal : ', FORMAT(APW.TOTAL, 0)) 'APW',
    COUNT(*) 'TOTAL NOTA', FORMAT(SUM(amount), 0) 'TOTAL NOMINAL', FORMAT((COUNT(*)*10000), 0) 'PENAGIHAN' FROM t_order_hdr a
    JOIN t_billing_cfshdr b ON a.NO_ORDER = b.NO_ORDER AND b.STATUS_BAYAR = 'SETTLED' AND b.IS_VOID IS NULL
    JOIN t_edc_payment_bank c ON b.NO_INVOICE = c.NO_INVOICE AND c.IS_VOID IS NULL
    LEFT JOIN (SELECT DATE_FORMAT(cb.TGL_TERIMA, '%y%m') TGL, COUNT(*) JML, SUM(amount) TOTAL FROM t_order_hdr ab
    JOIN t_billing_cfshdr bb ON ab.NO_ORDER = bb.NO_ORDER AND bb.STATUS_BAYAR = 'SETTLED' AND bb.IS_VOID IS NULL
    JOIN t_edc_payment_bank cb ON bb.NO_INVOICE = cb.NO_INVOICE AND cb.IS_VOID IS NULL WHERE ab.KD_GUDANG_TUJUAN = 'BAND'
    GROUP BY DATE_FORMAT(cb.TGL_TERIMA, '%y%m')) MTI ON MTI.TGL = DATE_FORMAT(c.TGL_TERIMA, '%y%m')
    LEFT JOIN (SELECT DATE_FORMAT(cb.TGL_TERIMA, '%y%m') TGL, COUNT(*) JML, SUM(amount) TOTAL FROM t_order_hdr ab
    JOIN t_billing_cfshdr bb ON ab.NO_ORDER = bb.NO_ORDER AND bb.STATUS_BAYAR = 'SETTLED' AND bb.IS_VOID IS NULL
    JOIN t_edc_payment_bank cb ON bb.NO_INVOICE = cb.NO_INVOICE AND cb.IS_VOID IS NULL WHERE ab.KD_GUDANG_TUJUAN = 'RAYA'
    GROUP BY DATE_FORMAT(cb.TGL_TERIMA, '%y%m')) APW ON APW.TGL = DATE_FORMAT(c.TGL_TERIMA, '%y%m')
    WHERE 1 = 1".$addsql;
		$this->newtable->multiple_search(true);
		$this->newtable->show_chk(false);
		$this->newtable->show_search(true);
		$proses = array(
		//'UPDATE DATA'  => array('GET_WS',"http://ipccfscenter.com/TPSServices/GetAP.php", '0','','icon-refresh','','menu'),
		'View Nota'  => array('MODALDTL',"report/laporanSales/detail", '1','','icon-magnifier-add','','list'),
		'View Trafik'  => array('MODAL', "report/laporanSales/trafik", '1','','icon-drawer','','list'),
		'Export Summary'  => array('EXCEL', site_url()."/report/execute/laporanSales", '0','','icon-printer','','list'));
		$this->newtable->search(array(array('c.TGL_TERIMA','TGL KEGIATAN','DATERANGE2')));
		$this->newtable->tipe_proses('button');
		$this->newtable->tipe_proses2('button');
		$this->newtable->hiddens(array("TGL"));
		$this->newtable->keys(array("TGL"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby(1);
		$this->newtable->groupby(array("TGL"));
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("tbllaporansales");
		$this->newtable->set_divid("divtbllaporansales");
		$this->newtable->rowcount(10);
		$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate($SQL);
		$arrdata = array("page_title" => $page_title, "title" => $title, "content" => $tabel);
		if($this->input->post("ajax")||$act == "post")
			echo $tabel;
		else
			return $arrdata;
	}

  public function laporanSales_detil($act, $id){
		$title = "LAPORAN SALES DETAIL";
    $arrid = explode("~",$id);
		$KD_TPS = $this->newsession->userdata('KD_TPS');
		$KD_GUDANG = $this->newsession->userdata('KD_GUDANG');
		$KD_GROUP = $this->newsession->userdata('KD_GROUP');
		$TIPE_ORGANISASI = $this->newsession->userdata('TIPE_ORGANISASI');
    $arrnamaGudang = $this->get_comboboxnamagudang("GUDANG");
		$check = (grant()=="W")?true:false;
		$SQL = "SELECT c.TGL_TERIMA,c.NO_INVOICE,c.NO_INVOICE AS 'NO INVOICE',
    DATE_FORMAT(c.TGL_TERIMA,'%d-%m-%Y %H:%i:%s') AS'TGL_INVOICE',a.EX_NOTA,
    IFNULL(a.NAMA_FORWARDER,a.CONSIGNEE) AS CUSTOMER, c.BANK,
    (CASE c.FL_EDC WHEN 'Y' THEN 'POS EDC' ELSE 'MANUAL' END) AS EDC,
    (CASE WHEN d.WEIGHT > d.MEASURE THEN CASE WHEN CEIL(d.WEIGHT)<2 THEN 2 ELSE CEIL(d.WEIGHT) END
	  ELSE CASE WHEN CEIL(d.MEASURE)<2 THEN 2 ELSE CEIL(d.MEASURE) END END) AS CBM,
    c.AMOUNT 'TOTAL TAGIHAN' FROM t_order_hdr a
    JOIN t_billing_cfshdr b ON a.NO_ORDER=b.NO_ORDER AND b.STATUS_BAYAR='SETTLED' AND b.IS_VOID IS NULL
    JOIN t_edc_payment_bank c ON b.NO_INVOICE=c.NO_INVOICE AND c.IS_VOID IS NULL
    JOIN (SELECT dtl.* FROM t_billing_cfsdtl dtl JOIN t_billing_cfshdr hdr ON hdr.ID=dtl.ID
    WHERE dtl.KODE_BILL='ADM' GROUP BY hdr.ID) d ON d.ID=b.ID
    JOIN mst_cfsoperator_cust m ON m.KD_GUDANG=a.KD_GUDANG_TUJUAN
    WHERE DATE_FORMAT(c.TGL_TERIMA,'%y%m') = ".$this->db->escape($arrid[0]);
		$this->newtable->multiple_search(true);
		$this->newtable->show_chk(false);
		$this->newtable->show_search(true);
		$this->newtable->search(array(array('a.KD_GUDANG_TUJUAN', 'GUDANG', 'OPTION', $arrnamaGudang),array('c.NO_INVOICE','NO INVOICE'),array('c.TGL_TERIMA','TGL INVOICE','DATERANGE2')));
    $this->newtable->action(site_url() . "/report/laporanSales/".$act."/".$id);
		$this->newtable->hiddens(array("TGL_TERIMA","NO_INVOICE"));
		$this->newtable->keys(array("NO_INVOICE"));
    $this->newtable->numberformat(array("CBM","TOTAL TAGIHAN"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby(1);
		$this->newtable->sortby("DESC");
		$this->newtable->set_formid("tbllaporansales_detil");
		$this->newtable->set_divid("divtbllaporansales_detil");
		$this->newtable->rowcount(10);
		$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate($SQL);
		$arrdata = array("page_title" => $page_title, "title" => $title, "content" => $tabel);
		if($this->input->post("ajax")||$act == "post")
			echo $tabel;
		else
			return $arrdata;
	}

  public function laporanSales_trafik($act, $id){
		$title = "LAPORAN SALES TRAFIK";
    $arrid = explode("~",$id);
		$KD_TPS = $this->newsession->userdata('KD_TPS');
		$KD_GUDANG = $this->newsession->userdata('KD_GUDANG');
		$KD_GROUP = $this->newsession->userdata('KD_GROUP');
		$TIPE_ORGANISASI = $this->newsession->userdata('TIPE_ORGANISASI');
    $arrnamaGudang = $this->get_comboboxnamagudang("GUDANG");
		$check = (grant()=="W")?true:false;
		$SQL = "SELECT cal.my_date,DATE_FORMAT(cal.my_date,'%d-%m-%Y') AS TANGGAL,
    (CASE WHEN r1.JML_NOTA IS NOT NULL OR r2.JML_NOTA IS NOT NULL THEN COALESCE(r1.JML_NOTA, 0)
    ELSE '<span class=\"text-danger\">Libur/Tidak ada transaksi</span>' END) AS APW,
    (CASE WHEN r1.JML_NOTA IS NOT NULL OR r2.JML_NOTA IS NOT NULL THEN COALESCE(r2.JML_NOTA, 0)
    ELSE '<span class=\"text-danger\">Libur/Tidak ada transaksi</span>' END) AS MTI,
    (CASE WHEN r1.JML_NOTA IS NOT NULL OR r2.JML_NOTA IS NOT NULL
    THEN COALESCE(r0.JML, 0) ELSE '' END) AS Subtotal
    FROM (SELECT s.start_date + INTERVAL (r.ID) DAY AS my_date FROM (SELECT
    LAST_DAY(STR_TO_DATE(".$this->db->escape($arrid[0].'01').",'%y%m%d')) + INTERVAL 1 DAY - INTERVAL 1 MONTH AS start_date,
    LAST_DAY(STR_TO_DATE(".$this->db->escape($arrid[0].'01').",'%y%m%d')) AS end_date) AS s
    JOIN reff_billing AS r ON r.ID <= DATEDIFF(s.end_date, s.start_date)) AS cal
    LEFT JOIN (SELECT DISTINCT TGL_KEGIATAN, SUM(JML_NOTA) JML
    FROM xpi2_ap_payment_priok_h GROUP BY TGL_KEGIATAN) r0 ON r0.TGL_KEGIATAN >= cal.my_date
    AND r0.TGL_KEGIATAN < cal.my_date + INTERVAL 1 DAY
    LEFT JOIN xpi2_ap_payment_priok_h r1 ON r1.TGL_KEGIATAN = r0.TGL_KEGIATAN AND r1.SUPPLIER_ID = '100110'
    LEFT JOIN xpi2_ap_payment_priok_h r2 ON r2.TGL_KEGIATAN = r0.TGL_KEGIATAN AND r2.SUPPLIER_ID = '106659'";
		$this->newtable->multiple_search(true);
		$this->newtable->show_chk(false);
		$this->newtable->show_search(true);
		$this->newtable->search(array(array('r0.TGL_KEGIATAN','TGL KEGIATAN','DATERANGE2')));
    $this->newtable->action(site_url() . "/report/laporanSales/".$act."/".$id);
		$this->newtable->hiddens(array("my_date"));
		$this->newtable->keys(array("my_date"));
    $this->newtable->numberformat(array("CBM","TOTAL TAGIHAN"));
		$this->newtable->cidb($this->db);
		$this->newtable->orderby(1);
		$this->newtable->sortby("ASC");
		$this->newtable->set_formid("tbllaporansales_trafik");
		$this->newtable->set_divid("divtbllaporansales_trafik");
		$this->newtable->rowcount(50);
		$this->newtable->clear();
		$this->newtable->menu($proses);
		$tabel .= $this->newtable->generate($SQL);
		$arrdata = array("page_title" => $page_title, "title" => $title, "content" => $tabel);
		if($this->input->post("ajax")||$act == "post")
			echo $tabel;
		else
			return $arrdata;
	}
}
