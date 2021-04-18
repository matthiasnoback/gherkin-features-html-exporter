<?php
declare(strict_types=1);
/** @var ScenarioNode $scenario */

use Behat\Gherkin\Node\OutlineNode;
use Behat\Gherkin\Node\ScenarioNode;
use GherkinHtmlExporter\Html;

assert($scenario instanceof OutlineNode);

?>
<div class="scenario scenario-outline">
    <div class="scenario-title">
        <span class="keyword"><?php echo Html::escape($scenario->getKeyword()); ?></span>
        <?php if ($scenario->getTitle() !== null) { ?><span class="title"><?php echo Html::escape($scenario->getTitle()); ?></span><?php } ?>
    </div>
    <div class="steps">
        <?php
        foreach ($scenario->getSteps() as $step) {
            require __DIR__ . '/_step.html.php';
        }
        ?>
    </div>
    <div class="examples">
        <?php
        foreach ($scenario->getExampleTables() as $table) {
            ?>
            <div class="example-table">
                <?php
                require __DIR__ . '/_table.php';
                ?>
            </div>
            <?php
        }
        ?>
    </div>
</div>
