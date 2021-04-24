<?php
declare(strict_types=1);

namespace GherkinHtmlExporter\HtmlNode;

use GherkinHtmlExporter\HtmlPrinter;

final class KeywordAndTitleHtmlNode implements HtmlNode
{
    private string $keyword;
    private ?string $title;

    public function __construct(string $keyword, ?string $title)
    {
        $this->keyword = $keyword;
        $this->title = $title;
    }

    public function toHtml(HtmlPrinter $htmlPrinter): string
    {
        return $htmlPrinter->nodesToHtml(
            [
                '<div class="title">',
                new KeywordHtmlNode($this->keyword),
                ':',
                is_string($this->title)
                    ? new ReplaceVariablesNode(' {title}', ['title' => $this->title])
                    : null,
                '</div>'
            ]
        );
    }
}
