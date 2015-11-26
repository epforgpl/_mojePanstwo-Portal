<? $pismo = $object->getData();
$this->Combinator->add_libs('css', $this->Less->css('letters', array('plugin' => 'Start')));
$this->Combinator->add_libs('css', $this->Less->css('letters-responses', array('plugin' => 'Start')));
$this->Combinator->add_libs('css', $this->Less->css('public-letters', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('dataobject', array('plugin' => 'Dane')));

$accessDict = array(
    'prywatna',
    'publiczna'
);

?>

<div class="container margin-top-20">
    <div class="row">
        <div class="col-sm-9">

            <div class="letter-table">
                <div class="row">
                    <div class="col-sm-2">
                        <p class="_label">Od:</p>
                    </div>
                    <div class="col-sm-10">
                        <p>
                            <a title="Profil użytkownika <?= $pismo['from_user_name'] ?>" href="/dane/uzytkownicy/<?= $pismo['pisma.from_user_id'] ?>">
                                <?= $pismo['from_user_name'] ?>
                            </a>
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-2">
                        <p class="_label">Do:</p>
                    </div>
                    <div class="col-sm-10">
                        <p><?= $pismo['to_label'] ?></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-2">
                        <p class="_label">Temat:</p>
                    </div>
                    <div class="col-sm-10">
                        <p><?= $pismo['template_name'] ?></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="text">
                            <?= $pismo['content'] ?>
                        </div>
                    </div>
                </div>
                <? if ($pismo['sent']) { ?>
                    <div class="row sent">
                        <div class="col-sm-12">
                            <p>Wysłano <?= dataSlownie($pismo['sent_at']) ?></p>
                        </div>
                    </div>
                <? } ?>
                <? if ($pismo['is_public']) { ?>
                    <div class="shareList">
                        <?
                        $share_url = 'https://mojepanstwo.pl/dane/pisma/' . $pismo['id'];

                        if ($pismo['object_id']) {
                            $share_url = 'https://mojepanstwo.pl/dane/' . $pismo['page_dataset'] . '/' . $pismo['page_object_id'] . ',' . $pismo['page_slug'] . '/pisma/' . $pismo['id'];
                        }
                        ?>
                        <p>Podziel się pismem:</p>
                        <ul class="share share-center">
                            <li><a href="https://www.facebook.com/sharer/sharer.php?u=<?= $share_url ?>"
                                   onclick="window.open('https://www.facebook.com/sharer/sharer.php?u=<?= $share_url ?>', 'mywin',
                                       'left=20,top=20,width=500,height=500,toolbar=1,resizable=0'); return false;"
                                   class="btn btn-social-icon btn-sm btn-facebook"><i class="fa fa-facebook"></i></a>
                            </li>
                            <li><a href="https://twitter.com/home?status=<?= $share_url ?>"
                                   onclick="window.open('https://twitter.com/home?status=<?= $share_url ?>', 'mywin',
                                       'left=20,top=20,width=500,height=500,toolbar=1,resizable=0'); return false;"
                                   class="btn btn-social-icon btn-sm btn-twitter"><i class="fa fa-twitter"></i></a></li>
                            <li><a href="http://www.wykop.pl/dodaj/link/?url=<?= $share_url ?>"
                                   onclick="window.open('http://www.wykop.pl/dodaj/link/?url=<?= $share_url ?>', 'mywin',
                                       'left=20,top=20,width=500,height=500,toolbar=1,resizable=0'); return false;"
                                   class="btn btn-social-icon btn-sm btn-wykop"></a></li>
                        </ul>
                    </div>
                <? } ?>
            </div>

            <div class="lettersResponses">
                <div class="row margin-top-20">
                    <div class="col-md-12">

                        <ul class="responses">
                            <? if (isset($responses) && is_array($responses) && count($responses)) { ?>
                                <? foreach ($responses as $response) { ?>
                                    <li class="response">
                                        <h2>
                                            <?= $response['Response']['title'] ?>
                                            <span class="date"><?= dataSlownie($response['Response']['date']) ?></span>
                                        </h2>

                                        <div class="content">
                                            <?= $response['Response']['content'] != '' ? htmlspecialchars($response['Response']['content']) : 'Brak treści' ?>
                                        </div>
                                        <? if (count($response['files'])) { ?>
                                            <div class="files">
                                                <? foreach ($response['files'] as $file) { ?>
                                                    <div class="file">
                                                        <a target="_blank"
                                                           href="/dane/pisma/<?= $pismo['id'] ?>/attachment/<?= $file['ResponseFile']['id'] ?>"><span
                                                                class="glyphicon glyphicon-download-alt"></span>
                                                            <?= $file['ResponseFile']['src_filename'] != '' ? $file['ResponseFile']['src_filename'] : 'Brak nazwy' ?>
                                                        </a>
                                                    </div>
                                                <? } ?>
                                            </div>
                                        <? } ?>
                                    </li>
                                <? } ?>
                            <? } ?>
                        </ul>

                    </div>
                </div>
            </div>
        </div><div class="col-sm-3">

            <? if($pismo['from_user_id'] == AuthComponent::user('id')) { ?>
                <div class="margin-top-10">
                    <a class="btn btn-sm auto-width btn-primary btn-icon btn-auto-width" href="/moje-pisma/<?= $pismo['alphaid'] ?>">
                        <i class="icon glyphicon glyphicon-pencil"></i>
                        Zarządzaj pismem
                    </a>
                </div>
            <? } ?>

        </div>
    </div>
</div>
