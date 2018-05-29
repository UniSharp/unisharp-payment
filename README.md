# UniSharp Payment

Provide Cathay, TaiwanPay and more ways to pay

## Installation

```composer require unisharp/payment dev-master```

## Available Gateway

- [智付通 Spgateway](https://www.spgateway.com/)
- [綠界 ECPay](https://www.ecpay.com.tw/)
- [國泰世華 Cathay](https://www.cathaybk.com.tw/cathaybk/corp/cash/intro/receivable/#first-tab-04)

## Usages

Initial the gateway

```php
$cathay = UniSharp\Payment\Gateways\CathayGateway::create([
    'hashKey'       => 'c7fe1bfba42369ec1add502c9917e14d',
    'hashIV'        => '',
    'merchantId'    => '123456789',
    'version'       => '',
    'actionUrl'     => 'https://sslpayment.uwccb.com.tw/EPOSService/Payment/OrderInitial.aspx',
    'returnUrl'     => 'https://localhost/payment/confirm',
    'notifyUrl'     => 'https://localhost/payment/notify',
    'clientBackUrl' => 'https://localhost/payment/return',
    'paymentInfoUrl'=> 'https://localhost/payment/information',
]);
```

Generate post form

```php
$cathay->newOrder(
    $order->sn,
    $order->total_price,
    $order->name,
    $order->note
);

return $cathay->genForm(true);
```

Process order result/information

```php
$cathay = UniSharp\Payment\Responses\CathayResponse::create([
    'hashKey'       => 'c7fe1bfba42369ec1add502c9917e14d',
    'hashIV'        => '' 
]);
```

Check the payment response

```php
// Check resonse content
$result = $cathay->processOrder('xml');

// Check response success
$cathay->rspOk();
```

More details on (voicetube/taiwan-payment-gateway)[https://github.com/voicetube/Taiwan-Payment-Gateway]
