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
        $this->order['MerchantOrderNo'] = $merchantOrderNo;
        $this->order['Amt'] = $amount;
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
        return "<?xml version='1.0' encoding='UTF-8'?>
            <MERCHANTXML>
                <CAVALUE>{$this->genCheckValue()}</CAVALUE>
                <ORDERINFO>
                    <STOREID>{$this->order['MerchantID']}</STOREID>
                    <ORDERNUMBER>{$this->order['MerchantOrderNo']}</ORDERNUMBER>
                    <AMOUNT>{$this->order['Amt']}</AMOUNT>
                    {$inst}
                </ORDERINFO>
            </MERCHANTXML>
        ";
    }

    public function genForm($autoSubmit)
    {
        return "
            <form name='main' action='https://{$this->actionUrl}/OrderInitial.aspx' method='post' >
                <input type=hidden name='strRqXML' value='訂單 XML'>
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
