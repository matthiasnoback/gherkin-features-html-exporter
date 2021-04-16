<?php
declare(strict_types=1);

/** @var FeatureNode $feature */

use Behat\Gherkin\Node\FeatureNode;

assert($feature instanceof FeatureNode);

?>
<div class="feature">
    <div class="feature-title">
        <span class="keyword"><?php echo $this->escape($feature->getKeyword()); ?></span>: <span class="title"><?php echo $this->escape($feature->getTitle()); ?></span>
    </div>
    <?php foreach ($feature->getScenarios() as $scenario) {
        require __DIR__ . '/scenario.html.php';
    } ?>
</div>
