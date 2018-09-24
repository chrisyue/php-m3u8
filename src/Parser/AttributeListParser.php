<?php

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

class AttributeListParser
{
    private $valueParsers;

    public function __construct(Config $valueParsers)
    {
        $this->valueParsers = $valueParsers;
    }

    public function parse($value, array $types)
    {
        if (!is_string($value)) {
            throw new \InvalidArgumentException(sprintf('$value can only be string, got %s', var_export($value)));
        }

        preg_match_all('/(?<=^|,)[A-Z0-9-]+=("?).+?\1(?=,|$)/', $value, $matches);

        $result = new \ArrayObject();
        foreach ($matches[0] as $attr) {
            list($name, $value) = explode('=', $attr);
            $result[$name] = $value;

            if (!isset($types[$name])) {
                continue;
            }

            $type = $types[$name];
            $parse = $this->valueParsers->get($type);
            if (is_callable($parse)) {
                $result[$name] = $parse($value);
            }
        }

        return $result;
    }
}
