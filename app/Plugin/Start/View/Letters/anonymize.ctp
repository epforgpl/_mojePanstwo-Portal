<?php
$this->Combinator->add_libs('css', $this->Less->css('letters', array('plugin' => 'Start')));
$this->Combinator->add_libs('css', $this->Less->css('dataobject', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('letters-responses', array('plugin' => 'Start')));

$accessDict = array(
    'prywatne',
    'publiczne'
);
$href_base = '/moje-pisma/' . $pismo['alphaid'] . ',' . $pismo['slug'];

$share_url = 'https://mojepanstwo.pl/dane/pisma/' . $pismo['numeric_id'];
if ($pismo['object_id']) {
    $share_url = 'https://mojepanstwo.pl/dane/' . $pismo['page_dataset'] . '/' . $pismo['page_object_id'] . ',' . $pismo['page_slug'] . '/pisma/' . $pismo['numeric_id'];
}

$this->Combinator->add_libs('js', 'Start.rangy/rangy-core.js');
$this->Combinator->add_libs('js', 'Start.rangy/rangy-classapplier.js');
$this->Combinator->add_libs('js', 'Start.rangy/rangy-textrange.js');
$this->Combinator->add_libs('js', 'Start.rangy/rangy-highlighter.js');
$this->Combinator->add_libs('js', 'Start.letters-anonymize.js');
?>
<?php // $this->Combinator->add_libs('js', 'Start.letters-social-share.js') ?>

<?
echo $this->Html->css($this->Less->css('app'));

echo $this->element('headers/main');
echo $this->element('app/sidebar');
?>

<div class="app-content-wrap">
    <div class="objectsPage">

        <?= $this->element('letters/header') ?>

        <?= $this->element('letters/menu', array(
            'plugin' => 'Start',
            'active' => 'anonymize',
        )); ?>

        <div class="container">

            <div class="row">
                <div class="col-md-9">
                    <div class="col-xs-12 alert alert-info margin-top-15 margin-sides-20">
                        <p>Zaznacz fragmenty pisma, których nie chcesz ujawnić publicznie. Wciśnij na wyciemnione polę
                            aby ponownie były widoczne.<br/>Gdy będziesz gotowy, naciśnij
                            przycisk "Anonimizuj i publikuj pismo" na dole ekranu.</p>
                    </div>

                    <form id="anonimizePublicForm" method="post" class="margin-sides-20"
                          action="/moje-pisma/<?= $pismo['alphaid'] . ',' . $pismo['slug'] ?>">
                        <fieldset>
                            <div class="block col-xs-12">
                                <section class="content text anonymize">
                                    <? echo $pismo['content']; ?>
                                </section>
                            </div>
                        </fieldset>
                        <div class="text-center col-xs-12">
                            <a href="/moje-pisma/<?= $pismo['alphaid'] . ',' . $pismo['slug'] ?>"
                               class="btn btn-default">Anuluj</a>
                            <input type="hidden" name="is_public" value="1"/>
                            <input type="hidden" name="save" value="1"/>
                            <input type="hidden" name="public_content" id="public_content_input" value=""/>
                            <button type="button" name="save"
                                    class="btn btn-md btn-success btn-icon anonimizePublicBtn"><i
                                    class="icon glyphicon glyphicon-ok"></i>Anonimizuj i publikuj pismo
                            </button>
                        </div>
                    </form>

                </div>
                <div class="col-md-3">
                    <?= $this->element('letters/side', array('plugin' => 'Start',)); ?>
                </div>
            </div>

        </div>
    </div>
</div>


<?= $this->element('Start.pageEnd'); ?>
