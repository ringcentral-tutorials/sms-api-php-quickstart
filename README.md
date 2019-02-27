# SMS API PHP Quickstart

[![Community][community-img]][community-url]
[![Twitter][twitter-img]][twitter-url]

 [community-img]: https://img.shields.io/badge/dynamic/json.svg?label=community&colorB=&suffix=%20users&query=$.approximate_people_count&uri=http%3A%2F%2Fapi.getsatisfaction.com%2Fcompanies%2F102909.json
 [community-url]: https://devcommunity.ringcentral.com/ringcentraldev
 [twitter-img]: https://img.shields.io/twitter/follow/ringcentraldevs.svg?style=social&label=follow
 [twitter-url]: https://twitter.com/RingCentralDevs

A quickstart tutorial to teach users to use RingCentral SMS API. The following topics are included:

- How to send SMS
- How to send MMS
- How to track delivery status of messages
- How to retrieve and modify message history
- How to receive and reply to SMS messages


## Setup

```
composer install
yarn install
cp .env.sample .env
```

Edit `.env`


## Run demo code

```
php send-sms.php
php send-mms.php
php track-status.php
php retrieve-modify.php
php receive-reply.php
```

## Generate docs

```
yarn docs
```
