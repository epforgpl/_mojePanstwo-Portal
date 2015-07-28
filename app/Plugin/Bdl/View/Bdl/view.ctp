<div class="objectsPage" itemtype="http://schema.org/Intangible" itemscope="">
    <div class="objectsPageWindow">
        <?
        $this->Combinator->add_libs('js', 'Bdl.bdlapp');
        echo $this->Element('Bdl.leftsideaccordion', array('tree' => $tree));
        ?>
    </div>
</div>