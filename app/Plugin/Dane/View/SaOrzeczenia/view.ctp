<?php $this->Combinator->add_libs('css', $this->Less->css('view-saorzeczenia', array('plugin' => 'Dane'))); ?>

<?= $this->Element('dataobject/pageBegin'); ?>
    <div class="col-xs-12 col-md-2 objectSide">
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

    <div class="col-md-10 objectMain">
            <div class="object">

                <? if ($parts = $object->getLayer('html')) { ?>
                    <? foreach ($parts as $part) { ?>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"><?= $part['title'] ?></h3>
                            </div>
                            <div class="panel-body">
                                <?= $part['content'] ?>
                            </div>
                            <div class="panel-footer">Źródło: <a
                                    href="http://orzeczenia.nsa.gov.pl/doc/<?= $object->getData('sa_orzeczenia.nsa_id'); ?>">
                                    orzeczenia.nsa.gov.pl/doc/<?= $object->getData('sa_orzeczenia.nsa_id'); ?>
                                </a>
                            </div>
                        </div>
                    <? } ?>
                <? } ?>
            </div>
        </div>

<?= $this->Element('dataobject/pageEnd'); ?>