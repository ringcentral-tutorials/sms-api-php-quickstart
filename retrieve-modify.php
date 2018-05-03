<?php

use Symfony\Component\Dotenv\Dotenv;

require('vendor/autoload.php');

$dotenv = new Dotenv();
$dotenv->load(__DIR__.'/.env');

$rcsdk = new RingCentral\SDK\SDK(getenv('RINGCENTRAL_CLIENT_ID'), getenv('RINGCENTRAL_CLIENT_SECRET'), getenv('RINGCENTRAL_SERVER_URL'));

$platform = $rcsdk->platform();

$platform->login(getenv('RINGCENTRAL_USERNAME'), getenv('RINGCENTRAL_EXTENSION'), getenv('RINGCENTRAL_PASSWORD'));

$r = $platform->get('/account/~/extension/~/message-store', array(
    'dateFrom' => '2018-05-03T06:33:00.000Z'
));
$messages = $r->json()->records;
$count = count($messages);
print_r("We get a list of {$count} messages");

$messageId = $messages[0]->id;
$r = $platform->put("/account/~/extension/~/message-store/{$messageId}", array(
    'readStatus' => 'Read'
));
$readStatus = $r->json()->readStatus;
print_r("\nMessage readStatus has been changed to {$readStatus}");

$platform->delete("/account/~/extension/~/message-store/{$messageId}");
print_r("\nMessage {$messageId} has been deleted");
