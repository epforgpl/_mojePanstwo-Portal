<?php $this->Combinator->add_libs('css', $this->Less->css('view-sporzeczenia', array('plugin' => 'Dane'))); ?>

<?= $this->Element('dataobject/pageBegin'); ?>
    <div class="col-xs-12 col-md-8 objectMain">
        <div class="object">
            <?php foreach ($object->getLayer('bloki') as $blok) { ?>
                <div class="block col-xs-12">
                    <?php if (isset($blok['orzeczenia_bloki']['tytul']) && $blok['orzeczenia_bloki']['tytul']) { ?>
                        <header><?php echo $blok['orzeczenia_bloki']['tytul']; ?></header>
                    <?php } ?>
                    <section><?php echo $blok['orzeczenia_bloki']['wartosc']; ?></section>
                </div>
                <footer>
                    <a href="http://orzeczenia.ms.gov.pl/details/<?= $object->getData('sp_orzeczenia.str_ident'); ?>">Źródło</a>
                </footer>
            <?php } ?>
        </div>
    </div>
<?= $this->Element('dataobject/pageEnd'); ?>