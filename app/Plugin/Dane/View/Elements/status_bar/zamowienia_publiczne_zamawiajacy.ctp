<ul class="dataHighlights oneline col-xs-12">
		
    <?
    if( $rodzaj = $object->getData('rodzaj') ) { ?>
        <li class="dataHighlight col-sm-8">
            <p class="_value"><?= $rodzaj ?></p>
        </li>
    <? } ?>
    
    <?
    $www = $www = $object->getData('www');
    if (isset($www) && !empty($www)) {
        $url = (stripos($www, 'http') === false) ? 'http://' . $www : $www;
        ?>
        <li class="dataHighlight col-sm-4">
            <p class="_label">Strona WWW</p>

            <p class="_value"><a target="_blank" title="<?= addslashes($object->getTitle()) ?>"
                                 href="<?= $url ?>"><?= $www; ?></a></p>
        </li>
    <? } ?>
    
    <?
    if( $regon = $object->getData('regon') ) { ?>
        <li class="dataHighlight col-sm-4">
            <p class="_label">REGON</p>

            <p class="_value"><?= $regon ?></p>
        </li>
    <? } ?>
    
	<?
    $tel = $object->getData('telefon');
    if (isset($tel) && !empty($tel)) { ?>
        <li class="dataHighlight col-sm-4">
            <p class="_label">Telefon</p>

            <p class="_value"><?= $tel ?></p>
        </li>
    <? } ?>
    
    <?
    $fax = $object->getData('fax');
    if (isset($fax) && !empty($fax)) { ?>
        <li class="dataHighlight col-sm-4">
            <p class="_label">Fax</p>

            <p class="_value"><?= $fax ?></p>
        </li>
    <? } ?>    
    
</ul>