<?php

namespace Thilanga\Telstra\SMSBundle\Transport;


use ScayTrase\SmsDeliveryBundle\Exception\DeliveryFailedException;
use ScayTrase\SmsDeliveryBundle\Service\ShortMessageInterface;
use ScayTrase\SmsDeliveryBundle\Transport\TransportInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use Thilanga\Telstra\SMSBundle\Message\TelstraSmsMessage;


class TelstraSmsTransport implements TransportInterface
{
    const API_URL = 'https://api.telstra.com/';
    const API_VERSION = 'v1';

    private $container;

    private $client;

    private $clientID;

    private $clientSecret;

    private $accessToken;

    public function __construct($container)
    {


        $this->container = $container;
        $client = new Client([
            'base_uri' => self::API_URL . self::API_VERSION . '/',
            'exceptions' => FALSE
        ]);


        $this->client = $client;
        $this->clientID = $this->container->getParameter('thilanga_telstra_sms.sms_api_key');
        $this->clientSecret = $this->container->getParameter('thilanga_telstra_sms.sms_api_secret');

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

        if ($response->getStatusCode() == 200) {
            $accessToken = json_decode($response->getBody())->access_token;
        }

        $this->accessToken = $accessToken;
    }

    /**
     * @param ShortMessageInterface $message
     * @return boolean
     *
     * @throws DeliveryFailedException
     */
    public function send(ShortMessageInterface $message)
    {
        $telstraSmsMessage = new TelstraSmsMessage($message->getRecipient(), $message->getBody());
        return $this->sendMessage($telstraSmsMessage);
    }

    /**
     * @param $to
     * @param $body
     * @return mixed
     */
    public function sendMessage(ShortMessageInterface $message)
    {

        //Do authenticate here
        $this->authenticate();
        if ($this->accessToken != false) {
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
