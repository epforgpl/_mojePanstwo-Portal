<?php $multi = @($this->request->query[$filter['filter']['field']][0]) == "["; ?>

<div class="daysButton btn-group pull-right">
    <button type="button"
            class="btn btn-default btn-xs single<?php if (!$multi) {
                echo ' disabled';
            } ?>"><?php echo __d('dane', 'LC_DANE_FILTER_DAYBUTTON_SINGLE') ?></button>
    <button type="button"
            class="btn btn-default btn-xs multi"<?php if ($multi) {
        echo ' disabled';
    } ?>><?php echo __d('dane', 'LC_DANE_FILTER_DAYBUTTON_MULTI') ?></button>
</div>

<?php echo $this->Form->input('Dataset.' . $filter['filter']['field'], array(
    'label' => false,
    'div' => false,
    'class' => 'option number dates form-control input-sm disabled hide',
    'autocomplete' => 'off'
)); ?>

<div class="daysSingle<?php if ($multi) {
    echo ' hide';
} ?>">
    <?php echo $this->Form->input('Dataset.' . $filter['filter']['field'] . 'DaysSingle', array(
        'data-main' => $filter['filter']['field'],
        'label' => false,
        'div' => false,
        'class' => 'option number form-control input-sm jquery-datepicker single',
        'placeholder' => __d('dane', 'LC_DANE_FILTER_DAYS_SINGLE_PLACEHOLDER'),
        'autocomplete' => 'off'
    )); ?>
</div>
<div class="daysMulti<?php if (!$multi) {
    echo ' hide';
} ?>">
    <?php echo $this->Form->input('Dataset.' . $filter['filter']['field'] . 'DaysMultiFrom', array(
        'data-main' => $filter['filter']['field'],
        'label' => false,
        'div' => false,
        'class' => 'option number form-control input-sm jquery-datepicker multi from',
        'placeholder' => __d('dane', 'LC_DANE_FILTER_DAYS_MULTI_FROM_PLACEHOLDER'),
        'autocomplete' => 'off'
    )); ?>
    <?php echo $this->Form->input('Dataset.' . $filter['filter']['field'] . 'DaysMultiTill', array(
        'data-main' => $filter['filter']['field'],
        'label' => false,
        'div' => false,
        'class' => 'option number form-control input-sm jquery-datepicker multi till',
        'placeholder' => __d('dane', 'LC_DANE_FILTER_DAYS_MULTI_TILL_PLACEHOLDER'),
        'autocomplete' => 'off'
    )); ?>
</div>