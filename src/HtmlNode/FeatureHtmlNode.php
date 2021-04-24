<?php
declare(strict_types=1);

namespace GherkinHtmlExporter\HtmlNode;

use Behat\Gherkin\Node\FeatureNode;
use Behat\Gherkin\Node\ScenarioInterface;
use GherkinHtmlExporter\HtmlPrinter;

final class FeatureHtmlNode implements HtmlNode
{
    private FeatureNode $feature;

    public function __construct(FeatureNode $feature)
    {
        $this->feature = $feature;
    }

    public static function determineUniqueAnchorForFeature(FeatureNode $feature): string
    {
        assert(is_string($feature->getFile()));

        return md5(basename($feature->getFile()) . $feature->getLine());
    }

    public function toHtml(HtmlPrinter $htmlPrinter): string
    {
        return $htmlPrinter->nodesToHtml(
            [
                new ReplaceVariablesNode(
                    '<a id="{anchor}"></a>',
                    [
                        'anchor' => self::determineUniqueAnchorForFeature($this->feature),
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
