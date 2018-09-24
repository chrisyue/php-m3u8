<?php

/*
 * This file is part of the PhpM3u8 package.
 *
 * (c) Chrisyue <https://chrisyue.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Chrisyue\PhpM3u8\Data\Value\Attribute;

class Resolution
{
    private $width;

    private $height;

    public function __construct(int $width, int $height)
    {
        $this->width = $width;
        $this->height = $height;
    }

    public static function fromString(string $string)
    {
        [$width, $height] = explode('x', $string);

        return new self($width, $height);
    }

    public function getWidth()
    {
        return $this->width;
    }

    public function getHeight()
    {
        return $this->height;
    }

    public function __toString()
    {
        return sprintf('%dx%d', $this->width, $this->height);
    }
}
