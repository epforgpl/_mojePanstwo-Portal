<?= $this->Element('dataobject/pageBegin'); ?>
<div class="object">
    <div class="document col-md-10 col-md-offset-1">
        <div class="block-group">

            <?php foreach ($object->getLayer('bloki') as $blok) { ?>

                <div class="block">

                    <div class="block-header">
                        <h2 class="label"><?php echo $blok['orzeczenia_bloki']['tytul']; ?></h2>
                    </div>

                    <div class="content">
                        <?php echo $blok['orzeczenia_bloki']['wartosc']; ?>
                    </div>

                </div>
            <?php } ?>

            <div class="well well-sm text-center">
                Źródło:
                <a href="http://orzeczenia.ms.gov.pl/details/<?= $object->getData('sp_orzeczenia.str_ident'); ?>">
                    orzeczenia.ms.gov.pl/details/<?= $object->getData('sp_orzeczenia.str_ident'); ?>
                </a>
            </div>
        </div>
    </div>
<?= $this->Element('dataobject/pageEnd'); ?>