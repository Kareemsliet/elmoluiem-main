<?php

namespace App\Http\Services;
use GuzzleHttp\Client;
class PaymobTransfer
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
    }

    public function generateAuthToken()
    {
        $response = $this->client->post('https://accept.paymobsolutions.com/api/auth/tokens', [
            'json' => [
                'api_key' => $this->apiKey,
            ],
        ]);

        $authToken = json_decode($response->getBody(), true)['token'];

        return $authToken;
    }

    public function transfer(array $data)
    {
        $authToken = $this->generateAuthToken();

        $response = $this->client->post("https://accept.paymobsolutions.com/api/payouts", [
            'auth_token' => $authToken,
            'recipient' => [
                'identifier' => $data["wallet_number"],
                'subtype' => 'WALLET', 
            ],
            'amount_cents' => $data["amount"] * 100, 
            'currency' => 'EGP',
        ]);

        return json_decode($response->getBody(), true);
    }

    public function checkTransferStatsu($transactionId)
    {
        $response = $this->client->get("https://accept.paymobsolutions.com/api/disbursements/transaction/{$transactionId}", [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->apiKey,
            ],
        ]);

        return json_decode($response->getBody(), true);
    }
}