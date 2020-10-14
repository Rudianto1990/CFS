<?php

require_once ('config.php' );
require_once ($CONF['root.dir'] . 'Libraries/nusoap/nusoap.php' );

$options = array('location' => 'http://ipccfscenter.com/TPSServices/server_jav.php', 
                  'uri' => 'http://ipccfscenter.com/',
				  'exceptions'=>true, 'trace' => 1);
$api = new SoapClient(NULL, $options);
?>
<form method="post" action="">
<input type="text" name="tes"/>
<button type="submit">send</button>
</form>
<?php if(isset($_POST['tes'])) {
	var_dump($api->__getFunctions());
	$SoapCallParameters = new stdClass();
$SoapCallParameters->String0 = $_POST['tes'];

	$obj =  $api->CheckConnection($_POST['tes']); 
echo "Response:\n" . $api->__getLastResponse() . "\n";
var_dump($obj);

        var_dump($api->__getLastRequest());
}?>



<?php
//versi curl langsung
//require_once ('config.php' );
//require_once ($CONF['root.dir'] . 'Libraries/nusoap/nusoap.php' );
    function SendCurl($xml, $url, $SOAPAction, $proxy = "", $port = "443") {
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

/* $options = array('location' => 'http://10.1.6.112/TPSServices/server_plp.php', 
                  'uri' => 'http://10.1.6.112/');
$api = new SoapClient(NULL, $options);
 */
?>
<!--form method="post" action="">
<label>XML Billing</label><br>
<textarea name="tes" rows="4" cols="50"></textarea><br>
<button type="submit">send</button>
</form-->
<?php 
//if(isset($_POST['tes'])) {
	//$api->"nama method"($parameter1,$parameter2,$parameter3);
	//parameter disesuaikan dengan method
	//echo $api->LoadBillingGudang($_POST['tes'],"TES","TES"); 
/* $params = array(
  "String0" => $_POST['tes']
);
$response = $client->__soapCall("HelloWorld", array($params));

/* Print webservice response 
var_dump($response);
 */
    $xml = '<soapenv:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:urn="urn:LoadBillingGudangwsdl">
   <soapenv:Header/>
   <soapenv:Body>
      <urn:LoadBillingGudang soapenv:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/">
         <fStream xsi:type="xsd:string">' . htmlspecialchars($_POST['tes']) . '</fStream>
         <Username xsi:type="xsd:string">TES1</Username>
         <Password xsi:type="xsd:string">TES1</Password>
      </urn:LoadBillingGudang>
   </soapenv:Body>
</soapenv:Envelope>';
	//$Send = SendCurl($xml, "http://ipccfscenter.com/TPSServices/server_plp.php", "urn:TPSServices#LoadBillingGudang");

	//echo $Send['response'];

//}
?>