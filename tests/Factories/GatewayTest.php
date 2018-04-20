<?php
namespace UniSharp\Payment\Tests\Factories;

use PHPUnit\Framework\TestCase;
use UniSharp\Payment\Factories\Gateway;
use VoiceTube\TaiwanPaymentGateway\SpGatewayPaymentGateway;

class GatewayTest extends TestCase
{
    public function testCreate()
    {
        $this->assertInstanceOf(SpGatewayPaymentGateway::class, Gateway::create('SpGateway', []));
    }

    public function testRegister()
    {
    }
}
