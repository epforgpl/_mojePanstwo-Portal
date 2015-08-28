<?

if (
    ($static = $object->getStatic()) &&
    ($glosowanie = @$static['glosowanie'])
) {
    $this->Combinator->add_libs('js', '../plugins/highstock/js/highstock');
    $this->Combinator->add_libs('js', '../plugins/highstock/locals');
    $this->Combinator->add_libs('js', 'Dane.Krakow_glosowania_votings.js');
    $this->Combinator->add_libs('css', $this->Less->css('krakow_glosowania_votings', array('plugin' => 'Dane')));
    ?>

    <div class="krakow_glosowania_voting_chart" data-za="<?= (int)$glosowanie['liczba_glosow_za'] ?>"
         data-przeciw="<?= (int)$glosowanie['liczba_glosow_przeciw'] ?>"
         data-nieobecni="<?= (int)$glosowanie['liczba_nieobecni'] ?>"
         data-wstrzymanie="<?= (int)$glosowanie['liczba_glosow_wstrzymanie'] ?>"></div>

<?
}
