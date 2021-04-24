<?php
declare(strict_types=1);

namespace GherkinHtmlExporter\HtmlNode;

use Behat\Gherkin\Node\ArgumentInterface;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use GherkinHtmlExporter\HtmlPrinter;
use RuntimeException;

final class ArgumentHtmlNode implements HtmlNode
{
    private ArgumentInterface $argument;

    public function __construct(ArgumentInterface $argument)
    {
        $this->argument = $argument;
    }

    public function toHtml(HtmlPrinter $htmlPrinter): string
    {
        if ($this->argument instanceof TableNode) {
            return $htmlPrinter->nodesToHtml(
                [
                    '<div class="table-argument">',
                    new TableHtmlNode($this->argument),
                    '</div>'
                ]
            );
        }
        if ($this->argument instanceof PyStringNode) {
            return $htmlPrinter->nodesToHtml(
                [
                    '<div class="pystring-argument">',
                    '<pre>',
                    $this->argument->getRaw(),
                    '</pre>',
                    '</div>'
                ]
            );
        }

        throw new RuntimeException('Not implemented');
    }
}
