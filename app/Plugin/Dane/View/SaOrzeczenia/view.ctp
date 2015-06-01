<?php $this->Combinator->add_libs('css', $this->Less->css('view-saorzeczenia', array('plugin' => 'Dane'))); ?>

<?= $this->Element('dataobject/pageBegin'); ?>
    <div class="col-xs-12 col-md-8 objectMain">
        <div class="object">
            <? if ($parts = $object->getLayer('html')) { ?>
                <div class="panel panel-default">
                    <ul class="list-group">
                        <? foreach ($parts as $part) { ?>
                            <li class="list-group-item">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?= $part['title'] ?></h3>
                                </div>
                                <div class="panel-body">
                                    <?= $part['content'] ?>
                                </div>
                            </li>
                        <? } ?>
                    </ul>
                    <div class="panel-footer">Źródło: <a
                            href="http://orzeczenia.nsa.gov.pl/doc/<?= $object->getData('sa_orzeczenia.nsa_id'); ?>">
                            orzeczenia.nsa.gov.pl/doc/<?= $object->getData('sa_orzeczenia.nsa_id'); ?>
                        </a>
                    </div>
                </div>
            <? } ?>
        </div>
    </div>

<?= $this->Element('dataobject/pageEnd'); ?>