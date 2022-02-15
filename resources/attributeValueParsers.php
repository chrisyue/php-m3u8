<?php

/*
 * This file is part of the PhpM3u8 package.
 *
 * (c) Chrisyue <https://chrisyue.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Chrisyue\PhpM3u8\Data\Transformer\Iso8601Transformer;
use Chrisyue\PhpM3u8\Data\Value\Attribute\Resolution;
use Chrisyue\PhpM3u8\Data\Value\Tag\Byterange;

$quotedStringParse = function ($value) {
    return trim($value, '"');
};

/*
 * @see https://tools.ietf.org/html/rfc8216#section-4.2
 */
return [
    'decimal-integer' => 'intval',
    'hexadecimal-sequence' => 'strval',
    'decimal-floating-point' => 'floatval',
    'signed-decimal-floating-point' => 'floatval',
    'quoted-string' => $quotedStringParse,
    'enumerated-string' => 'strval',
    'decimal-resolution' => [Resolution::class, 'fromString'],
    // special
    'datetime' => function ($value) {
        return Iso8601Transformer::fromString(trim($value, '"'));
    },
    'byterange' => function ($value) {
        return Byterange::fromString(trim($value, '"'));
    },
    'closed-captions' => function ($value) {
        if ('NONE' === $value) {
            return null;
        }

        return $quotedStringParse($value);
    },
];
