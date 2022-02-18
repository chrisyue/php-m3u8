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

namespace Chrisyue\PhpM3u8\Line;

class Line
{
    public const TYPE_URI = 'uri';
    public const TYPE_TAG = 'tag';

    private $tag;

    private $value;

    public function __construct($tag = null, $value = null)
    {
        if (null === $tag && null === $value) {
            throw new \InvalidArgumentException('$tag and $value can not both be null');
        }

        $this->tag = $tag;
        $this->value = $value;
    }

    public static function fromString($line)
    {
        $line = trim($line);
        if (empty($line)) {
            return;
        }

        if ('#' !== $line[0]) {
            return new self(null, $line);
        }

        if ('#EXT' !== substr($line, 0, 4)) {
            return;
        }

        $line = ltrim($line, '#');
        if (empty($line)) {
            return;
        }

        [$tag, $value] = array_pad(explode(':', $line, 2), 2, true);

        return new self($tag, $value);
    }

    public function getTag()
    {
        return $this->tag;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function isType($type)
    {
        return $this->getType() === $type;
    }

    public function __toString()
    {
        if ($this->isType(self::TYPE_URI)) {
            return $this->value;
        }

        if (true === $this->value) {
            return sprintf('#%s', $this->tag);
        }

        if (false === $this->value) {
            return '';
        }

        return sprintf('#%s:%s', $this->tag, $this->value);
    }

    private function getType()
    {
        if (null !== $this->tag) {
            return self::TYPE_TAG;
        }

        return self::TYPE_URI;
    }
}
