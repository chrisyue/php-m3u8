PHP M3u8
========

M3u8 file parser / dumper

v2.1.0

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/f04296f1-1621-4af0-8346-fd3379f34a5a/big.png)](https://insight.sensiolabs.com/projects/f04296f1-1621-4af0-8346-fd3379f34a5a)

[![Latest Stable Version](https://poser.pugx.org/chrisyue/php-m3u8/v/stable)](https://packagist.org/packages/chrisyue/php-m3u8)
[![License](https://poser.pugx.org/chrisyue/php-m3u8/license)](https://packagist.org/packages/chrisyue/php-m3u8)
[![Total Downloads](https://poser.pugx.org/chrisyue/php-m3u8/downloads)](https://packagist.org/packages/chrisyue/php-m3u8)
[![Build Status](https://travis-ci.org/chrisyue/php-m3u8.svg?branch=develop)](https://travis-ci.org/chrisyue/php-m3u8)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/chrisyue/php-m3u8/badges/quality-score.png?b=develop)](https://scrutinizer-ci.com/g/chrisyue/php-m3u8/?branch=develop)
[![Code Coverage](https://scrutinizer-ci.com/g/chrisyue/php-m3u8/badges/coverage.png?b=develop)](https://scrutinizer-ci.com/g/chrisyue/php-m3u8/?branch=develop)
[![StyleCI](https://styleci.io/repos/52257600/shield)](https://styleci.io/repos/52257600)

Installation
------------

```
$ composer require 'chrisyue/php-m3u8'
```

Usage
-----

### Parse

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

$m3u8 = new M3u8();
$m3u8->read($m3u8Content);
```

now you can get information from $m3u8

```php
$m3u8->getVersion();
$m3u8->getTargetDuration();
$m3u8->getDuration();

// get certain media segment inforatiom
$segment = $m3u8->getSegments()->offsetGet(0);
// or
$segment = $m3u8->getSegments()[0];

// get information from $segment
$segment->getDuration();
$segment->getMediaSequence();
```

*for more inforamation please check the `M3u8`, `Segments`, `Segment` API under `\Chrisyue\M3u8`*.

#### Supported Tags

According to [HLS draft version 23](https://tools.ietf.org/html/draft-pantos-http-live-streaming-23)

* Basic Tags
    - [x] EXTM3U
    - [x] EXT-X-VERSION
* Media Segment Tags
    - [x] EXTINF
    - [x] EXT-X-BYTERANGE
    - [x] EXT-X-DISCONTINUITY
    - [x] EXT-X-KEY
    - [x] EXT-X-PROGRAM-DATE-TIME
    - [ ] EXT-X-MAP
    - [ ] EXT-X-DATERANGE
* Media Playlist Tags
    - [x] EXT-X-TARGETDURATION
    - [x] EXT-X-MEDIA-SEQUENCE
    - [x] EXT-X-DISCONTINUITY-SEQUENCE
    - [x] EXT-X-ENDLIST
    - [ ] EXT-X-PLAYLIST-TYPE
    - [ ] EXT-X-I-FRAMES-ONLY
* Master Playlist Tags
    - [ ] EXT-X-MEDIA
    - [ ] EXT-X-STREAM-INF
    - [ ] EXT-X-I-FRAME-STREAM-INF
    - [ ] EXT-X-SESSION-DATA
    - [ ] EXT-X-SESSION-KEY
* Media or Master Playlist Tags
    - [ ] EXT-X-INDEPENDENT-SEGMENTS
    - [ ] EXT-X-START

### Dump

```php
$m3u8 = new M3u8();
$m3u8->getVersionTag()->setVersion(3);
$m3u8->getMediaSequenceTag()->setMediaSequence(33);
$m3u8->getDiscontinuitySequenceTag()->setDiscontinuitySequence(3);
$m3u8->getTargetDurationTag()->setTargetDuration(12);
$m3u8->getEndlistTag()->setEndless(true);

$segment = new Segment($version);
$segment->getExtinfTag()->setDuration(12)->setTitle('hello world');
$segment->getByteRangeTag()->setLength(10000)->setOffset(100);
$segment->getProgramDateTimeTag()->setProgramDateTime(new \DateTime('2:00 pm'));
$segment->getUri()->setUri('stream33.ts');
$m3u8->getSegments()->add($segment);

echo $m3u8->dump();
```

### To Contributors

Please follow the [gitflow](http://nvie.com/posts/a-successful-git-branching-model/) work flow
to add a new feature, or fix bugs.
