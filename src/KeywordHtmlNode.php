<?php
declare(strict_types=1);

namespace GherkinHtmlExporter;

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
                Html::escape($this->keyword),
                '</span>'
            ]
        );
    }
}
