<?
$rand = 'carousel-' . rand();
$perGroupSet = (isset($options['perGroup'])) ? $options['perGroup'] : 4;
$rowNumber = (isset($options['rowNumber'])) ? $options['rowNumber'] : 2;
$slidertheme = 'dataobjectSlider';
if (isset($_COOKIE["_mPViewport"])) {
    $cookie = $_COOKIE["_mPViewport"];

    if ($cookie == 'xs') {
        $perGroup = (floor($perGroupSet / 4) < 1) ? 1 : floor($perGroupSet / 4);
    } elseif ($cookie == 'sm') {
        $perGroup = (round($perGroupSet / 2, 0, PHP_ROUND_HALF_UP) < 1) ? 1 : round($perGroupSet / 2, 0, PHP_ROUND_HALF_UP);
    } else {
        $perGroup = $perGroupSet;
    }
} else {
    $perGroup = $perGroupSet;
}
$perGroupSize = ($rowNumber == 1) ? floor(12 / $perGroup) : (($perGroup <= $rowNumber) ? 12 : floor((12 / ceil($perGroup / $rowNumber))));
?>

    <div class="dataobjectsSlider" data-rownumber="<?= $rowNumber ?>">
        <div id="<?php echo $rand; ?>" class="carousel slide" data-ride="carousel">
            <?php if (!empty($objects) && (count($objects) > $perGroup)) { ?>
                <ol class="carousel-indicators">
                    <?php for ($x = 0; $x < (ceil(count($objects) / $perGroup)); $x++) { ?>
                        <li data-target="#<?php echo $rand; ?>"
                            data-slide-to="<?= $x ?>"
                            <? if ($x == 0) { ?> class="active"<? } ?>>
                        </li>
                    <?php } ?>
                </ol>
            <?php } ?>

            <div class="carousel-inner">
                <div class="item active">
                    <? if (!empty($objects)) {
                        foreach ($objects as $index => $object) {
                            if (($index % $perGroup == 0) && ($index != 0)) {
                                echo '</div><div class="item">';
                            }

                            echo '<div class="object col-xs-' . $perGroupSize . '">' . $this->Dataobject->render($object, $slidertheme, $options) . '</div>';
                        }
                    } ?>
                </div>
            </div>

            <a class="left carousel-control" href="#<?php echo $rand; ?>" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left"></span>
            </a>
            <a class="right carousel-control" href="#<?php echo $rand; ?>" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right"></span>
            </a>
        </div>
    </div>

<?php /*
<div class="dataobjectSlider">
    <div class="col-md-1 half nav left">
        <div class="nav_inner">
            &laquo;
        </div>
    </div>
    <div class="col-md-11 cont">

        <? if (!empty($objects)) { ?>

            <ul>

                <?
                foreach ($objects as $object) {
                    ?>

                    <li>

                        <?= $this->Dataobject->render($object) ?>

                    </li>

                <?
                }
                ?>

            </ul>

        <? } ?>

    </div>
    <div class="col-md-1 half nav right">
        <div class="nav_inner">
            &raquo;
        </div>
    </div>
</div>
 */
?>