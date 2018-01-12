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

class M3u8 extends AbstractContainer
{
    private $m3uTag;

    private $versionTag;

    private $targetDurationTag;

    private $mediaSequenceTag;

    private $discontinuitySequenceTag;

    private $segments;

    private $endlistTag;

    public function __construct()
    {
        $this->m3uTag = new Tag\M3uTag();
        $this->versionTag = new Tag\VersionTag();
        $this->targetDurationTag = new Tag\TargetDurationTag();
        $this->mediaSequenceTag = new Tag\MediaSequenceTag();
        $this->discontinuitySequenceTag = new Tag\DiscontinuitySequenceTag();
        $this->segments = new Segments($this);
        $this->endlistTag = new Tag\EndlistTag();
    }

    public function read($string)
    {
        $lines = self::split($string);

        $this->readLines($lines);
    }

    public function getVersionTag()
    {
        return $this->versionTag;
    }

    public function getVersion()
    {
        return $this->versionTag->getVersion();
    }

    public function getTargetDurationTag()
    {
        return $this->targetDurationTag;
    }

    public function getTargetDuration()
    {
        return $this->targetDurationTag->getTargetDuration();
    }

    public function getMediaSequenceTag()
    {
        return $this->mediaSequenceTag;
    }

    public function getMediaSequence()
    {
        return $this->mediaSequenceTag->getMediaSequence();
    }

    public function getDiscontinuitySequenceTag()
    {
        return $this->discontinuitySequenceTag;
    }

    public function getDiscontinuitySequence()
    {
        return $this->discontinuitySequenceTag->getDiscontinuitySequence();
    }

    /**
     * @return Chrisyue\PhpM3u8\Segments
     */
    public function getSegments()
    {
        return $this->segments;
    }

    public function getEndlistTag()
    {
        return $this->endlistTag;
    }

    public function isEndless()
    {
        return $this->endlistTag->isEndless();
    }

    public function getDuration()
    {
        return $this->segments->getDuration();
    }

    protected function getComponents()
    {
        return [
            $this->m3uTag,
            $this->versionTag,
            $this->targetDurationTag,
            $this->mediaSequenceTag,
            $this->discontinuitySequenceTag,
            $this->segments,
            $this->endlistTag,
        ];
    }

    private static function split($string)
    {
        $lines = explode("\n", $string);
        $lines = array_map('trim', $lines);

        return array_filter($lines);
    }
}
