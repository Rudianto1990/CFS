<?php

class main {

    var $conn;
    var $connSMS;
    var $CONF;
    var $LANG;
    var $strLabel = array();

    function main($config, $connection) {
        $this->conn = $connection;
        $this->CONF = $config;
    }

    function connect($status = true) {
        if ($status) {
            $this->conn->connect();
        } else {
            $this->conn->disconnect();
        }
        return true;
    }

    function checkDB() {
        if ($this->conn->isConnect) {
            $this->conn->disconnect();
        }
        return true;
    }

    function getData($fieldName, $tableName, $where = "", $operator = "", $value = "", $order = "", $sort = "ASC") {
        $field = implode(",", $fieldName);
        $SQL = "SELECT " . $field . " FROM " . $tableName . "";
        if ($where != "") {
            $SQL .= " WHERE " . $where . " " . $operator . " " . $value . "";
        }
        if ($order != "") {
            $SQL .= " ORDER BY  " . $order . " " . $sort;
        }
        //echo $SQL."<br>";
        $Query = $this->conn->query($SQL);
        $data["SIZE_DATA"] = $Query->size();
        while ($Query->next()) {
            foreach ($fieldName as $item) {
                $data[$item] = $Query->get($item);
            }
        }
        return $data;
    }

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

    function generateRandom($length = 8) {
        $pool = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        $str = '';
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($pool, mt_rand(0, strlen($pool) - 1), 1);
        }
        return $str;
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

    function createFile($filename, $txt = "") {
        $filename = fopen($filename, "w");
        fputs($filename, $txt);
        fclose($filename);
    }

    function CheckFile($filename) {
        if (file_exists($filename)) {
            return true;
        } else {
            return false;
        }
    }

    function removeFile($filename) {
        if (file_exists($filename)) {
            unlink($filename);
        }
    }

    function sendSoap($url, $proxyport, $proxyhost, $operation, $params = array(), $namespace, $soapAction) {
        require_once($this->CONF['root.dir'] . "Libraries/nusoap/nusoap.php");
        $client = new nusoap_client($url); //, false, $proxyhost, $proxyport);
        $client->soap_defencoding = 'UTF-8';
        $err = $client->getError();
        if ($err) {
            $result = '<h2>Constructor error</h2><pre>' . $err . '</pre>';
        } else {
            //call($operation,$params=array(),$namespace='http://tempuri.org',$soapAction='',$headers=false,$rpcParams=null,$style='rpc',$use='encoded')

            $result = $client->call($operation, $params, $namespace, $soapAction, false, null, 'document', 'literal');
        }
        return $result;
    }

}

?>