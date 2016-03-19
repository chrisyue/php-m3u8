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
    private $loader;

    protected function loadContent($uri)
    {
        if (null === $this->loader) {
            $this->loader = new Loader();
        }

        return $this->loader->load($uri);
    }
}
