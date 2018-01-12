<?php

/*
 * This file is part of the PhpM3u8 package.
 *
 * (c) Chrisyue <http://chrisyue.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Chrisyue\PhpM3u8;

class Segments implements DumpableInterface, \Iterator, \ArrayAccess
{
    private $segments = [];

    private $m3u8;

    private $position = 0;

    public function __construct(M3u8 $m3u8)
    {
        $this->m3u8 = $m3u8;
    }

    public function rewind()
    {
        $this->position = 0;
    }

    public function current()
    {
        return $this->segments[$this->position];
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
        return isset($this->segments[$this->position]);
    }

    public function offsetSet($offset, $value)
    {
        if (!is_object($value) || !$value instanceof Segment) {
            throw new \InvalidArgumentException('Expected $value of class Chrisyue\PhpM3u8\Segment');
        }
        if (is_null($offset)) {
            $this->add($value);

            return;
        }
        $this->segments[$offset] = $value;
    }

    /**
     * @return Chrisyue\PhpM3u8\Segment
     */
    public function offsetGet($offset)
    {
        return $this->segments[$offset];
    }

    /**
     * @return bool
     */
    public function offsetExists($offset)
    {
        return isset($this->segments[$offset]);
    }

    public function offsetUnset($offset)
    {
        unset($this->segments[$offset]);
    }

    public function add(Segment $segment)
    {
        $this->segments[] = $segment;
    }

    /**
     * @return int|float
     */
    public function getDuration()
    {
        $duration = 0;
        foreach ($this->segments as $segment) {
            $duration += $segment->getDuration();
        }

        return $duration;
    }

    /**
     * @return Chrisyue\PhpM3u8\Segment
     */
    public function getFirst()
    {
        $first = reset($this->segments);
        if (false !== $first) {
            return $first;
        }
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->segments);
    }

    public function readLines(array &$lines)
    {
        $mediaSequence = $this->m3u8->getMediaSequence();
        $discontinuitySequence = $this->m3u8->getDiscontinuitySequence();
        while (true) {
            $segment = new Segment($this->m3u8->getVersion());
            $segment->readLines($lines);

            if ($segment->isEmpty()) {
                return;
            }

            $segment->setMediaSequence($mediaSequence++);

            $segment->setDiscontinuitySequence($discontinuitySequence);
            if ($segment->isDiscontinuity()) {
                $segment->setDiscontinuitySequence(++$discontinuitySequence);
            }
            $this->segments[] = $segment;
        }
    }

    public function dump()
    {
        $lines = array_map(function (Segment $segment) {
            return $segment->dump();
        }, $this->segments);

        return implode("\n", $lines);
    }
}
