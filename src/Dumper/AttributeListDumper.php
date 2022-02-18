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

namespace Chrisyue\PhpM3u8\Dumper;

use Chrisyue\PhpM3u8\Config;

class AttributeListDumper
{
    private $valueDumper;

    public function __construct(Config $valueDumper)
    {
        $this->valueDumper = $valueDumper;
    }

    public function dump(\ArrayAccess $data, array $types)
    {
        $result = [];
        foreach ($data as $key => $value) {
            if (!isset($types[$key])) {
                continue;
            }

            $type = $types[$key];
            $dump = $this->valueDumper->get($type);

            $result[] = sprintf('%s=%s', $key, $dump($value));
        }

        if (!empty($result)) {
            return implode(',', $result);
        }
    }
}
