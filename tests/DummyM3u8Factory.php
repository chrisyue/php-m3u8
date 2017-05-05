<?php

/*
 * This file is part of the PhpM3u8 package.
 *
 * (c) Chrisyue <http://chrisyue.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Chrisyue\PhpM3u8\Tests;

use Chrisyue\PhpM3u8\M3u8\M3u8;
use Chrisyue\PhpM3u8\M3u8\MediaSegment;
use Chrisyue\PhpM3u8\M3u8\Playlist;

class DummyM3u8Factory
{
    public static function createM3u8($version = 3)
    {
        $playlist = new Playlist(array(
            new MediaSegment('stream12.ts', 5, 12, false, 'title'),
            new MediaSegment('stream13.ts', 4, 13),
            new MediaSegment('stream14.ts', 3, 14),
            new MediaSegment('stream15.ts', 6, 15),
            new MediaSegment('stream0.ts', 6, 16, true, null, \SplFixedArray::fromArray(array(1000, null))),
            new MediaSegment('stream0.ts', 6, 17, false, null, \SplFixedArray::fromArray(array(1000, 1000))),
        ));

        return new M3u8($playlist, $version, 6, 3);
    }

    public static function createM3u8Content($version = 3)
    {
        if ($version < 3) {
            return <<<'M3U8'
#EXTM3U
#EXT-X-VERSION:2
#EXT-X-TARGETDURATION:6
#EXT-X-MEDIA-SEQUENCE:12
#EXT-X-DISCONTINUITY-SEQUENCE:3
#EXTINF:5,title
stream12.ts
#EXTINF:4,
stream13.ts
#EXTINF:3,
stream14.ts
#EXTINF:6,
stream15.ts
#EXT-X-DISCONTINUITY
#EXTINF:6,
#EXT-X-BYTERANGE:1000
stream0.ts
#EXTINF:6,
#EXT-X-BYTERANGE:1000@1000
stream0.ts
#EXT-X-ENDLIST
M3U8;
        }

        return <<<'M3U8'
#EXTM3U
#EXT-X-VERSION:3
#EXT-X-TARGETDURATION:6
#EXT-X-MEDIA-SEQUENCE:12
#EXT-X-DISCONTINUITY-SEQUENCE:3
#EXTINF:5.000,title
stream12.ts
#EXTINF:4.000,
stream13.ts
#EXTINF:3.000,
stream14.ts
#EXTINF:6.000,
stream15.ts
#EXT-X-DISCONTINUITY
#EXTINF:6.000,
#EXT-X-BYTERANGE:1000
stream0.ts
#EXTINF:6.000,
#EXT-X-BYTERANGE:1000@1000
stream0.ts
#EXT-X-ENDLIST
M3U8;
    }
}
