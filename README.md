# SMSBundle
Symfony2 Bundle -  Send SMS using Telstra API. This is an implimentation of scaytrase/symfony-sms-interface. Make sure you have Telestra API keys. [Register here](https://dev.telstra.com/) to get your API keys.


## Installation

Installation is available via Composer

### composer.json


```
require: "thilanga/telstra-sms": "dev-master"
```

### app/AppKernel.php

update your kernel bundle requirements as follows:

```
$bundles = array(
    ....
     //SMS
     new ScayTrase\SmsDeliveryBundle\SmsDeliveryBundle(),
     new Thilanga\Telstra\SMSBundle\ThilangaTelstraSMSBundle(),

    ....
    );
```

## Configuration

```
sms_delivery:
    transport: sms_delivery.transport.telstra
    disable_delivery: false
    delivery_recipient: null

thilanga_telstra_sms:
    enabled: true
    sms_api_key: xxxxxxxxxxxxxxxxxxx
    sms_api_secret: yyyyyyyyyyyyyyyy

```

## Usage



### Example

```
    use Thilanga\Telstra\SMSBundle\Message\TelstraSmsMessage;

    /**
     * @Route("/testsms", name="testsms")
     */
    public function sendSmsAction()
    {
        $message = new TelstraSmsMessage('0400001111', 'This is a test message.');

        $sender = $this->get('sms_delivery.sender');

        $result = $sender->send($message);

        if (isset($result->messageId)) {
            return new Response('Delivery :successful');
        } else {
            return new Response('Delivery :failed');
        }
    }
```

## Credits
[scaytrase](https://github.com/scaytrase/symfony-sms-interface) and [kubacode](https://github.com/kubacode/telstraSMS)

