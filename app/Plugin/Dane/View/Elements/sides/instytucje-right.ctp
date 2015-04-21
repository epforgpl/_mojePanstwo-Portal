<?
$this->Combinator->add_libs('css', $this->Less->css('view-administracjapubliczna', array('plugin' => 'Dane')));
// $this->Combinator->add_libs('css', $this->Less->css('dataobjectslider', array('plugin' => 'Dane')));
$this->Combinator->add_libs('js', 'Dane.view-administracjapubliczna');
?>
<div class="objectSideInner">

    

    <? if (
        ($nadrzedna = $object->getLayer('instytucja_nadrzedna')) ||
        $object->getData('liczba_instytucji')
    ) { ?>
        <div class="block">

            <ul class="dataHighlights side">

                <? if ($nadrzedna = $object->getLayer('instytucja_nadrzedna')) { ?>
                    <li class="dataHighlight">
                        <p class="_label">Instytucja nadrzędna</p>

                        <p class="_value pull-left"><a
                                href="/dane/instytucje/<?= $nadrzedna['id'] ?><? if ($nadrzedna['slug']) { ?>,<?= $nadrzedna['slug'] ?><? } ?>"><?= $nadrzedna['nazwa'] ?></a>
                        </p>
                    </li>
                <? } ?>

                

                <? if ($object->getData('liczba_instytucji')) { ?>
                    <li class="dataHighlight">
                        <a href="<?= $object->getUrl() ?>/instytucje"><span class="icon icon-moon">&#xe611;</span>Instytucje
                            nadzorowane <span class="glyphicon glyphicon-chevron-right"></span></a>
                    </li>
                <? } ?>
	
	            <? if (false && $object->getData('twitter_account_id')) { ?>
	                <li class="dataHighlight">
	                    <a href="/dane/twitter_accounts/<?= $object->getData('twitter_account_id') ?>"><span
	                            class="icon icon-moon">&#xe61d;</span>Tweety <span
	                            class="glyphicon glyphicon-chevron-right"></span></a>
	                </li>
	            <? } ?>

            </ul>

        </div>
    <? } ?>


	<? if ($object->getData('budzet_plan')) { ?>
        <div class="block">

            <ul class="dataHighlights side">

                <? if ($object->getData('budzet_plan')) { ?>
                    <li class="dataHighlight big">
                        <p class="_label" data-toggle="tooltip" data-placement="top"
                           title="Budżet roczny organizacji, finansowany z budżetu państwa">Budżet
                            roczny</p>

                        <div>
                            <p class="_value pull-left"><?= number_format_h($object->getData('budzet_plan') * 1000) ?>
                                PLN</p>

                            <p class="pull-right nopadding"><a class="btn btn-sm btn-default"
                                                               href="/dane/instytucje/<?= $object->getId() ?>/budzet">Szczegóły &raquo;</a>
                            </p>
                        </div>
                    </li>
                <? } ?>

            </ul>

        </div>
    <? } ?>


    <div class="block">

        <ul class="dataHighlights side">
            
            <? if ($www = $object->getData('www')) {
                $url = (stripos($www, 'http') === false) ? 'http://' . $www : $www;
                ?>
                <li class="dataHighlight">
                    <p class="_label">Adres WWW</p>

                    <p class="_value"><a target="_blank" title="<?= addslashes($object->getTitle()) ?>"
                                         href="<?= $url ?>"><?= $www; ?></a></p>
                </li>
            <? } ?>
            
            <? if ($email = $object->getData('email')) { ?>
                <li class="dataHighlight">
                    <p class="_label">Adres e-mail</p>

                    <p class="_value"><a target="_blank" href="mailto:<?= $email ?>"><?= $email; ?></a>
                    </p>
                </li>
            <? } ?>

            <? if ($object->getData('phone')) { ?>
                <li class="dataHighlight">
                    <p class="_label">Telefon</p>

                    <p class="_value"><?= $object->getData('phone'); ?></p>
                </li>
            <? } ?>

            <? if ($object->getData('fax')) { ?>
                <li class="dataHighlight">
                    <p class="_label">Fax</p>

                    <p class="_value"><?= $object->getData('fax'); ?></p>
                </li>
            <? } ?>

        </ul>
        
    </div>
    
    
    
    
    <div class="block">
        
        <p class="text-center">
	        <a class="actionIcons icon api" target="_blank" href="#" data-toggle="modal"
               data-target=".modal-api-call"><span
                    class="glyphicon glyphicon-cog"></span>API
            </a>
        </p>

    </div>
    
    
    


</div>