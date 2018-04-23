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

        $expect = simplexml_load_string("
			<form name='main'
				id='CATHAY_SPGATEWAY_FORM_GO_503e74d339f991a2d9296194d34f9acea8e19786'
				action='https://sslpayment.uwccb.com.tw/EPOSService/Payment/OrderInitial.aspx/OrderInitial.aspx'
                method='post'>
			   <input type='hidden' name='strRqXML' value='' />
			   <script>
                 document.getElementById('CATHAY_SPGATEWAY_FORM_GO_503e74d339f991a2d9296194d34f9acea8e19786').submit();
               </script>
			</form>
		");

var_dump($gateway->genForm(true));
        $response = simplexml_load_string($gateway->genForm(true));
        $this->assertEquals($expect['action'], $response['action']);
    }
}
