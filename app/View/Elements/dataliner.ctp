<?
$this->Combinator->add_libs('css', $this->Less->css('timeline', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('dataliner', array('plugin' => 'Dane')));
$this->Combinator->add_libs('js', 'Dane.timeline');
$this->Combinator->add_libs('js', 'Dane.dataliner');
?>

<div class="dataliner" data-requestdata="<? if (isset($requestData) && !empty($requestData)) {
    echo htmlspecialchars(json_encode($requestData));
} ?>"
     data-filterfield="<? if (isset($filterField) && !empty($filterField)) {
         echo $filterField;
     } ?>">
    <? if (isset($filters) && !empty($filters)) { ?>
        <div class="filters text-center">
            <select class="selectpicker">
                <? foreach ($filters as $filter) { ?>
                    <option<? if (isset($filter['selected']) && $filter['selected']) { ?> selected="selected"<? } ?>
                        value="<?= $filter['id'] ?>"><?= $filter['nazwa'] ?></option>
                <? } ?>
            </select>

        </div>
    <? } ?>
    <div class="timeline" style="display: none;">
        <? if (isset($initData) && !empty($initData)) { ?>
            <ul>
                <? foreach ($initData as $d) { ?>
                    <li data-type="<?= htmlspecialchars($d['type']) ?>">
                        <p class="date"><?= $d['date'] ?></p>

                        <div class="title"><?= $d['title'] ?></div>
                        <div class="content"><?= $d['content'] ?></div>
                    </li>
                <? } ?>
            </ul>
        <? } ?>
    </div>
    <div class="endlessLoader loading"></div>
</div>