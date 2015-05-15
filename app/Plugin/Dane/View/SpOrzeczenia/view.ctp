<?php $this->Combinator->add_libs('css', $this->Less->css('view-sporzeczenia', array('plugin' => 'Dane'))); ?>

<?= $this->Element('dataobject/pageBegin'); ?>
    <div class="object">
        <div class="document col-xs-12 col-md-8">
            <?php foreach ($object->getLayer('bloki') as $blok) { ?>
                <div class="panel panel-default">
                    <?php if (isset($blok['orzeczenia_bloki']['tytul']) && $blok['orzeczenia_bloki']['tytul']) { ?>
                        <div class="panel-heading">
                            <h3 class="panel-title"><?php echo $blok['orzeczenia_bloki']['tytul']; ?></h3>
                        </div>
                    <?php } ?>
                    <div class="panel-body">
                        <?php echo $blok['orzeczenia_bloki']['wartosc']; ?>
                    </div>
                    <div class="panel-footer">Źródło: <a
                            href="http://orzeczenia.ms.gov.pl/details/<?= $object->getData('sp_orzeczenia.str_ident'); ?>">
                            orzeczenia.ms.gov.pl/details/<?= $object->getData('sp_orzeczenia.str_ident'); ?>
                        </a>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
<?= $this->Element('dataobject/pageEnd'); ?>