<?= $this->element('Admin.header'); ?>
<? $this->Combinator->add_libs('js','Admin.accept-moderate-request-modal'); ?>

<h2>Ankiety</h2>

<? if(isset($surveys) && count($surveys)) { ?>
    <div class="list-group">
        <? foreach($surveys as $survey) { ?>
            <a href="/admin/surveys/view/<?= $survey['Survey']['id'] ?>" class="list-group-item"><?= $survey['Survey']['name'] ?></a>
        <? } ?>
    </div>
<? } else { ?>
    <p class="margin-top-20">Brak ankiet</p>
<? } ?>

<?= $this->element('Admin.footer'); ?>
