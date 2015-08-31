<?= $this->element('Admin.header'); ?>
<? $this->Combinator->add_libs('js','Admin.accept-moderate-request-modal'); ?>

<h2><?= $survey['survey']['name'] ?></h2>

<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
<? foreach($survey['questions'] as $i => $question) { ?>
    <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="heading<?= $i ?>">
            <h4 class="panel-title">
                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?= $i ?>" aria-expanded="true" aria-controls="collapse<?= $i ?>">
                    <?= $question['question'] ?>
                </a>
            </h4>
        </div>
        <div id="collapse<?= $i ?>" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading<?= $i ?>">
            <ul class="list-group">
                <? if(count($question['answers'])) { ?>
                    <? foreach($question['answers'] as $answer) { ?>
                        <li class="list-group-item">
                            <span class="badge"><?= $answer['count']; ?></span>
                            <?= $answer['answer'] != '' ? $answer['answer'] : 'Pusta odpowiedź'; ?>
                        </li>
                    <? } ?>
                <? } else { ?>
                    <li class="list-group-item">Brak odpowiedzi</li>
                <? } ?>
            </ul>
        </div>
    </div>
<? } ?>
</div>

<?= $this->element('Admin.footer'); ?>
