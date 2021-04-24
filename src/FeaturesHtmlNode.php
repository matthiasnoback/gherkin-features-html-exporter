<?php
declare(strict_types=1);

namespace GherkinHtmlExporter;

use Behat\Gherkin\Node\FeatureNode;

final class FeaturesHtmlNode implements HtmlNode
{
    /**
     * @var array<FeatureNode>
     */
    private array $features;

    /**
     * @param array<FeatureNode> $features
     */
    public function __construct(array $features)
    {
        $this->features = $features;
    }

    public function toHtml(HtmlPrinter $htmlPrinter): string
    {
        return $htmlPrinter->nodesToHtml(
            array_map(fn(FeatureNode $feature) => new FeatureHtmlNode($feature), $this->features)
        );
    }
}
