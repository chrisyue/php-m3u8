<?php

namespace Chrisyue\PhpM3u8\M3u8\MediaSegment\UriProcessor;

use Chrisyue\PhpM3u8\M3u8\MediaSegment\MediaSegmentInterface;

interface UriProcessorInterface
{
    public function process(MediaSegmentInterface $mediaSegment);
}
