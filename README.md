PHP M3u8
========

v1.2.0

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

### parser

```php
$parser = new \Chrisyue\PhpM3u8\Parser();
$m3u8 = $parser->parse($m3u8Content);

// or with loader
class MyLoader implements LoaderInterface
{
    public function load($uri)
    {
        // return $uri content by `file_get_contents` or `guzzle` etc.
    }
}

$parser->setLoader(new MyLoader());
$parser->parseFromUri($uri);
```

Fortunately you don't really need to write a `MyLoader` class because there is already a `CachableLoader` along with this library

supposing you are using psr6 compatible cache utils like Symfony cache component:

```php
$cachePool = new \Symfony\Component\Cache\Adapter\ApcuAdapter();
$loader = new \Chrisyue\PhpM3u8\CachableLoader($cachePool);

$parser->setLoader($loader);
$m3u8 = $parser->parseFromUri($uri);
```

### dumper

```php
$dumper = new \Chrisyue\PhpM3u8\Dumper();
echo $dumper->dump($m3u8);
```
