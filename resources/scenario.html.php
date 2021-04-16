<?php
declare(strict_types=1);
/** @var \Behat\Gherkin\Node\ScenarioNode $scenario */
?>
<div class="scenario">
    <div class="scenario-title">
        <span class="keyword"><?php echo $this->escape($scenario->getKeyword()); ?></span> <span class="title"><?php echo $this->escape($scenario->getTitle()); ?></span>
    </div>
    <div class="steps">
        <?php
        foreach ($scenario->getSteps() as $step) {
            include __DIR__ . '/step.html.php';
        }
        ?>
    </div>
</div>
