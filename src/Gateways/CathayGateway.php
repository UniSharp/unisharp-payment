<?php
namespace UniSharp\Payment\Gateways;

use VoiceTube\TaiwanPaymentGateway\Common\AbstractGateway;
use VoiceTube\TaiwanPaymentGateway\Common\GatewayInterface;

class CathayGateway extends AbstractGateway implements GatewayInterface
{
    public function newOrder(
        $merchantOrderNo,
        $amount,
        $itemDescribe = '',
        $orderComment = '',
        $respondType = '',
        $timestamp = 0
    ) {
        $this->order['MerchantID'] = $this->merchantId;
        $this->order['MerchantOrderNo'] = strtoupper($merchantOrderNo);
        $this->order['Amt'] = (int) $amount;
        if (empty($this->actionUrl)) {
            $this->actionUrl = 'https://sslpayment.uwccb.com.tw/EPOSService/Payment/OrderInitial.aspx';
        }
    }

    public function genCheckValue()
    {
        return md5($this->order['MerchantID'] . $this->order['MerchantOrderNo'] . $this->order['Amt'] . $this->hashKey);
    }

    public function getXml()
    {
        $inst = isset($this->order['InstFlag']) ? "<PERIODNUMBER>{$this->order['InstFlag']}</PERIODNUMBER>" : '';
        return str_replace("\n", '', "
            <MERCHANTXML>
                <CAVALUE>{$this->genCheckValue()}</CAVALUE>
                <ORDERINFO>
                    <STOREID>{$this->order['MerchantID']}</STOREID>
                    <ORDERNUMBER>{$this->order['MerchantOrderNo']}</ORDERNUMBER>
                    <AMOUNT>{$this->order['Amt']}</AMOUNT>
                    {$inst}
                </ORDERINFO>
            </MERCHANTXML>
        ");
    }

    public function genForm($autoSubmit)
    {

        $formId = sprintf("CATHAY_SPGATEWAY_FORM_GO_%s", sha1(time()));
        $xml = $this->getXml();
        return "
            <form name='main' id='{$formId}' action='{$this->actionUrl}' method='post'>
                <input type='hidden' name='strRqXML' value='{$xml}' />
				<script> document.getElementById('{$formId}').submit(); </script>
            </form>
        ";
    }

    public function useBarCode()
    {
        return $this;
    }

    public function useCVS()
    {
        return $this;
    }

    public function useATM()
    {
        return $this;
    }

    public function useCredit()
    {
        return $this;
    }

    public function setUnionPay()
    {
        return $this;
    }

    public function setCreditInstallment($months)
    {
        $this->order['InstFlag'] = $months;
        return $this;
    }

    public function setOrderExpire($expireDate)
    {
        return $this;
    }

    public function getOrder()
    {
        return $this->order;
    }
}
