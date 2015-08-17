<?php $this->Combinator->add_libs('css', $this->Less->css('DataBrowser', array('plugin' => 'Dane'))); ?>

<? echo $this->Element('dataobject/pageBegin'); ?>

    <div class="objectsPage">
        <?
        $options = array();
        if (isset($title))
            $options['title'] = $title;

        echo $this->Element('Dane.DataBrowser/browser-from-object', $options);
        ?>
    </div>

<?= $this->Element('dataobject/pageEnd'); ?>