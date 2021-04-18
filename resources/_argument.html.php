<?php
declare(strict_types=1);

use Behat\Gherkin\Node\ArgumentInterface;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use GherkinHtmlExporter\Html;

/** @var ArgumentInterface $argument */
assert($argument instanceof ArgumentInterface);

if ($argument instanceof TableNode) {
    ?>
    <div class="table-argument">
        <table>
            <tbody>
            <?php foreach ($argument->getRows() as $row) {
                ?>
                <tr>
                    <?php foreach ($row as $cell) {
                        ?>
                        <td><?php echo Html::escape($cell); ?></td><?php
                    }
                    ?>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>
    </div>
    <?php
}

if ($argument instanceof PyStringNode) {
    ?>
    <div class="pystring-argument">
        <pre><?php echo $argument->getRaw(); ?></pre>
    </div>
    <?php
}
