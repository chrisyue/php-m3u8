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

class MediaSegment
{
    protected $uri;
    protected $duration;
    protected $sequence;
    protected $isDiscontinuity;
    protected $title;
    protected $byteRange;

    public function __construct(
        $uri,
        $duration,
        $sequence,
        $isDiscontinuity = false,
        $title = null,
        \SplFixedArray $byteRange = null
    ) {
        $this->uri = $uri;
        $this->duration = $duration;
        $this->sequence = $sequence;
        $this->isDiscontinuity = $isDiscontinuity;
        $this->title = $title;
        $this->byteRange = $byteRange;
    }

    public function getUri()
    {
        return $this->uri;
    }

    public function getDuration()
    {
        return $this->duration;
    }

    public function getSequence()
    {
        return $this->sequence;
    }

    public function isDiscontinuity()
    {
        return $this->isDiscontinuity;
    }

    public function getTitle()
    {
        return $this->title;
    }

    /**
     * length: $byteRange[0],
     * offset: $byteRange[1].
     *
     * @return \SplFixedArray|null
     */
    public function getByteRange()
    {
        return $this->byteRange;
    }
}
