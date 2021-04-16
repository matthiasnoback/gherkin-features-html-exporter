<?php
declare(strict_types=1);

/** @var StepNode $step */

use Behat\Gherkin\Node\StepNode;

?>
<div class="step">
    <span class="keyword"><?php echo $this->escape($step->getKeyword()); ?></span> <span class="text"><?php echo $this->escape($step->getText()); ?></span>
</div>
<?php
