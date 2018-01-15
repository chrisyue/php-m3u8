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

class PlaylistTypeTag extends AbstractTag
{
    use SingleValueTagTrait;

    private $playlistType;

    const TAG_IDENTIFIER = '#EXT-X-PLAYLIST-TYPE';

    public function setPlaylistType($playlistType)
    {
        $this->playlistType = $playlistType;

        return $this;
    }

    public function getPlaylistType()
    {
        return $this->playlistType;
    }

    public function dump()
    {
        if (null === $this->playlistType) {
            return;
        }

        return sprintf('%s:%s', self::TAG_IDENTIFIER, $this->playlistType);
    }

    protected function read($line)
    {
        $this->playlistType = (string) self::extractValue($line);
    }
}
