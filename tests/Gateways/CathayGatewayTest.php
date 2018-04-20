<?php
namespace UniSharp\Payment\Tests\Gateways;

use PHPUnit\Framework\TestCase;
use UniSharp\Payment\Gateways\CathayGateway;
use VoiceTube\TaiwanPaymentGateway\SpGatewayPaymentGateway;

class CathayGatewayTest extends TestCase
{
    public function testXml()
    {
        $gateway = new CathayGateway([
            'merchantId' => '1234',
            'hashKey' => '1234', // alias for CUBKEY
            'hashIV' => '1234', // 用不到
        ]);

        $gateway->newOrder(
            '4567',
            50
        );

        $expect = "<?xml version='1.0' encoding='UTF-8'?>
            <MERCHANTXML>
                <CAVALUE>76732f2a42207344714c06c6a0963fe6</CAVALUE>
                <ORDERINFO>
                    <STOREID>1234</STOREID>
                    <ORDERNUMBER>4567</ORDERNUMBER>
                    <AMOUNT>50</AMOUNT>
                </ORDERINFO>
            </MERCHANTXML>
        ";

        $this->assertXmlStringEqualsXmlString($expect, $gateway->getXml());
    }

    public function setInstFlag()
    {
        $gateway = new CathayGateway([
            'merchantId' => '1234',
            'hashKey' => '1234', // alias for CUBKEY
            'hashIV' => '1234', // 用不到
        ]);

        $gateway->newOrder(
            '4567',
            50
        );

        $gateway->setCreditInstallment(5);

        $expect = "<?xml version='1.0' encoding='UTF-8'?>
            <MERCHANTXML>
                <CAVALUE>76732f2a42207344714c06c6a0963fe6</CAVALUE>
                <ORDERINFO>
                    <STOREID>1234</STOREID>
                    <ORDERNUMBER>4567</ORDERNUMBER>
                    <AMOUNT>50</AMOUNT>
                    <PERIODNUMBER>5</PERIODNUMBER>
                </ORDERINFO>
            </MERCHANTXML>
        ";

        $this->assertXmlStringEqualsXmlString($expect, $gateway->getXml());
    }

    public function testGenForm()
    {
        $gateway = new CathayGateway([
            'merchantId' => '1234',
            'hashKey' => '1234', // alias for CUBKEY
            'hashIV' => '1234', // 用不到
        ]);

        $gateway->newOrder(
            '4567',
            50
        );

        $gateway->genForm();
    }
}
