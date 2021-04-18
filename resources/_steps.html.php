<?php
declare(strict_types=1);

/** @var array<StepNode> $steps */

use Behat\Gherkin\Node\StepNode;

if (count($steps) > 0) {
    ?>
    <div class="steps">
        <?php
        foreach ($steps as $step) {
            require __DIR__ . '/_step.html.php';
        }
        ?>
    </div>
    <?php
}
