<?php

namespace App\Support;

use Symfony\Component\HtmlSanitizer\HtmlSanitizer;
use Symfony\Component\HtmlSanitizer\HtmlSanitizerConfig;

class NewsHtml
{
    public static function sanitize(string $html): string
    {
        $config = (new HtmlSanitizerConfig)
            ->allowSafeElements()
            ->allowRelativeLinks(false)
            ->allowRelativeMedias(false);

        return (new HtmlSanitizer($config))->sanitize($html);
    }
}
