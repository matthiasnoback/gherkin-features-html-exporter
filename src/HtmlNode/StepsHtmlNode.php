<?php
declare(strict_types=1);

namespace GherkinHtmlExporter\HtmlNode;

use Behat\Gherkin\Node\StepNode;
use GherkinHtmlExporter\HtmlPrinter;

final class StepsHtmlNode implements HtmlNode
{
    /**
     * @var array<StepNode>
     */
    private array $steps;

    /**
     * @param array<StepNode> $steps
     */
    public function __construct(array $steps)
    {
        $this->steps = $steps;
    }

    public function toHtml(HtmlPrinter $htmlPrinter): string
    {
        if (count($this->steps) === 0) {
            return '';
        }

        return $htmlPrinter->nodesToHtml(
            [
                '<div class="steps">',
                array_map(
                    fn(StepNode $step) => new StepHtmlNode($step),
                    $this->steps
                ),
                '</div>'
            ]
        );
    }
}
