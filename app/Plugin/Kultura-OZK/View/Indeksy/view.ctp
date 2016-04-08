<div class="container">
    <div class="row">
        <div class="col-md-12">

            <h1><?= $index['details']['nazwa'] ?></h1>

            <hr style="border-color: #CCC;"/>

            <div class="row">

                <div class="col-md-6">

                    <h2>Organizacje</h2>

                    <div class="alert alert-dismissable alert-info">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        Organizacje, dla których przeważa wybrany indeks. Liczby oznaczają punktację, którą uzyskał
                        indeks dla danej organizacji.
                    </div>

                    <ul class="list-group">
                        <? foreach ($index['organizations'] as $org) { ?>
                            <li class="list-group-item">
                                <span class="badge"><?= _number($org['score']) ?></span>
                                <a target="_blank" href="/dane/krs_podmioty/<?= $org['id'] ?>/kultura">
                                    <?= $org['nazwa'] ?>
                                </a>
                            </li>
                        <? } ?>
                    </ul>


                </div>

                <div class="col-md-6">

                    <h2>Działalności</h2>

                    <div class="alert alert-dismissable alert-info">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        Działalności właściwe dla danego indeksu. Liczby oznaczają wolumen organizacji, dla których
                        przeważa wybrany indeks i które zadeklarowały daną działalność. Kolejność występowania
                        działalności dla danej organizacji nie jest brana pod uwagę w tym zestawieniu.
                    </div>

                    <ul class="list-group">
                        <? foreach ($index['pkd'] as $pkd) { ?>
                            <li class="list-group-item">
                                <span class="badge"><?= _number($pkd['count']) ?></span>
                                <?= $pkd['nazwa'] ?>
                            </li>
                        <? } ?>
                    </ul>


                </div>

            </div>

        </div>
    </div>
</div>