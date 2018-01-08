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

    private $playlist_type;

    const TAG_IDENTIFIER = '#EXT-X-PLAYLIST-TYPE';

    public function setPlaylistType($playlist_type)
    {
        $this->playlist_type = $playlist_type;

        return $this;
    }

    public function getPlaylistType()
    {
        return $this->playlist_type;
    }

    public function dump()
    {
        if (empty($this->playlist_type)) {
            return;
        }
        return sprintf('%s:%s', self::TAG_IDENTIFIER, $this->playlist_type);
    }

    protected function read($line)
    {
        $this->playlist_type = (string) self::extractValue($line);
    }
}
