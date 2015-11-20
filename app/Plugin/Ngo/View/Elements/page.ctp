<?
$this->Combinator->add_libs('css', $this->Less->css('ngo', array('plugin' => 'Ngo')));
$this->Combinator->add_libs('js', 'Dane.DataBrowser.js');

?>

<div class="col-xs-12 col-sm-4 col-md-1-5 noleftpadding dataAggsContainer">
    <div class="mp-sticky mp-sticky-disable-sm-4" data-widthFromWrapper="false">
        <? echo $this->Element('Dane.DataBrowser/app_chapters'); ?>
        <?
        $this->Combinator->add_libs('js', 'Media.twitter-account-suggestion');
        $this->Combinator->add_libs('css', $this->Less->css('banners-box', array('plugin' => 'Dane')));
        $this->Combinator->add_libs('css', $this->Less->css('twitter-account-suggestion', array('plugin' => 'Media')));
        ?>
    </div>
</div>

<div class="col-xs-12 col-sm-8 col-md-4-5 norightpadding">

    <div class="dataWrap">

        <p>Test</p>

    </div>
</div>
