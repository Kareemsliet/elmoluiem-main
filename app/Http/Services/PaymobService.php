<?php

namespace App\Http\Services;
use GuzzleHttp\Client;
class PaymobService
{
    protected $client;
    protected $apiKey;
    protected $integrationId;
    protected $iframeId;
    public $hmacSecret;
    public function __construct()
    {

        $this->client = new Client();

        $this->apiKey = "ZXlKaGJHY2lPaUpJVXpVeE1pSXNJblI1Y0NJNklrcFhWQ0o5LmV5SmpiR0Z6Y3lJNklrMWxjbU5vWVc1MElpd2ljSEp2Wm1sc1pWOXdheUk2TVRBd056RXlPU3dpYm1GdFpTSTZJakUzTkRBME16QXpOVFF1T1RFeU9UVTVJbjAuYlN0SlhxeTFfRXd0bWdsOXEyNVhIbGUzVklOQW1LQmlxYmhJUnVXRS1pc0VJOFEwTDdyOEZIbWgyZjJjWXVCdmdUcXlBUGt5NzBpMERnTkZ4MnVLRFE=";

        $this->integrationId = "4994459";

        $this->iframeId = "882288";

        $this->hmacSecret = "10CAF368CFC59CACBBACA3AD55A0D6C0";

        // $this->client = new Client();
        // $this->apiKey = "ZXlKaGJHY2lPaUpJVXpVeE1pSXNJblI1Y0NJNklrcFhWQ0o5LmV5SmpiR0Z6Y3lJNklrMWxjbU5vWVc1MElpd2ljSEp2Wm1sc1pWOXdheUk2TVRBeU5UazVOeXdpYm1GdFpTSTZJbWx1YVhScFlXd2lmUS5penRDeHcyblJyOUpGcEFhNzkxQmNTWGYwVGZHQ3lOR1ExQWt0eGJ4SFd5Z2lsSnJyY2Y3VWx5UFVDVnczWmtZa3AtT3ZkdlhESy12NXhFd3BKd3VpQQ==";
        // $this->integrationId = "4994454";
        // $this->iframeId = "902690";
        // $this->hmacSecret = "AC80E4DF48376B02974CBF9CAF9A7B7A";
    }

    public function generateAuthToken()
    {
        $response = $this->client->post('https://accept.paymob.com/api/auth/tokens', [
            'json' => [
                'api_key' => $this->apiKey,
            ],
        ]);

        $authToken = json_decode($response->getBody(), true)['token'];

        return $authToken;
    }

    public function generateOrderId($amount, $authToken)
    {

        $orderId = uniqid();

        $response = $this->client->post('https://accept.paymob.com/api/ecommerce/orders', [
            'json' => [
                'auth_token' => $authToken,
                'delivery_needed' => false,
                'amount_cents' => $amount * 100,
                'currency' => 'EGP',
                'merchant_order_id' => $orderId,
            ],
        ]);

        $orderId = json_decode($response->getBody(), true)['id'];

        return $orderId;
    }

    public function generatePaymentData($data)
    {
        $amount=$data["amount"];

        $authToken = $this->generateAuthToken();

        $orderId = $this->generateOrderId($amount, $authToken);

        $response = $this->client->post('https://accept.paymob.com/api/acceptance/payment_keys', [
            'json' => [
                'auth_token' => $authToken,
                'amount_cents' => $amount * 100,
                'expiration' => 3600,
                'order_id' => $orderId,
                'billing_data' => [
                    'first_name' => $data["name"],
                    'last_name' => $data["name"],
                    'email' => $data["email"],
                    'phone_number' => $data["phone"],
                    'street' => 'Street Name',
                    'building' => 'Building Name',
                    'floor' => 'Floor Number',
                    'apartment' => 'Apartment Number',
                    'city' => 'Cairo',
                    'state' => 'Cairo',
                    'country' => 'EG',
                ],
                'metadata' => [
                    'student_id' => $data["student_id"],
                    'orderable_id' => $data["orderable_id"],
                    'orderable_type' => $data["orderable_type"]=="App\Models\Lesson"?"lessons":"courses",
                ],
                'currency' => 'EGP',
                'integration_id' => $this->integrationId,
            ],
        ]);

        $paymentToken = json_decode($response->getBody(), true)['token'];

        return [
            "paymentToken"=>$paymentToken,
            "orderId"=>$orderId,
        ];
    }

    public function payWithPaymob($paymentToken, $phoneNumber)
    {
        $response = $this->client->post('https://accept.paymob.com/api/acceptance/payments/pay', [
            'json' => [
                'source' => [
                    'identifier' => $phoneNumber,
                    'subtype' => 'WALLET',
                    'wallet_issuer' => 'Vodafone'
                ],
                'payment_token' => $paymentToken,
            ],
        ]);

        $paymentResponse = json_decode($response->getBody(), true);

        return $paymentResponse;
    }
}