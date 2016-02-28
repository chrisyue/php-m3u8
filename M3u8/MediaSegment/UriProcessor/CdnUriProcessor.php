<?php

namespace Chrisyue\PhpM3u8\M3u8\MediaSegment\UriProcessor;

use Chrisyue\PhpM3u8\M3u8\MediaSegment\MediaSegmentInterface;

class CdnUriProcessor implements UriProcessorInterface
{
    private $host;
    private $fullPathDir;

    public function __construct($host)
    {
        $this->host = $host;
    }

    public function process(MediaSegmentInterface $mediaSegment)
    {
        return preg_replace('/^(https?:\/\/[^\/]+)?/', $this->host, $mediaSegment->getUri());
    }
}
