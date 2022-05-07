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

namespace Chrisyue\PhpM3u8\Data\Value;

class Byterange
{
    private $length;

    private $offset;

    public function __construct($length, $offset = null)
    {
        $this->length = (int) $length;
        if ($this->length < 1) {
            throw new \InvalidArgumentException('$length should be an integer greater than 0');
        }

        if (null === $offset) {
            return;
        }

        $this->offset = (int) $offset;
        if ($this->offset < 0) {
            throw new \InvalidArgumentException('$offset should be a natural number');
        }
    }

    public static function fromString($string)
    {
        [$length, $offset] = array_pad(explode('@', $string), 2, null);

        return new self($length, $offset);
    }

    public function getLength()
    {
        return $this->length;
    }

    public function getOffset()
    {
        return $this->offset;
    }

    public function __toString()
    {
        if (null === $this->offset) {
            return (string) $this->length;
        }

        return sprintf('%d@%d', $this->length, $this->offset);
    }
}
