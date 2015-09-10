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

