How to Make a Parsing/Dumping Rule
==================================

If you've already checked the file
[tagValueParsers.php](../resources/tagValueParsers.php), you could find that
this file contains very simple "type => callable" rules which define how to
parse tag types:

```php
// resources/definitions/tagValueParsers.php
return [
    'int' => 'intval',
    // ...
];
```

As you may have figured it out already, you can easily add a new parser/dumper
for your own tag/attribute type. For example, some M3U(8)s have a negative
duration value of `EXTINF`, for supporting this non standard EXTINF tag, you
could create your own parsing/dumping rules, and use this rule to create your
own parser/dumper:

```php
<?php

use Chrisyue\PhpM3u8\Config;
use Chrisyue\PhpM3u8\Definition\TagDefinitions;
use Chrisyue\PhpM3u8\Dumper\Dumper;
use Chrisyue\PhpM3u8\Line\Lines;
use Chrisyue\PhpM3u8\Parser\DataBuilder;
use Chrisyue\PhpM3u8\Parser\Parser;
use Chrisyue\PhpM3u8\Stream\TextStream;

require 'vendor/autoload.php';

// create your own parser
// assume this script is put in project root dir
$parsingRules = require 'vendor/chrisyue/php-m3u8/resources/tagValueParsers.php';
$parsingRules['inf'] = function ($string) {
    sscanf($string, '%[^,],%[^$]', $duration, $title);

    return compact('duration', 'title');
};

$tagDefinitions = new TagDefinitions(require 'vendor/chrisyue/php-m3u8/resources/tags.php');
$parser = new Parser(
    $tagDefinitions,
    new Config($parsingRules), // use your own parsing rules
    new DataBuilder()
);

$m3u8Content = <<<'M3U8'
#EXTM3U
#EXTINF:-1,part1
http://media.example.com/fileSequence52-A.ts
#EXTINF:-1,
http://media.example.com/fileSequence52-B.ts
#EXTINF:-1,part2
http://media.example.com/fileSequence52-C.ts
#EXTINF:-1,
http://media.example.com/fileSequence53-A.ts
M3U8;

echo 'Parsing...', PHP_EOL;
$result = $parser->parse(new Lines(new TextStream($m3u8Content)));
var_export($result);
echo PHP_EOL, 'Done!', PHP_EOL, PHP_EOL;

// create your own dumper
$dumpingRules = require 'vendor/chrisyue/php-m3u8/resources/tagValueDumpers.php';
$dumpingRules['inf'] = function (array $inf) {
    return sprintf('%s,%s', $inf['duration'], $inf['title'] ?? '');
};

$dumper = new Dumper(
    $tagDefinitions,
    new Config($dumpingRules) // use your own dumping rules
);

echo 'Dumping...', PHP_EOL;
$stream = new TextStream();
$result = $dumper->dumpToLines($result, new Lines($stream));
echo $stream, 'Done!', PHP_EOL;
```

You could check the [tagValueDumpers.php](../resources/tagValueDumpers.php)
or [attributeValueParsers.php](../resources/attributeValueParsers.php),
[attributeValueDumpers.php](../resources/attributeValueDumpers.php) to get the
idea how to define a tag/attribute parser/dumper.

As you can see, PHP M3U8 is not only a parser/dumper, you could consider it as
an "M3U8 parser/dumper framework". If you try to parse/dump an very
old/experimental version of M3U8 document, which may differ a lot from RFC 8216,
or you want to generate different data structures other than the built-in ones,
all you gonna do is to make your own tag definitions or parsing/dumping rules.

Check the built-in [supported tags](supported-tags.md) in current version.
