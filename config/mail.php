<?php

//send email in local
// return [
//     'driver' => env('MAIL_DRIVER', 'smtp'),
//     'host' => env('MAIL_HOST', 'smtp.gmail.com'),
//     'port' => env('MAIL_PORT', 587),
//     'from' => [
//         'address' => 'alangchi1994@gmail.com',
//         'name' => 'A Lang Chi - App Admin',
//     ],
//     'encryption' => env('MAIL_ENCRYPTION', 'tls'),
//     'username' => env('MAIL_USERNAME'),
//     'password' => env('MAIL_PASSWORD'),
//     'sendmail' => '/usr/sbin/sendmail -bs',
// ];

//Config email on heroku
return array(
  'driver' => 'smtp',
  'host' => 'smtp.sendgrid.net',
  'port' => 587,
  'from' => array('address' => 'alangchi1994@gmail.com', 'name' => 'A Lang Chi'),
  'encryption' => 'tls',
  'username' => 'alangchi',
  'password' => 'alangchi@17031994',
);