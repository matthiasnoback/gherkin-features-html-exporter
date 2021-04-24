<?php
declare(strict_types=1);

namespace GherkinHtmlExporter\HtmlNode;

use GherkinHtmlExporter\HtmlPrinter;

interface HtmlNode
{
    public function toHtml(HtmlPrinter $htmlPrinter): string;
}
