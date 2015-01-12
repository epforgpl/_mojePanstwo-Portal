<?php $this->Combinator->add_libs('css', $this->Less->css('htmlexDocMain_v1')); ?>
<?php $this->Combinator->add_libs('css', $this->Less->css('htmlexDoc', array('plugin' => 'Dane'))); ?>
<?php $this->Combinator->add_libs('css', $this->Less->css('view-sejminterpelacje', array('plugin' => 'Dane'))); ?>

<?php $this->Combinator->add_libs('js', 'toolbar'); ?>

<?= $this->Element('dataobject/pageBegin'); ?>

    <div class="object">

        <?php if (empty($teksty) && $wydarzenie['dokument_id']) { ?>
            <?php echo $this->Html->css($document->getCSSLocation()); ?>

            <div class="htmlexDoc sejmInterpelacje" data-packages="<?php echo $document->getPackagesCount(); ?>"
                 data-current-package="<?php echo $documentPackage; ?>"
                 data-pages="<?php echo $document->getPagesCount(); ?>"
                 data-document-id="<?php echo $document->getId(); ?>">

                <?=
                $this->Element('toolbar', array(
                    'left_column_width' => 9,
                    'right_column_width' => 3,
                )); ?>

                <div class="document container">
                    <div class="row">
                        <div class="content col-md-9">
                            <div class="canvas">
                                <?php echo $document->loadHtml($documentPackage); ?>
                            </div>
                            <div class="loadMoreDocumentContent <?php if ($document->getPackagesCount() > 1) {
                                echo 'show';
                            } else {
                                echo 'hide';
                            } ?>"></div>
                        </div>

                        <? if (!empty($wydarzenia) && is_array($wydarzenia)) { ?>
                            <div class="sidebox col-md-3">
                                <ul class="tables">
                                    <?php foreach ($wydarzenia as $t) { ?>
                                        <li class="<?php if ($wydarzenie['id'] == $t['id']) { ?>s<?php } ?>">
                                            <a href="/dane/sejm_interpelacje/<?= $object->getId() ?>/<?= $t['id'] ?>">
                                                <p class="nazwa"><?php echo $t['nazwa']; ?></p>

                                                <div class="desc">
                                                    <?php if ($t['autor_str']) { ?><p>
                                                        <span
                                                            class="l">Od:</span> <span
                                                            class="v"><?php echo $t['autor_str']; ?></span>
                                                        </p><?php } ?>
                                                    <?php if ($t['adresaci_str']) { ?><p>
                                                        <span
                                                            class="l">Do
                                                    :</span> <span
                                                            class="v"><?php echo $t['adresaci_str']; ?></span>
                                                        </p><?php } ?>
                                                    <?php if ($t['data'] != '0000-00-00') { ?>
                                                        <p>
                                                        <span
                                                            class="l"><?= __d('dane', 'LC_DANE_DATA_WPLYWU') ?>:</span> <span
                                                            class="v"><?= $this->Czas->dataSlownie($t['data']); ?></span>
                                                        </p><?php } ?>
                                                    <?php if ($t['data_ogloszenia'] != '0000-00-00') { ?>
                                                        <p><span
                                                            class="l"><?= __d('dane', 'LC_DANE_DATA_OGLOSZENIA') ?>
                                                            :</span> <span
                                                            class="v"><?= $this->Czas->dataSlownie($t['data_ogloszenia']); ?></span>
                                                        </p><?php } ?>
                                                </div>
                                            </a>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        <? } ?>
                    </div>
                </div>
            </div>
        <?php } else { ?>
            <div class="htmlexDoc nominheight">
                <div class="document">
                    <div class="content col-md-9">
                        <?php foreach ($teksty as $t) { ?>
                            <div class="block">

                                <div class="block-header">
                                    <? if ($wydarzenie['typ_id'] == 1 || $wydarzenie['typ_id'] == 3) {
                                        ?>
                                        <h2 class="label">
                                            <small>Do:</small> <?php echo $t['funkcja_nazwa']; ?></h2>
                                    <? } elseif ($wydarzenie['typ_id'] == 2 || $wydarzenie['typ_id'] == 4) { ?>
                                        <h2 class="label">
                                            <small>Od:</small> <?php echo $wydarzenie['autor_str']; ?></h2>
                                    <? } ?>
                                </div>

                                <div class="content textBlock">
                                    <?php echo $t['html']; ?>
                                </div>

                            </div>
                        <?php } ?>
                    </div>
                    <div class="row sidebox col-md-3">
                        <ul class="tables">
                            <?php foreach ($wydarzenia as $t) { ?>
                                <li<?php if ($wydarzenie['id'] == $t['id']) { ?> class="s"<?php } ?>>
                                    <a href="/dane/sejm_interpelacje/<?= $object->getId() ?>/<?= $t['id'] ?>">
                                        <p class="nazwa"><?php echo $t['nazwa']; ?></p>

                                        <div class="desc">
                                            <?php if ($t['autor_str']) { ?><p><span
                                                    class="l">Od:</span> <span
                                                    class="v"><?php echo $t['autor_str']; ?></span>
                                                </p><?php } ?>
                                            <?php if ($t['adresaci_str']) { ?><p><span
                                                    class="l">Do:</span> <span
                                                    class="v"><?php echo $t['adresaci_str']; ?></span>
                                                </p><?php } ?>
                                            <?php if ($t['data'] != '0000-00-00') { ?>
                                                <p>
                                                <span
                                                    class="l"><?= __d('dane', 'LC_DANE_DATA_WPLYWU') ?>:</span> <span
                                                    class="v"><?= $this->Czas->dataSlownie($t['data']); ?></span>
                                                </p><?php } ?>
                                            <?php if ($t['data_ogloszenia'] == '0000-00-00') { ?>
                                                <p>
                                                <span
                                                    class="l"><?= __d('dane', 'LC_DANE_DATA_OGLOSZENIA') ?>
                                                    :</span> <span
                                                    class="v"><?= $this->Czas->dataSlownie($t['data_ogloszenia']); ?></span>
                                                </p><?php } ?>
                                        </div>
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
        <?php } ?>

    </div>

<?= $this->Element('dataobject/pageEnd'); ?>