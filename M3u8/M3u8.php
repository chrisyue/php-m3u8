<?php

/*
 * This file is part of the PhpM3u8 package.
 *
 * (c) Chrisyue <http://chrisyue.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Chrisyue\PhpM3u8\M3u8;

class M3u8
{
    private $playlist;
    private $version;
    private $targetDuration;
    private $discontinuitySequence;

    public function __construct(Playlist $playlist, $version, $targetDuration, $discontinuitySequence = null)
    {
        $this->playlist = $playlist;
        $this->version = $version;
        $this->targetDuration = $targetDuration;
        $this->discontinuitySequence = $discontinuitySequence;
    }

    public function getPlaylist()
    {
        return $this->playlist;
    }

    public function getVersion()
    {
        return $this->version;
    }

    public function getTargetDuration()
    {
        return $this->targetDuration;
    }

    public function getMediaSequence()
    {
        return $this->playlist->getFirst()->getSequence();
    }

    public function getDiscontinuitySequence()
    {
        return $this->discontinuitySequence;
    }

    public function getAge()
    {
        return $this->playlist->getAge();
    }

    public function getDuration()
    {
        return $this->playlist->getDuration();
    }
}
