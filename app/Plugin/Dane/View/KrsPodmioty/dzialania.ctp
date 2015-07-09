<?
echo $this->Element('dataobject/pageBegin');

$this->Combinator->add_libs('css', $this->Less->css('dataobjectslider', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('view-krspodmioty', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('view-dzialania', array('plugin' => 'Dane')));
$this->Combinator->add_libs('js', 'Dane.view-krspodmioty');
$this->Combinator->add_libs('js', 'Dane.view-krspodmioty-dzialania');
?>

<div class="krsPodmioty">
    <div class="col-md-9 objectMain">
        <div class="object">
            <div class="block block-simple col-xs-12 dzialanie">
                <? if($object_editable) { ?>
                    <header>
                        <div class="header">
                            <div class="col-sm-8">
                                <?= $dzialanie->getData('tytul'); ?>
                            </div>
                            <div class="col-sm-4 text-right">
                                <div class="btn btn-danger btn-icon btn-auto-width" data-action="delete" data-id="<?= $dzialanie->getData('id'); ?>">
                                    <i class="icon glyphicon glyphicon-remove"></i>
                                    Usuń
                                </div>
                                <a href="/dane/krs_podmioty/<?= $object->getId(); ?>/dzialania_edycja/<?= $dzialanie->getData('id'); ?>">
                                    <div class="btn btn-primary btn-icon btn-auto-width">
                                        <i class="icon glyphicon glyphicon-pencil"></i>
                                        Edytuj
                                    </div>
                                </a>
                            </div>
                        </div>
                    </header>
                <? } else { ?>
                    <header><?= $dzialanie->getData('tytul'); ?></header>
                <? } ?>

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