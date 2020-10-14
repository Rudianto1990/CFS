<?php

set_time_limit(3600);
require_once("config.php");

$method = 'ReadLoadBillingGudang';
$KdAPRF = 'LoadBillingGudang';
$sqlerror='';
$main = new main($CONF, $conn);
$main->connect();

$SQL = "SELECT a.ID, a.REQUEST, a.RESPONSE FROM app_log_services a WHERE a.METHOD in ('LoadBillingGudang') and a.USERNAME='RAYA'
	AND a.FL_USED='0' order by a.WK_REKAM DESC limit 1";
$Query = $conn->query($SQL);
if ($Query->size() > 0) {
    while ($Query->next()) {
		$ID_LOG = $Query->get("ID");
		$STR_DATA = $Query->get("REQUEST");
		$RESPONSE = $Query->get("RESPONSE");

		$message = '<?xml version="1.0" encoding="UTF-8"?>';
		$message .= '<DOCUMENT>';
		$xml = xml2ary($STR_DATA);
		if (count($xml) > 0) {
			$xml = $xml['DOCUMENT']['_c'];
			$countBilling = 0;
			$countBilling = count($xml['LOADBILLINGGUDANG']);
			if ($countBilling > 1) {
				for ($c = 0; $c < $countBilling; $c++) {
					$billing = $xml['LOADBILLINGGUDANG'][$c]['_c'];
					$message .= insertorder($billing, $IDLogServices);
				}
			} elseif ($countBilling == 1) {
				$billing = $xml['LOADBILLINGGUDANG']['_c'];
				$message .= insertorder($billing, $IDLogServices);
			} else {
				$message .= '<LOADBILLING>';
				$message .= '<RESPON>Format fStream SALAH!!!</RESPON>';
				$message .= '</LOADBILLING>';
			}
		} else {
			$message .= '<LOADBILLING>';
			$message .= '<RESPON>Format fStream SALAH!!!</RESPON>';
			$message .= '</LOADBILLING>';
		}
		$message .= '</DOCUMENT>';
		echo $message.'<hr>';
    }
} else {
	echo 'data tidak ada.<hr>';
}

$main->connect(false);
  
function errorxml(){
	$message .= '<LOADBILLING>';
	$message .= '<RESPON>Format fStream SALAH!!!</RESPON>';
	$message .= '</LOADBILLING>';
	return $message;
}
function insertorder($billing, $ID_LOG) {
    global $CONF, $conn;
    $sqlerror = '';
    $message = "";
    $header = $billing['HEADER']['_c'];
    $detil = $billing['DETIL']['_c'];

    /* Begin Generate data header */

    $NO_ORDER = trim($header['NO_ORDER']['_v']) == "" ? "NULL" : "" . strtoupper(trim($header['NO_ORDER']['_v'])) . "";
    $JENIS_BILLING = trim($header['JENIS_BILLING']['_v']) == "" ? "NULL" : "" . strtoupper(trim($header['JENIS_BILLING']['_v'])) . "";
    $NO_BL_AWB = trim($header['NO_BL_AWB']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['NO_BL_AWB']['_v'])) . "'";
    $TGL_STRIPPING = trim($header['TGL_STRIPPING']['_v']) == "" ? "NULL" : "STR_TO_DATE('" . strtoupper(trim($header['TGL_STRIPPING']['_v'])) . "','%Y%m%d')";
    $TGL_KELUAR = trim($header['TGL_KELUAR']['_v']) == "" ? "NULL" : "STR_TO_DATE('" . strtoupper(trim($header['TGL_KELUAR']['_v'])) . "','%Y%m%d')";
    $NO_DO = trim($header['NO_DO']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['NO_DO']['_v'])) . "'";
    $TGL_DO = trim($header['TGL_DO']['_v']) == "" ? "NULL" : "STR_TO_DATE('" . strtoupper(trim($header['TGL_DO']['_v'])) . "','%Y%m%d')";
    $TGL_EXP_DO = trim($header['TGL_EXP_DO']['_v']) == "" ? "NULL" : "STR_TO_DATE('" . strtoupper(trim($header['TGL_EXP_DO']['_v'])) . "','%Y%m%d')";
    $NAMA_PBM = trim($header['NAMA_PBM']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['NAMA_PBM']['_v'])) . "'";
    $NPWP_PBM = trim($header['NPWP_PBM']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['NPWP_PBM']['_v'])) . "'";
    $ALAMAT_PBM = trim($header['ALAMAT_PBM']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['ALAMAT_PBM']['_v'])) . "'";
    $NOTA_EX = trim($header['NOTA_EX']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['NOTA_EX']['_v'])) . "";
    $NO_CONTAINER_ASAL = trim($header['NO_CONTAINER_ASAL']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['NO_CONTAINER_ASAL']['_v'])) . "'";
    $JENIS_DOKUMEN = trim($header['JENIS_DOKUMEN']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['JENIS_DOKUMEN']['_v'])) . "'";
    $NO_DOKUMEN = trim($header['NO_DOKUMEN']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['NO_DOKUMEN']['_v'])) . "'";
    $TGL_DOKUMEN = trim($header['TGL_DOKUMEN']['_v']) == "" ? "NULL" : "STR_TO_DATE('" . strtoupper(trim($header['TGL_DOKUMEN']['_v'])) . "','%Y%m%d')";
    $CONSIGNEE = trim($header['CONSIGNEE']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['CONSIGNEE']['_v'])) . "'";
    $NPWP_CONSIGNEE = trim($header['NPWP_CONSIGNEE']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['NPWP_CONSIGNEE']['_v'])) . "'";
    $ALAMAT_CONSIGNEE = trim($header['ALAMAT_CONSIGNEE']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['ALAMAT_CONSIGNEE']['_v'])) . "'";
    $NAMA_KAPAL = trim($header['NAMA_KAPAL']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['NAMA_KAPAL']['_v'])) . "'";
    $NO_VOYAGE = trim($header['NO_VOYAGE']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['NO_VOYAGE']['_v'])) . "'";
    $TANGGAL_TIBA = trim($header['TANGGAL_TIBA']['_v']) == "" ? "NULL" : "STR_TO_DATE('" . strtoupper(trim($header['TANGGAL_TIBA']['_v'])) . "','%Y%m%d')";
    $SUBTOTAL = trim($header['SUB_TOTAL']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['SUB_TOTAL']['_v'])) . "'";
    $PPN = trim($header['PPN']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['PPN']['_v'])) . "'";
    $TOTAL = trim($header['TOTAL']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['TOTAL']['_v'])) . "'";
    //$JENIS_BAYAR = trim($header['JENIS_BAYAR']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($header['JENIS_BAYAR']['_v'])) . "'";

    /* BEGIN Generate jenis transaksi */
    $cariOrder = "select A.TGL_KELUAR from t_order_hdr A WHERE A.NO_BL_AWB=" . $NO_BL_AWB . " order by A.ID desc limit 1";
    $hasilCariOrder = $conn->query($cariOrder);
    $hasilCariOrder->next();
    if ($hasilCariOrder->get("TGL_KELUAR") != "") {
        $TGL_KELUAR_LAMA = "'" . $hasilCariOrder->get("TGL_KELUAR") . "'";
        $JENIS_TRANSAKSI = 'P';
    } else {
        $TGL_KELUAR_LAMA = "NULL";
        $JENIS_TRANSAKSI = 'B';
    }
    /* END Generate jenis transaksi */
    $KD_GUDANG = (strpos($NO_ORDER, "10") == 0) ? 'RAYA' : 'BAND';
    /* BEGIN Generate kode proforma */
    if ($JENIS_BILLING == 1) {
        $kodetrx = "02";
    } elseif ($JENIS_BILLING == 2) {
        $kodetrx = "01";
    }
    $kdtglpro = date('Ymd');

    $SQLselectidbef = "SELECT substr(A.NO_PROFORMA_INVOICE, 12) AS NO_PROFORMA_INVOICE FROM t_billing_cfshdr A WHERE A.ID = (SELECT MAX(A.ID) FROM t_billing_cfshdr A) LIMIT 1";
    $Queryselectidbef = $conn->query($SQLselectidbef);
    $Queryselectidbef->next();
    $probef = $Queryselectidbef->get("NO_PROFORMA_INVOICE");
    $pronew = $probef + 1;

    if ($pronew <= 9) {
        $pro = '0000';
    } elseif (99 >= $pronew && $pronew > 9) {
        $pro = '000';
    } elseif (999 >= $pronew && $pronew > 99) {
        $pro = '00';
    } elseif (9999 >= $pronew && $pronew > 999) {
        $pro = '0';
    } elseif (99999 >= $pronew && $pronew > 9999) {
        $pro = '';
    }
    $prourut = $pro . $pronew;

    $NO_PROFORMA = $kodetrx . "-" . $kdtglpro . $prourut;
    /* END Generate kode proforma */
    /* End Generate data header */

    $SQLorder = "SELECT B.ID, B.NO_PROFORMA_INVOICE FROM t_order_hdr A join t_billing_cfshdr B on A.NO_ORDER=B.NO_ORDER 
				 WHERE A.NO_ORDER = '" . $NO_ORDER . "'";
    $Queryorder = $conn->query($SQLorder);
    if ($Queryorder->size() == 0) {
        $SQLHeaderorder = "INSERT INTO t_order_hdr(NO_ORDER,JENIS_TRANSAKSI,JENIS_BILLING,JENIS_BAYAR,TGL_KELUAR_LAMA,TGL_KELUAR,NO_BL_AWB,TGL_STRIPPING,NO_DO,TGL_DO,TGL_EXPIRED_DO,NAMA_FORWARDER,NPWP_FORWARDER,ALAMAT_FORWARDER,CONSIGNEE,NPWP_CONSIGNEE,ALAMAT_CONSIGNEE,KD_GUDANG_TUJUAN,NO_CONT_ASAL,NM_ANGKUT,NO_VOYAGE,TGL_TIBA,KD_KPBC,KODE_DOK,NO_SPPB,TGL_SPPB,WK_REKAM) VALUES('" . $NO_ORDER . "','" . $JENIS_TRANSAKSI . "','" . $JENIS_BILLING . "','A'," . $TGL_KELUAR_LAMA . "," . $TGL_KELUAR . "," . $NO_BL_AWB . "," . $TGL_STRIPPING . "," . $NO_DO . "," . $TGL_DO . "," . $TGL_EXP_DO . "," . $NAMA_PBM . "," . $NPWP_PBM . "," . $ALAMAT_PBM . "," . $CONSIGNEE . "," . $NPWP_CONSIGNEE . "," . $ALAMAT_CONSIGNEE . ",'" . $KD_GUDANG . "'," . $NO_CONTAINER_ASAL . "," . $NAMA_KAPAL . "," . $NO_VOYAGE . "," . $TANGGAL_TIBA . ",'040300'," . $JENIS_DOKUMEN . "," . $NO_DOKUMEN . "," . $TGL_DOKUMEN . ",NOW());";
        $Execute = $conn->execute($SQLHeaderorder);
        if ($Execute == "") {
            $sqlerror = 'Gagal insert data header';
			echo $SQLHeaderorder;
        }
    } else {
        $Queryorder->next();
        $NO_PROFORMA = $Queryorder->get("NO_PROFORMA_INVOICE");
    }
    if ($sqlerror == "") {
        $SQLHeader = "INSERT INTO t_billing_cfshdr(JENIS_BILLING,NO_ORDER,TGL_UPDATE,SUBTOTAL,PPN,TOTAL,FLAG_APPROVE,KD_ALASAN_BILLING,JENIS_BAYAR,NO_NOTA,NO_PROFORMA_INVOICE) VALUES('" . $JENIS_BILLING . "','" . $NO_ORDER . "',
		NOW()," . $SUBTOTAL . "," . $PPN . "," . $TOTAL . ",'Y','REJECT','A'," . $NOTA_EX . ",'" . $NO_PROFORMA . "');";
        $Execute = $conn->execute($SQLHeader);
        if ($Execute != "") {
            //detail
            $IDHeader = mysql_insert_id();
            $countTarif = 0;
            $countTarif = count($detil['TARIF']);
            $message .= '<LOADBILLING>';
            $message .= '<HEADER>';
            $message .= '<NO_ORDER>' . $NO_ORDER . '</NO_ORDER>';
            $message .= '</HEADER>';
            $message .= '<DETIL>';
            $messagetarif = '';
            if ($countTarif > 1) {
                for ($i = 0; $i < $countTarif; $i++) {
                    $chektarif = cektarif($detil['TARIF'][$i]['_c'], $NO_ORDER);
                    $chektarif = explode("|", $chektarif);
                    $RES = $chektarif[0];
                    $messagetarif .= $chektarif[1];
                }
            } elseif ($countTarif == 1) {
                $chektarif = cektarif($detil['TARIF']['_c'], $NO_ORDER);
                $chektarif = explode("|", $chektarif);
                $RES = $chektarif[0];
                $messagetarif .= $chektarif[1];
            }
            $message .= '<RESPON>' . $RES . '</RESPON>';
            $message .= $messagetarif;
            $message .= '</DETIL>';
            $message .= '</LOADBILLING>';

            if ($countTarif > 1) {
                for ($i = 0; $i < $countTarif; $i++) {
                    insertdetiltarif($detil, $detil['TARIF'][$i]['_c'], $IDHeader);
                }
            } elseif ($countTarif == 1) {
                insertdetiltarif($detil, $detil['TARIF']['_c'], $IDHeader);
            }

            $KODSTAT = ($RES == 'REJECT') ? '300' : '400';
            $SQLUpdateBillingOrder = "UPDATE t_order_hdr SET KD_STATUS = '" . $KODSTAT . "' WHERE NO_ORDER = '" . $NO_ORDER . "'; ";
            //var_dump($SQLUpdateBillingOrder);die();
            $Execute = $conn->execute($SQLUpdateBillingOrder);

            $SQLUpdateBillingHDR = "UPDATE t_billing_cfshdr SET KD_ALASAN_BILLING = '" . $RES . "' WHERE NO_ORDER = '" . $NO_ORDER . "'; ";
            $Execute = $conn->execute($SQLUpdateBillingHDR);

            $SQL = "UPDATE app_log_services SET FL_USED = '1', WK_USED = NOW() WHERE ID = '" . $ID_LOG . "'";
            $Execute = $conn->execute($SQL);
        } else {
            $message .= '<LOADBILLING>';
            $message .= '<HEADER>';
            $message .= '<NO_ORDER>' . $NO_ORDER . '</NO_ORDER>';
            $message .= '</HEADER>';
            $message .= '<DETIL>';
            $message .= '<RESPON>REJECT</RESPON>';
            $message .= '<ALASAN_REJECT>';
            $message .= '<KD_TARIF></KD_TARIF>';
            $message .= '<KETERANGAN>Gagal insert data billing</KETERANGAN>';
            $message .= '</ALASAN_REJECT>';
            $message .= '</DETIL>';
            $message .= '</LOADBILLING>';
            $SQL = "UPDATE app_log_services SET FL_USED = '1', KETERANGAN = 'Gagal insert data billing', WK_USED = NOW() WHERE ID = '" . $ID_LOG . "'";
            $Execute = $conn->execute($SQL);
        }
    } else {
        $message .= '<LOADBILLING>';
        $message .= '<HEADER>';
        $message .= '<NO_ORDER>' . $NO_ORDER . '</NO_ORDER>';
        $message .= '</HEADER>';
        $message .= '<DETIL>';
        $message .= '<RESPON>REJECT</RESPON>';
        $message .= '<ALASAN_REJECT>';
        $message .= '<KD_TARIF></KD_TARIF>';
        $message .= '<KETERANGAN>' . $sqlerror . '</KETERANGAN>';
        $message .= '</ALASAN_REJECT>';
        $message .= '</DETIL>';
        $message .= '</LOADBILLING>';
        $SQL = "UPDATE app_log_services SET FL_USED = '1', KETERANGAN = '" . $sqlerror . "', WK_USED = NOW() WHERE ID = '" . $ID_LOG . "'";
        $Execute = $conn->execute($SQL);
    }

    return $message;
}

function cektarif($tarif, $no_order) {
    global $CONF, $conn;
    $message = "";
    $TARIF_DASAR = trim($tarif['TARIF_DASAR']['_v']) == "" ? "NULL" : "" . strtoupper(trim($tarif['TARIF_DASAR']['_v'])) . "";
    $KODE = trim($tarif['KODE_TARIF']['_v']) == "" ? "NULL" : "" . strtoupper(trim($tarif['KODE_TARIF']['_v'])) . "";
    $SQLKode = "SELECT a.TARIF_DASAR FROM reff_billing_cfs a WHERE a.KODE_BILL = '" . $KODE . "'";
    $QueryKode = $conn->query($SQLKode);
    if ($QueryKode->size() > 0) {
        $QueryKode->next();
        $TARIF_DASAR_CFS = $QueryKode->get("TARIF_DASAR");
        if ($TARIF_DASAR > $TARIF_DASAR_CFS) {
            $RES = 'REJECT';
            $message .= '<ALASAN_REJECT>';
            $message .= '<KD_TARIF>' . $KODE . '</KD_TARIF>';
            $message .= '<KETERANGAN>Tarif billing melebihi tarif dasar</KETERANGAN>';
            $message .= '</ALASAN_REJECT>';
        } elseif ($TARIF_DASAR < $TARIF_DASAR_CFS) {
            $RES = 'REJECT';
            $message .= '<ALASAN_REJECT>';
            $message .= '<KD_TARIF>' . $KODE . '</KD_TARIF>';
            $message .= '<KETERANGAN>Tarif billing kurang dari tarif dasar</KETERANGAN>';
            $message .= '</ALASAN_REJECT>';
        } else {
            $RES = 'ACCEPT';
        }
    } else {
        $RES = 'REJECT';
        $message .= '<ALASAN_REJECT>';
        $message .= '<KD_TARIF>' . $KODE . '</KD_TARIF>';
        $message .= '<KETERANGAN>Kode tidak sesuai dengan tarif dasar</KETERANGAN>';
        $message .= '</ALASAN_REJECT>';
    }
    return $RES . "|" . $message;
}

function insertdetiltarif($detil, $tarif, $IDHeader) {
    global $CONF, $conn;
    $TARIF_DASAR = trim($tarif['TARIF_DASAR']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($tarif['TARIF_DASAR']['_v'])) . "'";
    $KODE = trim($tarif['KODE_TARIF']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($tarif['KODE_TARIF']['_v'])) . "'";
    $QTY = trim($tarif['QTY']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($tarif['QTY']['_v'])) . "'";
    $SATUAN = trim($tarif['SATUAN']['_v']) == "'" ? "NULL" : "'" . strtoupper(trim($tarif['SATUAN']['_v'])) . "'";
    $NILAI = trim($tarif['NILAI']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($tarif['NILAI']['_v'])) . "'";
    $HARI = trim($tarif['HARI']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($tarif['HARI']['_v'])) . "'";
    $JNS_KMS = trim($detil['JNS_KMS']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($detil['JNS_KMS']['_v'])) . "'";
    $MERK_KMS = trim($detil['MERK_KMS']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($detil['MERK_KMS']['_v'])) . "'";
    $JML_KMS = trim($detil['JML_KMS']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($detil['JML_KMS']['_v'])) . "'";
    $WEIGHT = trim($detil['WEIGHT']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($detil['WEIGHT']['_v'])) . "'";
    $MEASURE = trim($detil['MEASURE']['_v']) == "" ? "NULL" : "'" . strtoupper(trim($detil['MEASURE']['_v'])) . "'";
    //insert t_billing_cfsdtl
    $SQLDetil = "INSERT INTO t_billing_cfsdtl(ID,KODE_BILL,JNS_KMS,MRK_KMS,JML_KMS,TARIF_DASAR,TOTAL,QTY,HARI,SATUAN,WEIGHT,MEASURE) 
	VALUES('" . $IDHeader . "'," . $KODE . "," . $JNS_KMS . "," . $MERK_KMS . "," . $JML_KMS . "," . $TARIF_DASAR . "," . $NILAI . "," . $QTY . "," . $HARI . "," . $SATUAN . "," . $WEIGHT . "," . $MEASURE . "); ";
    $Execute = $conn->execute($SQLDetil);
}
?>
