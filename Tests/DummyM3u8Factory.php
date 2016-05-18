<?php

/*
 * This file is part of the PhpM3u8 package.
 *
 * (c) Chrisyue <http://chrisyue.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests;

use Chrisyue\PhpM3u8\M3u8\M3u8;
use Chrisyue\PhpM3u8\M3u8\MediaSegment\MediaSegment;
use Chrisyue\PhpM3u8\M3u8\Playlist;

class DummyM3u8Factory
{
    public static function createM3u8($version = 3)
    {
        $playlist = new Playlist(array(
            new MediaSegment('stream12.ts', 5, 12),
            new MediaSegment('stream13.ts', 4, 13),
            new MediaSegment('stream14.ts', 3, 14),
            new MediaSegment('stream15.ts', 6, 15),
        ));

        return new M3u8($playlist, $version, 5);
    }

    public static function createM3u8Content($version = 3)
    {
        if ($version < 3) {
            return <<<'M3U8'
#EXTM3U
#EXT-X-VERSION:2
#EXT-X-TARGETDURATION:5
#EXT-X-MEDIA-SEQUENCE:12
#EXTINF:5,
stream12.ts
#EXTINF:4,
stream13.ts
#EXTINF:3,
stream14.ts
#EXTINF:6,
stream15.ts
M3U8;
        }

        return <<<'M3U8'
#EXTM3U
#EXT-X-VERSION:3
#EXT-X-TARGETDURATION:5
#EXT-X-MEDIA-SEQUENCE:12
#EXTINF:5.000,
stream12.ts
#EXTINF:4.000,
stream13.ts
#EXTINF:3.000,
stream14.ts
#EXTINF:6.000,
stream15.ts
M3U8;
    }
}
