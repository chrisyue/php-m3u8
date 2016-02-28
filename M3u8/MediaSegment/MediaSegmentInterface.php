<?php

namespace Chrisyue\PhpM3u8\M3u8\MediaSegment;

interface MediaSegmentInterface
{
    public function getUri();

    public function getDuration();

    public function getSequence();

    public function isDiscontinuity();
}
