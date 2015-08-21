<?
$this->Combinator->add_libs('css', $this->Less->css('dataobject', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('dataobjectpage', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('DataBrowser', array('plugin' => 'Dane')));
echo $this->Combinator->add_libs('css', $this->Less->css('view-gminy', array('plugin' => 'Dane')));
echo $this->Combinator->add_libs('css', $this->Less->css('view-gminy-radni_powiazania', array('plugin' => 'Dane')));

if ($object->getId() == '903') {
    $this->Combinator->add_libs('css', $this->Less->css('view-gminy-krakow', array('plugin' => 'Dane')));
}

echo $this->Element('dataobject/pageBegin', array(
    'titleTag' => 'p',
));

$powiazania = $object->getLayer('radni_powiazania');
?>
<h1 class="subheader">Rada Miasta Kraków</h1>

<div class="dataBrowser">
    <div class="row">
        <div class="dataBrowserContent">
            <div class="col-md-3 col-xs-12 dataAggsContainer">

                <? if (isset($_submenu) && isset($_submenu['items'])) {

                    if (!isset($_submenu['base']))
                        $_submenu['base'] = $object->getUrl();

                    echo $this->Element('Dane.DataBrowser/browser-menu', array(
                        'menu' => $_submenu,
                    ));

                } ?>

            </div>
            <div class="col-xs-12 col-md-8">
                <div id="powiazania" class="object">
                    <? if ($powiazania) { ?>
                        <? foreach ($powiazania as $p) { ?>
                            <div class="block col-xs-12">
                                <div class="header col-md-3">
                                    <img src="<? if ($p['radny']['avatar'] == '1') {
                                        echo 'http://resources.sejmometr.pl/avatars/5/' . $p['radny']['avatar_id'] . '.jpg';
                                    } elseif ($p['radny']['plec'] == 'K') {
                                        echo 'http://resources.sejmometr.pl/avatars/g/w.png';
                                    } else {
                                        echo 'http://resources.sejmometr.pl/avatars/g/m.png';
                                    } ?>" onerror="imgFixer(this)"/>

                                    <h2 class="name">
                                        <a href="/dane/gminy/<?= $object->getId() ?>/radni/<?= $p['radny']['id'] ?>"><?= $p['radny']['nazwa'] ?></a>
                                    </h2>

                                    <p class="club"><?= $p['radny']['komitet'] ?></p>
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
                                            class="badge"><?= implode('</span> <span class="badge">', $badges) ?></span>
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
    </div>
</div>

<?
echo $this->Element('dataobject/pageEnd');
?>
