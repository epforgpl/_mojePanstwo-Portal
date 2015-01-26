<!DOCTYPE html>
<html>
<head>
    <title>Title of the document</title>
    <style>
        <?php $this->Combinator->add_libs('css', $this->Less->css('pisma_render', array('plugin' => 'Pisma'))) ?>
    </style>
</head>
<body>
<div id="editor-cont">
    <div class="editor-controls">
        <div class="control control-date">
            <input type="text" class="datepicker" <?php if (!empty($pismo['data_pisma'])) {
                $months = array('stycznia', 'lutego', 'marca', 'kwietnia', 'maja', 'czerwca', 'lipca', 'sierpnia', 'września', 'października', 'listopada', 'grudnia');
                $data_proc = explode('-', $pismo['data_pisma']);
                $data_slownie = $data_proc[2] . ' ' . $months[$data_proc[1] - 1] . ' ' . $data_proc[0];

                echo 'value="' . $data_slownie . '"';
            } ?>>
        </div>

        <div class="control control-sender">
            <?php if (!empty($pismo['nadawca'])) { ?>
                <div class="pre"><?= str_replace("\n", '<br/>', $pismo['nadawca']) ?></div>
            <? } ?>
        </div>

        <div class="control control-addressee">
            <?php if (!empty($pismo['adresat'])) {
                echo $pismo['adresat'];
            } ?>
        </div>

        <div class="control control-template">
            <?php if (!empty($pismo['tytul'])) {
                echo $pismo['tytul'];
            } ?>
        </div>
    </div>

    <article id="editor">
        <? if (!empty($pismo['tresc'])) {
            echo $pismo['tresc'];
        } ?>
    </article>

    <div class="editor-controls">
        <div class="control control-signature">
            <?php if (!empty($pismo['podpis'])) { ?>
                <div class="pre"><?= str_replace("\n", '<br/>', $pismo['podpis']) ?></div>
            <? } ?>
        </div>
    </div>
</div>
</body>
</html>