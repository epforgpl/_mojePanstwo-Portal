<? $this->Combinator->add_libs('js', 'Dane.header-vote'); ?>

<? if (isset($uchwala) && isset($header_vote)) {

    $vote_dict = array(

        '-1' => array(
            'Przeciw',
            'danger'
        ),

        '0' => array(
            'Wstrzymałeś/aś się',
            'default'
        ),

        '1' => array(
            'Za',
            'success'
        )

    );

    ?>
    <div class="headerVote">
        <div class="container">

            <h3>
                <a role="button" data-toggle="collapse" href="#headerVoteDetails" aria-expanded="false"
                   aria-controls="headerVoteDetails">
                    <span class="glyphicon glyphicon-menu-hamburger text-muted" aria-hidden="true"></span>
                </a>
                Głosowanie
            </h3>

            <div class="collapse" id="headerVoteDetails">
                <div class="list-group">
                    <?php foreach ($header_vote as $vote) { ?>
                        <a
                            href="<?= (isset($domainMode) && $domainMode == 'MP' ? '/dane/gminy/903,krakow/rada_uchwaly/' . $vote['id'] : '/rada_uchwaly/' . $vote['id']) ?>"
                            class="list-group-item<? if ($vote['id'] == $uchwala->getId()) echo ' disabled'; ?>">
                            <? if ($vote['vote'] !== false) { ?>

                                <span class="label label-<?= $vote_dict[$vote['vote']][1] ?> pull-right">
                                <?= $vote_dict[$vote['vote']][0] ?>
                            </span>

                            <? } ?>
                            <?= strlen($vote['tytul']) > 130 ? substr($vote['tytul'], 0, 130) . '...' : $vote['tytul']; ?>
                        </a>
                    <? } ?>
                </div>
            </div>

            <? if (false !== $key = array_search($uchwala->getId(), array_column($header_vote, 'id'))) {
                $vote = $header_vote[$key];
                if ($vote['vote'] === false) { /* Głosowanie */ ?>

                    <div class="row">
                        <div class="hidden-xs col-sm-5 col-md-8">
                            <div class="progress">
                                <div class="progress-bar progress-bar-info" role="progressbar"
                                     aria-valuenow="<?= $header_vote_progress; ?>" aria-valuemin="0" aria-valuemax="100"
                                     style="width: <?= $header_vote_progress; ?>%">
                                    <?= $header_vote_progress; ?>%
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-7 col-md-4">
                            <form
                                action="<?= (isset($domainMode) && $domainMode == 'MP' ? '/dane/gminy/903,krakow/glosuj' : '/glosuj') ?>"
                                method="post">
                                <input type="hidden" name="vote_id" value="<?= $vote['id']; ?>"/>

                                <div class="voteOptions pull-right">
                                    <button type="submit" name="vote" class="btn btn-success btn-icon auto-width"
                                            value="Za"><i class="icon glyphicon glyphicon-ok"></i>Za
                                    </button>
                                    <button type="submit" name="vote" class="btn btn-primary btn-icon auto-width"
                                            value="Wstrzymuje się"><i class="icon glyphicon glyphicon-minus"></i>Wstrzymuje
                                        się
                                    </button>
                                    <button type="submit" name="vote" class="btn btn-danger btn-icon auto-width"
                                            value="Przeciw"><i class="icon glyphicon glyphicon-remove"></i>Przeciw
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                <? } else { /* Już zagłosowano na ten druk */

                    $next = 0;
                    foreach ($header_vote as $vote) {
                        if ($vote['vote'] === false) {
                            $next = $vote['id'];
                            break;
                        }
                    }

                    if ($next == 0) { ?>

                        <div class="alert alert-info" role="alert">
                            Zakończyłeś głosowanie.
                            <a class="alert-link"
                               href="<?= (isset($domainMode) && $domainMode == 'MP' ? '/dane/gminy/903,krakow/glosuj' : '/glosuj') ?>">Sprawdź
                                wyniki</a>
                            lub
                            <a class="alert-link"
                               href="<?= (isset($domainMode) && $domainMode == 'MP' ? '/dane/gminy/903,krakow/glosuj?reset' : '/glosuj?reset') ?>">rozpocznij
                                proces głosowania od nowa</a>.
                        </div>

                    <? } else { ?>

                        <div class="alert alert-info" role="alert">
                            Już głosowałeś/aś na ten projekt.
                            <a class="alert-link"
                               href="<?= (isset($domainMode) && $domainMode == 'MP' ? '/dane/gminy/903,krakow/rada_uchwaly/' . $next : '/rada_uchwaly/' . $next) ?>">Przejdź
                                do kolejnej uchwały</a>
                            lub
                            <a class="alert-link"
                               href="<?= (isset($domainMode) && $domainMode == 'MP' ? '/dane/gminy/903,krakow/glosuj?reset' : '/glosuj?reset') ?>">rozpocznij
                                proces głosowania od nowa</a>.
                        </div>

                    <? } ?>

                <? } ?>

            <? } else { /* Nie można zagłosować na ten druk */

                $next = 0;
                foreach ($header_vote as $vote) {
                    if ($vote['vote'] === false) {
                        $next = $vote['id'];
                        break;
                    }
                }

                if ($next == 0) { ?>

                    <div class="alert alert-info" role="alert">
                        Zakończyłeś głosowanie.
                        <a class="alert-link"
                           href="<?= (isset($domainMode) && $domainMode == 'MP' ? '/dane/gminy/903,krakow/glosuj' : '/glosuj') ?>">Sprawdź
                            wyniki</a>
                        lub
                        <a class="alert-link"
                           href="<?= (isset($domainMode) && $domainMode == 'MP' ? '/dane/gminy/903,krakow/glosuj?reset' : '/glosuj?reset') ?>">rozpocznij
                            proces głosowania od nowa</a>.
                    </div>

                <? } else { ?>

                    <div class="alert alert-info" role="alert">
                        Nie możesz zagłosować na tę uchwałe.
                        <a class="alert-link"
                           href="<?= (isset($domainMode) && $domainMode == 'MP' ? '/dane/gminy/903,krakow/rada_uchwaly/' . $next : '/rada_uchwaly/' . $next) ?>">Przejdź
                            do kolejnej uchwały</a>
                        lub
                        <a class="alert-link"
                           href="<?= (isset($domainMode) && $domainMode == 'MP' ? '/dane/gminy/903,krakow/glosuj?reset' : '/glosuj?reset') ?>">rozpocznij
                            proces głosowania od nowa</a>.
                    </div>

                <? } ?>

            <? } ?>
        </div>
    </div>
<? } ?>
