<?php

namespace Thilanga\Telstra\SMSBundle\Service\Telstra;

use MyProject\Proxies\__CG__\OtherProject\Proxies\__CG__\stdClass;
use ScayTrase\Utils\SMSDeliveryBundle\Exception\DeliveryFailedException;
use ScayTrase\Utils\SMSDeliveryBundle\Service\MessageDeliveryService;
use ScayTrase\Utils\SMSDeliveryBundle\Service\ShortMessageInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;

class TelstraMessageDeliveryService extends MessageDeliveryService
{

    const API_URL = 'https://api.telstra.com/';
    const API_VERSION = 'v1';

    private $container;

    /**
     * @var Client
     */
    private $client;

    private $clientID;

    private $clientSecret;

    private $accessToken;
    
    public function __construct($container)
    {
        parent::__construct($container);

        $this->container = $container;
        $client = new Client([
            'base_uri' => self::API_URL . self::API_VERSION . '/',
            'exceptions' => FALSE
        ]);

        $this->client = $client;
        $this->clientID = $this->container->getParameter('sms_key');
        $this->clientSecret = $this->container->getParameter('sms_secret');

        $this->authenticate();
    }


    /**
     *
     */
    private function authenticate()
    {
        $accessToken = false;
        $response = $this->client->get('oauth/token',
            ['query' => [
                'client_id' => $this->clientID,
                'client_secret' => $this->clientSecret,
                'grant_type' => 'client_credentials',
                'scope' => 'SMS'
            ]]);

        if($response->getStatusCode() == 200) {
            $accessToken = json_decode($response->getBody())->access_token;
        }

        $this->accessToken = $accessToken;
    }

    /**
     * @param $to
     * @param $body
     * @return mixed
     */
    public function sendMessage(ShortMessageInterface $message)
    {


        if($this->accessToken != false) {
            $to = $this->formatNumber($message->getRecipient());

            $response = $this->client->post('sms/messages', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->accessToken,
                    'Content-Type' => 'application/json'
                ],
                'json' => [
                    'to' => $to,
                    'body' => $message->getBody()
                ]
            ]);

            return json_decode($response->getBody());
        }

        return false;
    }

    /**
     * @param $messageID
     * @return mixed
     */
    public function getStatus($messageID)
    {
        $response = $this->client->get('sms/messages/' . $messageID, [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->accessToken
            ]
        ]);

        return json_decode($response->getBody());
    }

    /**
     * @param $messageID
     * @return mixed
     */
    public function getResponse($messageID)
    {
        $response = $this->client->get('sms/messages/' . $messageID . '/response', [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->accessToken
            ]
        ]);

        return json_decode($response->getBody());
    }

    /**
     * @param $number
     * @return mixed
     */
    private function formatNumber($number)
    {
        return str_replace(' ', '', $number);
    }
}