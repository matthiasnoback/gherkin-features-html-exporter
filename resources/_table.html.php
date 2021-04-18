<?php
declare(strict_types=1);

/** @var TableNode $table */

use Behat\Gherkin\Node\TableNode;
use GherkinHtmlExporter\Html;

assert($table instanceof TableNode);

?>
<table>
    <tbody>
    <?php foreach ($table->getRows() as $row) {
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
<?php
