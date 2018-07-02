# Member Area (Vanilla PHP)
[![Donate](https://img.shields.io/badge/Donate-PayPal-brightgreen.svg?style=flat-square&logo=paypal)](https://paypal.me/PaulDSB/)

About
------------
Member area with mini-chat, OpenClassRooms exercise

Languages used
--------------
[![Language](https://img.shields.io/badge/Language-Vanilla--Php-red.svg?style=flat-square)][1]
[![Bootstrap](https://img.shields.io/badge/Css-BootStrap-blue.svg?style=flat-square)][2]

Installation
-------------
[![PhpStorm](https://img.shields.io/badge/Software-PHPStorm-ff69b4.svg?style=flat-square&colorB=B356EA)][3]
[![reCaptcha](https://img.shields.io/badge/Google-reCaptcha-blue.svg?style=flat-square)][4]

1. Dump the `dump_db.sql`into your database.
2. Rename the file `config/config.php.dist` to `config.php` and add your databaseName, username and password for mysql.
3. You have to create your [reCaptcha Google][4] . On the config domain, if you are on localhost, add:
```
localhost
127.0.0.1
```
Than add your `data-sitekey` and ``
- Start your localhost, and enjoy ;) 

[1]: http://php.net/manual/en/intro-whatis.php
[2]: https://getbootstrap.com/
[3]: https://www.jetbrains.com/phpstorm/
[4]: https://www.google.com/recaptcha/admin