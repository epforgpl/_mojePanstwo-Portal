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
                <form action="/admin/twitter_accounts/add/<?= $suggestion['TwitterAccountSuggestion']['id'] ?>" method="post">
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
                            <select name="type" class="form-control">
                                <? foreach($types as $id => $type) { ?>
                                    <option value="<?= $id ?>"<? if($id == $suggestion['TwitterAccountSuggestion']['type_id']) echo ' selected';?>>
                                        <?= $type ?>
                                    </option>
                                <? } ?>
                            </select>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group">
                                <input type="submit" class="btn btn-default" value="Dodaj"/>
                                <a href="/admin/twitter_accounts/remove/<?= $suggestion['TwitterAccountSuggestion']['id'] ?>" class="btn btn-default">Usuń</a>
                            </div>
                        </td>
                    </tr>
                </form>
            <? } ?>
        </table>
    <? } ?>


<?= $this->element('Admin.footer'); ?>
