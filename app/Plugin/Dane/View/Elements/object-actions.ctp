<?
$this->Combinator->add_libs('js', 'Pisma.pisma-button');
$this->Combinator->add_libs('css', $this->Less->css('pisma-button', array('plugin' => 'Pisma')));
?>

<ul class="object-actions-ul">
    <!--<li>
        <p class="btn_cont">
            <button class="btn btn-primary btn-icon">
                <span class="glyphicon icon" data-icon="&#xe61c;" aria-hidden="true"></span>Obserwuj
            </button>
        </p>
        <p class="desc">
            Kliknij, aby otrzymywać powiadomienia o pracy tej instytucji
        </p>
    </li>-->

    <? foreach ($buttons as $key => $data) {
        if ($key == 'obserwuj') { ?>
        	<li>
                <p class="btn_cont">
                    <button class="btn btn-primary btn-icon obserwuj-button" data-objectid="<?= $data['id'] ?>">
                        <span class="glyphicon icon" data-icon="&#xe61d;" aria-hidden="true"></span> Obserwuj
                    </button>
                </p>
                <p class="desc">
                    Kliknij, aby nowe dane od <?= $name ?> były umieszczane w Twoim personalnym feedzie.
                </p>
            </li>
        <? } elseif ($key == 'pisma') { ?>
            <li>
                <p class="btn_cont">
                    <button class="btn btn-primary btn-icon pisma-list-button"
                            data-adresatid="<?= $data['adresat_id'] ?>">
                        <span class="glyphicon icon" data-icon="&#xe61d;" aria-hidden="true"></span> Wyślij pismo
                    </button>
                </p>
                <p class="desc">
                    Kliknij, aby wysłać pismo do <?= $name ?>.
                </p>
            </li>
        <? } elseif ($key == 'pismo') { ?>
            <li>
            	<form action="//<?= PORTAL_DOMAIN ?>/pisma" method="post">
	                <p class="btn_cont">
			                <input type="hidden" name="adresat_id" value="<?= $data['adresat_id'] ?>" />
							<input type="hidden" name="szablon_id" value="<?= $data['szablon_id'] ?>" />
                        <button class="btn btn-primary btn-icon">
                            <span class="glyphicon icon" data-icon="&#xe61d;"
                                  aria-hidden="true"></span> <?= $data['nazwa'] ?>
		                    </button>
		               
	                </p>
                 </form>
                <? if( isset($data['opis']) ) {?>
                <p class="desc">
                    <?= $data['opis'] ?>
                </p>
                <? } ?>
            </li>
        <? }
    } ?>
</ul>