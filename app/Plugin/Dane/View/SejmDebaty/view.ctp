<?
echo $this->Combinator->add_libs('css', $this->Less->css('view-sejmposiedzeniapunkty', array('plugin' => 'Dane')));
echo $this->Combinator->add_libs('css', $this->Less->css('view-sejmdebaty', array('plugin' => 'Dane')));

echo $this->Element('dataobject/pageBegin');
?>
    <div class="debata-wystapienia">
        <?
        echo $this->Element('Dane.DataBrowser/browser');
        ?>
    </div>
<?
echo $this->Element('dataobject/pageEnd');