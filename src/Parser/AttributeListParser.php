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

namespace Chrisyue\PhpM3u8\Parser;

use Chrisyue\PhpM3u8\Config;
use Chrisyue\PhpM3u8\Data\Transformer\AttributeStringToArray;

class AttributeListParser
{
    private $valueParsers;

    private $attributeStringToArray;

    public function __construct(Config $valueParsers, AttributeStringToArray $attributeStringToArray)
    {
        $this->valueParsers = $valueParsers;
        $this->attributeStringToArray = $attributeStringToArray;
    }

    public function parse($string, array $types)
    {
        $attributeParse = $this->attributeStringToArray;
        $attributes = $attributeParse($string);

        $result = new \ArrayObject();
        foreach ($attributes as $key => $value) {
            if (!isset($types[$key])) {
                continue;
            }

            $type = $types[$key];
            $parse = $this->valueParsers->get($type);
            if (\is_callable($parse)) {
                $result[$key] = $parse($value);
            }
        }

        return $result;
    }
}
