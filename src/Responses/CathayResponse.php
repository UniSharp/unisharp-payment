<?php
namespace UniSharp\Payment\Responses;

use VoiceTube\TaiwanPaymentGateway\Common;
use VoiceTube\TaiwanPaymentGateway\Common\AbstractResponse;
use VoiceTube\TaiwanPaymentGateway\Common\ResponseInterface;

class CathayResponse extends AbstractResponse implements ResponseInterface
{
    public function processOrder($type = 'xml')
    {
        return $this->processOrderXml();
    }

    
    public function matchCheckCode(array $payload = [])
    {
        if (isset($payload['AUTHINFO'])) {
            return $payload['CAVALUE'] == md5($payload['ORDERINFO']['STOREID'] .
                $payload['ORDERINFO']['ORDERNUMBER'] .
                $payload['ORDERINFO']['AMOUNT'] .
                $payload['AUTHINFO']['AUTHSTATUS'] .
                $payload['AUTHINFO']['AUTHCODE'] .
                $this->hashKey);
        }

        return $payload['CAVALUE'] == md5(
            $payload['ORDERINFO']['STOREID'] .
            $payload['ORDERINFO']['ORDERNUMBER'] .
            $this->hashKey
        );
    }

    public function rspOk()
    {
        $domain = parse_url($this->returnUrl)['host'];
        $cavalue = md5($domain . $this->hashKey);
        return "<?xml version='1.0' encoding='UTF-8'?>
            <MERCHANTXML><CAVALUE>$cavalue</CAVALUE><RETURL>{$this->returnUrl}</RETURL></MERCHANTXML>";
    }

    public function processOrderXml()
    {
        if ($_POST && $_POST['strRqXML']) {
            $payload = json_decode(json_encode(simplexml_load_string($_POST['strRqXML'])), true);
            $payload['matched'] = $this->matchCheckCode($payload);
            return $payload;
        }

        return false;
    }
}
