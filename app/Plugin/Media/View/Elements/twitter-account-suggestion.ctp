<?
$this->Combinator->add_libs('js', 'Media.twitter-account-suggestion');
$this->Combinator->add_libs('css', $this->Less->css('banners-box', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('twitter-account-suggestion', array('plugin' => 'Media')));
?>

<div class="banner twitter block margin-top-10">
    <?php echo $this->Html->image('Dane.banners/twitter_banner.png', array(
        'width' => '64',
        'alt' => 'Twitter',
        'class' => 'pull-left'
    )); ?>
    <p><strong>Pozwól monitorować</strong> swoje tweety!</p>
    <a href="#" data-toggle="modal" data-target="#twitterAccountSuggestionModal" class="btn btn-sm btn-primary">Dodaj konto</a>
</div>

