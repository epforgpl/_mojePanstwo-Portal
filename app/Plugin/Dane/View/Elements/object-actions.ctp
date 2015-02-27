<?
$this->Combinator->add_libs('js', 'Pisma.pisma-button');
$this->Combinator->add_libs('css', $this->Less->css('pisma-button', array('plugin' => 'Pisma')));
?>

<ul class="object-actions-ul">
    <!--<li>
        <p class="btn_cont">
            <button class="btn btn-primary">
                <span class="glyphicon" data-icon="&#xe61c;" aria-hidden="true"></span>Obserwuj
            </button>
        </p>
        <p class="desc">
            Kliknij, aby otrzymywać powiadomienia o pracy tej instytucji
        </p>
    </li>-->

    <? foreach ($buttons as $key => $data) {
        if ($key == 'pisma') { ?>
            <li>
                <p class="btn_cont">
                    <button class="btn btn-primary pisma-list-button" data-adresatid="<?= $data['adresat_id'] ?>">
                        <span class="glyphicon" data-icon="&#xe61d;" aria-hidden="true"></span> Wyślij pismo
                    </button>
                </p>
                <p class="desc">
                    Kliknij, aby wysłać pismo do <?= $name ?>.
                </p>
            </li>
        <? }
    } ?>
</ul>