PHP M3u8
========

An M3u8 parser / dumper framework.

**Warning: you are visiting the very experimental branch, this branch is for the contributors only!**

To get the ready-to-use code, please visit [master](../../../tree/master) branch.

Why would I like to make a new version?
---------------------------------------

I'd like to separate the parse/dump ability from the model classes(to meet the Single Responsibility Principle), 
and also I'd like the parser/dumper could read some configuration from the config files know how to parse/dump a 
specific tag. I think it could be cool because the configurations could also be treated as a M3u8 documentation.

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
$result = $parser->parse(new Chrisyue\PhpM3u8\Stream\TextStream($m3u8Content));

var_export($result);

// dump
$text = new TextStream();
$dumper = new DumperFacade();
$dumper->dump($result, $text);

echo $text;
```

#### Supported Tags

According to [RFC8216](https://tools.ietf.org/html/rfc8216)

* Basic Tags
    - [x] EXTM3U
    - [x] EXT-X-VERSION
* Media Segment Tags
    - [x] EXTINF
    - [x] EXT-X-BYTERANGE
    - [x] EXT-X-DISCONTINUITY
    - [ ] EXT-X-KEY
    - [x] EXT-X-PROGRAM-DATE-TIME
    - [ ] EXT-X-MAP
    - [x] EXT-X-DATERANGE
* Media Playlist Tags
    - [x] EXT-X-TARGETDURATION
    - [x] EXT-X-MEDIA-SEQUENCE
    - [x] EXT-X-DISCONTINUITY-SEQUENCE
    - [x] EXT-X-ENDLIST
    - [x] EXT-X-PLAYLIST-TYPE
    - [x] EXT-X-I-FRAMES-ONLY
* Master Playlist Tags
    - [x] EXT-X-MEDIA
    - [x] EXT-X-STREAM-INF
    - [x] EXT-X-I-FRAME-STREAM-INF
    - [x] EXT-X-SESSION-DATA
    - [ ] EXT-X-SESSION-KEY
* Media or Master Playlist Tags
    - [x] EXT-X-INDEPENDENT-SEGMENTS
    - [x] EXT-X-START
