<?
echo $this->Element('dataobject/pageBegin');
?>

    <div class="row margin-top-20">
        <div class="col-sm-9">

            <? if($object->getData('user_username')) { ?>
                <div class="row">
                    <div class="col-sm-2">
                        <p class="_label">Dodano przez:</p>
                    </div>
                    <div class="col-sm-10">
                        <p>
                            <a title="Profil użytkownika <?= $object->getData('user_username') ?>" href="/dane/uzytkownicy/<?= $object->getData('user_id') ?>">
                                <?= $object->getData('user_username') ?>
                            </a>
                        </p>
                    </div>
                </div>
            <? } ?>

            <? $note = $object->getData('description'); ?>
            <div class="collection-main-note alert alert-info overflow-hidden note-editable<?= $note == '' ? ' empty' : '' ?>">
                <? if($note == '') { ?>
                    <p class="text-center">
                        Brak notatki
                    </p>
                <? } else { ?>
                    <div class="content">
                        <?= $note ?>
                    </div>
                <? } ?>
            </div>

            <div class="block block-simple col-sm-12 margin-top-10 collectionObjects" data-collection-id="<?= $object->getId() ?>">

                <div class="row collections-browser">
                    <?= $this->element('Dane.DataBrowser/browser-content', array(
                        'displayAggs' => false,
                        'app_chapters' => false,
                        'forceHideAggs' => true,
                        //'beforeItemElement' => 'Start.DataBrowser/collection-before',
                        //'afterItemElement' => 'Start.DataBrowser/collection-after',
                        'paginatorPhrases' => array('dokument', 'dokumenty', 'dokumentów'),
                        'noResultsPhrase' => 'Kolekcja jest pusta',
                        'nopaging' => true,
                        'innerParams' => array(
                            'collection' => array(
                                'id' => $object->getId(),
                            ),
                        ),
                    )); ?>
                </div>

            </div>

        </div>
    </div>

<?
echo $this->Element('dataobject/pageEnd');
