<?php

/*
 * This file is part of the PhpM3u8 package.
 *
 * (c) Chrisyue <http://chrisyue.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Chrisyue\PhpM3u8\Loader;

use Psr\Cache\CacheItemPoolInterface;

abstract class AbstractCachableLoader implements LoaderInterface
{
    private $cachePool;
    private $options;

    public function __construct(CacheItemPoolInterface $cachePool, array $options = array())
    {
        $this->cachePool = $cachePool;
        $this->options = $options + array('ttl' => 3600);
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
