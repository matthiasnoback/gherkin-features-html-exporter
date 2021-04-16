<?php
declare(strict_types=1);

use Behat\Gherkin\Node\FeatureNode;

/** @var FeatureNode $feature */

?>
<div class="feature">
    <div class="feature-title">
        <span class="keyword"><?php echo $this->escape($feature->getKeyword()); ?></span>: <span class="title"><?php echo $this->escape($feature->getTitle()); ?></span>
    </div>
    <?php foreach ($feature->getScenarios() as $scenario) {
        include __DIR__ . '/scenario.html.php';
    } ?>
</div>
