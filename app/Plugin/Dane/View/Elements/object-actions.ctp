<?
if (isset($object_actions)) {
    $this->Combinator->add_libs('js', 'Pisma.pisma-button');
    $this->Combinator->add_libs('css', $this->Less->css('pisma-button', array('plugin' => 'Pisma')));
    ?>

    <ul class="object-actions-ul">

        <? foreach ($object_actions as $key => $data) {
            if ($key == 'pisma') { ?>
                <li>
                    <p class="btn_cont">
                        <button class="btn btn-primary btn-icon pisma-list-button"
                                data-adresatid="<?= $data['adresat_id'] ?>">
                            <span class="glyphicon icon" data-icon="&#xe61d;" aria-hidden="true"></span> Wyślij pismo
                        </button>
                    </p>
                    <p class="desc">
                        Kliknij, aby wysłać pismo do <?= $nazwa ?>.
                    </p>
                </li>
            <? } elseif ($key == 'pismo') { ?>
                <li>
                    <form action="//<?= PORTAL_DOMAIN ?>/pisma" method="post">
                        <div class="btn_cont">
                            <input type="hidden" name="adresat_id" value="<?= $data['adresat_id'] ?>"/>
                            <input type="hidden" name="szablon_id" value="<?= $data['szablon_id'] ?>"/>
                            <button class="pismoBox">
                                <strong><?= $data['nazwa'] ?></strong>
                                <? if (isset($data['opis'])) { ?><p><?= $data['opis'] ?></p><? } ?>
                            </button>
                        </div>
                    </form>
                </li>
            <? }
        } ?>
    </ul>
<? } ?>
