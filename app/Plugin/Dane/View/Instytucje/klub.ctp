<?
echo $this->Element('dataobject/pageBegin', array(
    'titleTag' => 'p',
));

echo $this->Element('Dane.dataobject/subobject', array(
    'object' => $klub,
    'objectOptions' => array(
        'truncate' => 1000,
        'mode' => 'subobject',
    ),
    'menu' => $_submenu,
));

echo $this->Element('Dane.DataBrowser/browser');

echo $this->Element('dataobject/pageEnd');