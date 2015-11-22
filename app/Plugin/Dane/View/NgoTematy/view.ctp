<?

echo $this->Element('dataobject/pageBegin');

$this->Combinator->add_libs('css', $this->Less->css('temat', array('plugin' => 'Ngo')));
$this->Combinator->add_libs('js', 'Ngo.temat');

?>

</div><!-- closing div.objectsPageContent.main -->
</div><!-- closing div.container -->

<div class="hello">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-md-8 col-lg-6">
                <hr/>
                <p>Uchodźca - osoba, która musiała opuścić teren, na którym mieszkała ze względu na zagrożenie życia,
                    zdrowia, bądź wolności. Zagrożenie to jest najczęściej związane z walkami zbrojnymi, klęskami
                    żywiołowymi, prześladowaniami religijnymi bądź z powodu rasy lub przekonań politycznych.</p>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="objectsPageContent main">
        <div class="firstBlock col-xs-12 nopadding">
            <div class="linkBox col-xs-12 col-md-6">
                <h2>Informacje</h2>
                <hr/>
                <ul class="list">
                    <li>
                        <a href="#"><span>Fakty i mity</span>
                            <small>Sprawdź co jest prawdą a co tylko powielanym mitem.</small>
                        </a>
                    </li>
                    <li>
                        <a href="#"><span>Portrety uchodźców</span>
                            <small>Każdy uchodźca to osobna historia. Poznaj ich.</small>
                        </a>
                    </li>
                    <li>
                        <a href="#"><span>Autorytety o uchodźcach</span>
                            <small>Co sądzą o uchodźcach znani ludzie.</small>
                        </a>
                    </li>
                    <li>
                        <a href="#"><span>Materiały informacyjne</span>
                            <small>Garść informacji o uchodźcach.</small>
                        </a>
                    </li>
                    <li>
                        <a href="#"><span>Infografiki</span>
                            <small>Fakty przekazane w przejrzysty i lekki sposób.</small>
                        </a>
                    </li>
                    <li>
                        <a href="#"><span>Statystyki</span>
                            <small>Problem uchodźców w liczbach.</small>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="storyBox col-xs-12 col-sm-6 col-md-3">
                <a href="#alaa">
                    <img src="/Ngo/img/storybox/alaa.png" alt="Alaa"/>

                    <div class="info">
                        <div class="name">Alaa</div>
                        <div class="country">Syria</div>
                        <div class="story">Poznaj jej historię</div>
                    </div>
                </a>
            </div>
            <div class="pomocBox col-xs-12 col-sm-6 col-md-3">
                <div class="redbox">
                    <h3>Chcesz pomóc?</h3>
                    <ul class="pomoc">
                        <li><a href="#">Wolontariat</a></li>
                        <li><a href="#">Wsparcie finansowe</a></li>
                        <li><a href="#">Pomoc mieszkaniowa</a></li>
                        <li><a href="#">Pomoc rzeczowa</a></li>
                        <li><a href="#">Pomoc językowa</a></li>
                        <li><a href="#">Zbiórki</a></li>
                        <li><a href="#">Akcja lokalna</a></li>
                        <li><a href="#">Reagowanie na mowę nienawiści</a></li>
                    </ul>
                </div>
            </div>
        </div>


        <?= $this->Element('dataobject/pageEnd'); ?>
