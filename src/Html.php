<?php
declare(strict_types=1);

namespace GherkinHtmlExporter;

use League\CommonMark\CommonMarkConverter;

final class Html
{
    public static function escape(string $value): string
    {
        return htmlspecialchars($value, ENT_QUOTES);
    }

    public static function markdownToHtml(string $markdown): string
    {
        static $converter;

        if ($converter === null) {
            $converter = new CommonMarkConverter();
        }

        return $converter->convertToHtml($markdown);
    }
}
