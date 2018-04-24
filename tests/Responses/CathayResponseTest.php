<?php
namespace UniSharp\Payment\Tests\Responses;

use PHPUnit\Framework\TestCase;
use UniSharp\Payment\Responses\CathayResponse;

class CathayResponseTest extends TestCase
{
    public function testXml()
    {
        $response = new CathayResponse([
            'merchantId' => '010990045',
            'hashKey' => 'f0dc9f7adb09a5985cdfa586cfae260c', // alias for CUBKEY
            'hashIV' => '1234', // 用不到
            'returnUrl' => 'http://example.com/callback'
        ]);

        $payload = "<?xml version='1.0' encoding='UTF-8'?>
            <MERCHANTXML>
                <CAVALUE>dfe573f5c1955609c8644c32fee70e7d</CAVALUE>
                <ORDERINFO>
                    <STOREID>010990045</STOREID>
                    <ORDERNUMBER>E180423102001</ORDERNUMBER>
                    <AMOUNT>2045</AMOUNT>
                </ORDERINFO>
                <AUTHINFO>
                    <AUTHSTATUS>0000</AUTHSTATUS>
                    <AUTHCODE>ab1234</AUTHCODE>
                    <AUTHTIME>20180424063020</AUTHTIME>
                    <AUTHMSG>nothin</AUTHMSG>
                </AUTHINFO>
            </MERCHANTXML>
        ";

        $_POST['strRqXML'] = $payload;

        $this->assertTrue($response->processOrder()['matched']);
    }

    public function testResponse()
    {
        $response = new CathayResponse([
            'merchantId' => '010990045',
            'hashKey' => 'f0dc9f7adb09a5985cdfa586cfae260c', // alias for CUBKEY
            'hashIV' => '1234', // 用不到
            'returnUrl' => 'http://example.com/callback'
        ]);

        $payload = "<?xml version='1.0' encoding='UTF-8'?>
            <MERCHANTXML>
                <CAVALUE>dfe573f5c1955609c8644c32fee70e7d</CAVALUE>
                <ORDERINFO>
                    <STOREID>010990045</STOREID>
                    <ORDERNUMBER>E180423102001</ORDERNUMBER>
                    <AMOUNT>2045</AMOUNT>
                </ORDERINFO>
                <AUTHINFO>
                    <AUTHSTATUS>0000</AUTHSTATUS>
                    <AUTHCODE>ab1234</AUTHCODE>
                    <AUTHTIME>20180424063020</AUTHTIME>
                    <AUTHMSG>nothin</AUTHMSG>
                </AUTHINFO>
            </MERCHANTXML>
        ";

        $_POST['strRqXML'] = $payload;

        $expect = "<?xml version='1.0' encoding='UTF-8'?>
        <MERCHANTXML>
            <CAVALUE>c8df674afe29939211873938262bf877</CAVALUE>
            <RETURL>http://example.com/callback</RETURL>
        </MERCHANTXML>
        ";

        $this->assertXmlStringEqualsXmlString($expect, $response->rspOk());
    }
}
