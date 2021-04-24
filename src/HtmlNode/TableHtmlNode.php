<?php
declare(strict_types=1);

namespace GherkinHtmlExporter\HtmlNode;

use Behat\Gherkin\Node\TableNode;
use GherkinHtmlExporter\HtmlPrinter;

final class TableHtmlNode implements HtmlNode
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
                '<table><tbody>',
                array_map(
                    fn(array $row) => [
                        '<tr>',
                        array_map(
                            fn($cell) => [
                                '<td>',
                                $htmlPrinter->escape($cell),
                                '</td>',
                            ],
                            $row
                        ),
                        '</tr>'
                    ],
                    $this->table->getRows()
                ),
                '</tbody></table>'
            ]
        );
    }
}
