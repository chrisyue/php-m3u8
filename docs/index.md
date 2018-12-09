PHP M3U8
========

PHP M3U8 is an M3U8 file parser / dumper written in PHP.

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
vi demo.php
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
#EXT-X-MEDIA-SEQUENCE:7794
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

$mediaPlaylist = $parser->parse(new TextStream($m3u8Content));

var_export($mediaPlaylist);
echo PHP_EOL;

echo '*** Dumping media playlist... ***', PHP_EOL;
$text = new TextStream();
$dumper->dump($mediaPlaylist, $text);

echo $text, PHP_EOL;

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
information, see [how to define a tag](how-to-define-a-tag.md) and
[how to make a parsing/dumping rule](how-to-make-a-parsing-dumping-rule.md).
