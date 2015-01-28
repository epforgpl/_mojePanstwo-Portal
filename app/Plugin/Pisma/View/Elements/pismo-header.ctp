<div class="row">
    <div class="col-md-12 pismoTitle">
        <div class="titleBlock">
            <h1 contenteditable="true" data-url="<?= $pismo['alphaid'] . ',' . $pismo['slug'] ?>">
                <?= $pismo['nazwa'] ?>
            </h1>
        </div>

        <? if ( !$this->Session->read('Auth.User.id') && isset($alert) && $alert ) { ?>
            <div class="alert alert-dismissable alert-warning">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <h4>Uwaga!</h4>

                <p>Nie jesteś zalogowany. Twoje pisma będą przechowywane na tym urządzeniu przez 24 godziny. <a
                        class="_specialCaseLoginButton" href="/login">Zaloguj się</a>, aby trwale przechowywać pisma na
                    swoim koncie.</p>
            </div>
        <? } ?>

        <? if ($pismo['from_user_type'] == 'account') { ?>
            <div class="letter-meta">
                <?php if (!empty($pismo['from_user_name'])) { ?>Autor: <?= $pismo['from_user_name'];
                } ?>
            </div>
        <? } ?>

    </div>
</div>