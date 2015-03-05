<?
$this->Combinator->add_libs('css', $this->Less->css('view-poslowie', array('plugin' => 'Dane')));
$this->Combinator->add_libs('css', $this->Less->css('dataobjectslider', array('plugin' => 'Dane')));

$this->Combinator->add_libs('js', '../plugins/highcharts/js/highcharts');
$this->Combinator->add_libs('js', '../plugins/highcharts/locals');

$this->Combinator->add_libs('js', 'Dane.view-twitteraccounts');
$this->Combinator->add_libs('js', 'Dane.view-poslowie.js');

echo $this->Element('dataobject/pageBegin');
?>

    <div class="row">

        <div class="subobject">
            <div class="col-lg-9">

                <p><?= $twitter_account->getData('description') ?></p>

            </div>
            <div class="col-lg-3">


                <p><a href="https://twitter.com/<?= $twitter_account->getData('twitter_name') ?>" type="button"
                      class="btn btn-primary pull-right">@<?= $twitter_account->getData('twitter_name') ?></a></p>

            </div>
        </div>

    </div>

    <div class="twitter row">
        <div class="col-md-3 objectSide">
            <div class="objectSideInner">
                <?=
                $this->element('Dane.objects/twitter_accounts/side_div', array(
                    'object' => $twitter_account,
                )) ?>
            </div>
        </div>


        <div class="col-md-9 objectMain">
            <div class="object">
                <div class="block-group">
                    <?=
                    $this->element('Dane.objects/twitter_accounts/main_div', array(
                        'object' => $twitter_account,
                        'twitts' => $twitts,
                    )) ?>
                </div>
            </div>
        </div>
    </div>


<?= $this->Element('dataobject/pageEnd'); ?>