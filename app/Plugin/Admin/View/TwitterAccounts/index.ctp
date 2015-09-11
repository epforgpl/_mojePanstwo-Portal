<?
	$this->Combinator->add_libs('js', 'Admin.twitterSuggestions');
	echo $this->element('Admin.header');
?>
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
                        <form id="twitterSuggestionsForm" action="/admin/twitter_accounts/add/<?= $suggestion['TwitterAccountSuggestion']['id'] ?>" method="post">
                            
                            <select name="type" class="form-control pull-left" style="width: inherit;">
                                <? foreach($types as $id => $type) { ?>
                                    <option value="<?= $id ?>"<? if($id == $suggestion['TwitterAccountSuggestion']['type_id']) echo ' selected="selected"';?>>
                                        <?= $type ?>
                                    </option>
                                <? } ?>
                            </select>
                
	                        <div class="btn-group btn-group-sm pull-right" role="group">
	                            <input type="submit" class="btn btn-default" value="Dodaj"/>
	                            <a href="/admin/twitter_accounts/remove/<?= $suggestion['TwitterAccountSuggestion']['id'] ?>" class="btn btn-default">Usuń</a>
	                        </div>

                        </form>

                    </td>
                </tr>
            <? } ?>
        </table>
    <? } ?>


<?= $this->element('Admin.footer'); ?>
