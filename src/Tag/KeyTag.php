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

class KeyTag extends AbstractTag
{
    use AttributesValueTagTrait;

    const TAG_IDENTIFIER = '#EXT-X-KEY';

    /**
     * @var string
     */
    private $method;

    /**
     * @var string
     */
    private $uri;

    /**
     * @var string
     */
    private $iv;

    /**
     * @var string
     */
    private $keyFormat;

    /**
     * @var array
     */
    private $keyFormatVersions;

    /**
     * @param string
     *
     * @return self
     */
    public function setMethod($method)
    {
        $this->method = $method;

        return $this;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param string
     *
     * @return self
     */
    public function setUri($uri)
    {
        $this->uri = $uri;

        return $this;
    }

    /**
     * @return string
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * @param string
     *
     * @return self
     */
    public function setIv($iv)
    {
        $this->iv = $iv;

        return $this;
    }

    /**
     * @return string
     */
    public function getIv()
    {
        return $this->iv;
    }

    /**
     * @param string
     *
     * @return self
     */
    public function setKeyFormat($keyFormat)
    {
        $this->keyFormat = $keyFormat;

        return $this;
    }

    /**
     * @return string
     */
    public function getKeyFormat()
    {
        return $this->keyFormat;
    }

    /**
     * @param array
     *
     * @return self
     */
    public function setKeyFormatVersions(array $keyFormatVersions)
    {
        $this->keyFormatVersions = $keyFormatVersions;

        return $this;
    }

    /**
     * @return array
     */
    public function getKeyFormatVersions()
    {
        return $this->keyFormatVersions;
    }

    public function dump()
    {
        $attrs = [];
        foreach (get_object_vars($this) as $prop => $value) {
            if (empty($value)) {
                continue;
            }

            if ('uri' === $prop || 'keyFormat' === $prop) {
                $attrs[] = sprintf('%s="%s"', strtoupper($prop), $value);

                continue;
            }

            if ('keyFormatVersions' === $prop) {
                $attrs[] = sprintf('%s="%s"', strtoupper($prop), implode('/', $value));

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
        $attributes = self::extractAttributes($line);

        foreach (get_object_vars($this) as $prop => $value) {
            $key = strtoupper($prop);
            if (isset($attributes[$key])) {
                if ('uri' === $prop || 'keyFormat' === $prop) {
                    $this->$prop = trim($attributes[$key], '"');

                    continue;
                }

                if ('keyFormatVersions' === $prop) {
                    $this->$prop = explode('/', trim($attributes[$key], '"'));

                    continue;
                }

                $this->$prop = $attributes[$key];
            }
        }
    }
}
