<?

$this->Combinator->add_libs('css', $this->Less->css('collections-view', array('plugin' => 'Start')));

$this->Combinator->add_libs('css', $this->Less->css('dataobject', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('dataobjectpage', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('DataBrowser', array('plugin' => 'Dane')));
$this->Combinator->add_libs('js', 'Dane.DataBrowser.js');

$accessDict = array(
    'prywatna',
    'publiczna'
);

?>

<div class="container">
    <div class="objectsPage">

        <div class="row">

            <div class="col-md-8">

        <header class="collection-header">

            <ul class="breadcrumb">
                <li><a href="<?= $object->getUrl(); ?>/kolekcje">Kolekcje <?= $object->getTitle(); ?></a></li>
                <li class="active">Kolekcja <?= $item->getData('nazwa') ?></li>
            </ul>

            <div class="overflow-auto">

                <div class="content pull-left">
                    <span class="object-icon icon-datasets-kolekcje"></span>
                    <div class="object-icon-side">
                        <h2><?= $item->getData('nazwa') ?></h2>
                    </div>
                </div>
            </div>
        </header>


        <ul class="collection-meta margin-top-10">
            <li>
                Kolekcja <?= $accessDict[$item->getData('is_public')] ?>
            </li>
            <? if($item->getData('object_id')) { ?>
                <li>Redakcja: <a href="<?= $object->getUrl() ?>"><?= $object->getTitle() ?></a></li>
            <? } ?>
        </ul>

        <? $note = $item->getData('description'); ?>
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

        <div class="block block-simple col-sm-12 margin-top-20 collectionObjects" data-collection-id="<?= $item->getId() ?>">

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
                            'id' => $item->getId(),
                        ),
                    ),
                )); ?>
            </div>

        </div>
            </div>
        </div>
    </div>
</div>
