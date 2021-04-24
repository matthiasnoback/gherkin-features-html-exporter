<?php
declare(strict_types=1);

namespace GherkinHtmlExporter;

interface HtmlNode
{
    public function toHtml(HtmlPrinter $htmlPrinter): string;
}
