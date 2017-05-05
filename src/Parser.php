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

use Chrisyue\PhpM3u8\Loader\LoaderInterface;
use Chrisyue\PhpM3u8\M3u8\M3u8;
use Chrisyue\PhpM3u8\M3u8\MediaSegment;
use Chrisyue\PhpM3u8\M3u8\Playlist;

class Parser
{
    private $loader;

    public function setLoader(LoaderInterface $loader)
    {
        $this->loader = $loader;

        return $this;
    }

    public function parseFromUri($uri)
    {
        if (null === $this->loader) {
            throw new \BadMethodCallException('You should set an m3u8 loader first');
        }

        return $this->parse($this->loader->load($uri));
    }

    public function parse($content)
    {
        $tokens = $this->lex($content);

        if (!isset($tokens['version'])) {
            $tokens['version'] = 3;
        }

        if (!isset($tokens['mediaSequence'])) {
            $tokens['mediaSequence'] = 0;
        }

        if (!isset($tokens['discontinuitySequence'])) {
            $tokens['discontinuitySequence'] = null;
        }

        if (!isset($tokens['isEndless'])) {
            $tokens['isEndless'] = true;
        }

        $mediaSegments = array();
        foreach ($tokens['playlist'] as $index => $row) {
            $mediaSegment = new MediaSegment(
                $row['uri'],
                $row['duration'],
                $tokens['mediaSequence'] + $index,
                !empty($row['isDiscontinuity']),
                empty($row['title']) ? null : $row['title'],
                empty($row['byteRange']) ? null : $row['byteRange']
            );
            $mediaSegments[] = $mediaSegment;
        }
        $playlist = new Playlist($mediaSegments, $tokens['isEndless']);

        return new M3u8($playlist, $tokens['version'], $tokens['targetDuration'], $tokens['discontinuitySequence']);
    }

    private function lex($content)
    {
        $tokens = array();

        $mediaSequence = 0;

        $lines = explode("\n", $content);
        foreach ($lines as $line) {
            $line = trim($line);

            if (preg_match('/^#EXT-X-VERSION:(\d+)/', $line, $matches)) {
                $tokens['version'] = $matches[1];
                continue;
            }

            if (preg_match('/^#EXT-X-TARGETDURATION:(\d+)/', $line, $matches)) {
                $tokens['targetDuration'] = (int) $matches[1];
                continue;
            }

            if (preg_match('/^#EXT-X-MEDIA-SEQUENCE:(\d+)/', $line, $matches)) {
                $tokens['mediaSequence'] = (int) $matches[1];
                continue;
            }

            if (preg_match('/^#EXT-X-DISCONTINUITY-SEQUENCE:(\d+)/', $line, $matches)) {
                $tokens['discontinuitySequence'] = (int) $matches[1];
                continue;
            }

            if (preg_match('/^#EXT-X-DISCONTINUITY/', $line)) {
                $tokens['playlist'][$mediaSequence]['isDiscontinuity'] = true;
                continue;
            }

            if (preg_match('/^#EXTINF:(.+),(.*)$/', $line, $matches)) {
                $tokens['playlist'][$mediaSequence]['duration'] = $matches[1];

                if (isset($matches[2])) {
                    $tokens['playlist'][$mediaSequence]['title'] = $matches[2];
                }

                continue;
            }

            if (preg_match('/^#EXT-X-BYTERANGE:(\d+)(@(\d+))?$/', $line, $matches)) {
                $byteRange = new \SplFixedArray(2);
                $byteRange[0] = (int) $matches[1];

                if (!empty($matches[3])) {
                    $byteRange[1] = (int) $matches[3];
                }

                $tokens['playlist'][$mediaSequence]['byteRange'] = $byteRange;

                continue;
            }

            if (preg_match('/^[^#]+/', $line, $matches)) {
                $tokens['playlist'][$mediaSequence]['uri'] = $matches[0];
                ++$mediaSequence;

                continue;
            }

            if ('#EXT-X-ENDLIST' === $line) {
                $tokens['isEndless'] = false;
                break;
            }
        }

        return $tokens;
    }
}
