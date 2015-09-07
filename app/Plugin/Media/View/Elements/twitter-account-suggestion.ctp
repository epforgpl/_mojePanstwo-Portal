<?
$this->Combinator->add_libs('js', 'Media.twitter-account-suggestion');
$this->Combinator->add_libs('css', $this->Less->css('banners-box', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('twitter-account-suggestion', array('plugin' => 'Media')));
?>

<div class="banner odpis block">
    <?php echo $this->Html->image('Dane.banners/twitter_banner.png', array(
        'width' => '62',
        'alt' => 'Twitter',
        'class' => 'pull-right margin-top-30'
    )); ?>
    <p><strong>Pozwól monitorować</strong> swoje tweety!</p>
    <a href="#" data-toggle="modal" data-target="#twitterAccountSuggestionModal" class="btn btn-sm btn-primary">Dodaj konto</a>
</div>

<div class="modal fade" id="twitterAccountSuggestionModal" tabindex="-1" role="dialog"
     aria-labelledby="uprawnieniaModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Zaproponuj nowe konto</h4>
            </div>
            <form class="form-horizontal" method="post">
                <div class="modal-body margin-sides-20">
                    <p class="text-center">W naszych bazach gromadzimy aktywności osób publicznych, organizacji i urzędów. Jeśli chcesz, abyśmy analizowali również Twój profil, wypełnij poniższy formularz:</p>

                    <div class="form-cont">
	                    <div class="form-group">
	                        <label for="inputName">URL</label>
	                        <input required="required" autocomplete="off" type="text" class="form-control" name="name">
	                        <span class="help-block">
	                            Wklej tutaj link do swojego profilu na Twitterze.
	                        </span>
	                    </div>
	                    <div class="form-group">
	                        <label for="inputSurname">Jestem</label>
	                        <select class="form-control" name="type_id">
	                            <?php foreach(array(
	                                2 => 'Komentatorem politycznym',
	                                3 => 'Przedstawicielem urzędu',
	                                7 => 'Politykiem',
	                                8 => 'Przedstawicielem partii politycznej',
	                                9 => 'Przedstawicielem organizacji pozarządowej') as $i => $type) { ?>
	                                <option value="<?= $i ?>"><?= $type ?></option>
	                            <? } ?>
	                        </select>
	                        <span class="help-block">
	                            Zaznacz typ swojego profilu.
	                        </span>
	                    </div>
                    </div>
                    
                    <p class="text-center">Po weryfikacji Twojego konta, dodamy je do naszej bazy.</p>

                </div>
                <div class="modal-footer text-center">
                    <button type="submit" class="btn btn-primary btn-icon auto-width">
                        <i class="icon" data-icon="&#xe604;"></i>Wyślij
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
