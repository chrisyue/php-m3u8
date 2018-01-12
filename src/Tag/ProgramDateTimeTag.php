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

class ProgramDateTimeTag extends AbstractTag
{
    use SingleValueTagTrait;

    const TAG_IDENTIFIER = '#EXT-X-PROGRAM-DATE-TIME';

    /**
     * @var string Absolute date and/or time of the first sample of the Media Segment in ISO_8601 format
     */
    private $programDateTime;

    /**
     * @param \DateTime $programDateTime
     *
     * @return self
     */
    public function setProgramDateTime(\DateTime $programDateTime)
    {
        $this->programDateTime = $programDateTime;

        return $this;
    }

    /**
     * @return \DateTime
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
        if (null === $this->programDateTime) {
            return;
        }

        if (version_compare(phpversion(), '7.0.0') >= 0) {
            return sprintf('%s:%s', self::TAG_IDENTIFIER, $this->programDateTime->format('Y-m-d\TH:i:s.vP'));
        }

        $dateString = substr($this->programDateTime->format('Y-m-d\TH:i:s.u'), 0, -3);

        return sprintf('%s:%s%s', self::TAG_IDENTIFIER, $dateString, $this->programDateTime->format('P'));
    }

    /**
     * @param string $line
     */
    protected function read($line)
    {
        $this->programDateTime = new \DateTime(self::extractValue($line));
    }
}
