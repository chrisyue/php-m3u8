<?php

declare(strict_types=1);

/*
 * This file is part of the PhpM3u8 package.
 *
 * (c) Chrisyue <https://chrisyue.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Chrisyue\PhpM3u8\Facade\DumperFacade;
use Chrisyue\PhpM3u8\Facade\ParserFacade;
use Chrisyue\PhpM3u8\Stream\TextStream;

require 'vendor/autoload.php';

$parser = new ParserFacade();
$dumper = new DumperFacade();

echo '*** Parsing media playlist... ***', \PHP_EOL;

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
echo 'The 1st segment\'s duration is ', $firstSegment['EXTINF']->getDuration(), \PHP_EOL;
echo 'and the key URI is ', $firstSegment['EXT-X-KEY'][0]['URI'], \PHP_EOL;
echo 'The version of this M3U8 is ', $mediaPlaylist['EXT-X-VERSION'], \PHP_EOL;

// check what the whole result looks like
var_export($mediaPlaylist);
echo \PHP_EOL;

// change some values before dumping
$firstSegment['uri'] = 'http://chrisyue.com/a.ts';
$firstSegment['EXTINF']->setTitle('hi');

echo '*** Dumping media playlist... ***', \PHP_EOL;
$text = new TextStream();
$dumper->dump($mediaPlaylist, $text);

echo $text, \PHP_EOL;

// MEDIA PLAYLIST DEMO END

// MASTER PLAYLIST DEMO START

echo '*** Parsing master playlist... ***', \PHP_EOL;
$m3u8Content = <<<'M3U8'
    #EXTM3U
    #EXT-X-STREAM-INF:BANDWIDTH=1280000,AVERAGE-BANDWIDTH=1000000
    http://example.com/low.m3u8
    #EXT-X-STREAM-INF:BANDWIDTH=2560000,AVERAGE-BANDWIDTH=2000000
    http://example.com/mid.m3u8
    #EXT-X-STREAM-INF:BANDWIDTH=7680000,AVERAGE-BANDWIDTH=6000000
    http://example.com/hi.m3u8
    #EXT-X-STREAM-INF:BANDWIDTH=65000,CODECS="mp4a.40.5",CLOSED-CAPTIONS=NONE
    http://example.com/audio-only.m3u8
    M3U8;

$masterPlaylist = $parser->parse(new TextStream($m3u8Content));

var_export($masterPlaylist);
echo \PHP_EOL;

echo '*** Dumping media playlist... ***', \PHP_EOL;
$text = new TextStream();
$dumper->dump($masterPlaylist, $text);

echo $text, \PHP_EOL;
