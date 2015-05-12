<?
$this->Combinator->add_libs('css', $this->Less->css('cover', array('plugin' => 'Dane')));
?>
<div class="col-md-8">
    <div class="databrowser-panel">
        <h2>Aplikacje</h2>

        <div class="apps row">

            <? foreach ($_applications as $a) {
                if ($a['tag'] == 1) { ?>
                    <a class="homePageIcon col-xs-6 col-sm-4 col-md-3" href="<?= $a['href'] ?>">
                        <i class="icon" <? if ($a['icon']) {
                            echo 'data-icon-applications="' . $a['icon'] . '"';
                        } else {
                            echo 'data-icon="&#xe612;"';
                        } ?>></i>

                        <p><?= $a['name'] ?></p>
                    </a>
                <? }
            } ?>

        </div>
    </div>

    <div class="databrowser-panel">
        <h2>Raporty</h2>

        <div class="apps row">

            <? foreach ($_applications as $a) {
                if ($a['tag'] == 2) { ?>
                    <a class="homePageIcon col-xs-6 col-sm-4 col-md-3" href="<?= $a['href'] ?>">
                        <i class="icon" <? if ($a['icon']) {
                            echo 'data-icon-applications="' . $a['icon'] . '"';
                        } else {
                            echo 'data-icon="&#xe612;"';
                        } ?>></i>

                        <p><?= $a['name'] ?></p>
                    </a>
                <? }
            } ?>

        </div>
    </div>
</div>
<div class="col-md-4">
    <a href="/moje_dane" target="_self" class="box">
        <h3>Komunikuj</h3>

        <p>Otrzymuj powiadomienia o aktywnościach urzędów, urzędnikow oraz firm, którymi jesteś zainteresowany.</p>
        <span>Moje Dane &rarr;</span>
    </a>
    <a href="/moje_pisma" target="_self" class="box">
        <h3>Obserwuj</h3>

        <p>Wysyłaj wnioski o udostępnienie informacji publicznych oraz inne pisma do urzędów i dziel się nimi w mediach
            społecznościowych.</p>
        <span>Moje Pisma &rarr;</span>
    </a>
</div>