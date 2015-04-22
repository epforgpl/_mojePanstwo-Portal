<?php $this->Combinator->add_libs('css', $this->Less->css('view-saorzeczenia', array('plugin' => 'Dane'))); ?>

<?= $this->Element('dataobject/pageBegin'); ?>

    <div class="row">

        <div class="col-lg-2 objectSide">
            <div class="objectSideInner">


                <ul class="dataHighlights side">
                    <li class="dataHighlight">
                        <p class="_label"><?= __d('dane', 'LC_DANE_DATA_WPLYWU') ?></p>

                        <p class="_value"><?= $this->Czas->dataSlownie($object->getData('data_wplywu')) ?></p>
                    </li>
                    <li class="dataHighlight">
                        <p class="_label"><?= __d('dane', 'LC_DANE_DATA_ORZECZENIA') ?></p>

                        <p class="_value"><?= $this->Czas->dataSlownie($object->getData('data_orzeczenia')) ?></p>
                    </li>
                    <li class="dataHighlight">
                        <p class="_label"><?= __d('dane', 'LC_DANE_DLUGOSC_ROZPATRYWANIA') ?></p>

                        <p class="_value"><?= pl_dopelniacz($object->getData('dlugosc_rozpatrywania'), 'dzień', 'dni', 'dni') ?></p>
                    </li>
                </ul>

            </div>
        </div>

        <div class="col-lg-10 objectMain">

            <div class="object">

                <? if ($parts = $object->getLayer('html')) { ?>
                    <div class="block-group">
                        <? foreach ($parts as $part) { ?>

                            <div class="block">
                                <div class="block-header">
                                    <h2 class="label"><?= $part['title'] ?></h2>
                                </div>
                                <div class="content textBlock">
                                    <?= $part['content'] ?>
                                </div>
                            </div>

                        <? } ?>
                    </div>
                <? } ?>

                <div class="well well-sm">
                    Źródło:
                    <a href="http://orzeczenia.nsa.gov.pl/">
                        orzeczenia.nsa.gov.pl
                    </a>
                </div>

            </div>
        </div>

    </div>

<?= $this->Element('dataobject/pageEnd'); ?>