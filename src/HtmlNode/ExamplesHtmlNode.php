<?php
declare(strict_types=1);

namespace GherkinHtmlExporter\HtmlNode;

use Behat\Gherkin\Node\ExampleTableNode;
use GherkinHtmlExporter\HtmlPrinter;

final class ExamplesHtmlNode implements HtmlNode
{
    private array $exampleTables;

    public function __construct(array $exampleTables)
    {
        $this->exampleTables = $exampleTables;
    }

    public function toHtml(HtmlPrinter $htmlPrinter): string
    {
        return $htmlPrinter->nodesToHtml(
            [
                '<div class="examples">',
                '<div class="title">',
                new KeywordHtmlNode('Examples'),
                ':</div>',
                array_map(
                    fn(ExampleTableNode $exampleTable) => new ExampleHtmlTableNode($exampleTable),
                    $this->exampleTables
                ),
                '</div>'
            ]
        );
    }
}
