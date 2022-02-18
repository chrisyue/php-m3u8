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

namespace Chrisyue\PhpM3u8\Data\Transformer;

class AttributeStringToArray
{
    public function __invoke($string)
    {
        if (!\is_string($string)) {
            throw new \InvalidArgumentException(sprintf('$string can only be string, got %s', \gettype($string)));
        }

        preg_match_all('/(?<=^|,)[A-Z0-9-]+=("?).+?\1(?=,|$)/', $string, $matches);

        $attrs = [];
        foreach ($matches[0] as $attr) {
            [$key, $value] = explode('=', $attr, 2);
            $attrs[$key] = $value;
        }

        return $attrs;
    }
}
