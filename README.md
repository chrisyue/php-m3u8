PHP M3u8
========

M3u8 file parser / dumper

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/f04296f1-1621-4af0-8346-fd3379f34a5a/big.png)](https://insight.sensiolabs.com/projects/f04296f1-1621-4af0-8346-fd3379f34a5a)

[![Latest Stable Version](https://poser.pugx.org/chrisyue/php-m3u8/v/stable)](https://packagist.org/packages/chrisyue/php-m3u8)
[![License](https://poser.pugx.org/chrisyue/php-m3u8/license)](https://packagist.org/packages/chrisyue/php-m3u8)
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

### Parser

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

$parser = new \Chrisyue\PhpM3u8\Parser();
$m3u8 = $parser->parse($m3u8Content);
```

or with loader

```php
class MyLoader implements LoaderInterface
{
    public function load($uri)
    {
        return file_get_contents('http://example.com/path/to/m3u8');
    }
}

$parser->setLoader(new MyLoader());
$m3u8 = $parser->parseFromUri($uri);
```

now you can get information from $m3u8

```php
$m3u8->getVersion();
$m3u8->getTargetDuration();
$m3u8->getDuration();

// get certain media segment inforatiom
$mediaSegment = $m3u8->getPlaylist()->offsetGet(0);
// or
$mediaSegment = $m3u8->getPlaylist()[0];

// get information from $mediaSegment
$mediaSegment->getDuration();
$mediaSegment->getSequence();
```

*for more inforamation please check the `M3u8`, `PlayList`, `MediaSegment` API under `\Chrisyue\M3u8`*.

Fortunately you don't really need to write a `MyLoader` class because there is already a `CachableLoader` along with this library

supposing you are using psr6 compatible cache utils like Symfony cache component:

```php
$cachePool = new \Symfony\Component\Cache\Adapter\ApcuAdapter();
$loader = new \Chrisyue\PhpM3u8\CachableLoader($cachePool);

$parser->setLoader($loader);
$m3u8 = $parser->parseFromUri($uri);
```

### Dumper

now you can try to dump the `$m3u8` back into M3U8 text

```php
$dumper = new \Chrisyue\PhpM3u8\Dumper();

echo $dumper->dump($m3u8);
```
