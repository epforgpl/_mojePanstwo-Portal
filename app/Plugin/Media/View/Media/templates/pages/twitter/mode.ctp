<? if ($group['mode'] == 'stats') { ?>

    <? if (isset($type['objects']) && is_array($type['objects']) && !empty($type['objects'])) { ?>
        <ul>
            <?

            $i = 0;
            foreach ($type['objects'] as $object) {
                $i++;

                if ($i > 3) {
                    break;
                }

                ?>

                <li class="account">

                    <? { ?>

                        <div class="avatar"><a href="/dane/twitter_accounts/<?= $object['id'] ?>">
                                <img src="<?= $object['profile_image_url'] ?>" onerror="imgFixer(this)"/>
                            </a></div>
                        <div class="info">
                            <p class="name"><?= $object['name'] ?></p>

                            <? if ($group['preset'] == 'twitter_account_id') { ?>
                                <p class="counter"><?= number_format($object['count'], 0, '.', ' ') ?></p>
                            <? } elseif ($group['preset'] == 'accounts_retweets') { ?>
                                <p class="counter"><?= number_format($object['count'], 0, '.', ' ') ?></p>
                            <? } elseif ($group['preset'] == 'accounts_replies') { ?>
                                <p class="counter"><?= number_format($object['count'], 0, '.', ' ') ?></p>
                            <? } elseif ($group['preset'] == 'mentions') { ?>
                                <p class="counter"><?= number_format($object['count'], 0, '.', ' ') ?></p>
                            <? } ?>
                        </div>
                    <? } ?>
                </li>
                <? if ($i > 10) {
                    break;
                }
            }
            ?>
        </ul>
    <? } else { ?>
        <div class="alert empty small">Brak danych w wybranym przez Ciebie okresie - zwiększ okres analiz.</div>
    <? } ?>

<? } elseif ($group['mode'] == 'account') { ?>

    <? if (isset($type['search']) && is_array($type['search']) && !empty($type['search'])) { ?>
        <ul>
            <?
            $i = 0;
            foreach ($type['search'] as $object) {
                $i++;


                ?>

                <li class="account">
                    <div class="avatar"><a href="/dane/twitter_accounts/<?= $object['id'] ?>">
                            <img src="<?= $object['profile_image_url'] ?>" onerror="imgFixer(this)"/>
                        </a></div>
                    <div class="info">
                        <p class="name">
                            <a href="/dane/twitter_accounts/<?= $object['id'] ?>"><?= $object['name'] ?></a>
                        </p>

                        <p class="counter"><? if ($object['followers_delta_' . $range] > 0) echo "+";
                            echo number_format($object['followers_delta_' . $range], 0, '.', ' ') ?></p>
                    </div>
                    <div class="tweet_stats">
                        <div class="row">

                            <div class="col-lg-4">

                                <p class="_counter small _tooltip" data-toggle="tooltip" data-placement="bottom"
                                   title="Aktualna liczba obserwujących"><span
                                        class="glyphicon glyphicon-unchecked"></span> <?= number_format($object['followers_count'], 0, '.', ' ') ?>
                                </p>

                            </div>

                            <div class="col-lg-4">


                                <p class="_counter plus small _tooltip" data-toggle="tooltip" data-placement="bottom"
                                   title="Liczba nowych subskrypcji"><span
                                        class="glyphicon glyphicon-log-in"></span> <?= number_format($object['followers_add_' . $range], 0, '.', ' ') ?>
                                </p>

                            </div>
                            <div class="col-lg-4">

                                <p class="_counter minus small _tooltip" data-toggle="tooltip" data-placement="bottom"
                                   title="Liczba usuniętych subskrypcji"><?= number_format($object['followers_diff_' . $range], 0, '.', ' ') ?>
                                    <span class="glyphicon glyphicon-log-out"></span></p>

                            </div>
                        </div>
                    </div>
                </li>
                <? if ($i > 10) {
                    break;
                }
            }
            ?>
        </ul>
    <? } else { ?>
        <div class="alert empty small">Brak danych w wybranym przez Ciebie okresie - zwiększ okres analiz.</div>
    <? } ?>

    <?
    $params = array(
        'typ_id' => $type['id'],
    );

    if (@$group['order']) {
        $params['order'] = $group['order'];
    }

    if (@$group['link']['order']) {
        $params['order'] = $group['link']['order'];
    }

    $href = '/dane/' . $group['link']['dataset'] . '?' . http_build_query($params);
    ?>

<? } elseif ($group['mode'] == 'tag') { ?>

    <? if (isset($type['objects']) && is_array($type['objects']) && !empty($type['objects'])) { ?>
        <ul>
            <?
            $i = 0;
            foreach ($type['objects'] as $object) {
                $i++;
                $href = '/dane/twitter/?!bez_retweetow=1&tags[]=' . $object['id'] . '&twitter_accounts%3Atyp_id[]=' . $type['id'] . '&_date=LAST_' . $range;
                ?>
                <li class="list-group-item">
                    <span class="badge"><?= number_format($object['count'], 0, '.', ' ') ?></span>
                    <a href="#">#<?= $object['name'] ?></a>
                </li>
                <? if ($i >= 5) {
                    break;
                }
            }
            ?>
        </ul>
    <? } else { ?>
        <div class="alert empty small">Brak danych w wybranym przez Ciebie okresie - zwiększ okres analiz.</div>
    <? } ?>

<? } elseif ($group['mode'] == 'url') { ?>

    <? if (isset($type['objects']) && is_array($type['objects']) && !empty($type['objects'])) { ?>
        <ul>
            <?
            $i = 0;
            foreach ($type['objects'] as $object) {
                $i++;

                $object['title'] = $object['name'];
                $object['url'] = $object['name'];

                if (stripos($object['title'], 'http://') === 0) {
                    $object['title'] = substr($object['title'], 7);
                }

                if (stripos($object['title'], 'https://') === 0) {
                    $object['title'] = substr($object['title'], 8);
                }

                if (stripos($object['title'], 'www.') === 0) {
                    $object['title'] = substr($object['title'], 4);
                }

                ?>

                <li class="list-group-item">
                    <span class="badge"><?= number_format($object['count'], 0, '.', ' ') ?></span>
                    <a href="<?= $object['url'] ?>" title="<?= $object['title'] ?>"
                       target="_blank"><?= substr($object['title'], 0, 26) ?><? if (strlen($object['title']) > 26) { ?>...<? } ?></a>
                </li>
                <?
                if ($i >= 5) {
                    break;
                }
            }
            ?>

        </ul>

    <? } else { ?>
        <div class="alert empty small">Brak danych w wybranym przez Ciebie okresie - zwiększ okres analiz.</div>
    <? } ?>

<? } elseif ($group['mode'] == 'source') { ?>

    <? if (isset($type['objects']) && is_array($type['objects']) && !empty($type['objects'])) { ?>
        <ul>

            <?
            $i = 0;
            foreach ($type['objects'] as $object) {
                $i++;


                ?>

                <li class="list-group-item">

                    <span class="badge"><?= number_format($object['count'], 0, '.', ' ') ?></span>
                    <?= strip_tags($object['name']) ?>

                </li>

                <?
                if ($i >= 3) {
                    break;
                }
            }
            ?>

        </ul>

    <? } else { ?>
        <div class="alert empty small">Brak danych w wybranym przez Ciebie okresie - zwiększ okres analiz.</div>
    <? } ?>

<? } elseif ($group['mode'] == 'tweet') { ?>

    <? if (isset($type['objects']) && is_array($type['objects']) && !empty($type['objects'])) { ?>
        <ul>

            <?
            $i = 0;
            foreach ($type['objects'] as $object) {
                $i++;
                ?>

                <li class="tweet" tweet_id="<?= $object->getId() ?>">

                    <div class="tweet_header">
                        <div class="avatar">
                            <p>
                                <img src="<?= $object->getData('twitter_accounts.profile_image_url') ?>"
                                     onerror="imgFixer(this)"/>
                            </p>
                        </div>
                        <div class="data">

                            <p class="date"><?= $this->Czas->dataSlownie($object->getData('czas_utworzenia')) ?> <?= substr($object->getData('czas_utworzenia'), 11, 5) ?></p>

                            <p class="account"><a
                                    href="/dane/twitter_accounts/<?= $object->getData('twitter_accounts.id') ?>"><?= $object->getData('twitter_accounts.name') ?></a>
                            </p>

                        </div>
                    </div>

                    <div class="tweet_content">
                        <p><?= $object->getData('html'); ?></p>
                    </div>

                    <div class="tweet_stats">
                        <div class="row">
                            <div class="col-lg-6">
                                <p class="_counter">
                                    <a title="Liczba retweetów"
                                       href="/dane/twitter/<?= $object->getId() ?>"><span
                                            class="glyphicon glyphicon-retweet"></span> <?= number_format($object->getData('liczba_retweetow'), 0, '.', ' ') ?>
                                    </a>
                                </p>
                            </div>
                            <div class="col-lg-6">
                                <p class="_counter">
                                    <a title="Liczba odpowiedzi"
                                       href="/dane/twitter/<?= $object->getId() ?>"><span
                                            class="glyphicon glyphicon-transfer"></span> <?= $object->getData('liczba_zaangazowan') ?>
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>

                </li>


                <?
                if ($i > 10) {
                    break;
                }
            }
            ?>
        </ul>

    <? } else { ?>
        <div class="alert empty small">Brak danych w wybranym przez Ciebie okresie - zwiększ okres analiz.</div>
    <? } ?>

    <?
    $params = array(
        'twitter_accounts:typ_id' => $type['id'],
    );

    if (@$group['order']) {
        $params['order'] = $group['order'];
    }

    if (@$group['link']['order']) {
        $params['order'] = $group['link']['order'];
    }

    $href = '/dane/' . $group['link']['dataset'] . '?' . http_build_query($params);
    ?>

<? } ?>
