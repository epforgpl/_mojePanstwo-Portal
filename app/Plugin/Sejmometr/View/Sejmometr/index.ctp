<?php $this->Combinator->add_libs('css', $this->Less->css('dataobject', array('plugin' => 'Dane'))) ?>
<?php $this->Combinator->add_libs('css', $this->Less->css('dataobjectslider', array('plugin' => 'Dane'))) ?>
<?php $this->Combinator->add_libs('css', $this->Less->css('sejmometr', array('plugin' => 'Sejmometr'))) ?>
<?php $this->Combinator->add_libs('css', $this->Less->css('new-look')) ?>

<?php $this->Combinator->add_libs('js', '../plugins/highcharts/js/highcharts'); ?>
<?php $this->Combinator->add_libs('js', '../plugins/highcharts/locals'); ?>

<?php $this->Combinator->add_libs('js', 'Sejmometr.sejmometr.js'); ?>

<div id="sejmometr" class="newLayout">

    <div class="headline strip">
        <div class="container">
            <h1 class="header text-center"><a href="/sejmometr">Sejmometr</a></h1>

            <div class="content-container col-xs-12">
                <h5>Sejm jest organem władzy ustawodawczej w Polsce. Tworzą go posłowie, którzy są reprezentantami
                    Narodu
                    dlatego mogą, a nawet powinni być przez ten Naród oceniani. Szerokie udostępnianie informacji o
                    poselskich działaniach leży w interesie każdego z 460 posłów. Obywatele nie mający dostępu do takich
                    danych swoje poglądy wyrobią w oparciu o inne, niekoniecznie obiektywne źródła informacji.
                    Postanowiliśmy wesprzeć tych, którzy chcieliby wiedzieć jak pracują nasi posłowie i w jakich
                    warunkach
                    wykonują swój mandat poselski. Stworzyliśmy aplikację, która prezentuje rozmaite dane związane z
                    sejmową
                    codziennością!

                </h5>


                <div class="row sejm-menu">
                    <div class="col-lg-4 link">
                        <a class="poslowie" href="/dane/poslowie"><span>Znajdź<br/>i sprawdź swojego posła!</span></a>
                    </div>
                    <div class="col-lg-4 link">
                        <a class="projekty" href="/sejmometr/prace"><span>Projekty aktów prawnych</span></a>
                    </div>
                    <div class="col-lg-4 link">
                        <a class="posiedzenia" href="/sejmometr/posiedzenia"><span>Posiedzenia Sejmu</span></a>
                    </div>
                    <? /*
                <div class="col-lg-3 link">
                    <a class="koszty" href="/sejmometr/info"><span>Ile to kosztuje?</span></a>
                </div>
                */
                    ?>
                </div>


                <div style="display: none;">
                    <div class="searchInput search col-xs-12 col-md-10 col-md-offset-1">
                        <form
                            action="<? echo Router::url(array(
                                'plugin' => 'Dane',
                                'controller' => 'datachannels',
                                'action' => 'view',
                                'alias' => 'sejm'
                            )); ?>">
                            <div class="input-group">
                                <input name="q" value="" type="text" autocomplete="off"
                                       placeholder="Szukaj w pracach Sejmu..."
                                       class="form-control input-lg">
		                <span class="input-group-btn">
		                      <button class="btn btn-success button big" type="submit" data-icon="&#xe600;"></button>
		                </span>
                            </div>
                        </form>
                    </div>

                    <div class="shortcut submenu">
                        <ul>
                            <li class="active">
                                <a href="/sejmometr">Sejmometr</a>
                            </li>
                            <li>
                                <a href="/dane/legislacja_projekty_ustaw">Projekty ustaw</a>
                            </li>
                            <li>
                                <a href="/dane/sejm_druki">Druki sejmowe</a>
                            </li>
                            <li>
                                <a href="/dane/poslowie" target="_self">Posłowie</a>
                            </li>
                            <li>
                                <a href="/dane/sejm_kluby" target="_self">Kluby parlamentarne</a>
                            </li>
                            <li>
                                <a href="/dane/sejm_interpelacje" target="_self">Interpelacje</a>
                            </li>
                        </ul>
                    </div>
                </div>


            </div>
        </div>
    </div>


    <?php /* BEGIN TIMELINE strip li */ ?>

    <? /*
<div class="timeline strip">
    <div class="container">
        <div class="head col-xs-12">
            <h2>Posiedzenia <strong>Sejmu</strong></h2>
        </div>
    </div>
</div>

<div id="timeline-embed" data-source="1"></div>
*/
    ?>
    <?php /* END TIMELINE strip */ ?>


    <? /*
<div class="poslowie strip">
    <div class="container">
        <div class="head col-xs-12">
            <h2>Posłowie tej kadencji</h2>

            <form action="<?= $poslowie_url ?>">
                <div class="input-group">
                    <input name="q" value="" type="text" autocomplete="off"
                           placeholder="Wpisz nazwisko posła lub nazwę miejscowości albo kod pocztowy, aby wyszukać posłów z danego okręgu"
                           class="form-control input-lg">
	                <span class="input-group-btn">
	                      <button class="btn btn-success button big" type="submit" data-icon="&#xe600;"></button>
	                </span>
                </div>
            </form>

            <div class="pull-left">
                <p>Kliknij na nazwisko posła, aby pokazać jego szczegółowe dane.</p>
            </div>
        </div>
        <div class="content-container col-xs-12">
            <ul>
                <? foreach($poslowie as $p) { ?>
                <li class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
                    <a href="<?= $p['url'] ?>"><?= $p['nazwisko'] . ' ' . $p['imie'] ?><img
                            src="<?= $p['klub_img_src'] ?>" alt="<?= $p['klub'] ?>"></a>
                </li>
                <? } ?>
            </ul>
            <div class="getMore text-center">
                <a class="btn btn-primary" href="<?= Router::url(array('plugin' => 'dane', 'controller' => 'poslowie')); ?>"
                   target="_self">Pokaż całą listę</a>
            </div>
        </div>
    </div>
</div>

<div class="raportWydatki strip">
    <div class="container">
        <div class="col-xs-12">
            <div class="liczba">113 209 340
                <small>PLN</small>
            </div>
            <div class="infoLine">
                Tyle kosztowały wydatki związane z pracą posłów w 2013 roku
            </div>
            <div class="checkIt">
                <a class="btn btn-primary" href="#" onclick="return false;">Zobacz historię wydatków
                    <small>(już wkrótce)</small>
                </a>
            </div>
        </div>
        <?php // echo $this->element('Sejmometr.inner-story'); ?>
    </div>
</div>

*/
    ?>

    <div class="detailPoslowie strip">
        <div class="container">
            <div class="sideMenu hidden-xs col-sm-4 col-md-2">
                <ul class="nav">
                    <li class="active">
                        <a href="#wystapienia">Wystąpienia</a>
                    </li>
                    <li>
                        <a href="#frekwencja">Frekwencja</a>
                    </li>
                    <li>
                        <a href="#bunty">Bunty</a>
                    </li>

                    <li>
                        <a href="#interpelacje">Interpelacje</a>
                    </li>
                    <li>
                        <a href="#zawody">Kim są posłowie z zawodu</a>
                    </li>
                    <li>
                        <a href="#etyka_poselska">Etyka poselska</a>
                    </li>
                    <li>
                        <a href="#poslankiPoslowie">Posłanki i posłowie</a>
                    </li>
                    <li>
                        <a href="#przeloty">Poselskie przeloty</a>
                    </li>
                    <li>
                        <a href="#przejazdy">Poselskie przejazdy</a>
                    </li>
                    <? /*
        <li>
            <a href="#wnioskiImmunitet">Wnioski o uchylenie immunitetu</a>
        </li>
        */
                    ?>
                    <li>
                        <a href="#domPoselski">Dom poselski</a>
                    </li>
                    <? /*
        <li>
            <a href="#zarobki">Zarobki posłów</a>
        </li>
        <li>
            <a href="#dodatki">Dodatki do uposażenia i dieta poselska</a>
        </li>
        */
                    ?>
                    <li>
                        <a href="#pozyczki">Pożyczki</a>
                    </li>
                    <li>
                        <a href="#zapomogi">Zapomogi</a>
                    </li>
                </ul>
            </div>
            <div class="content-container col-xs-12 col-sm-8 col-md-10">
                <?php
                /* WYSTAPAPIENIA BLOCK */

                $page = array(
                    'class' => 'wystapienia',
                    'anchor' => 'wystapienia',
                    'title' => 'Wystąpienia na forum Sejmu',
                    'text' => 'Posłowie w ramach sprawowania mandatu wypowiadają się na posiedzeniach Sejmu. Zobacz, którzy z nich są najbardziej aktywni.',
                    'link' => $poslowie_url . '?order=' . $liczba_wypowiedzi['order'],
                    'item_path' => 'wystapienia',
                );

                echo $this->element('Sejmometr.list', array('page' => $page, 'items' => $liczba_wypowiedzi['items']));


                /* FREKWENCJA BLOCK */

                $page = array(
                    'class' => 'frekwencja',
                    'anchor' => 'frekwencja',
                    'title' => 'Frekwencja posłów na głosowaniach',
                    'text' => 'Poseł musi być obecny na posiedzeniach Sejmu i powinien czynnie w nich uczestniczyć. To poselski obowiązek, którego zaniedbanie powoduje konsekwencje finansowe. Jeżeli poseł ma nieusprawiedliwione nieobecności Marszałek Sejmu zarządza obniżenie uposażenia i diety parlamentarnej albo jednego z tych świadczeń, jeżeli tylko ono przysługuje posłowi. Poseł ze swoich świadczeń traci 1/30 za każdy dzień nieusprawiedliwionej nieobecności na posiedzeniu Sejmu lub za niewzięcie w danym dniu udziału w więcej niż 1/5 głosowań. Sprawdź, który z posłów najcześciej omija sejmowe posiedzenia.',
                    'link' => $poslowie_url . '?order=' . $frekwencja['order'],
                    'item_path' => 'glosowania/?glos_id[]=4',
                );

                echo $this->element('Sejmometr.list', array('page' => $page, 'items' => $frekwencja['items']));


                /* BUNTY BLOCK */

                $page = array(
                    'class' => 'bunty',
                    'anchor' => 'bunty',
                    'title' => 'Bunty poselskie',
                    'text' => 'Poprzez "bunty" określamy sytuacje polegające na tym, że poseł głosuje przeciwnie niż większość klubu parlamentarnego, do którego należy. Partie zabezpieczają się przed buntami stosując dyscyplinę głosowania. Narzucają tym samym sposób w jaki dany poseł ma zagłosować. Za naruszenie dyscypliny grozi nawet kara finansowa. Powstaje pytanie jak narzędzie dyscypliny głosowania ma się do konstytucyjnego zapisu o tym, że posłowie są przedstawicielami Narodu. W momencie gdy poseł oddaje swój głos zgodnie z wytycznymi partyjnego lidera jest przedstawicielami partii, a nie Narodu. Wydaje się, że dyscyplina poselska nie wpływa korzystnie na interesy obywateli. W sytuacji jej zastosowania na decyzję posła podczas głosowania mają wpływ nie merytoryczne rozważania, ale obawy przed sankcjami, które może wymierzyć partia. W naszym zestawieniu prezentujemy największych buntowników w Sejmie, którzy głosują inaczej niż większość ich klubu parlamentarnego.',
                    //'link' => $poslowie_url . '?order=liczba_glosowan_zbuntowanych%20desc'
                    'link' => $poslowie_url . '?order=' . $zbuntowanie['order'],
                    'item_path' => 'glosowania/?bunt[]=1',
                );

                echo $this->element('Sejmometr.list', array('page' => $page, 'items' => $zbuntowanie['items']));


                /* INTERPELACJE BLOCK */

                $page = array(
                    'class' => 'interpelacje',
                    'anchor' => 'interpelacje',
                    'title' => 'Interpelacje',
                    'text' => 'Składanie interpelacji jest jednym z poselskich uprawnień. Każdy z posłów może zapytać Prezesa Rady Ministrów lub konkretnego ministra o sprawę, która dotyczy polityki państwa. Członkowie Rady Ministrów muszą udzielić posłowi odpowiedzi nie później niż w ciągu 21 dni od otrzymania interpelacji. Zobacz, który z posłów najczęściej zadaje pytania!',
                    'link' => $poslowie_url . '?order=' . $liczba_interpelacji['order'],
                    'item_path' => 'interpelacje',
                );

                echo $this->element('Sejmometr.list', array('page' => $page, 'items' => $liczba_interpelacji['items']));


                /* KIM SA Z ZAWODU BLOCK */

                $page = array(
                    'class' => 'zawod',
                    'anchor' => 'zawody',
                    'title' => 'Kim posłowie są z zawodu?',
                    'text' => 'Wśród parlamentarzystów pojawia się wiele różnych profesji. Nie ma jednak jednolitych zasad jeśli chodzi o wskazywanie przez posłów swoich zawodów. Niektórzy z posłów jako swój zawód podają ten, który wynika z ich wykształcenia, inni natomiast zawód ostatnio wykonywany. Część posłów wskazuje, że są posłami zawodowymi czyli takimi, którzy poza wykonywaniem mandatu parlamentarnego nie pracują, ani nie prowadzą działalności gospodarczej. W naszym zestawieniu przedstawiamy czym najczęściej zawodowo zajmują się posłowie.',
                    'link' => Router::url(array('action' => 'zawody_poslow'))
                );

                echo $this->element('Sejmometr.graph_percent', array('page' => $page, 'items' => $zawody));


                /* ETYKA POSELSKA BLOCK */

                $page = array(
                    'class' => 'etyka_poselska',
                    'anchor' => 'etyka_poselska',
                    'title' => 'Etyka poselska',
                    'text' => 'Kwestiami związanymi z etyką parlamentarzystów zajmuje się Komisja Etyki Poselskiej. Zadaniem komisji jest m. in. rozpatrywanie spraw posłów, którzy zachowują się w sposób nieodpowiadający poselskiej godności. Zobacz czyje zachowanie najczęściej było przedmiotem uchwał Komisji Etyki Poselskiej.',
                    'link' => '/dane/sejm_komisje_uchwaly',
                    'item_path' => 'komisja_etyki_uchwaly',
                );

                echo $this->element('Sejmometr.list', array('page' => $page, 'items' => $uchwaly_komisji_etyki['items']));


                /* POSLANKI POSLOWIE BLOCK */

                $page = array(
                    'class' => 'poslankiPoslowie',
                    'anchor' => 'poslankiPoslowie',
                    'title' => 'Posłanki i posłowie',
                    'text' => 'Ilość kobiet i mężczyzn w Sejmie i w poszczególnych partiach',
                );

                echo $this->element('Sejmometr.graph_circle', array('page' => $page, 'items' => $poslanki_poslowie));


                /* POLSKIE PRZELOTY BLOCK */

                $page = array(
                    'class' => 'przeloty',
                    'anchor' => 'przeloty',
                    'title' => 'Poselskie przeloty',
                    'text' => 'Poseł ma prawo do bezpłatnych przelotów w krajowym przewozie lotniczym. W celu zapewnienia realizacji na rzecz posłów krajowej usługi lotniczej, Kancelaria Sejmu zawiera umowy z przewoźnikami lotniczymi. Posłowie mają również prawo do doraźnego korzystania z usług innych przewoźników lotniczych, z którymi Kancelaria Sejmu nie zawarła stosownych umów. W takim przypadku posłowie kupują bilet w kasie przewoźnika, a następnie należność przez nich uiszczona zwracana jest im przez Kancelarię Sejmu na zasadzie refundacji, na podstawie oryginału faktury, rachunku albo biletu wystawionego przez przewoźnika. Poniżej przedstawiamy nazwiska posłów, którzy latali najczęściej w 2013 roku.',
                    'link' => $poslowie_url . '?order=liczba_przelotow desc',
                );

                echo $this->element('Sejmometr.list', array('page' => $page, 'items' => $przeloty['items']));


                /* POLSKIE PRZEJAZDY BLOCK */

                $page = array(
                    'class' => 'przeloty',
                    'anchor' => 'przejazdy',
                    'title' => 'Poselskie przejazdy',
                    'text' => 'Posłowie w ramach wykonywania swojej pracy mogą korzystać ze służbowych samochodów, którymi dysponuje Kancelaria Sejmu. Zobacz kto w 2013 roku najczęściej był w drodze.',
                    'link' => $poslowie_url . '?order=liczba_przejazdow desc',
                );

                echo $this->element('Sejmometr.list', array('page' => $page, 'items' => $przejazdy['items']));

                /* KWATERY PRYWATNE POSLOW BLOCK */
                /*

                $page = array(
                    'class' => 'kwatery',
                    'anchor' => 'kwatery',
                    'title' => 'Kwatery prywatne posłów',
                    'text' => 'Jeżeli dla posłów, którzy nie są zameldowani na pobyt stały w Warszawie i nie posiadają innego uprawnienia do zakwaterowania na terenie tego miasta, brakuje miejsc w Domu Poselskim, mogą wtedy wynająć kwatery prywatne na podstawie zawartych przez siebie umów najmu. Z tego tytułu posłowie mogą otrzymać maksymalnie 2200 zł miesięcznie kwoty refundacji. Sprawdźcie w jakim stopniu parlamentarzyści w 2013 r. skorzystali z refundacji.',
                    'link' => '#rankingLink'
                );

                echo $this->element('Sejmometr.list', array('page' => $page, 'items' => $kwatery_prywatne['items']));
                */


                /* WMIOSKI O UCHYLENIE IMMUNITETU BLOCK */

                /*
                $page = array(
                    'class' => 'wnioskiImmunitet',
                    'anchor' => 'wnioskiImmunitet',
                    'title' => 'Wnioski o uchylenie immunitetu',
                    'text' => 'W sytuacji gdy poseł narusza prawo, odpowiedni organ np. Komenda Policji może skierować do Marszałka Sejmu wniosek o uchylenie poselskiego immunitetu. Poniżej przedstawiamy ranking posłów, których w 2013 r. najczęściej dotyczyły wnioski o wyrażenie zgody na pociągniecie posłów do odpowiedzialności.',
                    'link' => '#rankingLink'
                );

                echo $this->element('Sejmometr.list', array('page' => $page));
                */

                /* DOM POSELSKI BLOCK */
                $page = array(
                    'class' => 'dom',
                    'anchor' => 'domPoselski',
                    'title' => 'Dom poselski',
                    'text' => '<p>Posłowie, którzy nie są zameldowani na pobyt stały w Warszawie i nie posiadają innego uprawnienia do zakwaterowania na terenie tego miasta, mogą korzystać z Domu Poselskiego.</p><p><strong>W 2013 r. w Domu Poselskim udzielono posłom 21, 152 zakwaterowań (w dobach).</strong></p>'
                );

                echo $this->element('Sejmometr.text', array('page' => $page));


                /* ZAROBKI POSLOW BLOCK */

                /*
                $page = array(
                    'class' => 'zarobki',
                    'anchor' => 'zarobki',
                    'title' => 'Zarobki posłów',
                    'text' => '<p><strong>Zobacz, kto nie pobierał uposażenia poselskiego w 2013 roku!</strong></p><p>Posłom w okresie sprawowania mandatu, licząc od pierwszego posiedzenia Sejmu, przysługuje uposażenie poselskie. Świadczenie jest wypłacane miesięcznie (także za niepełne miesiące sprawowania mandatu) i wynosi obecnie 9892,30 zł brutto. Jednak nie wszyscy posłowie otrzymują uposażenie poselskie. Posłom, którzy:</p><ul><li>pracują i nie zdecydowali się na bezpłatny urlop na czas wykonywnia mandatu,</li><li>prowadzą działalność gospodarczą,</li><li>nie zawiesili prawa do emerytury lub renty</li><li>uposażenie poselskie nie przysługuje.</li></ul><p><strong>Zobacz, kto nie pobierał uposażenia poselskiego w 2013 roku!</strong></p>',
                    'link' => '#rankingLink'
                );

                echo $this->element('Sejmometr.list', array('page' => $page));
                */

                /* DODATKI DO UPOSAZENIA I DIETA BLOCK */
                $page = array(
                    'class' => 'dodatki',
                    'anchor' => 'dodatki',
                    'title' => 'Dodatki do uposażenia i dieta poselska',
                    'text' => '<p>Posłom, którzy pełnią dodatkowe funkcje przysługują dodatki do uposażenia w wysokości:</p><ul><li>20 % uposażenia - dla pełniących funkcję przewodniczącego komisji,</li><li>15 % uposażenia - dla pełniących funkcję zastępcy przewodniczącego komisji,</li><li>10 % uposażenia - dla pełniących funkcję przewodniczących stałych podkomisji,</li><li>Łączna wysokość dodatków nie może jednak przekroczyć 35% uposażenia poselskiego.</li></ul><p>Wszystkim posłom przysługuje dieta poselska czyli środki finansowe na pokrycie kosztów związanych z wydatkami poniesionymi w związku z wykonywaniem mandatu na terenie kraju. Dieta poselska wynosi 25 % uposażenia miesięcznego czyli <strong>2473,08 zł brutto</strong>. Dieta jest wolna od podatku dochodowego od osób fizycznych w granicach określonych w przepisach dla diet otrzymywanych z tytułu pełnienia obowiązków obywatelskich.</p>'
                );

                echo $this->element('Sejmometr.text', array('page' => $page, 'items' => $uposazenia['items']));


                /* POZYCZKI BLOCK */
                $page = array(
                    'class' => 'pozyczki',
                    'anchor' => 'pozyczki',
                    'title' => 'Pożyczki',
                    // 'text' => '<p>Jeżeli poseł potrzebuje pieniędzy w związku z zakupem domu czy remontem mieszkania może złożyć wniosek o udzielenie pożyczki na cele mieszkaniowe. Świadczenie przynawane jest na podstawie decyzji Marszałka Sejmu po zasięgnięciu opinii Zespołu do Spraw Pomocy Socjalnej. Wysokość oprocentowania pożyczki wynosi 3% jeśli została udzielona na okres do 12 miesięcy, lub 4% jeśli została udzielona na okres do 24 miesięcy.</p><p><strong>W 2013 r. w Domu Poselskim udzielono posłom 21, 152 zakwaterowań (w dobach).</strong></p>'
                    'text' => '<p>Jeżeli poseł potrzebuje pieniędzy w związku z zakupem domu czy remontem mieszkania może złożyć wniosek o udzielenie pożyczki na cele mieszkaniowe. Świadczenie przynawane jest na podstawie decyzji Marszałka Sejmu po zasięgnięciu opinii Zespołu do Spraw Pomocy Socjalnej. Wysokość oprocentowania pożyczki wynosi 3% jeśli została udzielona na okres do 12 miesięcy, lub 4% jeśli została udzielona na okres do 24 miesięcy.</p>'
                );

                echo $this->element('Sejmometr.text', array('page' => $page));


                /* ZAPOMOGI BLOCK */
                $page = array(
                    'class' => 'zapomogi',
                    'anchor' => 'zapomogi',
                    'title' => 'Zapomogi',
                    'text' => '<p>Posłowie mogą otrzymać pomoc materialną udzielaną w formie zapomogi bezzwrotnej. Taka zapomoga przysługuje posłom, którzy znajdują się w trudnej sytuacji materialnej i nie mogą zaspokoić podstawowych potrzeb życiowych. O zapomogę mogą również starać się ci posłowie, którzy zostali dotknięci wypadkiem losowym np. chorobą.</p><p><strong>W 2013 roku udzielono posłom 4 zapomogi na łączną kwotę 41 000 zł.</strong></p>'
                );

                echo $this->element('Sejmometr.text', array('page' => $page));
                ?>
            </div>
        </div>
    </div>

</div>