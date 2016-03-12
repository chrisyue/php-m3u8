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

function file_get_contents($uri)
{
    return 'hello world';
}

namespace Tests\Loader;

use Chrisyue\PhpM3u8\Loader\CachableLoader;

class CachableLoaderTest extends \PHPUnit_Framework_TestCase
{
    public function testLoadWithoutCache()
    {
        $uri = 'http://example.com';
        $expiresAfter = 1800;
        $content = \Chrisyue\PhpM3u8\Loader\file_get_contents($uri);
        $cachePool = $this->prophesizeCachePool($uri, false, $content, $expiresAfter);

        $loader = new CachableLoader($cachePool->reveal(), array('ttl' => $expiresAfter));
        $this->assertEquals($loader->load($uri), $content);
    }

    public function testLoadWithCache()
    {
        $uri = 'http://site.com';
        $expiresAfter = 1800;
        $content = \Chrisyue\PhpM3u8\Loader\file_get_contents($uri);
        $cachePool = $this->prophesizeCachePool($uri, true, $content, $expiresAfter);

        $loader = new CachableLoader($cachePool->reveal(), array('ttl' => $expiresAfter));
        $this->assertEquals($loader->load($uri), $content);
    }

    public function testLoadCacheWithDefaultTtlOption()
    {
        $uri = 'http://another.site.com';
        $content = \Chrisyue\PhpM3u8\Loader\file_get_contents($uri);
        $cachePool = $this->prophesizeCachePool($uri, false, $content, 3600);

        $loader = new CachableLoader($cachePool->reveal());
        $this->assertEquals($loader->load($uri), $content);
    }

    private function prophesizeCachePool($uri, $isHit, $content, $expiresAfter)
    {
        $cachePool = $this->prophesize('Psr\Cache\CacheItemPoolInterface');
        $cacheItem = $this->prophesize('Psr\Cache\CacheItemInterface');

        $key = md5($uri);
        $cachePool->getItem($key)->shouldBeCalledTimes(1)->willReturn($cacheItem->reveal());
        $cacheItem->isHit()->shouldBeCalledTimes(1)->willReturn($isHit);

        if ($isHit) {
            $cacheItem->get()->shouldBeCalledTimes(1)->willReturn($content);

            return $cachePool;
        }

        $cacheItem->set($content)->shouldBeCalledTimes(1);
        $cacheItem->expiresAfter($expiresAfter)->shouldBeCalledTimes(1);

        $cachePool->save($cacheItem->reveal())->shouldBeCalledTimes(1);

        return $cachePool;
    }
}
