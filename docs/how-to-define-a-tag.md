How to Define a Tag
===================

PHP-M3U8 will try to parse the M3U8 document as
[RFC8216](https://tools.ietf.org/html/rfc8216). However you may want to parse
some tags or attributes which are already removed from RFC8216. For example,
`PROGRAM-ID` has been removed since HLS version 6.

It's easy to let PHP-M3U8 work with tags and attributes defined other than
RFC8216. All you need to know is how to "define" a M3U8 tag.

As you may know, a parser/dumper needs tag definition to work. the built-in
definition file is located in `resources/definitions/tags.php`. If you've
checked this file, you may find this file actually a M3U8 documentation written
in PHP, take the `EXT-X-STREAM-INF` as an example:

```php
// resources/definitions/tags.php
$definitions = [
    'EXT-X-STREAM-INF' => [
        'category' => 'master-playlist',
        'multiple' => true,
        'type' => [
            'BANDWIDTH' => 'decimal-integer',
            'AVERAGE-BANDWIDTH' => 'decimal-integer',
            'CODECS' => 'quoted-string',
            'RESOLUTION' => 'decimal-resolution',
            'FRAME-RATE' => 'decimal-floating-point',
            'HDCP-LEVEL' => 'enumerated-string',
            'AUDIO' => 'quoted-string',
            'VIDEO' => 'quoted-string',
            'SUBTITLES' => 'quoted-string',
            'CLOSED-CAPTIONS' => 'quoted-string',
        ],
        'uriAware' => true,
        'position' => -1800,
    ],
    // ...
];

// ...

return $definitions;
```

An tag definition has these properties:

- category: a tag is belong to one of 'master-playlist', 'media-playlist',
  'media-segment', 'playlist'. 'playlist' means this tag can both appear in a
  master playlist or a media playlist.
- multiple: a tag can appear many times in its category. for example, the
  `EXT-X-STREAM-INF` can appear many times in a master playlist. this property
  can be ommitted and the default value is `false`.
- type: a tag value could be different type of values, the `EXT-X-VERSION` has
  an int value, and the `EXT-X-STREAM-INF' has an attribute-list value.
  Although `EXT-X-ENDLIST` has no value, it implies the value is a boolean.
  Check the tags definition files to know all the *built-in* types, yes, I've
  implied that you could define your own type too, check
  [how to make a parsing/dumping rule](how-to-make-a-parsing-dumping-rule.md)
  for more.
- uriAware: If a tag must be followed by a URI, this tag is uriAware. As far as
  I know the only "uriAware" tag is `EXT-X-STREAM-INF`.
- position: this one is actually for dumping purpose only. The dumper will sort
  the tags before dumping. For convenience, the tags which position is less
  than 0 will be dumped before media segment tags.

So, to add the support of the `PROGRAM-ID` of `EXT-X-STREAM-INF`, all you have
to do is to add the definition of "what PROGRAM-ID" is:

```php
$definitions = require 'path/to/definitions/tags.php';
$definitions['EXT-X-STREAM-INF']['type']['PROGRAM-ID'] = 'decimal-integer';

$tagDefinitions = new Chrisyue\PhpM3u8\Definition\TagDefinitions($definitions);
$parser = new Parser(
    $tagDefinitions,
    new Chrisyue\PhpM3u8\Config(require 'path/to/tagValueParsers.php'),
    new Chrisyue\PhpM3u8\Parser\DataBuilder()
);

$parser->parse(new Chrisyue\PhpM3u8\Line\Lines(new Chrisyue\PhpM3u8\Stream\TextStream($m3u8)));
```

Besides tag type, the attribute types are also customizable, for more
information please check
[how to make a parsing/dumping rule](how-to-make-a-parsing-dumping-rule.md)
