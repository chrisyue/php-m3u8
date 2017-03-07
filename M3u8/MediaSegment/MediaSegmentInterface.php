<?php

/*
 * This file is part of the PhpM3u8 package.
 *
 * (c) Chrisyue <http://chrisyue.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Chrisyue\PhpM3u8\M3u8\MediaSegment;

interface MediaSegmentInterface
{
    public function getUri();

    public function getDuration();

    public function getSequence();

    public function isDiscontinuity();

    public function getTitle();
}
