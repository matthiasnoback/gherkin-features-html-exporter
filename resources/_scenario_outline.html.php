<?php
declare(strict_types=1);

/** @var ScenarioNode $scenario */

use Behat\Gherkin\Node\OutlineNode;
use Behat\Gherkin\Node\ScenarioNode;
use GherkinHtmlExporter\Html;
use GherkinHtmlExporter\TitleAndDescription;

assert($scenario instanceof OutlineNode);

$titleAndDescription = TitleAndDescription::fromScenarioTitle($scenario->getTitle());
?>
<div class="scenario scenario-outline">
    <div class="scenario-title">
        <span class="keyword"><?php echo Html::escape($scenario->getKeyword()); ?></span>
        <?php if ($titleAndDescription->getTitle() !== null) { ?><span class="title"><?php echo Html::escape($titleAndDescription->getTitle()); ?></span><?php } ?>
    </div>
    <?php

    $description = $titleAndDescription->getDescription();
    require __DIR__ . '/_description.html.php';

    ?>
    <div class="steps">
        <?php
        foreach ($scenario->getSteps() as $step) {
            require __DIR__ . '/_step.html.php';
        }
        ?>
    </div>
    <div class="examples">
        <div class="examples-title"><span class="keyword">Examples</span>:</div>
        <?php
        foreach ($scenario->getExampleTables() as $table) {
            ?>
            <div class="example-table">
                <?php
                require __DIR__ . '/_table.html.php';
                ?>
            </div>
            <?php
        }
        ?>
    </div>
</div>
