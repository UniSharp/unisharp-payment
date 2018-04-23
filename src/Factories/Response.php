<?
namespace UniSharp\Payment\Factories;

use UniSharp\Payment\Factories\Factory;
use UniSharp\Payment\Responses\CathayResponse;
use VoiceTube\TaiwanPaymentResponse\EcPayPaymentResponse;
use VoiceTube\TaiwanPaymentResponse\Common\ResponseInterface;
use VoiceTube\TaiwanPaymentResponse\SpGatewayPaymentResponse;

class Response extends Factory
{
    protected static $registered = [
        'AllPay'    => AllPayPaymentResponse::class,
        'SpGateway' => SpGatewayPaymentResponse::class,
        'EcPay'     => EcPayPaymentResponse::class,
        'Cathay'    => CathayResponse::class,
    ];
}
