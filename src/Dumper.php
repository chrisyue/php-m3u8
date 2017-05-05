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
use Chrisyue\PhpM3u8\M3u8\MediaSegment;

class Dumper
{
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

        foreach ($m3u8->getPlaylist() as $mediaSegment) {
            if ($mediaSegment->isDiscontinuity()) {
                $lines[] = '#EXT-X-DISCONTINUITY';
            }

            $lines[] = self::createExtinfLine($m3u8->getVersion(), $mediaSegment);

            $byteRangeline = self::createByteRangeLine($mediaSegment);
            if (!empty($byteRangeline)) {
                $lines[] = $byteRangeline;
            }

            $lines[] = $mediaSegment->getUri();
        }

        if (!$m3u8->isEndless()) {
            $lines[] = '#EXT-X-ENDLIST';
        }

        return implode(PHP_EOL, $lines);
    }

    private static function createExtinfLine($m3u8Version, MediaSegment $mediaSegment)
    {
        if ($m3u8Version < 3) {
            return sprintf('#EXTINF:%d,%s', round($mediaSegment->getDuration()), $mediaSegment->getTitle());
        }

        return sprintf('#EXTINF:%.3f,%s', $mediaSegment->getDuration(), $mediaSegment->getTitle());
    }

    private static function createByteRangeLine(MediaSegment $mediaSegment)
    {
        $byteRange = $mediaSegment->getByteRange();
        if (empty($byteRange[0])) {
            return;
        }

        $line = sprintf('#EXT-X-BYTERANGE:%d', $byteRange[0]);
        if (empty($byteRange[1])) {
            return $line;
        }

        return sprintf('%s@%d', $line, $byteRange[1]);
    }
}
