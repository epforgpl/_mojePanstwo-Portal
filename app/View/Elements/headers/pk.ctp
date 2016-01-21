<?
$this->Combinator->add_libs('css', $this->Less->css('appheader'));
$this->Combinator->add_libs('js', array('appheader'));
?>
<div class="appHeader pk">
    <div class="container">
        <div class="holder">
            <div class="attachment col-xs-8 col-sm-5 col-md-3 text-center">
                <a class="thumb_cont" href="http://przejrzystykrakow.pl" title="Link do strony Przejrzystego Krakowa">
                    <img class="thumb" src="/dane/img/customObject/krakow/logo_pkrk.png"
                         alt="Logo Przejrzystego Krakowa"/>
                </a>
            </div>
            <div class="content col-xs-12 col-sm-7 col-md-9">
                <p class="header">
                    Portal oparty o dane publiczne o Krakowie. Prowadzony przez <a href="http://www.stanczyk.org.pl/"
                                                                                   target="_blank"
                                                                                   title="Link do strony Fundacji Stańczyka">Fundację
                        Stańczyka</a>.
                </p>
            </div>
        </div>
    </div>
</div>

<? echo $this->Element('menu'); ?>
