<?php
$this->Combinator->add_libs('css', $this->Less->css('letters', array('plugin' => 'Start')));
$this->Combinator->add_libs('css', $this->Less->css('letter-anonymize', array('plugin' => 'Start')));
$this->Combinator->add_libs('css', $this->Less->css('letter', array('plugin' => 'Start')));
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

                    <div>
                        <div class="col-xs-12 alert alert-info margin-top-30">
                            <p>Zaznacz fragmenty pisma, których nie chcesz ujawnić publicznie. Wciśnij na wyciemnione
                                polę
                                aby ponownie były widoczne.<br/>Gdy będziesz gotowy, naciśnij
                                przycisk "Anonimizuj i publikuj pismo" na dole ekranu.</p>
                        </div>
                    </div>

                    <form id="anonimizePublicForm" method="post"
                          action="/moje-pisma/<?= $pismo['alphaid'] . ',' . $pismo['slug'] ?>">
                        <div class="block">
                            <section class="content">
                                <div class="letter-render">
                                    <div class="row" style="margin-bottom: 20px;">
                                        <div class="col-md-8">
                                            <div class="nadawca"><?= nl2br($pismo['from_str']); ?></div>
                                        </div>
                                        <div class="col-md-4">
                                            <?
                                            $parts = array();
                                            if ($pismo['miejscowosc'])
                                                $parts[] = $pismo['miejscowosc'];
                                            if ($pismo['data_pisma'])
                                                $parts[] = dataSlownie($pismo['data_pisma'], array(
                                                    'relative' => false,
                                                ));
                                            ?>

                                            <div class="miejsce_data"><?= implode(', ', $parts) ?></div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-5 col-md-offset-7">
                                            <div class="adresat"><?= $pismo['to_str']; ?></div>
                                        </div>
                                    </div>
                                    <h2 class="tytul"><?= $pismo['title']; ?></h2>
                                    <div class="tresc anonymize"><?= $pismo['content']; ?></div>
                                    <div class="row">
                                        <div class="col-md-5 col-md-offset-7">
                                            <div class="podpis"><?= nl2br($pismo['podpis']); ?></div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                        <div class="row margin-top-20">
                            <div class="col-md-12">
                                <div class="text-center">
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
                            </div>
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
