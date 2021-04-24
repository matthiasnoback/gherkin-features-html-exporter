<?php
declare(strict_types=1);

namespace GherkinHtmlExporter;

use Wa72\HtmlPrettymin\PrettyMin;

final class HtmlFormatterUsingLibrary implements HtmlFormatter
{
    public function reformatHtml(string $html): string
    {
        $pm = new PrettyMin();

        return $pm->load($html)
            ->indent()
            ->saveHtml();
    }
}
