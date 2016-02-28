<?php

namespace Chrisyue\PhpM3u8\M3u8\MediaSegment\UriProcessor;

use Chrisyue\PhpM3u8\M3u8\MediaSegment\MediaSegmentInterface;

class OriginUriProcessor implements UriProcessorInterface
{
    public function process(MediaSegmentInterface $mediaSegment)
    {
        return $mediaSegment->getUri();
    }
}
