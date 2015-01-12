<?php $this->Combinator->add_libs('css', $this->Less->css('view-sejminterpelacje', array('plugin' => 'Dane'))); ?>
<?php $this->Combinator->add_libs('js', 'toolbar'); ?>

<?= $this->Element('dataobject/pageBegin'); ?>

    <div class="row">
        <div class="col-md-3 objectSide">

            <div class="objectSideInner">
                <ul class="dataHighlights side">

                    <li class="dataHighlight -block">
                        <p class="_label">Autor interpelacji:</p>

                        <p class="_value"><?= str_replace(',', '<br/>', $object->getData('poslowie_str')) ?></p>
                    </li>

                    <li class="dataHighlight -block">
                        <p class="_label">Adresat:</p>

                        <p class="_value"><?= str_replace(',', '<br/>', $object->getData('adresaci_str')) ?></p>
                    </li>

                </ul>
            </div>

        </div>
        <div class="col-md-9">
            <div class="object">
                <?= $this->dataobject->feed($feed); ?>
            </div>
        </div>
    </div>

<?= $this->Element('dataobject/pageEnd'); ?>