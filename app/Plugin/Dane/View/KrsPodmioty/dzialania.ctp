<?
echo $this->Element('dataobject/pageBegin');

$this->Combinator->add_libs('css', $this->Less->css('dataobjectslider', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('view-krspodmioty', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('view-dzialania', array('plugin' => 'Dane')));
$this->Combinator->add_libs('js', 'Dane.view-krspodmioty');
?>

<div class="krsPodmioty">
    <div class="col-md-9 objectMain">
        <div class="object">
            <div class="block block-simple col-xs-12 dzialanie">
                <header><?= $dzialanie->getData('tytul'); ?></header>

                <? if($dzialanie->getData('photo') == '1') { ?>
                    <div class="photo">
                        <img alt="<?= $dzialanie->getData('tytul'); ?>" src="http://sds.tiktalik.com/portal/pages/dzialania/<?= $dzialanie->getData('dataset'); ?>/<?= $dzialanie->getData('object_id'); ?>/<?= $dzialanie->getData('id'); ?>.jpg"/>
                    </div>
                <? } ?>

                <p class="opis">
                    <?= nl2br($dzialanie->getData('opis')); ?>
                </p>
            </div>
        </div>
    </div>
</div>

<?= $this->Element('dataobject/pageEnd'); ?>