<?php
namespace UniSharp\Payment\Responses;

use VoiceTube\TaiwanPaymentGateway\Common;
use VoiceTube\TaiwanPaymentGateway\Common\AbstractResponse;
use VoiceTube\TaiwanPaymentGateway\Common\ResponseInterface;

class SpGatewayPaymentResponse extends AbstractResponse implements ResponseInterface
{
    public function processOrder()
    {
        return $this->processOrderXml();
    }


    public function processOrderXml()
    {
        if ($_POST && $_POST['strRqXML']) {
            return simplexml_load_string($_POST['strRqXML']);
        }
    }
}
