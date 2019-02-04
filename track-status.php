<?php

use Symfony\Component\Dotenv\Dotenv;

require('vendor/autoload.php');

$dotenv = new Dotenv();
$dotenv->load(__DIR__.'/.env');

$rcsdk = new RingCentral\SDK\SDK(getenv('RINGCENTRAL_CLIENT_ID'),
                                 getenv('RINGCENTRAL_CLIENT_SECRET'),
      	                         getenv('RINGCENTRAL_SERVER_URL'));

$platform = $rcsdk->platform();
$platform->login( getenv('RINGCENTRAL_USERNAME'),
                  getenv('RINGCENTRAL_EXTENSION'),
                  getenv('RINGCENTRAL_PASSWORD') );

function check_status( $messageId ) {
    global $platform;
    $r = $platform->get("/account/~/extension/~/message-store/{$messageId}" );
    return $r->json()->messageStatus;
}

$r = $platform->post('/account/~/extension/~/sms', array(
    'from' => array('phoneNumber' => getenv('RINGCENTRAL_USERNAME')),
    'to' => array(
        array('phoneNumber' => getenv('RINGCENTRAL_RECEIVER')),
    ),
    'text' => 'Message content',
));

$messageId = $r->json()->id;
print_r("Message ID: " . $messageId . "\n");
$status = check_status( $messageId );
if ($status == "Delivered") {
    print_r('Message was sent successfully');
} else if ($status == "Queued") {
    print_r("Message is queued. Will check again in 5 seconds...\n");
    sleep(5);   
    print_r("New status is " . check_status($messageId) . "\n");
} else {
    print_r("Status is " . $status . "\n");
}
?>