<?php

namespace Chrisyue\PhpM3u8\M3u8;

use Chrisyue\PhpM3u8\M3u8\MediaSegment\MediaSegment;

class Playlist implements \Iterator
{
    private $mediaSegments = [];
    private $age;
    private $position = 0;

    public function __construct(array $mediaSegments = [], $age = null)
    {
        $this->mediaSegments = $mediaSegments;
        $this->age = $age;
    }

    public function rewind()
    {
        $this->position = 0;
    }

    public function current()
    {
        return $this->mediaSegments[$this->position];
    }

    public function key()
    {
        return $this->position;
    }

    public function next()
    {
        ++$this->position;
    }

    public function valid()
    {
        return isset($this->mediaSegments[$this->position]);
    }

    public function add(MediaSegment $mediaSegment)
    {
        $this->mediaSegments[] = $mediaSegment;

        return $this;
    }

    public function getFirst()
    {
        $first = reset($this->mediaSegments);

        if (false !== $first) {
            return $first;
        }
    }

    public function getDuration()
    {
        $duration = 0;
        foreach ($this->mediaSegments as $segment) {
            $duration += $segment->getDuration();
        }

        return $duration;
    }

    public function count()
    {
        return count($this->mediaSegments);
    }

    public function setAge($age)
    {
        $this->age = $age;

        return $this;
    }

    public function getAge()
    {
        return $this->age;
    }
}
