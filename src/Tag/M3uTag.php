<?php

/*
 * This file is part of the PhpM3u8 package.
 *
 * (c) Chrisyue <http://chrisyue.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Chrisyue\PhpM3u8\Tag;

use Chrisyue\PhpM3u8\DumpableInterface;

class M3uTag implements DumpableInterface
{
    const TAG_IDENTIFIER = '#EXTM3U';

    public function readLines(array &$lines)
    {
        $firstLine = $lines[0];
        if (self::TAG_IDENTIFIER !== $firstLine) {
            throw new \InvalidArgumentException('The first line of a M3u8 must be "#EXTM3U"');
        }

        unset($lines[0]);
    }

    public function dump()
    {
        return self::TAG_IDENTIFIER;
    }
}
