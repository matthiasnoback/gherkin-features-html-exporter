<?php
declare(strict_types=1);
/** @var ScenarioNode $scenario */

use Behat\Gherkin\Node\ScenarioNode;
use GherkinHtmlExporter\Html;
use GherkinHtmlExporter\TitleAndDescription;

assert($scenario instanceof ScenarioNode);

$titleAndDescription = TitleAndDescription::fromScenarioTitle($scenario->getTitle());
?>
<div class="scenario">
    <div class="scenario-title">
        <span class="keyword"><?php echo Html::escape($scenario->getKeyword()); ?></span>: <?php if ($titleAndDescription->getTitle() !== null) { ?><span class="title"><?php echo Html::escape($titleAndDescription->getTitle()); ?></span><?php } ?>
    </div>
    <?php

    $description = $titleAndDescription->getDescription();
    require __DIR__ . '/_description.html.php';

    $steps = $scenario->getSteps();
    require __DIR__ . '/_steps.html.php';
    ?>
</div>
