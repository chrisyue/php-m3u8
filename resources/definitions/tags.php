<?php

/*
 * This file is part of the PhpM3u8 package.
 *
 * (c) Chrisyue <https://chrisyue.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

$definitions = [
    // basic
    'EXT-X-VERSION' => [
        'category' => 'playlist',
        'type' => 'int',
        'position' => -3500,
    ],
    // media playlist
    'EXT-X-TARGETDURATION' => [
        'category' => 'media-playlist',
        'type' => 'int',
        'position' => -2900,
    ],
    'EXT-X-MEDIA-SEQUENCE' => [
        'category' => 'media-playlist',
        'type' => 'int',
        'position' => -2800,
    ],
    'EXT-X-DISCONTINUITY-SEQUENCE' => [
        'category' => 'media-playlist',
        'type' => 'int',
        'position' => -2700,
    ],
    'EXT-X-PLAYLIST-TYPE' => [
        'category' => 'media-playlist',
        'type' => 'enum',
        'position' => -2600,
    ],
    'EXT-X-I-FRAMES-ONLY' => [
        'category' => 'media-playlist',
        'type' => 'bool',
        'position' => -2500,
    ],
    'EXT-X-ENDLIST' => [
        'category' => 'media-playlist',
        'type' => 'bool',
        'position' => 1000,
    ],
    // master playlist
    'EXT-X-MEDIA' => [
        'category' => 'master-playlist',
        'type' => [
            'TYPE' => 'enumerated-string',
            'URI' => 'quoted-string',
            'GROUP-ID' => 'quoted-string',
            'LANGUAGE' => 'quoted-string',
            'ASSOC-LANGUAGE' => 'quoted-string',
            'NAME' => 'quoted-string',
            'DEFAULT' => 'enumerated-string',
            'AUTOSELECT' => 'enumerated-string',
            'FORCED' => 'enumerated-string',
            'INSTREAM-ID' => 'quoted-string',
            'CHARACTERISTICS' => 'quoted-string',
            'CHANNELS' => 'quoted-string',
        ],
        'position' => -1900,
    ],
    'EXT-X-STREAM-INF' => [
        'category' => 'master-playlist',
        'multiple' => true,
        'type' => [
            'BANDWIDTH' => 'decimal-integer',
            'AVERAGE-BANDWIDTH' => 'decimal-integer',
            'CODECS' => 'quoted-string',
            'RESOLUTION' => 'decimal-resolution',
            'FRAME-RATE' => 'decimal-floating-point',
            'HDCP-LEVEL' => 'enumerated-string',
            'AUDIO' => 'quoted-string',
            'VIDEO' => 'quoted-string',
            'SUBTITLES' => 'quoted-string',
            'CLOSED-CAPTIONS' => 'quoted-string',
        ],
        'uriAware' => true,
        'position' => -1800,
    ],
    'EXT-X-I-FRAME-STREAM-INF' => [
        'category' => 'master-playlist',
        'multiple' => true,
        // the type is defined at the end of this file.
        'position' => -1700,
    ],
    'EXT-X-SESSION-DATA' => [
        'category' => 'master-playlist',
        'type' => [
            'DATA-ID' => 'quoted-string',
            'VALUE' => 'quoted-string',
            'URI' => 'quoted-string',
            'LANGUAGE' => 'quoted-string',
        ],
        'position' => -1600,
    ],
    // media or master playlist
    'EXT-X-INDEPENDENT-SEGMENTS' => [
        'category' => 'playlist',
        'type' => 'bool',
        'position' => -900,
    ],
    'EXT-X-START' => [
        'category' => 'playlist',
        'type' => [
            'TIME-OFFSET' => 'signed-decimal-floating-point',
            'PRECISE' => 'enumerated-string',
        ],
        'position' => -800,
    ],
    /*
     * media segment tags
     *
     * @see https://tools.ietf.org/html/rfc8216#section-4.3.2
     */
    'EXTINF' => [
        'category' => 'media-segment',
        'type' => 'inf',
        'position' => 1000,
    ],
    'EXT-X-BYTERANGE' => [
        'category' => 'media-segment',
        'type' => 'byterange',
        'position' => 100,
    ],
    'EXT-X-DISCONTINUITY' => [
        'category' => 'media-segment',
        'position' => 200,
        'type' => 'bool',
    ],
    'EXT-X-PROGRAM-DATE-TIME' => [
        'category' => 'media-segment',
        'position' => 300,
        'type' => 'datetime',
    ],
    'EXT-X-DATERANGE' => [
        'category' => 'media-segment',
        'position' => 400,
        'type' => [
            'ID' => 'quoted-string',
            'CLASS' => 'quoted-string',
            'START-DATE' => 'datetime',
            'END-DATE' => 'datetime',
            'DURATION' => 'decimal-floating-point',
            'PLANNED-DURATION' => 'decimal-floating-point',
            'SCTE35-CMD' => 'hexadecimal-sequence',
            'SCTE35-OUT' => 'hexadecimal-sequence',
            'SCTE35-IN' => 'hexadecimal-sequence',
            'END-ON-NEXT' => 'enumerated-string',
        ],
    ],
];

$definitions['EXT-X-I-FRAME-STREAM-INF']['type'] = $definitions['EXT-X-STREAM-INF']['type'];
unset(
    $definitions['EXT-X-I-FRAME-STREAM-INF']['type']['FRAME-RATE'],
    $definitions['EXT-X-I-FRAME-STREAM-INF']['type']['AUDIO'],
    $definitions['EXT-X-I-FRAME-STREAM-INF']['type']['SUBTITLES'],
    $definitions['EXT-X-I-FRAME-STREAM-INF']['type']['CLOSED-CAPTIONS']
);
$definitions['EXT-X-I-FRAME-STREAM-INF']['type']['URI'] = 'quoted-string';

return $definitions;