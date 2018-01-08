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

class StreamTag extends AbstractTag
{
    use SingleValueTagTrait;

    const TAG_IDENTIFIER = '#EXT-X-STREAM-INF';

    /**
     * @var string
     */
    private $programId;

    /**
     * @var string
     */
    private $bandwidth;

    /**
     * @var string
     */
    private $resolution;

    /**
     * @var string
     */
    private $codecs;

    /**
     * @param string
     *
     * @return self
     */
    public function setProgramId($programId)
    {
        $this->programId = $programId;

        return $this;
    }

    /**
     * @return string
     */
    public function getProgramId()
    {
        return $this->programId;
    }

    /**
     * @param string
     *
     * @return self
     */
    public function setBandwidth($bandwidth)
    {
        $this->bandwidth = $bandwidth;

        return $this;
    }

    /**
     * @return string
     */
    public function getBandwidth()
    {
        return $this->bandwidth;
    }

    /**
     * @param string
     *
     * @return self
     */
    public function setResolution($resolution)
    {
        $this->resolution = $resolution;

        return $this;
    }

    /**
     * @return string
     */
    public function getResolution()
    {
        return $this->resolution;
    }

    /**
     * @param string
     *
     * @return self
     */
    public function setCodecs($codecs)
    {
        $this->codecs = $codecs;

        return $this;
    }

    /**
     * @return string
     */
    public function getCodecs()
    {
        return $this->codecs;
    }

    public function dump()
    {
        $attrs = [];
        foreach (get_object_vars($this) as $prop => $value) {
            if (empty($value)) {
                continue;
            }

            if ('codecs' === $prop) {
                $attrs[] = sprintf('%s="%s"', strtoupper($prop), $value);
                continue;
            }

            if ('programId' === $prop) {
                $attrs[] = sprintf('%s=%s', 'PROGRAM-ID', $value);
                continue;
            }

            $attrs[] = sprintf('%s=%s', strtoupper($prop), $value);
        }

        if (empty($attrs)) {
            return;
        }

        return sprintf('%s:%s', self::TAG_IDENTIFIER, implode(',', $attrs));
    }

    protected function read($line)
    {
        $attrs = preg_split("/,(?=(?:[^\"]*\"[^\"]*\")*(?![^\"]*\"))/", self::extractValue($line));
        $attributes = [];
        foreach ($attrs as $attr) {
            list($key, $value) = explode('=', $attr);
            $attributes[$key] = trim($value);
        }

        foreach (get_object_vars($this) as $prop => $value) {
            $key = strtoupper($prop);
            if (isset($attributes[$key])) {
                if ('codecs' === $prop) {
                    $this->$prop = trim($attributes[$key], '",');
                    continue;
                }
                $this->$prop = trim($attributes[$key], ',');
            }
        }
        if (isset($attributes['PROGRAM-ID'])) {
            $this->programId = trim($attributes['PROGRAM-ID'], ',');
        }
    }
}
