<?= $this->element('Admin.header'); ?>
    <h2>Propozycje nowych kont Twitter</h2>


    <? if(!isset($suggestions) || !count($suggestions)) { ?>
        <p class="margin-top-20">Brak propozycji</p>
    <? } else { ?>
        <table class="table table-striped table-hover table-bordered margin-top-20">
            <tr>
                <th>Data utworzenia</th>
                <th>Użytkownik</th>
                <th>Nazwa</th>
                <th>Typ</th>
                <th>Opcje</th>
            </tr>
            <? foreach($suggestions as $suggestion) { ?>
                <tr>
                    <td><?= $suggestion['TwitterAccountSuggestion']['cts']; ?></td>
                    <td>
                        <? if(isset($suggestion['User']['username'])) { ?>
                            <?= $suggestion['User']['username']; ?>
                            (<?= $suggestion['User']['id']; ?> )
                        <? } else { ?>
                            Gość
                        <? } ?>
                    </td>
                    <td>
                        <a href="https://twitter.com/<?= $suggestion['TwitterAccountSuggestion']['name']; ?>">
                            @<?= $suggestion['TwitterAccountSuggestion']['name']; ?>
                        </a>
                    </td>
                    <td>
                        <?= $types[$suggestion['TwitterAccountSuggestion']['type_id']] ?>
                    </td>
                    <td>
                        <div class="btn-group btn-group-sm" role="group">
                            <a href="/admin/twitter_accounts/add/<?= $suggestion['TwitterAccountSuggestion']['id'] ?>" class="btn btn-default">Dodaj</a>
                            <a href="/admin/twitter_accounts/remove/<?= $suggestion['TwitterAccountSuggestion']['id'] ?>" class="btn btn-default">Usuń</a>
                        </div>
                    </td>
                </tr>
            <? } ?>
        </table>
    <? } ?>


<?= $this->element('Admin.footer'); ?>
