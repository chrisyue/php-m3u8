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

namespace Chrisyue\PhpM3u8;

class Config
{
    private $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function get($key, $default = null)
    {
        if (!\is_string($key)) {
            throw new \InvalidArgumentException(sprintf('$key can only be string, got %s', var_export($key, true)));
        }

        if (\array_key_exists($key, $this->data)) {
            return $this->data[$key];
        }

        if (null === $default) {
            throw new \OutOfBoundsException(sprintf('Unknown config "%s"', $key));
        }

        return $default;
    }

    protected function getData()
    {
        return $this->data;
    }
}
