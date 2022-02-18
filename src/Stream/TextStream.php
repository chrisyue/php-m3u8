<?php

declare(strict_types=1);

/*
 * This file is part of the PhpM3u8 package.
 *
 * (c) Chrisyue <https://chrisyue.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Chrisyue\PhpM3u8\Stream;

class TextStream extends \ArrayIterator implements StreamInterface
{
    public function __construct($text = null)
    {
        $lines = [];
        if (null !== $text) {
            $lines = explode("\n", trim($text));
        }

        parent::__construct($lines);
    }

    public function add($line): void
    {
        $this->append($line);
    }

    public function __toString()
    {
        return implode("\n", $this->getArrayCopy())."\n";
    }
}
