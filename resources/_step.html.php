<?php
declare(strict_types=1);

/** @var StepNode $step */

use Behat\Gherkin\Node\StepNode;
use GherkinHtmlExporter\Html;

assert($step instanceof StepNode);
?>
<div class="step">
    <span class="keyword"><?php echo Html::escape($step->getKeyword()); ?></span> <span class="text"><?php echo Html::escape($step->getText()); ?></span>
    <?php foreach ($step->getArguments() as $argument) {
        require __DIR__ . '/_argument.html.php';
    }
    ?>
</div>
<?php
