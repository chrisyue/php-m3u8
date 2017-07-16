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

abstract class AbstractTag implements DumpableInterface
{
    public function readLines(array &$lines)
    {
        if (empty($lines)) {
            return;
        }

        foreach ($lines as $key => $line) {
            if (0 === strpos($line, static::TAG_IDENTIFIER)) {
                $this->read($line);

                unset($lines[$key]);

                return;
            }

            if (0 !== strpos($line, '#')) {
                return;
            }
        }
    }

    abstract protected function read($line);
}
