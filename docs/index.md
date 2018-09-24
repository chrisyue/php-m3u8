PHP M3U8
========

PHP M3U8 is an M3U8 file parser / dumper written in PHP.

Installation
------------

```bash
composer require 'chrisyue/php-m3u8:^3'
```

That was it.

How to Use
----------

```php
$m3u8Content = <<<'M3U8'
#EXTM3U
#EXT-X-VERSION:3
#EXT-X-TARGETDURATION:6
#EXT-X-MEDIA-SEQUENCE:12
#EXTINF:5.000,title
stream12.ts
#EXTINF:4.000,
stream13.ts
#EXTINF:3.000,
stream14.ts
#EXTINF:6.000,
stream15.ts
M3U8;

// parse
$parser = new Chrisyue\PhpM3u8\Facade\ParserFacade();
$playlist = $parser->parse(new Chrisyue\PhpM3u8\Stream\TextStream($m3u8Content));

var_export($playlist['EXT-X-VERSION']);
var_export($playlist['mediaSegments'][0]['EXTINF']);
var_export($playlist['mediaSegments'][0]['uri']);

// dump
$text = new TextStream();
$dumper = new DumperFacade();
$dumper->dump($playlist, $text);

echo $text;
```

As a "Facade" will hide too much details, if you take a look of those facade
classes, you'll notice that the real parser/dumper will take a "tag definitions"
and a "parsing/dumping rules" as it's dependencies. "definitions" or "rules" are
actually "configuration". All these "configuration" are defined in PHP files.
You may want to modify those configuration files to meet your needs. For more
information, see
[how to define a tag](how-to-define-a-tag.md) and
[how to make a parsing/dumping rule](how-to-make-a-parsing-dumping-rule.md).
