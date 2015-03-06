<?php $this->Combinator->add_libs('css', $this->Less->css('api', array('plugin' => 'Api'))) ?>

<div id="api" class="newLayout">
    <div class="jumbotron">
        <div class="container">
            <h1>API</h1>

            <p>Dowiedz się jak uzyskać dostęp do największego zbioru otwartych danych w Polsce i jak zintegrować je ze
                swoją aplikacją! One API page to rule them all! </p>

            <!--<div class="searchBar col-md-12">-->
            <!--<form method="GET">-->
            <!--<div class="col-md-12 searchFor">-->
            <!--<div class="input-group">-->
            <!--<input type="text" name="q" placeholder="Szukaj w API..." value=""-->
            <!--class="form-control input-lg"-->
            <!--autocomplete="off">-->
            <!--<span class="input-group-btn">-->
            <!--<button class="btn" type="submit"></button>-->
            <!--</span>-->
            <!--</div>-->
            <!--</div>-->
            <!--</form>-->
            <!--</div>-->

        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Informacje ogólne</h2>

                <div class="option col-xs-12 col-sm-6 col-md-4">
                    <h3>Opis techniczny</h3>

                    <p>Chcesz skorzystać z naszego API? Zapoznaj się z wprowadzeniem i informacjami technicznymi
                        wspólnymi dla wszystkich API aplikacji</p>
                    <a class="btn btn-primary btn-sm"
                       href="<?php echo $this->Html->url(array('action' => 'technical_info')); ?>">Więcej</a>
                </div>
            </div>
        </div>

        <hr/>

        <div class="row">
            <div class="col-md-12">
                <h2>Dostępne API</h2>

                <?php foreach ($apis as $api) { ?>
                    <div class="option col-xs-12 col-sm-6 col-md-4" data-icon="">
                        <h3>
                            <span class="icon">
                                <img
                                    src="<?php echo '/' . strtolower($api['slug']) . '/icon/' . $api['slug'] . '.svg' ?>"
                                    alt=""/>
                            </span><?php echo $api['name'];
                            if (intval($api['version']) == 0) {
                                echo ' <span class="beta">BETA</span>';
                            } ?>
                        </h3>

                        <p><?php echo $api['description'] ?></p>
                        <a class="btn btn-primary btn-sm"
                           href="<?php echo $this->Html->url(array(
                               'action' => 'view',
                               'slug' => $api['slug']
                           )); ?>">Zobacz</a>
                    </div>
                <?php } ?>
            </div>
        </div>

        <? if (!empty($clients)) { ?>
            <hr/>

            <div class="row">
                <div class="col-md-12">
                    <h2>Klienci API</h2>
                </div>
            </div>
        <? } ?>

    </div>
</div>