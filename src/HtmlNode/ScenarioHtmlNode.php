<?php
declare(strict_types=1);

namespace GherkinHtmlExporter\HtmlNode;

use Behat\Gherkin\Node\BackgroundNode;
use Behat\Gherkin\Node\OutlineNode;
use Behat\Gherkin\Node\ScenarioLikeInterface;
use GherkinHtmlExporter\HtmlPrinter;

final class ScenarioHtmlNode implements HtmlNode
{
    private ?ScenarioLikeInterface $scenario;

    public function __construct(?ScenarioLikeInterface $scenario)
    {
        $this->scenario = $scenario;
    }

    public function toHtml(HtmlPrinter $htmlPrinter): string
    {
        if ($this->scenario === null) {
            return '';
        }

        $titleAndDescription = TitleAndDescription::fromScenarioTitle($this->scenario->getTitle());

        $classes = ['scenario'];
        if ($this->scenario instanceof BackgroundNode) {
            $classes[] = 'background';
        }
        if ($this->scenario instanceof OutlineNode) {
            $classes[] = 'outline';
        }

        return $htmlPrinter->nodesToHtml(
            [
                '<div class="' . implode(' ', $classes) . '">',
                new KeywordAndTitleHtmlNode($this->scenario->getKeyword(), $titleAndDescription->getTitle()),
                new DescriptionHtmlNode($titleAndDescription->getDescription()),
                new StepsHtmlNode($this->scenario->getSteps()),
                $this->scenario instanceof OutlineNode ? new ExamplesHtmlNode($this->scenario->getExampleTables()) : null,
                '</div>'
            ]
        );
    }
}
