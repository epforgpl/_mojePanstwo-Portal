<?
echo $this->Combinator->add_libs('css', $this->Less->css('view-gminy', array('plugin' => 'Dane')));
if ($object->getId() == '903') {
    $this->Combinator->add_libs('css', $this->Less->css('view-gminy-krakow', array('plugin' => 'Dane')));
}

echo $this->Element('dataobject/pageBegin', array(
    'titleTag' => 'p',
));
?>


    <?
    echo $this->Element('Dane.dataobject/subobject', array(
        'menu' => isset($_submenu) ? $_submenu : false,
        'object' => $komisja,
        'objectOptions' => array(
            'bigTitle' => true,
        )
    ));

    $options = array(
	    'searcher' => false,
    );
    if (isset($title))
        $options['title'] = $title;
    echo $this->Element('Dane.DataBrowser/browser', $options);
    ?>


<?php
echo $this->Element('dataobject/pageEnd', array(
    'titleTag' => 'p',
));
?>