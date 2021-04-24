<?php
declare(strict_types=1);

namespace GherkinHtmlExporter\HtmlNode;

use Behat\Gherkin\Node\ArgumentInterface;
use Behat\Gherkin\Node\StepNode;
use GherkinHtmlExporter\HtmlPrinter;

final class StepHtmlNode implements HtmlNode
{
    private StepNode $step;

    public function __construct(StepNode $step)
    {
        $this->step = $step;
    }

    public function toHtml(HtmlPrinter $htmlPrinter): string
    {
        return $htmlPrinter->nodesToHtml(
            [
                '<div class="step">',
                new KeywordHtmlNode($this->step->getKeyword()),
                ' ',
                $htmlPrinter->escape($this->step->getText()),
                array_map(
                    fn(ArgumentInterface $argument) => new ArgumentHtmlNode($argument),
                    $this->step->getArguments()
                ),
                '</div>'
            ]
        );
    }
}
