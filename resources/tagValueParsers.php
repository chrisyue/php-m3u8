<?php

/*
 * This file is part of the PhpM3u8 package.
 *
 * (c) Chrisyue <https://chrisyue.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Chrisyue\PhpM3u8\Config;
use Chrisyue\PhpM3u8\Data\Transformer\Iso8601Transformer;
use Chrisyue\PhpM3u8\Data\Value\Tag\Byterange;
use Chrisyue\PhpM3u8\Data\Value\Tag\Inf;
use Chrisyue\PhpM3u8\Parser\AttributeListParser;

$attributeListParser = new AttributeListParser(
    new Config(require __DIR__.'/attributeValueParsers.php')
);

return [
    'int' => 'intval',
    'bool' => null,
    'enum' => null,
    'attribute-list' => [$attributeListParser, 'parse'],
    // special types
    'inf' => [Inf::class, 'fromString'],
    'byterange' => [Byterange::class, 'fromString'],
    'datetime' => [Iso8601Transformer::class, 'fromString'],
];
