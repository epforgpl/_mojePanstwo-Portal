<?php $this->Combinator->add_libs('css', $this->Less->css('htmlexDocMain_v1')); ?>
<?php $this->Combinator->add_libs('css', $this->Less->css('htmlexDoc', array('plugin' => 'Dane'))); ?>
<?php $this->Combinator->add_libs('css', $this->Less->css('view-sejminterpelacje', array('plugin' => 'Dane'))); ?>

<?php $this->Combinator->add_libs('js', 'toolbar'); ?>

<?= $this->Element('dataobject/pageBegin', array(
    'titleTag' => 'p',
)) ?>

    <div class="row">
        <div class="col-md-3 dataFeed">

            <div class="object">
                <? echo $this->Element('Dane.DataFeed/feed-min'); ?>
            </div>

        </div>
        <div class="col-md-9">

            <?
            if (!($pismo->getLayer('teksty')) && $pismo->getData('dokument_id')) {

                echo $this->Document->place($pismo->getData('dokument_id'));

            } else {
                ?>

                <? foreach ($pismo->getLayer('teksty') as $tekst) { ?>
                    <div class="block" style="margin: 20px 0;">
                        <div class="block-header">
                            <h2 class="label"><?= $pismo->getData('nazwa') ?></h2>
                        </div>
                        <div class="content" style="margin: 25px;">
                            <?= $tekst['html'] ?>
                        </div>
                    </div>
                <? } ?>

            <? } ?>


        </div>
    </div>

<?= $this->Element('dataobject/pageEnd'); ?>