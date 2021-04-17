<?php
declare(strict_types=1);
/** @var ScenarioNode $scenario */

use Behat\Gherkin\Node\ScenarioNode;
use GherkinHtmlExporter\Html;

assert($scenario instanceof ScenarioNode);

?>
<div class="scenario">
    <div class="scenario-title">
        <span class="keyword"><?php echo Html::escape($scenario->getKeyword()); ?></span>
        <?php if ($scenario->getTitle() !== null) { ?><span class="title"><?php echo Html::escape($scenario->getTitle()); ?></span><?php } ?>
    </div>
    <div class="steps">
        <?php
        foreach ($scenario->getSteps() as $step) {
            require __DIR__ . '/step.html.php';
        }
        ?>
    </div>
</div>
