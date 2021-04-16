<?php
declare(strict_types=1);

use Behat\Gherkin\Node\ArgumentInterface;
use Behat\Gherkin\Node\TableNode;

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
                        <td><?php echo $this->escape($cell); ?></td><?php
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
