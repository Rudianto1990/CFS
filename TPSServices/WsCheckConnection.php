<?php

set_time_limit(3600);
require_once("config.php");
//$CONF['url.wsdl'] = 'http://103.29.187.109/TPSServices/services.php';
//$CONF['url.wsdl'] = 'Https://agungwarehouse.co.id/webservice_cfs/cfsserver.php';
//$CONF['url.wsdl'] = 'http://ipccfscenter.com/TPSServices/server_jav.php';
//$CONF['url.wsdl'] = 'http://103.29.187.215/TPSServices/server_jav.php';
$CONF['url.wsdl'] = 'http://10.1.6.112/TPSServices/server_plp.php';
$method = 'CheckConnection';
$KdAPRF = '';
$SufixMethod = '';
$filename = $CONF['root.dir'] . "CheckScheduler/" . $method . "" . $SufixMethod . ".txt";
$main = new main($CONF, $conn);
$CheckFile = $main->CheckFile($filename);
if (!$CheckFile) {
    $createFile = $main->createFile($filename);
    $main->connect();

    //Tes koneksi Web Service BC
    $fStream = '<?xml version="1.0" encoding="UTF-8" ?>
<DOCUMENT xmlns="UploadCustomerData.xsd">
<CDM>
<CUSTOMER_ID_SEQ></CUSTOMER_ID_SEQ>
<CUSTOMER_ID>090909</CUSTOMER_ID>
<CUSTOMER_LABEL></CUSTOMER_LABEL>
<NAME>TANTO BERSAMA</NAME>
<ADDRESS></ADDRESS>
<NPWP></NPWP>
<EMAIL></EMAIL>
<WEBSITE></WEBSITE>
<PHONE></PHONE>
<COMPANY_TYPE></COMPANY_TYPE>
<ALT_NAME></ALT_NAME>
<DEED_ESTABLISHMENT></DEED_ESTABLISHMENT>
<CUSTOMER_GROUP></CUSTOMER_GROUP>
<CUSTOMER_TYPE></CUSTOMER_TYPE>
<SVC_VESSEL></SVC_VESSEL>
<SVC_CARGO></SVC_CARGO>
<SVC_CONTAINER></SVC_CONTAINER>
<SVC_MISC></SVC_MISC>
<IS_SUBSIDIARY></IS_SUBSIDIARY>
<HOLDING_NAME></HOLDING_NAME>
<EMPLOYEE_COUNT></EMPLOYEE_COUNT>
<IS_MAIN_BRANCH></IS_MAIN_BRANCH>
<PARTNERSHIP_DATE></PARTNERSHIP_DATE>
<PROVINCE></PROVINCE>
<CITY></CITY>
<CITY_TYPE></CITY_TYPE>
<KECAMATAN></KECAMATAN>
<KELURAHAN></KELURAHAN>
<POSTAL_CODE></POSTAL_CODE>
<FAX></FAX>
<PARENT_ID></PARENT_ID>
<CREATE_BY></CREATE_BY>
<CREATE_DATE></CREATE_DATE>
<CREATE_VIA></CREATE_VIA>
<CREATE_IP></CREATE_IP>
<EDIT_BY></EDIT_BY>
<EDIT_DATE></EDIT_DATE>
<EDIT_VIA></EDIT_VIA>
<EDIT_IP></EDIT_IP>
<IS_SHIPPING_AGENT></IS_SHIPPING_AGENT>
<IS_SHIPPING_LINE></IS_SHIPPING_LINE>
<REG_TYPE></REG_TYPE>
<IS_PBM></IS_PBM>
<IS_FF></IS_FF>
<IS_EMKL></IS_EMKL>
<IS_PPJK></IS_PPJK>
<IS_CONSIGNEE></IS_CONSIGNEE>
<REGISTRATION_COMPANY_ID></REGISTRATION_COMPANY_ID>
<HEADQUARTERS_ID></HEADQUARTERS_ID>
<HEADQUARTERS_NAME></HEADQUARTERS_NAME>
<STATUS_APPROVAL></STATUS_APPROVAL>
<TYPE_APPROVAL></TYPE_APPROVAL>
<STATUS_CUSTOMER></STATUS_CUSTOMER>
<CONFIRM_DATE></CONFIRM_DATE>
<APPROVE_DATE></APPROVE_DATE>
<ACCEPTANCE_DOC></ACCEPTANCE_DOC>
<ACCEPTANCE_DOC_DATE></ACCEPTANCE_DOC_DATE>
<REJECT_NOTES></REJECT_NOTES>
<REJECT_USER></REJECT_USER>
<REJECT_DATE></REJECT_DATE>
<BRANCH_SIGN></BRANCH_SIGN>
<PASSPORT></PASSPORT>
<CITIZENSHIP></CITIZENSHIP>
</CDM>
</DOCUMENT>
';
    echo $CONF['url.wsdl'];
    //$SOAPAction = 'http://services.beacukai.go.id/'.$method;
    $SOAPAction = 'urn:TPSServices#UploadCustomerData';
    $xml = '<soapenv:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ser="http://services.beacukai.go.id/">
                    <soapenv:Header/>
                        <soapenv:Body>
                           <ser:UploadCustomerData soapenv:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/">
                              <fStream xsi:type="xsd:string">' . htmlspecialchars($fStream) . '</fStream>
                              <Type xsi:type="xsd:string">INSERT</Type>
                           </ser:UploadCustomerData>
                        </soapenv:Body>
                     </soapenv:Envelope>';
    $xml = '<soapenv:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:urn="urn:UploadCustomerDatawsdl">
            <soapenv:Header/>
            <soapenv:Body>
               <urn:UploadCustomerData soapenv:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/">
                  <fStream xsi:type="xsd:string">' . htmlspecialchars($fStream) . '</fStream>
                  <Type xsi:type="xsd:string">INSERT</Type>
               </urn:UploadCustomerData>
            </soapenv:Body>
         </soapenv:Envelope>';
    $Send = SendCurl1($xml, $CONF['url.wsdl'], $SOAPAction, '', '');
    echo '<pre>';
    print_r($Send);
    echo '</pre>';
    if ($Send['response'] != '') {
        //echo $Send['response'];
        //$arr1 = 'CheckConnectionResponse';
        //$arr2 = 'CheckConnectionResult';
        $arr1 = 'UploadCustomerDataResponse';
        $arr2 = 'UploadCustomerDataResult';
        $response = xml2ary($Send['response']);
        $response = $response['soap:Envelope']['_c']['soap:Body']['_c'][$arr1]['_c'][$arr2]['_v'];
    } else {
        $response = '';
    }

    /* $SQL = "SELECT B.USERNAME_TPSONLINE_BC, B.PASSWORD_TPSONLINE_BC
      FROM t_organisasi B
      WHERE B.KD_TIPE_ORGANISASI IN ('TPS','TPS1','TPS2')";
      $Query = $conn->query($SQL);
      if ($Query->size() > 0) {
      while ($Query->next()) {
      $USERNAME_TPSONLINE_BC = $Query->get("USERNAME_TPSONLINE_BC");
      $PASSWORD_TPSONLINE_BC = $Query->get("PASSWORD_TPSONLINE_BC");

      $xml = '<soapenv:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ser="http://services.beacukai.go.id/">
      <soapenv:Header/>
      <soapenv:Body>
      <ser:CheckConnection soapenv:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/">
      <Username xsi:type="xsd:string">' . $USERNAME_TPSONLINE_BC . '</Username>
      <Password xsi:type="xsd:string">' . $PASSWORD_TPSONLINE_BC . '</Password>
      </ser:CheckConnection>
      </soapenv:Body>
      </soapenv:Envelope>';
      $Send = $main->SendCurl($xml, $CONF['url.wsdl'], $SOAPAction, $CONF['proxyhost'] . ":" . $CONF['proxyport'],'80');
      echo '<pre>';
      print_r($Send);
      echo '</pre>';
      if ($Send['response'] != '') {
      $arr1 = 'CheckConnectionResponse';
      $arr2 = 'CheckConnectionResult';
      $response = xml2ary($Send['response']);
      $response = $response['soap:Envelope']['_c']['soap:Body']['_c'][$arr1]['_c'][$arr2]['_v'];
      } else {
      $response = '';
      }
      }
      } */

    //Tes koneksi Web Service APW
    //$xml .= '<TGL_BAYAR>20171010160506</TGL_BAYAR>';
    /* $SOAPAction = '';
      $SQLUSER = "SELECT A.ID,A.NO_ORDER,A.NO_INVOICE,A.TGL_UPDATE,A.TOTAL FROM  t_billing_cfshdr A
      WHERE A.NO_ORDER LIKE '1001%' AND A.KD_ALASAN_BILLING='ACCEPT' AND A.NO_INVOICE IS NOT NULL AND A.FL_SEND='100'";
      $QueryUser = $conn->query($SQLUSER);

      if ($QueryUser->size() > 0) {//echo 'oke';
      while ($QueryUser->next()) {
      $xml = '<?xml version="1.0" encoding="UTF-8"?>';
      $xml .= '<DOCUMENT>';
      $xml .= '<RESPONPEMBAYARANCFS>';
      $xml .= '<NO_ORDER>' . $QueryUser->get("NO_ORDER") . '</NO_ORDER>';
      $xml .= '<NO_INVOICE>' . $QueryUser->get("NO_INVOICE") . '</NO_INVOICE>';
      $xml .= '<TGL_BAYAR>' . $QueryUser->get("TGL_UPDATE") . '</TGL_BAYAR>';
      $xml .= '<TOTAL_BAYAR>' . $QueryUser->get("TOTAL") . '</TOTAL_BAYAR>';
      $xml .= '</RESPONPEMBAYARANCFS>';
      $xml .= '</DOCUMENT>';
      $Send = $main->SendCurl($xml, $CONF['url.wsdl'], $SOAPAction);
      echo $xml.'<pre>';
      print_r($Send);
      echo '</pre>';
      if ($Send['response'] != '') {
      $arr1 = 'CheckConnectionResponse';
      $arr2 = 'CheckConnectionResult';
      $response = $Send['response'];
      $SQL = "UPDATE t_billing_cfshdr SET FL_SEND='200' WHERE ID='". $QueryUser->get("ID") ."'";
      $Execute = $conn->execute($SQL);
      } else {
      $response = '';
      }
      echo $response.'<hr>';
      }
      } */
    /*     $SOAPAction = '';
      $xml = '<?xml version="1.0" encoding="UTF-8"?>';
      $xml .= '<DOCUMENT>';
      $xml .= '<RESPONPEMBAYARANCFS>';
      $xml .= '<NO_ORDER>100120171010350</NO_ORDER>';
      $xml .= '<NO_INVOICE>000.010-17.23.00350</NO_INVOICE>';
      $xml .= '<TGL_BAYAR>2017-10-10 12:18:27</TGL_BAYAR>';
      $xml .= '<TOTAL_BAYAR>54450</TOTAL_BAYAR>';
      $xml .= '</RESPONPEMBAYARANCFS>';
      $xml .= '<RESPONPEMBAYARANCFS>';
      $xml .= '<NO_ORDER>100120171010349</NO_ORDER>';
      $xml .= '<NO_INVOICE>000.010-17.23.00349</NO_INVOICE>';
      $xml .= '<TGL_BAYAR>2017-10-10 12:18:26</TGL_BAYAR>';
      $xml .= '<TOTAL_BAYAR>574725</TOTAL_BAYAR>';
      $xml .= '</RESPONPEMBAYARANCFS>';
      $xml .= '<RESPONPEMBAYARANCFS>';
      $xml .= '<NO_ORDER>100120171010348/NO_ORDER>';
      $xml .= '<NO_INVOICE>000.010-17.23.00348</NO_INVOICE>';
      $xml .= '<TGL_BAYAR>2017-10-10 12:18:26</TGL_BAYAR>';
      $xml .= '<TOTAL_BAYAR>451525</TOTAL_BAYAR>';
      $xml .= '</RESPONPEMBAYARANCFS>';
      $xml .= '</DOCUMENT>';

      $Send = $main->SendCurl($xml, $CONF['url.wsdl'], $SOAPAction);
      echo $xml.'<pre>';
      print_r($Send);
      echo '</pre>';
      if ($Send['response'] != '') {
      $arr1 = 'CheckConnectionResponse';
      $arr2 = 'CheckConnectionResult';
      $response = xml2ary($Send['response']);
      $response = $response['soap:Envelope']['_c']['soap:Body']['_c'][$arr1]['_c'][$arr2]['_v'];
      } else {
      $response = '';
      }
      echo $response;
     */
    $main->connect(false);
    $main->removeFile($filename);
} else {
    echo 'Scheduler sedang berjalan, harap menghapus file ' . $method . '' . $SufixMethod . '.txt yang ada difolder CheckScheduler.';
}

function SendCurl1($xml, $url, $SOAPAction, $proxy = "", $port = "443") {
    $header[] = 'Content-Type: text/xml';
    $header[] = 'SOAPAction: "' . $SOAPAction . '"';
    $header[] = 'Content-length: ' . strlen($xml);
    $header[] = 'Connection: close';

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    #curl_setopt($ch, CURLOPT_PORT, $port);
    #curl_setopt($ch, CURLOPT_PROXY, $proxy);
    #curl_setopt($ch, CURLOPT_VERBOSE, 0);
    #curl_setopt($ch, CURLOPT_HEADER, 0);
    #curl_setopt($ch, CURLOPT_SSLVERSION, 3);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    //curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    //curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POST, true);
    //curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
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

?>