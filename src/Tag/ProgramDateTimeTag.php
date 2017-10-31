<?php

/*
 * This file is part of the PhpM3u8 package.
 *
 * (c) Chrisyue <http://chrisyue.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Chrisyue\PhpM3u8\Tag;

/**
 * Class ProgramDateTimeTag.
 */
class ProgramDateTimeTag extends AbstractTag
{
    use SingleValueTagTrait;

    const TAG_IDENTIFIER = '#EXT-X-PROGRAM-DATE-TIME';

    /**
     * @var string Absolute date and/or time of the first sample of the Media Segment in ISO_8601 format
     */
    private $programDateTime;

    /**
     * @param string $programDateTime
     *
     * @return $this
     */
    public function setProgramDateTime($programDateTime)
    {
        $this->programDateTime = $programDateTime;

        return $this;
    }

    /**
     * @return string
     */
    public function getProgramDateTime()
    {
        return $this->programDateTime;
    }

    /**
     * @return string
     */
    public function dump()
    {
        return sprintf('%s:%d', self::TAG_IDENTIFIER, $this->programDateTime);
    }

    /**
     * @param string $line
     */
    protected function read($line)
    {
        $this->programDateTime = self::extractValue($line);
    }
}
