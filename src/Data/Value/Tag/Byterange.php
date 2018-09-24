<?php

/*
 * This file is part of the PhpM3u8 package.
 *
 * (c) Chrisyue <https://chrisyue.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Chrisyue\PhpM3u8\Data\Value\Tag;

class Byterange
{
    private $length;

    private $offset;

    public function __construct(int $length, string $offset = null)
    {
        $this->length = $length;
        $this->offset = $offset;
    }

    public static function fromString(string $string)
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
