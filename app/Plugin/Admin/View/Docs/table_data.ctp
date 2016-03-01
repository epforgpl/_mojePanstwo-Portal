<?
$this->Combinator->add_libs('js', 'Admin.doctable-data');
?><!DOCTYPE HTML>
<html lang="en">
<head>
    <title>Document Tables</title>
    <?= $this->Html->css('../libs/bootstrap/3.3.4/css/bootstrap.min.css'); ?>
    <?= $this->Html->css($this->Less->css('docs-table-data', array('plugin' => 'Admin'))); ?>
</head>
<body>
<div class="doctableData"
     data-table-data="<?= htmlspecialchars(json_encode($tableData)) ?>">
    <div class="preview"></div>
    <div class="toolbar">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <!--<button type="button" class="btn btn-sm btn-primary saveDocTables">
                        Zapisz
                    </button>-->
                    <button type="button" class="btn btn-sm btn-default exportSQL">
                        Eksportuj SQL
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<a id="forceDownloadFile"></a>
<?= $this->Html->script('../libs/jquery/2.1.4/jquery-2.1.4.min.js') ?>
<?= $this->Html->script('../libs/bootstrap/3.3.4/js/bootstrap.min.js') ?>
<?= $this->Combinator->scripts('js') ?>
</body>
</html>