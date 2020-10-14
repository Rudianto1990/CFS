<?php 
/*+---------------------------------------------------------------------------------------------------+
  | $Web Service Template$                                                         					  |
  | Author                  : -                                                         			  |
  | Template Created Date	: 22-Des-2014                                                             |
  | Template Version        : 1.0                                                                     |
  |---------------------------------------------------------------------------------------------------|
  | $Template Modification History$                                                                   |
  |---------------------------------------------------------------------------------------------------|
  | Modification                                Date                                  Modification By |
  | Add generateResponse,array_to_xml			03-Feb-2015 						  Endang Fiansyah |
  |---------------------------------------------------------------------------------------------------|
  */
  
//======= Data Collection ========// 
// function to convert an array to XML using SimpleXML
function array_to_xml($array, &$xml) {
    foreach($array as $key => $value) {
        if(is_array($value)) {
            if(!is_numeric($key)){
                $subnode = $xml->addChild("$key");
                array_to_xml($value, $subnode);
            } else {
                array_to_xml($value, $xml);
            }
        } else {
            $xml->addChild("$key","$value");
        }
    }
}

function generateResponse($out_data_array, $response_code, $response_message, $msg_format="json")
{
	$response_message = str_replace(array("\t","\n"), ' ', $response_message);
	$arr = array('sc_type' => 1, 'sc_code' => 123456, 'rc' => $response_code, 'rcmsg' => $response_message, 'data' => $out_data_array);

	if($msg_format=="json")
		return json_encode($arr, JSON_HEX_TAG);
	else if($msg_format=="xml")
	{
		$xml = new SimpleXMLElement('<root/>');
		
		// function call to convert array to xml
		array_to_xml($arr, $xml);
		return $xml->asXML();
	}
	else 
	{
		return "undefined output data format, please check service bus app (data_collection.php -> generateResponse)";
	}	
}

//======= Set Debug Mode ========//
function getDebugMode()
{
	//if set true, return query to client
	//default is false
	return false;
}
//======= Set Debug Mode 2 ========//
function getDebugMode2()
{
	//if set true, return query if query fail/error
	//default is true
	return true;
}
?>