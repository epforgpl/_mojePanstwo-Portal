<?php //$this->Combinator->add_libs('css', $this->Less->css('dataobjectslider', array('plugin' => 'Dane'))) ?>
<?php $this->Combinator->add_libs('css', $this->Less->css('view-sejmposiedzeniapunkty', array('plugin' => 'Dane'))); ?>

<?php echo $this->Element('dataobject/pageBegin'); ?>
    <div class="object">

        <div class="col-md-6 nopadding">

            <? if ($object->getData('opis')) { ?>

                <div class="block">
                    <div class="block-header">
                        <h2 class="label">Wynik obrad:</h2>
                    </div>
                    <div class="content textBlock">
                        <?= $object->getData('opis'); ?>
                    </div>
                </div>

            <? } ?>

            <? if (($debaty = $object->getRelatedGroup('debaty')) && ($debaty = $debaty['objects'])) { ?>

                <div class="block">
                    <div class="block-header">
                        <h2 class="label">Debaty:</h2>
                    </div>
                    <div class="content nopadding">
                        <ul class="block-list">
                            <? foreach ($debaty as $debata) { ?>
                                <li>

                                    <? $this->Dataobject->setObject($debata); ?>

                                    <div class="objectRender">
                                        <div class="row">

                                            <div class="formatDate col-md-2 dimmed">
                                                <?php echo($this->Dataobject->getDate()); ?>
                                            </div>

                                            <div class="data col-md-10">
                                                <div class="row">

                                                    <div class="content">

                                                        <p class="title"><a
                                                                href="/dane/sejm_posiedzenia_punkty/<?= $object->getId() ?>,<?= $object->getSlug() ?>/debaty/<?= $debata->getId() ?>">Część
                                                                #<?= $debata->getData('punkt_i') ?></a></p>

                                                        <div class="aoverflow">
                                                            <p class="img-debata">
                                                                <img onerror="imgFixer(this)"
                                                                     src="http://resources.sejmometr.pl/stenogramy/subpunkty/<?= $debata->getId() ?>.jpg"/>
                                                            </p>

                                                            <p class="debata-stats">
                                                                <? if ($debata->getData('liczba_wystapien')) { ?>Liczba wystąpień:
                                                                    <strong><?= $debata->getData('liczba_wystapien') ?></strong><? } ?>
                                                                <br/>
                                                                <? if ($debata->getData('liczba_glosowan')) { ?>Liczba głosowań:
                                                                    <strong><?= $debata->getData('liczba_glosowan') ?></strong><? } ?>
                                                            </p>
                                                        </div>

                                                    </div>

                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                </li>
                            <? } ?>
                        </ul>
                    </div>
                </div>

            <? } ?>

        </div>
        <div class="col-md-6 nopadding">

            <? if (($druki = $object->getRelatedGroup('druki')) && ($druki = $druki['objects'])) { ?>

                <div class="block">
                    <div class="block-header">
                        <h2 class="label">Powiązane druki sejmowe:</h2>
                    </div>
                    <div class="content" style="padding: 0 10px !important;">
                        <ul class="block-list">
                            <? foreach ($druki as $druk) { ?>
                                <li>
                                    <? echo $this->Dataobject->render($druk, 'default-nodate'); ?>
                                </li>
                            <? } ?>
                        </ul>
                    </div>
                </div>

            <? } ?>

        </div>

    </div>
<?php echo $this->Element('dataobject/pageEnd'); ?>
