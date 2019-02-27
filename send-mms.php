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

$body = array(
   'from' => array( 'phoneNumber' => getenv('RINGCENTRAL_USERNAME') ),
   'to'   => array( array('phoneNumber' => getenv('RINGCENTRAL_RECEIVER')) ),
   'text' => 'Message content'
);

$request = $rcsdk->createMultipartBuilder()
    ->setBody( $body )
    ->add(fopen(__DIR__.'/docs/test.jpg', 'r'))
    ->request('/account/~/extension/~/sms');
$r = $platform->sendRequest($request);

print_r("Message ID: " . $r->json()->id . "\n");
?>
