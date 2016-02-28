<?php

namespace Chrisyue\PhpM3u8\Loader;

use Psr\Cache\CacheItemPoolInterface;

abstract class AbstractCachableLoader implements LoaderInterface
{
    private $cachePool;
    private $options;

    public function __construct(CacheItemPoolInterface $cachePool, array $options)
    {
        $this->cachePool = $cachePool;
        $this->options = $options;
    }

    public function load($uri)
    {
        $cacheItem = $this->cachePool->getItem(md5($uri));
        if ($cacheItem->isHit()) {
            return $cacheItem->get();
        }

        $content = $this->loadContent($uri);
        $cacheItem->set($content);
        $cacheItem->expiresAfter($this->options['ttl']);
        $this->cachePool->save($cacheItem);

        return $content;
    }

    abstract protected function loadContent($uri);
}
