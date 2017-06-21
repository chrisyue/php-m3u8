<?php

/*
 * This file is part of the PhpM3u8 package.
 *
 * (c) Chrisyue <http://chrisyue.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Chrisyue\PhpM3u8;

class Uri implements DumpableInterface
{
    private $uri;

    public function readLines(array &$lines)
    {
        foreach ($lines as $key => $line) {
            if (0 !== strpos($line, '#')) {
                $this->uri = $line;

                unset($lines[$key]);

                return;
            }
        }
    }

    public function setUri($uri)
    {
        $this->uri = $uri;

        return $this;
    }

    public function __toString()
    {
        return $this->dump();
    }

    public function dump()
    {
        return $this->uri;
    }

    public function isEmpty()
    {
        return empty($this->uri);
    }
}
