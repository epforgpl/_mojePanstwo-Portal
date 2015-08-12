<?
$this->Combinator->add_libs('css', $this->Less->css('htmlexDocMain_v2'));
$this->Combinator->add_libs('css', $this->Less->css('doc'));
?>

<div class="container">

    <h1><?= $doc['Document']['filename'] ?></h1>

    <div class="row objectsPage">

        <div class="col-md-2">

            <ul class="fields">
                <li>
                    <p class="_label">Extension</p>

                    <p class="_value"><?= $doc['Document']['fileextension'] ?></p>
                </li>
                <li>
                    <p class="_label">Size</p>

                    <p class="_value"><?= human_filesize($doc['Document']['filesize']) ?></p>
                </li>
                <li>
                    <p class="_label">Pages</p>

                    <p class="_value"><?= $doc['Document']['pages_count'] ?></p>
                </li>
                <li>
                    <p class="_label">Packages</p>

                    <p class="_value"><?= $doc['Document']['packages_count'] ?></p>
                </li>
                <li>
                    <p class="_label">CSS</p>

                    <p class="_value"><a
                            href="http://mojepanstwo/htmlex/<?= $doc['Document']['id'] ?>/<?= $doc['Document']['id'] ?>.css"
                            target="_blank">LINK</a></p>
                </li>
                <li>
                    <p class="_label">Source</p>

                    <p class="_value"><a href="<?= $doc['Document']['url'] ?>" target="_blank">LINK</a></p>
                </li>


            </ul>

        </div>
        <div class="col-md-10 objectsPageContent">

            <div class="row">
                <div class="docs-toolbar" role="toolbar">
                    <button class="btn btn-lg btn-default"><input type="checkbox"></button>
                    <div class="btn-group">
                        <button type="button" class="btn btn-lg btn-default" aria-label="rotate-left"><i
                                class="fa fa-undo"></i></button>
                        <button type="button" class="btn btn-lg btn-default" aria-label="rotate-right"><i
                                class="fa fa-repeat"></i></button>
                    </div>
                    <button type="button" class="btn btn-lg btn-default" aria-label="rotate-right"><span
                            class="glyphicon glyphicon-ok"></span></button>
                    <button type="button" class="btn btn-lg btn-default" aria-label="rotate-right"><span
                            class="glyphicon glyphicon-remove"></span></button>
                </div>
            </div>
            <div class="row">
                <?= $this->Document->place($doc) ?>
            </div>
        </div>

    </div>
</div>
<?
$this->Combinator->add_libs('js', 'Docs/edit');
?>