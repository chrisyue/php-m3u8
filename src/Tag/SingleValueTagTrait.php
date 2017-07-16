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

trait SingleValueTagTrait
{
    private static function extractValue($line)
    {
        return substr($line, strlen(self::TAG_IDENTIFIER) + 1);
    }
}
