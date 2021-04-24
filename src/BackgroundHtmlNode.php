<?php
declare(strict_types=1);

namespace GherkinHtmlExporter;

use Behat\Gherkin\Node\BackgroundNode;

final class BackgroundHtmlNode implements HtmlNode
{
    private ?BackgroundNode $background;

    public function __construct(?BackgroundNode $background)
    {
        $this->background = $background;
    }

    public function toHtml(HtmlPrinter $htmlPrinter): string
    {
        if ($this->background === null) {
            return '';
        }

        $titleAndDescription = TitleAndDescription::fromScenarioTitle($this->background->getTitle());

        return $htmlPrinter->nodesToHtml(
            [
                '<div class="background">',
                new KeywordAndTitleHtmlNode($this->background->getKeyword(), $titleAndDescription->getTitle()),
                new DescriptionHtmlNode($titleAndDescription->getDescription()),
                new StepsHtmlNode($this->background->getSteps()),
                '</div>'
            ]
        );
    }
}
