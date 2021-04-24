<?php
declare(strict_types=1);

namespace GherkinHtmlExporter\HtmlNode;

use GherkinHtmlExporter\HtmlPrinter;

final class DescriptionHtmlNode implements HtmlNode
{
    private ?string $description;

    public function __construct(?string $description)
    {
        $this->description = $description;
    }

    public function toHtml(HtmlPrinter $htmlPrinter): string
    {
        if ($this->description === null || trim($this->description) === '') {
            return '';
        }

        return $htmlPrinter->nodesToHtml(
            [
                '<div class="description">',
                $htmlPrinter->markdownToHtml($this->description),
                '</div>'
            ]
        );
    }
}
