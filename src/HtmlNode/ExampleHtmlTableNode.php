<?php
declare(strict_types=1);

namespace GherkinHtmlExporter\HtmlNode;

use Behat\Gherkin\Node\TableNode;
use GherkinHtmlExporter\HtmlPrinter;

final class ExampleHtmlTableNode implements HtmlNode
{
    private TableNode $table;

    public function __construct(TableNode $table)
    {
        $this->table = $table;
    }

    public function toHtml(HtmlPrinter $htmlPrinter): string
    {
        return $htmlPrinter->nodesToHtml(
            [
                '<div class="example-table">',
                new TableHtmlNode($this->table),
                '</div>'
            ]
        );
    }
}
