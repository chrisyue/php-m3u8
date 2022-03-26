PHP M3u8
========

[![Latest Stable Version](https://poser.pugx.org/chrisyue/php-m3u8/v/stable)](https://packagist.org/packages/chrisyue/php-m3u8)
[![License](https://poser.pugx.org/chrisyue/php-m3u8/license)](https://packagist.org/packages/chrisyue/php-m3u8)
[![CI Status](https://github.com/chrisyue/php-m3u8/actions/workflows/ci.yaml/badge.svg)](https://github.com/chrisyue/php-m3u8/actions)
[![Total Downloads](https://poser.pugx.org/chrisyue/php-m3u8/downloads)](https://packagist.org/packages/chrisyue/php-m3u8)
[![Donate](https://img.shields.io/badge/Donate-PayPal-green.svg)](https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=blizzchris@gmail.com&lc=US&item_name=Donation+for+PHP-M3U8&no_note=0&cn=&currency_code=USD&bn=PP-DonationsBF:btn_donateCC_LG.gif:NonHosted)

An M3u8 parser / dumper.

Now it fully supports for [RFC 8216](docs/supported-tags.md), and
it can support for non standard M3U(8) with little effort.

Installation
------------

Use composer to require it:

```bash
composer require 'chrisyue/php-m3u8:^4' # PHP 7.4 or PHP 8.*
composer require 'chrisyue/php-m3u8:^3' # PHP 5.6 or PHP 7.{0,1,2,3}
```

Quickstart
----------

Setup the demo project and install PHP M3U8 with it:

```bash
mkdir demo
cd demo
composer require 'chrisyue/php-m3u8:^4'
```

Copy the demo script file to the project root:

```bash
cp vendor/chrisyue/php-m3u8/demo/demo.php .
```

And run:

```bash
php demo.php
```

You could check the [demo file](demo/demo.php) out to find out how to use.

As a "Facade" hides too much details, if you take a look of those facade
classes, you'll notice that the real parser/dumper will take a "tag definitions"
and a "parsing/dumping rules" as it's dependencies. "definitions" and "rules" are
actually "configuration". All these "configuration"s are written in PHP. You may
want to modify those configuration files to meet your needs. For more
information, see
- [How to Define A Tag](docs/how-to-define-a-tag.md)
- [How to Make A Parsing/Dumping Rule](docs/how-to-make-a-parsing-dumping-rule.md)

Donation
--------

Thanks for your support :)

[![paypal](https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif)](https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=blizzchris@gmail.com&lc=US&item_name=Donation+for+PHP-M3U8&no_note=0&cn=&currency_code=USD&bn=PP-DonationsBF:btn_donateCC_LG.gif:NonHosted)

<img width="150" height="150" alt="Wechat Donation" src="https://www.chrisyue.com/wp-content/uploads/2020/08/wx-reward-code.jpg">
