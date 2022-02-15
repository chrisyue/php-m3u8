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

Use composer to require it, version 3 above is recommended.

```bash
composer require 'chrisyue/php-m3u8:^3'
```

Quickstart
----------

Setup the demo project and install PHP M3U8 with it:

```bash
mkdir demo
cd demo
composer require 'chrisyue/php-m3u8:^3'
```

Create a PHP script `demo.php` in project root

```bash
touch demo.php
```

Copy the code below to `demo.php`:

```php
<?php

use Chrisyue\PhpM3u8\Facade\DumperFacade;
use Chrisyue\PhpM3u8\Facade\ParserFacade;
use Chrisyue\PhpM3u8\Stream\TextStream;

require 'vendor/autoload.php';

$parser = new ParserFacade();
$dumper = new DumperFacade();

echo '*** Parsing media playlist... ***', PHP_EOL;

$m3u8Content = <<<'M3U8'
#EXTM3U
#EXT-X-VERSION:3
#EXT-X-MEDIA-SEQUENCE:77949999999
#EXT-X-TARGETDURATION:15

#EXT-X-KEY:METHOD=AES-128,URI="https://priv.example.com/key.php?r=52"

#EXTINF:2.833,
http://media.example.com/fileSequence52-A.ts
#EXTINF:15.0,
http://media.example.com/fileSequence52-B.ts
#EXTINF:13.333,
http://media.example.com/fileSequence52-C.ts

#EXT-X-KEY:METHOD=AES-128,URI="https://priv.example.com/key.php?r=53"

#EXTINF:15.0,
http://media.example.com/fileSequence53-A.ts
M3U8;

/**
 * @var ArrayObject
 */
$mediaPlaylist = $parser->parse(new TextStream($m3u8Content));

// Now you can get some data from the playlist easily
/**
 * @var ArrayObject
 */
$firstSegment = $mediaPlaylist['mediaSegments'][0];

// EXTINF tag is a Chrisyue\PhpM3u8\Data\Value\Tag\Inf
// for more information about tag value data type, please check the docs
echo 'The 1st segment\'s duration is ', $firstSegment['EXTINF']->getDuration(), PHP_EOL;
echo 'and the key URI is ', $firstSegment['EXT-X-KEY'][0]['URI'], PHP_EOL;
echo 'The version of this M3U8 is ', $mediaPlaylist['EXT-X-VERSION'], PHP_EOL;

// check what the whole result looks like
var_export($mediaPlaylist);
echo PHP_EOL;

// change some values before dumping
$firstSegment['uri'] = 'http://chrisyue.com/a.ts';
$firstSegment['EXTINF']->setTitle('hi');

echo '*** Dumping media playlist... ***', PHP_EOL;
$text = new TextStream();
$dumper->dump($mediaPlaylist, $text);

echo $text, PHP_EOL;

// MEDIA PLAYLIST DEMO END

// MASTER PLAYLIST DEMO START

echo '*** Parsing master playlist... ***', PHP_EOL;
$m3u8Content = <<<'M3U8'
#EXTM3U
#EXT-X-STREAM-INF:BANDWIDTH=1280000,AVERAGE-BANDWIDTH=1000000
http://example.com/low.m3u8
#EXT-X-STREAM-INF:BANDWIDTH=2560000,AVERAGE-BANDWIDTH=2000000
http://example.com/mid.m3u8
#EXT-X-STREAM-INF:BANDWIDTH=7680000,AVERAGE-BANDWIDTH=6000000
http://example.com/hi.m3u8
#EXT-X-STREAM-INF:BANDWIDTH=65000,CODECS="mp4a.40.5"
http://example.com/audio-only.m3u8
M3U8;

$masterPlaylist = $parser->parse(new TextStream($m3u8Content));

var_export($masterPlaylist);
echo PHP_EOL;

echo '*** Dumping media playlist... ***', PHP_EOL;
$text = new TextStream();
$dumper->dump($masterPlaylist, $text);

echo $text, PHP_EOL;
```

And run:

```bash
php demo.php
```

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
