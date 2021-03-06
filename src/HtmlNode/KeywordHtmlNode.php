<?php
declare(strict_types=1);

namespace GherkinHtmlExporter\HtmlNode;

use GherkinHtmlExporter\HtmlPrinter;

final class KeywordHtmlNode implements HtmlNode
{
    private string $keyword;

    public function __construct(string $keyword)
    {
        $this->keyword = $keyword;
    }

    public function toHtml(HtmlPrinter $htmlPrinter): string
    {
        return $htmlPrinter->nodesToHtml(
            [
                '<span class="keyword">',
                $htmlPrinter->escape($this->keyword),
                '</span>'
            ]
        );
    }
}
