<?
$this->Combinator->add_libs('js', 'Admin.docs-dict');
?><!DOCTYPE HTML>
<html lang="en">
<head>
    <title>Słownik</title>
    <?= $this->Html->css('../libs/bootstrap/3.3.4/css/bootstrap.min.css'); ?>
    <?= $this->Html->css($this->Less->css('docs-table-data', array('plugin' => 'Admin'))); ?>
</head>
<body>
<div class="container">
    <h2 class="text-muted">Słownik</h2>
    <table id="mainTable" class="table table-bordered">
        <tr>
            <th>Z</th>
            <th>Na</th>
            <th>Opcje</th>
        </tr>
        <? foreach($dict as $dic) { ?>
            <tr data-id="<?= $dic['doctable_dict']['id'] ?>">
                <td>
                    <input
                        type="text"
                        name="from"
                        data-id="<?= $dic['doctable_dict']['id'] ?>"
                        class="form-control editable"
                        value="<?= $dic['doctable_dict']['from'] ?>">
                </td>
                <td>
                    <input
                        type="text"
                        name="to"
                        data-id="<?= $dic['doctable_dict']['id'] ?>"
                        class="form-control editable"
                        value="<?= $dic['doctable_dict']['to'] ?>">
                </td>
                <td>
                    <button data-id="<?= $dic['doctable_dict']['id'] ?>" class="btn btn-danger removeDict">Usuń</button>
                </td>
            </tr>
        <? } ?>
        <tr id="addDict">
            <td>
                <input type="text" id="addDictFrom" name="from" class="form-control" placeholder="Z">
            </td>
            <td>
                <input type="text" id="addDictTo"  name="to" class="form-control" placeholder="Na">
            </td>
            <td>
                <button class="btn btn-default">Dodaj</button>
            </td>
        </tr>
    </table>
</div>
<?= $this->Html->script('../libs/jquery/2.1.4/jquery-2.1.4.min.js') ?>
<?= $this->Html->script('../libs/bootstrap/3.3.4/js/bootstrap.min.js') ?>
<?= $this->Combinator->scripts('js') ?>
</body>
</html>