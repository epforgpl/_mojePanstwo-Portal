<?
$this->Combinator->add_libs('css', $this->Less->css('zbiorki_publiczne', array('plugin' => 'ZbiorkiPubliczne')));
echo $this->Html->css($this->Less->css('app'));

$this->Combinator->add_libs('js', 'ZbiorkiPubliczne.zbiorki_publiczne.js');

echo $this->element('headers/main');
echo $this->element('app/sidebar');
?>

<div class="app-content-wrap">
    <div class="objectsPage">
        <div id="zbiorkiPubliczne" class="container">
            <div class="appBanner margin-top-20">
                <h1 class="appTitle">Zbiórka publiczna</h1>
                <p class="appSubtitle">Sprawozdania</p>
            </div>
            <div class="sections col-xs-12">
                <div class="sections col-xs-12">
                    <? echo $this->Element('ZbiorkiPubliczne.form1') ?>
                </div>
                <div class="sections col-xs-12">
                    <? echo $this->Element('ZbiorkiPubliczne.form2') ?>
                </div>
            </div>
            <div class="sectionsBtn col-xs-12 text-center">
                <button class="btn btn-primary btn-lg disabled">Dalej</button>
            </div>
        </div>
    </div>
</div>
