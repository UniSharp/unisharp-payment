<?php
namespace UniSharp\Payment\Factories;

use UniSharp\Payment\Factories\Factory;
use UniSharp\Payment\Responses\CathayResponse;
use VoiceTube\TaiwanPaymentResponse\EcPayPaymentResponse;
use VoiceTube\TaiwanPaymentGateway\SpGatewayPaymentResponse;
use VoiceTube\TaiwanPaymentResponse\Common\ResponseInterface;

class Response extends Factory
{
    protected static $registered = [
        'AllPay'    => AllPayPaymentResponse::class,
        'SpGateway' => SpGatewayPaymentResponse::class,
        'EcPay'     => EcPayPaymentResponse::class,
        'Cathay'    => CathayResponse::class,
    ];
}
