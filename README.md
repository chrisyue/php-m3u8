PHP M3u8
========

M3u8 file parser / dumper

Installation
------------

```
$ composer require 'chrisyue/php-m3u8:dev-master'
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
        // return $uri content by `file_get_contents` or `guzzle`
    }
}

$parser->setLoader(new MyLoader());
$parser->parseFromUri($uri);

// fortunately you don't really need to write a `MyLoader` class because there is already a `CachableLoader` along with this library
// supposing you are using psr6 compatible cache utils like Symfony cache component
$cachePool = new \Symfony\Component\Cache\Adapter\ApcuAdapter();
$loader = new \Chrisyue\PhpM3u8\CachableLoader($cachePool);
$parser->setLoader($loader);
$m3u8 = $parser->parseFromUri($uri);
```

### dumper

```php
class MyMediaSegmentUriProcessor implements MediaSegmentUriProcessorInterface
{
    public function process(\Chrisyue\PhpM3u8\MediaSegment $mediaSegment)
    {
        return $mediaSegment->getUri();
        // or you'd like to make the uri absolute path
        // return sprintf('http://example.com/%s', $mediaSegment->getUri());
    }
}

$dumper = new \Chrisyue\PhpM3u8\Dumper(new MyMediaSegmentUriProcessor());
echo $dumper->dump($m3u8);
```
