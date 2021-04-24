<?php
declare(strict_types=1);

namespace GherkinHtmlExporter;

use Behat\Gherkin\Node\BackgroundNode;
use Behat\Gherkin\Node\FeatureNode;
use Behat\Gherkin\Node\ScenarioInterface;

final class FeatureHtmlNode implements HtmlNode
{
    private FeatureNode $feature;

    public function __construct(FeatureNode $feature)
    {
        $this->feature = $feature;
    }

    public function toHtml(HtmlPrinter $htmlPrinter): string
    {
        return $htmlPrinter->nodesToHtml(
            [
                new ReplaceVariablesNode(
                    '<a id="{anchor}"></a>',
                    [
                        'anchor' => md5(basename($this->feature->getFile()) . $this->feature->getLine()),
                    ]
                ),
                '<div class="feature">',
                new KeywordAndTitleHtmlNode($this->feature->getKeyword(), $this->feature->getTitle()),
                new DescriptionHtmlNode($this->feature->getDescription()),
                new ScenarioHtmlNode($this->feature->getBackground()),
                array_map(fn (ScenarioInterface $scenario) => new ScenarioHtmlNode($scenario), $this->feature->getScenarios()),
                '</div>'
            ]
        );
    }
}
