<?
$this->Combinator->add_libs('css', $this->Less->css('htmlexDocMain_v2'));
$this->Combinator->add_libs('css', $this->Less->css('doc'));
$this->Combinator->add_libs('js', 'Docs/attachment');
$this->Combinator->add_libs('css', $this->Less->css('Docs/attachment'));
?>

<div class="navbar navbar-fixed-top ">
    <div class="middle nav navbar-nav navbar-right">
        <div class="docs-toolbar" role="toolbar">
            <button type="button" class="btn btn-lg btn-primary add_vertical"><span
                    class="glyphicon glyphicon-plus"></span><span
                    class="btn-counter line_counter">0</span></button>
            <button type="button" class="btn btn-lg btn-primary calculate_fields"><span
                    class="glyphicon glyphicon-list"></span></button>
            <button type="button" class="btn btn-lg btn-success save-doc"><span
                    class="glyphicon glyphicon-ok"></span></button>
            <button type="button" class="btn btn-lg btn-danger cancel-changes"><span
                    class="glyphicon glyphicon-remove"></span></button>
        </div>
    </div>
</div>

<div class="container">

    <div class="col-sm-6"><h1><?= $doc['Document']['filename'] ?></h1></div>
    <div class="col-sm-6"><h1>ID: <?= $doc['Document']['id'] ?></h1></div>

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
                            href="http://mojepanstwo.pl/htmlex/<?= $doc['Document']['id'] ?>/<?= $doc['Document']['id'] ?>.css"
                            target="_blank">LINK</a></p>
                </li>
                <li>
                    <p class="_label">Source</p>

                    <p class="_value"><a href="<?= $doc['Document']['url'] ?>" target="_blank">LINK</a></p>
                </li>
            </ul>

        </div>
        <div class="col-md-10 objectsPageContent">

            <div style="overflow: hidden !important;">
            <?= $xml ?>
                <div style="clear:both;"></div>
            </div>
        </div>

    </div>
</div>
