<?php $this->Combinator->add_libs('css', $this->Less->css('view-saorzeczenia', array('plugin' => 'Dane'))); ?>

<?= $this->Element('dataobject/pageBegin'); ?>

    <div class="col-xs-12 col-md-8 objectMain">
        <div class="object">
            <? if ($parts = $object->getLayer('html')) { ?>

                <? foreach ($parts as $part) { ?>
                    <div class="block">
                        <header><?= $part['title'] ?></header>
                        <section><?= $part['content'] ?></section>
                    </div>
                <? } ?>

                <footer>
                    <a href="http://orzeczenia.nsa.gov.pl/doc/<?= $object->getData('sa_orzeczenia.nsa_id'); ?>">Źródło</a>
                </footer>
            <? } ?>
        </div>
    </div>

<?= $this->Element('dataobject/pageEnd'); ?>