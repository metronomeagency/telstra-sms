<?php

namespace Thilanga\Telstra\SMSBundle\Message;

use ScayTrase\SmsDeliveryBundle\Service\ShortMessageInterface;

class TelstraSmsMessage implements ShortMessageInterface
{

    /** @var  string */
    private $recipient;
    /** @var  string */
    private $message;


    /**
     * TelstraSmsMessage constructor.
     * @param string $recipient
     * @param string $message
     */
    public function __construct($recipient, $message)
    {
        $this->recipient = $recipient;
        $this->message = $message;
    }

    /**
     * @return string
     */
    public function getRecipient()
    {
        return $this->recipient;
    }

    /**
     * @param string $recipient
     */
    public function setRecipient($recipient)
    {
        $this->recipient = $recipient;
    }

    /**
     * Get Message Body
     * @return string message to be sent
     */
    public function getBody()
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setBody($message)
    {
        $this->message = $message;
    }

}
