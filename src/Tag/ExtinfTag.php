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

class ExtinfTag extends AbstractTag
{
    private $duration;

    private $title;

    private $m3u8Version;

    const TAG_IDENTIFIER = '#EXTINF';

    public function __construct($m3u8Version = 3)
    {
        $this->m3u8Version = $m3u8Version;
    }

    public function setDuration($duration)
    {
        $this->duration = $duration;

        return $this;
    }

    public function getDuration()
    {
        return $this->duration;
    }

    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function dump()
    {
        if (null === $this->duration) {
            return;
        }

        if (3 > $this->m3u8Version) {
            return sprintf('%s:%d,%s', self::TAG_IDENTIFIER, round($this->duration), $this->title);
        }

        return sprintf('%s:%.3f,%s', self::TAG_IDENTIFIER, round($this->duration, 3), $this->title);
    }

    protected function read($line)
    {
        list($this->duration, $this->title) = sscanf($line, self::TAG_IDENTIFIER.':%f,%[^$]');
    }
}
