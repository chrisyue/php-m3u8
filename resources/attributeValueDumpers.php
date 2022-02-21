<?php

declare(strict_types=1);

/*
 * This file is part of the PhpM3u8 package.
 *
 * (c) Chrisyue <https://chrisyue.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Chrisyue\PhpM3u8\Data\Transformer\Iso8601Transformer;

$quotedStringDump = fn ($value) => sprintf('"%s"', $value);

/*
 * @see https://tools.ietf.org/html/rfc8216#section-4.2
 */
return [
    'decimal-integer' => 'strval',
    'hexadecimal-sequence' => 'strval',
    'decimal-floating-point' => 'strval',
    'signed-decimal-floating-point' => 'strval',
    'quoted-string' => $quotedStringDump,
    'enumerated-string' => 'strval',
    'decimal-resolution' => 'strval', // Resolution is __toString able
    // special
    'datetime' => fn ($value) => $quotedStringDump(Iso8601Transformer::toString($value)),
    'byterange' => $quotedStringDump, // Byterange is __toString able
    'closed-captions' => function ($value) use ($quotedStringDump) {
        if (null === $value) {
            return 'NONE';
        }

        return $quotedStringDump($value);
    },
];
