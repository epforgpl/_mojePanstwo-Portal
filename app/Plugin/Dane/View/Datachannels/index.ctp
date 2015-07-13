<?php $this->Combinator->add_libs('css', $this->Less->css('katalog', array('plugin' => 'Dane'))) ?>
<?php $this->Combinator->add_libs('css', $this->Less->css('dataobject', array('plugin' => 'Dane'))) ?>
<?php $this->Combinator->add_libs('css', $this->Less->css('dataobjectslider', array('plugin' => 'Dane'))) ?>

<?php $this->Combinator->add_libs('js', 'Dane.dataobjectsslider') ?>
<?php $this->Combinator->add_libs('js', 'Dane.dane') ?>

<?php
$di = 0;
foreach ($channels as $data) {
    $datachannel = $data['Datachannel'];
    if (!empty($data['dataobjects'])) {

        $href = '/dane/kanal/' . $datachannel['slug'];
        if ($q != '') {
            $href .= '?q=' . urlencode($q);
        }

        ?>
        <div class="stripe<? if ($di % 2) { ?> odd<? } ?>">
            <div class="container">
                <div class="catalog content">
                    <div class="catalogSquares">
                        <div class="col-xs-12">

                            <div class="datachannel row">

                                <div class="col-lg-12">
                                    <h2>
                                        <a href="<?= $href ?>"><?php echo $datachannel['name']; ?>
                                            <?
                                            if (@$datachannel['count']) {
                                                ?>
                                                <small><?= pl_dopelniacz($datachannel['count'], 'wynik', 'wyniki', 'wyników') ?> &raquo;</small>
                                            <? } ?>
                                        </a>
                                    </h2>
                                </div>

                                <? if ($data['Dataset'] > 1) { ?>
                                    <div class="col-lg-12 datasets">
                                        <div class="description">
                                            <p class="title"><?php echo __d('dane', __('LC_DANE_ZBIORY_DANYCH')); ?>
                                                :</p>
                                            <ul>
                                                <?php foreach ($data['Dataset'] as $dataset) {
                                                    if ($dataset['count']) {
                                                        ?>
                                                        <li>
                                                            <a href="/dane/<?= $dataset['alias'] ?><? if ($q) { ?>?q=<?=
                                                                urlencode($q);
                                                            } ?>"><?php echo $dataset['name']; ?>
                                                                <span
                                                                    class="badge<? if (empty($q)) { ?> badge-data<? } else { ?> badge-active<? } ?>"><?php echo $this->Number->currency($dataset['count'], '', array('places' => 0,)); ?></span>
                                                            </a>
                                                        </li>
                                                    <?php
                                                    }
                                                } ?>
                                            </ul>
                                        </div>
                                    </div>
                                <? } ?>


                                <div class="dataobjectsSliderRow">
                                    <div class="col-xs-12">
                                        <?php echo $this->dataobjectsSlider->render($data['dataobjects'], array(
                                            'perGroup' => 3,
                                            'rowNumber' => 1
                                        )) ?>
                                    </div>

                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php
    }
    $di++;
}
?>
                
                
            