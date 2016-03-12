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

use Chrisyue\PhpM3u8\M3u8\M3u8;
use Chrisyue\PhpM3u8\M3u8\MediaSegment\UriProcessor\UriProcessorInterface;

class Dumper
{
    private $mediaSegmentUriProcessor;

    public function __construct(UriProcessorInterface $processor)
    {
        $this->mediaSegmentUriProcessor = $processor;
    }

    public function dump(M3u8 $m3u8)
    {
        $lines = array(
            '#EXTM3U',
            sprintf('#EXT-X-VERSION:%s', $m3u8->getVersion()),
            sprintf('#EXT-X-TARGETDURATION:%d', $m3u8->getTargetDuration()),
        );

        if ($m3u8->getMediaSequence()) {
            $lines[] = sprintf('#EXT-X-MEDIA-SEQUENCE:%s', $m3u8->getMediaSequence());
        }

        if ($m3u8->getDiscontinuitySequence()) {
            $lines[] = sprintf('#EXT-X-DISCONTINUITY-SEQUENCE:%s', $m3u8->getDiscontinuitySequence());
        }

        $lines[] = ''; // separator between m3u8 info and playlist

        foreach ($m3u8->getPlaylist() as $mediaSegment) {
            if ($mediaSegment->isDiscontinuity()) {
                $lines[] = '#EXT-X-DISCONTINUITY';
            }

            $lines[] = $m3u8->getVersion() < 3 ? sprintf('#EXTINF:%d,', round($mediaSegment->getDuration())) : sprintf('#EXTINF:%.3f,', $mediaSegment->getDuration());
            $lines[] = $this->mediaSegmentUriProcessor->process($mediaSegment);
        }

        return implode(PHP_EOL, $lines);
    }
}
