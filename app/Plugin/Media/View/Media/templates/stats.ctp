<? if (isset($this->request->query['info']) && $this->request->query['info']) { ?>


    <div class="row">
        <div class="col-lg-6 col-lg-offset-3">
            <div class="stats">

                <p class="time">Pozostało tweetów do pobrania:
                    <strong><?= number_format($stats['tweets_download']['queue_count'], 0, '.', ' ') ?></strong></p>

                <p class="time">Prędkość pobierania:
                    <strong><?= number_format($stats['tweets_download']['hour_downloaded_count'], 0, '.', ' ') ?> /
                        h</strong></p>

                <p class="time">Prognoza zakończenia: <strong><?


                        $ts = time();
                        $ts += $stats['tweets_download']['hours_left'] * 3600;

                        echo date('Y-m-d H:i:s', $ts);


                        ?></strong></p>

                <p class="_label">Pobieranie twettów:
                    <strong><?= round(100 * $stats['tweets_download']['progress'], 2) ?> %</strong></p>

                <div class="bs-example">
                    <div class="progress progress-striped active">
                        <div style="width: <?= round(100 * $stats['tweets_download']['progress'], 2) ?>%"
                             class="progress-bar"></div>
                    </div>
                </div>


                <p class="time">Pozostało tweetów do przetworzenia:
                    <strong><?= number_format($stats['tweets_analyse']['queue_count'], 0, '.', ' ') ?></strong></p>

                <p class="time">Prędkość przetwarzania:
                    <strong><?= number_format($stats['tweets_analyse']['hour_analysed_count'], 0, '.', ' ') ?> /
                        h</strong></p>

                <p class="time">Prognoza zakończenia: <strong><?


                        $ts = time();
                        $ts += $stats['tweets_analyse']['hours_left'] * 3600;

                        echo date('Y-m-d H:i:s', $ts);


                        ?></strong></p>

                <p class="_label">Przetwarzanie twettów:
                    <strong><?= round(100 * $stats['tweets_analyse']['progress'], 2) ?> %</strong></p>

                <div class="bs-example">
                    <div class="progress progress-striped active">
                        <div style="width: <?= round(100 * $stats['tweets_analyse']['progress'], 2) ?>%"
                             class="progress-bar progress-bar-success"></div>
                    </div>
                </div>


                <p class="time">Pozostało tweetów do zaindeksowania:
                    <strong><?= number_format($stats['tweets_index']['queue_count'], 0, '.', ' ') ?></strong></p>

                <p class="time">Prędkość indeksowania:
                    <strong><?= number_format($stats['tweets_index']['hour_indexed_count'], 0, '.', ' ') ?> /
                        h</strong>
                </p>

                <p class="time">Prognoza zakończenia: <strong><?


                        $ts = time();
                        $ts += $stats['tweets_index']['hours_left'] * 3600;

                        echo date('Y-m-d H:i:s', $ts);


                        ?></strong></p>

                <p class="_label">Indeksowanie twettów:
                    <strong><?= round(100 * $stats['tweets_index']['progress'], 2) ?> %</strong></p>

                <div class="bs-example">
                    <div class="progress progress-striped active">
                        <div style="width: <?= round(100 * $stats['tweets_index']['progress'], 2) ?>%"
                             class="progress-bar progress-bar-success"></div>
                    </div>
                </div>


                <p class="time">Wygenerowano: <strong><?= date('Y-m-d- H:i:s', $stats['time']) ?></strong></p>

            </div>
        </div>
    </div>

<? } ?>