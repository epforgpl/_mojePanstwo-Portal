<?
$this->Combinator->add_libs('css', $this->Less->css('dataobject', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('dataobjectpage', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('DataBrowser', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('view-gminy', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('view-gminy-radni_powiazania', array('plugin' => 'Dane')));

if ($object->getId() == '903') {
    $this->Combinator->add_libs('css', $this->Less->css('view-gminy-krakow', array('plugin' => 'Dane')));
}

echo $this->Element('dataobject/pageBegin', array(
    'titleTag' => 'p',
));

if (!isset($_submenu['base']))
    $_submenu['base'] = $object->getUrl();

$powiazania = $object->getLayer('urzednicy_powiazania');
?>


<div class="row">
    <div class="col-md-2">
		<div class="dataBrowser">
		<?
			echo $this->Element('Dane.DataBrowser/browser-menu', array(
                'menu' => $_submenu,
                'pills' => isset($pills) ? $pills : null
            ));
        ?>
		</div>
	</div>
    <div class="col-md-10 nocontainer">

		
		<h1 class="smaller margin-top-15">Powiązania urzędników Urzędu Miasta z organizacjami w Krajowym Rejestrze Sądowym</h1>

        <div id="powiazania" class="object">
            <? if ($powiazania) { ?>
                <? foreach ($powiazania as $p) { ?>
                    <div class="block col-xs-12">
                        <div class="header col-md-3">
                            <h2 class="name">
                                <a href="/dane/gminy/<?= $object->getId() ?>/urzednicy/<?= $p['urzednik']['id'] ?>"><?= $p['urzednik']['nazwa'] ?></a>
                            </h2>

                            <p class="club"><?= $p['urzednik']['opis'] ?></p>
                        </div>

                        <div class="content col-md-9">
                            <ul>
                                <?
                                foreach ($p['organizacje'] as $o) {

                                    $badges = array();

                                    if ($o['relacja']['reprezentat'] == '1') {
                                        $badges[] = $o['relacja']['reprezentat_funkcja'] ? $o['relacja']['reprezentat_funkcja'] : 'Członek organu reprezentacji';
                                    }

                                    if ($o['relacja']['wspolnik'] == '1') {
                                        $badges[] = 'Wspólnik';
                                    }

                                    if ($o['relacja']['akcjonariusz'] == '1') {
                                        $badges[] = 'Akcjonariusz';
                                    }

                                    if ($o['relacja']['prokurent'] == '1') {
                                        $badges[] = 'Prokurent';
                                    }

                                    if ($o['relacja']['nadzorca'] == '1') {
                                        $badges[] = 'Członek organu nadzoru';
                                    }

                                    if ($o['relacja']['zalozyciel'] == '1') {
                                        $badges[] = 'Członek komitetu założycielskiego';
                                    }
                                    ?>
                                    <li>
                                        <a href="/dane/krs_podmioty/<?= $o['id'] ?>"><?= stripslashes($o['nazwa']) ?></a>
                                        <span
                                            class="_badge"><?= implode('</span> <span class="_badge">', $badges) ?></span>
                                    </li>
                                <? } ?>
                            </ul>
                        </div>
                    </div>
                <? } ?>
            <? } ?>

        </div>
            

    </div>
</div>



<?
echo $this->Element('dataobject/pageEnd');
?>
