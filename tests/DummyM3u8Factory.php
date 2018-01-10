<?php

/*
 * This file is part of the PhpM3u8 package.
 *
 * (c) Chrisyue <http://chrisyue.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Chrisyue\PhpM3u8\tests;

use Chrisyue\PhpM3u8\M3u8;
use Chrisyue\PhpM3u8\Segment;
use Chrisyue\PhpM3u8\Tag\KeyTag;

class DummyM3u8Factory
{
    public static function createM3u8($version = 3)
    {
        $m3u8 = new M3u8();
        $m3u8->getVersionTag()->setVersion($version);
        $m3u8->getMediaSequenceTag()->setMediaSequence(33);
        $m3u8->getDiscontinuitySequenceTag()->setDiscontinuitySequence(3);
        $m3u8->getTargetDurationTag()->setTargetDuration(12);
        $m3u8->getEndlistTag()->setEndless(true);

        $segment = new Segment($version);

        $keyTag = new KeyTag();
        $keyTag->setMethod('AES-128')->setUri('key')->setIV('0xF85A5066CCB442181ACACA2E862A34DC');
        $segment->getKeyTags()->add($keyTag);
        $keyTag = new KeyTag();
        $keyTag->setMethod('SAMPLE-AES')->setUri('key2')->setIV('0xF85A5066CCB442181ACACA2E862A34DC')
            ->setKeyFormat('com.apple')->setKeyFormatVersions([1]);
        $segment->getKeyTags()->add($keyTag);

        $segment->getExtinfTag()->setDuration(12)->setTitle('hello world');
        $segment->getByteRangeTag()->setLength(10000)->setOffset(100);
        $segment->getUri()->setUri('stream33.ts');
        $segment->getProgramDateTimeTag()->setProgramDateTime(new \DateTime('2010-02-19T14:54:23.031+08:00'));
        $m3u8->getSegments()->add($segment);

        $segment = new Segment($version);
        $segment->getExtinfTag()->setDuration(10);
        $segment->getDiscontinuityTag()->setDiscontinuity(true);
        $segment->getUri()->setUri('video01.ts');
        $m3u8->getSegments()->add($segment);

        return $m3u8;
    }

    public static function createM3u8Content($version = 3)
    {
        if ($version < 3) {
            return <<<'M3U8'
#EXTM3U
#EXT-X-VERSION:2
#EXT-X-TARGETDURATION:12
#EXT-X-MEDIA-SEQUENCE:33
#EXT-X-DISCONTINUITY-SEQUENCE:3
#EXT-X-KEY:METHOD=AES-128,URI="key",IV=0xF85A5066CCB442181ACACA2E862A34DC
#EXT-X-KEY:METHOD=SAMPLE-AES,URI="key2",IV=0xF85A5066CCB442181ACACA2E862A34DC,KEYFORMAT="com.apple",KEYFORMATVERSIONS="1"
#EXTINF:12,hello world
#EXT-X-BYTERANGE:10000@100
#EXT-X-PROGRAM-DATE-TIME:2010-02-19T14:54:23.031+08:00
stream33.ts
#EXTINF:10,
#EXT-X-DISCONTINUITY
video01.ts
M3U8;
        }

        return <<<'M3U8'
#EXTM3U
#EXT-X-VERSION:3
#EXT-X-TARGETDURATION:12
#EXT-X-MEDIA-SEQUENCE:33
#EXT-X-DISCONTINUITY-SEQUENCE:3
#EXT-X-KEY:METHOD=AES-128,URI="key",IV=0xF85A5066CCB442181ACACA2E862A34DC
#EXT-X-KEY:METHOD=SAMPLE-AES,URI="key2",IV=0xF85A5066CCB442181ACACA2E862A34DC,KEYFORMAT="com.apple",KEYFORMATVERSIONS="1"
#EXTINF:12.000,hello world
#EXT-X-BYTERANGE:10000@100
#EXT-X-PROGRAM-DATE-TIME:2010-02-19T14:54:23.031+08:00
stream33.ts
#EXTINF:10.000,
#EXT-X-DISCONTINUITY
video01.ts
M3U8;
    }
}
