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

class VersionTag extends AbstractTag
{
    use SingleValueTagTrait;

    private $version = 3;

    const TAG_IDENTIFIER = '#EXT-X-VERSION';

    public function setVersion($version)
    {
        $this->version = $version;

        return $this;
    }

    public function getVersion()
    {
        return $this->version;
    }

    public function dump()
    {
        return sprintf('%s:%d', self::TAG_IDENTIFIER, $this->version);
    }

    protected function read($line)
    {
        $this->version = (int) self::extractValue($line);
    }
}
