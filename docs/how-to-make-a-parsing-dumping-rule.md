How to Make a Parsing/Dumping Rule
==================================

If you've already checked the file
[tagValueParsers.php](../resources/tagValueParsers.php), you could find that
this file contains very simple "type => callable" rules which define how to
parse a certain tag type:

```php
// resources/definitions/tagValueParsers.php
return [
    'int' => 'intval',
    // ...
];
```

As you may have figured it out already, you can easily add a new parser/dumper
for your own tag/attribute type. Take the `inf` type as an example:

```php
// resources/definitions/tagValueParsers.php
return [
    'inf' => [Chrisyue\PhpM3u8\Data\Value\Tag\Inf::class, 'fromString'],
    // ...
];

// resources/definitions/tags.php
$definitions = [
    'EXTINF' => [
        'type' => 'inf',
    ],
    // ...
];
```

NOTE: the `attribute-list` type is defined as an array in `tags.php`, this
array is as the 2nd parameter to the `attribute-list` parsing/dumping callable.

You could also check the [tagValueDumpers.php](../resources/tagValueDumpers.php)
or [attributeValueParsers.php](../resources/attributeValueParsers.php),
[attributeValueDumpers.php](../resources/attributeValueDumpers.php) to get the
idea how to define a tag/attribute parser/dumper.

As you could see, PHP M3U8 is not only a parser/dumper, you can consider it as
an "M3U8 parser/dumper framework". If you try to parse/dump an very old version
of M3U8 document, which may differ a lot from RFC8216, you could even make your
own tag definitions/type parsing/dumping rules other than the built-in ones.

Check the built-in [supported tags](supported-tags.md) in current
version.
