<?
$this->Combinator->add_libs('css', $this->Less->css('warstwy', array('plugin' => 'Mapa')));
$this->Combinator->add_libs('css', $this->Less->css('ngo', array('plugin' => 'Ngo')));
$this->Combinator->add_libs('js', 'latlon-geohash');
$this->Combinator->add_libs('js', 'Mapa.warstwy');
$this->Combinator->add_libs('js', 'Ngo.ngo');
$this->Combinator->add_libs('js', 'Dane.DataBrowser.js');

switch (Configure::read('Config.language')) {
    case 'pol':
        $lang = "pl-PL";
        break;
    case 'eng':
        $lang = "en-EN";
        break;
};
echo $this->Html->script('//maps.googleapis.com/maps/api/js?v=3.21&libraries=geometry&sensor=false&language=' . $lang, array('block' => 'scriptBlock'));
?>

<div class="col-xs-12 col-md-3 col-sm-4 dataAggsContainer">
    <div class="mp-sticky mp-sticky-disable-sm-4" data-widthFromWrapper="false">

        <? echo $this->Element('Dane.DataBrowser/app_chapters'); ?>

        <?
        $this->Combinator->add_libs('js', 'Media.twitter-account-suggestion');
        $this->Combinator->add_libs('css', $this->Less->css('banners-box', array('plugin' => 'Dane')));
        $this->Combinator->add_libs('css', $this->Less->css('twitter-account-suggestion', array('plugin' => 'Media')));
        ?>

        <div class="banner block">

            <div>
                <div class="img-cog pull-left">
                    <span class="glyphicon glyphicon-cog"></span>
                </div>

                <p class="headline margin-top-20"><strong>Zarządzaj profilem</strong> <br/>swojej organizacji!</p>
            </div>

            <div class="description margin-top-30">
                <p>Dodawaj działania swojej organizacji, uaktualniaj i modyfikuj jej dane!</p>

                <p>Aby zacząć, znajdź organizację, korzystając z wyszukiwarki powyżej, przejdź na jej profil i poproś o
                    uprawnienia do zarządzania jej profilem.</p>
                <button class="btn btn-sm btn-primary szukajOrganizajiBtn">Szukaj organizacji</button>
            </div>
        </div>


    </div>
</div>

<div class="col-xs-12 col-md-9 col-sm-8">

    <div class="dataWrap">
        <div class="appBanner bottom-border">
            <h1 class="appTitle">Organizacje pozarządowe</h1>

            <p class="appSubtitle">Poznaj scenę organizacji obywatelskich w Polsce.</p>
        </div>

        <div id="actions-newest" class="block block-simple col-sm-12">
            <header class="nopadding">Najnowsze działania organizacji pozarządowych:</header>
            <section class="content margin-top-10">
                <div class="row">
                    <? foreach ($dataBrowser['aggs']['dzialania']['top']['hits']['hits'] as $dzialanie) { ?>
                        <div class="action col-sm-4">
                            <h4>
                                <a href="/dane/<?= $dzialanie['fields']['source'][0]['data']['dzialania.dataset']; ?>/<?= $dzialanie['fields']['source'][0]['data']['dzialania.object_id']; ?>/dzialania/<?= $dzialanie['fields']['id'][0]; ?>">
                                    <?= $this->Text->truncate($dzialanie['fields']['source'][0]['data']['dzialania.tytul'], 100); ?>
                                </a>
                            </h4>

                            <? if ($dzialanie['fields']['source'][0]['data']['dzialania.photo'] == '1') { ?>
                                <div class="photo">
                                    <a href="/dane/<?= $dzialanie['fields']['source'][0]['data']['dzialania.dataset']; ?>/<?= $dzialanie['fields']['source'][0]['data']['dzialania.object_id']; ?>/dzialania/<?= $dzialanie['fields']['id'][0]; ?>"><img
                                            alt="<?= $dzialanie['fields']['source'][0]['data']['dzialania.tytul']; ?>"
                                            src="http://sds.tiktalik.com/portal/2/pages/dzialania/<?= $dzialanie['fields']['id'][0]; ?>.jpg"/></a>
                                </div>
                            <? } ?>

							<p class="owner"><?= @$dzialanie['fields']['source'][0]['data']['dzialania.owner_name'] ?></p>

                            <div class="desc">
                                <?= @$this->Text->truncate($dzialanie['fields']['source'][0]['data']['dzialania.podsumowanie'], 200) ?>
                            </div>
                        </div>
                    <? } ?>
                </div>
                <div class="text-center margin-top-20">
                    <a class="btn btn-xs btn-primary" href="/ngo/dzialania">Zobacz więcej &raquo;</a>
                </div>
            </section>
        </div>

        <div class="block block-simple col-sm-12">
            <header class="nopadding">Mapa organizacji pozarządowych:</header>
            <section class="content margin-top-10">
                <div id="map"></div>
                <div class="mapSpinner spinner grey">
                    <div class="bounce1"></div>
                    <div class="bounce2"></div>
                    <div class="bounce3"></div>
                </div>
            </section>
        </div>

        <? /*
        <div class="block block-simple col-sm-12">
            <header class="nopadding">Dane statystyczne o sektorze organizacji pozarządowych:</header>
        </div>

        <div class="block block-simple col-sm-12">
            <header class="nopadding">Ważne akty prawne dotyczące organizacji pozarządowych:</header>
        </div>
        */ ?>


    </div>

</div>
