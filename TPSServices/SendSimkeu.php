<?php
    //ini buat scedhuler
    set_time_limit(3600);
    require_once("config.php");
    // die();
    $main = new main($CONF, $conn);
    $main->connect();

    if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown"))
        $ip = getenv("HTTP_CLIENT_IP");
    else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown"))
        $ip = getenv("REMOTE_ADDR");
    else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown"))
        $ip = getenv("HTTP_X_FORWARDED_FOR");
    else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown"))
        $ip = $_SERVER['REMOTE_ADDR'];
    else {
        $ip = "unknown/server";
    }

    //BEGIN
    if(date('H')>=19 && date('H')<=21){
        $SOAPAction = 'urn:portalintegrasiipc#pollServer';
        $ipAddress = $ip;
        $userName = 'SIMKEU';
        $Password = 'SIMKEU';
        $url = 'http://103.19.80.243/cfs_dev/dev/server.php?wsdl';
        // $url = 'http://103.19.80.243/cfs_dev/bos_ipctpk/server.php';
        $method = 'saveTransaction';
        $KdAPRF = 'SENTSIMKEU';

        $SQL = "SELECT A.ID, A.JENIS_BILLING, A.NO_ORDER,A.NO_INVOICE,B.EX_NOTA, C.BANK, B.CUSTOMER_NUMBER AS ID_ORGANISASI, IFNULL(B.NAMA_FORWARDER,B.CONSIGNEE) AS NAMA, IFNULL(B.ALAMAT_FORWARDER,B.ALAMAT_CONSIGNEE) AS ALAMAT, IFNULL(B.NPWP_FORWARDER,B.NPWP_CONSIGNEE) AS NPWP, A.SUBTOTAL, A.PPN, A.TOTAL, DATE_FORMAT(C.TGL_TERIMA, '%d/%m/%Y %H:%i:%s') AS TGL_TERIMA, C.APPR_CODE, C.REFF_NO, B.NM_ANGKUT,
            B.NO_VOYAGE, DATE_FORMAT(B.TGL_TIBA, '%d/%m/%Y') AS TGL_TIBA, B.NO_DO, B.NO_BL_AWB, func_name(B.KD_GUDANG_TUJUAN, 'GUDANG') AS GUDANG_TUJUAN, B.KD_GUDANG_TUJUAN, DATE_FORMAT(B.TGL_KELUAR, '%d/%m/%Y') AS TGL_KELUAR
            FROM t_billing_cfshdr A INNER JOIN t_order_hdr B ON A.NO_ORDER = B.NO_ORDER
            INNER JOIN t_edc_payment_bank C ON A.NO_INVOICE = C.NO_INVOICE
            WHERE A.IS_VOID IS NULL AND C.IS_VOID IS NULL AND A.IS_SENDSIMKEU = '100' AND A.NO_INVOICE IS NOT NULL
            AND date_format(NOW(),'%y%m%d%H')>=date_format(TGL_TERIMA,'%y%m%d%H') GROUP BY A.NO_INVOICE HAVING COUNT(A.NO_INVOICE)=1
            -- AND date_format('180110','%y%m%d')>date_format(TGL_TERIMA,'%y%m%d') AND date_format('180101','%y%m%d')<date_format(TGL_TERIMA,'%y%m%d')
            ORDER BY A.NO_INVOICE ASC LIMIT 100";
        $Query = $conn->query($SQL);
        if ($Query->size() > 0) {
            $message = '<?xml version="1.0" encoding="UTF-8"?>';
            $message .= '<root>';
            $message .= '<group>';
            while ($Query->next()) {
                $ID = $Query->get("ID");
                $JENIS_BILLING = $Query->get("JENIS_BILLING");//if kemasan petikemas
                $NO_INVOICE = $Query->get("NO_INVOICE");
                $EX_NOTA = $Query->get("EX_NOTA");
                $ID_ORGANISASI = $Query->get("ID_ORGANISASI");
                $NAMA = htmlspecialchars($Query->get("NAMA"));
                $ALAMAT = htmlspecialchars($Query->get("ALAMAT"));
                $NPWP = $Query->get("NPWP");
                $SUBTOTAL = $Query->get("SUBTOTAL");
                $PPN = $Query->get("PPN");
                $TOTAL = $Query->get("TOTAL");
                $TGL_TERIMA = $Query->get("TGL_TERIMA");
                $APPR_CODE = $Query->get("APPR_CODE");
                $REFF_NO = $Query->get("REFF_NO");
                $NM_ANGKUT = $Query->get("NM_ANGKUT");
                $NO_VOYAGE = $Query->get("NO_VOYAGE");
                $TGL_TIBA = $Query->get("TGL_TIBA");
                $NO_DO = $Query->get("NO_DO");
                $NO_BL_AWB = htmlspecialchars($Query->get("NO_BL_AWB"));
                $KD_GUDANG_TUJUAN = $Query->get("KD_GUDANG_TUJUAN");//if band atau apw(kd gudang)
                $GUDANG_TUJUAN = $Query->get("GUDANG_TUJUAN");
                $TGL_KELUAR = $Query->get("TGL_KELUAR");
                $NO_ORDER = $Query->get("NO_ORDER");
                $BANK = $Query->get("BANK");//if mandiri etc.

                $SQLgudang = "SELECT A.KD_CUST_GUDANG, A.GUDANG_NAME FROM mst_cfsoperator_cust A WHERE A.KD_GUDANG = '". $KD_GUDANG_TUJUAN ."'";
                $Querygudang = $conn->query($SQLgudang);
                $Querygudang->next();
                $kd_cust_gudang = $Querygudang->get("KD_CUST_GUDANG");
                $customer_name_vendor = $Querygudang->get("GUDANG_NAME");

                $SQLbank = "SELECT A.BANK_ID, A.BANK_ACCOUNT FROM mst_bank_account_simkeu A WHERE A.BANK_NAME = '". $BANK ."' AND A.TYPE='P'";
                $Querybank = $conn->query($SQLbank);
                $Querybank->next();
                $bankID = $Querybank->get("BANK_ID");
                $receiptaccount = $Querybank->get("BANK_ACCOUNT");

                $message .= '<component>';
                $message .= '<transaction>';
                $message .= '<header>';
                $message .= '<transaction_number>'. $NO_INVOICE .'</transaction_number>';
                $message .= '<prev_transaction_number>'. $EX_NOTA .'</prev_transaction_number>';
                $message .= '<request_number>'.$NO_ORDER.'</request_number>';
                $message .= '<tax_number>'. $NO_INVOICE .'</tax_number>';
                $message .= '<header_context>BRG</header_context>';//DARI MAS PANDIT
                $message .= '<header_sub_context>BRG12</header_sub_context>';//DARI MAS PANDIT
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
                // penambahan begin tgl 19 april

                // $SQLIntegrate = "SELECT A.SOURCE_SYSTEM,A.IS_TRANSACTION,A.IS_RECEIPT,A.IS_PAYABLE FROM mst_simkeu_integrated A";
                // $QueryIntegrate = $conn->query($SQLIntegrate);
                // $QueryIntegrate->next();
                // $SOURCE_SYSTEM = $QueryIntegrate->get("SOURCE_SYSTEM");
                // $IS_TRANSACTION = $QueryIntegrate->get("IS_TRANSACTION");
                // $IS_RECEIPT = $QueryIntegrate->get("IS_RECEIPT");
                // $IS_PAYABLE = $QueryIntegrate->get("IS_PAYABLE");

                // $message .= '<source_system>'. $SOURCE_SYSTEM .'</source_system>';
                // $message .= '<operation_unit_code></operation_unit_code>';
                // $message .= '<is_transaction>'. $IS_TRANSACTION .'</is_transaction>';
                // $message .= '<is_receipt>'. $IS_RECEIPT .'</is_receipt>';
                // $message .= '<is_payable>'. $IS_PAYABLE .'</is_payable>';
                // $message .= '<is_payable_resend>T</is_payable_resend>';
                // $message .= '<atribute2></atribute2>';
                // $message .= '<atribute3></atribute3>';
                // $message .= '<atribute5></atribute5>';

                // penambahan end
                $message .= '</header>';
                $message .= '<details>';
                $SQLDETIL = "SELECT A.KODE_BILL, C.DESKRIPSI, A.QTY, A.SATUAN, A.TARIF_DASAR, A.TOTAL, round(A.TOTAL/10) AS TAXPPN
                    FROM t_billing_cfsdtl A INNER JOIN t_billing_cfshdr B ON A.ID = B.ID
                    INNER JOIN reff_billing_cfs C ON A.KODE_BILL = C.KODE_BILL
                    WHERE A.ID = ". $ID ."";
                // echo $SQLDETIL;
                $QueryDetil = $conn->query($SQLDETIL);
                if ($QueryDetil->size() > 0) {
                    $ADMINISTRASI = '0';
                    $i = 0;
                    while ($QueryDetil->next()) {
                        $i = $i+1;
                        $KODE_BILL = $QueryDetil->get("KODE_BILL");
                        $DESKRIPSI = $QueryDetil->get("DESKRIPSI");
                        $QTY = $QueryDetil->get("QTY");
                        $SATUAN = $QueryDetil->get("SATUAN");
                        $TARIF_DASAR = $QueryDetil->get("TARIF_DASAR");
                        $TOTALDETIL = $QueryDetil->get("TOTAL");
                        $TAXPPN = $QueryDetil->get("TAXPPN");
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
                        $message .= '<service_type>'. $kdservicetype .'</service_type> '; //MASIH TENTATIVE
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
                $message .= '<receipt_account>'. $receiptaccount .'</receipt_account>';//DARI MAS PANDIT
                $message .= '<organization_id>83</organization_id>';
                $message .= '<bank_id>'. $bankID .'</bank_id>'; //DARI MAS PANDIT
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
                $Querypercentage = $conn->query($SQLpersentage);
                $Querypercentage->next();
                $share_percentage = $Querypercentage->get("SHARE_PERCENTAGE");
                // $share_percentage = '100';//tabel master
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
            }
            $message .= '</group>';
            $message .= '<configuration>';
            $message .= '<source_apps>CFS</source_apps>';
            $message .= '<ip_address>'. $ip .'</ip_address>';
            $message .= '<token></token>';
            $message .= '<key></key>';
            $message .= '</configuration>';
            $message .= '</root>';
            $xmlRequest = $message;
            // echo $message;die();
            // print_r($message);die();
            $xml = '<soapenv:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ser="http://services.beacukai.go.id/">
                            <soapenv:Header/>
                                <soapenv:Body>
                                <ser:saveIntegrasi soapenv:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/">
                                    <in_param xsi:type="xsd:string"><![CDATA['. $message .']]></in_param>
                                    <type xsi:type="xsd:string">NW</type>
                                </ser:saveIntegrasi>
                                </soapenv:Body>
                            </soapenv:Envelope>';
            $Send = $main->SendCurl($xml, $url, $SOAPAction);
            //RESPONSE
            if ($Send['response'] != '') {
                echo $Send['response'];
                $xmlResponse = $Send['response'];
                $arr1 = 'ns1:saveIntegrasiResponse';
                $arr2 = 'return';
                $response = xml2ary($Send['response']);
                $response = $response['SOAP-ENV:Envelope']['_c']['SOAP-ENV:Body']['_c'][$arr1]['_c'][$arr2]['_v'];
                $xml = xml2ary($response);
                $root = $xml['root']['_c'];
                //print_r($root);die();
                $group = $root['group']['_c'];

                $countgroup = count($group);
                $component = $group['component'];
                $countcomponent = count($component);
                echo $countcomponent;
                if ($countcomponent > 1) {
                    //loop
                    for ($i=0; $i < $countcomponent; $i++) {
                        $istrue = "true";
                        $message = "";
                        $transaction = $component[$i]['_c']['transaction']['_c'];
                        $transaction_numbertrx = trim($transaction['transaction_number']['_v']) == "" ? "NULL" : "" . strtoupper(trim($transaction['transaction_number']['_v'])) . "";
                        $SQL = "UPDATE t_billing_cfshdr SET IS_SENDSIMKEU = '200' WHERE NO_INVOICE = '" . $transaction_numbertrx . "'";
                        $Execute = $conn->execute($SQL);
                        $statustrx = trim($transaction['status']['_v']) == "" ? "NULL" : "" . strtoupper(trim($transaction['status']['_v'])) . "";
                        $messagetrx = trim($transaction['message']['_v']) == "" ? "NULL" : "" . strtoupper(trim($transaction['message']['_v'])) . "";
                        $istrue .= $statustrx == "F" ? "false" : "true";
                        $message .= $messagetrx.",";

                        $receipt = $component[$i]['_c']['receipt']['_c'];
                        $receipt_number = trim($receipt['receipt_number']['_v']) == "" ? "NULL" : "" . strtoupper(trim($receipt['receipt_number']['_v'])) . "";
                        $statusrcpt = trim($receipt['status']['_v']) == "" ? "NULL" : "" . strtoupper(trim($receipt['status']['_v'])) . "";
                        $messagercpt = trim($receipt['message']['_v']) == "" ? "NULL" : "" . strtoupper(trim($receipt['message']['_v'])) . "";
                        $istrue .= $statusrcpt == "F" ? "false" : "true";
                        $message .= $messagercpt.",";

                        $payable = $component[$i]['_c']['payable']['_c'];
                        $transaction_numberpay = trim($payable['transaction_number']['_v']) == "" ? "NULL" : "" . strtoupper(trim($payable['transaction_number']['_v'])) . "";
                        $statuspay = trim($payable['status']['_v']) == "" ? "NULL" : "" . strtoupper(trim($payable['status']['_v'])) . "";
                        $messagepay = trim($payable['message']['_v']) == "" ? "NULL" : "" . strtoupper(trim($payable['message']['_v'])) . "";
                        $istrue .= $statuspay == "F" ? "false" : "true";
                        $message .= $messagepay;
                        $SQL = "UPDATE t_billing_cfshdr SET IS_SENDSIMKEU = '200' WHERE NO_INVOICE = '" . $transaction_numbertrx . "'";
                        $Execute = $conn->execute($SQL);

                        if (strpos($istrue, 'false') !== FALSE) {
                            //false
                            $SQL = "UPDATE t_billing_cfshdr SET IS_SENDSIMKEU = '400', WHERE NO_INVOICE = '" . $transaction_numbertrx . "'";
                            $Execute = $conn->execute($SQL);
                        } else {
                            //success
                            $SQL = "UPDATE t_billing_cfshdr SET IS_SENDSIMKEU = '300' WHERE NO_INVOICE = '" . $transaction_numbertrx . "'";
                            $Execute = $conn->execute($SQL);
                        }
                    }
                }elseif ($countcomponent == 1) {
                    $istrue = "true";
                    $message = "";
                    $transaction = $component['_c']['transaction']['_c'];
                    $transaction_numbertrx = trim($transaction['transaction_number']['_v']) == "" ? "NULL" : "" . strtoupper(trim($transaction['transaction_number']['_v'])) . "";
                    $SQL = "UPDATE t_billing_cfshdr SET IS_SENDSIMKEU = '200' WHERE NO_INVOICE = '" . $transaction_numbertrx . "'";
                    $Execute = $conn->execute($SQL);
                    $statustrx = trim($transaction['status']['_v']) == "" ? "NULL" : "" . strtoupper(trim($transaction['status']['_v'])) . "";
                    $messagetrx = trim($transaction['message']['_v']) == "" ? "NULL" : "" . strtoupper(trim($transaction['message']['_v'])) . "";
                    $istrue .= $statustrx == "F" ? "false" : "true";
                    $message .= $messagetrx.",";

                    $receipt = $component['_c']['receipt']['_c'];
                    $receipt_number = trim($receipt['receipt_number']['_v']) == "" ? "NULL" : "" . strtoupper(trim($receipt['receipt_number']['_v'])) . "";
                    $statusrcpt = trim($receipt['status']['_v']) == "" ? "NULL" : "" . strtoupper(trim($receipt['status']['_v'])) . "";
                    $messagercpt = trim($receipt['message']['_v']) == "" ? "NULL" : "" . strtoupper(trim($receipt['message']['_v'])) . "";
                    $istrue .= $statusrcpt == "F" ? "false" : "true";
                    $message .= $messagercpt.",";

                    $payable = $component['_c']['payable']['_c'];
                    $transaction_numberpay = trim($payable['transaction_number']['_v']) == "" ? "NULL" : "" . strtoupper(trim($payable['transaction_number']['_v'])) . "";
                    $statuspay = trim($payable['status']['_v']) == "" ? "NULL" : "" . strtoupper(trim($payable['status']['_v'])) . "";
                    $messagepay = trim($payable['message']['_v']) == "" ? "NULL" : "" . strtoupper(trim($payable['message']['_v'])) . "";
                    $istrue .= $statuspay == "F" ? "false" : "true";
                    $message .= $messagepay;
                    $SQL = "UPDATE t_billing_cfshdr SET IS_SENDSIMKEU = '200' WHERE NO_INVOICE = '" . $transaction_numbertrx . "'";
                    $Execute = $conn->execute($SQL);

                    if (strpos($istrue, 'false') !== FALSE) {
                        //false
                        $SQL = "UPDATE t_billing_cfshdr SET IS_SENDSIMKEU = '400' WHERE NO_INVOICE = '" . $transaction_numbertrx . "'";
                        $Execute = $conn->execute($SQL);
                    } else {
                        //success
                        $SQL = "UPDATE t_billing_cfshdr SET IS_SENDSIMKEU = '300' WHERE NO_INVOICE = '" . $transaction_numbertrx . "'";
                        $Execute = $conn->execute($SQL);
                    }
                }
                $KODE='200';
            } else {
                echo 'yoyi';
                $response = 'Tidak Dapat Respon';
                $KODE='100';
            }

            $SQL = "INSERT INTO mailbox(SNRF, KD_APRF, KD_ORG_SENDER, KD_ORG_RECEIVER, STR_DATA, KD_STATUS, TGL_STATUS)
                    VALUES (NULL, '" . $KdAPRF . "','1','1','" . mysql_real_escape_string($response) . "','".$KODE."',NOW())";
            $Execute = $conn->execute($SQL);
            if (!$Execute) echo 'mailbox = '.mysql_error();

            $SQL = "INSERT INTO app_log_services (USERNAME, PASSWORD, URL, METHOD, REQUEST, RESPONSE, IP_ADDRESS, WK_REKAM)
                    VALUES ('" . $userName . "','" . $Password . "','" . $url . "','" . $method . "','" . mysql_real_escape_string($xmlRequest) . "','" . mysql_real_escape_string($response) . "','" . $ipAddress . "', NOW())";
            $Execute = $conn->execute($SQL);
            if (!$Execute) echo 'app_log_services = '.mysql_error();
        } else {
            $SQL = "SELECT DATE_FORMAT(C.TGL_TERIMA,'%Y-%m-%d') AS TGL_KEGIATAN, COUNT(*) JML_NOTA, (SUM(B.SUBTOTAL)-SUM(D.TOTAL)) KSMU,
                (SUM(B.TOTAL)-SUM(D.TOTAL)-SUM(D.TOTAL/10)) AS KSMU_PPN,E.KD_CUST_GUDANG,SUM(C.AMOUNT) TOTAL
                FROM t_order_hdr A JOIN t_billing_cfshdr B ON A.NO_ORDER=B.NO_ORDER AND B.STATUS_BAYAR='SETTLED'
                AND B.IS_VOID IS NULL JOIN t_edc_payment_bank C ON C.NO_INVOICE=B.NO_INVOICE AND C.IS_VOID IS NULL
                JOIN t_billing_cfsdtl D ON B.ID=D.ID and D.KODE_BILL='ADM' JOIN mst_cfsoperator_cust E ON E.KD_GUDANG=A.KD_GUDANG_TUJUAN
                where DATE_FORMAT(C.TGL_TERIMA,'%Y-%m-%d') NOT IN (SELECT TGL_KEGIATAN FROM XPI2_AP_PAYMENT_PRIOK_H)
                group by A.KD_GUDANG_TUJUAN, TGL_KEGIATAN";
            $Query = $conn->query($SQL);
            if ($Query->size() > 0) {
                echo "GENERATE AP INVOICE<HR>";
                while ($Query->next()) {
                    $TGL_KEGIATAN = $Query->get("TGL_KEGIATAN");
                    $JML_NOTA = $Query->get("JML_NOTA");
                    $KSMU = $Query->get("KSMU");
                    $KSMU_PPN = $Query->get("KSMU_PPN");
                    $TOTAL = $Query->get("TOTAL");
                    $GUDANG = $Query->get("KD_CUST_GUDANG");
                    $SQL1 = "SELECT A.INVOICE_NUMBER, date_format(TGL_KEGIATAN,'%y') TAHUN, INISIAL
                        FROM xpi2_ap_payment_priok_h A JOIN mst_cfsoperator_cust B ON A.SUPPLIER_ID=B.KD_CUST_GUDANG
                        JOIN (SELECT MAX(INVOICE_NUMBER) INVOICE_NUMBER FROM xpi2_ap_payment_priok_h
                        WHERE SUPPLIER_ID = '".$GUDANG."') C ON C.INVOICE_NUMBER=A.INVOICE_NUMBER";
                    $Query1 = $conn->query($SQL1);
                    if ($Query1->size() > 0) {
                        $Query1->next();
                        $INVOICE_NUMBER = $Query1->get("INVOICE_NUMBER");
                        $TAHUN = $Query1->get("TAHUN");
                        $INISIAL = $Query1->get("INISIAL");
                        $year = date('y');
                        if($year>$TAHUN){
                            $noUrut = 1;
                        }else{
                            $noUrut = (int) substr($INVOICE_NUMBER, 12, 4);
                            $noUrut++;
                        }
                        $INVOICE_NUMBER = "CFS" . $INISIAL . "0083" . $year . sprintf("%04s", $noUrut);
                        echo $INVOICE_NUMBER.';';
                        $SQL = "INSERT INTO xpi2_ap_payment_priok_h(INVOICE_NUMBER, TGL_KEGIATAN, JML_NOTA, KSMU, KSMU_PPN, TOTAL, SUPPLIER_ID)
                                VALUES ('" . $INVOICE_NUMBER . "','".$TGL_KEGIATAN."','".$JML_NOTA."','" . $KSMU . "','" . $KSMU_PPN . "','" . $TOTAL . "','".$GUDANG."')";
                        $Execute = $conn->execute($SQL);
                        if (!$Execute) echo 'xpi2_ap_payment_priok_h = '.mysql_error();
                        echo '<br>';
                    }
                }
            }else{
                echo 'Data Tidak Ada';
            }
        }
    }else{
        echo "Hayoo mau ngapain? masih jam berapa ini";
    }

    //END

    $main->connect(false);
?>
