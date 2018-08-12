<?php

/*
 * This file is part of the PhpM3u8 package.
 *
 * (c) Chrisyue <https://chrisyue.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Chrisyue\PhpM3u8\Stream;

class TextStream implements StreamInterface
{
    private $lines;

    public function __construct($text = '')
    {
        $this->lines = explode("\n", $text);
    }

    public function next()
    {
        next($this->lines);
    }

    public function valid()
    {
        return false !== current($this->lines);
    }

    public function current()
    {
        return current($this->lines);
    }

    public function key()
    {
        return key($this->lines);
    }

    public function rewind()
    {
        reset($this->lines);
    }

    public function add($line)
    {
        $this->lines[] = $line;
    }

    public function __toString()
    {
        return implode("\n", $this->lines)."\n";
    }
}
