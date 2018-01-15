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

trait AttributesValueTagTrait
{
    use SingleValueTagTrait;

    private static function extractAttributes($line)
    {
        $attrsText = self::extractValue($line);

        preg_match_all('/(?<=^|,)[A-Z0-9-]+=("?).+?\1(?=,|$)/', $attrsText, $matches);
        $attributes = [];
        foreach ($matches[0] as $attr) {
            list($key, $value) = explode('=', $attr);
            $attributes[$key] = trim($value);
        }

        return $attributes;
    }
}
