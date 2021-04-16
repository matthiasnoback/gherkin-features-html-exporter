<?php
declare(strict_types=1);

/** @var StepNode $step */

use Behat\Gherkin\Node\StepNode;

assert($step instanceof StepNode);
?>
<div class="step">
    <span class="keyword"><?php echo $this->escape($step->getKeyword()); ?></span> <span class="text"><?php echo $this->escape($step->getText()); ?></span>
    <?php foreach ($step->getArguments() as $argument) {
        require __DIR__ . '/argument.html.php';
    }
    ?>
</div>
<?php
