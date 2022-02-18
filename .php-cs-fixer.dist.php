<?php

$header = <<<'EOF'
This file is part of the PhpM3u8 package.

(c) Chrisyue <https://chrisyue.com/>

For the full copyright and license information, please view the LICENSE
file that was distributed with this source code.
EOF;

$finder = PhpCsFixer\Finder::create()->in(__DIR__);

$config = new PhpCsFixer\Config();
return $config->setRules([
        '@Symfony' => true,
        '@Symfony:risky' => true,
        '@PHP74Migration' => true,
        '@PHP74Migration:risky' => true,
        '@PHPUnit84Migration:risky' => true,
        'header_comment' => compact('header'),
        'ordered_imports' => true,
    ])
    ->setFinder($finder)
;
