<? $this->Combinator->add_libs('js', 'Dane.header-vote'); ?>

<? if(isset($druk) && isset($header_vote)) { ?>
    <div class="headerVote">
        <div class="container">
            <? if(false !== $key = array_search($druk->getId(), array_column($header_vote, 'id'))) {
                $vote = $header_vote[$key];
                if($vote['vote'] === false) { /* Głosowanie */ ?>

                    <div class="row">
                        <div class="col-md-9">
                            <div class="progress">
                                <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="<?= $header_vote_progress; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= $header_vote_progress; ?>%">
                                    <?= $header_vote_progress; ?>%
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <form action="<?= (isset($domainMode) && $domainMode == 'MP' ? '/dane/gminy/903,krakow/glosuj' : '/glosuj') ?>" method="post">
                                <input type="hidden" name="vote_id" value="<?= $vote['id']; ?>"/>
                                <div class="voteOptions pull-right">
                                    <input type="submit" name="vote" class="btn btn-link btn-link-success" value="Za"/>
                                    <input type="submit" name="vote" class="btn btn-link btn-link-default" value="Wstrzymuje się"/>
                                    <input type="submit" name="vote" class="btn btn-link btn-link-danger" value="Przeciw"/>
                                </div>
                            </form>
                        </div>
                    </div>

                <? } else { /* Już zagłosowano na ten druk */

                    $next = 0;
                    foreach($header_vote as $vote) {
                        if($vote['vote'] === false) {
                            $next = $vote['id'];
                            break;
                        }
                    }

                    ?>

                    <div class="alert alert-warning" role="alert">
                        Już głosowałeś/aś na ten projekt.
                        <a href="<?= (isset($domainMode) && $domainMode == 'MP' ? '/dane/gminy/903,krakow/druki/' . $next : '/druki/' . $next) ?>">Przejdź do kolejnego projektu</a>
                        lub
                        <a href="<?= (isset($domainMode) && $domainMode == 'MP' ? '/dane/gminy/903,krakow/glosuj?reset' : '/glosuj?reset') ?>">rozpocznij proces głosowania od nowa</a>.
                    </div>

                <? } ?>

            <? } else { /* Nie można zagłosować na ten druk */ ?>

                <p>Nie można zagłosować na ten druk</p>

            <? } ?>
        </div>
    </div>
<? } ?>