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
    'quoted-string' => fn ($value) => sprintf('"%s"', $value),
    'enumerated-string' => 'strval',
    'decimal-resolution' => 'strval', // Chrisyue\PhpM3u8\Value\Attribute\Resolution is __toString able
    // special
    'datetime' => fn ($value) => sprintf('"%s"', Iso8601Transformer::toString($value)),
    'byterange' => fn ($value) => $quoteStringDump($value),
    'closed-captions' => function ($value) {
        if (null === $value) {
            return 'NONE';
        }

        return $quotedStringDump($value);
    },
];
