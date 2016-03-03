<?
$this->Combinator->add_libs('js', 'Admin.doctable');
?><!DOCTYPE HTML>
<html lang="en">
<head>
    <title>Document Tables</title>
    <?= $this->Html->css('../libs/bootstrap/3.3.4/css/bootstrap.min.css'); ?>
    <?= $this->Html->css($this->Less->css('docs-tables', array('plugin' => 'Admin'))); ?>
</head>
<body>
<div class="doctable"
     data-tables="<?= htmlspecialchars(json_encode($tables)) ?>"
     data-tables-data="<?= htmlspecialchars(json_encode($tablesData)) ?>"
     data-document-id="<?= $document_id ?>"
     data-doc="<?= htmlspecialchars($docJSON) ?>">
    <div class="preview"></div>
    <div class="toolbar">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <button type="button" class="btn btn-sm btn-primary saveDocTables">
                        Zapisz
                    </button>
                    <button type="button" class="btn btn-sm btn-default exportDocTables">
                        Pobierz
                    </button>
                    <button type="button" class="btn btn-sm btn-default importDocTables">
                        Wczytaj
                    </button>
                    <button type="button" class="btn btn-sm btn-default increaseTextFont">
                        +
                    </button>
                    <button type="button" class="btn btn-sm btn-default decreaseTextFont">
                        -
                    </button>
                    <div class="btn-group pull-right viewSelect" data-toggle="buttons">
                        <label class="btn btn-sm btn-default active">
                            <input type="radio" name="view" value="document" autocomplete="off" checked> Dokument
                        </label>
                        <label class="btn btn-sm btn-default">
                            <input type="radio" name="view" value="data" autocomplete="off"> Dane
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<a id="forceDownloadFile"></a>
<input type="file" accept=".json" id="importLocalFile"/>
<?= $this->Html->script('../libs/jquery/2.1.4/jquery-2.1.4.min.js') ?>
<?= $this->Html->script('../libs/bootstrap/3.3.4/js/bootstrap.min.js') ?>
<?= $this->Combinator->scripts('js') ?>
</body>
</html>
