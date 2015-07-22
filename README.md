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
    new ScayTrase\Utils\SMSDeliveryBundle\SMSDeliveryBundle(),
    new Thilanga\Telstra\SMSBundle\ThilangaTelstraSMSBundle(),
    ....
    );
```

## Configuration

Basic interface supports two optional parameters:

```
#thilanga_telstra_sms:
#    enabled: true #By default enabled:false
#    sms_api_key: "######" #Consumer Key from https://dev.telstra.com   
#    sms_api_secret: "######" #Consumer Secret https://dev.telstra.com 
```

## Usage



### Example

```
    use Thilanga\Telstra\SMSBundle\Service\Telstra\SMSMessage;

    /**
     * @Route("/testsms", name="testsms")
     */
    public function sendSmsAction()
    {
        $message = new SMSMessage('0400001111', 'This is a test message.');
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

