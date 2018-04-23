<?php
namespace UniSharp\Payment\Factories;

use UniSharp\Payment\Factories\Factory;
use UniSharp\Payment\Gateways\CathayGateway;
use VoiceTube\TaiwanPaymentGateway\EcPayPaymentGateway;
use VoiceTube\TaiwanPaymentGateway\Common\GatewayInterface;
use VoiceTube\TaiwanPaymentGateway\SpGatewayPaymentGateway;

class Gateway extends Factory
{
    protected static $registered = [
        'AllPay'    => AllPayPaymentGateway::class,
        'SpGateway' => SpGatewayPaymentGateway::class,
        'EcPay'     => EcPayPaymentGateway::class,
        'Cathay'    => CathayGateway::class,
    ];
}
