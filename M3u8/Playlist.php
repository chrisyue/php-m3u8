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

class Playlist implements \Iterator, \ArrayAccess
{
    private $mediaSegments = array();
    private $age;
    private $position = 0;

    public function __construct(array $mediaSegments = array(), $age = null)
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

    public function offsetSet($offset, $value)
    {
        if (!$value instanceof MediaSegment) {
            throw new \InvalidArgumentException('$value should be type of Chrisyue\PhpM3u8\M3u8\MediaSegment\MediaSegment');
        }

        if (is_null($offset)) {
            $this->add($value);

            return;
        }

        $this->mediaSegments[$offset] = $value;
    }

    public function offsetGet($offset)
    {
        return $this->mediaSegments[$offset];
    }

    public function offsetExists($offset)
    {
        return isset($this->mediaSegments[$offset]);
    }

    public function offsetUnset($offset)
    {
        unset($this->mediaSegments[$offset]);
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
