<?
$this->Combinator->add_libs('css', $this->Less->css('media', array('plugin' => 'Media')));
$this->Combinator->add_libs('js', 'jquery-tags-cloud-min');
$this->Combinator->add_libs('js', 'Media.media');
?>

<?= $this->Element('appheader'); ?>

<div id="media">
    <? include('templates/pages/twitter.ctp'); ?>
</div>