<?php

namespace Thilanga\Telstra\SMSBundle\Service\Telstra;

use ScayTrase\Utils\SMSDeliveryBundle\Exception\DeliveryFailedException;
use ScayTrase\Utils\SMSDeliveryBundle\Service\ShortMessageInterface;

class SMSMessage implements  ShortMessageInterface{

    private $body = '';
    private $recipient = '';


    public function __construct($to, $body)
    {
        $this->recipient = $to;
        $this->body = $body;
    }

    /**
     * Get Message Body
     * @return string message to be sent
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Get Message Recipient
     * @return string message recipient number
     */
    public function getRecipient()
    {
        return $this->recipient;
    }

    /**
     * Set Message Recipient
     * @param $recipient string
     * @return void
     */
    public function setRecipient($recipient)
    {
        $this->recipient = $recipient;
    }

    /**
     * @param string $body
     */
    public function setBody($body)
    {
        $this->body = $body;
    }
}