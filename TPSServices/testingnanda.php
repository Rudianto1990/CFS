<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS");
header("Access-Control-Max-Age: 604800");
header("Access-Control-Allow-Headers: x-requested-with, Content-Type, origin, authorization, accept, soapaction"); 
ob_start();
// call library
require_once ('config.php' );
//require_once ($CONF['root.dir'].'Libraries/soaplib/nusoap.php');
require_once ($CONF['root.dir'] . 'Libraries/nusoap-lokal/lib/nusoap.php');
require_once ($CONF['root.dir'] . 'Libraries/xml2array.php' );

$wsdlglobal = 'IVOServices';

// create instance
$server = new soap_server();

// initialize WSDL support
$server->configureWSDL('MIVOwsdl', 'urn:MIVOwsdl');

// place schema at namespace with prefix tns
$server->wsdl->schemaTargetNamespace = 'urn:MIVOwsdl';

// register method
$server->register('flogin', // method name
        array('Username' => 'xsd:string', 'Password' => 'xsd:string'), //input parameter
        array('return' => 'xsd:string'), // output
        'urn:floginwsdl', // namespace
        'urn:' . $wsdlglobal, // soapaction
        'rpc', // style
        'encoded', // use
        'flogin'// documentation
);

function flogin($Username, $Password) {
    global $CONF, $conn;
    $conn->connect();
    // print_r($fStream);die();
    $WSDLSOAP = 'http://ipccfscenter.com/TPSServices/testingnanda.php';
    if($Username <> NULL){
        $message = '<?xml version="1.0" encoding="UTF-8"?>';
        $message .= '<DOCUMENT>';
        $message .= '<STATUS>TRUE</STATUS>';
        $message .= '<MESSAGE>SUKSES</MESSAGE>';
        $message .= '<USERNAME>'. $Username .'</USERNAME>';
        $message .= '<PASSWORD>'. $Password .'</PASSWORD>';
        $message .= '<ROLE>1</ROLE>';
        $message .= '</DOCUMENT>';
    } else {
        $message = '<?xml version="1.0" encoding="UTF-8"?>';
        $message .= '<DOCUMENT>';
        $message .= '<STATUS>FALSE</STATUS>';
        $message .= '<MESSAGE>Format Salah</MESSAGE>';
        $message .= '</DOCUMENT>';
    }


    $og = simplexml_load_string($message);

    $return = json_encode($og);
    $conn->disconnect();
    return $return;
}

$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';

$server->service($HTTP_RAW_POST_DATA);
?>
