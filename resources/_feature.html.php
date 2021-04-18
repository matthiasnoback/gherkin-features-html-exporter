<?php
declare(strict_types=1);

/** @var FeatureNode $feature */

use Behat\Gherkin\Node\FeatureNode;
use Behat\Gherkin\Node\OutlineNode;
use GherkinHtmlExporter\Html;

assert($feature instanceof FeatureNode);

?>
<div class="feature">
    <div class="feature-title">
        <span class="keyword"><?php echo Html::escape($feature->getKeyword()); ?></span>: <span class="title"><?php echo Html::escape($feature->getTitle()); ?></span>
    </div>
    <?php foreach ($feature->getScenarios() as $scenario) {
        if ($scenario instanceof OutlineNode) {
            require __DIR__ . '/_scenario_outline.html.php';
        } else {
            require __DIR__ . '/_scenario.html.php';
        }
    } ?>
</div>
