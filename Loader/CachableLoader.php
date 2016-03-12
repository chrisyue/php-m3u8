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

class CachableLoader extends AbstractCachableLoader
{
    protected function loadContent($uri)
    {
        $content = file_get_contents($uri, null, stream_context_create(array(
            'http' => array(
                'timeout' => 10,
            ),
        )));

        if (false === $content) {
            throw new \Exception(sprintf('The m3u8 uri %s cannot be loaded', $uri));
        }

        return $content;
    }
}
