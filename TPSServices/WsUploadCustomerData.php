<?php

set_time_limit(3600);
require_once("config.php");
$CONF['url.wsdl'] = 'http://ipccfscenter.com/TPSServices/server_jav.php';
//$CONF['url.wsdl'] = 'http://10.1.6.112/TPSServices/server_jav.php';
$method = 'UploadCustomerData';
$KdAPRF = 'UPLOADCUSTOMERDATA';
$filename = $CONF['root.dir'] . "CheckScheduler/" . $method . ".txt";
$main = new main($CONF, $conn);
$CheckFile = $main->CheckFile($filename);
if (!$CheckFile) {
    $createFile = $main->createFile($filename);
    $main->connect();

    //BEGIN
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
</DOCUMENT>';


    $SOAPAction = 'urn:TPSServices#' . $method;
    $xml = '<soapenv:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:urn="urn:UploadCustomerDatawsdl">
                <soapenv:Header/>
                <soapenv:Body>
                   <urn:UploadCustomerData soapenv:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/">
                      <fStream xsi:type="xsd:string">' . htmlspecialchars($fStream) . '</fStream>
                      <Type xsi:type="xsd:string">INSERT</Type>
                   </urn:UploadCustomerData>
                </soapenv:Body>
             </soapenv:Envelope>';
    $Send = $main->SendCurl($xml, $CONF['url.wsdl'], $SOAPAction, $CONF['proxyhost'] . ":" . $CONF['proxyport'], '80');
    echo '<pre>';
    print_r($Send);
    echo '</pre>';
    if ($Send['response'] != '') {
        $arr1 = 'ns1:UploadCustomerDataResponse';
        $arr2 = 'UploadCustomerDataResult';
        $response = xml2ary($Send['response']);
        //$response = $response['soap:Envelope']['_c']['soap:Body']['_c'][$arr1]['_c'][$arr2]['_v'];
        $response = $response['SOAP-ENV:Envelope']['_c']['SOAP-ENV:Body']['_c'][$arr1]['_c'][$arr2]['_v'];
    } else {
        $response = '';
    }
    //END

    $main->connect(false);
    $main->removeFile($filename);
} else {
    echo 'Scheduler sedang berjalan, harap menghapus file ' . $method . '.txt yang ada difolder CheckScheduler.';
}

function SendCurl1($xml, $url, $SOAPAction, $proxy = "", $port = "443") {
    $header[] = 'Content-Type: text/xml';
    $header[] = 'SOAPAction: "' . $SOAPAction . '"';
    $header[] = 'Content-length: ' . strlen($xml);
    $header[] = 'Connection: close';

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    //curl_setopt($ch, CURLOPT_PORT, $port);
    //curl_setopt($ch, CURLOPT_PROXY, $proxy);
    //curl_setopt($ch, CURLOPT_VERBOSE, 0);
    //curl_setopt($ch, CURLOPT_HEADER, 0);
    //curl_setopt($ch, CURLOPT_SSLVERSION, 3);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    //curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($ch, CURLOPT_POST, TRUE);
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

?>