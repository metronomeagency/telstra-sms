# SMSBundle
Symfony2 Bundle -  Send SMS using Telstra API. This is an implimentation of scaytrase/symfony-sms-interface.


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
    new SMSBundle\SMSBundle(),
    ....
    );
```

## Configuration

Basic interface supports two optional parameters:

```
#sms:
#    enabled: true #By default enabled:false
#    sms_api_key: "######" #Consumer Key from https://dev.telstra.com   
#    sms_api_secret: "######" #Consumer Secret https://dev.telstra.com 
```

## Usage



### Example

```
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
