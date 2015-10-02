<?

$this->Combinator->add_libs('css', $this->Less->css('view-krspodmioty', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('view-krspodmioty-dzialania', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('view-dzialania', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('view-krspodmioty-dane', array('plugin' => 'Dane')));

/* tinymce */
echo $this->Html->script('../plugins/tinymce/js/tinymce/tinymce.min', array('block' => 'scriptBlock'));

/* page script */
$this->Combinator->add_libs('js', 'Dane.view-krspodmioty-dane');

$page = $object->getLayer('page');

$description =
    (isset($page['description']) && strlen($page['description']) > 0)
        ? $page['description'] : $object->getData('cel_dzialania');

echo $this->Element('dataobject/pageBegin'); ?>

<form class="dzialanie" action="<?= $object->getUrl(); ?>.json" method="post">

    <input type="hidden" name="_action" value="save_edit_data_form"/>

    <div class="row">
        <div class="col-md-12">
            <header>
                Edytuj dane <?= $object->getDataset() == 'krs_podmioty' ? 'organizacji' : 'urzędu gminy'; ?>
            </header>
        </div>
    </div>

    <div class="row">
        <div class="col-md-9">

            <div class="block block-simple col-xs-12 dzialanie objectMain">
                <section>
                    <div class="row">
                        <div class="col-xs-12">

                            <? if($object->getDataset() == 'krs_podmioty') { ?>
                                <div class="form-group">
                                    <label for="descriptionTextArea">Misja:</label>
                                    <textarea name="description" id="descriptionTextArea" class="form-control"><?= $description ?></textarea>
                                </div>

                                <div class="form-group margin-top-30">
                                    <label>Obszar działania:</label>

                                    <?

                                        $obszary = $object->getPage('obszary_dzialan') ? $object->getPage('obszary_dzialan') : array();
                                        $obszary_ids = array_column($obszary, 'id');

                                    foreach(array(
                                        'działalność charytatywna',
                                        'pomoc społeczna',
                                        'ochrona praw obywatelskich i praw człowieka',
                                        'rozwój przedsiębiorczości',
                                        'nauka, kultura, edukacja',
                                        'ekologia',
                                        'działalność międzynarodowa',
                                        'aktywność społeczna',
                                        'sport, turystyka',
                                        'bezpieczeństwo publiczne',
                                        'inne'
                                    ) as $i => $field) { ?>
                                        <div>
                                            <label>
                                                <input name="areas[]" type="checkbox" value="<?= ($i + 1) ?>" <? if(in_array($i + 1, $obszary_ids)) echo 'checked'; ?>>
                                                <?= ucfirst($field) ?>
                                            </label>
                                        </div>
                                    <? } ?>

                                </div>

                            <? } ?>

                            <div class="form-group margin-top-<?= ($object->getDataset() == 'krs_podmioty') ? 30 : 0; ?>">
                                <label for="phoneNumber">Numer telefonu:</label>
                                <input maxlength="195" type="text" class="form-control" id="phoneNumber" name="phone" <? if($object->getPage('phone')) echo 'value="'.$object->getPage('phone').'"'; ?>/>
                            </div>

                            <div class="form-group margin-top-10">
                                <label for="emailAddress">Adres e-mail:</label>
                                <input maxlength="195" type="text" class="form-control" id="emailAddress" name="email" <? if($object->getPage('email')) echo 'value="'.$object->getPage('email').'"'; ?>/>
                            </div>

                            <div class="form-group margin-top-10">
                                <label for="www">Adres strony WWW:</label>
                                <input maxlength="195" type="text" class="form-control" id="www" name="www" <? if($object->getPage('www')) echo 'value="'.$object->getPage('www').'"'; ?>/>
                            </div>

                            <h4 class="text-muted margin-top-30">
                                Konta na portalach społecznościowych
                            </h4>

                            <? foreach(array(
                                'facebook',
                                'twitter',
                                'instagram',
                                'youtube',
                                'vine'
                            ) as $i => $field) { ?>
                                <div class="form-group margin-top-10">
                                <label for="<?= $field ?>">Profil <?= ucfirst($field) ?>:</label>
                                <input maxlength="195" type="text" class="form-control" id="<?= $field ?>" name="<?= $field ?>" <? if($object->getPage($field)) echo 'value="'.$object->getPage($field).'"'; ?>/>
                                </div>
                            <? } ?>

                        </div>
                    </div>
                </section>
            </div>

        </div>
        <div class="col-md-3">
            <div class="sticky margin-top-20">
                <div class="row">
                    <div class="col-md-12 margin-top-10">

                        <button class="btn auto-width btn-primary btn-icon submitBtn" type="submit">
                            <i class="icon glyphicon glyphicon-ok"></i>
                            Zapisz
                        </button>

                        <? if($object->getDataset() == 'krs_podmioty') { ?>
                            <br/>
                            <div data-opis="<?= $object->getData('cel_dzialania') ?>" class="btn auto-width btn-link btn-icon btnImport margin-top-5">
                                <i class="icon glyphicon glyphicon-download"></i>
                                Zaimportuj z KRS
                            </div>
                        <? } ?>

                    </div>
                </div>
            </div>
        </div>
    </div>

</form>


<?= $this->element('dataobject/pageEnd'); ?>
