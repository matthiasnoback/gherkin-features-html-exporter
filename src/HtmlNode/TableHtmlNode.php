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
        $nodes = ['<table><tbody>'];

        foreach ($this->table->getRows() as $row) {
            $nodes[] = '<tr>';

            foreach ($row as $cell) {
                $nodes[] = new ReplaceVariablesNode(
                    '<td>{cell}</td>',
                    [
                        'cell' => $cell
                    ]
                );
            }
            $nodes[] = '</tr>';
        }

        $nodes[] = '</tbody></table>';

        return $htmlPrinter->nodesToHtml($nodes);
    }
}
