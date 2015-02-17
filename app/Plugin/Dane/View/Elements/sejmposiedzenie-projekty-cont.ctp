<div class="projekty mpanel margintop">
    <div class="column col-md-4">

        <h2 class="label label-success">Przyjęto</h2>
        <? echo $this->element('Dane.sejmposiedzenie-projekty', array(
            'projekty' => $projekty['przyjete'],
        )); ?>

    </div>
    <div class="column col-md-4">

        <h2 class="label label-primary">Do dalszych prac</h2>
        <? echo $this->element('Dane.sejmposiedzenie-projekty', array(
            'projekty' => $projekty['dalsze_prace'],
        )); ?>

    </div>
    <div class="column col-md-4">

        <h2 class="label label-danger">Odrzucono</h2>
        <? echo $this->element('Dane.sejmposiedzenie-projekty', array(
            'projekty' => $projekty['odrzucone'],
        )); ?>

    </div>
</div>