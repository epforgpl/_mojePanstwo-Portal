<?
echo $this->Element('dataobject/pageBegin');

$this->Combinator->add_libs('css', $this->Less->css('dataobjectslider', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('view-krspodmioty', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('view-dzialania', array('plugin' => 'Dane')));
$this->Combinator->add_libs('js', 'Dane.view-krspodmioty');
#$this->Combinator->add_libs('js', 'Dane.view-krspodmioty-dzialania');
?>

<div class="krsPodmioty">
    <div class="col-md-9 objectMain">
        <div class="object">
            <div class="block block-simple col-xs-12 dzialanie">
                <? if($object_editable) { ?>
                    <header>
                        <div class="row">
                            <div class="col-sm-8">
                                <?= $dzialanie->getData('tytul'); ?>
                            </div>
                            <div class="col-sm-4 text-right">
                                <a href="<?= $object->getUrl() ?>/dzialania/<?= $dzialanie->getData('id') ?>/edytuj">
                                    <div class="btn btn-sm btn-primary btn-icon btn-auto-width">
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

                <div class="row sub-header">
                    <div class="col-sm-6">
                        <span class="date">
                            <span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
                            <?= $this->Czas->dataSlownie(
                                $dzialanie->getData('data_utworzenia')
                            ); ?>
                        </span>
                    </div>
                    <div class="col-sm-6">
                        <div class="share pull-right"></div>
                    </div>
                </div>

                <? if($dzialanie->getData('photo') == '1') { ?>
                    <div class="photo">
                        <img alt="<?= $dzialanie->getData('tytul'); ?>" src="http://sds.tiktalik.com/portal/1/pages/dzialania/<?= $dzialanie->getData('id'); ?>.jpg"/>
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