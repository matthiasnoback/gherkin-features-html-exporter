<?php
declare(strict_types=1);

/** @var FeatureNode $feature */

use Behat\Gherkin\Node\BackgroundNode;
use Behat\Gherkin\Node\FeatureNode;
use Behat\Gherkin\Node\OutlineNode;
use GherkinHtmlExporter\Html;
use GherkinHtmlExporter\TitleAndDescription;

assert($feature instanceof FeatureNode);

?>
<a id="<?php echo md5(basename($feature->getFile()) . $feature->getLine()); ?>"></a>
<div class="feature">
    <div class="feature-title"><span class="keyword"><?php echo Html::escape($feature->getKeyword()); ?></span>:<?php if (is_string($feature->getTitle())) { ?> <span class="title"><?php echo Html::escape($feature->getTitle()); ?></span><?php } ?></div>
    <?php

    $description = $feature->getDescription();
    require __DIR__ . '/_description.html.php';

    $background = $feature->getBackground();
    if ($background instanceof BackgroundNode) {
        $titleAndDescription = TitleAndDescription::fromScenarioTitle($background->getTitle());

        ?>
        <div class="background">
            <div class="background-title">
                <span class="keyword"><?php echo Html::escape($background->getKeyword()); ?></span>:<?php if (is_string($titleAndDescription->getTitle())) { ?> <span class="title"><?php echo Html::escape($titleAndDescription->getTitle()); ?></span><?php } ?>
            </div>
            <?php

            $description = $titleAndDescription->getDescription();
            require __DIR__ . '/_description.html.php';

            $steps = $background->getSteps();
            require __DIR__ . '/_steps.html.php'
            ?>
        </div>
        <?php
    }
    if ($feature->hasBackground()) {
        $background = $feature->getBackground();

    }
    ?>
    <?php foreach ($feature->getScenarios() as $scenario) {
        if ($scenario instanceof OutlineNode) {
            require __DIR__ . '/_scenario_outline.html.php';
        } else {
            require __DIR__ . '/_scenario.html.php';
        }
    } ?>
</div>
