<?php

use Symfony\Component\Dotenv\Dotenv;
use RingCentral\SDK\Subscription\Events\NotificationEvent;
use RingCentral\SDK\Subscription\Subscription;

require('vendor/autoload.php');

$dotenv = new Dotenv();
$dotenv->load(__DIR__.'/.env');

$rcsdk = new RingCentral\SDK\SDK(getenv('RINGCENTRAL_CLIENT_ID'), getenv('RINGCENTRAL_CLIENT_SECRET'), getenv('RINGCENTRAL_SERVER_URL'));

$platform = $rcsdk->platform();

$platform->login(getenv('RINGCENTRAL_USERNAME'), getenv('RINGCENTRAL_EXTENSION'), getenv('RINGCENTRAL_PASSWORD'));


$subscription = $rcsdk->createSubscription();
$subscription->addEvents(array('/restapi/v1.0/account/~/extension/~/message-store/instant?type=SMS'));
$subscription->addListener(Subscription::EVENT_NOTIFICATION, function (NotificationEvent $e) use ($platform) {
    $sender = $e->payload()['body']['from']['phoneNumber'];
    $r = $platform->post('/account/~/extension/~/sms', array(
        'from' => array('phoneNumber' => getenv('RINGCENTRAL_USERNAME')),
        'to' => array(
            array('phoneNumber' => $sender),
        ),
        'text' => 'This is an automatic reply',
    ));
    print_r('SMS replied: ' . $r->json()->id);
});
$subscription->setKeepPolling(true);
$r = $subscription->register();
