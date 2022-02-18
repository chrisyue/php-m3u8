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

namespace Chrisyue\PhpM3u8\Data\Value\Tag;

class Inf
{
    private $duration;

    private $title;

    private $version;

    public function __construct($duration, $title = null, $version = 6)
    {
        $this->duration = +$duration;
        if ($this->duration < 0) {
            throw new \InvalidArgumentException('$duration should not be less than 0');
        }

        $this->version = (int) $version;
        if ($this->version < 2 || $this->version > 7) {
            throw new \InvalidArgumentException('$version should be an integer greater than 1 and less than 8');
        }

        if (null === $title) {
            return;
        }

        $this->title = (string) $title;
    }

    public static function fromString($string)
    {
        [$duration, $title] = explode(',', $string);

        return new self($duration, $title);
    }

    public function getDuration()
    {
        return $this->duration;
    }

    public function setTitle($title): void
    {
        $this->title = $title;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function __toString()
    {
        /*
         * @see https://tools.ietf.org/html/rfc8216#section-4.3.2.1
         */
        if ($this->version < 3) {
            return sprintf('%d,%s', round($this->duration), $this->title);
        }

        return sprintf('%.3f,%s', $this->duration, $this->title);
    }
}
